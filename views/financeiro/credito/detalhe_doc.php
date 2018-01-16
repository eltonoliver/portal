<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header btn-success">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-arrow-right"></i> Data: <?=$cupom[0]->DT_VENDA?> - Cupom: <?=$cupom[0]->ID_VENDA?> <i class="fa fa-arrow-left"></i></h4>
        </div>
            <div class="panel-body">   

                <table class="table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Unidade Médida</th>
                            <th style="text-align: center">Qtde</th>
                            <th style="text-align: right">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cupom as $c){
                            $total += $c->PRECO_UNITARIO;
                            $qtde  += $c->QUATIDADE;
                            ?>
                        <tr>
                            <td><?=$c->NM_MATERIAL?></td>
                            <td><?=$c->SIGLA?></td>
                            <td style="text-align: center"><?=$c->QUANTIDADE?></td>
                            <td style="text-align: right"><?=number_format($c->PRECO_UNITARIO, 2, ',', '.')?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right">Total</td>
                            <td colspan="1" style="text-align: right"><strong>R$ <?=number_format($total, 2, ',', '.')?></strong></td>
                        </tr>
                    </tfoot>
                </table>
                
                <table class="table">
                    <caption>Detalhe de pagamento</caption>
                    <tbody>
                        <?php foreach ($detalhes as $d){?>
                        <tr>
                            <td style="text-align: left"><?=$d->DC_FORMA_RECEBIMENTO?></td>
                            <td style="text-align: left">R$ <?=number_format($d->VLR_RECEBIDO, 2, ',', '.')?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="1" style="text-align: left">Total</td>
                            <td colspan="1" style="text-align: left"><strong>R$ <?=number_format($total, 2, ',', '.')?></strong></td>
                        </tr>
                    </tfoot>
                </table>

            </div> 
            <div class="modal-footer">
                <button class="btn btn-danger pull-left" data-dismiss="modal" id="frmarquivo_btn" ><i class="fa fa-refresh"></i> Fechar </button>
                
            </div>
        </form>
    </div>
</div>
<? exit(); ?>

