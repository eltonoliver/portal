<?php $this->load->view('layout/header'); ?>

<script type="text/javascript" src="<?= SCL_JS ?>editor/tinymce/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?= SCL_JS ?>editor/tinymce/js/tinymce/langs/pt_BR.js"></script>

<link href="<?= SCL_CSS ?>bootstrap-select.minss.css" rel="stylesheet" type="text/css">
<script src="<?= SCL_JS ?>scriptss.js"></script>   

<script src="<?= SCL_JS ?>jquery-validation/lib/jquery.js"></script>
<script src="<?= SCL_JS ?>jquery-validation/dist/jquery.validate.js"></script>


<script type="text/javascript">
tinymce.init({
    file_browser_callback : elFinderBrowser,
    selector: "textarea",
    theme: "modern",
    content_css:"<?=SCL_JS?>editor/tinymce/js/tinymce/tinymce_style.css",
    convert_urls: false,
    force_br_newlines : false,
    force_p_newlines : false,
    forced_root_block : '',
    fontsize_formats: "6pt 8pt 10pt 12pt 14pt 18pt 24pt 36pt",
//    entity_encoding : "raw",
//    fullpage_default_encoding: "UTF-8",
//    width : 300,
//    forced_root_block_attrs: {
//         "font_formats": "Arial Narrow"
//    },
    fullpage_default_font_family:"Arial Narrow",
    font_formats: "Arial Narrow=arial narrow;",
    plugins: [
        "advlist autolink lists image charmap preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar1: " insertfile undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image ",
    toolbar2: "fontselect | styleselect | fontsizeselect | forecolor backcolor emoticons fullscreen | preview",
    image_advtab: true,
    theme_advanced_resizing : true,
    templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
    ]
});



function elFinderBrowser (field_name, url, type, win) {
  tinymce.activeEditor.windowManager.open({
    file: '<?=SCL_JS?>editor/elfinder/elfinder.html',// use an absolute path!
    //file: 'http://www.seculomanaus.com.br/portal/assets/js/editor/elfinder/elfinder.html',// use an absolute path!
    title: 'Upload de Arquivos',
    width: 900,  
    height: 450,
    resizable: 'yes'
  }, {
    setUrl: function (url) {
      win.document.getElementById(field_name).value = url;
    }
  });
  return false;
}
</script>

<script>
    $().ready(function () {
        // validate the comment form when it is submitted
        $("#form_disciplina").validate({
            messages: {
                disc: {required: 'Informe a disciplina'},
                tipo: {required: 'Informe o tipo'},
                txtimg1:{required: 'Selecione o tipo de Opcão'},
                txtimg2:{required: 'Selecione o tipo de Opcão'},
                txtimg3:{required: 'Selecione o tipo de Opcão'},
                txtimg4:{required: 'Selecione o tipo de Opcão'},
                txtimg5:{required: 'Selecione o tipo de Opcão'},
                pergunta:{required: 'Descreva a pergunta'}
                //gabarito:{required: 'Informe a resposta'}
            }
        });
    });
    


</script>



<style>
    #form_disciplina label.error {
        color: #F00;    
    }

    textarea{
    -webkit-column-width: 10px; /* Chrome, Safari, Opera */
    -moz-column-width: 10px; /* Firefox */
    column-width: 10px;
}
</style>
<script>
    function showhidediv(rad) {
        var rads = document.getElementsByName(rad.name);
        document.getElementById('one').style.display = (rads[0].checked) ? 'block' : 'none';
        document.getElementById('two').style.display = (rads[1].checked) ? 'block' : 'none';
    }   
</script>
    
<div id="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-<?= $bt_cor ?>">
                
                <div class="panel-heading">
                    <h4><?= $subtitulo ?> - Total de Questões: <?=$total?></h4>
                    <a href="<?=SCL_RAIZ?>provas/visualizar/prova?id=<?=base64_encode($prova)?>" target="_blank" class="btn btn-default right" href="#"><i class="fa fa-book"></i> Visualizar Prova</a>
                </div>
                
                <div class="panel-body">
                    <?php
                    echo get_msg('msgok');
                    echo get_msg('msgerro');
                    
                    if($total == 24){
                        echo "<h1>A Prova já contém todas as questões</h1>";
                        echo '<a href="'.SCL_RAIZ.'provas/questoes/" class="btn btn-danger">Voltar</a>';
                    }else{
                    ?>
                    
                    <form class="form-horizontal" id="form_disciplina" name="form_disciplina" method="post" enctype='multipart/form-data' action="<?= SCL_RAIZ ?>provas/questoes/registrar_questao" >                       
                        <input type="hidden" name="prova" value="<?=$prova?>" >
                        <input type="hidden" name="curso" value="<?=$curso?>" >
                        <input type="hidden" name="serie" value="<?=$serie?>" >
                        <input type="hidden" name="disc" value="<?=$disciplina?>" >
<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="disc">Curso</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="curso" id="curso" required >
                                    <option value="" class="text-muted">Selecione a disciplina</option>
                                    <?php
                                    foreach ($curso as $item) { ?>
                                        <option value="<?= $item['CD_CURSO'] ?>">
                                            <?= $item['NM_CURSO'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>-->
                        
<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="disc">Série</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="serie" id="serie" required >
                                    <option value="" class="text-muted">Selecione uma Série</option>
                                </select>
                            </div>
                        </div>-->
                        
<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="disc">Disciplina</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="disc" id="disc" required >
                                    <option value="" class="text-muted">Selecione a Disciplina</option>
                                    <?php foreach($disciplina as $r){ ?>
                                       <option value="<?=$r->CD_DISCIPLINA?>"><?=$r->NM_DISCIPLINA?></option>';	
                                    <?php } ?>
                                </select>
                            </div>
                        </div>-->
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tipo</label>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="px" value="O" onclick="showhidediv(this);" name="tipo" id="tipo" required>
                                        <span class="lbl">Questão Objetiva</span>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="px" value="D" onclick="showhidediv(this);" name="tipo" id="tipo">
                                        <span class="lbl">Questão Dissertativa</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="pergunta">Pergunta</label>
                            <div class="col-sm-9">
                                <textarea id="pergunta" cols="10" name="pergunta"  rows="6"  required></textarea>
                            </div>
                        </div>
                        
<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="disc">Temas</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="grupo" id="grupo" required >
                                    <option value="" class="text-muted">Selecione um Tema</option>
                                    <?php
                                    foreach ($grupo as $g) { ?>
                                        <option value="<?= $g['CD_GRUPO'] ?>">
                                            <?= $g['DC_GRUPO'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>-->
                        
<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="disc">Assunto</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="assunto[]" id="assunto" required multiple="">
                                    
                                </select>
                            </div>
                        </div>-->
                        
<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="disc">Assunto</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="assunto[]" id="assunto" required multiple="">
                                    <?php
                                    foreach ($subgrupo as $d) {
                                        ?>
                                        <option value="<?= $d->CD_SUBGRUPO ?>"><?= $d->DC_SUBGRUPO ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>-->
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="disc">Dificuldade</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="dificuldade" id="dificuldade" required>
                                    <option value="" class="text-muted">Selecione a dificuldade da questão</option>
                                    <option value="1" class="text-muted">Fácil</option>
                                    <option value="2" class="text-muted" selected="selected">Médio</option>
                                    <option value="3" class="text-muted">Difícil</option>
                                </select>
                            </div>
                        </div>
                        
                        <div id="two" class="CF" style="display:none;"  >
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="posicao">Posição</label>
                                <div class="col-sm-9">
                                    <?php
                                    $pos = $this->prova->valida_posicao_questao($prova,'D')->result();
                                    ?>
                                    <select class="form-control input-sm" name="posicao1" id="posicao1" required>
                                        <option value="" class="text-muted">Posição da Questão</option>
                                        <?php
                                        $posi = array();
                                         foreach ($pos as $p){
                                                $posi[] = $p->POSICAO;           
                                        }
                                        foreach (range(21, 24) as $posD){
                                            if (!in_array($posD, $posi)) { 
                                                echo '<option value="'.$posD.'" class="text-muted">Posição: '.$posD.'</option>';
                                            }
                                        }
                                            
                                        ?>
                                    </select>

                                </div>
                            </div>
                            
<!--                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="gabarito">Gabarito</label>
                                <div class="col-sm-9">
                                    <input type="text" id="gabarito" name="gabarito" class="form-control" placeholder="Informe a Resposta da questão">
                                </div>
                            </div>-->
                        </div>
                        
                        
                        <div id="one" class="CF" style="display:none;"  >
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="posicao">Posição</label>
                                <div class="col-sm-9">
                                    <?php
                                    $posq = $this->prova->valida_posicao_questao($prova,'O')->result();
                                    ?>
                                    <select class="form-control input-sm" name="posicao" id="posicao" required>
                                        <option value="" class="text-muted">Posição da Questão</option>
                                        <?php
                                        $posa = array();
                                         foreach ($posq as $p){
                                                $posa[] = $p->POSICAO;           
                                        }
                                        foreach (range(1, 20) as $posO){
                                            if (!in_array($posO, $posa)) { 
                                                echo '<option value="'.$posO.'" class="text-muted">Posição: '.$posO.'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="form-group" style="display:none">
                                <label class="col-sm-3 control-label" for="linha">Resposta</label>
                                <div class="col-sm-9">
                                    <select class="form-control input-sm" name="gabarito" id="gabarito" required>
                                        <option value="" class="text-muted">Selecione a resposta</option>
                                        <option value="A" class="text-muted">Opção A</option>
                                        <option value="B" class="text-muted">Opção B</option>
                                        <option value="C" class="text-muted">Opção C</option>
                                        <option value="D" class="text-muted">Opção D</option>
                                        <option value="E" class="text-muted">Opção E</option>
                                    </select>
                                </div>
                            </div>
                        </div> 
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <input type="submit" value="Cadastrar" name="confirmar" class="btn btn-primary">
                                <a href="<?= SCL_RAIZ ?>provas/questoes/" class="btn btn-danger">Cancelar</a>
                            </div>
                        </div>
                    </form>
                    
                    <?php } ?>
                    
                </div>
                    
            </div>                    
        </div>
    </div>
</div>




<script>
    $(document).ready(function() {
        $("select[name=curso]").change(function() {
            $("select[id=serie]").html('Aguardando série');
            $.post("<?= SCL_RAIZ ?>colegio/colegio/curso_serie", {
                curso: $(this).val()},
            function(valor) {
                $("select[id=serie]").html(valor);
            });
        });
        
        $("select[name=prova]").change(function() {
            $("select[id=disc]").html('Aguardando disciplina');
            $.post("<?= SCL_RAIZ ?>provas/questoes/disciplina", {
                prova: $(this).val()},
            function(valor) {
                $("select[id=disc]").html(valor);
            });
        });
        
        $("select[name=grupo]").change(function() { 
            $("select[id=assunto]").html('Aguardando disciplina');
            $.post("<?= SCL_RAIZ ?>provas/questoes/lista_subgrupo", {
                grupo: $(this).val()},
            function(valor) {
                $("select[id=assunto]").html(valor);
            });
        });
    });
</script>    

<?php $this->load->view('layout/footer'); ?>