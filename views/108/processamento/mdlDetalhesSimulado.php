<div class="modal-dialog modal-lg" id="mdlAtualizar">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">Detalhes do Processamento </h5>            
        </div>
        <div class="modal-body">
            <div vclass="well row">
                <div class="col-xs-1">
                    <i class="fa fa-4x fa-graduation-cap"></i>
                </div>
                <div class="col-xs-11">
                    <h6><strong><?=$listar[0]['TITULO'].' - '.$listar[0]['DISCIPLINAS']?></strong></h6>
                    <h6>Qtd. Questão: <?=$listar[0]['QTDE_QUESTOES']?></h6>
                    <h6>Valor por Questão: <?=number_format($listar[0]['VALOR_QUESTAO'],4,'.','')?></h6>
                </div>
            </div>
            <table class="table table-bordered table-hover">
                
                <?
                $nO = number_format($listar[0]['VL_T_OBJETIVA'],1,'.','');
                $nD = number_format($listar[0]['VL_T_DISCURSIVA'],1,'.','');
                $aluno = '';
                foreach($listar as $l){
                
                if($aluno != $l['CD_ALUNO']){
                ?>
                <tr>
                    <td class="panel-footer font-bold" colspan="7">
                        <?=$l['CD_ALUNO'].' - '.$l['NM_ALUNO']?>
                    </td>
                </tr>
                <tr class="font-bold panel-footer">
                    <td>DISCIPLINA</td>
                    <td class="text-center">VERSÃO</td>
                    <td class="text-center">ACERTOS</td>
                    <td class="text-center">ERROS</td>
                    <td class="text-center">VL QUESTÃO</td>
                    <td class="bg-warning text-center">OBJETIVA</td>
                    <td class="bg-success text-center">NOTA</td>
                </tr>
                <? } ?>
                <tr>
                    <td><?=$l['CD_DISCIPLINA'].' - '.$l['NM_DISCIPLINA']?></td>
                    <td class="text-center"><?=$l['CD_PROVA']?></td>
                    <td class="text-center"><?=$l['ACERTOS']?></td>
                    <td class="text-center"><?=$l['ERROS']?></td>
                    <td class="text-center"><?='x'.number_format($l['VALOR_QUESTAO'],4,'.','')?></td>
                    <td class="bg-warning text-center"><?=number_format(($l['ACERTOS'] * $l['VALOR_QUESTAO']),1,'.','')?></td>
                    <td class="bg-success text-center"><?=(($l['NOTA'] == '')? '-' : number_format($l['NOTA'],1,'.',''))?></td>
                </tr>
                <? 
                $aluno = $l['CD_ALUNO'];
                } 
                ?>
            </table>
        </div>
        <div class="modal-footer">

            <button type="button" class="btn btn-primary2" id="frmProvaCartao">
                <i class="fa fa-file-text"></i> Processar Cartões
            </button>
            <button type="button" class="btn btn-warning2" id="frmProvaSimulado">
                <i class="fa fa-clock-o"></i> Processar Notas
            </button>
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
        
        
        $('#frmProvaSimulado').click(function() {
            swal({
                title: "Lançamento de Notas",
                text: "Tem certeza que deseja processar esse Simulado?",
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sim, Processar!",
                cancelButtonText: "Não, Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: true,
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/processamento/frmProvaSimulado/'.$listar[0]['CD_TIPO_PROVA'].'-'.$original.'') ?>", {
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
        $modal.modal({backdrop: 'static', keyboard: false});
        $modal.load($remote);
    }
);
</script>

</div>
