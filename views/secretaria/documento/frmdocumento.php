
<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header btn-info">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-list"></i> <?=$titulo?> </h4>
        </div>
        <form  name="frmDeclaracao" id="frmDeclaracao" action="<?=SCL_RAIZ?>secretaria/declaracao/pdf" method="post" >
            <input name="aluno" type="hidden" value="<?=$aluno?>" />
            <input name="documento" value="<?=$documento?>" type="hidden" />
            <div class="modal-footer">
                <button class="btn btn-default pull-left" data-dismiss="modal" id="frmarquivo_btn"><i class="fa fa-refresh"></i> Fechar </button>
                <input class="btn btn-success pull-right" type="submit" name="btnDocumento" id="btnDocumento" value="Validar" >
            </div>
        </form>
    </div>
</div>
<? exit(); ?>

