<div class="container" style="font-family: Arial, Helvetica, sans-serif">    
    <div class="row">
        <div class="col-sm-12" style="font-weight: bold">        
            <h3 class="text-center">Avaliação Institucional do Professor</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="font-weight: bold">
            <p class="text-center"><?= $professor ?></p>
            <p class="text-center"><?= $disciplina ?></p>
            <p class="text-center"><?= $turma ?></p>
        </div>
    </div>


    <div class="text-center" style="padding: 20px">
        <table class="table table-bordered" >
            <thead>
                <tr>
                    <th style="width: 15%" class="text-center">BIMESTRE</th>
                    <th style="width: 15%" class="text-center">TÓPICO</th>
                    <th style="width: 15%" class="text-center">MUITO INSASTIFEITO</th>
                    <th style="width: 15%" class="text-center">INSUFICIENTE</th>
                    <th style="width: 15%" class="text-center">REGULAR</th>
                    <th style="width: 10%" class="text-center">BOM</th>
                    <th style="width: 15%" class="text-center">EXCELENTE</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($resultado as $row) :
                    $al = ($row['MUITO_SATISFEITO'] +
                            $row['INSUFICIENTE'] +
                            $row['REGULAR'] +
                            $row['BOM'] +
                            $row['EXCELENTE']
                            );

                    $corLinha = "";
                    switch ($row['BIMESTRE']) {
                        case 1:
                            $corLinha = "success";
                            break;
                        case 2:
                            $corLinha = "warning";
                            break;
                        case 3:
                            $corLinha = "info";
                            break;
                        case 4:
                            $corLinha = "danger";
                            break;
                        default:
                            $corLinha = "";
                    }
                    ?>
                    <tr class="<?= !empty($corLinha) ? $corLinha : "" ?>">
                        <td class="text-center"><?= $row['BIMESTRE'] ?></td>
                        <td class="text-justify" style="padding: 5px"><?= $row['DC_DIVISAO'] ?></td>
                        <td class="text-center"><?= number_format(($row['MUITO_SATISFEITO'] * 100) / $al, 1, '.', '') ?>%</td>
                        <td class="text-center"><?= number_format(($row['INSUFICIENTE'] * 100) / $al, 1, '.', '') ?>%</td>
                        <td class="text-center"><?= number_format(($row['REGULAR'] * 100) / $al, 1, '.', '') ?>%</td>
                        <td class="text-center"><?= number_format(($row['BOM'] * 100) / $al, 1, '.', '') ?>%</td>
                        <td class="text-center"><?= number_format(($row['EXCELENTE'] * 100) / $al, 1, '.', '') ?>%</td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>