<div class="panel panel-primary">    
    <table class="table table-bordered table-hover" id="grid-semestre">
        <thead>
            <tr class="panel-heading">
                <th class="text-center">MATRÍCULA</th>
                <th class="text-center">NOME</th>
                <th class="text-center">MÉDIA</th>
                <th class="text-center">SITUAÇÃO</th>
            </tr>
        </thead>

        <tbody class="panel-body">
            <?php
            foreach ($alunos as $row) {
                $media = floatval($row['MEDIA_SEMESTRE']);
                ?>
                <tr class="<?= $media >= 7 ? "success" : "danger" ?>">
                    <td class="text-center"><?= $row['CD_ALUNO'] ?></td>
                    <td class="text-justify"><?= $row['NM_ALUNO'] ?></td>
                    <td class="text-center"><?= $row['MEDIA_SEMESTRE'] ?></td>
                    <td class="text-center"><?= $media >= 7 ? "APROVADO" : "RECUPERAÇÃO" ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php exit(); ?>