<div class="modal-dialog" style="width:80%">
    <? 
    $new = new Prova_lib(); 
    $pai = (($prova[0]['CD_PROVA_PAI'] == '')? $prova[0]['CD_PROVA'] : $prova[0]['CD_PROVA_PAI']);
    ?>
<style>
    input[type=radio].css-checkbox {
        position:absolute; 
        z-index:-1000; 
        left:-1000px; 
        overflow: hidden; 
        clip: rect(0 0 0 0); 
        height:1px; 
        width:1px; 
        margin:-1px; 
        padding:0; 
        border:0;
    }

    input[type=radio].css-checkbox + label.css-label {
        padding-left:26px;
        height:21px; 
        display:inline-block;
        line-height:21px;
        background-repeat:no-repeat;
        background-position: 0 0;
        font-size:21px;
        vertical-align:middle;
        cursor:pointer;

    }

    input[type=radio].css-checkbox:checked + label.css-label {
        background-position: 0 -21px;
    }
    label.css-label {
        background-image:url(<?= base_url('assets/images/csscheckbox_0cf84fec35537d1f4546496881280e34.png') ?>);
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
</style>
    <script type="text/javascript">
        function frmProvaGabaritar(id) {
            $("#pQuestao").html('<?= LOAD ?>');
            $.post("<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/prova_gabarito/frmManter') ?>", {
                objeto: id
            },
            function (data) {
                $("#pQuestao").html(data);
            });
        }
        ;
        function link(id) {
            $("#frmModalFull").html('<?= LOAD ?>');
            $.post("<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/prova_gabarito/mdlGabaritarProva/') ?>/" + id + "", {
                avalProvaVersao: <?= $prova[0]['CD_PROVA'] ?>
            },
            function (data) {
                $("#frmModalFull").html(data);
            });
        };
    </script>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <span class="label label-warning pull-left"> POSIÇÃOº <?= $questoes['posicao'] ?> </span>
            <span class="label label-success pull-left"> Nº <?= $questoes['questao'] ?> </span>
            <h5 class="text-center"><?= $prova[0]['TITULO'] . ' - ' . $prova[0]['DISCIPLINAS'] ?></h5>
        </div>
        <div class="modal-footer no-padding no-margins">
            <?= $link ?>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-8 border-right">
                    <? echo($questoes['opcao']['CD_OPCAO']); ?>
                    <? echo($questoes['opcao']['FLG_CORRETA']); ?>
                    <small>
                        <strong>
                            <strong><?=$questoes['posicao']?> </strong>) 
                            <?= $new->formata_texto_com_richtext($questoes['descricao']) ?>
                         </strong>
                        <br><br>
                        <table class="table table-striped">
                        <? foreach ($questoes['opcao'] as $opcao) { ?>
                            <tr>
                                <td width="3%">
                                    <? if($prova[0]['FLG_PEND_PROCESSAMENTO'] == 1){ ?>
                                        <input <?=(($opcao['FLG_CORRETA'] == 1) ? 'checked="checked"': '')?> type="radio" class="css-checkbox" id="<?= $questoes['questao'] . $opcao['CD_OPCAO'] ?>" name="<?= $questoes['questao'] ?>" onclick="frmProvaGabaritar(this.value)" value="<?= $prova[0]['CD_PROVA'] .'-'.$questoes['questao'] . '-' . $opcao['CD_OPCAO'].'-'.$pai?>">
                                        <label for="<?= $questoes['questao'] . $opcao['CD_OPCAO'] ?>" class="css-label"></label>
                                    <? }else{
                                        echo $opcao['CD_OPCAO'];
                                      } ?>
                                </td>
                                <td valign="top" style="font-size:13px">
                                    <?=$new->formata_texto_com_richtext($opcao['DC_OPCAO'])?>
                                </td>
                            </tr>
                        <? } ?>
                        <tr>
                            <td width="3%">
                                <? if($prova[0]['FLG_PEND_PROCESSAMENTO'] == 1){ ?>
                                    <input <?=(($questoes['anulada'] == 'S') ? 'checked="checked"': '')?> type="radio" class="css-checkbox" id="<?= $questoes['questao'] . 'A' ?>" name="<?= $questoes['questao'] ?>" onclick="frmProvaGabaritar(this.value)" value="<?= $prova[0]['CD_PROVA'] .'-'.$questoes['questao'] . '-A'.'-'.$pai?>">
                                    <label for="<?= $questoes['questao'] . 'A' ?>" class="css-label radGroup1"></label>
                                <? } ?>
                            </td>
                            <td valign="middle" style="font-size:12px">
                                <strong>ANULAR QUESTÃO </strong><small><i>(O Aluno ganha o ponto correspondente a essa questão)</i></small>
                            </td>
                        </tr>
                        <tr>
                            <td width="3%">
                                <? if($prova[0]['FLG_PEND_PROCESSAMENTO'] == 1){ ?>
                                    <input <?=(($questoes['cancelada'] == 'S') ? 'checked="checked"': '')?> type="radio" class="css-checkbox" id="<?= $questoes['questao'] . 'C' ?>" name="<?= $questoes['questao'] ?>" onclick="frmProvaGabaritar(this.value)" value="<?= $prova[0]['CD_PROVA'] .'-'.$questoes['questao'] . '-C'.'-'.$pai ?>">
                                    <label for="<?= $questoes['questao'] . 'C' ?>" class="css-label radGroup1"></label>
                                <? } ?>
                            </td>
                            <td valign="middle" style="font-size:12px">
                                <strong> CANCELAR QUESTÃO </strong><small><i>(O ponto correspondente a esta questão será distribuido para as demais questões.)</i></small>
                            </td>
                        </tr>
                        </table>
                    </small>
                </div>
                <div class="col-sm-4 bg-green">
                    <h5><strong>Gabaritos</strong></h5>
                    <div id="pQuestao">
                        <small><?=$prova[0]['RESPOSTAS']?></small>
                        <hr>
                        <?
                        $cartao = new gabarito_lib();
                        $cartao->numero_prova = $prova[0]['CD_PROVA'];
                        $cartao->prova_pai = (($prova[0]['CD_PROVA_PAI'] == '')? $prova[0]['CD_PROVA'] : $prova[0]['CD_PROVA_PAI']);
                        $cartao->correcao();
                        echo $cartao->cartao_resposta();
                        
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <?= $link ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>
    
    
</div>
