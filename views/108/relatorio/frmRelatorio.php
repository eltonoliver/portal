<?php $this->load->view('home/header'); ?>
<script src="<?= base_url('assets/js/highcharts.js') ?>"></script>

<?php
// Monta o JSON de ALUNO
$alunos = array();
foreach ($aluno as $al) {
    $alunos[] = array(
        $al['NM_ALUNO'],
        (float) $al['NOTA']
    );
}
?>

<div class="content animate-panel">
    <div class="col-lg-12">
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-tab="Prova" data-toggle="tab" href="#tab-prova" aria-expanded="true"> 
                    Estatística da Prova
                </a>
            </li>
            <li class="">
                <a data-tab="Questao" data-toggle="tab" href="#tab-questao" aria-expanded="false">
                    Estatística por Questões
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="tab-prova" class="tab-pane active">
                <div class="panel-body">
                    <div class="hpanel hviolet" >
                        <div class="panel-heading">
                            Relatório de Notas da Turma
                            <button data-toggle="btn_Turma" class='btn btn-info'>
                                <i class='fa fa-print'></i> Imprimir
                            </button>
                        </div>
                        <div class="panel-body" id="GraficoTurma"></div>
                    </div>
                    <div class="hpanel hviolet">
                        <div class="panel-heading">
                            Relatório de Notas da Turma
                        </div>
                        <div class="panel-body">
                            <table cellpadding="1" id="tblGridCandidato" cellspacing="1" class="table">
                                <tbody>
                                    <? foreach ($aluno as $al) { ?>
                                    <tr class='panel-footer'>
                                        <th width="2%" align="center"></th>
                                        <th width="65%" align="center"></th>
                                        <th width="5%"  align="center">Objetiva</th>
                                        <th width="5%"  align="center">Discursiva</th>
                                        <th width="5%"  align="center">Lançada</th>
                                    </tr>
                                    <tr class="<?= (($al['NOTA'] >= 7) ? 'bg-success' : (($al['NOTA'] <= 5) ? 'bg-danger' : 'bg-warning')) ?>">
                                        <td align="center">
                                            <img width="30" class="img-rounded" src="http://server01.seculomanaus.com.br/academico/usuarios/foto?codigo=<?= $al['CD_ALUNO'] ?>">
                                        </td>
                                        <td align="left">
                                            <?= ' ( ' . $al['CD_PROVA_VERSAO'] . ' - ' . $al['NM_DISCIPLINA'] . ' )' ?><br>
                                            <?= $al['CD_ALUNO'] . ' - ' . substr($al['NM_ALUNO'], 0, 60) ?>
                                        </td>
                                        <td align="center" style='font-size:25px'>
                                            <strong><?= number_format($al['NR_NOTA'], 1, '.', '') ?></strong>
                                        </td>
                                        <td align="center" style='font-size:25px'>
                                            <strong><?= number_format($al['NR_NOTA_DISCURSIVA'], 1, '.', '') ?></strong>
                                        </td>
                                        <td align="center" style='font-size:25px'>
                                            <strong><?= number_format($al['NOTA'], 1, '.', '') ?></strong>
                                        </td>
                                    </tr>
                                    <!--tr>
                                        <td align="center" colspan="5">
                                            <table class='table' width='100%'>
                                                <tr>
                                                    <td width='10' align="left">QUE.</td>
                                                    <? for($i=0; strlen($al['GABARITO']) > $i; $i++) { ?>
                                                    <td align="center">
                                                        <?= $i + 1 ?>
                                                    </td>
                                                    <? } ?>
                                                </tr>
                                                <tr>
                                                    <td width='10' align="left">GAB.</td>
                                                    <? for($i=0; strlen($al['GABARITO']) > $i; $i++) { ?>
                                                    <td align="center">
                                                        <span class='badge badge-success'><?= substr($al['GABARITO'], $i, 1) ?></span>
                                                    </td>
                                                    <? } ?>
                                                </tr>
                                                <tr>
                                                    <td width='10' align="left">RES.</td>
                                                    <? for($i=0; strlen($al['GABARITO']) > $i; $i++) { ?>
                                                    <td align="center">
                                                        <span class='badge badge-<?= ((substr($al['RESPOSTAS'], $i, 1) == substr($al['GABARITO'], $i, 1)) ? 'success' : 'danger') ?>'>
                                                            <?= substr($al['RESPOSTAS'], $i, 1) ?>
                                                        </span>
                                                    </td>
                                                    <? } ?>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr-->
                                    <? }  ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab-questao" class="tab-pane" id='IMPQUESTAO'>
                <div class="panel-body">
                    <div class="hpanel hgreen">
                        <div class="panel-heading">
                            ESTATÍSTICA POR QUESTÃO
                             <button data-toggle="btn_Questao" class='btn btn-info'>
                                <i class='fa fa-print'></i> Imprimir
                            </button>
                        </div>
                        <div class="panel-body" id="GraficoQuestao"></div>
                    </div>


                    <?php
                    $quest = 0;
                    foreach($questao as $q){ 
                        if($q->CD_QUESTAO != $quest){
                        $quest = $q->CD_QUESTAO; 
                    ?>
                    <div class="col-lg-12 border-bottom">
                        <div class="hpanel hred">
                            <div class="panel-heading bg-info">
                                Questão N&omicron; <?=$q->CD_QUESTAO?> <br/>
                                Tema; <?=$q->DC_TEMA?> <br/>
                                Conteúdo; <?=$q->DC_CONTEUDO->load()?> <br/>
                            </div>
                            <div class="col-lg-6">
                                <p>
                                <?=$q->DC_QUESTAO->LOAD()?>   
                                </p>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-group">
                                <?php 
                                foreach($questao as $qo){ 
                                if($qo->CD_QUESTAO == $q->CD_QUESTAO){
                                ?>
                                <li class="list-group-item <?=(($qo->CORRETA == $qo->CD_OPCAO)? 'active' : '')?>">
                                    <span class="badge badge-success"><?=$qo->QTD?> aluno(s)</span>
                                    <span class="badge badge-danger"><?=number_format(($qo->QTD*100)/count($alunos),2,'.','')?>%</span>
                                    <?=$qo->DC_OPCAO->LOAD()?>
                                </li>
                                    
                                <?php } } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php } } ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('[data-toggle="btn_Turma"]').on('click', function () {
        var conteudo = $('div[id="tab-prova"]').html(),
                tela_impressao = window.open('about:blank');

        tela_impressao.document.write(conteudo);
        tela_impressao.window.print();
        tela_impressao.window.close();
    });
    $('[data-toggle="btn_Questao"]').on('click', function () {
        var conteudo = $('div[id="tab-questao"]').html(),
                tela_impressao = window.open('about:blank');

        tela_impressao.document.write(conteudo);
        tela_impressao.window.print();
        tela_impressao.window.close();
    });
</script>

<script type='text/javascript'>
    //<![CDATA[
    var GraficoTurma = Highcharts.chart('GraficoTurma', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<?= $al['DISCIPLINAS'] ?>'
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Nota'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Nota: <b>{point.y:.1f}</b>'
        },
        series: [{
                name: 'Nota: ',
                data: <?= json_encode($alunos) ?>,
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    format: '{point.y:.1f}', // one decimal
                    y: 10, // 10 pixels down from the top
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
    });
    //]]>
</script>

<?php
$qt = array();
$questao = array();

foreach ($rsquestao as $q) {
    $qs = json_encode($q);
    $qs = str_replace("'", '', $qs);
    (array) $qs = json_decode($qs);

    $qt[] = $qs->CD_QUESTAO;

    switch ($q->CORRETA) {
        case '#':
            $questao[$q->CD_QUESTAO]['CERTO'] = ($qs->A + $qs->B + $qs->C + $qs->D + $qs->E) + $questao[$q->CD_QUESTAO]['CERTO'];
            $questao[$q->CD_QUESTAO]['ERRADO'] = $questao[$q->CD_QUESTAO]['ERRADO'] + 0;
            break;
        case 'A':
            $questao[$q->CD_QUESTAO]['CERTO'] = $qs->A + $questao[$q->CD_QUESTAO]['CERTO'];
            $questao[$q->CD_QUESTAO]['ERRADO'] = ($qs->B + $qs->C + $qs->D + $qs->E) + $questao[$q->CD_QUESTAO]['ERRADO'];
            break;
        case 'B':
            $questao[$q->CD_QUESTAO]['CERTO'] = $qs->B + $questao[$q->CD_QUESTAO]['CERTO'];
            $questao[$q->CD_QUESTAO]['ERRADO'] = ($qs->A + $qs->C + $qs->D + $qs->E) + $questao[$q->CD_QUESTAO]['ERRADO'];
            break;
        case 'C':
            $questao[$q->CD_QUESTAO]['CERTO'] = $qs->C + $questao[$q->CD_QUESTAO]['CERTO'];
            $questao[$q->CD_QUESTAO]['ERRADO'] = ($qs->A + $qs->B + $qs->D + $qs->E) + $questao[$q->CD_QUESTAO]['ERRADO'];
            break;
        case 'D':
            $questao[$q->CD_QUESTAO]['CERTO'] = $qs->D + $questao[$q->CD_QUESTAO]['CERTO'];
            $questao[$q->CD_QUESTAO]['ERRADO'] = ($qs->A + $qs->B + $qs->C + $qs->E) + $questao[$q->CD_QUESTAO]['ERRADO'];
            break;
        case 'E':
            $questao[$q->CD_QUESTAO]['CERTO'] = $qs->D + $questao[$q->CD_QUESTAO]['CERTO'];
            $questao[$q->CD_QUESTAO]['ERRADO'] = ($qs->A + $qs->B + $qs->C + $qs->D) + $questao[$q->CD_QUESTAO]['ERRADO'];
            break;
    }
}

$c_questao = array_keys(array_flip($qt));

$certo = array();
$errado = array();
foreach ($questao as $qt) {
    $certo[] = $qt['CERTO'];
    $errado[] = $qt['ERRADO'];
}
?>

<script type='text/javascript'>
    //<![CDATA[
    Highcharts.chart('GraficoQuestao', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Erros e acertos por questão'
        },
        xAxis: {
            categories: <?= json_encode($c_questao) ?>,
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Alunos'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y}</b></td></tr>',
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
        series: [{
                name: 'Acerto',
                data: <?= json_encode($certo) ?>

            }, {
                name: 'Erros',
                data: <?= json_encode($errado) ?>

            }]
    });
    //]]> 
</script>
<?php $this->load->view('home/footer'); ?>