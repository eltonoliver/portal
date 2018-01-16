<div class="modal-dialog">
    <div class="color-line"></div>
    <div class="modal-content">
        <form name="formulario<?= $filtro[0]['CD_TEMA'] ?>" id="formulario<?= $filtro[0]['CD_TEMA'] ?>">
            <div class="modal-footer <?= $panel ?>">
                <h4><?= $titulo ?></h4>
            </div>
            <div class="modal-body no-padding">
                <br />
                <div class="form-group col-xs-6">
                    <label>Curso</label>
                    <select name="avalCurso" id="avalCurso<?= $filtro[0]['CD_TEMA'] ?>" class="form-control">
                        <option></option>
                        <? foreach ($curso as $row) { ?>
                            <option <?= (($filtro[0]['CD_CURSO'] == $row['CD_CURSO']) ? 'selected=selected' : '') ?> value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO'] ?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="form-group col-xs-6">
                    <label>Série</label>
                    <select name="avalSerie" id="avalSerie<?= $filtro[0]['CD_TEMA'] ?>" class="form-control">
                    <?= (($filtro[0]['ORDEM_SERIE']) ? '<option value="' . $filtro[0]['ORDEM_SERIE'] . '">' . $filtro[0]['NM_SERIE'] . '</option>' : '') ?>
                    <option></option>
                </select>
                </div>
                
                <div class="form-group col-xs-6">
                    <label>Disciplina</label>
                    <select name="avalDisciplina" id="avalDisciplina<?= $filtro[0]['CD_TEMA'] ?>" class="form-control">
                    <?= (($filtro[0]['CD_DISCIPLINA']) ? '<option value="' . $filtro[0]['CD_DISCIPLINA'] . '">' . $filtro[0]['NM_DISCIPLINA'] . '</option>' : '') ?>
                    <option></option>
                </select>
                </div>
                
                <div class="form-group col-xs-6">
                    <label>Deixar Visível para seleção?</label>
                    <select name="avalVisivel" id="avalVisivel<?= $filtro[0]['CD_TEMA'] ?>" class="form-control">
                    <option value="S" <?= (($filtro[0]['FLG_ATIVO'] == 'S') ? 'selected=selected' : '') ?>>SIM</option>
                    <option value="N" <?= (($filtro[0]['FLG_ATIVO'] == 'N') ? 'selected=selected' : '') ?>>NÃO</option>
                </select>
                <input name="avalCodigo" type="hidden" value="<?= $filtro[0]['CD_TEMA'] ?>"/>
                <input name="avalOpcao" type="hidden" value="<?= $opcao ?>"/>
                </div>
                
                <div class="form-group col-xs-12">
                    <label>Tema</label>
                    <input autocomplete="off" name="avalTema" name="avalTema<?= $filtro[0]['CD_TEMA'] ?>" type="text" class="form-control" value="<?= (($filtro[0]['DC_TEMA']) ? $filtro[0]['DC_TEMA'] : '') ?>" />
                </div>
                <div class="form-group col-xs-12">
                    <div id="res<?= $filtro[0]['CD_TEMA'] ?>"></div>
                </div>
                &zwnj;
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <input type="submit" id="btnConfirmar" class="btn btn-success"> 
            </div>
        </form>        
    </div>
    <script type="text/javascript">
        $("select[id=txtCurso<?= $filtro[0]['CD_TEMA'] ?>]").change(function() {
            $("select[id=txtSerie<?= $filtro[0]['CD_TEMA'] ?>]").html('<option>Carregando</option>');
            $.post("<?= base_url('comum/combobox/serie') ?>", {
                curso: $(this).val()
            },
            function(valor) {
                $("select[id=txtSerie<?= $filtro[0]['CD_TEMA'] ?>]").html(valor);
                $("select[id=txtDisciplina<?= $filtro[0]['CD_TEMA'] ?>]").html('');
            });
        });

        $("select[id=txtSerie<?= $filtro[0]['CD_TEMA'] ?>]").change(function() {
            $("select[id=txtDisciplina<?= $filtro[0]['CD_TEMA'] ?>]").html('<option>Carregando</option>');
            $.post("<?= base_url('comum/combobox/disciplina') ?>", {
                curso: $("select[id=txtCurso<?= $filtro[0]['CD_TEMA'] ?>]").val(),
                serie: $("select[id=txtSerie<?= $filtro[0]['CD_TEMA'] ?>]").val(),
            },
            function(valor) {
                $("select[id=txtDisciplina<?= $filtro[0]['CD_TEMA'] ?>]").html(valor);
            });
        });

        // ENVIA O FORMULÁRIO COM OS DADOS
        jQuery('#formulario<?= $filtro[0]['CD_TEMA'] ?>').submit(function() {
            var dados = jQuery(this).serialize();
            $("div[id=res]").html('<div class="panel"><?= LOAD ?></div>');
            jQuery.ajax({
                type: "POST",
                url: "<?= base_url('108/tema/frmManter') ?>",
                data: dados,
                success: function(data) {
                    txtFiltrar();
                    $("div[id=res<?= $filtro[0]['CD_TEMA'] ?>]").html(data);
                },
            });
            return false;
        });
    </script>
</div>