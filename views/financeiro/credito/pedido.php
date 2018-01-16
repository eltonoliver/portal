<div style="position: fixed; bottom:0px; z-index:99999; float:right; right:16px; width:18%" id="grdpedido" class="well">
    <h3> Meu Pedido </h3>
    <div  style=" overflow: scroll; height: 350px">
        <?
        $total = 0;
        foreach ($selecao as $s) {
            $p = explode(':', $s);

            $total = $total + ($p[1] * $p[2]);
            ?>
            <div>
                <h4><?= $p[3] ?>
                    <h4 style="text-align: right"><strong><?= $p[1] ?>X R$ <?= number_format(($p[1] * $p[2]), 2, ',', '.') ?></strong></h5>
                    </h4>
            </div>
        <? } ?>
    </div>
    <div style="background:#CC0; padding: 5px">
        <h5>Total
            <br/><h3>R$ <?= number_format($total, 2, ',', '.') ?></h3>
        </h5>
        <? if ($total > 0) { ?>
            <a class="btn btn-success" type="text" data-toggle="modal" data-target="#libera"><i class="fa fa-credit-card"></i> Finalizar Pedido</a>
            <!-- /.main-content -->
            <div class="modal fade" id="libera" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form name="frmpedido" id="frmpedido" method="post" action="<?= SCL_RAIZ ?>financeiro/credito/pedido" >
                            <div class="modal-header btn-success">
                                <a type="button" class="close" onclick="fechar('libera');" aria-hidden="true">&times;</a>
                                <h4><i class="fa fa-user"></i> Confirmar Compra</h4>
                            </div>
                            <div class="modal-body">
                                Como deseja pagar este pedido?
                                <?
                                foreach ($selecao as $s) {
                                    ?>
                                    <input type="hidden" value="<?= $s ?>" name="pedido[]" />
                                <? } ?>
                                <input type="hidden" value="<?= base64_encode($aluno) ?>" name="aluno" />
                            </div>
                            <div class="modal-footer">
                                <input type="submit" />
                                <a type="none" class="btn btn-success" onclick="javascript:enviar();" id="btnvalidar" name="btnvalidar" ><i class="fa fa-user"></i> Crédito do Aluno</a>
                                <a class="btn btn-default pull-left" type="text" onclick="fechar('libera');"><i class="fa fa-sign-out"></i> Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.modal -->
        <? } ?>
    </div>

</div>
<? exit; ?>