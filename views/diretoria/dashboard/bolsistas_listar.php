<link href="<?= SCL_CSS ?>bootstrap.min.css?v=3.1.0" rel="stylesheet" />
<table class="table table-striped table-bordered">
    <thead class="well">
        <tr>
            <th colspan="5" style="padding: 5px; background:#CCC" align='center'>
                <h3> :: Lista de Bolsistas ::</h3>  Total de Bolsistas (<?=count($bolsistas)?>)
            </th>
        </tr>
        <tr>
            <th style="padding: 5px; background:#CCC">ALUNO</th>
            <th style="padding: 5px; background:#CCC">RESPONSÁVEL</th>
            <th style="padding: 5px; background:#CCC">MOTIVO</th>
            <th style="padding: 5px; background:#CCC">TIPO</th>
            <th style="padding: 5px; background:#CCC">BOLSA %</th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($bolsistas as $row) { 
            if($row['PERCENTUAL'] == '100'){
                $cor = '#F8DBAF'; //Laranja claro
            }else{
                $cor = '#CFE8FA'; //Azul
            }
            
            ?>
            <tr>
                <td style="font-size:10px; padding: 5px; background:<?=$cor?>"><?= $row['CD_ALUNO'].' - '.$row['NM_ALUNO']?></td>
                <td style="font-size:10px; padding: 5px; background:<?=$cor?>"><?= $row['NM_RESPONSAVEL']?></td>
                <th style="font-size:10px ;padding: 5px; background:<?=$cor?>"><?= $row['DC_MOTIVO']?></th>
                <td style="font-size:10px; padding: 5px; background:<?=$cor?>"><?= $row['DC_TURNO']?></td>
                <td style="font-size:10px; padding: 5px; background:<?=$cor?>"><?= $row['PERCENTUAL']?>%</td>
            </tr>
        <? } ?>
    </tbody>
</table>
<? //exit();?>