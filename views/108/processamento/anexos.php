<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.css')?>" />
<script src="<?=base_url('assets/js/jquery.min.js')?>"></script>
<script type="text/javascript">
    $(function($) {
        var pai = window.parent.document;
        <?php if (isset($erro)):?>
            alert('<?php echo $erro ?>');
        <?php elseif (isset($nome)):?>
            $('#anexos', pai).append('<li class="list-group-item" nome="<?=$aleatorio?>" registro="<?=$registro?>"><button class="btn btn-danger btn-xs" onclick="removeAnexo(this)"> X </button>  <?=$nome ?> - <strong>( <?=$registro?> registros ) </strong></li>');
        <?php endif ?>
    	$("#arquivo").change(function() {
            if (this.value != ""){
                $("#form").hide();
                $("#status").show();
                $("#upload").submit();
            }
        });
    });
</script>
<div class="col-xs-10" id="form">
<form id="upload" action="<?=base_url('108/processamento/anexo')?>" method="post" enctype="multipart/form-data">
    <input type="file" name="arquivo" id="arquivo" class="form-control input-xs" />
</form>
</div>
<span id="status" style="display: none;" class="col-xs-2">
    <img src="<?=base_url('assets/images/loading-bar.gif')?>" alt="Enviando..." />
</span>