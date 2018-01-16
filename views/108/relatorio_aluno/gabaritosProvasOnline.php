<hr>

<table style="width: 100%">
    <tbody>
        <tr>
            <td style="text-align: center">
                <h2 style="text-align: center"><?= $aluno[0]['NM_ALUNO'] ?></h2>
            </td>
        </tr>

        <tr>
            <td style="text-align: center">
                <h3 style="text-align: center"><?= $aluno[0]['CD_ALUNO'] ?></h3>
            </td>
        </tr>
</table>

<br>

<table style="width: 100%">
    <tbody>
        <tr>
            <td style="text-align: center">
                <h3>ACOMPANHAMENTO DE PROVAS</h3><br/>
            </td>
        </tr>

        <tr>
            <td style="text-align: center; color: red; font-weight: bold">
                <p>
                    Cuidado, não compare seu gabarito com os demais alunos de sua sala.<br>
                    São geradas versões de provas diferentes e você pode estar comparando sua prova com um 
                    gabarito diferente.
                </p>
            </td>
        </tr>
    </tbody>
</table>

<br>

<div style="display: block">
    <?php foreach ($provas as $row): ?>
        <div style="width: 45%; padding-left: 30px; float: left; margin-bottom: 30px">
            <table style="text-align: center; border: 1px solid black; border-collapse: collapse; width: 100%">
                <thead>
                    <tr style="background: gainsboro; border: 1px solid black">
                        <th style="text-align: center" colspan="4">
                            <?= $row['NUM_PROVA'] . ' - ' . $row['BIMESTRE'] . 'º BIMESTRE - (' . $row['NM_MINI'] . ') - ' . $row['DISCIPLINAS'] ?>
                        </th>                    
                    </tr>

                    <tr style="background: gainsboro">
                        <th style="text-align: center; border: 1px solid black">QUESTÃO</th>
                        <th style="text-align: center; border: 1px solid black">GABARITO</th>
                        <th style="text-align: center; border: 1px solid black">RESPOSTA</th>
                        <th style="text-align: center; border: 1px solid black">TEMPO GASTO</th>                        
                    </tr>                    
                </thead>

                <tbody>
                    <?php foreach ($row['QUESTOES'] as $questao): ?>
                        <tr>
                            <td style="border: 1px solid black"><?= $questao['POSICAO'] ?></td>
                            <td style="border: 1px solid black"><?= $questao['CORRETA'] ?></td>
                            <td style="border: 1px solid black; background: <?= $questao['CORRETA'] == $questao['RESPOSTA'] ? "#77cd4c" : "#ff6666" ?>">
                                <?= $questao['RESPOSTA'] ?>
                            </td>
                            <td style="border: 1px solid black"><?= $questao['NR_TEMPO_RESPOSTA'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>    
</div>     

<fieldset style="padding-left: 30px;">
    <legend style="font-weight: bold;">Legenda</legend>    
    <div style="margin-top: 10px;">
        <div><span style="background-color: #77cd4c">&nbsp;&nbsp;&nbsp;&nbsp;</span> Acertou a questão</div>
        <div><span style="background-color: #ff6666">&nbsp;&nbsp;&nbsp;&nbsp;</span> Errou a questão</div>
        <div> *  Questão anulada</div>
        <div> #  Questão cancelada</div>               
        <div> Z  Questão não marcada</div>               
    </div>
</fieldset>