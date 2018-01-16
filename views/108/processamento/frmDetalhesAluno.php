<div class="modal-dialog modal-lg animated-panel zoomIn" style="animation-delay: 0.1s;">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">

            <i class="fa fa-4x fa-graduation-cap pull-left"></i>
            <h5 class="modal-title">Detalhes do Aluno</h5>
            
        </div>
        <div class="modal-body">
            <div class="well row">
                <div class="col-xs-12">
                    <h6><strong><?=$aluno[0]['TITULO'].' - '.$aluno[0]['DISCIPLINAS']?></strong></h6>
                    <div class="col-xs-6">
                        <table class="table">
                            <tr>
                                <td width="40%" class="text-left">Qtd. Questão: </td>
                                <td><?=$aluno[0]['QTD']?></td>
                            </tr>
                            <tr>
                                <td class="text-left">Valor por Questão:</td>
                                <td><?=number_format($aluno[0]['VL_QUESTAO'],4,'.','')?></td>
                            </tr>
                            <tr>
                                <td class="text-left">Max Objetiva:</td>
                                <td><?=number_format($aluno[0]['VL_T_OBJETIVA'],1,'.','')?></td>
                            </tr>
                            <tr>
                                <td class="text-left">Max Discursiva:</td>
                                <td><?=number_format($aluno[0]['VL_T_DISCURSIVA'],1,'.','')?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-6">
                        <table class="table">
                            <tr>
                                <td width="50%" class="text-right">Qtd. Questão: </td>
                                <td><?=$aluno[0]['QTD']?></td>
                            </tr>
                            <tr>
                                <td class="text-right">Valor por Questão:</td>
                                <td><?=number_format($aluno[0]['VL_QUESTAO'],4,'.','')?></td>
                            </tr>
                            <tr>
                                <td class="text-right">Max Objetiva:</td>
                                <td><?=number_format($aluno[0]['VL_T_OBJETIVA'],1,'.','')?></td>
                            </tr>
                            <tr>
                                <td class="text-right">Max Discursiva:</td>
                                <td><?=number_format($aluno[0]['VL_T_DISCURSIVA'],1,'.','')?></td>
                            </tr>
                        </table>
                    </div>
                    <hr>
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
            <a class="btn btn-info" target="_blank" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_gabarito/avaliacao/?id='.base64_encode($aluno[0]['CD_PROVA_VERSAO']).'&aluno='.base64_encode($aluno[0]['CD_ALUNO']).'')?>">
                <i class="fa fa-file-pdf-o"></i> Prova Corrigida
            </a>
            <a class="btn btn-info" target="_blank" href="https://www.seculomanaus.com.br/gestordeprovas/banco/gabarito/frmImprimir/?id=<?= base64_encode($aluno[0]['CD_PROVA'])?>">
                <i class="fa fa-list-ol"></i> Gabarito Geral
            </a>
        </div>
    </div>
</div>
