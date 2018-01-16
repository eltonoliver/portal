<?php $this->load->view('layout/header'); ?>
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
                "code,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,cleanup,link,unlink,image,table,formatselect,fontselect,fontsizeselect,forecolor,backcolor,fullscreen",
        // Theme options
        theme_advanced_buttons2: "",
        theme_advanced_buttons3: "",
        theme_advanced_buttons4: "",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
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
            username: "Some User",
            staffid: "991234"
        }
    });
</script>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo validation_errors();
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    Cadastrar novo artigo
                </div>
                <div class="panel-body">
                    <form action="<?= SCL_RAIZ ?>jornal/artigos/registar_infor" method="post"  name="formArtigo" id="formArtigo" enctype='multipart/form-data'>
                        <div id="error_message" style="color:red"></div>
                        <input name="acao" type="hidden" id="acao" value="<?= $acao ?>" />
                        <input name="bt_acao" type="hidden" id="bt_acao" value="<?= $bt_acao ?>" />
                        <input name="bt_cor" type="hidden" id="bt_cor" value="<?= $bt_cor ?>" />
                        <input name="codigo" type="hidden" id="codigo" value="<?= $codigo ?>" />

                        <div class="col-xs-12">
                            <div class="col-sm-12">
                                <?php
                                echo br();
                                echo form_label("<strong>CÓDIGO: </strong>");
                                echo br();
                                echo form_input('sclcodigo', '' . $codigo . '', 'class="form-control" readonly="readonly"');
                                echo br();
                                echo form_label("<strong>Autor</strong>");
                                echo br();
                                if ($this->session->userdata('SCL_SSS_USU_TIPO') == 30) {
                                    $op = array('' => 'Selecione o Autor');
                                    foreach ($autores as $a) {
                                        $op[$a->CD_MEMBRO] = $a->NOME;
                                    }
                                    $ex1 = 'class="form-control"';
                                    echo form_dropdown("cd_autor", $op, $cd_membro, $ex1);
                                } else {
                                    echo form_hidden('cd_autor', $autor);
                                    echo form_input('autor', '' . $nm_autor . '', 'class="form-control" readonly="readonly"');
                                }
                                echo br();
                                echo form_label("<strong>CATEGORIA: </strong>");
                                echo br();
                                $opcoes = array('' => 'Informe a Categoria');
                                foreach ($categoria as $c) {
                                    $opcoes[$c->CD_CATEGORIA] = $c->DC_CATEGORIA;
                                }
                                $ex = 'class="form-control"';
                                echo form_dropdown("categoria", $opcoes, $tipo, $ex);
                                echo br();
                                echo form_label("<strong>TITULO: </strong>");
                                echo br();
                                echo form_input('titulo', '' . $titulo_artigo . '', 'class="form-control"');
                                echo br();
                                echo form_label("<strong>SUB-TITULO: </strong>");
                                echo br();
                                echo form_input('subtitulo', '' . $subtitulo_artigo . '', 'class="form-control"');
                                echo br();
                                echo form_label("<strong>CAPA: </strong>");
                                if ($_GET['acao'] == 2)
                                    echo '<div class="text-warning">Não Incluir para manter a capa original</div>';
                                echo br();
                                echo form_upload('arquivo', '', 'class="form-control" id="arquivo"');
                                echo br();
                                echo form_label("<strong>TEXTO: </strong>");
                                echo br();
                                echo form_textarea('texto', '' . $texto . '', 'class="form-control"');
                                ?>
<!--                                        <textarea id="texto" name="texto" cols="50" rows="8"></textarea>-->
                                <?php
                                if ($this->session->userdata('SCL_SSS_USU_TIPO') == 30) {
                                    echo form_checkbox('publicado', 1, TRUE);
                                    echo ' Publicar no Site?';
                                }
                                ?>
                                <br>
                                <br>  


                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="pull-left"><a href="<?= SCL_RAIZ ?>jornal/artigos/" class="btn btn-inverse"><i class="fa fa-backward"></i> Cancelar</a></div>
                            <button type="submit" id="btn_frmMensagem" class="btn btn-<?= $bt_cor ?>"> <?= $bt_acao ?> Registro <i class="fa fa-save"></i></button>
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
</script>
<?php $this->load->view('layout/footer'); ?>