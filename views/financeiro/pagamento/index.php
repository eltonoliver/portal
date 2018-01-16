<? $this->load->view('layout/header'); ?>

<div id="content">
    <form onsubmit="return validar(this);" method="POST" name="frmpagamento" id="frmpagamento" action="<?= SCL_RAIZ ?>financeiro/pagamento/validacao" >
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-credit-card"></i>  Pagamento Online </h3>
                    </div>
                    <div class="panel-body">

                        <table class="table table-hover" id="boleto">
                            <thead>
                                <tr class="well">
                                    <th>#</th>
                                    <th>ALUNO</th>
                                    <th>REF.</th>
                                    <th>DESCRIÇÃO</th>
                                    <th>VENCIMENTO</th>
                                    <th>VALOR R$</th>
                                    <th style="5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <input name="produto[]" type="hidden" required/>
                            <?
                            echo count($boleto);
                            if (count($boleto) > 0) {
                                foreach ($boleto as $row) {
                                    if (empty($row['DT_BAIXA']) && $row['FLG_IMPRIME_SICANET'] = 1  && $row['TITULO_PROTESTADO'] == 'N') {
                                        ?>
                                        <tr class="<?
                            if (empty($row['DT_BAIXA'])) {
                                if (strtotime($row['DT_VENCIMENTO']) < strtotime(date('d-m-Y')))
                                    echo "danger";
                                else
                                    echo "alt";
                            }else {
                                echo "success";
                            }

                            $desconto = $row['VL_BOLSA'] + $row['OUTROS_DESCONTOS'];
                            $acrescimo = $row['MULTA_CALCULADA'] + $row['JUROS_CALCULADO'];
                            $valorTotal = $acrescimo + $row['VALOR_BOLETO'];
                                        ?>"  >
                                            <td>    
                                                <input name="produto[]" type="checkbox"  value="<?=
                            base64_encode($row['CD_ALUNO'] . ':' .   // [0] - CODIGO DO ALUNO
                                    $row['CD_PRODUTO'] . ':' .       // [1] - CODIGO DO PRODUTO
                                    $row['MES_REFERENCIA'] . ':' .   // [2] - MES DE REFERENCIA CASO SEJA MENSALIDADE
                                    $row['NUM_PARCELA'] . ':' .      // [3] - NUMERO DA MENSALIDADE
                                    $row['NR_ORDEM'] . ':' .         // [4] - ORDEM DO BOLETO
                                    $valorTotal . ':' .              // [5] - VALOR TOTAL DO BOLETO
                                    $row['NM_ALUNO'] . ':' .         // [6] - NOME DO ALUNO PARA MONTAR O GRID
                                    $row['NM_PRODUTO'] . ':' .       // [7] - NOME DO PRODUTO
                                    $row['VL_BOLSA'] . ':' .         // [8] - VALOR DA BOLSA
                                    $row['OUTROS_DESCONTOS'] . ':' . // [9] - VALOR DE OUTROS DESCONTOS
                                    $row['MULTA_CALCULADA'] . ':' .  // [10] - VALOR DA MULTA CALCULADA
                                    $row['JUROS_CALCULADO'] . ':' .  // [11] - VALOR DO JUROS CALCULADO
                                    $row['OUTROS_DESCONTOS'] . ':' . // [12] - VALOR DE OUTROS DESCONTOS
                                    $row['VL_BOLSA']                 // [13] - VALOR DA BOLSA
                            );
                                        ?>" >
                                            </td>
                                            <td><?= substr($row['NM_ALUNO'], 0, 15) ?></td>
                                            <td><?= $row['MES_REFERENCIA'] ?></td>
                                            <td><?= substr($row['NM_PRODUTO'], 0, 17) ?></td>
                                            <td><?= date('d/m/Y', strtotime($row['DT_VENCIMENTO'])) ?></td>
                                            <td><?= number_format($valorTotal, 2, ',', '.') ?></td>
                                            <td></td>
                                        </tr>
                                        <?
                                    }
                                }
                            }
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="10" class="well right" align="right">
                                        * Use o pesquisar para filtrar os regitros, por <strong>Aluno, Referência ou Vencimento</strong>.
                                    </td>
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
                                            <select name="formaPagamento" id="formaPagamento" class="form-control" required onchange="ocultar('formaPagamento')">
                                                <option></option>
                                                <option value="A"><i class="fa fa-credit-card"></i>Débito</option>
                                                <option value="1">Crédito à Vista</option>
                                            </select>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </fieldset>
                        <fieldset class="col-sm-12">
                            <legend>Bandeira do Cartão</legend>

                            <table class="table table-hover"  data-page-size="20">
                                <thead>
                                    <tr class="well">
                                        <th><div class="input-group">
                                    <span class="input-group-addon">
                                        <input name="codigoBandeira" type="radio" required id="codigoBandeira" value="visa" required>
                                    </span>
                                    <img src="<?= SCL_IMG ?>boleto/visa.png" title="Visa" width="100%">
                                </div></th>
                                <th><div class="input-group" style="float:left">
                                    <span class="input-group-addon">
                                        <input name="codigoBandeira" type="radio" required id="codigoBandeira" value="mastercard" >
                                    </span>
                                    <img src="<?= SCL_IMG ?>boleto/mastercard.png" title="MasterCard" width="100%">
                                </div></th>
                                <th><div class="input-group" style="float:left" id="elo" >
                                    <span class="input-group-addon">
                                        <input name="codigoBandeira"  type="radio" required id="codigoBandeira" value="elo" >
                                    </span>
                                    <img src="<?= SCL_IMG ?>boleto/elo.png"  title="Elo" width="100%"> 
                                </div></th>
                                </tr>
                                </thead>
                            </table>
                        </fieldset>
                    </div>
                    <div class="panel-footer">
                        <button style="border-bottom: 1px solid #fff" type="submit" name="PagamentoOnline" class="btn btn-success btn-sm"> 
                            <i class="fa fa-credit-card"></i> Continuar Pagando
                        </button>
                    </div>
                </div>
            </div>




        </div>
    </form>
</div>

<!-- /.modal -->
<script src="<?= SCL_JS ?>jquery.dataTables.min.js"></script> 
<script src="<?= SCL_JS ?>jquery.dataTables.bootstrap.js"></script> 
<script>
        //
        $('#boleto').dataTable({
            "sPaginationType": "full_numbers"
        });
        function ocultar(id) {
            var tipo = document.getElementById(id).value;
            if (tipo == "A")
                document.getElementById('elo').style.display = 'none';
            else
                document.getElementById('elo').style.display = '';
        }
</script>
<? $this->load->view('layout/footer'); ?>
