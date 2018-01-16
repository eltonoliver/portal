

<?
foreach ($matricula2014 as $item) {
    $modalidade2014 .= "{ name: '".'('.$item['QTD_ALUNOS']  .') '. $item['DC_MODALIDADE'] . "', y: " . $item['QTD_ALUNOS'] . ", legendIndex: " . $item['CD_MODALIDADE'] . "},";
}
 $modalidade2014 = trim($modalidade2014, ",");

foreach ($matricula2015 as $l) {
    $modalidade2015 .= "{ name: '".'('.$l['QTD_ALUNOS']  .') '. $l['DC_TIPO_REGISTRO'].':'.$l['DC_MODALIDADE'] . "', y: " . $l['QTD_ALUNOS'] . ", legendIndex: " . $l['CD_MODALIDADE'] . "},";
}
// echo $modalidade2015 = trim($modalidade2015, ",");
?>



<div  class="col-sm-12 well">

    <div class="col-xs-6">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-users"></i> Alunos Matriculados</h3>
            </div>
            <div class="panel-body">
                <div class="box-content">
          <? foreach($matricula2014 as $item){ ?>
          <div id="mdlalunomodalidade2014<?=$item['CD_MODALIDADE']?>" class="modal fade">
            <div class="modal-dialog" style="width:80%">
              <div class="modal-content">
                <div class="modal-header btn-info">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">ALUNOS NA MODALIDADE {
                    <?=$item['DC_MODALIDADE']?>
                    } </h4>
                </div>
                <div class="modal-body">
                  <div class="table-responsive">
                    <table class="table table-condensed" id="grdAlunoModalidade2014<?=$item['CD_MODALIDADE']?>">
                      <thead>
                        <tr>
                          <th>Matrícula</th>
                          <th>Aluno</th>
                          <th>Curso</th>
                          <th>Série</th>
                          <th>Turno</th>
                        </tr>
                      </thead>
                      <tbody>
                        <? foreach($alunos2014 as $r){
		if($r['CD_MODALIDADE'] == $item['CD_MODALIDADE']){
		 ?>
                        <tr>
                          <td><?=$r['CD_ALUNO']?></td>
                          <td class="center"><?=$r['NM_ALUNO']?></td>
                          <td class="center"><?=$r['NM_CURSO_RED']?></td>
                          <td class="center"><?=$r['NM_SERIE']?></td>
                          <td class="center"><?=$r['DC_TURNO']?></td>
                        </tr>
                        <? } }?>
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
    
		$('#grdAlunoModalidade2014<?=$item['CD_MODALIDADE']?>').dataTable({
       "sPaginationType": "full_numbers"
    });
	
jQuery(function($) {
	$('[data-rel=tooltip]').tooltip();
	$('[data-rel=popover]').popover({html:true});
	});
</script>
          <? } ?>
          
          
          
          <div id="modalidade2014" style="height:500px"></div>
          
          <script>
          $(function () {
    var chart;
    
    $(document).ready(function () {
    	
    	// Build the chart
        $('#modalidade2014').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Alunos Matriculados | 2014/1'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                    	enabled: true,
                    	format: '<b>{point.name}</b>: <br/>{point.y} aluno(s) | Total: {point.percentage:.1f}%'
                	},
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Total de Alunos',
                data: [<?=$modalidade2014?>],
		point: {
                    events: {
                        click: function() {
                            $('#mdlalunomodalidade2014'+this.legendIndex).modal('show');
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
            <div class="panel-footer">
                <a href="#" class="btn btn-primary">Impressão</a>
            </div>
        </div>
    </div>  


       <div class="col-xs-6">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-users"></i> Alunos Matriculados 2015</h3>
            </div>
            <div class="panel-body">
                <div class="box-content">
          <? foreach($matricula2015 as $item){ ?>
          <div id="mdlalunomodalidade2015<?=$item['CD_MODALIDADE']?>" class="modal fade">
            <div class="modal-dialog" style="width:80%">
              <div class="modal-content">
                <div class="modal-header btn-info">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">ALUNOS NA MODALIDADE {
                    <?=$item['DC_MODALIDADE']?>
                    } </h4>
                </div>
                <div class="modal-body">
                  <div class="table-responsive">
                    <table class="table table-condensed" id="grdAlunoModalidade2015<?=$item['CD_MODALIDADE']?>">
                      <thead>
                        <tr>
                          <th>Matrícula</th>
                          <th>Aluno</th>
                          <th>Curso</th>
                          <th>Série</th>
                          <th>Turno</th>
                        </tr>
                      </thead>
                      <tbody>
                        <? foreach($alunos2015 as $r){
		if($r['CD_MODALIDADE'] == $item['CD_MODALIDADE']){
		 ?>
                        <tr>
                          <td><?=$r['CD_ALUNO']?></td>
                          <td class="center"><?=$r['NM_ALUNO']?></td>
                          <td class="center"><?=$r['NM_CURSO_RED']?></td>
                          <td class="center"><?=$r['NM_SERIE']?></td>
                          <td class="center"><?=$r['DC_TURNO']?></td>
                        </tr>
                        <? } }?>
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
          <? } ?>
          
          
          
          <div id="modalidade2015" style="height:500px"></div>
          
          <script>
          $(function () {
    var chart;
    
    $(document).ready(function () {
    	
    	// Build the chart
        $('#modalidade2015').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            credits: {
                enabled: false
            },
            title: {
                text: 'Alunos Matriculados | 2015/1'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                    	enabled: true,
                    	format: '<b>{point.name}</b>: <br/>{point.y} aluno(s) | Total: {point.percentage:.1f}%'
                	},
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Total de Alunos',
                data: [<?=$modalidade2015?>],
		point: {
                    events: {
                        click: function() {
                            $('#mdlalunomodalidade2015'+this.legendIndex).modal('show');
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
            <div class="panel-footer">
                <a href="#" class="btn btn-primary">Impressão</a>
            </div>
        </div>
    </div>  

    
    <div class="col-xs-12">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-bar-chart-o"></i> Alunos Bolsistas 
                </h3>
            </div>
            <div class="panel-body">
                <?
                foreach ($bolsas as $r) {
                    $bolsaValor .= "{ name: '" . $r['DC_MOTIVO'] . "', y: " . $r['QTD_ALUNOS'] . " , legendIndex: " . $r['CD_MOTIVO'] . $r['PERCENTUAL'] . "},";
                    ?>
                    <div id="mdlbolsa<?= $item['CD_MODALIDADE'] . $r['PERCENTUAL'] ?>" class="modal fade" data-remote="<?= SCL_RAIZ ?>/diretoria/dashboard/mdlbolsa?motivo=<?= $r['CD_MOTIVO'] ?>&percentual=<?= $r['PERCENTUAL'] ?>"></div>
                    <?
                }
                $bolsaValor = trim($bolsaValor, ",");
                ?>
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
                                        allowPointSelect: false,
                                        cursor: 'pointer',
                                        dataLabels: {
                                            enabled: true,
                                            format: '<b>{point.name}</b>: <br/>{point.y} alunos | Total : {point.percentage:.1f}%'
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
            <div class="panel-footer">
                <a href="<?=base_url()?>diretoria/dashboard/todosbolsitas" target='_blank' class="btn btn-primary">Imprimir Todos</a>
            </div>
        </div>
    </div>
</div>
<? exit(); ?>