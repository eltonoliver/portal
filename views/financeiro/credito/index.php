<? $this->load->view('layout/header'); ?>


<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h5 class="panel-title"><i class="fa fa-list"></i> Comprovante(s) de Compra(s)</h5>
                </div>&zwj;
                <div class="panel-body">
                    
                    <table class="table table-hover table-striped" id="grid" data-page-size="20">
                            <thead>
                                <tr class="well">
                                    <th>ALUNO</th>
                                    <th>DESCRIÇÃO</th>
                                    <th>VENCIMENTO</th>
                                    <th>VALOR R$</th>
                                    <th>(-) R$</th>
                                    <th>(+) R$</th>
                                    <th>PAGO</th>
                                    <th>Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!isset($comprovante['retorno']) && !isset($comprovante['cursor'])):?>
                                <?                                
                                foreach ($comprovante as $row) {
                                    ?>

                                    <tr class="">
                                        <td><?= $row['CD_ALUNO']?> - <?= substr($row['NM_ALUNO'], 0, 15) ?></td>
                                        <td><? if($row['FL_STATUS']!= 'COMPRA REALIZADA') echo substr($row['NM_PRODUTO'], 0, 17); else echo 'COMPRA DE CRÉDITO ONLINE'; ?></td>
                                        <td><?= $row['COMPROVANTE'] ?></td>
                                        <td><?= number_format($row['VL_RECEBIDO'], 2, ',', '.') ?></td>
                                        <td><?= number_format($desconto, 2, ',', '.') ?></td>
                                        <td><?= number_format($acrescimo, 2, ',', '.') ?></td>
                                        <td><?= number_format($row['VL_TOTAL'], 2, ',', '.') ?></td>
                                        <td>
                                            <a target="_blanc" href="<?=base_url()?>financeiro/credito/comprovante?token=<?=base64_encode($row['CD_PAGAMENTO'])?>&validation=<?=base64_encode($row['AUTENTICACAO'])?>">
                                                <i class="fa fa-download"></i>
                                                Baixar
                                            </a>
                                        </td>
                                    </tr>
                                    <?  }  ?>
                                    <?php endif;?>
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
        
        
        <? foreach($aluno as $r){?>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h5 class="panel-title"><i class="fa fa-user"></i>  <?=$r['NM_ALUNO']?></h5>
                </div>
                <div class="panel-body">
                   <div class="col-xs-4 thumbnail avatar">
                        <img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $r['CD_ALUNO'] ?>" class="media-object">
                    </div>
                    <div class="col-xs-8">
                        <ul class="nav nav-pills nav-stacked">
                            <li class="list-warning">
                                Crédito: <br /><strong style="font-size:30px"><?= number_format(str_replace(',','.',$r['VL_SALDO']),2,',','.')?></strong>
                            </li>
                            
                            <li class="list-info">
                                Limite Diário: <br /><strong style="font-size:20px"><?=number_format($r['VL_LIMITE'],2,',','.')?></strong>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="panel-footer">                    
                    <a href="<?=SCL_RAIZ?>financeiro/credito/extrato?token=<?=base64_encode($r['CD_ALUNO'])?>" class="btn btn-danger" data-toggle="frmCredito" data-target="#frmCredito"><i class="fa fa-list"></i> Extrato </a>
                    <a style="display:none" href="<?=SCL_RAIZ?>financeiro/credito/cardapio?token=<?=base64_encode($r['CD_ALUNO'])?>" class="btn btn-info" data-toggle="frmCredito" data-target="#frmCredito"><i class="fa fa-cutlery"></i> Cardápio </a>
                </div>
            </div>
        </div>
        <? } ?>
    </div>
</div>
<script>
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

<script src="<?= SCL_JS ?>jquery.dataTables.min.js"></script> 
<script src="<?= SCL_JS ?>jquery.dataTables.bootstrap.js"></script> 
<script>
    //
    $('#grid').dataTable({
        "sPaginationType": "full_numbers"
    });
</script>

<? $this->load->view('layout/footer'); ?>
