<? $this->load->view('layout/header'); ?>

<div id="content">
    <?// print_r( $this->session->userdata('FRM_TOTAL') )?>
    <div class="row">
        <form action="<?= SCL_RAIZ ?>financeiro/pagamento/pagamento_online" method="post" class="form-horizontal" enctype="multipart/form-data" id="frmadicionar" name="frmadicionar" >
            <div class="col-md-8">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-credit-card"></i>  Pagamento Online </h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                                <tr class="well">
                                    <th></th>
                                    <th>Aluno</th>
                                    <th>Produto</th>
                                    <th>Referência</th>
                                    <th>Bolsa(-)</th>
                                    <th>Multa(+)</th>
                                    <th>Juros(+)</th>
                                    <th>Descontos(+)</th>
                                    <th>Valor R$</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $total = 0;
                                foreach ($this->session->userdata('FRM_PRODUTO') as $row) {
                                    $real = $row;
                                    $row = base64_decode($row);
                                    //echo $row;
                                    $l = explode(':', $row);
                                    $total = $total + $l[5];
                                    ?>
                                    <tr style="font-size:10px" >
                                        <td><input checked name="produto[]" type="checkbox"  value="<?= $real ?>" style="display:none" ></td>
                                        <td height="20px"><?= substr($l[6],0,20) ?></td>
                                        <td><?= $l[7] ?></td>
                                        <td><?= $l[2] ?></td>
                                        <td><?= number_format($l[8], 2, ',', '.') ?></td>
                                        <td><?= number_format($l[10], 2, ',', '.') ?></td>
                                        <td><?= number_format($l[11], 2, ',', '.') ?></td>
                                        <td><?= number_format($l[9], 2, ',', '.') ?></td>
                                        <td><?= number_format($l[5], 2, ',', '.') ?></td>
                                    </tr>
                                <? } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>
                                    </th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 style="font-weight:bold">R$ <?= number_format($this->session->userdata('FRM_TOTAL'),2,',','.') ?></h4></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>    



            <div class="col-md-4">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-exclamation"></i>  Informações do Sistema</h3>
                    </div>
                    <div class="panel-body">
                        <fieldset class="col-sm-12">
                            <legend>Tipo de Transação</legend>


                            <table class="table table-hover" data-page-size="20">
                                <thead>
                                    <tr class="well">
                                        <th>
                                            <select name="txtformaPagamento" id="txtformaPagamento" class="form-control" disabled>
                                                <option <? if ($this->session->userdata('FRM_FORMA_PAGAMENTO') == 'A') echo 'selected'; ?> value="A"><i class="fa fa-credit-card"></i>Débito</option>
                                                <option <? if ($this->session->userdata('FRM_FORMA_PAGAMENTO') == '1') echo 'selected'; ?> value="1">Crédito à Vista</option>
                                            </select>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </fieldset>
                        <fieldset class="col-sm-12">
                            <legend>Bandeira do Cartão</legend>

                            <table class="table table-hover">
                                <thead>
                                    <tr class="well well-inverse">
                                        <th><div class="input-group">
                                    <span class="input-group-addon">
                                        <input <? if ($this->session->userdata('FRM_BANDEIRA') == 'visa') echo 'checked'; ?> disabled name="txtcodigoBandeira" type="radio" required  id="txtcodigoBandeira" value="visa" >
                                    </span>
                                    <img src="<?= SCL_IMG ?>boleto/visa.png" title="Visa" width="100%">
                                </div></th>
                                <th><div class="input-group" style="float:left">
                                    <span class="input-group-addon">
                                        <input <? if ($this->session->userdata('FRM_BANDEIRA') == 'mastercard') echo 'checked'; ?> disabled name="txtcodigoBandeira" type="radio" required  id="txtcodigoBandeira" value="mastercard" >
                                    </span>
                                    <img src="<?= SCL_IMG ?>boleto/mastercard.png" title="MasterCard" width="100%">
                                </div></th>
                                <th><div class="input-group" style="float:left">
                                    <span class="input-group-addon">
                                        <input <? if ($this->session->userdata('FRM_BANDEIRA') == 'elo') echo 'checked'; ?> disabled name="txtcodigoBandeira" type="radio" required  id="txtodigoBandeira" value="elo" >
                                    </span>
                                    <img src="<?= SCL_IMG ?>boleto/elo.png" title="Elo" width="100%"> 
                                </div></th>
                                </tr>
                                </thead>
                            </table>
                        </fieldset>
                    </div>
                    <div class="panel-footer">
                        <a href="<?=base_url()?>financeiro/pagamento" style="border-bottom: 1px solid #fff" class="btn btn-danger btn-sm"> 
                            <i class="fa fa-backward"></i> Voltar
                        </a>
                        <button style="border-bottom: 1px solid #fff" type="submit" name="PagamentoOnline" class="btn btn-success btn-sm"> 
                            <i class="fa fa-credit-card"></i> Finalizar Pagamento
                        </button>
                    </div>
                </div>
            </div>
        
        </form>
    </div> 
</div>

<? $this->load->view('layout/footer'); ?>
