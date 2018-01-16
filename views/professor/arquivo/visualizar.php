<link href="<?= SCL_CSS ?>bootstrap-select.min.css" rel="stylesheet" type="text/css">
<script src="<?= SCL_JS ?>bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?= SCL_JS ?>bootstrap-switch.min.js?v=3.0.0"></script>
<script src="<?= SCL_JS ?>bootstrap-filestyle.js"></script>
<script src="<?= SCL_JS ?>summernote.min.js">
</script><script src="<?= SCL_JS ?>script.js"></script>   


<div class="modal-header btn-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" >Visualização de Arquivo</h4>
</div>
<div class="widget-body" style="height:400px">
    <iframe width="100%" border="0"  height="100%" src="<?= base_url('application/upload/professor/' . $codigo . '/' . $arquivo) ?>" ></iframe>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Fechar</button>
</div>

<?php exit; ?>