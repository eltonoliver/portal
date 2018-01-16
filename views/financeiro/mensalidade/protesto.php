<? $this->load->view('layout/header'); ?>


<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-barcode"></i>  Boletos em Protesto</h3>
                </div>
                <div class="panel-body">
                    
                    <ul class="nav nav-pills col-sm-6">
                        <li class=""><a href="<?= SCL_RAIZ ?>financeiro/boleto" >Título</a></li>
                        <li class="active"><a href="<?= SCL_RAIZ ?>financeiro/boleto/protesto" >Título(s) em Protesto(s)</a></li>
                    </ul>
                    
                    <div class="pull-right col-sm-6">
                        <a href="<?= SCL_RAIZ ?>financeiro/boleto/protesto" class="pull-right" ><img src="<?= SCL_IMG ?>cielo.png" style="width:70%"></a>
                    </div>

                    <hr class="col-sm-12"/>
                    
                    <table class="table table-hover" id="conteudo_aula" data-page-size="20">
                        <thead>
                            <tr class="well">
                                <th>#</th>
                                <th>ALUNO</th>
                                <th>REF.</th>
                                <th>DESCRIÇÃO</th>
                                <th>VENCIMENTO</th>
                                <th>VALOR R$</th>
                                <th>(-) R$</th>
                                <th>(+) R$</th>
                                <th>PAGO</th>
                                <th style="5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                            foreach ($boleto as $row) {
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
                                $acrescimo = $row['JUROS_INTEGRAL'] + $row['JUROS_CALCULADO'];
                                ?>
                                    ">
                                    <td>
                                        <? if (empty($row['DT_BAIXA']) && $row['FLG_IMPRIME_SICANET'] = 1 && $row['NOSSO_NUMERO']) { ?>       
                                            <input name="produto[]" type="checkbox"  value="<?= base64_encode($row['CD_ALUNO'] . ':' . $row['CD_PRODUTO'] . ':' . $row['MES_REFERENCIA'] . ':' . $row['NUM_PARCELA'] . ':' . $row['NR_ORDEM'] . ':' . $row['VALOR_BOLETO'] . ':' . $row['NM_ALUNO'] . ':' . $row['NM_PRODUTO']); ?>"   />
                                        <? } ?>
                                    </td>
                                    <td><?= substr($row['NM_ALUNO'], 0, 15) ?></td>
                                    <td><?= $row['MES_REFERENCIA'] ?></td>
                                    <td><?= substr($row['NM_PRODUTO'], 0, 17) ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['DT_VENCIMENTO'])) ?></td>
                                    <td><?= number_format($row['VALOR_BOLETO'], 2, ',', '.') ?></td>
                                    <td><?= number_format($desconto, 2, ',', '.') ?></td>
                                    <td><?= number_format($acrescimo, 2, ',', '.') ?></td>
                                    <td><?= number_format($row['VALOR_RECEBIDO'], 2, ',', '.') ?></td>
                                    <td>
                                        <?
                                        if (empty($row['DT_BAIXA']) && $row['FLG_IMPRIME_SICANET'] = 1 && $row['NOSSO_NUMERO']) {

                                            echo "<form action='" . base_url() . "financeiro/boleto/imprimir/' target='_blank' method='post' name='form_imprimir_" . $row['CD_ALUNO'] . $row['CD_PRODUTO'] . $row['MES_REFERENCIA'] . "'>";
                                            echo "<input name='aluno' type='hidden' id='aluno' value='" . $row['CD_ALUNO'] . "' />";
                                            echo "<input name='protesto' type='hidden' id='protesto' value='" . $row['CD_PROTESTO'] . "' />";
                                            echo '<button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-credit-card"></i> Boleto</button>';
                                            echo "</form>";
                                        } elseif ($row['NFSE_NUMERO'] != '') {
                                            echo '<a href="https://www.seculomanaus.com.br/portal/application/upload/aluno/' . $row['CD_ALUNO'] . '/Arquivos/Pagamentos/' . $row['NFSE_NUMERO'] . '.pdf" target="_blank"  > <i class="fa fa-download"></i> NFS-E</a>';
                                        }
                                        ?>

                                    </td>
                                </tr>
                                <?
                                $i = $i + 1;
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="10" class="well well-info" height="42px" align="left" valign="middle">


                                </td>
                            </tr>
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
    </div>
</div>




<!-- /.modal -->
<script src="<?= SCL_JS ?>jquery.dataTables.min.js"></script> 
<script src="<?= SCL_JS ?>jquery.dataTables.bootstrap.js"></script> 
<script>
    //
    $('#conteudo_aula').dataTable({
        "sPaginationType": "full_numbers"
    });
</script>
<? $this->load->view('layout/footer'); ?>
