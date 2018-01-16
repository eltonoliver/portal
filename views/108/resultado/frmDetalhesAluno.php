<div class="modal-dialog modal-lg animated-panel zoomIn" style="animation-delay: 0.1s;">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">

            <i class="fa fa-4x fa-graduation-cap pull-left"></i>
            <h5 class="modal-title">Detalhes do Aluno</h5>
            
        </div>
        <div class="modal-body">
            <div class="well row">
                <div class="col-xs-12" style="margin-bottom: 15px">
                    <h6><strong><?=$aluno[0]['TITULO'].' - '.$aluno[0]['DISCIPLINAS']?></strong></h6>
                    <div class="col-xs-6">
                        <table class="table">
                            <tr>
                                <td class="text-center">Qtd. Questão: <?=$aluno[0]['QTD']?></td>                                
                            </tr>
                            <tr>
                                <td class="text-center">Valor por Questão: <?=number_format($aluno[0]['VL_QUESTAO'],4,'.','')?></td>                                
                            </tr>                            
                            <tr>
                                <td class="text-center">Max Objetiva: <?=number_format($aluno[0]['VL_T_OBJETIVA'],1,'.','')?></td>
                            </tr>
                            <tr>
                                <td class="text-center">Max Discursiva: <?=number_format($aluno[0]['VL_T_DISCURSIVA'],1,'.','')?></td>                                
                            </tr>
                        </table>
                    </div>                                        
                    </div>
                <br><br><br>
                <div class="col-xs-12">
                    <table class="table">
                        <tr>
                            <td width="10%" class="text-right">Gabarito</td>
                            <? for($i=0; $i < $aluno[0]['QTD'];$i++){ 
                                $s1 = substr($aluno[0]['RESPOSTAS'],$i,1);
                                $s2 = substr($aluno[0]['GABARITO'],$i,1);
                                ?>
                                <td class="bg-<?=(($s1 == $s2)? 'success': 'danger' )?> text-center">
                                    <?=substr($aluno[0]['GABARITO'],$i,1)?>
                                </td>
                            <? } ?>
                        </tr>
                        <tr>
                            <td class="text-right">Respostas</td>
                            <? for($i=0; $i < $aluno[0]['QTD'];$i++){ 
                                $s1 = substr($aluno[0]['RESPOSTAS'],$i,1);
                                $s2 = substr($aluno[0]['GABARITO'],$i,1);
                                ?>
                                <td class="bg-<?=(($s1 == $s2)? 'success': 'danger' )?> text-center">
                                    <?=substr($aluno[0]['RESPOSTAS'],$i,1)?>
                                </td>
                            <? } ?>
                        </tr>
                    </table>
                    <fieldset>
                        
                        <legend>Legenda</legend>
                        Z: QUESTÃO NÃO RESPONDIDA;<br>
                        #: QUESTÃO CANCELADA;<br>
                        *: QUESTÃO ANULADA;<br>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            
            <button type="button" class="btn btn-danger2 pull-left" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>
        </div>
    </div>
</div>
