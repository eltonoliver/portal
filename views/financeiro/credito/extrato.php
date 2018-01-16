<?php $this->load->view('layout/header'); ?>

<link rel="stylesheet" type="text/css" media="screen" href="<?= SCL_CSS ?>bootstrap-datapicker.css">
<script type="text/javascript" src="<?= SCL_JS ?>bootstrap-datepicker.min.js"></script> 

<script type="text/javascript">
    function filtrar() {
        $("#form_pesq").submit(function () {  
            $('div[id=tabela_listar]').html('<div class="progress progress-striped progress-striped active"><div class="progress-bar progress-bar-warning" style="width: 100%;">Carregando Dados</div></div>');
            $.post("<?= SCL_RAIZ ?>financeiro/credito/extrato", $("#form_pesq").serialize()) //Serialize looks good name=textInNameInput&&telefon=textInPhoneInput---etc
                    .done(function (data) { 
                        if (data != null) {
                            $('div[id=tabela_listar]').html(data);
                        } else {
                            $('div[id=tabela_listar]').html("<div class='text-danger'>Não retornou nada da pesquisa</div>");
                        }
                    });
            return false;
        })
    }
</script>

<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <a href="<?=  base_url()?>inicio" class="btn btn-default">Voltar</a>
                </div>
                <div class="panel-body">
                    <div class="col-xs-3">
                        <img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $aluno ?>" class="" style="width: 100px">                            
                    </div>
                    <form id="form_pesq" name="form_pesq" method="post">
                        <div class="col-xs-6">
                            <label>Filtro</label>
                           
                            <input type="hidden" name="cd_aluno" value="<?=base64_decode($this->input->get('token'));?>" />
                            <input type="hidden" name="limite" value="<?=base64_decode($this->input->get('limite'));?>" />
                            <input type="hidden" name="almoco" value="<?=base64_decode($this->input->get('al'));?>" />
                            <input type="hidden" name="acao" value="<?=base64_encode('extrato');?>" />
                            
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" placeholder="Data Inicial" class="form-control" name="dt_ini" id="dt_ini" value="<?=date('d/m/Y')?>">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                
                                <input type="text" placeholder="Data Final" class="form-control" name="dt_fim" id="dt_fim" value="<?=date('d/m/Y')?>">
                                <span class="input-group-btn">
                                    <button type="submit" onclick="filtrar();" id="filtro" class="btn btn-success btn-sm">Filtrar</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <span>Extrato com os dados de compra de crédito e consumo realizado com crédito.</span>
                </div>
            </div>
            
            <div class="col-xs-12">
                <div class="panel">
                    <div id="tabela_listar">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(function () {

        $("#dt_ini").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 3,
            onClose: function (selectedDate) {
                $("#dt_fim").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#dt_fim").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 3,
            onClose: function (selectedDate) {
                $("#dt_ini").datepicker("option", "maxDate", selectedDate);
            }
        });
    });
    

    $('#gridview').dataTable({
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
    $('#gridview_wrapper .dataTables_filter input').attr('placeholder', 'Procurar...');
    
    $('[data-toggle="frmDetalhe"]').on('click',
                function(e) {
                    $('#frmCredito').remove();
                    e.preventDefault();
                    var $this = $(this)
                            , $remote = $this.data('remote') || $this.attr('href')
                            , $modal = $('<div class="modal fade" id="frmCredito"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
                    $('body').append($modal);
                    $modal.modal({backdrop: 'static', keyboard: false});
                    $modal.load($remote);
                }
        );

</script>
<?php $this->load->view('layout/footer'); ?>
