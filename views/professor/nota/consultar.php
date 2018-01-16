<div class="modal-header btn-primary">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" style="font-weight: bold">Visualização de Notas</h4>
</div>

<div class="modal-body">
    <p class="text-center" style="font-weight: bold">
        <?= $nota ?>
    </p>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">Matrícula</th>
                <th class="text-center">Aluno</th>
                <th class="text-center">Nota</th>
            </tr>
        </thead>

        <tbody>
            <?php
            if (count($alunos) > 0) :
                foreach ($alunos as $aluno) :
                    ?>
                    <tr>
                        <td class="text-center"><?= $aluno->CD_ALUNO ?></td>
                        <td class="text-center"><?= $aluno->NM_ALUNO ?></td>
                        <td class="text-center">                    
                            <?php
                            $valor = $aluno->NOTA;

                            if (empty($valor)) {
                                echo "-";
                            } else {
                                echo $valor;
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                endforeach;
            endif;
            ?> 
        </tbody>
    </table>
</div>

<?php exit(); ?>