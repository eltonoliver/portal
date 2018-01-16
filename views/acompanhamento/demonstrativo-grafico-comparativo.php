<?php
$bimestres = "";
$notasP1 = "";
$notasP2 = "";

$aux = "";
foreach ($registros as $row) {
    if ($row['BIMESTRE'] != $aux) {
        $bimestres .= "'" . $row['BIMESTRE'] . "º Bimestre', ";
        $aux = $row['BIMESTRE'];
    }

    if ($row['NM_MINI'] == "P1") {
        $notasP1 .= number_format($row['NOTA'], 1, '.', '') . ", ";
    }

    if ($row['NM_MINI'] == "P2") {
        $notasP2 .= number_format($row['NOTA'], 1, '.', '') . ", ";
    }
}
?>

<script type='text/javascript'>//<![CDATA[
    $(function () {
        $('#grafico-comparativo').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: [<?= $bimestres ?>],
                crosshair: true
            },
            yAxis: {
                min: 0,
                max: 10,
                title: {
                    text: 'Nota'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
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
            series: [
                {
                    name: "P1",
                    data: [<?= $notasP1 ?>]
                },
                {
                    name: "P2",
                    data: [<?= $notasP2 ?>]
                }
            ]
        });
    });
//]]> 

</script>

<div class="row">
    <div class="col-xs-12">
        <div id="grafico-comparativo"></div>
    </div>
</div>

<?php exit(); ?>