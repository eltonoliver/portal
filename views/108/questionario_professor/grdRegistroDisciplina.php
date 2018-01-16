<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?=base_url('assets/js/highcharts.js')?>"></script>

 <?
    $profs = array();
    $dado = array();
    $topico = array();
    
    foreach ($lista as $row) {
        $profs[] = $row['NM_PROFESSOR'];
        $topico[] = $row['DC_DIVISAO'].' '.$row['BIMESTRE'].'º Bimestre';
    }
    $profs = array_keys(array_flip($profs));
    $topico = array_keys(array_flip($topico));
    
    $item = '';
    foreach ($topico as $t) {
        $item = (($item == '')? '' : $item.',' ).'"'.$t.'"';
    }
    
    foreach ($profs as $p) {
        
        $diccs = array();
        foreach ($lista as $row) {
            if($row['NM_PROFESSOR'] == $p){
                $al = ($row['MUITO_SATISFEITO'] +
                        $row['INSUFICIENTE'] +
                        $row['REGULAR'] +
                        $row['BOM'] +
                        $row['EXCELENTE']
                    );
                $diccs[] = (int)$al;
            }
        }
        $data[] = array(
            'name' => trim($p),
            'data' => json_encode($diccs),
        );
    }
    
    $dados = json_encode($data);

    // Tratamento para json numérico
    $dados = str_replace('"data":"[','"data":[',$dados);
    $dados = str_replace(']"},{"name"',']},{"name"',$dados);
    $dados = str_replace(']"}]',']}]',$dados);
    
?>


<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<table class="display table table-hover" id="tblGrid">
    <?
    $pro = '';
    $dic = '';
    foreach ($lista as $row) {
        $al = ($row['MUITO_SATISFEITO'] +
                $row['INSUFICIENTE'] +
                $row['REGULAR'] +
                $row['BOM'] +
                $row['EXCELENTE']
                );

        if ($pro != $row['CD_PROFESSOR'] || $dic != $row['CD_DISCIPLINA']) {
            $pro = $row['CD_PROFESSOR'];
            $dic = $row['CD_DISCIPLINA'];
            ?>
            <tr class="panel-footer">
                <td colspan="6"><strong><?= $row['NM_PROFESSOR'] . ' - ' . $row['NM_DISCIPLINA'] ?></strong></td>
            </tr>
            <tr class="panel-footer">
                <td><br><strong>TÓPICO</strong></td>
                <td align="center"> MUITO <br>INSATISFEITO</td>
                <td align="center" valign="botton"> <br>INSUFICIENTE</td>
                <td align="center"> <br>REGULAR</td>
                <td align="center"> <br>BOM</td>
                <td align="center"> <br>EXCELENTE</td>
            </tr>
        <? } ?>
        <?php
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
            <td><?= $row['DC_DIVISAO'] ?></td>
            <td align="center"><?= number_format(($row['MUITO_SATISFEITO'] * 100) / $al, 1, '.', '') ?>%</td>
            <td align="center"><?= number_format(($row['INSUFICIENTE'] * 100) / $al, 1, '.', '') ?>%</td>
            <td align="center"><?= number_format(($row['REGULAR'] * 100) / $al, 1, '.', '') ?>%</td>
            <td align="center"><?= number_format(($row['BOM'] * 100) / $al, 1, '.', '') ?>%</td>
            <td align="center"><?= number_format(($row['EXCELENTE'] * 100) / $al, 1, '.', '') ?>%</td>
        </tr>
    <? } ?>
</table>

<div class="row">
    <div class="col-md-6 pull-left">
        <label>Legenda:</label>
        <button class="btn alert-success">1º Bimestre</button>
        <button class="btn alert-warning">2º Bimestre</button>
        <button class="btn alert-info">3º Bimestre</button>
        <button class="btn alert-danger">4º Bimestre</button>    
    </div>

    <div class="col-md-6 pull-right text-right">        
        <a class="btn btn-primary" href="<?= $urlRelatorio ?>" target="_blank" data-method="post">
            Gerar Relatório
        </a>    
    </div>
</div>

<script type='text/javascript'>
$(function () {

    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Avaliação Institucional'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [<?=$item?>],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total (pt)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} pt</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: <?=$dados?>
    });

});
</script>

<script type="text/javascript">
    $('[data-toggle="frmModalInfo"]').on('click',
            function (e) {
                $('#frmModalInfo').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade hmodal-danger no-padding"  id="frmModalInfo"  tabindex="-1" role="dialog" ><div class="modal-dialog no-padding" ><div class="modal-content no-padding"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
</script>