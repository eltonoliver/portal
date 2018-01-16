<div class="modal-header btn-info">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 class="modal-title">LISTA DE ALUNOS DA TURMA</h3>
</div>


<div class="modal-body">
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th class="text-center">Matrícula</th>
                <th class="text-center">Aluno</th>                    
            </tr>
        </thead>

        <tbody>
            <?php foreach ($alunos as $row): ?>
                <tr>
                    <td class="text-center"><?= $row['CD_ALUNO'] ?></td>
                    <td class="text-center"><?= $row['NM_ALUNO'] ?></td>                    
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2" class="text-center">
                    <strong>Total de <?= count($alunos) ?> alunos</strong>
                </td>
            </tr>
        </tfoot>
    </table>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Fechar</button>    
</div>

<?php exit(); ?>