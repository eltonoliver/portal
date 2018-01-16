<?php
$this->load->view('layout/header');
$mensagem = $this->session->flashdata('mensagem');
$hasMensagem = !empty($mensagem);

if ($hasMensagem) :
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#modal-informativo").modal("show");
        });
    </script>
<?php endif; ?>
<script type="text/javascript">
    function abrir_frequencia(cd_aula) {
        $("#modal_frequencia" + cd_aula).modal("show");
    }

    function lembreteFecharAula() {
        $.ajax({
            url: "<?= site_url('professor/diario/lembreteFecharAula') ?>",
            dataType: 'json',
            success: function (data) {
                if (data['success']) {
                    var modals = $(".modal.in");

                    //evitar um modal sobre o outro
                    if (modals.length === 0) {
                        $("#modal-informativo-mensagem").html(data['mensagem']);
                        $("#modal-informativo").modal("show");
                    }
                }
            },
            complete: function () {
                setTimeout(lembreteFecharAula, 60000);
            }
        });
    }

    $(document).ready(function () {
        lembreteFecharAula();
    });
</script>

<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('success');
            echo get_msg('error');
            ?>

            <div class="panel panel-info">                
                <div class="panel-heading">
                    <h3 class="panel-title text-center">MATUTINO</h3>
                </div>

                <?=
                $this->load->view("professor/diario/grid_aula", array(
                    'aulas' => $manha,
                        ), true);
                ?>
            </div>

            <div class="panel panel-warning">                
                <div class="panel-heading">
                    <h1 class="panel-title text-center">VESPERTINO</h1>
                </div>

                <?=
                $this->load->view("professor/diario/grid_aula", array(
                    'aulas' => $tarde,
                        ), true);
                ?>
            </div>
        </div>
    </div>

    <!-- Modal Informativo -->
    <div class="modal fade" id="modal-informativo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">             
        <div class="modal-dialog" style="width:30%">
            <div class="modal-content">
                <div class="modal-header alert-dismissable btn-warning">                                            
                    <h4 class="modal-title" id="myModalLabel">Importante</h4>
                </div>

                <div class="modal-body">                                            
                    <div id="modal-informativo-mensagem">
                        <?php
                        if ($hasMensagem) {
                            echo $this->session->flashdata('mensagem');
                        }
                        ?>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-check"></i> Ok</button>                                            
                </div>
            </div>
        </div>
    </div>                                                                
    <!-- Fim Modal Informativo -->  
</div>

<?php $this->load->view('layout/footer'); ?>