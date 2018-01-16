<div id="mdlFrmVersao">
    <div class="modal-dialog modal-sm">
        <script type="text/javascript">
            function SelVersaoProva() {
                var dados = jQuery('#formulario').serialize();
                $("#mdlFrmVersao").html('<?=LOAD?>');
                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url('108/prova_gabarito/mdlGabaritarProva/') ?>",
                    data: dados,
                    success: function(data) {
                        $("#mdlFrmVersao").html(data);
                    },
                });
                return false;
            };
        </script>
        <div class="modal-content">
            <div class="color-line"></div>
            <form name="formulario" id="formulario">
                <div class="modal-footer">
                    <small>GABARITAR PROVA</small>
                </div>
                <div class="modal-body">
                    <label>Versões da prova</label>
                    <select name="avalProvaVersao" id="avalProvaVersao" class="form-control">
                        <option value=""></option>
                        <? foreach ($versao as $row) { ?>
                            <option value="<?= $row['CD_PROVA'] ?>">PROVA Nº <?= $row['NUM_PROVA'] ?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-warning2" onclick="SelVersaoProva()">Selecionar</button>
                </div>
            </form>
        </div>
    </div>
</div>