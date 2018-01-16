<?
$this->load->view('home/header');
?>
<script type="text/javascript">
    function AvalProvaQuestaoPosicao(questao, posicao, prova) {
        $.post("<?= base_url('108/prova_questoes/frmManterProvaQuestao') ?>", {
            operacao: 'EP',
            avalProva: prova,
            avalQuestao: questao,
            avalPosicao: posicao,
        },
         function(data) {
            location.reload(); 
         });
    };


    function AvalProvaQuestaoExcluir(prova, questao) {
        $.post("<?= base_url('108/prova_questoes/frmManterProvaQuestao') ?>", {
            operacao: 'X',
           avalProva: prova,
         avalQuestao: questao
        },
        function(data) {
            location.reload(); 
        });
    }
    ;

</script>
<div class="row projects no-margins">
    <form name="frmProva" id="frmProva">        
        <div class="col-lg-12 animated-panel zoomIn ">  
            <div class="hpanel hviolet">
                <div class="panel-heading">
                    <a href="<?= base_url('108/prova/frmNovaProvaConfiguracao/' . $prova[0]['CD_PROVA'] . '') ?>" class="btn btn-info"><i class="fa fa-dot-circle-o"></i> Voltar</a>
                </div>
            </div>
        </div>
        <div class="col-lg-3 animated-panel zoomIn ">  
            <div class="hpanel hviolet">
                <div class="panel-body no-padding">
                    <div class="users-list ">
                        <? foreach ($tema as $t) { ?>
                            <div class="chat-user no-padding">
                                <div class="chat-user-name">
                                    <small>
                                        <a data-toggle="frmModal" href="<?= base_url('108/prova_questoes/mdlTemaQuestoes?prova=' . $prova[0]['CD_PROVA'] . '&tema=' . $t['CD_TEMA'] . '&disciplina=' . $disciplina . '&curso=' . $prova[0]['CD_CURSO'] . '&serie=' . $prova[0]['ORDEM_SERIE'] . '') ?>">
                                            <?= $t['DC_TEMA'] ?>
                                        </a>
                                    </small>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>        

        <div class="col-lg-9 animated-panel zoomIn">
            <? foreach ($listar as $q) { ?>
                <div class="col-lg-6 animated-panel zoomIn" style="animation-delay: 0.1s; width:<?=(($q['tipo'] == 'O')? '49' : '98')?>%">
                    <div class="hpanel <?=(($q['tipo'] == 'O')? 'hgreen' : 'hyellow')?> ">
                        <div class="panel-footer">
                            <span class="btn btn-sm btn-<?=(($q['tipo'] == 'O')? 'success' : 'warning')?>"> Nº <?= $q['codigo'] ?> </span>
                            <select class="btn btn-default" name="avalPosicaoQuestao" style="padding:2px" onchange="AvalProvaQuestaoPosicao(<?= $q['codigo'] ?>, this.value,<?= $q['prova'] ?>)">
                                <?
                                $new = new Prova_lib();
                                $new->disciplina = $q['disciplina'];
                                $new->prova = $q['prova'];
                                $new->tipo = $q['tipo'];
                                $new->selecao = $q['posicao'];
                                echo $new->posicao();
                                ?>
                            </select>
                            <button class="btn btn-sm btn-danger2 pull-right" type="button" onclick="AvalProvaQuestaoExcluir(<?= $q['prova'] ?>,<?= $q['codigo'] ?>)"><i class="fa fa-trash"></i> Excluir</button>
                        </div>
                        <div class="modal-footer no-margins">
                            <div style="font-size:10px; text-align: left">
                                Cadastro: <?=$q['usuario'].' <br /> Em: '.$q['dia']?> 
                                <br/>Nível: <?=$q['nivel']?>
                                <br/>Tema: <?=strip_tags( $q['conteudo'][0]['DC_TEMA'] )?>
                                <br/>Conteúdo: <?=strip_tags( $q['conteudo'][0]['DC_CONTEUDO'] )?>
                            </div>
                        </div>
                        <div class="panel-body" style="text-align: justify; height:200px; overflow: scroll; word-wrap: break-word; overflow-x: hidden;">
                            <small contenteditable="true" spellcheck="true">
                                <?= $new->formata_texto_com_richtext_alternativa($q['questao']) ?>
                            </small>
                        </div>
                        <?
                        if ($q['tipo'] == 'O') {
                            echo '<div class="panel-footer" contenteditable="true" spellcheck="true"> A) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][0]['DC_OPCAO']) . '</div>';
                            echo '<div class="panel-footer" contenteditable="true" spellcheck="true"> B) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][1]['DC_OPCAO']) . '</div>';
                            echo '<div class="panel-footer" contenteditable="true" spellcheck="true"> C) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][2]['DC_OPCAO']) . '</div>';
                            echo '<div class="panel-footer" contenteditable="true" spellcheck="true"> D) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][3]['DC_OPCAO']) . '</div>';
                            echo '<div class="panel-footer" contenteditable="true" spellcheck="true"> E) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][4]['DC_OPCAO']) . '</div>';
                        }
                        ?>
                    </div>
                </div>
            <? } ?>
        </div>

        <input type="hidden" name="txtOperacao" value="U" />
        <input type="hidden" name="avalEstrutura"  value="<?= $prova[0]['CD_ESTRUTURA'] ?>" />
        <input type="hidden" name="avalNumNota"  value="<?= $prova[0]['NUM_NOTA'] ?>" />
    </form>
</div>

<div style="padding-bottom: 150px"></div>

<? $this->load->view('home/footer'); ?>