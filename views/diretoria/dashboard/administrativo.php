
<script src="<?= SCL_JS ?>highcharts.js"></script>
<script src="<?= SCL_JS ?>exporting.js"></script>

<?
foreach ($inadiplencia as $l) {
    $devedorCategoria .= "'" . $l['MES_REFERENCIA'] . "',";
    $devedorValor .= "{name: 'R$ " . number_format($l['VALOR_INADIMPLENCIA'], 2, ',', '.') . "', y:" . $l['VALOR_INADIMPLENCIA'] . "},";
}

foreach ($aluno_modalidade as $item) {
    $modalidade .= "{ name: '" . $item['DC_MODALIDADE'] . "', y: " . $item['QTD_ALUNOS'] . ", legendIndex: " . $item['CD_MODALIDADE'] . "},";
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

<div id="content" class="col-lg-10 col-sm-11">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header" data-original-title>
                    <h2><i class="fa fa-bar-chart-o"></i><span class="break"></span>Faturamento Mensal </h2>
                </div>
                <div class="box-content">
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
            </div>
        </div>
        <!--/col-->

        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <h2><i class="fa fa-bar-chart-o"></i><span class="break"></span>Alunos inadiplentes</h2>
                </div>
                <div class="box-content">

                    <script>
                        $(function() {
                            $('#inadiplente').highcharts({
                                chart: {
                                    type: 'line'
                                },
                                title: {
                                    text: 'Alunos inadiplentes'
                                },
                                xAxis: {
                                    categories: [<?= $devedorCategoria ?>]
                                },
                                yAxis: {
                                    title: {
                                        text: 'Valores'
                                    }
                                },
                                plotOptions: {
                                    line: {
                                        dataLabels: {
                                            enabled: true,
                                            format: '{point.name}'
                                        },
                                        enableMouseTracking: false
                                    }
                                },
                                series: [{
                                        name: 'Inadiplentes',
                                        data: [<?= $devedorValor ?>]
                                    }]
                            });
                        });
                    </script>


                    <div id="inadiplente" style="height:350px"></div>
<? foreach ($bolsas as $r) { ?>
                        <div id="mdlbolsa<?= $item['CD_MODALIDADE'] . $r['PERCENTUAL'] ?>" class="modal fade" data-remote="<?= SCL_RAIZ ?>/diretoria/dashboard/mdlbolsa?motivo=<?= $r['CD_MOTIVO'] ?>&percentual=<?= $r['PERCENTUAL'] ?>"></div>

<?
}
$bolsaValor = trim($bolsaValor, ",");
?>

                </div>
            </div>
        </div>











        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2><i class="fa fa-bar-chart-o"></i><span class="break"></span>Alunos Matriculados</h2>
                </div>
                <div class="box-content">
                    <? foreach ($aluno_modalidade as $item) { ?>
                        <div id="mdlalunomodalidade<?= $item['CD_MODALIDADE'] ?>" class="modal fade">
                            <div class="modal-dialog" style="width:100%">
                                <div class="modal-content">
                                    <div class="modal-header btn-info">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title">ALUNOS NA MODALIDADE {
                                            <?= $item['DC_MODALIDADE'] ?>
                                            } </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table table-condensed" id="grdAlunoModalidade<?= $item['CD_MODALIDADE'] ?>">
                                                <thead>
                                                    <tr>
                                                        <th>MatrÃ­cula</th>
                                                        <th>Aluno</th>
                                                        <th>Curso</th>
                                                        <th>SÃ©rie</th>
                                                        <th>Turno</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?
                                                    foreach ($alunos as $r) {
                                                        if ($r['CD_MODALIDADE'] == $item['CD_MODALIDADE']) {
                                                            ?>
                                                            <tr>
                                                                <td><?= $r['CD_ALUNO'] ?></td>
                                                                <td class="center"><?= $r['NM_ALUNO'] ?></td>
                                                                <td class="center"><?= $r['NM_CURSO_RED'] ?></td>
                                                                <td class="center"><?= $r['NM_SERIE'] ?></td>
                                                                <td class="center"><?= $r['DC_TURNO'] ?></td>
                                                            </tr>
                                                        <? }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                    </div>
                                </div>
                                <!-- /.modal-content --> 
                            </div>
                        </div>
                        <script>

                            $('#grdAlunoModalidade<?= $item['CD_MODALIDADE'] ?>').dataTable({
                                "sPaginationType": "full_numbers"
                            });

                            jQuery(function($) {
                                $('[data-rel=tooltip]').tooltip();
                                $('[data-rel=popover]').popover({html: true});
                            });
                        </script>
<? } ?>



                    <div id="modalidade" style="height:500px"></div>

                    <script>
                        $(function() {
                            var chart;

                            $(document).ready(function() {

                                // Build the chart
                                $('#modalidade').highcharts({
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false
                                    },
                                    credits: {
                                        enabled: false
                                    },
                                    title: {
                                        text: 'Alunos Matriculados | <?= $this->session->userdata('SCL_SSS_USU_PERIODO') ?> '
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                format: '<b>{point.name}</b>: {point.y} {point.percentage:.1f}%'
                                            },
                                            showInLegend: true
                                        }
                                    },
                                    series: [{
                                            type: 'pie',
                                            name: 'Total de Alunos',
                                            data: [<?= $modalidade ?>],
                                            point: {
                                                events: {
                                                    click: function() {
                                                        $('#mdlalunomodalidade' + this.legendIndex).modal('show');
                                                    }
                                                }
                                            }

                                        }]
                                });
                            });

                        });
                    </script> 
                </div>
            </div>
        </div>
        <!--/col-->
        <?
        foreach ($bolsas as $r) {
            $bolsaValor .= "{ name: '" . $r['DC_MOTIVO'] . "', y: " . $r['QTD_ALUNOS'] . " , legendIndex: " . $r['CD_MOTIVO'] . $r['PERCENTUAL'] . "},";
            ?>
            <div id="mdlbolsa<?= $item['CD_MODALIDADE'] . $r['PERCENTUAL'] ?>" class="modal fade" data-remote="<?= SCL_RAIZ ?>/diretoria/dashboard/mdlbolsa?motivo=<?= $r['CD_MOTIVO'] ?>&percentual=<?= $r['PERCENTUAL'] ?>"></div>

        <?
        }
        $bolsaValor = trim($bolsaValor, ",");
        ?>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2><i class="fa fa-bar-chart-o"></i><span class="break"></span>Bolsas de Estudo</h2>
                </div>
                <div class="box-content">

                    <script>
                        $(function() {
                            var chart;

                            $(document).ready(function() {

                                // Build the chart
                                $('#bolsas_de_estudo').highcharts({
                                    chart: {
                                        plotBackgroundColor: null,
                                        plotBorderWidth: null,
                                        plotShadow: false
                                    },
                                    credits: {
                                        enabled: false
                                    },
                                    title: {
                                        text: 'Bolsas de Estudos | <?= $this->session->userdata('SCL_SSS_USU_PERIODO') ?> '
                                    },
                                    plotOptions: {
                                        pie: {
                                            allowPointSelect: true,
                                            cursor: 'pointer',
                                            dataLabels: {
                                                enabled: true,
                                                format: '<b>{point.name}</b>: {point.y} {point.percentage:.1f}%'
                                            },
                                            showInLegend: true
                                        }
                                    },
                                    series: [{
                                            type: 'pie',
                                            name: 'Total de Alunos',
                                            data: [<?= $bolsaValor ?>],
                                            point: {
                                                events: {
                                                    click: function() {
                                                        $('#mdlbolsa' + this.legendIndex).modal('show');
                                                    }
                                                }
                                            }
                                        }]
                                });
                            });

                        });
                    </script>


                    <div id="bolsas_de_estudo" style="height:500px"></div>
                    <? foreach ($bolsas as $r) { ?>
                        <div id="mdlbolsa<?= $item['CD_MODALIDADE'] . $r['PERCENTUAL'] ?>" class="modal fade" data-remote="<?= SCL_RAIZ ?>/diretoria/dashboard/mdlbolsa?motivo=<?= $r['CD_MOTIVO'] ?>&percentual=<?= $r['PERCENTUAL'] ?>"></div>

                    <?
                    }
                    $bolsaValor = trim($bolsaValor, ",");
                    ?>

                </div>
            </div>
        </div>
        <!--/col--> 

    </div>
    <!--/row--> 
</div>
<? exit(); ?>