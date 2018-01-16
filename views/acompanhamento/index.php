<?php $this->load->view('layout/header'); ?>


<div id="content">
    <div class="row user-profile">
        <?php foreach ($alunos as $aluno) { ?>
            <?php $url = site_url("acompanhamento/aluno") . "?token=" . base64_encode($aluno['CD_ALUNO']); ?>
            <div class="page-header media col-sm-3" style="margin-bottom: 15px">
                <div class="media">
                    <a href="<?= $url ?>">
                        <div class="pull-left"> 
                            <img src="<?= "https://www.seculomanaus.com.br/academico/usuarios/foto?codigo=" . $aluno['CD_ALUNO'] ?>" class="media-object">
                        </div>

                        <div class="media-body">
                            <h5 class="media-heading">                                
                                <div>
                                    <span><?= substr($aluno['NM_ALUNO'], 0, 20) ?></span>
                                </div>
                                <div>
                                    <span>Matrícula: <?= $aluno['CD_ALUNO'] ?></span>    
                                </div>
                                <div>
                                    <span>Turma: <?= $aluno['TURMA_ATUAL']; ?></span>
                                </div>
                            </h5>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php $this->load->view('layout/footer'); ?>