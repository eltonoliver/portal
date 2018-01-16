<? $this->load->view('layout/header'); 

$dia = array();
$aluno = array();
foreach ($listar as $row) {
    $dia[] = $row['DT_AULA'];
    $diaaluno[] = $row['CD_ALUNO'].':'.$row['DT_AULA'].':'.$row['FALTAS'];
    $aluno[] = $row['CD_ALUNO'].':'.$row['NM_ALUNO'].':'.$row['NM_RESPONSAVEL'].':'.$row['TEL1'].':'.$row['TEL2'].':'.$row['TEL3'];
}
$dia = array_keys(array_flip($dia));

$diaaluno = array_keys(array_flip($diaaluno));
$aluno = array_keys(array_flip($aluno));
?>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Relação dos Alunos Faltosos</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>MATRÍCULA</th>
                                <th>NOME</th>
                                <th>RESPONSÁVEL</th>
                                <th style="text-align: center">TEL - 1</th>
                                <th style="text-align: center">TEL - 2</th>
                                <th style="text-align: center">TEL - 3</th>
                                <? 
                                foreach ($dia as $row) { ?>
                                <th style="text-align: center"><?=date('d/m/Y', strtotime($row))?></th>
                                <? } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($aluno as $row) { 
                                $item = explode(':',$row);
                                ?>
                                <tr class="" style="font-size:10px">
                                    <td><?= $item[0] ?></td>
                                    <td><?= $item[1] ?></td>
                                    <td><?= $item[2] ?></td>
                                    <td style="text-align: center"><?= $item[3] ?></td>
                                    <td style="text-align: center"><?= $item[4] ?></td>
                                    <td style="text-align: center"><?= $item[5] ?></td>
                                    <? 
                                    //print_r($diaaluno);
                                    foreach ($dia as $row) {
                                        ?>
                                    <th style="text-align: center">
                                        <? foreach ($diaaluno as $r) {
                                           $s = explode(':',$r);
                                           $falta = 0;

                                           if($row == $s[1] && $s[0] == $item[0])
                                           //if(in_array($row, $r) && in_array($item[0], $r))
                                                echo $s[2];
                                           else
                                               echo '';
                                        }?></th>
                                    <? } ?>
                                </tr>
                            <? } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<? $this->load->view('layout/footer'); ?>
