<div class="modal-header btn-info">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><i class="fa fa-credit-card"></i> Pagamento Online</h3>
</div>
<form action="<?= SCL_RAIZ ?>financeiro/pagamento/pagamento_online" method="post" class="form-horizontal" enctype="multipart/form-data" id="frmadicionar" name="frmadicionar" >
    <div class="modal-body">
        <div class="row">
            <div class="col-xs-4"> 
                <div class="col-md-12">   
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Bandeiras</h3>
                        </div>
                        <div class="panel-body">
                            <span class="blue bigger-150">
                                <label class="inline">
                                    <input name="codigoBandeira" type="radio" class="ace" id="codigoBandeira" value="visa" >
                                    <span class="lbl"></span> </label>
                                <img src="<?= SCL_IMG ?>boleto/visa.png" title="Visa" width="20%">
                                <label class="inline">
                                    <input name="codigoBandeira" type="radio" class="ace" id="codigoBandeira" value="mastercard" >
                                    <span class="lbl"></span> </label>
                                <img src="<?= SCL_IMG ?>boleto/mastercard.png" title="MasterCard" width="20%"> 
                                <!--img src="<?= SCL_IMG ?>boleto/american.png" title="American"--> 
                                <!--img src="<?= SCL_IMG ?>boleto/itau.png" title="Itau"-->
                                <label class="inline">
                                    <input name="codigoBandeira" type="radio" class="ace" id="codigoBandeira" value="elo" >
                                    <span class="lbl"></span> </label>
                                <img src="<?= SCL_IMG ?>boleto/elo.png" title="Elo" width="20%"> 
                                <!--img src="<?= SCL_IMG ?>boleto/boleto.png" title="Boleto" --> 
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">   
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Formas de Pagamento</h3>
                        </div>
                        <div class="panel-body">
                            <span class="blue bigger-150">
                                <label class="inline">
                                    <input name="formaPagamento" type="radio" class="ace" id="formaPagamento" value="A" >
                                    <span class="lbl"></span><span class="grey bigger-110">Débito</span> </label>
                                <label class="inline">
                                    <input name="formaPagamento" type="radio" class="ace" id="formaPagamento" value="1" >
                                    <span class="lbl"></span> <span class="grey bigger-110"> Crédito à Vista</span></label>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-8">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Boletos</h3>
                    </div>
                    <div class="panel-body">

                        <table class="table-bordered table-striped table-condensed rt cf" id="rt1">
                            <thead class="cf">
                                <tr>
                                    <th>Selecione</th>
                                    <th>Aluno</th>
                                    <th class="numeric">Ref.</th>
                                    <th class="numeric">Descrição</th>
                                    <th class="numeric">Vencimento</th>
                                    <th class="numeric">Vencimento</th>
                                    <th class="numeric">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                if (count($boleto) > 0) {
                                    foreach ($boleto as $row) {
                                        if (empty($row['DT_BAIXA']) && $row['FLG_IMPRIME_SICANET'] = 1 && $row['NOSSO_NUMERO']) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <input name="produto[]" type="checkbox" class="ace" id="produto" 
                                                           value="<?= base64_encode('aluno:' . $row['CD_ALUNO'] . 
                                                                                    '-produto:' . $row['CD_PRODUTO'] . 
                                                                                    '-ref:' . $row['MES_REFERENCIA'] . 
                                                                                    '-parcela:' . $row['NUM_PARCELA'] .  '-ordem:' . $row['NR_ORDEM']); ?>" >
                                                </td>
                                                <td><?= substr($row['NM_ALUNO'], 0, 15) ?></td>
                                                <td class="numeric"><?= $row['MES_REFERENCIA'] ?></td>
                                                <td class="numeric"><?= substr($row['NM_PRODUTO'], 0, 17) ?></td>
                                                <td class="numeric"><?= date('d/m/Y', strtotime($row['DT_VENCIMENTO'])) ?></td>
                                                <td class="numeric"><?= number_format($row['VALOR_BOLETO'], 2, ',', '.') ?></td>
                                            </tr>
                                            <?
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="retorno"></div>
<div class="modal-footer">
    <button class="btn btn-danger" data-dismiss="modal" id="frmarquivo_btn" ><i class="fa fa-pencil"></i> Fechar </button>
    <button type="submit" value="Submit" class="btn btn-primary" id="frmarquivo_btn" ><i class="fa fa-save"></i> Pagar </button>
</div>
</form>

<script type="text/javascript">
  /*  $(document).ready(function() {
        jQuery('#frmadicionar').submit(function() {
            var dados = jQuery(this).serialize();
            jQuery.ajax({
                type: "POST",
                url: "<?= SCL_RAIZ ?>financeiro/pagamento/pagamento_online",
                data: dados,
                success: function(data)
                {
                    $("#retorno").html(data);
                }
            });

            return false;
        });
    });
*/
</script>
<? exit(); ?>
