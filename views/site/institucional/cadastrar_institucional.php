<?php $this->load->view('layout/header'); ?>
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
                "iframe,code,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,cleanup,table,|,bullist,numlist,|,link,unlink,fontselect,fontsizeselect,forecolor,backcolor,fullscreen",
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
                    Dados da tela Institucional
                </div>
                <div class="panel-body">
                    <form class="form-bordered" enctype="multipart/form-data" method="post" action="<?=SCL_RAIZ?>site/institucional/confirmar" id="commentForm">
                        <input type="hidden" name="acao" value="1">
                        
                        <div class="form-group">
                            <label for="autor">Cadastrado por:</label>
                            <input type="text" placeholder="Autor" class="form-control" name="autor" id="autor" disabled="" value="<?= $autor ?>">
                            <input type="hidden" name="autor" value="<?= $autor ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="titulo">Titulo</label>
                            <input type="text" placeholder="Titulo" class="form-control" name="titulo" id="titulo">
                        </div>
                        
                        <div class="form-group">
                            <label for="descricao">Descricao</label>
                            <textarea type="text" class="form-control" name="descricao" id="descricao"></textarea>
                        </div>                    

                        <div class="form-group">
                            <label for="banner">Banner</label>
                            <input type="file" id="banner" name="banner">
                                <span class="file-name">
                                    <i class="icon-upload"></i>
                                </span>
                            <label class="text-danger">Só informe o banner caso queira alterar-lo</label>
                        </div>
  


                        <div class="form-group form-actions">
                            <button class="btn btn-primary" type="submit" >
                                <i class="fa fa-save"></i> 
                                Cadastrar
                            </button>
                             <a class="btn btn-warning" href="<?= SCL_RAIZ ?>site/institucional/">
                                <i class="fa fa-repeat"></i> Cancelar
                            </a>
                        </div>


                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('layout/footer'); ?>