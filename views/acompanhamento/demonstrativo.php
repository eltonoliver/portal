<script src="<?= base_url('assets/js/jquery-1.11.0.min.js') ?>"></script>
<script src="<?= base_url('assets/js/highcharts.js') ?>"></script>

<?php
$blt_disc = '';
$blt_nota = array();
$tp_nota = array();

//obter as notas de P1, MAIC e P2
for ($i = 1; $i < 4; $i++) {
    $tp_nota[$i] = $boletim[0]['NM_MINI_N0' . $i . '_' . $bimestre . 'B'];

    foreach ($boletim as $blt) {
        $blt_nota[$i] .= ((!empty($blt['NOTA_N0' . $i . '_' . $bimestre . 'B'])) ? "" . number_format($blt['NOTA_N0' . $i . '_' . $bimestre . 'B'], 1, '.', '') . "," : "0,");
    }
}

//obter as disciplinas
foreach ($boletim as $blt) {
    $blt_disc .= "'" . $blt['NM_DISCIPLINA'] . "',";
}
?>

<script type='text/javascript'>//<![CDATA[
    $(function () {
        $('#disciplinas').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: [<?= $blt_disc ?>],
                crosshair: true
            },
            yAxis: {
                min: 0,
                max: 10,
                title: {
                    text: 'Notas'
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
                    name: '<?= $tp_nota[1] ?>',
                    data: [<?= $blt_nota[1] ?>]
                },
                {
                    name: '<?= $tp_nota[2] ?>',
                    data: [<?= $blt_nota[2] ?>]
                },
                {
                    name: '<?= $tp_nota[3] ?>',
                    data: [<?= $blt_nota[3] ?>]
                }
            ]
        });
    });
//]]> 

</script>

<script type="text/javascript">
    $("#comparativo-disciplina").change(function () {
        var disciplina = $("#comparativo-disciplina").val();

        $.ajax({
            url: "<?= site_url("acompanhamento/demonstrativoGraficoComparativo") ?>",
            method: "post",
            dataType: "html",
            data: {
                disciplina: disciplina,
                token: "<?= $token ?>"
            },
            success: function (response) {
                $("#comparativo-notas").html(response);
            }
        });

    });
</script>

<div class="row">
    <div class="section-light col-lg-12 col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <div class="btn-group">
                                        <form action="<?= SCL_RAIZ ?>impressao/nota/" target="_blank" method="post">
                                            <input type="hidden" name="aluno" value="<?= $aluno['CD_ALUNO'] ?>" />
                                            <input type="hidden" name="tipo" value="0" />
                                            <button type="submit" class="btn btn-inverse">
                                                <i class="fa fa-print"></i> Imprimir
                                            </button>                                        
                                            <a data-toggle="modal" data-target="#boletim" class="btn btn-default" href="#" class="btn btn-inverse">
                                                <i class="fa fa-adn"></i> Boletim
                                            </a>
                                            <!--modal enviar arquivo-->
                                            <div class="modal fade" id="boletim" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                                 data-remote="<?= site_url("acompanhamento/boletim") . "?token=" . $token ?>" > 
                                                <div class="modal-dialog" style="width: 90%;">
                                                    <div class="modal-content">
                                                        <?= modal_load ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--modal enviar arquivo-->
                                        </form> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <fieldset class="form-group">
                            <legend>GRÁFICO DEMONSTRATIVO DE NOTAS - <?= $bimestre . "º BIMESTRE" ?></legend>

                            <div id="disciplinas"></div>
                        </fieldset>

                        <fieldset class="form-group">
                            <legend>GRÁFICO COMPARATIVO DE NOTAS POR DISCIPLINA</legend>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Disciplina</label>
                                        <select id="comparativo-disciplina" name="disciplina" class="form-control">
                                            <option value="">Selecione a Disciplina</option>

                                            <?php foreach ($disciplinas as $disciplina): ?>
                                                <option value="<?= $disciplina['CD_DISCIPLINA'] ?>">
                                                    <?= $disciplina['NM_DISCIPLINA'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>            
                                    </div>
                                </div>                               
                            </div>

                            <div id="comparativo-notas"></div>
                        </fieldset>

                        <fieldset>
                            <legend>DEMONSTRATIVO DE NOTAS</legend>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="font-size:11px">DISCIPLINA</th>
                                        <th style="font-size:11px">TURMA</th>

                                        <!-- 1º Bimestre -->
                                        <th class="text-center btn-success" style="font-size:11px"><?= $boletim[0]['NM_MINI_N01_1B'] ?></th>
                                        <th class="text-center btn-success" style="font-size:11px"><?= $boletim[0]['NM_MINI_N02_1B'] ?></th>
                                        <th class="text-center btn-success" style="font-size:11px"><?= $boletim[0]['NM_MINI_N03_1B'] ?></th>
                                        <th class="text-center btn-success" style="font-size:11px"><?= $boletim[0]['NM_MINI_N04_1B'] ?></th>
                                        <th class="text-center btn-success" style="font-size:11px">F</th>

                                        <!-- 2º Bimestre -->
                                        <th class="text-center btn-warning" style="font-size:11px"><?= $boletim[0]['NM_MINI_N01_2B'] ?></th>
                                        <th class="text-center btn-warning" style="font-size:11px"><?= $boletim[0]['NM_MINI_N02_2B'] ?></th>
                                        <th class="text-center btn-warning" style="font-size:11px"><?= $boletim[0]['NM_MINI_N03_2B'] ?></th>
                                        <th class="text-center btn-warning" style="font-size:11px"><?= $boletim[0]['NM_MINI_N04_2B'] ?></th>                                    
                                        <th class="text-center btn-warning" style="font-size:11px"><?= $boletim[0]['NM_MINI_N05_2B'] ?></th>
                                        <th class="text-center btn-warning" style="font-size:11px">F</th>

                                        <!-- 3º Bimestre -->
                                        <th class="text-center btn-info" style="font-size:11px"><?= $boletim[0]['NM_MINI_N01_3B'] ?></th>
                                        <th class="text-center btn-info" style="font-size:11px"><?= $boletim[0]['NM_MINI_N02_3B'] ?></th>
                                        <th class="text-center btn-info" style="font-size:11px"><?= $boletim[0]['NM_MINI_N03_3B'] ?></th>
                                        <th class="text-center btn-info" style="font-size:11px"><?= $boletim[0]['NM_MINI_N04_3B'] ?></th>                                                                        
                                        <th class="text-center btn-info" style="font-size:11px">F</th>

                                        <!-- 4º Bimestre -->
                                        <th class="text-center btn-danger" style="font-size:11px"><?= $boletim[0]['NM_MINI_N01_4B'] ?></th>
                                        <th class="text-center btn-danger" style="font-size:11px"><?= $boletim[0]['NM_MINI_N02_4B'] ?></th>
                                        <th class="text-center btn-danger" style="font-size:11px"><?= $boletim[0]['NM_MINI_N03_4B'] ?></th>
                                        <th class="text-center btn-danger" style="font-size:11px"><?= $boletim[0]['NM_MINI_N04_4B'] ?></th>                                    
                                        <th class="text-center btn-danger" style="font-size:11px"><?= $boletim[0]['NM_MINI_N05_4B'] ?></th>                                    
                                        <th class="text-center btn-danger" style="font-size:11px">F</th>                                    
                                    </tr>
                                </thead>

                                <tbody>
                                    <?                                
                                    foreach ($boletim as $item) {
                                    ?>
                                    <tr>
                                        <td style="font-size:11px"><?= $item['NM_DISCIPLINA'] ?></td>
                                        <td style="font-size:11px"><?= $item['CD_TURMA'] ?></td>

                                        <!-- 1º Bimestre -->
                                        <td class="text-center btn-success" style="font-size:11px">
                                            <?= !empty($item['NOTA_N01_1B']) ? number_format($item['NOTA_N01_1B'], 1, '.', '') : '-' ?>
                                        </td>
                                        <td class="text-center btn-success" style="font-size:11px">
                                            <?= !empty($item['NOTA_N03_1B']) ? number_format($item['NOTA_N02_1B'], 1, '.', '') : '-' ?>
                                        </td>
                                        <td class="text-center btn-success" style="font-size:11px">
                                            <?= !empty($item['NOTA_N03_1B']) ? number_format($item['NOTA_N03_1B'], 1, '.', '') : '-' ?>
                                        </td>
                                        <td class="text-center btn-success" style="font-size:11px">
                                            <?= !empty($item['NOTA_N04_1B']) ? number_format($item['NOTA_N04_1B'], 1, '.', '') : '-' ?>
                                        </td>                                        
                                        <td class="text-center btn-success" style="font-size:11px">
                                            <?= !empty($item['FALTAS_1B']) ? $item['FALTAS_1B'] : '-' ?>
                                        </td>

                                        <!-- 2º Bimestre -->
                                        <td class="text-center btn-warning" style="font-size:11px">
                                            <?= !empty($item['NOTA_N01_2B']) ? number_format($item['NOTA_N01_2B'], 1, '.', '') : '-' ?>
                                        </td>
                                        <td class="text-center btn-warning" style="font-size:11px">
                                            <?= !empty($item['NOTA_N03_2B']) ? number_format($item['NOTA_N02_2B'], 1, '.', '') : '-' ?>
                                        </td>
                                        <td class="text-center btn-warning" style="font-size:11px">
                                            <?= !empty($item['NOTA_N03_2B']) ? number_format($item['NOTA_N03_2B'], 1, '.', '') : '-' ?>
                                        </td>
                                        <td class="text-center btn-warning" style="font-size:11px">
                                            <?= !empty($item['NOTA_N04_2B']) ? number_format($item['NOTA_N04_2B'], 1, '.', '') : '-' ?>
                                        </td>                                        
                                        <td class="text-center btn-warning" style="font-size:11px">
                                            <?= !empty($item['NOTA_N05_2B']) ? number_format($item['NOTA_N05_2B'], 1, '.', '') : '-' ?>
                                        </td>                                        
                                        <td class="text-center btn-warning" style="font-size:11px">
                                            <?= !empty($item['FALTAS_2B']) ? $item['FALTAS_2B'] : '-' ?>
                                        </td>

                                        <!-- 3º Bimestre -->
                                        <td class="text-center btn-info" style="font-size:11px">
                                            <?= !empty($item['NOTA_N01_3B']) ? number_format($item['NOTA_N01_3B'], 1, '.', '') : '-' ?>
                                        </td>
                                        <td class="text-center btn-info" style="font-size:11px">
                                            <?= !empty($item['NOTA_N03_3B']) ? number_format($item['NOTA_N02_3B'], 1, '.', '') : '-' ?>
                                        </td>
                                        <td class="text-center btn-info" style="font-size:11px">
                                            <?= !empty($item['NOTA_N03_3B']) ? number_format($item['NOTA_N03_3B'], 1, '.', '') : '-' ?>
                                        </td>
                                        <td class="text-center btn-info" style="font-size:11px">
                                            <?= !empty($item['NOTA_N04_3B']) ? number_format($item['NOTA_N04_3B'], 1, '.', '') : '-' ?>
                                        </td>                                        
                                        <td class="text-center btn-info" style="font-size:11px">
                                            <?= !empty($item['FALTAS_3B']) ? $item['FALTAS_3B'] : '-' ?>
                                        </td>

                                        <!-- 4º Bimestre -->
                                        <td class="text-center btn-danger" style="font-size:11px">
                                            <?= !empty($item['NOTA_N01_4B']) ? number_format($item['NOTA_N01_4B'], 1, '.', '') : '-' ?>
                                        </td>
                                        <td class="text-center btn-danger" style="font-size:11px">
                                            <?= !empty($item['NOTA_N02_4B']) ? number_format($item['NOTA_N02_4B'], 1, '.', '') : '-' ?>
                                        </td>
                                        <td class="text-center btn-danger" style="font-size:11px">
                                            <?= !empty($item['NOTA_N03_4B']) ? number_format($item['NOTA_N03_4B'], 1, '.', '') : '-' ?>
                                        </td>
                                        <td class="text-center btn-danger" style="font-size:11px">
                                            <?= !empty($item['NOTA_N04_4B']) ? number_format($item['NOTA_N04_4B'], 1, '.', '') : '-' ?>
                                        </td>                                        
                                        <td class="text-center btn-danger" style="font-size:11px">
                                            <?= !empty($item['NOTA_N05_4B']) ? number_format($item['NOTA_N05_4B'], 1, '.', '') : '-' ?>
                                        </td>                                        
                                        <td class="text-center btn-danger" style="font-size:11px">
                                            <?= !empty($item['FALTAS_4B']) ? $item['FALTAS_4B'] : '-' ?>
                                        </td>
                                    </tr>
                                    <? } ?>
                                </tbody>
                            </table>
                        </fieldset>
                    </div>

                    <div class="panel-footer">
                        <button type="button" class="btn btn-alt btn-success">1º BIMESTRE</button>
                        <button type="button" class="btn btn-alt btn-warning">2º BIMESTRE</button>
                        <button type="button" class="btn btn-alt btn-info">3º BIMESTRE</button>
                        <button type="button" class="btn btn-alt btn-danger">4º BIMESTRE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php exit(); ?>