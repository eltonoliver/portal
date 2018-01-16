
<div class="modal-header btn-info">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"><i class="fa fa-plus"></i> Acesso / Programa / <?= $titulo ?></h4>
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
                <span class="input-group-addon ">Sistema: </span>
                <select name="tsistema" id="tsistema" class="form-control">
                    <?
                    foreach ($sistema as $item) {
                        if ($item['SISTEMA'] == $filtro[0]['SISTEMA'])
                            $r = "selected='selected'";
                        else
                            $r = '';
                        ?>
                        <option value="<?= $item['SISTEMA'] ?>" <?= $r ?>> <?= $item['DC_SISTEMA'] ?> </option>
                    <? } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">Nome do Programa:</span>
                <input name="nome" type="text"  class="form-control" style="z-index:0" value="<?= $filtro[0]['NM_PROGRAMA'] ?>" />
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">Formulário:</span>
                <input name="formulario" type="text"  class="form-control" style="z-index:0" value="<?= $filtro[0]['FORMULARIO'] ?>" />
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon">Observação:</span>
                <input name="observacao" type="text"  class="form-control" style="z-index:0" value="<?= $filtro[0]['OBSERVACAO'] ?>" />
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
                   // $("#resultado").html(data);
                    $('#<?=$modal?>').modal('hide');
                    /* ATUALIZA O GRID DE PROGRAMAS */
                    var dados = jQuery(this).serialize();
                    

                    jQuery.ajax({
                        type: "POST",
                        url: "<?= SCL_RAIZ ?>acesso/programa/tabela?sistema=<?=$filtro[0]['SISTEMA']?>",
                        data: dados,
                        success: function(data)
                        {
                            $("#grdprograma").html(data);
                        }
                    });
                    return false;
                    //$('#<?=$modal?>').modal('hide');
                    //$('#<?=$modal?>').modal({show: false});
                }
            });
            return false;
        });
    });

</script>
<? exit(); ?>