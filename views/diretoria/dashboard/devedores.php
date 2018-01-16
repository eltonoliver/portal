<div class="modal-header btn-info">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><i class="fa fa-user"></i> Devedores do mês de </h3>
</div>

<div class="modal-body">
    <div class="tab-pane" id="pill-generico">
        <div class="well" style="margin: 20px 0;">
            <table class="table table-condensed" id="grdAlunoModalidade<?= $item['CD_MODALIDADE'] ?>">
                <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Aluno</th>
                        <th>Curso</th>
                        <th>Série</th>
                        <th>Turno</th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    foreach ($alunos as $r) {
                        if ($r['CD_MODALIDADE'] == $item['CD_MODALIDADE']) {
                            ?>
                            <tr>
                                <td><?= $r['CD_ALUNO'] ?></td>
                                <td class="center"><?= $r['NM_ALUNO'] ?></td>
                                <td class="center"><?= $r['NM_CURSO_RED'] ?></td>
                                <td class="center"><?= $r['NM_SERIE'] ?></td>
                                <td class="center"><?= $r['DC_TURNO'] ?></td>
                            </tr>
    <? }
} ?>
                </tbody>
            </table>
        </div>
    </div>
    <? if(count($alunos) > 10){?>
    <script>

        $('#grdAlunoModalidade<?= $item['CD_MODALIDADE'] ?>').dataTable({
            "sPaginationType": "full_numbers"
        });

    </script>
    <? } ?>
</div>
<div class="modal-footer">
    <button class="btn btn-danger" data-dismiss="modal" id="frmarquivo_btn" ><i class="fa fa-refresh"></i> Fechar </button>
</div>
<? exit(); ?>

