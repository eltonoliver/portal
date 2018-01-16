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

<?php
foreach ($provas as $p) {
    $total = (($p['QTDE_QUESTOES'] == 24) ? $p['QTDE_QUESTOES'] - 4 : $p['QTDE_QUESTOES']);
    ?>
    <table style="width: 100%" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center" colspan="<?= $total + 1 ?>" style="background:#F5F5F5" height="30">
                    <?= $p['NUM_PROVA'] . ' - ' . $p['BIMESTRE'] . 'º BIMESTRE - (' . $p['NM_MINI'] . ') - ' . $p['DISCIPLINAS'] ?>
                </th>
            </tr>
        </thead>

        <tbody>                        
            <?php
            //indica quantas colunas para resposta do gabarito 
            //vai ter na tabela
            $colunas = 20;
            for ($j = 0; $j < $total; $j = $j + $colunas) {
                $pagina = $j + $colunas;

                if ($total < $colunas) {
                    $pagina = $total;
                }
                ?>
                <tr  style="border:solid 1px #000">
                    <td style="background:#A3A3A3">QUESTÕES</td>
                    <?php
                    for ($i = $j; $i < $pagina; $i++) {
                        ?>
                        <td align="center" style="background:#A3A3A3"><?= $i + 1 ?></td>
                    <?php } ?>
                </tr>

                <tr  style="border:solid 1px #000">
                    <td style="background:#A3A3A3">GABARITO</td>
                    <?php
                    for ($i = $j; $i < $pagina; $i++) {
                        ?>
                        <td align="center" style="background:#A3A3A3"><?= substr($p['GABARITO'], $i, 1) ?></td>
                    <?php } ?>
                </tr>

                <tr>
                    <td style="background:#A3A3A3;">RESPOSTAS</td>
                    <?php
                    for ($i = $j; $i < $pagina; $i++) {
                        ?>
                        <td align="center" style="background:<?= ((substr($p['GABARITO'], $i, 1) == substr($p['RESPOSTAS'], $i, 1) ? '#E8F3FF' : '#FBE3E6')) ?>"><?= substr($p['RESPOSTAS'], $i, 1) ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td colspan="<?= $total + 1 ?>"></td>
                </tr>
            <?php } ?>
        </tbody>    
    </table>
    <br>        
<?php } ?>

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