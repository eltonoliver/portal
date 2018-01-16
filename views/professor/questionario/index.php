<?php $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-warning">
                <table width="100%" class="table table-bordered table-hover" id="gridview" aria-describedby="sample-table-2_info">
                    <thead>
                        <tr class="panel-heading">
                            <th class="sorting">Turma</th>
                            <th class="sorting" width="15%">Total</th>
                            <th class="sorting" width="15%">Lançado</th>
                            <th class="sorting text-center" width="30%">%</th>
                            <th class="sorting_disabled text-center" width="10%">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($grade) > 0) {
                            foreach ($grade as $row) {
                                ?>
                                <tr class="text-success">
                                    <td><?= $row['CD_TURMA'] ?></td>
                                    <td><?= ($row['TPERGUNTA'] * $row['TALUNO']) ?> perguntas</td>
                                    <td><?= $row['TRESULTADO'] ?> respostas</td>
                                    <td>
                                        <?php $per = (($row['TRESULTADO'] * 100) / ($row['TPERGUNTA'] * $row['TALUNO'])) ?>
                                        <div class="progress progress-small progress-striped active">
                                            <div class="progress-bar progress-bar-info" style="width:<?= number_format($per, 2, '.', '') ?>%"><?= number_format($per, 2, '.', '') ?>%</div>
                                        </div>
                                    </td>
                                    <td width="10%">
                                        <a class="btn btn-danger" href="<?= SCL_RAIZ ?>professor/infantil/listar_turma?turma=<?= $row['CD_TURMA'] ?>">
                                            <i class="fa fa-check-circle"></i> Fazer Avaliação
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                        } ?>
                    </tbody>
                    <tfoot>
                        <tr role="row">
                            <th colspan="6">&nbsp;</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('layout/footer'); ?>
