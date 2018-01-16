<table class="table table-striped table-hover">
    <thead>
        <tr class="panel-footer">
            <td></td>
            <td>LISTA DE ALUNOS DA TURMA :: <?=$lista[0]['CD_TURMA']?></td>
        </tr>
    </thead>
    <tbody>
        <? foreach ($lista as $row) { ?>
            <tr height="10px">
                <td></td>
                <td>
                    <div class="checkbox checkbox-info no-margins">
                        <input name="avalAlunoInscrito[]" checked="checked" id="checkbox<?=$row['CD_ALUNO']?>" type="checkbox">
                        <label for="checkbox<?=$row['CD_ALUNO']?>">
                            <?= $row['CD_TURMA'].' - '.$row['CD_ALUNO'].' - <strong>'.$row['NM_ALUNO'].'</strong>'?>
                        </label>
                    </div>
                </td>
            </tr>
        <? } ?>
    </tbody>
</table>