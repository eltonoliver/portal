<div class="modal-dialog no-padding no-margins" style="width:100%">
    <style type='text/css'>

.isotope-item {
    z-index: 2;
}
.isotope-hidden.isotope-item {
    pointer-events: none;
    z-index: 1;
}
.isotope,
.isotope .isotope-item {
  /* change duration value to whatever you like */

    -webkit-transition-duration: 0.8s;
    -moz-transition-duration: 0.8s;
    transition-duration: 0.8s;
}
.isotope {
    -webkit-transition-property: height, width;
    -moz-transition-property: height, width;
    transition-property: height, width;
}
.isotope .isotope-item {
    -webkit-transition-property: -webkit-transform, opacity;
    -moz-transition-property: -moz-transform, opacity;
    transition-property: transform, opacity;
}
  </style>
  <script type='text/javascript' src="<?=base_url('assets/js/jquery.isotope.min.js')?>"></script>
  
  <script type="text/javascript">
    function AvalProvaQuestao(prova,questao) {
        //$("#vwfrmTabela").html('');
        $.post("<?= base_url('108/prova_questoes/frmManterProvaQuestao') ?>", {
            operacao: 'I',
            avalProva: prova,
            avalQuestao: questao,
            avalValor: 0,
            avalAnulada: 'N',
        },
         function(data) {
            alert(data);
         });
    };

</script>
    <? 
       $new = new Prova_lib(); 
       $params = $listar[0]['CD_PROVA'] . $listar[0]['CD_DISCIPLINA'] . $listar[0]['TIPO_QUESTAO']; 
    ?>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-body no-padding">
            <div class="panel-footer">
                <h3>Tema: <?=$conteudo[0]['DC_TEMA']?></h3>
                <hr/>
                <select class="form-inline btn-sm data-filter" name="avalConteudo" style="width:70%">
                    <option value="*">Todas as Questões</option>
                    <? foreach($conteudo as $c) { ?>
                           <option value=".<?=$c['CD_CONTEUDO']?>"><?=nl2br(strip_tags($c['DC_CONTEUDO']))?></option>
                       <? } ?>
                </select>
                <a href="<?=base_url('108/prova/frmProvaMontarQuestoes/?prova='.$this->input->get('prova').'&disciplina='.$this->input->get('disciplina').'')?>" class="btn btn-danger btn-sm pull-right" ><i class="fa fa-times-circle-o"></i> Fechar</a>
            </div>
            <hr/>
            <div class="row-table" id="grid">
              <? foreach($listar as $q) {  ?>
               <div class="animated-panel zoomIn element-item transition <?=$q['conteudo'][0]['CD_CONTEUDO']?> " data-category="transition" style="width:<?=(($q['tipo'] == 'O')? '25' : '49')?>%">
                    <div class="hpanel <?=(($q['tipo'] == 'O')? 'hgreen' : 'hyellow')?> ">
                        <div class="panel-footer">
                            <span class="btn btn-sm btn-<?=(($q['tipo'] == 'O')? 'success' : 'warning')?>"> Nº <?= $q['codigo'] ?> </span>
                            <button class="btn btn-sm btn-info pull-right" type="button" onclick="AvalProvaQuestao(<?= $q['prova'] ?>,<?= $q['codigo'] ?>)"><i class="fa fa-plus"></i> Selecionar</button>
                            <?=(($q['usada'] > 0 ) ? '<i class="fa fa-star fa-2x text-warning"></i> Usada': '')?>
                        </div>
                        <div class="modal-footer no-margins">
                            <div style="font-size:10px; text-align: left">
                                Cadastro: <?=$q['usuario'].' <br /> Em: '.$q['dia']?> 
                                <br/>Nível: <?=$q['nivel']?>
                                <br/>Tema: <?=strip_tags( $q['conteudo'][0]['DC_TEMA'] )?>
                                <br/>Conteúdo: <?=strip_tags( $q['conteudo'][0]['DC_CONTEUDO'] )?>
                            </div>
                        </div>
                        <div class="panel-body" style="text-align: justify; height:<?=(($q['tipo'] == 'O')? '200' : '400')?>px; overflow: scroll; word-wrap: break-word; overflow-x: hidden;">
                            <small>
                                <?= $new->formata_texto_com_richtext($q['questao']) ?>
                            </small>
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
            
            <div class="modal-footer">
                <a href="<?=base_url('108/prova/frmProvaMontarQuestoes/?prova='.$this->input->get('prova').'&disciplina='.$this->input->get('disciplina').'')?>" class="btn btn-danger"><i class="fa fa-times-circle-o"></i> Fechar</a>
            </div>
        </div>
    </div>
  <script>
$(function () {
    var $grid = $('#grid').isotope({
        itemSelector: '.element-item',
        layoutMode: 'fitRows'
    });
    var filterFns = {
        numberGreaterThan50: function () {
            var number = $(this).find('.number').text();
            return parseInt(number, 10) > 50;
        },
        ium: function () {
            var name = $(this).find('.name').text();
            return name.match(/ium$/);
        }
    };
    $('.filters-button-group').on('click', 'a', function () {
        var filterValue = $(this).attr('data-filter');
        filterValue = filterFns[filterValue] || filterValue;
        $grid.isotope({ filter: filterValue });
    });
    
    $("select[name=avalConteudo]").change(function() {
        var filterValue = $("select[name=avalConteudo]").val();
        filterValue = filterFns[filterValue] || filterValue;
            $grid.isotope({ 
            filter: filterValue 
        });
    });
});
</script>
 </div>