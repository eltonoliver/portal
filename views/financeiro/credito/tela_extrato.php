
<div class="page-header"><h1>Extrato de Crédito no Período de <?=$periodo?></h1></div>
<table class="table">
    <caption class="text-left text-info">
        
    </caption>
    <thead>
        <tr>
            <th>Data/hora</th>
            <th>Histórico</th>
            <th style="width: 15%">Documento</th>
            <th style="width: 10%" class="text-right">Crédito</th>
            <th style="width: 10%" class="text-right">Débito</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $subtotalD = "";
        $subtotalC = "";
        foreach ($extrato as $e){ 
            if($e['NATUREZA_OPERACAO']=='D'){
                $subtotalD += $e['VALOR_OPERACAO'];
            }
            if($e['NATUREZA_OPERACAO']=='C'){
                $subtotalC += $e['VALOR_OPERACAO'];
            }
        ?>
        <tr>
            <td><?=$e['DATA_OPERACAO']?></td>
            <td><?=$e['HISTORICO_OPERACAO']?></td>
            <td style="width: 15%">
                <?php if(isset($e['DOCUMENTO']) and $e['NATUREZA_OPERACAO']!='C'){?>
                <a href="<?= SCL_RAIZ ?>financeiro/credito/detalhe_extrato?cupom=<?=$e['DOCUMENTO']?>" data-toggle="frmCredito" data-target="#frmCredito"> <?=$e['DOCUMENTO']?> </a>
                <?php } if($e['NATUREZA_OPERACAO']=='C'){ 
                    echo $e['DOCUMENTO'];
                }
                ?>
                
            </td>
           
            <?php if($e['NATUREZA_OPERACAO']=='C'){?>
            <td style="width: 10%" class="text-right text-success"> <?= number_format($e['VALOR_OPERACAO'], 2, ',', '.') ?></td>
            <?php }else{ ?> <td class="text-right"> - </td> <?php } ?>
            <?php if($e['NATUREZA_OPERACAO']=='D'){?>
            <td style="width: 10%" class="text-right text-danger">( <?= number_format($e['VALOR_OPERACAO'], 2, ',', '.') ?> )</td>
            <?php }else{ ?> <td class="text-right"> - </td>  <?php } ?>
            
            
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
            <td colspan="1" class="text-right text-success"><strong>R$ <?= number_format($subtotalC, 2, ',', '.') ?></strong></td>
            <td colspan="1" class="text-right text-danger"><strong>R$ ( <?= number_format($subtotalD, 2, ',', '.') ?> )</strong></td>
        </tr>
        <tr>
            <td colspan="4" class="text-right"><strong>Saldo Total do período selecionado:</strong></td>
            <?php
            $total = $subtotalC-$subtotalD;
            if($total >= 0){
            ?>
            <td colspan="1" class="text-right text-success">
                <strong>
                   R$ <?= number_format($total, 2, ',', '.') ?>
                </strong>
            </td>
            <?php }else{ ?>
            <td colspan="1" class="text-right text-danger">
                <strong>
                   R$ ( <?= number_format($total, 2, ',', '.') ?> )
                </strong>
            </td>
            <?php } ?>
        </tr>
    </tfoot>
</table>
<blockquote><strong>Saldo Disponível de Crédito: R$ <?php
                                                        $valor = str_replace(',','.',$extrato[0]['VALOR_SALDO_ATUAL']);
                                                        if($extrato[0]['NATUREZA_SALDO_ATUAL'] == 'D'){
                                                            echo "<span class='text-danger'>( -".number_format($extrato[0]['VALOR_SALDO_ATUAL'], 2, ',', '.')." )</span>";
                                                        }else{
                                                            echo "<span class='text-success'>".number_format($valor, 2, ',', '.')."</span>";    
                                                        }
?></strong></blockquote>
<?php if($limite != 0){  ?>
    <blockquote><strong>Limite de uso diário: R$ <?= number_format($limite, 2, ',', '.') ?></strong> <span class="text-danger">Definido pelo responsável</sona></blockquote>
<?php }else{ ?>
    <blockquote><strong>Limite de uso diário: <span class="text-danger">Responsável não estabeleceu limite</span></strong></blockquote>
<?php } ?>
<blockquote><strong>Quantidade de Almoço Disponível:  <?=$almoco?></strong></blockquote>

<script type="text/javascript">
       
        $('[data-toggle="frmCredito"]').on('click',
                function(e) {
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
    </script>
<?php exit();?>
