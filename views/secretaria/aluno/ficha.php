<div class="modal-dialog" style="width:60%">
    <div class="modal-content">
        <div class="panel-heading btn-info">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-user"></i> Ficha do Aluno</h4>
        </div>
        <div class="panel-body">
            <div class="panel-body">
                <div class="col-xs-2 thumbnail avatar">
                    <img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $aluno[0]['CD_ALUNO'] ?>" class="media-object">
                </div>
                <div class="col-xs-5">
                    <h5>
                        <label>Aluno:</label> <?= $aluno[0]['NM_ALUNO'] ?><br/>
                        <label>Curso:</label> <?= $aluno[0]['NM_CURSO'] ?><br/>
                        <label>Série:</label> <?= $aluno[0]['NM_SERIE'] ?><br/>
                        <label>Turma:</label> <?= $aluno[0]['CD_TURMA'] ?><br/>
                    </h5>
                </div>
                <div class="col-xs-5">
                    <h5>
                        <label>Endereço:</label> <?= $aluno[0]['ALU_ENDERECO'] ?><br/>
                        <label>Bairro:</label> <?= $aluno[0]['ALU_BAIRRO'] ?><br/>
                        <label>Cidade / UF:</label> <?= $aluno[0]['ALU_CIDADE'] ?> / <?= $aluno[0]['ALU_ESTADO'] ?><br/>
                    </h5>
                </div>
            </div>

            <h5 class="btn btn-info">Responsáveis</h5>

            <div class="panel-footer"> 
                <div class="row">
                    <?
                    foreach ($responsavel as $rs) {
                        $css = '';
                        if ($rs['ACESSO_WEB'] == 'S') {
                            $css = '';
                        }
                        ?> 
                        <div class="col-sm-6"> 
                            <div class="col-xs-4 thumbnail avatar">
                                <img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $rs['CPF_RESPONSAVEL'] ?>" class="media-object">
                            </div>
                            <div class="col-xs-8">
                                <h5>
                                    <label>Responsável:</label> <?= $rs['NM_RESPONSAVEL'] ?><br/>
                                    <label>Telefone:</label> <?= $rs['TEL_RESPONSAVEL'] ?><br/>
                                    <label>Celular:</label> <?= $rs['TEL_RESPONSAVEL_2'] ?><br/>
                                    <label>Email:</label> <?= $rs['EMAIL_RESPONSAVEL'] ?><br/>
                                </h5>
                            </div>
                        </div> 
<? } ?>
                </div>
            </div>
<div class="panel-footer left">
    <a class="btn btn-danger  pull-right" data-dismiss="modal"><i class="fa fa-refresh"></i> Fechar </a>
</div>
        </div>
        
    </div>

</div>

<? exit(); ?>

