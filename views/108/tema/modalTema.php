<?php $disabled = $operacao == "D" ? "disabled" : "" ?>

<div class="modal-dialog">
    <div class="color-line"></div>

    <div class="modal-content">
        <form name="formulario<?= $tema->CD_TEMA ?>" id="formulario<?= $tema->CD_TEMA ?>">
            <div class="modal-header">
                <h4 class="modal-title text-right"><?= $titulo ?></h4>
            </div>

            <div class="modal-body">             
                <div class="row">
                    <div class="form-group col-xs-6">
                        <label>Curso</label>
                        <select name="avalCurso" id="avalCurso<?= $tema->CD_TEMA ?>" class="form-control" <?= $disabled ?>>
                            <option></option>
                            <? foreach ($cursos as $row) { ?>
                                <option <?= (($tema->CD_CURSO == $row->CD_CURSO) ? 'selected=selected' : '') ?> value="<?= $row->CD_CURSO ?>"><?= $row->NM_CURSO_RED ?></option>
                            <? } ?>
                        </select>
                    </div>

                    <div class="form-group col-xs-6">
                        <label>Série</label>
                        <select name="avalSerie" id="avalSerie<?= $tema->CD_TEMA ?>" class="form-control" <?= $disabled ?>>                            
                            <option></option>
                            <? foreach ($series as $row) { ?>
                                <option <?= (($tema->ORDEM_SERIE == $row->ORDEM_SERIE) ? 'selected=selected' : '') ?> value="<?= $row->ORDEM_SERIE ?>"><?= $row->NM_SERIE ?></option>
                            <? } ?>
                        </select>
                    </div>

                    <div class="form-group col-xs-6">
                        <label>Disciplina</label>
                        <select name="avalDisciplina" id="avalDisciplina<?= $tema->CD_TEMA ?>" class="form-control" <?= $disabled ?>>                             
                            <option></option>
                            <? foreach ($disciplinas as $row) { ?>
                                <option <?= (($tema->CD_DISCIPLINA == $row->CD_DISCIPLINA) ? 'selected=selected' : '') ?> value="<?= $row->CD_DISCIPLINA ?>"><?= $row->NM_DISCIPLINA ?></option>
                            <? } ?>
                        </select>
                    </div>

                    <div class="form-group col-xs-6">
                        <label>Deixar Visível para seleção?</label>
                        <select name="avalVisivel" id="avalVisivel<?= $tema->CD_TEMA ?>" class="form-control" <?= $disabled ?>>
                            <option value="S" <?= (($tema->FLG_ATIVO == 'S') ? 'selected=selected' : '') ?>>SIM</option>
                            <option value="N" <?= (($tema->FLG_ATIVO == 'N') ? 'selected=selected' : '') ?>>NÃO</option>
                        </select>                    
                    </div>

                    <div class="form-group col-xs-12">
                        <label>Tema</label>
                        <input autocomplete="off" name="avalTema" id="avalTema<?= $tema->CD_TEMA ?>" type="text" class="form-control" value="<?= (($tema->DC_TEMA) ? $tema->DC_TEMA : '') ?>" <?= $disabled ?>/>
                    </div>

                    <input name="avalCodigo" type="hidden" value="<?= $tema->CD_TEMA ?>"/>
                    <input name="avalOperacao" type="hidden" value="<?= $operacao ?>"/>
                </div>
            </div>

            <div class="modal-footer">
                <div id="res<?= $tema->CD_TEMA ?>">
                </div>
            </div>                 

            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" id="btnConfirmar<?= $tema->CD_TEMA ?>" class="btn btn-<?= $operacao == "D" ? "danger" : "success" ?> pull-right"><?= $operacao == "D" ? "Deletar" : "Salvar" ?></button> 
            </div>
        </form>        
    </div>

    <script type="text/javascript">
        $("select[id=avalCurso<?= $tema->CD_TEMA ?>]").change(function () {
            $("select[id=avalSerie<?= $tema->CD_TEMA ?>]").html('<option>Carregando</option>');
            $.post("<?= base_url('comum/combobox/serie') ?>", {
                curso: $(this).val()
            },
            function (valor) {
                $("select[id=avalSerie<?= $tema->CD_TEMA ?>]").html(valor);
                $("select[id=avalDisciplina<?= $tema->CD_TEMA ?>]").html('');
            });
        });

        $("select[id=avalSerie<?= $tema->CD_TEMA ?>]").change(function () {
            $("select[id=avalDisciplina<?= $tema->CD_TEMA ?>]").html('<option>Carregando</option>');
            $.post("<?= base_url('comum/combobox/disciplina') ?>", {
                curso: $("select[id=avalCurso<?= $tema->CD_TEMA ?>]").val(),
                serie: $("select[id=avalSerie<?= $tema->CD_TEMA ?>]").val()
            },
            function (valor) {
                $("select[id=avalDisciplina<?= $tema->CD_TEMA ?>]").html(valor);
            });
        });

        //validar os campos e exibe mensagem caso necessário
        function validar() {
            var mensagem = "";
            if ($("#avalCurso<?= $tema->CD_TEMA ?>").val() == "") {
                mensagem = "Selecione o Curso";

            } else if ($("#avalSerie<?= $tema->CD_TEMA ?>").val() == "") {
                mensagem = "Selecione a Série";

            } else if ($("#avalDisciplina<?= $tema->CD_TEMA ?>").val() == "") {
                mensagem = "Selecione a Disciplina";

            } else if ($("#avalTema<?= $tema->CD_TEMA ?>").val() == "") {
                mensagem = "Informe o Tema";
                $("#avalTema<?= $tema->CD_TEMA ?>").focus();
            }

            if (mensagem != "") {
                mostrarMensagem("Aviso", mensagem, "warning");
                return false;
            }

            return true;
        }

        //limpar os campos para um novo cadastro
        function limparCampos() {
            $("#avalCurso<?= $tema->CD_TEMA ?>").val("");
            $("#avalSerie<?= $tema->CD_TEMA ?>").html("");
            $("#avalDisciplina<?= $tema->CD_TEMA ?>").html("");
            $("#avalTema<?= $tema->CD_TEMA ?>").val("");
        }

        // ENVIA O FORMULÁRIO COM OS DADOS
        $("#btnConfirmar<?= $tema->CD_TEMA ?>").click(function () {
            //validar se campos foram preenchidos
            if (validar()) {
                $("#res<?= $tema->CD_TEMA ?>").html('<?= LOAD ?>');

                var dados = $("#formulario<?= $tema->CD_TEMA ?>").serialize();

                $.ajax({
                    url: "<?= site_url("108/tema/frmManter") ?>",
                    data: dados,
                    type: "post",
                    dataType: "json",
                    success: function (data) {
                        $("#res<?= $tema->CD_TEMA ?>").html("");

                        if (data['success']) {
                            if (data['operacao'] == "I") {
                                limparCampos();
                            } else if (data['operacao'] == "D") {
                                $("#frmModalInfo").modal("hide");
                            }

                            var pagina = null;
                            //verificar se existe tabela
                            if ($("#tbl").length > 0) {
                                //se existir obter a página atual da pesquisa
                                pagina = $('#tbl').DataTable().page();

                                //atualizar dados da tabela e definir na página que estava
                                if ($("#avalDisciplina<?= $tema->CD_TEMA ?>").val() != "") {
                                    filtrarAvancado(pagina);
                                } else {
                                    filtrarSimples(pagina);
                                }
                            }

                            mostrarMensagem("Mensagem", data['mensagem'], "success");
                        } else {
                            mostrarMensagem("Mensagem", data['mensagem'], "error");
                        }
                    }
                });
            }
        });
    </script>
</div>