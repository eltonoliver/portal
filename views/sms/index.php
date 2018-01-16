<? $this->load->view('layout/header'); ?>

<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Meus SMS's Enviados 
                        <a class="btn btn-success btn-sm col-md-2 pull-right" > 
                            <i class='fa fa-envelope'></i> Saldo de SMS: 
                            <? 
                            $sms = new Soapsms();
                            $saldo = $sms->saldo();
                            echo $saldo;
                            ?>
                        </a>
                        <? if($saldo > 0){ ?>
                        <a href="<?= SCL_RAIZ ?>sms/enviar" data-toggle="frmSMS"  class="btn btn-info btn-sm col-md-1 pull-right" data-target="#frmSMS" > <i class='fa fa-plus'></i>Adicionar</a>
                        <? }else{ 
                        echo '<a class="btn btn-danger btn-sm col-md-5 pull-right">Não há saldo para envio de SMS!</a>';
                        }
                        ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>Data de Envio</label>
                        <input id="data-sms" name="data-sms" type="text">
                    </div>
                    <hr>

                    <div id="container-sms">                        
                        <?php $this->load->view("sms/grid-sms", array('listar' => $listar)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= SCL_JS ?>jquery.dataTables.min.js"></script> 
<script src="<?= SCL_JS ?>jquery.dataTables.bootstrap.js"></script> 
<script type="text/javascript">
    function initDataTable() {
        $('#gridTabela').dataTable({
            "sPaginationType": "full_numbers",
            "oLanguage": {
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "sLengthMenu": "Mostrar por página _MENU_ ",
                "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
                "sInfoEmpty": "Registro não encontrado",
                "sZeroRecords": "Não há registro",
            },
            "aaSorting": [[0, "desc"]],
        });

        atualizaStatus();

        $("#gridTabela").on('draw.dt', function () {
            atualizaStatus();
        });
    }

    function atualizaStatus() {
        var linhas = $("#gridTabela").find("tbody tr");
        var tamanho = linhas.length;

        for (i = 0; i < tamanho; i++) {
            var codigo = $(linhas[i]).attr('id');

            $.ajax({
                url: "<?= site_url("sms/checaStatus") ?>",
                method: "post",
                dataType: "json",
                data: {
                    codigo: codigo
                },
                success: function (data, textStatus) {
                    var id = data['codigo'];
                    $("#gridTabela").find("#" + id + " .status").html(data['mensagem']);
                }
            });
        }
    }

    $(document).ready(function () {
        initDataTable();
        alterarData();
    });

    $("#data-sms").datepicker({
        language: 'pt-BR',
        format: 'dd/mm/yyyy'
    });

    function alterarData() {
        var dataEnvio = $("#data-sms").val();

        if (dataEnvio !== '') {
            $("#container-sms").html('<div class="progress progress-striped progress-active"><div class="progress-bar progress-bar-warning" style="width: 100%;"></div></div>');

            $.ajax({
                url: "<?= site_url("sms/listaSms") ?>",
                method: "post",
                data: {
                    envio: dataEnvio
                },
                success: function (data, status) {
                    $("#container-sms").html(data);
                    initDataTable();
                }
            });
        }
    }

    $("#data-sms").on("changeDate", function () {
        alterarData();
    });

    $('[data-toggle="frmSMS"]').on('click',
            function (e) {
                $('#frmSMS').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade" id="frmSMS"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
</script>
<? $this->load->view('layout/footer'); ?>