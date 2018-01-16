<? $this->load->view('layout/header'); ?>
<script src="<?= SCL_JS ?>highcharts.js"></script>
<script src="<?= SCL_JS ?>exporting.js"></script>
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <form action="javascript:void(0)" method="post" enctype="multipart/form-data" id="frmfiltro" name="frmfiltro" >
                            <div class="colsm-12">
                                <label> Tipo de Gráfico </label>
                                <div class="input-group">
                                    <select name="tipo" id="tipo" class="form-control">
                                        <option value=""></option>
                                            <option value="0">Acadêmico</option>
                                            <option value="2">Financeiro</option>
                                    </select>
                                    <span class="input-group-addon">
                                        <button type="submit" class="btn btn-danger btn-xs no-padding"><i class="fa fa-filter icon-only"></i> Filtrar</button>
                                    </span>
                                </div>
                            </div>
                            
                        </form>
                    </h5>
                </div>
            </div>
            <div id="grd" class="row"></div>
        </div>
    </div>
</div>

<!-- /.main-content -->
<div class="modal fade" id="mdlAdicionar" data-backdrop="static" data-keyboard="false" data-remote="<?= SCL_RAIZ ?>acesso/grupo/view?tipo=adicionar">
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
    jQuery(document).ready(function() {
        jQuery('#frmfiltro').submit(function() {
            var dados = jQuery(this).serialize();

            jQuery.ajax({
                type: "POST",
                url: "<?= SCL_RAIZ ?>diretoria/dashboard/filtro",
                data: dados,
                success: function(data)
                {
                    $("#grd").html(data);
                }
            });
            return false;
        });
    });

jQuery(function($) {
	$("#grupo").chosen(); 

});
</script>
<? $this->load->view('layout/footer'); ?>
