<?php $this->load->view('layout/header'); ?>
<link rel="stylesheet" href="<?= SCL_JS ?>/jquery-validation/demo/css/screen.css">
<script src="<?= SCL_JS ?>/jquery-validation/dist/jquery.validate.js"></script>

<script>
    $().ready(function() {
//    $("#commentForm").validate();
    });
</script>
<script src="<?= SCL_JS ?>script.js"></script>   
<script type="text/javascript" src="<?= SCL_JS ?>date-time/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="<?= SCL_CSS ?>datepicker.css" />
<script type="text/javascript" src="<?= SCL_JS ?>tinymce_pt/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?= SCL_JS ?>tinymce_pt/jscripts/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script type="text/javascript">
    tinyMCE.init({
        // General options
        language: "pt",
        mode: "textareas",
        theme: "advanced",
        plugins: "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        // Theme options
        theme_advanced_buttons1:
                "code,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,cleanup,link,unlink,fontselect,fontsizeselect,forecolor,backcolor,fullscreen",
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
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <form class="form-bordered" enctype="multipart/form-data" method="post" action="<?= SCL_RAIZ ?>site/informacao/cadastrar" id="commentForm">            
                <div class="panel panel-info">
                    <div class="panel-heading">
                        Informações Gerais do Site
                    </div>
                    <div class="panel-body">

                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#home">Apresentação</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#profile" id="teste">Ensino Infantil</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#messages">Ensino Fundamental</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#settings">Ensino Médio</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="home" class="tab-pane active">
                                <div style="margin: 20px 0;" class="well">
                                    <h4>Descreva o texto de Apresentação da Escola</h4>
                                    <p><textarea type="text" class="form-control " name="apresentacao" id="apresentacao"><?=$info[0]['APRESENTACAO']?></textarea></p>
                                </div>
                            </div>
                            
                            <div id="profile" class="tab-pane">
                                <div style="margin: 20px 0;" class="well">
                                    <h4>Descreva o texto informativo do Ensino Infantil</h4>
                                    <p><textarea type="text" class="form-control active" name="ens_infantil" id="ens_infantil"><?=$info[0]['ENS_INFANTIL']?></textarea></p>
                                </div>
                            </div>

                            <div id="messages" class="tab-pane">
                                <div style="margin: 20px 0;" class="well">
                                    <h4>Descreva o texto informativo do Ensino Fundamental</h4>
                                    <p><textarea type="text" class="form-control" name="ens_fundamental" id="ens_fundamental"><?=$info[0]['ENS_FUNDAMENTAL']?></textarea></p>
                                </div>
                            </div>

                            <div id="settings" class="tab-pane">
                                <div style="margin: 20px 0;" class="well">
                                    <h4>Descreva o texto informativo do Ensino Médio</h4>
                                    <p><textarea type="text" class="form-control" name="ens_medio" id="ens_medio"><?=$info[0]['ENS_MEDIO']?></textarea></p>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-save"></i> Cadastrar</button>
                    </div>
                </div>
            </form>    
        </div>
    </div>
</div>
<script>
    $('#data-table').dataTable({
        "sPaginationType": "full_numbers"
    });

    jQuery(function($) {
        $('.date-picker').datepicker(
                {autoclose: true}).next().on(ace.click_event, function() {
            $(this).prev().focus();
        });
    });
</script>
<?php $this->load->view('layout/footer'); ?>