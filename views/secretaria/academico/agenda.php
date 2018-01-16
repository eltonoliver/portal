<? $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <label>Informe o Período</label>
                    <div class="input-group col-sm-3"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input name="periodo" type="text" class="form-control" id="daterange">
                    </div>
                </div>
                <div class="panel-body" id="conteudo" style="min-height:250px">
                </div>
            </div>

        </div>
        <!-- Área que vai atualizar :final   -->
    </div>
</div>


<script src="<?= SCL_JS ?>bootstrap-datepicker.min.js"></script> 
<script src="<?= SCL_JS ?>daterangepicker.min.js"></script> 
<script src="<?= SCL_JS ?>moment.min.js"></script>
<script>
    $(document).ready(function () {
        $('#daterange').daterangepicker({
            format: 'DD/MM/YYYY',
        },
                function (start, end) {

                    $("#conteudo").html('<div class="progress progress-striped progress-active"><div class="progress-bar progress-bar-warning" style="width: 100%;"></div></div>');
                    $.ajax({
                        url: "<?= SCL_RAIZ ?>secretaria/academico/agenda_lista?inicio=" + start.format('DD/MM/YYYY') + "&fim=" + end.format('DD/MM/YYYY') + "",
                        success: function (data) {
                            $('#conteudo').html(data);
                        }
                    });
                });
    });
</script>
<script type="text/javascript">
    
    window.onload = function () {
        $.ajax({
            url: "<?= SCL_RAIZ ?>secretaria/academico/agenda_lista?inicio=<?=date('d/m/Y')?>&fim=<?=date('d/m/Y')?>",
            success: function (data) { 
                $('#conteudo').html(data);
            }
        });
    }
</script>
<? $this->load->view('layout/footer'); ?>