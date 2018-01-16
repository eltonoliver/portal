<?php $this->load->view('layout/header'); ?>
<script>
    function showElement() {
        document.getElementById("hiddenEl").style.display = "block";
    }
    function hideElement() {
        document.getElementById("hiddenEl").style.display = "none";
    }
    document.getElementById("elemento").addEventListener("mouseover", showElement, false);
    document.getElementById("elemento").addEventListener("mouseout", hideElement, false);
</script> 
<script type="text/javascript" src="<?=SCL_JS?>tinymce_pt/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?=SCL_JS?>tinymce_pt/jscripts/tiny_mce/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script type="text/javascript">
tinyMCE.init({
    language : "pt",
    mode : "textareas",
    theme : "advanced",
    plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

    // Theme options
    theme_advanced_buttons1 : "code,bold,italic,underline,strikethrough,\n\
                               |,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,\n\
                               |cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,forecolor,backcolor",
    //theme_advanced_buttons2 : ",undo,redo,|,link,unlink,image,code,|,preview,|",
    theme_advanced_buttons2 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
    theme_advanced_buttons3 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,pagebreak,image",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,

    // Example content CSS (should be your site CSS)
     content_css : "css/content.css",

    // Drop lists for link/image/media/template dialogs
    template_external_list_url : "lists/template_list.js",
    external_link_list_url : "lists/link_list.js",
    external_image_list_url : "lists/image_list.js",
    media_external_list_url : "lists/media_list.js",
    file_browser_callback : "tinyBrowser",
    // Replace values for the template plugin
    template_replace_values : {
            username : "Some User",
            staffid : "991234"
    }
});
</script>
        
<div id="content">
    <div class="row">
        <div class="col-xs-12"><?=validation_errors();?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Cadastrar Novo Slide</h3>
                    <div class="panel-toolbar">
                        <div class="btn-group">
                            <button onclick="history.go(-1)" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" type="button">Voltar</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="space-12"></div>
                    <form id="cadastrar" name="cadastrar" class="form-bordered" method="post" action="<?=SCL_RAIZ?>professor/slide/cadastrar_aula/<?=$this->uri->segment(3)?>">
                            <input type="hidden" value="1" name="acao"/>
                            <div class="form-group">
                                <label for="example-nf-email">Conteudo</label>
                                <select id="curso" name="conteudo" class="form-control" size="1">
                                    <option value="">Selecione o Conteúdo</option>
                                    <?php foreach ($conteudo as $c) { ?>
                                    <option value="<?=$c['CD_CONTEUDO']?>">  <?=$c['TITULO']?> - <?=$c['NM_DISCIPLINA']?> - <?=$c['NM_CURSO']?> - <?=$c['NM_SERIE']?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="example-nf-email">Titulo do Slide</label>
                                <input type="text"  class="form-control" name="titulo" id="titulo">
                            </div>
                            <div class="form-group">
                                <label for="example-nf-password">Conteúdo</label>
                                <textarea id="texto" name="texto" cols="200" rows="10"><p></p></textarea>
                            </div>

                            <div class="form-group form-actions">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-user"></i> Cadastrar</button>
                                <button class="btn btn-warning" type="reset" onclick="hideElement()"><i class="fa fa-repeat"></i> Cancelar</button></div>
                        </form>
                    
                </div>
          
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('layout/footer'); ?>
