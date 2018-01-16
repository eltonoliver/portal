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
  //  content_css:"<?=SCL_JS?>editor/tinymce/js/tinymce/tinymce_style.css",
    convert_urls: true,
    force_br_newlines : false,
    force_p_newlines : false,
    forced_root_block : '',
    fontsize_formats: "6pt 8pt 10pt 12pt 14pt 18pt 24pt 36pt",
//    entity_encoding : "raw",
//    fullpage_default_encoding: "UTF-8",
    //width : 300,
//    forced_root_block_attrs: {
//         "font_formats": "Arial Narrow"
//    },
    fullpage_default_font_family:"Arial Narrow",
    font_formats: "Arial Narrow=arial narrow,helvetica,sans-serif;",
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
                pergunta:{required: 'Descreva a pergunta'},
            //    gabarito:{required: 'Informe a resposta'}
            }
        });
    });
</script>

<style>
    #form_disciplina label.error {
        color: #F00;    
    }

</style>

<script>
    function showhidediv(rad) {
        var rads = document.getElementsByName(rad.name);
        document.getElementById('one').style.display = (rads[0].checked) ? 'block' : 'none';
        document.getElementById('two').style.display = (rads[1].checked) ? 'block' : 'none';
    }

    function showOP1(id) {
        if (id === 'T') {
            $("#input1").html('<input type="text" id="op1" name="op[]" class="form-control" required  placeholder="Opção A - Campo Obrigatório"><input type="radio" value="0" name="correta">Correta?');
        } else {
            $("#input1").html('<input type="file" id="op[]" name="op1" class="form-control" required><input type="hidden" name="op[]" /><input type="radio" value="0" name="correta">Correta?');
        }
    }

    function showOP2(id) {
        if (id === 'T') {
            $("#input2").html('<input type="text" id="opB" name="op[]" class="form-control" required  placeholder="Opção B - Campo Obrigatório"><input type="radio" value="1" name="correta">Correta?');
        } else {
            $("#input2").html('<input type="file" id="op[]" name="op2" class="form-control" required><input type="hidden" name="op[]" /><input type="radio" value="1" name="correta">Correta?');
        }
    }

    function showOP3(id) {
        if (id === 'T') {
            $("#input3").html('<input type="text" id="opC" name="op[]" class="form-control" required  placeholder="Opção C - Campo Obrigatório"><input type="radio" value="2" name="correta">Correta?');
        } else {
            $("#input3").html('<input type="file" id="op[]" name="op3" class="form-control" required><input type="hidden" name="op[]" /><input type="radio" value="2" name="correta">Correta?');
        }
    }

    function showOP4(id) {
        if (id === 'T') {
            $("#input4").html('<input type="text" id="opD" name="op[]" class="form-control" required  placeholder="Opção D - Campo Obrigatório"><input type="radio" value="3" name="correta">Correta?');
        } else {
            $("#input4").html('<input type="file" id="op[]" name="op4" class="form-control" required><input type="hidden" name="op[]" /><input type="radio" value="3" name="correta">Correta?');
        }
    }

    function showOP5(id) {
        if (id === 'T') {
            $("#input5").html('<input type="text" id="opE" name="op[]" class="form-control" required  placeholder="Opção E - Campo Obrigatório"><input type="radio" value="4" name="correta">Correta?');
        } else {
            $("#input5").html('<input type="file" id="op[]" name="op5" class="form-control" required><input type="hidden" name="op[]" /><input type="radio" value="4" name="correta">Correta?');
        }
    }
</script>

<script>
    function validar(){
        var disc = form_disciplina.disc.value;
        var assunto = form_disciplina.assunto.value;
        var dificuldade = form_disciplina.dificuldade.value;
        var tipo = form_disciplina.tipo.value;
        
        if (disc == "") {
            alert('Selcione uma disciplina');
            return false;
        }
        if (assunto == "") {
            alert('Selcione um ou mas assunto');
            return false;
        }
        if (dificuldade == "") {
            alert('Informe a dificuldade da questão');
            return false;
        }
        if (tipo == "") {
            alert('Informe o tipo da questão');
            return false;
        }
        
        
    }
</script>  

<script type="text/javascript">
/* Máscaras ER */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mvalor(v){
    v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
    v=v.replace(/(\d)(\d{1})$/,"$1.$2");//coloca a virgula antes dos 2 últimos dígitos
    return v;
}

</script>
<div id="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-<?= $bt_cor ?>">
                
                <div class="panel-heading">
                    <h4><?= $subtitulo ?></h4>
                </div>
                
                <div class="panel-body">
                    <?php
                   // print_r($dados);
                    echo get_msg('msgok');
                    echo get_msg('msgerro');
                    ?>
                    
                    <form class="form-horizontal" id="form_disciplina" name="form_disciplina" method="post" action="<?= SCL_RAIZ ?>provas/questoes/registrar_edicao" enctype='multipart/form-data' >
                        <input type="hidden" name="onde" value="<?=$_GET['token']?>">
                        <input type="hidden" name="cd_prova" value="<?=$dados[0]->CD_PROVA?>">
                        <input type="hidden" name="cd_questao" value="<?=$this->input->get('id')?>">                        
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="disc">Curso</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="curso" id="curso" required >
                                    <option value="" class="text-muted">Selecione a disciplina</option>
                                    <?php
                                    foreach ($curso as $item) { ?>
                                        <option value="<?= $item['CD_CURSO'] ?>" <?php if($dados[0]->CD_CURSO ==  $item['CD_CURSO'] ) echo "selected";?>>
                                            <?= $item['NM_CURSO'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="disc">Série</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="serie" id="serie" required >
                                    <option value="" class="text-muted">Selecione uma Série</option>
                                    <?php
                                    foreach ($serie as $item) { ?>
                                        <option value="<?= $item['ORDEM_SERIE'] ?>" <?php if($dados[0]->ORDEM_SERIE ==  $item['ORDEM_SERIE'] ) echo "selected";?>>
                                            <?= $item['NM_SERIE'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="disc">Disciplina</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="disc" id="disc" required >
                                    <option value="" class="text-muted">Selecione a Disciplina</option>
                                    <?php foreach($disciplina as $r){ ?>
                                       <option value="<?=$r->CD_DISCIPLINA?>" <?php if($dados[0]->CD_DISCIPLINA ==  $r->CD_DISCIPLINA ) echo "selected";?>>
                                            <?=$r->NM_DISCIPLINA?>
                                       </option>';	
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
<!--                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="disc">Assunto</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="assunto[]" id="assunto" required multiple="">
                                    <?php
                                    foreach ($subgrupo as $d) {
                                        ?>
                                        <option value="<?= $d->CD_SUBGRUPO ?>" <?php if($dados[0]->CD_SUBGRUPO ==  $d->CD_SUBGRUPO  ) echo "selected";?>><?= $d->DC_SUBGRUPO ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>-->
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="disc">Dificuldade</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="dificuldade" id="dificuldade" required>
                                    <option value="" class="text-muted">Selecione a dificuldade da questão</option>
                                    <option value="1" class="text-muted" <?php if($dados[0]->NR_DIFICULDADE == '1') echo "selected";?>>Fácil</option>
                                    <option value="2" class="text-muted" <?php if($dados[0]->NR_DIFICULDADE == '2') echo "selected";?>>Médio</option>
                                    <option value="3" class="text-muted" <?php if($dados[0]->NR_DIFICULDADE == '3') echo "selected";?>>Difícil</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tipo</label>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="px" value="O" onload="showhidediv(this);" onclick="showhidediv(this);" name="tipo" id="tipo" required <?php if($dados[0]->FLG_TIPO == 'O') echo "checked";?>>
                                        <span class="lbl">Questão Objetiva</span>
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" class="px" value="D" onload="showhidediv(this);" onclick="showhidediv(this);" name="tipo" id="tipo" <?php if($dados[0]->FLG_TIPO == 'D') echo "checked";?>>
                                        <span class="lbl">Questão Dissertativa</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="pergunta">Pergunta</label>
                            <div class="col-sm-9">
                                <textarea readonly="" id="pergunta" cols="100" name="pergunta"  rows="4" aria-required="true" oncontextmenu="return false" onkeydown="return false" required <?php if($dados[0]->FLG_TIPO == 'D') echo "checked";?>>
                                    <?=$dados[0]->DC_QUESTAO?>
                                </textarea>
                            </div>
                        </div>
                      
<!--                        <div id="two" class="CF" <?php if($dados[0]->FLG_TIPO == 'D') echo 'style="display:block;"'; else echo 'style="display:none;"' ?>  >
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="gabarito">Gabarito</label>
                                <div class="col-sm-9">
                                    <input type="text" id="gabarito" name="gabarito" class="form-control" placeholder="Informe a Resposta da questão">
                                </div>
                            </div>
                        </div>-->
                        
                        <div class="form-group">
                                <label class="col-sm-3 control-label" for="posicao">Posição</label>
                                <div class="col-sm-9">
                                    <select class="form-control input-sm" name="posicao" id="posicao" required>
                                        <option value="" class="text-muted">Posição da Questão</option>
                                        <?php
                                            foreach (range(1, 24) as $posD){
                                                if($posD == $dados[0]->POSICAO){
                                                    $select = "selected='selected'";
                                                }else{
                                                    $select = "";
                                                }
                                                echo '<option value="'.$posD.'" '.$select.' class="text-muted">Posição: '.$posD.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

<!--                        <div id="one" class="CF" <?php if($dados[0]->FLG_TIPO == 'O') echo 'style="display:block;"'; else echo 'style="display:none;"' ?>  >
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="linha">Resposta</label>
                                <div class="col-sm-9">
                                    <select class="form-control input-sm" name="gabarito" id="gabarito" required>
                                        <option value="" class="text-muted">Selecione a resposta</option>
                                        <option value="A" class="text-muted" <?php if($dados[0]->FLG_RESPOSTA_CORRETA == 'A') echo "selected";?>>Opção A</option>
                                        <option value="B" class="text-muted" <?php if($dados[0]->FLG_RESPOSTA_CORRETA == 'B') echo "selected";?>>Opção B</option>
                                        <option value="C" class="text-muted" <?php if($dados[0]->FLG_RESPOSTA_CORRETA == 'C') echo "selected";?>>Opção C</option>
                                        <option value="D" class="text-muted" <?php if($dados[0]->FLG_RESPOSTA_CORRETA == 'D') echo "selected";?>>Opção D</option>
                                        <option value="E" class="text-muted" <?php if($dados[0]->FLG_RESPOSTA_CORRETA == 'E') echo "selected";?>>Opção E</option>
                                    </select>
                                </div>
                            </div>
                        </div>-->
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <input type="submit" value="Editar"  class="btn btn-warning">
                                <a href="<?= SCL_RAIZ ?>provas/questoes/" class="btn btn-danger">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
                    
            </div>                    
        </div>
    </div>
</div>





<script>
    init.push(function () {

        $("#form_disciplina").validate({
            rules: {
                'disc': {required: true},
                'tipo': {required: true},
                'pergunta': {required: true},
                'opA': {required: true},
                'opB': {required: true},
                'opC': {required: true},
                'opD': {required: true},
                'opE': {required: true},
                'opG': {required: true}
            },
            messages: {
                disc: {required: 'Informe a disciplina da questão'},
                tipo: {required: 'Informe o tipo da questão'},
                pergunta: {required: 'Descreva a questão'},
                opA: {required: 'Informe a opção A'},
                opB: {required: 'Informe a opção B'},
                opC: {required: 'Informe a opção C'},
                opD: {required: 'Informe a opção D'},
                opE: {required: 'Informe a opção E'},
                opG: {required: 'Informe o Gabarito da questão'}
            },
        });
    });
    window.PixelAdmin.start(init);
</script>


<script>
    $(document).ready(function() {
        $("select[name=curso]").change(function() {
            $("select[id=serie]").html('Aguardando série');
            $.post("<?= SCL_RAIZ ?>colegio/colegio/curso_serie", {
                curso: $(this).val()},
            function(valor) {
                $("select[id=serie]").html(valor);
            })
        })
        
        $("select[name=prova]").change(function() {
            $("select[id=disc]").html('Aguardando disciplina');
            $.post("<?= SCL_RAIZ ?>provas/questoes/disciplina", {
                prova: $(this).val()},
            function(valor) {
                $("select[id=disc]").html(valor);
            })
        })
    });
</script>    
<?php $this->load->view('layout/footer'); ?>