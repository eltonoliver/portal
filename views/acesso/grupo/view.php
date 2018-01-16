
<div class="modal-header btn-info">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="fa fa-sitemap"></i> Acesso / grupo / <?= $titulo ?></h4>
</div>
<form action="#" method="post" id="frmmanter" name="frmmanter" enctype="multipart/form-data">
    <div class="modal-body">

        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">Código:</span>
                <input name="codigo" type="text" class="form-control" readonly value="<?= $filtro[0]['CD_PROGRAMA'] ?>">
                <input name="tipo" type="hidden" class="form-control" value="<?= $titulo ?>">
                <input name="operacao" type="hidden" class="form-control" value="<? if ($titulo == 'adicionar') echo 'A'; elseif ($titulo == 'editar') echo 'E'; if ($titulo == 'deletar') echo 'X'; ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">Nome do Grupo:</span>
                <input name="nome" type="text"  class="form-control" style="z-index:0" value="<?= $filtro[0]['DC_GRUPO'] ?>" />
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">Status:</span>
                <input type="checkbox" id="ativo" name="ativo" value="1" checked>
            </div>
        </div>
        
        <div id="resultado"></div>

    </div>
    <div class="modal-footer clearfix">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> <?= $titulo ?></button>
    </div>
</form>

<script>
    jQuery(document).ready(function() {
        jQuery('#frmmanter').submit(function() {
            var dados = jQuery(this).serialize();

            jQuery.ajax({
                type: "POST",
                url: "<?= SCL_RAIZ ?>acesso/programa/manter",
                data: dados,
                success: function(data)
                {
                    $("#resultado").html(data);
                }
            });
            return false;
        });
    });

</script>
<? exit(); ?>