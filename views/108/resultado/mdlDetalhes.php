<div class="modal-dialog modal-lg" id="mdlAtualizar">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">Detalhes do Processamento</h5>            
        </div>
        <div class="modal-body" style="height: 350px; overflow: auto">
            <div vclass="well row">
                <div class="col-xs-1">
                    <i class="fa fa-4x fa-graduation-cap"></i>
                </div>
                <div class="col-xs-11">
                    <h6><strong><?=$listar[0]['TITULO'].' - '.$listar[0]['DISCIPLINAS']?></strong></h6>
                    <h6>Qtd. Questão: <?=$listar[0]['QTD']?></h6>
                    <h6>Valor por Questão: <?=number_format($listar[0]['VL_QUESTAO'],4,'.','')?></h6>
                    <h6>Max Objetiva: <?=number_format($listar[0]['VL_T_OBJETIVA'],1,'.','')?></h6>
                    <h6>Max Discursiva: <?=number_format($listar[0]['VL_T_DISCURSIVA'],1,'.','')?></h6>
                </div>
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
                    <td class="text-center"></td>
                </tr>
                <? 
                
                foreach($listar as $l){
                
                ?>
                <tr>
                    <td style="font-size: 11px"><?=substr($l['CD_ALUNO'].' - '.$l['NM_ALUNO'],0,50)?></td>
                    <td class="text-center"><?=$l['CD_PROVA_VERSAO']?></td>
                    <td class="text-center"><?=$l['NR_ACERTO'].' / '.($l['NR_ACERTO'] + $l['NR_ERRO'])?></td>
                    <td class="text-center"><?='x'.number_format($l['VL_QUESTAO'],4,'.','')?></td>
                    <td class="bg-warning text-center"><?=(($l['NR_NOTA'] == '')? '-' : number_format($l['NR_NOTA'],1,'.',''))?></td>
                    <td class="bg-warning text-center"><?=(($l['NR_NOTA_DISCURSIVA'] == '')? '-' : number_format($l['NR_NOTA_DISCURSIVA'],1,'.',''))?></td>
                    <td class="bg-success text-center"><?=(($l['NOTA'] == '')? '-' : number_format($l['NOTA'],1,'.',''))?></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-info btn-xs" data-remote="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/resultado/frmDetalhesAluno/'.$l['CD_ALUNO'].'-'.$l['CD_PROVA_VERSAO'].'')?>" data-toggle="frmModalDetalhe">
                            <i class="fa fa-search"></i> Visualizar
                        </button>
                        
                    </td>
                </tr>
                <? } ?>
            </table>
                
        </div>
        <div class="modal-footer">
            
            <a class="btn btn-primary2" target="_blank" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/resultado/pntDetalhes/'.$listar[0]['CD_TIPO_PROVA'].'-'.$listar[0]['CD_PROVA'].'')?>">
                <i class="fa fa-print"></i> Imprimir
            </a>
                        
            <button type="button" class="btn btn-danger2" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>
            
        </div>
    </div>
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
