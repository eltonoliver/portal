<? $this->load->view('layout/header'); ?>
<script src="<?= SCL_JS ?>jquery.dataTables.min.js"></script> 
<script src="<?= SCL_JS ?>jquery.dataTables.bootstrap.js"></script> 
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <form action="<?= SCL_RAIZ ?>/acesso/programa/tabela" method="post" enctype="multipart/form-data" id="frmfiltro" name="frmfiltro" >
                            <div class="colsm-12">

                                <label> Informe o Sistema </label>
                                <div class="input-group">
                                    <select name="sistema" id="sistema" class="form-control">
                                        <? foreach ($sistema as $item) { ?>
                                            <option value="<?= $item['SISTEMA'] ?>">
                                                <?= $item['DC_SISTEMA'] ?>
                                                (
                                                <?= $item['PROGRAMA'] ?>
                                                )</option>
                                        <? } ?>
                                    </select>
                                    <span class="input-group-addon">
                                        <button type="submit" class="btn btn-danger btn-xs no-padding"><i class="fa fa-filter icon-only"></i> Filtrar</button>
                                    </span>
                                    <span class="input-group-addon">
                                        <button type="text" data-toggle="modal" data-target="#mdlAdicionar" name="btnAdd" class="btn btn-info btn-xs"> <i class="fa fa-list"></i> Novo Programa</button>
                                    </span>
                                </div>
                            </div>
                            
                        </form>
                    </h3>
                </div>
                <div class="panel-body">
                    <div id="grdprograma"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.main-content -->
<div class="modal fade" id="mdlAdicionar" data-backdrop="static" data-keyboard="false" data-remote="<?= SCL_RAIZ ?>acesso/programa/view?tipo=adicionar">
    <div class="modal-dialog">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script src="<?= SCL_JS ?>jquery.dataTables.min.js"></script> 
<script src="<?= SCL_JS ?>jquery.dataTables.bootstrap.js"></script> 
<script>
    $('#listar').dataTable({
        "sPaginationType": "full_numbers"
    });

    jQuery(document).ready(function() {
        jQuery('#frmfiltro').submit(function() {
            var dados = jQuery(this).serialize();

            jQuery.ajax({
                type: "POST",
                url: "<?= SCL_RAIZ ?>acesso/programa/tabela",
                data: dados,
                success: function(data)
                {
                    $("#grdprograma").html(data);
                }
            });
            return false;
        });
    });

jQuery(function($) {
	$("#sistema").chosen(); 

});
</script>
<? $this->load->view('layout/footer'); ?>
