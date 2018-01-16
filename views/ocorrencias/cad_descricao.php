<?php $this->load->view('layout/header'); ?>

<script type="text/javascript" src="<?= SCL_JS ?>tinymce_pt/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= SCL_JS ?>tinymce_pt/jscripts/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script type="text/javascript">
    tinyMCE.init({
        // General options
        language: "pt",
        mode: "textareas",
        theme: "advanced",
        // Theme options
        theme_advanced_buttons1:
                "code,bold,italic,underline,strikethrough,|,bullist,numlist,|justifyleft,justifycenter,justifyright,justifyfull,|,fontselect,fontsizeselect,forecolor,backcolor",
        //botoes: image,table,formatselect
        // Theme options
        theme_advanced_buttons2: "",
        theme_advanced_buttons3: "",
        theme_advanced_buttons4: "",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "center",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: true,
        // Example content CSS (should be your site CSS)
        content_css: "css/content.css",
        // Drop lists for link/image/media/template dialogs
        template_external_list_url: "lists/template_list.js",
        external_link_list_url: "lists/link_list.js",
        external_image_list_url: "lists/image_list.js",
        media_external_list_url: "lists/media_list.js",
        file_browser_callback: "tinyBrowser",
        // Replace values for the template plugin
        template_replace_values: {
            username: "descricao",
            staffid: "991234"
        }
    });
</script>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.5.1.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        //var input = '<label id="del"><label class="control-label"><strong>Nome Parcitipante</strong></label><div class="controls row"><div class="input-group col-sm-8"><input class="form-control" type="text" name="participante[]" style="text-transform: uppercase;" /> <span class="input-group-addon"><a style="cursor:pointer;" class="remove"><i class="fa fa-trash-o"></i></a></div></div></label>'; 
        var input = '<label id="del">';
            input += '<div class="form-group"><div class="col-md-12"><div class="form-group row">';
            input +='<label class="col-md-1 control-label"><strong>Parentenco</strong></label><div class="col-md-4"><div class="input-group col-sm-8">';
            input +='<select class="form-control" name="parentesco[]">';
            <?php foreach ($parentesco as $p){ ?>
            input += '<option value="<?=$p['CD_PARENTESCO']?>"><?=$p['DC_PARENTESCO']?></option>';
            <?php } ?>
            input +='</select></div></div>';
            input +='<label for="inputValue" class="col-md-1 control-label" style="margin-left: -100px">Participante</label><div class="col-md-6"><div class="input-group col-sm-12"> <input type="text" class="form-control" name="participante[]" style="text-transform: uppercase;"/><span class="input-group-addon"><a style="cursor:pointer;" class="remove"><i class="fa fa-trash-o"></i></a></span></div></div>'
            input += '</div></div></div>';
            input += '</label>';
            
        $("a[name='add']").click(function (e) {
            $('#inputs_adicionais').append(input);
        });

        $('#inputs_adicionais').delegate('a', 'click', function (e) {
            e.preventDefault();
            //$( this ).parent('label').remove();
            $('#del').remove();
        });

    });
</script>

<style type="text/css">
    fieldset { border: none; margin-left: -50px }
    label { display: block; }
    .remove { color:black;font-weight:bold;text-decoration:none; }
</style>

<script>
    function excluir_ocorrencia(id) {
        var url = "<?= base_url() ?>ocorrencias/psicologico/deletar_ocorrencia?id=" + id;
        window.location.href = url;
    }
</script>

<form name="frmDescricao" method="post" enctype='multipart/form-data' action="<?= base_url() ?>ocorrencias/psicologico/conf_descricao">
    <div id="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h1><i class="icon-plus"></i> Descrição da Consulta</h1>
                    </div>  

                    <input type="hidden" name="cd_ocorrencia" value="<?= $aluno[0]['CD_OCORRENCIA'] ?>" />

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <label>Data Consulta: </label> <?= formata_data($aluno[0]['DATA'], 'br') ?>
                            </div>
                            <div class="col-xs-4">
                                <label>Matricula: </label> <?= $aluno[0]['CD_ALUNO'] ?>
                            </div>
                            <div class="col-xs-4">
                                <label>Nome: </label> <?= $aluno[0]['NM_ALUNO'] ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <hr>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-md-1 control-label"><strong>Parentenco</strong></label>
                                            <div class="col-md-4">
                                                <div class="input-group col-sm-8"> 
                                                    <select class="form-control" name="parentesco[]">
                                                        <?php foreach ($parentesco as $p){ ?>
                                                        <option value="<?=$p['CD_PARENTESCO']?>"><?=$p['DC_PARENTESCO']?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <label for="inputValue" class="col-md-1 control-label" style="margin-left: -100px">Participante</label>
                                            <div class="col-md-6">
                                                <div class="input-group col-sm-12"> 
                                                    <input type="text" class="form-control" name="participante[]" style="text-transform: uppercase;"/>
                                                    <span class="input-group-addon">
                                                        <a name="add" style="cursor: pointer">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>







                                <div class="form-group" style="margin-left: 50px">
                                    <fieldset id="inputs_adicionais"></fieldset>
                                </div>
                            </div>

                        </div>
                        <div class="clearfix"><hr></div>
                        <div class="row">
                            <div class="col-xs-12"><label>Assunto</label></div>
                            <div class="col-xs-12">
                                <input text="text" name="assunto" class="form-control" />
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-12"><label>Descrição</label></div>
                            <div class="col-xs-12">
                                <textarea class="form-control textarea" rows="20" name="conteudo" ></textarea>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-4">        
                                <label class="control-label">Tipo do Arquivo</label>
                                <div class="input-append"  style="margin-top:-5px">
                                    <select class="form-control" name="tipo_arquivo[]">
                                        <?php foreach ($tipo_arquivo as $t) { ?>
                                            <option value="<?= $t['CD_OCORRENCIAS_TIPO_ARQUIVO'] ?>"><?= $t['DESCRICAO'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div> 
                            </div>

                            <div class="col-xs-8">        
                                <label class="control-label">Arquivo</label>
                                <div class="input-append"  style="margin-top:-35px">
                                    <input type="file" name="arquivo1" style="visibility:hidden;" id="pdffile" />
                                    <input type="text" id="subfile" class="input-small" style="width:400px">
                                    <a class="btn btn-default" onclick="$('#pdffile').click();">Procurar</a>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">        
                                <label class="control-label">Tipo do Arquivo</label>

                                <div class="input-append"  style="margin-top:-5px">
                                    <select class="form-control" name="tipo_arquivo[]">
                                        <?php foreach ($tipo_arquivo as $t) { ?>
                                            <option value="<?= $t['CD_OCORRENCIAS_TIPO_ARQUIVO'] ?>"><?= $t['DESCRICAO'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div> 
                            </div>

                            <div class="col-xs-8">        
                                <label class="control-label">Arquivo</label>
                                <div class="input-append"  style="margin-top:-35px">
                                    <input type="file" name="arquivo2" style="visibility:hidden;" id="pdffile1" />
                                    <input type="text" id="subfile1" class="input-small" style="width:400px">
                                    <a class="btn btn-default" onclick="$('#pdffile1').click();">Procurar</a>
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">        
                                <label class="control-label">Tipo do Arquivo</label>
                                <div class="input-append"  style="margin-top:-5px">
                                    <select class="form-control" name="tipo_arquivo[]">
                                        <?php foreach ($tipo_arquivo as $t) { ?>
                                            <option value="<?= $t['CD_OCORRENCIAS_TIPO_ARQUIVO'] ?>"><?= $t['DESCRICAO'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div> 
                            </div>

                            <div class="col-xs-8">        
                                <label class="control-label">Arquivo</label>
                                <div class="input-append"  style="margin-top:-35px">
                                    <input type="file" name="arquivo3" style="visibility:hidden;" id="pdffile2" />
                                    <input type="text" id="subfile2" class="input-small" style="width:400px">
                                    <a class="btn btn-default" onclick="$('#pdffile2').click();">Procurar</a>
                                </div> 
                            </div>
                        </div>

                    </div>

                    <div class="panel-footer">
                        <a href="#modal" role="button" class="btn btn-warning" data-toggle="modal"><i class="fa fa-rotate-left"></i> Cancelar</a>
                        <button type="submit" value="Submit" class="btn btn-success" id="frmarquivo_btn" ><i class="fa fa-plus"></i> Confirmar </button>


                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalConfirmLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title thin" id="modalConfirmLabel">Cancelar Consulta</h3>
            </div>
            <div class="modal-body">
                <form role="form">
                    <h4>Tem certeza que deseja cancelar o Atendimento?</h4>
                    <h4>Esta operação não terá mas retorno</h4>
                    <h3><?= $aluno[0]['CD_ALUNO'] ?> - <?= $aluno[0]['NM_ALUNO'] ?></h3>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                <button class="btn btn-success" onclick="excluir_ocorrencia(<?= $aluno[0]['CD_OCORRENCIA'] ?>)">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $('#pdffile').change(function () {
            $('#subfile').val($(this).val());
        });
        $('#showHidden').click(function () {
            $('#pdffile').css('visibilty', 'visible');
        });

        $('#pdffile1').change(function () {
            $('#subfile1').val($(this).val());
        });
        $('#showHidden').click(function () {
            $('#pdffile2').css('visibilty', 'visible');
        });

        $('#pdffile2').change(function () {
            $('#subfile2').val($(this).val());
        });
        $('#showHidden').click(function () {
            $('#pdffile2').css('visibilty', 'visible');
        });
    });
</script>
<?php $this->load->view('layout/footer'); ?>            
