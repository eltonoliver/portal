<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header btn-info">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-user"></i> Faltas do(a) Aluno(a)</h4>
        </div>

        <div class="modal-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <td>Dia</td>
                    <td>Tempo</td>
                    <td>Disciplina</td>
                    <td>Professor</td>
                </tr>
                <? foreach ($listar as $r) { ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($r['DT_AULA'])) ?></td>
                        <td><?= $r['TEMPO_AULA'] ?></td>
                        <td><?= $r['NM_DISCIPLINA'] ?></td>
                        <td><?= $r['NM_PROFESSOR'] ?></td>
                    </tr>
                <? } ?>
            </table>

        </div>
        <div class="modal-footer">
            <a class="btn btn-info pull-left" href="<?= SCL_RAIZ ?>coordenador/professor/falta_imprimir?token=<?= $aluno ?>" target="_blank"><i class="fa fa-print"></i> Imprimir </a>
            <button class="btn btn-danger" data-dismiss="modal" id="frmarquivo_btn" ><i class="fa fa-refresh"></i> Fechar </button>
        </div>
    </div>
</div>
<? exit(); ?>

