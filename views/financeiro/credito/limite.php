<div class="modal-dialog">
    <div class="modal-content" style="width:70%">
        <div class="modal-header btn-info">
            <h4><i class="fa fa-credit-card"></i> Limite do Aluno</h4>
        </div>
        
        <script src="<?=SCL_JS?>jquery.maskedinput-1.1.4.pack.js" type="text/javascript" /></script>

    
        <form action="<?= SCL_RAIZ ?>financeiro/credito/atualizar_limite" method="post" class="form-horizontal" enctype="multipart/form-data" id="frmlimite" name="frmlimite" >
            <div class="panel-body">
                <span class="col-xs-12">
                    <label class="panel-heading panel-info col-xs-12">
                        Novo Limite R$:
                        <input type="text" name="novo" id="novo" required value="<?= number_format($aluno[0]['VL_LIMITE'], 2, ',', '.') ?>" />
                        <input type="hidden" name="antigo" value="<?= number_format($aluno[0]['VL_LIMITE'], 2, ',', '.') ?>" />
                        <input type="hidden" name="aluno" value="<?=$aluno[0]['CD_ALUNO']?>" />
                        <input type="hidden" name="token" value="<?=base64_encode(number_format($aluno[0]['VL_SALDO'], 2, ',', '.') )?>" />
                    </label>
                </span>
                <span class="col-xs-12" id="dvmudancas">
                    
                    
                </span>
            </div> 
            <div class="modal-footer">
                <a class="btn btn-danger pull-left" href="<?= SCL_RAIZ ?>inicio" ><i class="fa fa-refresh"></i> Fechar </a>
                <button class="btn btn-success" type="submit" id="frmarquivo_btn" ><i class="fa fa-save"></i> Salvar</button>
            </div>
                <script type="text/javascript">
        jQuery(document).ready(function() {
        
            jQuery('#frmlimite').submit(function() {
                var dados = jQuery(this).serialize();
                jQuery.ajax({
                    type: "POST",
                    url: "<?= SCL_RAIZ ?>financeiro/credito/atualizar_limite",
                    data: dados,
                    success: function(data)
                    {
                        $("#dvmudancas").html(data);
                        return false;
                    }
                });
                return false;
            });
            $("#novo").mask("99,99");
        });
    </script>
        </form>
    </div>
</div>
<? exit(); ?>

