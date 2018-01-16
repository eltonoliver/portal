<div class="modal-dialog modal-lg" id="mdlAtualizar">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">
                <i class="fa fa-2x fa-graduation-cap pull-left"></i>
                Detalhes do Processamento
            </h5>
        </div>
        <div class="modal-body">
            <div vclass="well row">
                <? //print_r($prova);?>
                <h6><strong><?=$prova[0]['TITULO'].' - '.$prova[0]['DISCIPLINAS']?></strong></h6>

                <h6>
                    <strong>Objetiva || </strong>
                    Nota Máxima: <?=number_format($prova[0]['NOTA_DISSERTATIVA'],1,'.','')?> - 
                    Qtd. Questão: <?=$prova[0]['QUESTOES']?>
                </h6>
                <h6>
                    <strong>Discursiva || </strong> 
                    Nota Máxima: <?=number_format($prova[0]['NOTA_MAXIMA'],1,'.','')?> - 
                    Qtd. Questão: (<?=$prova[0]['QTDE_DISSERTATIVA']?>)
                </h6>
            </div>
            <table class="table table-bordered table-hover">
                <tr class="font-bold panel-footer">
                    <td>ALUNO</td>
                    <td>VERSÃO</td>
                    <td>ACERTOS</td>
                    <td>VL QUESTÃO</td>
                    <td class="bg-warning text-center">OBJETIVA</td>
                    <td class="bg-warning text-center">DISCURSIVA</td>
                    <td class="bg-success text-center">NOTA</td>
                </tr>
                <? foreach($listar as $l){ ?>
                <tr <? if ($l['ACERTOS'] <> ''){ ?>
                    data-remote="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/processamento/frmDetalhesAluno/'.$l['CD_ALUNO'].'-'.$l['CD_PROVA_VERSAO'].'')?>" data-toggle="frmModalDetalhe"
                <? } ?>
                 >
                    <td><?=$l['CD_ALUNO'].' - '.$l['NM_ALUNO']?></td>
                    <td class="text-center"><?=$l['CD_PROVA_VERSAO']?></td>
                    <td class="text-center"><?=$l['NR_ACERTO']?></td>
                    <td class="text-center"><?='x'.number_format($l['VL_QUESTAO'],4,'.','')?></td>
                    <td class="bg-warning text-center"><?=(($l['NR_NOTA'] == '')? '-' : number_format($l['NR_NOTA'],1,'.',''))?></td>
                    <td class="bg-warning text-center"><?=(($l['NR_NOTA_DISCURSIVA'] == '')? '-' : number_format($l['NR_NOTA_DISCURSIVA'],1,'.',''))?></td>
                    <td class="bg-success text-center"><?=(($l['NOTA'] == '')? '-' : number_format($l['NOTA'],1,'.',''))?></td>
                </tr>
                <? } ?>
            </table>
        </div>
        <div class="modal-footer">

            <button type="button" class="btn btn-primary2" id="frmProvaCartao">
                <i class="fa fa-file-text"></i> Processar Cartões
            </button>
            
            <?
                if($nO == 10.0){
                    if($listar[0]['CD_TIPO_PROVA'] == 1){
                        //$frmId = 'frmProvaSimulado';
                    }else{
                        $frmId = 'frmProvaObjetiva';
                    }
            ?>
            <button type="button" class="btn btn-warning2" id="<?=$frmId?>">
                <i class="fa fa-clock-o"></i> Processar
            </button>
            <? } ?>
            <?
                if($nO == 5.0){
                    if($listar[3]['FLG_PEND_PROCESSAMENTO'] == 0){
                    
                    $frmId = 'frmProvaDiscursiva';
            ?>
            <button type="button" class="btn btn-warning2" id="<?=$frmId?>">
                <i class="fa fa-clock-o"></i> Processar Notas
            </button>
                <? } } ?>
            
            <button type="button" class="btn btn-danger2" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>
        </div>
    </div>
<script>
    $(function() {
        $('#frmProvaCartao').click(function() {
            swal({
                title: "Cartões Respostas",
                text: "Tem certeza que deseja processar os cartões desta prova?",
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sim, Processar!",
                cancelButtonText: "Não, Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: true,
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/processamento/frmProcessaGabarito/'.$listar[0]['CD_TIPO_PROVA'].'-'.$original.'') ?>", {
                    avalProva: <?=$original?>
                    },
                    function(data) {
                        swal("Sucesso!", "Processamento realizado com sucesso!", "success");
                        $("#mdlAtualizar").html(data);
                    });
                }
            });
        });
        $('#<?=$frmId?>').click(function() {
            swal({
                title: "Lançamento de Notas",
                text: "Tem certeza que deseja processar esse lançamento de notas?",
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sim, finalizar!",
                cancelButtonText: "Não, Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: true,
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/processamento/'.$frmId.'/'.$listar[0]['CD_TIPO_PROVA'].'-'.$original.'') ?>", {
                    avalProva: <?=$original?>
                    },
                    function(data) {
                        swal("Sucesso!", "Processamento realizado com sucesso!", "success");
                        $("#mdlAtualizar").html(data);
                    });
                }
            });
        });
    });
</script>
<script type="text/javascript">
$('[data-toggle="frmModalDetalhe"]').on('click',
    function(e) {
        $('#frmModalDetalhe').remove();
        e.preventDefault();
        var $this = $(this)
                , $remote = $this.data('remote') || $this.attr('href')
                , $modal = $('<div class="modal fade hmodal no-padding"  id="frmModalDetalhe"  tabindex="-1" role="dialog" ><div class="modal-dialog no-padding" ><div class="modal-content no-padding"></div></div></div>');
        $('body').append($modal);
        $modal.modal({backdrop: 'static', keyboard: true });
        $modal.load($remote);
    }
);
</script>

</div>
