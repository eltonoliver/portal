<?php $this->load->view('layout/header'); ?>
<script>
function limite_textarea(valor) {
    quant = 200;
    total = valor.length;
    if(total <= quant) {
        resto = quant - total;
        document.getElementById('cont').innerHTML = resto;
    } else {
        document.getElementById('resumo').value = valor.substr(0,quant);
    }
}   
</script>   


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
                "code,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,cleanup,link,unlink,fontselect,fontsizeselect,forecolor,backcolor,fullscreen,|,image,table",
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
            <div class="panel panel-<?=$bt_cor?>">
                <div class="panel-heading">
                    <h4><?=$subtitulo?></h4>
                </div>

                <div class="panel-body">
                    <form action="<?=SCL_RAIZ?>jornal/news/registrar_info" method="post"  name="formCategoria" id="formCategoria" enctype='multipart/form-data'>
                        <?php
                        if($this->input->get('token')){
                            $acao = $this->input->get('token');
                        }else{
                            $acao = $acao;
                        }
                        ?>
                        <input type="hidden" name="acao" value="<?=$acao?>">
                        <input type="hidden" name="bt_cor" value="<?=$bt_cor?>">
                        <input type="hidden" name="bt_acao" value="<?=$bt_acao?>">
                        <?php
                        //validacao somente para edicao
                        if(base64_decode($this->input->get_post('token'))== 'editar') {?>
                            <input type="hidden" name="capa" value="<?=$dados[0]['IMG_CAPA']?>">
                            <input type="hidden" name="thumb" value="<?=$dados[0]['THUMB']?>">
                        <?php
                        }
                        
                        
                        echo validation_errors();
                        echo get_msg('msgok');
                        echo get_msg('msgerro');
                        ?>
                        <div class="col-xs-12">
                            <label><strong>CÓDIGO: </strong></label>
                            <br>
                            <input class="form-control" type="text" readonly="readonly" value="<?=$dados[0]['CD_NEWS']?>" name="codigo">
                            <br>
                            <label><strong>CATEGORIA - CADERNO </strong></label>
                            <br>
                            <select class="form-control" name="categoria" id="categoria">
                                <option value="">Selecione uma categoria</option>
                                <?php foreach ($lista_categoria as $lc){?>
                                    <option value="<?=$lc->CD_CATEGORIA?>" 
                                <?php if($lc->CD_CATEGORIA == $dados[0]['CD_CATEGORIA']) echo "selected='selected'"; ?> >
                                        CADERNO: <?=$lc->CADERNO?> - CATEGORIA: <?=$lc->DC_CATEGORIA?>
                                    </option>
                                <?php } ?>
                            </select>
                            <br>
                            <label><strong>AUTOR </strong></label>
                            <br>
                            <?php 
                            if ($this->session->userdata('SCL_SSS_USU_TIPO') == 30 or $this->session->userdata('SCL_SSS_USU_TIPO') == 40) { ?>
                            <select class="form-control" name="autor" id="autor">
                                <option value="">Selecione o autor</option>
                                <?php foreach ($autores as $r){?>
                                    <option value="<?=$r->CD_MEMBRO?>" 
                                         <?php if($r->CD_MEMBRO == $dados[0]['CD_AUTOR']) echo "selected='selected'"; ?> >
                                         <?=$r->NOME?>
                                    </option>
                                <?php } ?>
                            </select>
                            <?php }else{ ?>
                            <input class="form-control" type="text" readonly="readonly" value="<?=$nm_autor?>" name="nm_autor">
                            <input class="form-contrl" type="hidden" value="<?=$autor?>" name="autor">
                            <?php }?>
                            <br>
                            <label><strong>DATA DO EVENTO </strong></label>
                            <br>
                            <i class="icon-calendar"></i>
                            <?php
                            if($dados[0]['DT_EVENTO']==null){
                                $data = date('d/m/Y');
                            }else{
                                $data = date('d/m/Y',strtotime($dados[0]['DT_EVENTO']));
                            }
                            ?>
                            <input name="data" type="text" size="20" id="daterange" value="<?=$data?>"/>
                            <br>
                            <label><strong>TITULO </strong></label>
                            <br>
                            <input class="form-control" type="text" value="<?=$dados[0]['TITULO']?>" name="titulo">
                            <br>
                            <label><strong>RESUMO: </strong></label> <small class="text-warning">Uma descrição de no máximo 200 caracteres - <span ID="cont">200</span> restantes</small>
                            <br>
                            <input class="form-control" type="text" value="<?=$dados[0]['RESUMO']?>" name="resumo" id="resumo" onkeyup="limite_textarea(this.value)">
                            <br>
                            <label><strong>CAPA </strong></label> 
                                <?php if(base64_decode($this->input->get_post('token'))== 'editar') 
                                          echo '<small class="text-warning">Não Incluir para manter a capa original</small>'; ?>
                            <br>
                            <input id="capa" class="form-control" type="file" value="" name="capa" multiple >
                            <br>
                            <label><strong>MINIATURA</strong></label>
                                <?php if(base64_decode($this->input->get_post('token'))== 'editar') 
                                          echo '<small class="text-warning">Não Incluir para manter a capa original</small>'; ?>
                            <br>
                            <input id="thumb" class="form-control" type="file" value="" name="thumb">
                            <br>
                            <label><strong>DESCRIÇÃO</strong></label>
                            <br>
                            <textarea class="form-control" rows="10" name="descricao"><?=$dados[0]['DESCRICAO']?></textarea>
                            <br>
                            <?php
                                if ($this->session->userdata('SCL_SSS_USU_TIPO') == 30) {
                                    echo form_checkbox('publicado', 1, TRUE);
                                    echo ' Publicar no Jornal?';
                                }
                                ?>
                        </div>
                        <div class="modal-footer">
                            <div class="pull-left btn">
                                <a href="<?=SCL_RAIZ ?>jornal/news/" class="btn btn-inverse"><i class="fa fa-backward"></i> Cancelar</a>
                            </div>
                            <button type="submit" id="btn_frmMensagem" class="btn btn-<?=$bt_cor?>"> <?=$bt_acao?> Registro <i class="fa fa-save"></i></button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
<script src="<?=SCL_JS?>daterangepicker.min.js"></script> 
<script src="<?=SCL_JS?>moment.min.js"></script> 

<script>
$(document).ready(function(){
	$('#daterange').datepicker();	
});
</script>
<?php $this->load->view('layout/footer'); ?>
