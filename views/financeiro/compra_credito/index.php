<div class="modal-dialog modal-lg" id="FRMRetorno<?= $id ?>">
    <script src="<?=base_url('assets/js/jquery.mask.min.js')?>" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
          $(".aluno").change(function(){
            var total = 0;
            $('.aluno').each(function(){
              var valor = Number($(this).val());
              if (!isNaN(valor)) total += valor;
            });
            $("input[name='Total']").val(total.toFixed(2));
          });
        });
    </script>
    <div class="modal-content">
        <div class="modal-header btn-success">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-credit-card"></i> Compra de Crédito</h4>
        </div>
        <form id="frmRegistro" name="frmRegistro" >
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12" style="display: none">
                        <strong style="font-size:12px"> Bancos que aceitam DÉBITO via WEB.</strong><br />
                        <div class="col-sm-6">
                            <strong style="font-size:10px">
                                <img src="<?=base_url('assets/images/boleto/visa.png')?>" title="Visa" width="20%"> 
                                VISA ELECTRON:
                            </strong>
                            <br/>
                            <div style="font-size:12px">
                                Banco Bradesco,
                                Banco do Brasil,
                                Santander,
                                HSBC,
                                Itaú,
                                Mercantil,
                                Sicredi,
                                Banco de Brasília,
                                Banco da Amazônia,
                                Banco Espírito Santo e 
                                Banco do Nordeste.
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <strong  style="font-size:10px">
                                <img src="<?=base_url('assets/images/boleto/mastercard.png')?>" title="MasterCard" width="20%"> 
                                MASTERCARD MAESTRO:
                            </strong>
                            <br/>
                            <div style="font-size:12px">
                                Banco Santander, Banco de Brasília e Bancoob.
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <fieldset>
                            <legend>Meus Alunos</legend>
                            <?=$alunos?>
                        </fieldset>
                    </div>
                    <div class="col-sm-6 well">
                        <h4 style="font-weight: bold">Dados do Cartão</h4>
                        <div class="col-sm-6" style="padding-left: 0px">
                            <small>Tipo de Pagamento </small>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-credit-card"></i>
                                </span>
                                <select name="FormaPagamento" id="FormaPagamento" class="form-control" required>
                                    <option></option>
                                    <!--option value="A">DÉBITO A VISTA</option-->
                                    <option value="1">CRÉDITO A VISTA</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6" style="padding-left: 0px">
                            <small>Bandeira</small>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-credit-card"></i>
                                </span>
                                <select name="Bandeira" id="Bandeira" class="form-control" required>
                                    <option></option>
                                    <option value="visa"><i class="fa fa-credit-card"></i>VISA</option>
                                    <option value="mastercard"><i class="fa fa-credit-card"></i>MASTERCARD</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-8" style="padding-left: 0px">
                            <small>
                                Número do Cartão
                                <i style="color:#FF0000">( somente números )</i>
                            </small>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-credit-card"></i>
                                </span>
                                <input class="form-control" 
                                       maxlength="19"
                                       style="font-size:16px; font-weight: bold" 
                                       name="Cartao" 
                                       id="Cartao"
                                       required
                                       type="number"
                                       min="10000000000000"
                                       max="9999999999999999999"
                                />
                            </div>
                        </div>
                        <div class="col-sm-4" style="padding-left: 0px">
                            <small>CVC</small>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input maxlength="4"
                                       class="form-control" 
                                       style="font-size:16px; font-weight: bold" 
                                       type="text" 
                                       name="Cvc" 
                                       id="Cvc" 
                                       required
                                       />
                            </div>
                        </div>
                        <div class="col-sm-12" style="padding-left: 0px">
                            <small>Nome</small>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </span>
                                <input maxlength="50"
                                       class="form-control" 
                                       style="font-size:16px; font-weight: bold"
                                       type="text" 
                                       name="Nome" 
                                       id="Nome"
                                       />
                            </div>
                        </div>
                        <div class="col-sm-6" style="padding-left: 0px">
                            <small>Validade ( mm/aaaa )</small>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input maxlength="8"
                                       class="form-control Vencimento" 
                                       style="font-size:16px; font-weight: bold" 
                                       type="text" 
                                       name="Vencimento" 
                                       id="Vencimento" 
                                       placeholder="mm/aaaa"
                                       required
                                       />
                            </div>
                        </div>
                        <div class="col-sm-6" style="padding-left: 0px">
                            <small>Valor Total</small>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-money"></i>
                                </span>
                                <input 
                                    class="form-control"
                                    type="text"
                                    style="font-size:16px; font-weight: bold; color:#FF0000; text-align: right" 
                                    name="Total"
                                    id="Total"
                                    required
                                    readonly="readonly"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger pull-left" data-dismiss="modal" id="frmarquivo_btn" >
                    <i class="fa fa-refresh"></i> Fechar
                </button>
                <button class="btn btn-success pull-right btn-lg" type="submit"  >
                    <i class="fa fa-shopping-cart"></i> Pagar Crédito
                </button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    
$(document).ready(function (e) {
    
    $('.Vencimento').mask('00/0000');
    
    $("#frmRegistro").on('submit',(function(e) {
    	e.preventDefault();
        $("#FRMRetorno<?= $id ?>").html('<?=modal_load?>');
	$.ajax({
            url: "<?=base_url('financeiro/compra_credito/transacao')?>",  // Url to which the request is send
            type: "POST",      			     // Type of request to be send, called as method
            data:  new FormData(this), 		     // Data sent to server, a set of key/value pairs representing form fields and values 
            contentType: false,       		     // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
            cache: false,		             // To unable request pages to be cached
            processData:false,  		     // To send DOMDocument or non processed data file it is set to false (i.e. data should not be in the form of string)
            success: function(data){  		
                $("#FRMRetorno<?= $id ?>").html(data);
            }
       });
    }));
});
</script>
<? exit(); ?>

