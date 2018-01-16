
<?
foreach ($inadiplencia as $l) {
    $devedorCategoria .= "'" . $l['MES_REFERENCIA'] . "',";
    $devedorValor .= "{name: 'R$ " . number_format($l['VALOR_INADIMPLENCIA'], 2, ',', '.') . "', y:" . $l['VALOR_INADIMPLENCIA'] . "},";
}

foreach ($faturamento as $r) {
    $faturamentoTexto .= "'" . $r['MES_REFERENCIA'] . "',";
    $VEMITIDO .= "" . $r['VALOR_EMITIDO'] . ",";
    $VRECEBIDO .= "" . $r['VALOR_RECEBIDO'] . ",";
    $VRECEBER .= "" . $r['VALOR_RECEBER'] . ",";


    $faturamentoValorEmitido .= "{ name: 'R$ " . number_format($r['VALOR_EMITIDO'], 2, ',', '.') . "', y: " . $r['VALOR_EMITIDO'] . "},";
    $faturamentoValorRecebido .= "{ name: 'R$ " . number_format($r['VALOR_RECEBIDO'], 2, ',', '.') . "', y: " . $r['VALOR_RECEBIDO'] . "},";
    $faturamentoValorReceber .= "{ name: 'R$ " . number_format($r['VALOR_RECEBER'], 2, ',', '.') . "', y: " . $r['VALOR_RECEBER'] . "},";

    //$FQUANT_EMITIDO .= "".$r['QUANT_EMITIDO'].",";
    //$FQUANT_RECEBIDO .= "".$r['QUANT_RECEBIDO'].",";
    //$FQUANT_RECEBER .= "".$r['QUANT_RECEBER'].",";
}

$devedorCategoria = trim($devedorCategoria, ",");
$devedorValor = trim($devedorValor, ",");

$modalidade = trim($modalidade, ",");

$FMES = trim($FMES, ",");

$FQUANT_EMITIDO = trim($FQUANT_EMITIDO, ",");
$FQUANT_RECEBIDO = trim($FQUANT_RECEBIDO, ",");
$FQUANT_RECEBER = trim($FQUANT_RECEBER, ",");
?>

<div class="col-sm-12">

    <div class="col-xs-12">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Faturamento Mensal</h3>
            </div>
            <div class="panel-body">
                <div id="FFaturamento" style="height: 350px;"></div>
                <script type="text/javascript">
                    $(function() {

                        // First, let's make the colors transparent
                        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
                            return Highcharts.Color(color)
                                    .setOpacity(0.5)
                                    .get('rgba');
                        });

                        $('#FFaturamento').highcharts({
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Faturamento Mensal'
                            },
                            xAxis: {
                                categories: [<?= $faturamentoTexto ?>]
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: 'Valores R$ '
                                }
                            },
                            legend: {
                                backgroundColor: '#FFFFFF',
                                shadow: true
                            },
                            tooltip: {
                                shared: true,
                                valuePrefix: 'R$ '
                            },
                            plotOptions: {
                                column: {
                                    grouping: false,
                                    shadow: false
                                }
                            },
                            series: [{
                                    name: 'Emitidos',
                                    data: [<?= $VEMITIDO ?>],
                                    pointPadding: 0

                                }, {
                                    name: 'Recebidos',
                                    data: [<?= $VRECEBIDO ?>],
                                    pointPadding: 0.1

                                }, {
                                    name: 'A Receber',
                                    data: [<?= $VRECEBER ?>],
                                    pointPadding: 0.2

                                }]
                        });
                    });
                </script>
            </div>
            <div class="panel-footer">
                <!--a href="#" class="btn btn-primary left">Impressão</a-->
            </div>
        </div>
    </div>




    <div class="col-xs-12">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Alunos Inadimplentes</h3>
            </div>
            <div class="panel-body">
                <script>
                    $(function() {
                        $('#inadiplente').highcharts({
                            xAxis: {
                                categories: [<?= $devedorCategoria ?>]
                            },
                            title: {
                                text: 'Alunos inadimplentes'
                            },
                            yAxis: {
                                title: {
                                    text: 'Valores (R$)'
                                }
                            },
                            plotOptions: {
                                series: {
                                    cursor: 'pointer',
                                    allowPointSelect: true,
                                    dataLabels: {
                                        enabled: true,
                                        format: '{point.name}'
                                    },
                                    point: {
                                        events: {
                                            click: function() {
                                                //alert(this.category.replace('/',''));
                                                $('#mdldevedores' + this.category.replace('/', '')).modal('show');
                                            }
                                        }
                                    }
                                }
                            },
                            series: [{
                                    name: 'Inadiplência',
                                    data: [<?= $devedorValor ?>]
                                }]
                        });
                    });
                </script>


                <div id="inadiplente" style="height:350px"></div>
                <? foreach ($inadiplencia as $r) { ?>
                    <div id="mdldevedores<?= str_replace('/', '', $r['MES_REFERENCIA']) ?>" class="modal fade" data-remote="<?= SCL_RAIZ ?>diretoria/dashboard/mdldevedor?ref=<?= str_replace('', '', $r['MES_REFERENCIA']) ?>" data-backdrop="static" data-keyboard="false" >
                        <div class="modal-dialog" style="width:80%">
                            <div class="modal-content">
                            </div><!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                    <?
                }
                $bolsaValor = trim($bolsaValor, ",");
                ?>
            </div>
            <div class="panel-footer">
                <!--a href="#" class="btn btn-primary">Impressão</a-->
            </div>
        </div>
    </div>
</div>


<? exit(); ?>