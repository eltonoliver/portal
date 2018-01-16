<? $this->load->view('home/header'); ?>
<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-heading">
                <div class="panel-tools">
                    <a onclick="location.reload()"><i class="fa fa-refresh"></i></a>
                </div>
                <h3><i class="fa fa-check text-success"></i> <?=count($listar)?> PROVA(S) ESPERANDO CORREÇÃO</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover" id="tblGridView">
                    <thead>
                        <tr class="panel-footer">
                            <td width="10%"><strong>ID</strong></td>
                            <td width="10%"><strong>N. PROVA</strong></td>
                            <td width="10%" align="center"><strong>QUESTÕES</strong></td>
                            <td><strong>DISCIPLINA</strong></td>                            
                            <td width="10%" align="center"></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        foreach ($listar as $row) {
                            ?>
                            <tr>
                                <td><?= $row['CD_PROVA'] ?></td>
                                <td><?= $row['NUM_PROVA'] ?></td>
                                <td align="center"><?= $row['QUESTOES'] ?></td>
                                <td><?= $row['DISCIPLINAS'] ?></td>
                                <td>
                                    <a class="btn btn-warning btn-xs" href="<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/prova_correcao/frmCorrecao/' . $row['CD_PROVA'] . '') ?>" >
                                        <i class="fa fa-edit"></i> Corrigir agora
                                    </a>
                                </td>
                            </tr>
                        <? } ?>
                    </tbody>
                    <tfoot>
                        <tr class="panel-footer">
                            <td colspan="5">
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