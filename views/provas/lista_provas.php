<?php $this->load->view('layout/header'); ?>
<script language="JavaScript"> 
function linksduplosh(linkduplo1,linkduplo2) { 
    window.open(linkduplo1); 
    window.open(linkduplo2); 
} 
</script>   
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <?= $titulo ?>
                </div>

                <table border="1" id="gridProvas" class="table table-striped table-bordered table-responsive table-hover">
                    <thead class="well">
                        <tr>
                            <th width="10%">CÓDIGO</th>
                            <th width="30%">Descrição</th>
                            <th width="30%">Curso</th>
                            <th width="5%">Qtde</th>
                            <th width="10%">Data</th>
                            <th width="20%">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($listar as $row) {
                            if ($row->CD_STATUS == 0) {
                                $cor = "success"; //prova finalizada
                            } else if (($row->CD_STATUS == 1) and ( $row->CD_STATUS != null)) {
                                $cor = "info"; //prova em producao
                            } else if ($row->CD_STATUS == 2) {
                                $cor = "warning"; //prova em analise
                            } else if ($row->CD_STATUS == 3) {
                                $cor = "danger"; //prova cancelada
                            } else if ($row->CD_STATUS == 4) {
                                $cor = "default"; //prova para impressao
                            }
                            ?>
                            <tr style="font-size:12px;" class="<?= $cor ?>">
                                <td cla><?= $row->NUM_PROVA ?></td>
                                <td><?= $row->TITULO; ?></td>
                                <td><?= $row->NM_CURSO; ?></td>
                                <td><?= $row->QTDE_QUESTAO; ?></td>
                                <td><?= formata_data($row->DT_PROVA, 'br') ?></td>
                                <td>
                                    <?php
                                    $param = urlencode(serialize($row));
                                    $url = SCL_RAIZ . "provas/questoes/cadastro_questao?p=" . $row->CD_PROVA
                                    ?>
                                    <?php if ($row->CD_STATUS == 1) { ?>
                                        
                                        <a data-toggle="modal" data-target="#finalizar<?=$row->CD_PROVA ?>" class="btn btn-xs btn-success" href="#"><i class="fa fa-check"></i></a>
                                        <div class="modal fade" id="finalizar<?=$row->CD_PROVA ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"> 
                                            <div class="modal-dialog" style="width: 60%;">
                                                <div class="modal-content">
                                                    <div class="modal-content">
                                                        <div class="modal-header btn-success">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                            <h4><i class="fa fa-file"></i> Finalizar Prova</h4>
                                                        </div>
                                                        <div class="panel-body">   
                                                            <div class="row">
                                                                <div class="col-xs-12">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-12">
                                                                            <?php if($row->QTDE_QUESTAO < 24){ ?>
                                                                            <h1>A prova não contém todas as questõs, não pode ser finalizada</h1>
                                                                            <?php }else{ ?>
                                                                            <h1>Tem certza que deseja finalizar a prova?</h1>
                                                                            <h3>A partir desse momento não poderá mas editar as questões</h3>
                                                                            <h3><?= $row->TITULO; ?></h3>
                                                                            
                                                                            <p>OBS: A prova irá para análise da comissão de prova, caso necessário a prova poderá ser editada.</p>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div> 

                                                        <div class="modal-footer">
                                                            <button class="btn btn-danger pull-left" data-dismiss="modal" id="frmarquivo_btn" ><i class="fa fa-refresh"></i> Fechar </button>
                                                             <?php if($row->QTDE_QUESTAO == 24){ ?>
                                                             <a href="https://www.seculomanaus.com.br/seculo/prova?id=<?=$p->CD_PROVA ?>" target="_blank" class="btn btn-default right" href="#"><i class="fa fa-book"></i> Visualizar Prova</a>
                                                             <?php } ?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    <?php } ?>
                                    <?php if ($row->CD_STATUS == 1) { ?>
                                        <a class="btn btn-xs btn-warning" href="<?= SCL_RAIZ ?>provas/correcao/lista_questao_prova?cd_prova=<?= $row->CD_PROVA ?>"><i class="fa fa-list"></i></a>
                                    <?php } ?>
                                    <a class="btn btn-xs btn-info" href="javascript:void(0)" target="_blank" 
                                       onclick="linksduplosh('https://www.seculomanaus.com.br/seculo/prova?id=<?=$row->CD_PROVA ?>','https://www.seculomanaus.com.br/seculo/prova/discursiva?id=<?=$row->CD_PROVA ?>')"><i class="fa fa-book"></i></a>
                              
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-right">
                                Legenda: <i class="btn btn-xs btn-success fa fa-check"></i> Finalizar Prova | 
                                <i class="btn btn-xs btn-warning fa fa-list"></i> Visualizar Questões |
                                <i class="btn btn-xs btn-info fa fa-book"></i> Visualizar Prova
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="text-left">
                                Provas: <span class="btn btn-xs btn-success">Finalizada</span>
                                <span class="btn btn-xs btn-info">Em Desenvolvimento</span>
                                <span class="btn btn-xs btn-warning">Em Análise</span>
                                <span class="btn btn-xs btn-danger">Cancelada</span>
                                <span class="btn btn-xs btn-default">Para Impressão</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#gridProvas').dataTable({
        "sPaginationType": "full_numbers",
        "oLanguage": {
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "sLengthMenu": "Mostrar _MENU_ por página  ",
            "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
            "sInfoEmpty": "Registro não encontrado",
            "sZeroRecords": "Não há registro",
        },
        "aaSorting": [[0, "desc"]],
        "bStateSave": true
    });

    $('[data-toggle="frmModal"]').on('click',
            function (e) {
                $('#frmModal').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade" id="frmModal"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
</script>
<?php $this->load->view('layout/footer'); ?>





