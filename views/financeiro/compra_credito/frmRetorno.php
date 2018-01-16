<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header btn-info">
            <h4><i class="fa fa-credit-card"></i> Compra de Crédito ( Retorno )</h4>
        </div>
        <form id="frmRegistro" name="frmRegistro" >
            <div class="modal-body">
                <?php
                if($idstatus == '4' || $idstatus == '6'){
                    echo '<strong>Transação realizada com sucesso!</strong> <br />';
                    echo '<strong>Transação:</strong><br /> '.$transacao.' <br />';
                    echo '<strong>Status:</strong><br /> '.$status.' <br />';
                }else{
                    echo 'Não foi possível realizar a transação, favor verificar seus dados.';
                }
                ?>
            </div>
            <div class="modal-footer">
                <a href="<?=base_url('inicio')?>" class="btn btn-danger form-control" id="frmarquivo_btn" >
                    <i class="fa fa-refresh"></i> Fechar
                </a>
            </div>
        </form>
    </div>
</div>
<? exit(); ?>

