<?php $this->load->view('layout/header'); ?>

<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel-body">  
                <?= get_msg("mensagem"); ?>

                <?php
                $i = 0;
                foreach ($mensalidade as $row) {
                    if (empty($row['DT_BAIXA']) and strtotime(implode("-", array_reverse(explode("/", $row['DT_VENCIMENTO'])))) <= strtotime(implode("-", array_reverse(explode("/", date('d/m/Y')))))) {
                        $i++;
                    }
                }
                ?>               
                <ul class="nav nav-tabs">
                    <li class="<?php
                    if ($i > 0) {
                        echo 'active';
                    }
                    ?>"><a href="#home" data-toggle="tab">Vencidos</a></li>
                    <li class="<?php
                    if ($i == 0) {
                        echo 'active';
                    }
                    ?>"><a href="#profile" data-toggle="tab">A Vencer</a></li>
                    <li><a href="#messages" data-toggle="tab">Pagos</a></li>
                </ul>
                <div class="tab-content">
                    <!--boletos vencidos-->
                    <div class="tab-pane <?php
                    if ($i > 0) {
                        echo 'active';
                    }
                    ?>" id="home">
                        <div class="well">
                            <table class="table table-hover" id="titulos_vencidos" data-page-size="20">
                                <thead>
                                    <tr class="well">                                    
                                        <th class="text-center">ALUNO</th>
                                        <th class="text-center">REF.</th>
                                        <th class="text-center">PRODUTO</th>
                                        <th class="text-center" style="width: 5%"><strong>VENCIMENTO</strong></th>
                                        <th class="text-center">VALOR R$</th>
                                        <th class="text-center">PAGO</th>
                                        <th class="text-center" style="width: 5%"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    foreach ($mensalidade as $row) {

                                        if (empty($row['DT_BAIXA']) and strtotime(implode("-", array_reverse(explode("/", $row['DT_VENCIMENTO'])))) <= strtotime(implode("-", array_reverse(explode("/", date('d/m/Y')))))) {
                                            ?>
                                            <tr class="<?php
                                            $i = 0;

                                            echo "danger";
                                            $desconto = $row['VL_BOLSA'] + $row['OUTROS_DESCONTOS'];
                                            $acrescimo = $row['JUROS_INTEGRAL'] + $row['JUROS_CALCULADO'];
                                            ?>
                                                ">                                        
                                                <td class="text-center"><?= $row['NM_ALUNO'] ?></td>
                                                <td class="text-center" style="width: 7%"><?= $row['MES_REFERENCIA'] ?></td>
                                                <td class="text-center" style="width: 15%"><?= mb_substr($row['NM_PRODUTO'], 0, 17, 'UTF-8') ?></td>
                                                <td class="text-center" style="width: 10%"><?= formata_data($row['DT_VENCIMENTO'], 'br') ?></td>
                                                <td class="text-center" style="width: 10%"><?= number_format($row['VALOR_BOLETO'], 2, ',', '.') ?></td>
                                                <td class="text-center" style="width: 10%"><?= number_format($row['VALOR_RECEBIDO'], 2, ',', '.') ?></td>
                                                <td class="text-center" style="width: 5%">
                                                    <?php
                                                    if ($row['FLG_JURIDICAO'] != 1) {
                                                        if ($row['CD_BANCO'] == 341 and $row['REGISTRADA']) {
                                                            //echo '<a href="' . SCL_RAIZ . 'financeiro/boleto/boleto_vencido?aluno=' . $row['CD_ALUNO'] . '&produto=' . $row['CD_PRODUTO'] . '&mes=' . $row['MES_REFERENCIA'] . '&parcela=' . $row['NUM_PARCELA'] . '&ordem=' . $row['NR_ORDEM'] . '" class="btn btn-primary btn-xs" data-toggle="frmCredito" data-target="#frmCredito"><i class="fa fa-credit-card"></i> Boleto</a>';
                                                        } else {
                                                            if (empty($row['DT_BAIXA']) && $row['FLG_IMPRIME_SICANET'] = 1 && $row['NOSSO_NUMERO'] && $row['DT_ENVIADO'] != '') {

                                                                echo "<form action='" . base_url() . "financeiro/boleto/imprimir/' target='_blank' method='post' name='form_imprimir_" . $row['CD_ALUNO'] . $row['CD_PRODUTO'] . $row['MES_REFERENCIA'] . "'>";
                                                                echo "<input name='aluno' type='hidden' id='aluno' value='" . $row['CD_ALUNO'] . "' />";
                                                                echo "<input name='banco' type='hidden' id='banco' value='" . $row['CD_BANCO'] . "' />";
                                                               echo "<input name='produto' type='hidden' id='produto' value='" . $row['CD_PRODUTO'] . "' />";
                                                                echo "<input name='mes' type='hidden' id='mes' value='" . $row['MES_REFERENCIA'] . "' />";
                                                                echo "<input name='parcela' type='hidden' id='parcela' value='" . $row['NUM_PARCELA'] . "' />";
                                                                echo "<input name='ordem' type='hidden' id='ordem' value='" . $row['NUM_PARCELA'] . "' />";
                                                               echo '<button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-credit-card"></i> Boleto</button>';
                                                                echo "</form>";
                                                            } elseif ($row['NFSE_NUMERO'] != '') {
                                                                echo '<a href="https://www.seculomanaus.com.br/portal/application/upload/aluno/' . $row['CD_ALUNO'] . '/Arquivos/Pagamentos/' . $row['NFSE_NUMERO'] . '.pdf" target="_blank"  > <i class="fa fa-download"></i> NFS-E</a>';
                                                            }
                                                        }
                                                    }
                                                    ?>

                                                </td>
                                            </tr>
                                            <?php
                                            $i = $i + 1;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!--boletos a vencer-->
                    <div class="tab-pane <?php
                    if ($i == 0) {
                        echo 'active';
                    }
                    ?>" id="profile">
                        <div class="well">
                            <table class="table table-hover" id="titulos_a_vencer" data-page-size="20">
                                <thead>
                                    <tr class="well">                                    
                                        <th class="text-center">ALUNO</th>
                                        <th class="text-center">REF.</th>
                                        <th class="text-center">PRODUTO</th>
                                        <td class="text-center" style="width: 5%"><strong>VENCIMENTO</strong></td>
                                        <th class="text-center">VALOR R$</th>
                                        <th class="text-center">(-) R$</th>
                                        <th class="text-center">(+) R$</th>
                                        <th class="text-center">PAGO</th>
                                        <th class="text-center">PAGAR</th>
                                        <th class="text-center"></th>                                    
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    foreach ($mensalidade as $row) {

                                        if (empty($row['DT_BAIXA']) && strtotime(implode("-", array_reverse(explode("/", $row['DT_VENCIMENTO'])))) > strtotime(implode("-", array_reverse(explode("/", date('d/m/Y')))))) {
                                            ?>
                                            <tr class="<?php
                                            $i = 0;
                                            echo "danger";
                                            $desconto = $row['VL_BOLSA'] + $row['OUTROS_DESCONTOS'];
                                            $acrescimo = $row['JUROS_INTEGRAL'] + $row['JUROS_CALCULADO'];
                                            ?>
                                                ">                                        
                                                <td class="text-center"><?= $row['NM_ALUNO'] ?></td>
                                                <td class="text-center" style="width: 7%"><?= $row['MES_REFERENCIA'] ?></td>
                                                <td class="text-center" style="width: 15%"><?= mb_substr($row['NM_PRODUTO'], 0, 17, 'UTF-8') ?></td>
                                                <td class="text-center" style="width: 5%"><?= formata_data($row['DT_VENCIMENTO'], 'br') ?></td>
                                                <td class="text-center" style="width: 7%"><?= number_format($row['VALOR_BOLETO'], 2, ',', '.') ?></td>
                                                <td class="text-center" style="width: 7%"><?= number_format($desconto, 2, ',', '.') ?></td>
                                                <td class="text-center" style="width: 7%"><?= number_format($acrescimo, 2, ',', '.') ?></td>
                                                <td class="text-center" style="width: 7%"><?= number_format($row['VALOR_RECEBIDO'], 2, ',', '.') ?></td>
                                                <td class="text-center">
                                                    
                                                </td>
                                                <td class="text-center" style="width: 3%">
                                                    <?php
                                                    if (empty($row['DT_BAIXA']) && $row['FLG_IMPRIME_SICANET'] = 1  && $row['NOSSO_NUMERO'] > 99999999 && $row['DT_ENVIADO'] != '') {

                                                        echo "<form action='" . base_url() . "financeiro/boleto/imprimir/' target='_blank' method='post' name='form_imprimir_" . $row['CD_ALUNO'] . $row['CD_PRODUTO'] . $row['MES_REFERENCIA'] . "'>";
                                                       echo "<input name='aluno' type='hidden' id='aluno' value='" . $row['CD_ALUNO'] . "' />";
                                                        echo "<input name='banco' type='hidden' id='banco' value='" . $row['CD_BANCO'] . "' />";
                                                        echo "<input name='produto' type='hidden' id='produto' value='" . $row['CD_PRODUTO'] . "' />";
                                                        echo "<input name='mes' type='hidden' id='mes' value='" . $row['MES_REFERENCIA'] . "' />";
                                                        echo "<input name='parcela' type='hidden' id='parcela' value='" . $row['NUM_PARCELA'] . "' />";
                                                        echo "<input name='ordem' type='hidden' id='ordem' value='" . $row['NR_ORDEM'] . "' />";
                                                        echo '<button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-credit-card"></i> Boleto</button>';
                                                        echo "</form>";
                                                    } elseif ($row['NFSE_NUMERO'] != '') {
                                                        echo '<a href="https://www.seculomanaus.com.br/portal/application/upload/aluno/' . $row['CD_ALUNO'] . '/Arquivos/Pagamentos/' . $row['NFSE_NUMERO'] . '.pdf" target="_blank"  > <i class="fa fa-download"></i> NFS-E</a>';
                                                    }
                                                    ?>

                                                </td>                                        
                                            </tr>
                                            <?php
                                            $i = $i + 1;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!--boletos pagos-->
                    <div class="tab-pane" id="messages">
                        <div class="well">                            
                            <table class="table table-hover" id="titulos_pagos" data-page-size="20" >
                                <thead>
                                    <tr class="well">                                        
                                        <th class="text-center">ALUNO</th>
                                        <th class="text-center">REF.</th>
                                        <th class="text-center">PRODUTO</th>
                                        <th class="text-center">VENCIMENTO</th>
                                        <th class="text-center">VALOR R$</th>
                                        <th class="text-center">(-) R$</th>
                                        <th class="text-center">(+) R$</th>
                                        <th class="text-center">PAGO</th>
                                        <th class="text-center"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    foreach ($mensalidade as $row) {
                                        if (!empty($row['DT_BAIXA'])) {
                                            $i = 0;
                                            $desconto = $row['VL_BOLSA'] + $row['OUTROS_DESCONTOS'];
                                            $acrescimo = $row['JUROS_INTEGRAL'] + $row['JUROS_CALCULADO'];
                                            ?>                                            

                                            <tr class="success">                                                                                       
                                                <td class="text-center"><?= $row['NM_ALUNO'] ?></td>
                                                <td class="text-center" style="width: 7%"><?= $row['MES_REFERENCIA'] ?></td>
                                                <td class="text-center" style="width: 15%"><?= mb_substr($row['NM_PRODUTO'], 0, 17, 'UTF-8') ?></td>
                                                <td class="text-center" style="width: 5%"><?= formata_data($row['DT_VENCIMENTO'], 'br') ?></td>
                                                <td class="text-center" style="width: 7%"><?= number_format($row['VALOR_BOLETO'], 2, ',', '.') ?></td>
                                                <td class="text-center" style="width: 7%"><?= number_format($desconto, 2, ',', '.') ?></td>
                                                <td class="text-center" style="width: 7%"><?= number_format($acrescimo, 2, ',', '.') ?></td>
                                                <td class="text-center" style="width: 7%"><?= number_format($row['VALOR_RECEBIDO'], 2, ',', '.') ?></td>
                                                <td class="text-center" style="width: 10%">
                                                    <?php if ($row['NFSE_NUMERO'] != '') { ?>

                                                      <!--  <a href="http://visualizar.ginfes.com.br/report/consultarNota?__report=nfs_ver13&cdVerificacao=<?= $row['NFSE_CODIGO_VERIFICACAO'] ?>&numNota=<?= $row['NFSE_NUMERO'] ?>&cnpjPrestador=null" target="_blank" ><i class="fa fa-download"></i> NFS-E</a> -->

                                                       <a href="http://nfse.issmanaus.com.br/report/consultarNota?__report=nfs_ver13&cdVerificacao=<?= $row['NFSE_CODIGO_VERIFICACAO'] ?>&numNota=<?= $row['NFSE_NUMERO'] ?>&cnpjPrestador=null" target="_blank" ><i class="fa fa-download"></i> NFS-E</a> 

                                                    



                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $i = $i + 1;
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
</div>

<script src="<?= SCL_JS ?>jquery.dataTables.min.js"></script> 
<script src="<?= SCL_JS ?>jquery.dataTables.bootstrap.js"></script> 

<script>
    $('[data-toggle="frmCredito"]').on('click',
            function (e) {
                $('#frmCredito').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade" id="frmCredito"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );

    $('[data-toggle="modalCreditoAluno"]').on('click',
            function (e) {
                $('#modalCreditoAluno').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade" id="modalCreditoAluno"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );

    $('#titulos_pagos').dataTable({
        "sPaginationType": "full_numbers",
        "aaSorting": []
    });

    $('#titulos_vencidos').dataTable({
        "sPaginationType": "full_numbers",
        "aaSorting": []
    });

    $('#titulos_a_vencer').dataTable({
        "sPaginationType": "full_numbers",
        "aaSorting": []
    });
</script>

<? $this->load->view('layout/footer'); ?>
