<!--<div class="alert alert-danger">
        <button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>
        <strong><i class="icon-remove"></i>Cupom Não Localizado!</strong>
        <br><br>
        <?php print_r($cupom)?>
        <br>
</div>-->


<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr><th>Cupom #</th>
                            <th>Produto</th>
                            <th style="text-align: center">Qtde</th>
                            <th style="text-align: right">Valor</th>
                            <th width="200"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cupom as $c){
                            $total += $c->PRECO_UNITARIO;
                            ?>
                        <tr>
                            <td><a href="#"><?=str_pad($c->ID_VENDA, 10, "0", STR_PAD_LEFT)?></a></td>
                            <td><?=$c->NM_MATERIAL?></td>
                            <td style="text-align: center"><?=$c->QUANTIDADE?></td>
                            <td style="text-align: right"><?=number_format($c->PRECO_UNITARIO, 2, ',', '.')?></td>
                            <td style="text-align: center">
                                <div class="btn-group">
                                    <a data-toggle="modal" data-target="#troca<?=$c->ID_VENDA.$c->NR_ORDEM?>" class="btn btn-default" href="#"><i class="fa fa-refresh"></i></a>
                                </div>
                                <?php 
                                $param = urlencode(serialize($c));
                                $url = SCL_RAIZ."refeitorio/cantina/confirma_troca?p=".$param?>
                                <!--modal enviar arquivo-->
                                <div class="modal fade" id="troca<?=$c->ID_VENDA.$c->NR_ORDEM?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                     data-remote="<?=$url?>" > 
                                    <div class="modal-dialog" style="width: 60%;">
                                        <div class="modal-content">
                                            <?= modal_load ?>
                                        </div>
                                    </div>
                                </div>
                                <!--modal enviar arquivo-->
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align: right">Total</td>
                            <td colspan="1" style="text-align: right"><?=number_format($total, 2, ',', '.')?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>