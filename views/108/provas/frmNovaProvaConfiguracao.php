<? 
    $this->load->view('home/header'); 
    $disabled = (($prova[0]['FLG_PEND_PROCESSAMENTO'] == 0)? 'disabled' : '');
?>
<script type="text/javascript">
    function habilitar(){
        var checkeds = new Array();
        $("input[name='listaDeleteInscrito[]']:checked").each(function (){
            $('.btnCancelarInscricao').removeAttr('disabled');
        });
    };
    
    function svCancelarInscricao() {
        $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_inscritos/frmCancelaInscricao') ?>", {
            prova: <?=$prova[0]['CD_PROVA']?>,
            aluno: $("input[name='listaDeleteInscrito[]']:checked").serialize(),
        },
        function(valor) {
            $("#retornos").html(valor);
        });
    };
    
    function svProva() {
        var dados = jQuery('#frmProva').serialize();
        jQuery.ajax({
            type: "POST",
            url: "<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova/frmManterProvas') ?>",
            data: dados,
            success: function(data) {
                $("#retorno").html(data);
            },
        });
        return false;
    };

    function svDisciplina() {
        var dados = jQuery('#frmProvaDisiplina').serialize();
        jQuery.ajax({
            type: "POST",
            url: "<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova/frmManterProvaDisciplina') ?>",
            data: dados,
            success: function(data) {
                $("#rs").html(data);
            },
        });
        return false;
    };

    function calcular() {
        var objetivaI = $("[name='txtQTDOInicial']").val();
        var objetivaF = $("[name='txtQTDOFinal']").val();

        var discursivaI = $("[name='txtQTDDInicial']").val();
        var discursivaF = $("[name='txtQTDDFinal']").val();
        var resultado;
        resultado = ((objetivaF - objetivaI) + 1) + ((discursivaF - discursivaI) + 1);
        $("input[name='txtQTDQuestoes']").val(resultado);
    };

    function titulo() {

        var tipo = $("[name='avalTipoProva'] option:selected").text();
        var curso = $("[name='avalCurso'] option:selected").text();
        var serie = $("[name='avalSerie'] option:selected").text();
        var bimestre = $("[name='avalBimestre'] option:selected").text();
        var tipoNota = $("[name='avalTipoNota'] option:selected").text();
        var chamada = $("[name='avalChamada'] option:selected").text();

        var res;
        
        if(tipo != ''){
            res = tipo;
        }
        if(curso != ''){
            res = res + ' - ' + curso;
        }
        if(serie != ''){
            res = res + ' - ' + serie;
        }
        if(bimestre != ''){
            res = res + ' - ' + bimestre;
        }
        if(chamada != ''){
            res = res + ' - ' + chamada;
        }
        if(tipoNota != ''){
            res = res + ' - ' + tipoNota;
        }
        //res = tipo + ' - ' + curso + ' - ' + serie + ' - ' + bimestre + ' - ' + chamada + ' - ' + tipoNota;
        $("input[name='avalTitulo']").val(res);
    }
    ;

    function pxNumeroFinal() {
        var inicial = $("[name='avalPosInicial']").val();
        var res = (parseInt(inicial) + parseInt(10));
        $("input[name='avalPosFinal']").val(res);
    };

    function vlNotasObj() {

        var qtd = $("[name='avalQtdeObj']").val();
        var tt = $("[name='avalTTPontoObj']").val();
        var vl = (parseInt(tt) / parseInt(qtd));
        
        $("input[name='avalVlQuestaoObj']").val(vl);
    };
    
    function vlNotasDis() {

        var qtd = $("[name='avalQtdeDis']").val();
        var tt = $("[name='avalTTPontoDis']").val();
        var vl = (parseInt(tt) / parseInt(qtd));
        $("input[name='avalVlQuestaoDis']").val(vl);
    };

    $(document).ready(function(){
	$('.time').bootstrapMaterialDatePicker({
            date: false,
            shortTime: false,
            format: 'HH:mm'
	});			
    });
</script>

<div class="row projects no-margins">
    <div class="panel-heading"></div>

    <form name="frmProva" id="frmProva">
        <div class="col-lg-12 animated-panel zoomIn ">
            <div class="hpanel hviolet">
                <div class="panel-heading">
                    <a class="btn btn-info" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova') ?>"><i class="fa fa-dot-circle-o"></i> Voltar</a>
                    <? if($prova[0]['FLG_PEND_PROCESSAMENTO'] == 1){?>
                        <button class="btn btn-success btnSalvarDados pull-right" type="button"><i class="fa fa-save"></i> Salvar Dados</button>                        
                        <button class="btn btn-danger" data-toggle="frmModal" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_espaco_posicao/modalProva/' . $prova[0]['CD_PROVA'] . '') ?>"><i class="fa fa-align-justify"></i> Espaços e Posição</button>
                        <button class="btn btn-warning2" type="button"><i class="fa fa-check"></i> Correção da Prova</button>
                        <a class="btn btn-warning" target="_blank" href="<?=('http://server01.seculomanaus.com.br/academico/'.$this->session->userdata('SGP_SISTEMA').'/impressao/'.(($prova[0]['CD_TIPO_PROVA']== 6)?'ingresso':'index').'?id='.$prova[0]['CD_PROVA'].'')?>" type="button"><i class="fa fa-eye"></i> PDF OBJETIVA</a>
                        <a class="btn btn-warning" target="_blank" href="<?='http://server01.seculomanaus.com.br/academico/'.$this->session->userdata('SGP_SISTEMA').'/impressao/'.((($prova[0]['CD_TIPO_PROVA']== 6)?'discursiva':'discursiva').'?id='.$prova[0]['CD_PROVA'].'')?>" type="button"><i class="fa fa-eye"></i> PDF DISCURSIVA</a>
                        
                        <a data-toggle="frmModal" class="btn btn-primary" href="<?='http://server01.seculomanaus.com.br/provaonline/comissao/prova/index/?p='.base64_encode(json_encode($prova[0])).''?>" type="button"><i class="fa fa-eye"></i> PROVA ONLINE</a>
                    <? }else{ ?>
                        <a class="btn btn-warning" target="_blank" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_gabarito/avaliacao/?id='.base64_encode($prova[0]['CD_PROVA']).'')?>" type="button"><i class="fa fa-eye"></i> PROVA CORRIGIDA</a>
                    <? } ?>
                </div>
                <div class="panel-body no-padding">
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label>Formato</label>
                            <select name="avalFormato" id="avalFormato" class="form-control m-b">
                                <option <?= (($prova[0]['FL_FORMATO'] == 'I') ? 'selected="selected"' : '') ?> value="I">Impresso</option>
                                <option <?= (($prova[0]['FL_FORMATO'] == 'O') ? 'selected="selected"' : '') ?> value="O">Online</option>
                            </select>
                        </div>
                    </div>
                   
                     <div class="col-lg-1">
                        <div class="form-group">
                            <label>Exibir Nota: <?php 
                                      
                                       $exibir = $prova[0]['exibe_resultado'];
                                      
                                    ?></label>
                            <select name="avalResultado" id="avalResultado" class="form-control m-b" disabled>
                                <option <?php (($exibir == 1 || $exibir == "") ? 'selected="selected"' : '') ?> value="1">SIM</option>
                                <option <?php (($exibir == 0) ? 'selected="selected"' : '') ?> value="0">NÃO</option>
                            </select>
                        </div>
                    </div>
                   
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>Tipo Prova</label>
                            <select <?=$disabled?> readonly name="avalTipoProva" id="avalTipoProva" class="form-control m-b">
                                <option value=""></option>
                                    <? foreach ($tipo_prova as $row) { ?>
                                    <option <?= (($row['CD_TIPO_PROVA'] == $prova[0]['CD_TIPO_PROVA']) ? 'selected="selected"' : '') ?> value="<?= $row['CD_TIPO_PROVA'] ?>"><?= $row['DC_TIPO_PROVA'] ?></option>
                                    <? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="form-group">
                            <label>Código</label>
                            <input <?=$disabled?> type="text" name="avalProva" id="avalProva" class="form-control" value="<?= $prova[0]['CD_PROVA'] ?>" readonly="readonly" />
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Nº Prova</label>
                            <input <?=$disabled?> type="text" name="avalNumProva" id="avalNumProva" class="form-control" value="<?= $prova[0]['NUM_PROVA'] ?>" readonly="readonly" />
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Curso</label>
                            <select <?=$disabled?> onchange="titulo();" name="avalCurso" id="avalCurso" class="form-control m-b">
                                <option value=""></option>
<? foreach ($curso as $row) { ?>
                                    <option <?= (($row['CD_CURSO'] == $prova[0]['CD_CURSO']) ? 'selected="selected"' : '') ?> value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO'] ?></option>
<? } ?>
                            </select>
                        </div>
                    </div>                    
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Série</label>
                            <select <?=$disabled?> onchange="titulo();" name="avalSerie" id="avalSerie" class="form-control m-b">
                                <?
                                foreach ($serie as $s) {
                                    if (($s['NM_SERIE'] != 'ATIVIDADE DIRIGIDA') && ($s['NM_SERIE'] != 'ESTUDO DIRIGIDO')) {
                                        ?>
                                        <option <?= (($s['ORDEM_SERIE'] == $prova[0]['ORDEM_SERIE']) ? 'selected="selected"' : '') ?> value="<?= $s['ORDEM_SERIE'] ?>"><?= $s['ORDEM_SERIE'] . (($prova[0]['ORDEM_SERIE'] == 3) ? 'º Ano' : 'ª Série') ?></option>
                                        <?
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Bimestre</label>
                            <select <?=$disabled?> onchange="titulo();" name="avalBimestre" id="avalBimestre" class="form-control m-b">
                                <option value=""></option>
                                <option <?= (($prova[0]['BIMESTRE'] == 1) ? 'selected="selected"' : '') ?> value="1">1º Bimestre</option>
                                <option <?= (($prova[0]['BIMESTRE'] == 2) ? 'selected="selected"' : '') ?> value="2">2º Bimestre</option>
                                <option <?= (($prova[0]['BIMESTRE'] == 3) ? 'selected="selected"' : '') ?> value="3">3º Bimestre</option>
                                <option <?= (($prova[0]['BIMESTRE'] == 4) ? 'selected="selected"' : '') ?> value="4">4º Bimestre</option>
                                <option <?= (($prova[0]['BIMESTRE'] == 5) ? 'selected="selected"' : '') ?> value="5">5º Bimestre</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Tipo Nota
                            </label>
                            <select <?=$disabled?> onchange="titulo();" name="avalTipoNota" id="avalTipoNota" class="form-control m-b">
                                <option value=""></option>
<? foreach ($tipo_nota as $row) { ?>
                                    <option <?= (($row['CD_TIPO_NOTA'] == $prova[0]['CD_TIPO_NOTA']) ? 'selected="selected"' : '') ?> value="<?= $row['CD_TIPO_NOTA'] ?>"><?= $row['NM_MINI'] ?></option>
<? } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Chamada</label>
                            <select <?=$disabled?> onchange="titulo();" name="avalChamada" id="avalChamada" class="form-control m-b">
                                <option value=""></option>
                                <option <?= (($prova[0]['CHAMADA'] == 1) ? 'selected="selected"' : '') ?> value="1">1ª Chamada</option>
                                <option <?= (($prova[0]['CHAMADA'] == 2) ? 'selected="selected"' : '') ?> value="2">2ª Chamada</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Data da Prova</label>
                            <div class="input-group date" id="avalDataProva">
                                <input <?=$disabled?> value="<?= (($prova[0]['DT_PROVA']!="")? date('d/m/Y', strtotime(implode("-", array_reverse(explode("/", $prova[0]['DT_PROVA']))))):"") ?>" name="avalDataProva" type="text" class="form-control">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Hora Início</label>
                            <div class="input-group">
                                <input data-format="hh:mm" class="form-control time" type="text" id="hrInicio" value="<?= $prova[0]['HR_INICIO'] ?>" placeholder="hh:mm" name="horaInicio"/>
                                <span class="input-group-addon add-on"><i class="glyphicon glyphicon-time"></i></span>
                            </div>         
                        </div>
                    </div>
                    
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Hora Término</label>
                            <div class="input-group">
                                <input <?=$disabled?> id="hrFim" class="form-control time" value="<?= $prova[0]['HR_FIM'] ?>" name="horaFim" placeholder="hh:mm" type="text" maxlength="5">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Título da Prova</label>
                            <input <?=$disabled?> type="text" name="avalTitulo" class="form-control" value="<?= $prova[0]['TITULO'].(($prova[0]['CD_TIPO_NOTA'] == 5)? $prova[0]['DISCIPLINAS'] : '') ?>" <?=(($prova[0]['CD_TIPO_PROVA'] == 5)? '' : 'readonly="readonly"')?> />
                        </div>
                    </div>                    

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Professor 
                                <button type="button" class="btn btn-danger btn-xs btn-circle" data-container="body" data-toggle="popover" data-placement="top" data-title="Professor" data-content="Professor responsável pela disciplina." data-original-title="" title="">
                                    ?
                                </button>
                            </label>
                            <select <?=$disabled?> name="avalProfessor" id="avalProfessor" class="form-control avalProfessorLista">
                                <option value=""></option>
                                    <? foreach ($professor as $row) { ?>
                                    <option <?= (($row['CD_PROFESSOR'] == $prova[0]['CD_PROFESSOR']) ? 'selected="selected"' : '') ?> value="<?= $row['CD_PROFESSOR'] ?>"><?= $row['NM_PROFESSOR'] ?></option>
                                    <? } ?>
                            </select>
                        </div>
                    </div>
                    
                    
                    <fieldset class="col-lg-6 well">
                        <legend class="no-margins">Prova Objetiva</legend>
                        
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Qtd. Questões</label>
                                <div class="input-group bootstrap-touchspin">
                                    <input <?=$disabled?>  name="avalQtdeObj" id="avalQtdeObj" type="text" value="<?=number_format($prova[0]['QTDE_QUESTOES'],4,'.','') ?>" class="form-control avalQtd" style="display: block;">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 no-padding">
                            <div class="form-group">
                                <label>Total Pontos
                                </label>
                                <div class="input-group bootstrap-touchspin">
                                    <input <?=$disabled?>  name="avalTTPontoObj" id="avalTTPontoObj"  type="text" value="<?= $prova[0]['NOTA_MAXIMA'] ?>" class="form-control avalVlQuestao" style="display: block;">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Valor por Questão</label>
                                <div class="input-group bootstrap-touchspin">
                                    <input <?=$disabled?> name="avalVlQuestaoObj" id="avalVlQuestaoObj" type="NUMBER" value="<?=number_format($prova[0]['VALOR_QUESTAO'],4,'.','') ?>" class="form-control" style="display: block;">
                                </div>
                            </div>
                        </div>

                    </fieldset>
                    
                    
                    
                    <fieldset class="col-lg-6 well">
                        <legend class="no-margins">Valor Dissertativa</legend>

                        <div class="col-lg-4 no-padding">
                            <div class="form-group no-padding">
                                <label>Qtd. Questões
                                </label>
                                <div class="input-group bootstrap-touchspin">
                                    <input <?=$disabled?> onchange="vlNotasDis()" name="avalQtdeDis" id="avalQtdeDis" type="text" value="<?= $prova[0]['QTDE_DISSERTATIVA'] ?>" class="form-control avalQtd" style="display: block;">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Total Pontos</label>
                                <div class="input-group bootstrap-touchspin">
                                    <input <?=$disabled?> onchange="vlNotasDis()" name="avalTTPontoDis" id="avalTTPontoDis" type="text" value="<?= $prova[0]['NOTA_DISSERTATIVA'] ?>" class="form-control avalVlQuestao" style="display: block;">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Valor por Questão</label>
                                <div class="input-group bootstrap-touchspin">
                                    <input readonly="readonly" name="avalVlQuestaoDis" id="avalVlQuestaoDis" type="NUMBER" value="<?=number_format($prova[0]['VALOR_QUESTAO_DISSERTATIVA'],4,'.','') ?>" class="form-control" style="display: block;">
                                </div>
                            </div>
                        </div>

                    </fieldset>

                </div>
            </div>
        </div>
        <div class="col-lg-12 animated-panel zoomIn">
            <div class="hpanel horange">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-down"></i></a>
                    </div>
                    <? if ($prova[0]['CD_TIPO_PROVA'] == 2) { ?>
                        <? if (count($prova_disciplina) < 2) { ?>
                            <button class="btn btn-warning2" data-toggle="frmModal" href="<?= base_url('108/prova/mdlDisciplinasProva?prova=' . $prova[0]['CD_PROVA'] . '&curso=' . $prova[0]['CD_CURSO'] . '&serie=' . $prova[0]['ORDEM_SERIE'] . '&operacao=I') ?>">
                                <i class="fa fa-list-ul"></i> Adicionar Disciplina
                            </button>
                            <h3 class="pull-right">DISCIPLINA(S) DA PROVA</h3>
                                    <?
                                } else {
                                    echo '<h3>DISCIPLINA(S) DA PROVA</h3>';
                                }
                            } else {
                                ?>
                        <button class="btn btn-warning2" data-toggle="frmModal" href="<?= base_url('108/prova/mdlDisciplinasProva?prova=' . $prova[0]['CD_PROVA'] . '&curso=' . $prova[0]['CD_CURSO'] . '&serie=' . $prova[0]['ORDEM_SERIE'] . '&operacao=I') ?>">
                            <i class="fa fa-list-ul"></i> Adicionar Disciplina
                        </button>
                        <h3 class="pull-right">DISCIPLINA(S) DA PROVA</h3>
                    <? } ?>
                        
                </div>
                <div class="panel-body no-padding">
                    <div class="col-lg-12 no-padding">
                        <div class="table-responsive">
                            <table cellpadding="1" cellspacing="1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%" align="center">Tipo</th>
                                        <th>Disciplina</th>
                                        <th width="10%" align="center">Qtd. Posições</th>
                                        <th width="10%" align="center">Valor Questão</th>
                                        <th width="10%" align="center">Pos. Inicial</th>
                                        <th width="10%" align="center">Pos. Final</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? if (count($prova_disciplina) > 0) {
                                        foreach ($prova_disciplina as $pd) {
                                            ?>
                                            <tr>
                                                <td align="center"><?= (($pd['TIPO_QUESTAO'] == 'O') ? 'Objetiva' : 'Dissertativa') ?></td>
                                                <td><?= $pd['NM_DISCIPLINA'] ?></td>
                                                <td align="center"><?= $pd['QTD_QUESTOES'].' / '.(($pd['POSICAO_FINAL'] - $pd['POSICAO_INICIAL'])+1) ?></td>
                                                <td align="center"><?= number_format($pd['VL_QUESTAO'],4,'.','') ?></td>
                                                <td align="center"><?= $pd['POSICAO_INICIAL'] ?></td>
                                                <td align="center"><?= $pd['POSICAO_FINAL'] ?></td>
                                                <td width="<?=(($prova[0]['FLG_PEND_PROCESSAMENTO'] == 1)? '20' : '5')?>%">
                                                    <? if($prova[0]['FLG_PEND_PROCESSAMENTO'] == 1){?>
                                                        <a href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova/frmProvaMontarQuestoes/?prova=' . $pd['CD_PROVA'] . '&disciplina=' . $pd['CD_DISCIPLINA'] . '') ?>" class="btn btn-warning2 btn-xs" >
                                                            <i class="fa fa-edit"></i> Questões
                                                        </a>
                                                        <a data-toggle="frmModalUpdate" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova/mdlDisciplinasProva?prova=' . $pd['CD_PROVA'] . '&disciplina=' . $pd['CD_DISCIPLINA'] . '&tipo=' . $pd['TIPO_QUESTAO'] . '&curso=' . $prova[0]['CD_CURSO'] . '&serie=' . $prova[0]['ORDEM_SERIE'] . '&operacao=C') ?>" class="btn btn-info btn-xs" >
                                                            <i class="fa fa-edit"></i> Editar
                                                        </a>
                                                        <a data-toggle="frmModalDanger" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova/mdlDisciplinasProva?prova=' . $pd['CD_PROVA'] . '&disciplina=' . $pd['CD_DISCIPLINA'] . '&tipo=' . $pd['TIPO_QUESTAO'] . '&curso=' . $prova[0]['CD_CURSO'] . '&serie=' . $prova[0]['ORDEM_SERIE'] . '&operacao=D') ?>" class="btn btn-danger2 btn-xs" >
                                                            <i class="fa fa-times"></i> Deletar
                                                        </a>
                                                    <? } ?>
                                                </td>
                                            </tr>
                                          <? } } else { ?>
                                        <tr align="center">
                                            <td colspan="6"> Não há disciplinas cadastradas!</td>
                                        </tr>
                                    <? } ?>
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <? if($prova[0]['CD_TIPO_PROVA'] == 2){?>
        <div class="col-lg-3 animated-panel zoomIn">
            <div class="hpanel hgreen">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-down"></i></a>
                    </div>
                   <? if($prova[0]['FLG_PEND_PROCESSAMENTO'] == 1){?>
                    <button class="btn btn-success" data-toggle="frmModal" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_versoes/mdlProvaGerarVersoes/' . $prova[0]['CD_PROVA'] . '') ?>">
                        <i class="fa fa-sitemap"></i> GERAR VERSÕES
                    </button>
                   <? } ?>
                    <h3 class="<?=(($prova[0]['FLG_PEND_PROCESSAMENTO'] == 1)? 'pull-right' : '')?>">VERSÃO</h3>
                </div>
                <div class="panel-body no-padding">
                    <div class="col-lg-12 no-padding">
                        <div class="table-responsive">
                            <table cellpadding="1" cellspacing="1" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th align="center">ID</th>
                                        <th>Nº Prova</th>
                                        <th>Hr. Início</th>
                                        <th>Hr. Fim</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <? if (count($prova_versoes) > 0) {
                                        foreach ($prova_versoes as $vs) {
                                            ?>
                                            <tr>
                                                <td><?= $vs['CD_PROVA'] ?></td>
                                                <td><?= $vs['NUM_PROVA'] ?></td>
                                                <td class="text-center"><?= $vs['HR_INICIO'] ?></td>
                                                <td class="text-center"><?= $vs['HR_FIM'] ?></td>
                                            </tr>
                                            <? }
                                        } else {
                                            ?>
                                        <tr align="center">
                                            <td colspan="4"> Não há versão(ões)!</td>
                                        </tr>
                                        <? } ?>
                                </tbody>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <? } ?>
        <div class="col-lg-9 animated-panel zoomIn">
            <div class="hpanel hviolet">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="showhide"><i class="fa fa-chevron-down"></i></a>
                    </div>
                    <? if($prova[0]['FLG_PEND_PROCESSAMENTO'] == 1 && $prova[0]['CD_TIPO_PROVA'] < 5){?>
                    <button class="btn btn-primary2" data-toggle="frmModal" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_inscritos/mdlProvaInscritos/' . $prova[0]['CD_PROVA'] . '') ?>">
                        <i class="fa fa-users"></i> Adicionar Candidato(s)
                    </button>
                    <button type="button" class="btn btn-success btnInscrever" data-toggle="modal">
                        <i class="fa fa-list-ul"></i> Inscrição Automática
                    </button>
                    
                    <button type="button" class="btn btn-warning2"  data-toggle="frmModal" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_inscritos/mdlProvaAlunoAssociar/' . $prova[0]['CD_PROVA'] . '') ?>">
                        <i class="fa fa-list-ol"></i> Associar Aluno a Prova
                    </button>
                    
                    <? } if($prova[0]['FLG_PEND_PROCESSAMENTO'] == 1 && $prova[0]['CD_TIPO_PROVA'] == 6){?>
                    <button class="btn btn-primary" data-toggle="frmModal" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_inscritos/mdlProvaInscritosCliente/' . $prova[0]['CD_PROVA'] . '') ?>">
                        <i class="fa fa-users"></i> Adicionar Candidato(s)
                    </button>
                    <? } if($prova[0]['FLG_PEND_PROCESSAMENTO'] == 1 && $prova[0]['CD_TIPO_PROVA'] == 5){?>
                    <button class="btn btn-info" data-toggle="frmModal" href="<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_inscritos/mdlProvaInscritosAlinhamento/' . $prova[0]['CD_PROVA'] . '') ?>">
                        <i class="fa fa-users"></i> Adicionar Candidato(s)
                    </button>
                    <? } ?>
                    <h3 class="<?=(($prova[0]['FLG_PEND_PROCESSAMENTO'] == 1)? 'pull-right' : '')?>">INSCRITO(S) NA PROVA</h3>
                </div>
                <div class="panel-body">
                    <table cellpadding="1" id="tblGridCandidato" cellspacing="1" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%" align="center"></th>
                                <th width="5%" align="center">Matrícula</th>
                                <th>Aluno</th>
                                <th width="20%" align="center">Prova</th>
                                <th width="5%" align="center">Fez?</th>
                            </tr>
                        </thead>
                        <tbody>
                        <? if (count($prova_candidatos) > 0) {
                            foreach ($prova_candidatos as $pc) {
                                ?>
                                    <tr data-id-element="<?= $pc['CD_ALUNO'] ?>" class="text-<?=(($pc['FEZ_PROVA'] == 0)? 'danger' : 'success')?>">
                                        <td align="center">
                                            <div class="checkbox checkbox-danger no-margins no-padding">
                                                <input value="<?= $pc['CD_ALUNO'] ?>" onchange="habilitar()" class="checkbox listaDeleteInscrito" name="listaDeleteInscrito[]" id="listaDeleteInscrito" type="checkbox">
                                                <label for="checkbox<?= $pc['CD_ALUNO'] ?>"></label>
                                            </div>
                                        </td>
                                        <td align="center"><?= $pc['CD_ALUNO'] ?></td>
                                        <td><?= $pc['NM_ALUNO'] ?></td>
                                        <td><?= $pc['CD_PROVA_VERSAO'].' | '.$pc['NUM_PROVA']?></td>
                                        <td align="center">
                                            <i class="fa fa-<?=(($pc['FEZ_PROVA'] == 0)? 'times' : 'check')?> text-<?=(($pc['FEZ_PROVA'] == 0)? 'danger' : 'success')?>"></i>
                                        </td>
                                    </tr>
                                    <? }
                                }  ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" align="left">
                                    <? if($prova[0]['FLG_PEND_PROCESSAMENTO'] == 1){?>
                                    <button disabled type="button" id="btnCancelarInscricao" class="btn btn-danger2 btn-sm btnCancelarInscricao" >
                                        <i class="fa fa-trash"></i> Deletar
                                    </button>
                                    <? } ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" align="left" id="retornos">
                                    
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <input type="hidden" name="txtOperacao" value="U" />
        <input type="hidden" name="avalEstrutura"  value="<?= $prova[0]['CD_ESTRUTURA'] ?>" />
        <input type="hidden" name="avalNumNota"  value="<?= $prova[0]['NUM_NOTA'] ?>" />
    </form>
</div>
<script type="text/javascript">
    $("select[id=avalCurso]").change(function() {
        $("select[id=avalSerie]").html('<option>Carregando</option>');
        $.post("<?= base_url('comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function(valor) {
            $("select[id=avalSerie]").html(valor);
        });
    });

    $("select[id=FTSerie]").change(function() {
        $("select[id=TTDisciplina]").html('<option>Carregando</option>');
        $.post("<?= base_url('comum/combobox/disciplinaTable') ?>", {
            curso: $("select[id=FTCurso]").val(),
            serie: $("select[id=FTSerie]").val(),
        },
                function(valor) {
                    $("div[id=TTDisciplina]").html(valor);
                });
    });

    $("select[name=avalBimestre]").change(function() {
        $("select[name=avalTipoNota]").html('Carregando');
        $.post("<?= base_url('comum/combobox/notas') ?>", {
            bimestre: $('select[name=avalBimestre]').val(),
            curso: $('select[name=avalCurso]').val(),
        },
        function(valor) {
            $("select[name=avalTipoNota]").html(valor);
        });
    });

    $("select[id=avalCurso]").change(function() {
        $.post("<?= base_url('comum/combobox/estrutura') ?>", {
            curso: $(this).val()
        },
        function(valor) {
            $("input[name=avalEstrutura]").val(valor);
        });
    });

</script>
<script>
    
    function refreshPage(){
       location.reload();
     };
    
    $(function() {
        
        <? if($prova[0]['FLG_PEND_PROCESSAMENTO'] == 1){ ?>
        $('#avalDataProva').datepicker({
            format: 'dd/mm/yyyy',
            today: "Today",
        });
        $(".avalProfessorLista").select2();

        $("#avalNotaMaxima").TouchSpin({
            min: 0,
            max: 10,
            step: 1,
            decimals: 0,
            boostat: 5,
            maxboostedstep: 10,
        });
        $("#avalNotaDissertativa").TouchSpin({
            min: 0,
            max: 10,
            step: 1,
            decimals: 0,
            boostat: 5,
            maxboostedstep: 10,
        });
        $("#avalQtdQuestoes").TouchSpin({
            min: 0,
            max: 100,
            step: 1,
            decimals: 0,
            boostat: 5,
            maxboostedstep: 10,
        });
        
        $(".avalQtd").TouchSpin({
            min: 0,
            max: 100,
            step: 1,
            decimals: 0,
            boostat: 5,
            maxboostedstep: 10,
        });
        
        $(".avalVlQuestao").TouchSpin({
            min: 0,
            max: 10,
            step: 0.0001,
            decimals: 4,
            boostat: 5,
            maxboostedstep: 10,
        });
        
        $(".avalTTPontos").TouchSpin({
            min: 0,
            max: 10,
            step: 0.00,
            decimals: 2,
            boostat: 5,
            maxboostedstep: 10,
        });

        $('.btnSalvarDados').click(function() {
            
           /* if((($("#hrInicio").val() < '07:00') && ($("#hrInicio").val() > '18:00')) || (($("#hrFim").val() < '07:00') && ($("#hrFim").val() > '18:00')) ){
                alert("hora inválida");
            } 
            
            alert ("Inicio: "+$("#hrInicio").val()+" Fim: "+$("#hrFim").val());*/
                swal({
                    title: "Salvar as Alterações?",
                    text: "Salvar altarações realizadas nesta prova, caso haja alguma versão elas também serão atualizadas.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Sim, Salvar Dados!",
                    cancelButtonText: "Não, Cancelar!",
                    closeOnConfirm: false,
                    closeOnCancel: false},
                function(isConfirm) {
                    if (isConfirm) {
                        svProva();
                        swal("Dados Salvos!", "As alterações foram realizadas com sucesso!.", "success");
                        window.setTimeout(refreshPage, 2000 );
                    } else {
                        swal("Cancelado", "Os dados não fora salvos", "error");
                    }
                });
        });
        
        $('.btnCancelarInscricao').click(function() {
            swal({
                title: "Cancelar Inscrição(ões)?",
                text: "Você deseja realmente cancelar essas inscrições?",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, Cancelar",
                cancelButtonText: "Não",
                closeOnConfirm: false,
                closeOnCancel: false},
            function(isConfirm) {
                if (isConfirm) {
                    svCancelarInscricao();
                    swal("Cancelamento Finalizado!", "As Inscrição(ões) foram cancelada(s) com sucesso!.", "success");
                    window.setTimeout(refreshPage, 1000 );
                } else {
                    swal("Cancelado", "Os dados não fora salvos", "error");
                }
            });
        });
        
        $('.btnInscrever').click(function() {
            swal({
                title: "Inscrição automática",
                text: "Você tem certeza que deseja inscrever todos os alunos nesta prova?",
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sim, finalizar!",
                cancelButtonText: "Não, Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: true,
            },
            function(isConfirm) {
                if (isConfirm) {
                    // função que verifica no banco se a prova esta processada 
                    $.post("<?= base_url('108/prova_inscritos/frmInscricaoAutomatica') ?>", {
                    avalProva: $("#avalProva").val(),
                  avalChamada: $("#avalChamada").val(),
                    },
                    function(data) {
                        swal("Sucesso!", "Inscrições realizadas com sucesso!", "success");
                        $("#tblViewRetorno").html(data);
                        window.setTimeout(refreshPage, 500);
                    });
                }
            });
        });
        
        
        <? } ?>
    });
    $(function() {
        // Initialize Example 2
        $('#tblGridCandidato').dataTable();
    });
</script>
<? $this->load->view('home/footer'); ?>