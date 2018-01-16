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
    }
    ;


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
                    <a href="<?= base_url('108/prova_correcao/') ?>" class="btn btn-info"><i class="fa fa-dot-circle-o"></i> Voltar</a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 animated-panel zoomIn " style="position: fixed; bottom: 5%">
            <div class="hpanel hviolet">
                <div class="panel-heading">
                    <h3>Questões</h3>
                </div>
                <div class="panel-body no-padding"  style="overflow:auto; height: 350px;">
                    <div class="users-list " id="wizardControl">
                        <? foreach ($lista as $l) { ?>
                            <a class="chat-user no-padding" href="#Q<?=$l['codigo']?>" data-toggle="tab">
                                <div class="chat-user-name">
                                    QUESTÃO Nº <?=$l['posicao']?> | (<?=$l['codigo']?>)
                                </div>
                            </a>
                        <? } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-10 animated-panel zoomIn pull-right" style="animation-delay: 0.1s;">
            <div class="tab-content">
                <? $new = new Prova_lib();  foreach ($lista as $q) { ?>
                <div id="Q<?=$q['codigo']?>" class="tab-pane" style="font-size:16px">
                    <div class="hpanel <?=(($q['tipo'] == 'O')? 'hgreen' : 'hyellow')?> ">
                        <div class="panel-heading">
                            <h3> Nº <?= $q['codigo'] ?> </h3>
                        </div>
                        <div class="panel-body" style="text-align: justify; word-wrap: break-word; overflow-x: hidden;">
                            <textarea class="form-control" rows="10" onwaiting="true" spellcheck="true"><?= $new->formata_texto_com_richtext($q['questao']) ?></textarea>
                        </div>
                        <?
                        if ($q['tipo'] == 'O') {
                            echo '<div class="panel-footer"> A) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][0]['DC_OPCAO']) . '</div>';
                            echo '<div class="panel-footer"> B) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][1]['DC_OPCAO']) . '</div>';
                            echo '<div class="panel-footer"> C) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][2]['DC_OPCAO']) . '</div>';
                            echo '<div class="panel-footer"> D) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][3]['DC_OPCAO']) . '</div>';
                            echo '<div class="panel-footer"> E) ' . $new->formata_texto_com_richtext_alternativa($q['opcao'][4]['DC_OPCAO']) . '</div>';
                        }
                        ?>
                    </div>
                </div>
                <? } ?>
            </div>
        </div>

        <input type="hidden" name="txtOperacao" value="U" />
        <input type="hidden" name="avalEstrutura"  value="<?= $prova[0]['CD_ESTRUTURA'] ?>" />
        <input type="hidden" class="" name="avalNumNota"  value="<?= $prova[0]['NUM_NOTA'] ?>" />
    </form>
</div>

<div style="padding-bottom: 150px"></div>
<script>
    $(function() {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            $('a[data-toggle="tab"]').removeClass('bg-info');
            $('a[data-toggle="tab"]').addClass('bg-green');
            $(this).removeClass('bg-info');
            $(this).addClass('bg-green');
        })

        $('.next').click(function() {
            var nextId = $(this).parents('.tab-pane').next().attr("id");
            $('[href=#' + nextId + ']').tab('show');
        })

        $('.prev').click(function() {
            var prevId = $(this).parents('.tab-pane').prev().attr("id");
            $('[href=#' + prevId + ']').tab('show');
        })

        $('.submitWizard').click(function() {

            var approve = $(".approveCheck").is(':checked');
            if (approve) {
                // Got to step 1
                $('[href=#step1]').tab('show');

                // Serialize data to post method
                var datastring = $("#simpleForm").serialize();

                // Show notification
                swal({
                    title: "Thank you!",
                    text: "You approved our example form!",
                    type: "success"
                });
            } else {
                // Show notification
                swal({
                    title: "Error!",
                    text: "You have to approve form checkbox.",
                    type: "error"
                });
            }
        })
    });
</script>
<? $this->load->view('home/footer'); ?>