<div class="row">
    <div class="col-md-12">
        <?php if (count($provas) == 0): ?>
            <p>Sem gabaritos para o bimestre informado.</p>
        <?php else: ?>
            <div class="row">            
                <?php foreach ($provas as $row): ?>
                    <div class="col-md-6">
                        <table class="table table-bordered table-hover text-center">
                            <thead>
                                <tr style="background: gainsboro">
                                    <th class="text-center" colspan="4">
                                        <?= $row['NUM_PROVA'] . ' - ' . $row['BIMESTRE'] . 'º BIMESTRE - (' . $row['NM_MINI'] . ') - ' . $row['DISCIPLINAS'] ?>
                                    </th>                    
                                </tr>

                                <tr style="background: gainsboro">
                                    <th class="text-center">QUESTÃO</th>
                                    <th class="text-center">GABARITO</th>
                                    <th class="text-center">RESPOSTA</th>
                                    <th class="text-center">TEMPO GASTO</th>                        
                                </tr>                    
                            </thead>

                            <tbody>
                                <?php foreach ($row['QUESTOES'] as $questao): ?>
                                    <tr>
                                        <td><?= $questao['POSICAO'] ?></td>
                                        <td><?= $questao['CORRETA'] ?></td>
                                        <td style="background: <?= $questao['CORRETA'] == $questao['RESPOSTA'] ? "#77cd4c" : "#ff6666" ?>">
                                            <?= $questao['RESPOSTA'] ?>
                                        </td>
                                        <td><?= $questao['NR_TEMPO_RESPOSTA'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="panel-footer">
                <fieldset>
                    <legend>Legenda</legend>
                    <div><span style="background-color: #77cd4c">&nbsp;&nbsp;&nbsp;&nbsp;</span> Acertou a questão.</div>
                    <div><span style="background-color: #ff6666">&nbsp;&nbsp;&nbsp;&nbsp;</span> Errou a questão.</div>
                    <div>( * ) Questão anulada.</div>
                    <div>( # ) Questão cancelada.</div>               
                    <div>( Z ) Questão não marcada.</div>               
                </fieldset>
            </div>            
        <?php endif; ?>
    </div>
</div>

<?php exit(); ?>