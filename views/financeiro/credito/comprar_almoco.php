<script type="text/javascript">
function calcular(valor,saldo){
        var result = parseFloat(valor) * parseFloat($('#qtde_almoco').val());
        if(result > saldo){
            $("input[name=qtde_almoco]").val("");
            $("input[name=qtde_almoco]").focus();
            $('#msg').html("<strong class='text-danger'>Saldo Insufuciente</strong>");
            $('#botao').html("");
        }else{
            $('#msg').html(""); 
            $('#subtotal').val(result.toFixed(2));
            $('#botao').html("<button class='btn btn-success' type='submit' id='frmarquivo_btn' ><i class='fa fa-shopping-cart'></i> Comprar </button>");
        }
}
</script>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header btn-success">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-credit-card"></i> Compra de Almoço com Crédito</h4>
        </div>
        <form action="<?= SCL_RAIZ ?>financeiro/credito/finalizar_compra_almoco" method="post" class="form-horizontal" enctype="multipart/form-data" id="frmadicionar" name="frmadicionar" >
            <div class="panel-body">   
                <table width="100%" cellpadding="10">
                    <tr>
                        <td width="45%" class="well well-info" align="left">
                            Quantidade de Almoço
                            <?php
                            $desconto = str_replace(",", ".", $dados[0]['PERCENTUAL_DESCONTO']);
                            $vl_desconto = ($dados[0]['VALOR_VENDA'] * $desconto)/100;
                            $valor = $dados[0]['VALOR_VENDA'] - $vl_desconto;
                            ?>
                            <input class="form-control" style="font-size:20px; font-weight: bold" type="number" min="0"
                                      name="qtde_almoco" id="qtde_almoco" required  pattern="[0-9]" 
                                      x-moz-errormessage="Ops. Somente Números." 
                                      onchange="calcular(<?=$valor?>,<?=base64_decode($this->input->get('saldo'))?>)"
                                      value=""/>
                            
                            Total a Descontar de crédito:
                            <br>
                            <input type="text" name="subtotal" id="subtotal" readonly="" value="0.00">
                            <div id="msg"></div>
                            <br>
                            <br>
                            <div id="botao"></div>
                        </td>
                        <td width="5%"></td>
                        <td width="50%" class="well">
                            <strong> Saldo de Crédito: R$ <?= number_format(base64_decode($this->input->get('saldo')), 2, ',', '.') ?></strong>
                            <br/>
                            
                            <strong> Valor do Almoço: R$ <?= number_format($valor, 2, ',', '.') ?></strong><br>
                            <br/>
                            <div style="font-size:12px">
                                Informe a quantidade da almoços que deseja comprar e clique no botão "COMPRAR"
                            </div>

                            <input type="hidden" name="CD_ALUNO" value="<?=base64_decode($this->input->get('token'))?>" />
                            <input type="hidden" name="TIPO_REFEICAO" value="<?=$tipo_refeicao?>" />
                            <input type="hidden" name="CD_MATERIAL" value="<?=$dados[0]['CD_MATERIAL']?>" />
                            <input type="hidden" name="VL_UNITARIO" value="<?=number_format($valor, 2, '.', ',')?>" />
                            
                        </td>
                    </tr>
                </table>

            </div> 
            <div class="modal-footer">
                <button class="btn btn-danger pull-left" data-dismiss="modal" id="frmarquivo_btn" ><i class="fa fa-refresh"></i> Fechar </button>
                
            </div>
        </form>
    </div>
</div>

<?php exit(); ?>


