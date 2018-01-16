<? $this->load->view('home/header'); ?>
<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-heading">                    
                <h3>
                    <a class="btn btn-success pull-right" onclick="location.reload()">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a data-toggle="frmModal" href="<?=base_url('108/prova_cancelamento/frmNovaSolicitacao')?>" class="btn btn-primary pull-right">
                        <i class="fa fa-check text-success"></i> NOVA SOLICITAÇÃO
                    </a> 
                    <?=count($listar)?> HISTÓRICO DE CANCELAMENTO
                </h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover" id="tblGridView">
                    <thead>
                        <tr class="panel-footer">
                            <td width="10%"><strong>ID.</strong></td>
                            <td width="10%"><strong>PROVA</strong></td>
                            <td width="10%" align="center"><strong>MOTIVO</strong></td>
                            <td><strong>PARA:</strong></td>
                            <td><strong>DT. APROVAÇÃO:</strong></td>
                            <td width="10%" align="center"></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        foreach ($listar as $row) {
                            ?>
                            <tr>
                                <td><?= $row['CD_CANCELAMENTO'] ?></td>
                                <td><?= $row['CD_PROVA'] ?></td>
                                <td><?= $row['DS_MOTIVO'] ?></td>
                                <td align="center"><?= $row['NM_USUARIO_APROVACAO'] ?></td>
                                <td><?= $row['DT_APROVACAO'] ?></td>
                                <td>
                                    <a class="btn btn-warning btn-xs" href="<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/prova_cancelamento/frmCorrecao/' . $row['CD_PROVA'] . '') ?>" >
                                        <i class="fa fa-edit"></i> Corrigir agora
                                    </a>
                                </td>
                            </tr>
                        <? } ?>
                    </tbody>
                    <tfoot>
                        <tr class="panel-footer">
                            <td colspan="6">
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <script>
                    $(function() {
                        // Initialize Example 2
                        $('#tblGridView').dataTable();
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<? $this->load->view('home/footer'); ?>