<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header btn-success">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-credit-card"></i> Compra de Crédito</h4>
        </div>
        <form action="<?= SCL_RAIZ ?>financeiro/comprar/credito" method="post" class="form-horizontal" enctype="multipart/form-data" id="frmadicionar" name="frmadicionar" >
            <div class="panel-body">   
                <script src="http://yandex.st/highlightjs/7.3/highlight.min.js"></script>
                <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

                <script type="text/javascript" src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
                <script type="text/javascript" src="<?=base_url('assets/js/jquery.mask.min.js')?>"></script>
                <script>
                    $(document).ready(function(){
                        $('#CESCredito').mask('000,00', {reverse: true});
                    });
                </script>

                <table width="100%" cellpadding="10">
                    <tr>
                        <td width="45%" class="well well-info" align="left">
                            <h4 style="font-weight: bold">Dados do Cartão</h4>
                            Informe o Tipo de Pagamento 
                            <select name="CESFormaPagamento" id="CESFormaPagamento" class="form-control" required>
                                <option value="A"><i class="fa fa-credit-card"></i>DÉBITO A VISTA</option>
                            </select>

                            Escolha o Cartão 
                            <select name="CESCodigoBandeira" id="CESCodigoBandeira" class="form-control" required>
                                <option></option>
                                <option value="visa"><i class="fa fa-credit-card"></i>VISA</option>
                                <option value="mastercard"><i class="fa fa-credit-card"></i>MASTERCARD</option>
                            </select>
                            Valor do Crédito R$ 
                            <input max="7" class="form-control" style="font-size:20px; font-weight: bold" type="text" name="CESCredito" id="CESCredito" required  autocomplete="off"/>
                            <br />
                            <button class="btn btn-success" type="submit" id="frmarquivo_btn" ><i class="fa fa-shopping-cart"></i> Comprar </button>
                        </td>
                        <td width="5%"></td>
                        <td width="50%" class="well">
                             <strong style="font-size:12px"> Bancos que aceitam DÉBITO via WEB.</strong><br />
                            <strong style="font-size:10px"><img src="<?= SCL_IMG ?>boleto/visa.png" title="Visa" width="20%"> VISA ELECTRON:</strong>
                            <br/>
                            <div style="font-size:12px">
                                Banco Bradesco, Banco do Brasil, Santander, HSBC, Itaú, Mercantil, Sicredi, Banco de Brasília, Banco da Amazônia, Banco Espírito Santo e Banco do Nordeste.
                            </div>

                            <br/><strong  style="font-size:10px"><img src="<?= SCL_IMG ?>boleto/mastercard.png" title="MasterCard" width="20%"> MASTERCARD MAESTRO:</strong>
                            <br/>
                            <div style="font-size:12px">
                                Banco Santander, Banco de Brasília e Bancoob.
                            </div>
                            <input type="hidden" name="CESMatriculaAluno" value="<?=base64_decode($this->input->get('token'))?>" />
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
<? exit(); ?>

