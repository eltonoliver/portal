<?php $this->load->view('layout/header'); ?>
<link rel="stylesheet" href="<?= SCL_JS ?>/jquery-validation/demo/css/screen.css">
<script src="<?= SCL_JS ?>/jquery-validation/dist/jquery.validate.js"></script>

<script>
$().ready(function() {
//    $("#commentForm").validate();
    $("#commentForm").validate({
        rules: {
                dt_evento: "required",
                imagem: "required",
                descricao:"required",
                titulo:"required"
        },
        messages: {
                dt_evento: "Informe a data do evento",
                imagem:"Selecione uma imagem",
                descricao:"Descreva o texto da notícia",
                titulo:"Informe o título da notícia"
        }
    });
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
                "code,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,cleanup,table,|,bullist,numlist,|,link,unlink,fontselect,fontsizeselect,forecolor,backcolor,fullscreen",
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
            <div class="panel panel-warning">
                <div class="panel-heading">
                    Cadastrar novo parceiro
                </div>
                <div class="panel-body">
                    <form class="form-bordered" enctype="multipart/form-data" method="post" action="<?=SCL_RAIZ?>site/parceiros/cadastrar" id="commentForm">

                        <div class="form-group">
                            <label for="autor">Cadastrado por:</label>
                            <input type="text" placeholder="Autor" class="form-control" name="autor" id="autor" disabled="" value="<?= $autor ?>">
                            <input type="hidden" name="autor" value="<?=$this->session->userdata('SCL_SSS_USU_CODIGO')?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" placeholder="Nome" class="form-control" name="nome" id="nome">
                        </div>
                        
                        <div class="form-group">
                            <label for="titulo">Titulo</label>
                            <input type="text" placeholder="Titulo" class="form-control" name="titulo" id="titulo">
                        </div>
                        
                        <div class="form-group">
                            <label for="descricao">Descricao</label>
                            <textarea required="" type="text" class="form-control" name="descricao" id="descricao" aria-required="true"></textarea>
                        </div>                    

                        <div class="form-group">
                            <label for="banner">Banner</label>
                            <input type="file" id="banner" name="banner" required>
                                <span class="file-name">
                                    <i class="icon-upload"></i>
                                </span>
                            </label>
                        </div>
                        
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" id="logo" name="logo" required>
                                <span class="file-name">
                                    <i class="icon-upload"></i>
                                </span>
                            </label>
                        </div>



                        <div class="form-group form-actions">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-save"></i> Cadastrar</button>
                            <a class="btn btn-warning" href="<?= SCL_RAIZ ?>site/parceiros/">
                                <i class="fa fa-repeat"></i> Cancelar
                            </a>
                        </div>


                    </form>

                </div>
            </div>
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