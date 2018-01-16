<?php $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            if (count($alunos) > 0) {
                foreach ($alunos as $row) {
                    $per = number_format(($row['TRESULTADO'] * 100) / $row['TPERGUNTA'], 2, '.', '');
                    $round = round(($row['TRESULTADO'] * 100) / $row['TPERGUNTA']);
                    ?>
                    <div class="col-xs-12 col-sm-3 widget-container-span ui-sortable">
                        <form action="<?= SCL_RAIZ ?>professor/infantil/questionario" method="post" id="form<?= $row['CD_ALUNO'] ?>">
                            <input type="hidden" value="<?= $row['BIMESTRE'] ?>" name="bimestre" id="bimertre"/>
                            <input type="hidden" value="<?= $row['CD_QUEST'] ?>" name="questionario" id="questionario"/>
                            <input type="hidden" value="<?= $row['CD_ALUNO'] ?>" name="aluno" id="aluno"/>
                            <?php
                            if ($round < 100) {
                                $style = 'panel-danger';
                            } else {
                                $style = 'panel-primary';
                            }
                            ?>
                            <div class="panel <?= $style ?>">
                                <div class="panel-heading">
                                    <h6 class="small">
                                        <i class="fa fa-user"></i> 
                                        <?= substr($row['NM_ALUNO'], 0, 25) ?>
                                    </h6>
                                </div>
                                <div class="panel-body center">
                                    <div class="widget-main padding-6">
                                        <div class="alert alert-info">
                                            <div class="user">
                                                <img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $row['CD_ALUNO'] ?>" title="<?= $row['NM_ALUNO'] ?>" width="100%" />
                                            </div>
                                            <br />
                                            <a href="<?= SCL_RAIZ ?>professor/infantil/questionario?token=<?= base64_encode($row['CD_ALUNO']) ?>&bm=<?= $row['BIMESTRE'] ?>&qs=<?= $row['CD_QUEST'] ?>&tid=<?= base64_encode($row['NM_ALUNO']) ?>&t=<?= base64_encode($this->input->get('turma')) ?>" class="btn btn-xs"><i class="fa fa-"></i> Lançar Acompanhamentos </a>
                                        </div>
                                    </div>
                                </div>
                            </div>  

                        </form>
                    </div>
                <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<?php $this->load->view('layout/footer'); ?>
