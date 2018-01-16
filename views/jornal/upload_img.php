<?php $this->load->view('layout/header'); ?>
<script>
function add_img(){
    var SITE = SITE || {};

    SITE.fileInputs = function() { 
      var $this = $(this),
          $val = $this.val(),
          valArray = $val.split('\\'),
          newVal = valArray[valArray.length-1],
          $button = $this.siblings('.button'),
          $fakeFile = $this.siblings('.file-holder');
      if(newVal !== '') {
        $button.text(newVal);
        if($fakeFile.length === 0) {
          //$button.after('<span class="file-holder">' + newVal + '</span>');
        } else {
          $fakeFile.text(newVal);
        }
      }
    };

    $(document).ready(function() {
      $('.file-wrapper input[type=file]').bind('change focus click', SITE.fileInputs);
    });       
}
</script>    

<script language="JavaScript" type="text/javascript">   
//Não altere esses valores!
var iCount = 0;
var iCampos = 1;
var hidden1; 
//Definindo quantos campos poderão ser criados (máximo);
var iCamposTotal = 5; 
//Função que adiciona os campos;
function addInput() {   
    if (iCampos <= iCamposTotal) {
        hidden1 = document.getElementById("hidden1");
        var texto = "<div id='linha"+iCount+"'><label style='display: block'><span class='file-wrapper'><input type='file' name='arquivo"+iCount+"' id='arquivo"+iCount+"' onclick='add_img()' /><span class='button'>Selecione a Imagem</span></span>";
        //Capturando a div principal, na qual os novos divs serão inseridos:
        var camposTexto = document.getElementById('camposTexto');   
        camposTexto.innerHTML = camposTexto.innerHTML+texto;
        //Escrevendo no hidden os ids que serão passados via POST;
        //No código ASP ou PHP, você poderá pegar esses valores com um split, por exemplo;
        if (hidden1.value == "") {
            document.getElementById("hidden1").value = iCount;
        }else{
            document.getElementById("hidden1").value += ","+iCount;
        }
    iCount++;
    iCampos++;
    }   
}
   
//Função que remove os campos;
function removeInput(e) {
   var pai = document.getElementById('camposTexto');
   var filho = document.getElementById(e);
   hidden1 = document.getElementById("hidden1");
   var campoValor = document.getElementById("arquivo"+e.substring(5)).value;
   var lastNumber = hidden1.value.substring(hidden1.value.lastIndexOf(",")+1);

  // if(confirm("O campo que contém o valor:\n» "+campoValor+"\nserá excluído permanentemente!\n\nDeseja prosseguir?")){
		var removido = pai.removeChild(filho);
		//Removendo o valor de hidden1:
		if (e.substring(5) == hidden1.value) {
			hidden1.value = hidden1.value.replace(e.substring(5),"");
		}else if(e.substring(5) == lastNumber) {
			hidden1.value = hidden1.value.replace(","+e.substring(5),"");
		}else{
			hidden1.value = hidden1.value.replace(e.substring(5)+",","");		
		}
	iCampos--;
//	}
}
</script> 
<style>
.file-wrapper {
cursor: pointer;
display: inline-block;
overflow: hidden;
position: relative;
}
.file-wrapper input {
cursor: pointer;
font-size: 100px;
height: 100%;
filter: alpha(opacity=1);
-moz-opacity: 0.01;
opacity: 0.01;
position: absolute;
right: 0;
top: 0;
}
.file-wrapper .button {
background: #79130e;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
border-radius: 5px;
color: #fff;
cursor: pointer;
display: inline-block;
font-size: 11px;
font-weight: bold;
margin-right: 5px;
padding: 4px 18px;
text-transform: uppercase;
} 
</style>    
<?php
//parametros para distinguir se a imagem é artigo ou noticia
$tipo = $_GET['tipo'];
if($tipo == 'A'){
    $url = SCL_RAIZ.'jornal/artigos/';
    $tit = 'Imagem associada ao artigo';
    $pasta = 'artigo';
}else{
    $url = SCL_RAIZ.'jornal/noticias/';
    $tit = 'Imagem associada a noticia';
    $pasta = 'noticia';
}
?>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    Upload de Imagem
                </div>
                <?php if($_GET['tipo'] == 'A'){ ?>
                            <form action="<?=SCL_RAIZ ?>jornal/artigos/upload_img?codigo=<?=$_GET['codigo']?>" method="post" enctype='multipart/form-data'>  
                                <input name="tipo" type="hidden" id="tipo" value="<?=$_GET['tipo']?>" />
                            <?php }else{ ?>
                            <form action="<?=SCL_RAIZ ?>jornal/noticias/upload_img?codigo=<?=$_GET['codigo']?>" method="post" class="form-inline" enctype='multipart/form-data'>  
                                <input name="tipo" type="hidden" id="tipo" value="<?=$_GET['tipo']?>" />
                            <?php } ?>
                                <div id="error_message" style="color:red"></div>
                                <input name="codigo" type="hidden" id="codigo" value="<?=$_GET['codigo']?>" />
                                <div class="col-xs-12">
                                    <div class="col-sm-12">
                                        <br>
                                        <input type="button" value="Adicionar Nova Imagem" class="btn btn-primary" name="add_input" id="add_input" onClick="addInput();"> 
                                        <p>
                                        <div id="camposTexto"></div>
                                        <input type="hidden" name="contador" id="hidden1" value="">
                                       <br>
                                        <br>                    
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="pull-left"><a href="<?=$url?>" class="btn btn-inverse"><i class="fa fa-backward"></i> Cancelar</a></div>
                                    <button type="submit" id="btn_frmMensagem" class="btn btn-success"> Upload das Imagens <i class="icon-share"></i></button>
                                </div>
                            </form> 
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading"
                     <h3 class="panel-title">Imagem Associadas</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <?php if(count($imagem) > 0){ foreach ($imagem as $i) { ?>
                        <div class="col-xs-6 col-md-3">
                            <a href="<?=SCL_UPLOAD.'/'.$pasta.'/'.$_GET['codigo'].'/'.$i->IMAGEM?>" target="_blank" class="thumbnail">
                                <img alt="150x150" src="<?=SCL_UPLOAD.'/'.$pasta.'/'.$_GET['codigo'].'/'.$i->IMAGEM?>" width="150px" />
                            </a>
                        </div>
                        <?php } }else{ echo '<div class="pull-left"><h4 class="center">Não há imagem</h4></div>'; } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('layout/footer'); ?>
<!--

<link rel="stylesheet" href="<?=SCL_CSS?>colorbox.css" />
<script>
function add_img(){
    var SITE = SITE || {};

    SITE.fileInputs = function() { 
      var $this = $(this),
          $val = $this.val(),
          valArray = $val.split('\\'),
          newVal = valArray[valArray.length-1],
          $button = $this.siblings('.button'),
          $fakeFile = $this.siblings('.file-holder');
      if(newVal !== '') {
        $button.text(newVal);
        if($fakeFile.length === 0) {
          //$button.after('<span class="file-holder">' + newVal + '</span>');
        } else {
          $fakeFile.text(newVal);
        }
      }
    };

    $(document).ready(function() {
      $('.file-wrapper input[type=file]').bind('change focus click', SITE.fileInputs);
    });       
}
</script>    

<script language="JavaScript" type="text/javascript">   
//Não altere esses valores!
var iCount = 0;
var iCampos = 1;
var hidden1; 
//Definindo quantos campos poderão ser criados (máximo);
var iCamposTotal = 5; 
//Função que adiciona os campos;
function addInput() {   
    if (iCampos <= iCamposTotal) {
        hidden1 = document.getElementById("hidden1");
        var texto = "<div id='linha"+iCount+"'><label style='display: block'><span class='file-wrapper'><input type='file' name='arquivo"+iCount+"' id='arquivo"+iCount+"' onclick='add_img()' /><span class='button'>Selecione a Imagem</span></span>";
        //Capturando a div principal, na qual os novos divs serão inseridos:
        var camposTexto = document.getElementById('camposTexto');   
        camposTexto.innerHTML = camposTexto.innerHTML+texto;
        //Escrevendo no hidden os ids que serão passados via POST;
        //No código ASP ou PHP, você poderá pegar esses valores com um split, por exemplo;
        if (hidden1.value == "") {
            document.getElementById("hidden1").value = iCount;
        }else{
            document.getElementById("hidden1").value += ","+iCount;
        }
    iCount++;
    iCampos++;
    }   
}
   
//Função que remove os campos;
function removeInput(e) {
   var pai = document.getElementById('camposTexto');
   var filho = document.getElementById(e);
   hidden1 = document.getElementById("hidden1");
   var campoValor = document.getElementById("arquivo"+e.substring(5)).value;
   var lastNumber = hidden1.value.substring(hidden1.value.lastIndexOf(",")+1);

  // if(confirm("O campo que contém o valor:\n» "+campoValor+"\nserá excluído permanentemente!\n\nDeseja prosseguir?")){
		var removido = pai.removeChild(filho);
		//Removendo o valor de hidden1:
		if (e.substring(5) == hidden1.value) {
			hidden1.value = hidden1.value.replace(e.substring(5),"");
		}else if(e.substring(5) == lastNumber) {
			hidden1.value = hidden1.value.replace(","+e.substring(5),"");
		}else{
			hidden1.value = hidden1.value.replace(e.substring(5)+",","");		
		}
	iCampos--;
//	}
}
</script> 
<style>
.file-wrapper {
cursor: pointer;
display: inline-block;
overflow: hidden;
position: relative;
}
.file-wrapper input {
cursor: pointer;
font-size: 100px;
height: 100%;
filter: alpha(opacity=1);
-moz-opacity: 0.01;
opacity: 0.01;
position: absolute;
right: 0;
top: 0;
}
.file-wrapper .button {
background: #79130e;
-moz-border-radius: 5px;
-webkit-border-radius: 5px;
border-radius: 5px;
color: #fff;
cursor: pointer;
display: inline-block;
font-size: 11px;
font-weight: bold;
margin-right: 5px;
padding: 4px 18px;
text-transform: uppercase;
} 
</style>    
<?php
//parametros para distinguir se a imagem é artigo ou noticia
$tipo = $_GET['tipo'];
if($tipo == 'A'){
    $url = SCL_RAIZ.'/jornal/artigos/';
    $tit = 'Imagem associada ao artigo';
    $pasta = 'artigo';
}else{
    $url = SCL_RAIZ.'/jornal/noticias/';
    $tit = 'Imagem associada a noticia';
    $pasta = 'noticia';
}
?>

            <div class="widget-box transparent" id="recent-box">
                <div class="widget-header"> <?=$titulo?>
                    <div class="widget-toolbar no-border">
                        <a href="<?= SCL_RAIZ ?>/jornal/artigos">Voltar</a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main padding-4">
                        <div class="tab-content padding-8 overflow-visible">   
                            <?php echo validation_errors();?>
                            <?php echo $this->session->flashdata('sucesso');?> 
                            <?php echo $this->session->flashdata('erro');?>
                            <?php if($_GET['tipo'] == 'A'){ ?>
                            <form action="<?=SCL_RAIZ ?>/jornal/artigos/upload_img?codigo=<?=$_GET['codigo']?>" method="post" class="form-inline" enctype='multipart/form-data'>  
                                <input name="tipo" type="hidden" id="tipo" value="<?=$_GET['tipo']?>" />
                            <?php }else{ ?>
                            <form action="<?=SCL_RAIZ ?>/jornal/noticias/upload_img?codigo=<?=$_GET['codigo']?>" method="post" class="form-inline" enctype='multipart/form-data'>  
                                <input name="tipo" type="hidden" id="tipo" value="<?=$_GET['tipo']?>" />
                            <?php } ?>
                                <div id="error_message" style="color:red"></div>
                                <input name="codigo" type="hidden" id="codigo" value="<?=$_GET['codigo']?>" />
                                <div class="col-xs-12">
                                    <div class="col-sm-12">
                                        <br>
                                        <input type="button" value="Adicionar Nova Imagem" class="btn btn-primary" name="add_input" id="add_input" onClick="addInput();"> 
                                        <p>
                                        <div id="camposTexto"></div>
                                        <input type="hidden" name="contador" id="hidden1" value="">
                                       <br>
                                        <br>                    
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="pull-left"><a href="<?=$url?>" class="btn bigger-120 btn-grey"><i class="icon-ok bigger-120"></i>Cancelar</a></div>
                                    <button type="submit" id="btn_frmMensagem" class="btn btn-success"> Upload das Imagens <i class="icon-share"></i></button>
                                </div>
                            </form> 
                            
                            <div class="page-content">
				<div class="page-header">
                                    <h1>
					Galeria
                                        <small>
                                            <i class="icon-double-angle-right"></i>
                                            <?=$tit;?>
                                        </small>
                                    </h1>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
        				<div class="row-fluid">
                                            <ul class="ace-thumbnails">
                                                <?php foreach ($imagem as $i) { ?>
						<li>
                                                    <a href="<?=SCL_UPLOAD.'/'.$pasta.'/'.$_GET['codigo'].'/'.$i->IMAGEM?>" data-rel="colorbox">
                                                        <img alt="150x150" src="<?=SCL_UPLOAD.'/'.$pasta.'/'.$_GET['codigo'].'/'.$i->IMAGEM?>" width="150px" />
                                                    
                                                        <div class="text">
                                                                <div class="inner">Clique para amplicar</div>
                                                        </div>
                                                    </a>
                                                    
                                                </li>
                                                <?php } ?>
                                            </ul>
					</div>
                                    </div>
				</div>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?=SCL_JS?>jquery.colorbox-min.js"></script>
<script type="text/javascript">
jQuery(function($) {
	var colorbox_params = {
		reposition:true,
		scalePhotos:true,
		scrolling:false,
		previous:'<i class="icon-arrow-left"></i>',
		next:'<i class="icon-arrow-right"></i>',
		close:'&times;',
		current:'{current} of {total}',
		maxWidth:'100%',
		maxHeight:'100%',
		onOpen:function(){
			document.body.style.overflow = 'hidden';
		},
		onClosed:function(){
			document.body.style.overflow = 'auto';
		},
		onComplete:function(){
			$.colorbox.resize();
		}
	};

	$('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
	$("#cboxLoadingGraphic").append("<i class='icon-spinner orange'></i>");//let's add a custom loading icon

})
</script>
<?php $this->load->view('layout/footer'); ?>
-->