<div class="modal-header <?= ($hasAluno && !$hasChamadaRealizada) ? "btn-danger" : "btn-success" ?>">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 class="modal-title">LISTA DE CHAMADA</h3>
</div>

<form action="<?= site_url('professor/diario_retroativo/salvar_frequencia') ?>" method="post">
    <div class="modal-body">
        <input type="hidden" name="data" value="<?= $dataPendencia ?>">
        <?php if ($hasAluno && !$hasChamadaRealizada): ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="alert alert-danger">
                        Professor(a), a chamada não foi confirmada. Por favor, confirme para salvar.
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <input type="hidden" name="aula" value="<?= $aula ?>">

        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th class="text-center">Matrícula</th>
                    <th class="text-center">Aluno</th>                    
                    <th class="text-center" colspan="2">Frequência</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($alunos as $row): ?>
                    <tr>
                        <td class="text-center"><?= $row['CD_ALUNO'] ?></td>
                        <td class="text-center"><?= $row['NM_ALUNO'] ?></td>
                        <td class="text-center <?= $row['FLG_PRESENTE'] == 'S' ? "success" : "" ?>">
                            <input type="radio" name="<?= $row['CD_ALUNO'] ?>" value="S" <?= $row['FLG_PRESENTE'] == "S" ? "checked='checked'" : "" ?>> SIM
                        </td>
                        <td class="text-center <?= $row['FLG_PRESENTE'] == 'N' ? "danger" : "" ?>">
                            <input type="radio" name="<?= $row['CD_ALUNO'] ?>" value="N" <?= $row['FLG_PRESENTE'] == "N" ? "checked='checked'" : "" ?>> NÃO
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="4" class="text-center">
                        <strong>Total de <?= count($alunos) ?> alunos</strong>
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>

        <?php if ($hasAluno): ?>
            <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Confirmar</button>
        <?php endif; ?>
    </div>
</form>


<?php exit(); ?>