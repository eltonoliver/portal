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
                </tr>
                <? } ?>
                <tr>
                    <td><?=$l['CD_DISCIPLINA'].' - '.$l['NM_DISCIPLINA']?></td>
                    <td class="text-center"><?=$l['CD_PROVA']?></td>
                    <td class="text-center"><?=$l['NR_ACERTO']?></td>
                    <td class="text-center"><?=$l['NR_ERRO']?></td>
                    <td class="text-center"><?='x'.number_format($l['VL_QUESTAO'],4,'.','')?></td>
                    <td class="bg-success text-center"><?=(($l['NR_NOTA'] == '')? '-' : number_format($l['NR_NOTA'],1,'.',''))?></td>
                </tr>
                <? 
                $aluno = $l['CD_ALUNO'];
                } 
                ?>
            </table>
        </div>
        <div class="modal-footer">
            
            <a class="btn btn-primary2 pull-left" target="_blank" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/resultado/pntDetalhes/'.$listar[0]['CD_TIPO_PROVA'].'-'.$listar[0]['CD_PROVA'].'')?>">
                <i class="fa fa-print"></i> Imprimir
            </a>
            
            <button type="button" class="btn btn-danger2" data-dismiss="modal">
                <i class="fa fa-times"></i> Fechar
            </button>
        </div>
    </div>

</div>
