<div class="modal-dialog" style="width: 90%; height: 100%">
    <div class="modal-content">
        <div class="modal-header btn-success">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-credit-card"></i> Impressão de Boleto Atrasado</h4>
        </div>

        <div class="panel-body"> 
            <h2>Copie o código e cole no campo abaixo:
            <strong>
            <?php 
                 $a = remover_caracter($boleto['linhaDigitavel']);
                 echo $a;
                ?>
            </strong></h2>
            <iframe id="itau" name="itau" src="https://www.itau.com.br/servicos/boletos/atualizar?representacaoNumerica=123123123" style="border: 0; width: 100%; height: 1000px" />
        </div> 
        <div class="modal-footer">
            <button class="btn btn-danger pull-left" data-dismiss="modal" id="frmarquivo_btn" ><i class="fa fa-refresh"></i> Fechar </button>
        </div>
    </div>
</div>
<?php exit(); ?>

