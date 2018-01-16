<? $this->load->view('layout/header'); ?>
<script src="<?= SCL_JS ?>highcharts.js"></script>
<script src="<?= SCL_JS ?>exporting.js"></script>
<?
$dataseries = '';
$total = '';
foreach ($grafico as $r) {
    $dataseries .= "['" . $r['DC_TIPO_USUARIO'] . "'," . $r['TOTAL'] . "],";
    $total = $r['TOTAL'] + $total;
    // $faturamentoValorEmitido .= "{ name: 'R$ " . number_format($r['VALOR_EMITIDO'], 2, ',', '.') . "', y: " . $r['VALOR_EMITIDO'] . "},";
}
?>
<div id="content" class="col-sm-12">

    <div class="col-sm-12">
        <form name="frmFiltro">
            <div class="form-group">
                <div class="col-xs-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        <input type="text" id="data" name="data" class="form-control" value="<?= date('d/m/Y') ?>">
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <select class="form-control" name="tipo" id="tipo">
                            <option value="NULL">TODOS</option>
                            <option value="A">ALUNOS</option>
                            <option value="F">FUNCIONÁRIOS</option>
                            <option value="R">RESPONSÁVEIS</option>
                            <option value="P">PROFESSORES</option>
                            <option value="V">VISITANTES</option>
                            <option value="T">TERCEIROS</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </span>
                        <select class="form-control" name="tipo" disable>
                            <option value="4000">4 Segundos</option>
                            <option value="10000">1 minuto</option>
                            <option value="20000">2 minutos</option>
                            <option value="100000">10 minutos</option>
                            <option value="300000">30 Minutos</option>
                        </select>
                    </div>
                </div>
            </div> 
        </form>
    </div>

    <hr />
    <hr />
    <div class="col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Entrada de Usuários</h3>
            </div>
            <div  id="entrada">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">Saída de Usuários</h3>
            </div>
            <div  id="saida">
            </div>

        </div>
    </div>
    
    
    <div class="col-xs-12"> 
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Gráficos</h3>
            </div>
            <div class="panel-body" id="graficos">

                <div id="container"></div>
                <script type="text/javascript">
                    $(function() {
                        // First, let's make the colors transparent
                        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
                            return Highcharts.Color(color)
                                    .setOpacity(0.5)
                                    .get('rgba');
                        });
                        $('#graficos').highcharts({
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Monitoramento de Acesso ao Colégio'
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: 'Nº de Pessoas '
                                }
                            },
                            legend: {
                                enabled: true
                            },
                            tooltip: {
                                shared: true,
                                valuePrefix: ' '
                            },
                            plotOptions: {
                                column: {
                                    grouping: false,
                                    shadow: false,
                                    dataLabels: {
                                        enabled: true
                                    }
                                },
                            },
                            series: [{
                                    name: 'Numeros Total de Pessoas: <?=$total?>',
                                    data: [<?= $dataseries ?>]

                                }],
                            dataLabels: {
                                enabled: true,
                                rotation: -90,
                                color: '#FFFFFF',
                                align: 'right',
                                x: 4,
                                y: 10,
                                style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif',
                                    textShadow: '0 0 3px black'
                                }
                            }
                        });
                    });</script>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

        $("#entrada").load("<?= SCL_RAIZ ?>monitor/controle/entrada?data=" + document.getElementById("data").value + "&tipo=" + document.getElementById("tipo").value + "");
        $("#saida").load("<?= SCL_RAIZ ?>monitor/controle/saida?data=" + document.getElementById("data").value + "&tipo=" + document.getElementById("tipo").value + "");
        $("#grafico").load("<?= SCL_RAIZ ?>monitor/controle/grafico?data=" + document.getElementById("data").value + "&tipo=" + document.getElementById("tipo").value + "");
        var entrada = setInterval(function() {
            $("#entrada").load("<?= SCL_RAIZ ?>monitor/controle/entrada?data=" + document.getElementById("data").value + "&tipo=" + document.getElementById("tipo").value + "&cache=" + Math.random());
        }, 4000);
        var saida = setInterval(function() {
            $("#saida").load("<?= SCL_RAIZ ?>monitor/controle/saida?data=" + document.getElementById("data").value + "&tipo=" + document.getElementById("tipo").value + "&cache=" + Math.random());
        }, 4000);
        var grafico = setInterval(function() {
            $("#grafico").load("<?= SCL_RAIZ ?>monitor/controle/grafico?data=" + document.getElementById("data").value + "&tipo=" + document.getElementById("tipo").value + "&cache=" + Math.random());
        }, 4000);
        $("#tipo").onchage(function() {
            $("#entrada").html('<div class="col-sm-12 well center">Carregando dados ...</div>');
            var entrada = setInterval(function() {
                $("#entrada").load("<?= SCL_RAIZ ?>monitor/controle/entrada?data=" + document.getElementById("data").value + "&tipo=" + document.getElementById("tipo").value + "&cache=" + Math.random());
            }, 0);
        })
    });

</script>
<? $this->load->view('layout/footer'); ?>
