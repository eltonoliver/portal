<?php $this->load->view("layout/header"); ?>

<div id="content">
    <?= get_msg("msg") ?>

    <div class="row">
        <form action="<?= site_url("professor/diario/confirmar_conteudo_prova") ?>" method="post">
            <input type="hidden" id="disciplina" name="codigo-disciplina" value="<?= $codigoDisciplina ?>">
            <input type="hidden" name="descricao-disciplina" value="<?= $descricaoDisciplina ?>">
            <input type="hidden" id="turma" name="turma" value="<?= $turma ?>">
            <input type="hidden" id="bimestre" name="bimestre" value="<?= $bimestre ?>">
            <input type="hidden" name="prova" value="<?= $codigoProva ?>">
            <input type="hidden" name="descricao-nota" value="<?= $descricaoNota ?>">

            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Tipo de Nota:</label>                    
                                <select name="tipo-nota" class="form-control" readonly="true">
                                    <option value="<?= $codigoNota ?>" selected>
                                        <?= $descricaoNota ?>
                                    </option>
                                </select>               
                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Turma:</label>       
                                <div>
                                    <?= $turma ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Disciplina:</label>                
                                <div>
                                    <?= $descricaoDisciplina ?>
                                </div>
                            </div>
                        </div>            
                    </div>  

                    <div class="row">
                        <div class="col-xs-4">                
                            <div class="form-group <?= form_error("data-prova") != "" ? "has-error" : "" ?>">
                                <label>Data da Prova:</label>
                                <input name="data-prova" type="text" class="form-control" id="data-prova" value="<?= $dataProva ?>">
                                <?= form_error("data-prova") ?>
                            </div>                            
                        </div>

                        <div class="col-xs-4">
                            <div class="form-group <?= form_error("opcao") != "" ? "has-error" : "" ?>">
                                <label>Forma de lançamento:</label>
                                <div class="radio">
                                    <input type="radio" value="A" name="opcao" <?= $opcao === "A" ? "checked" : "" ?>>
                                    <label> 
                                        Escolher conteúdo da prova de um determinado período.
                                    </label>
                                </div>

                                <div class="radio">
                                    <input type="radio" value="M" name="opcao" <?= $opcao === "M" ? "checked" : "" ?>>
                                    <label>
                                        Digitar conteúdo da prova.
                                    </label>
                                </div>
                                <?= form_error("opcao") ?>
                            </div>
                        </div>

                        <div id="conteudo-periodo-campo" style="display: none">                                        
                            <div class="col-xs-4">                                        
                                <div class="form-group <?= form_error("data-conteudo") != "" ? "has-error" : "" ?>">
                                    <label>Conteúdo de:</label>
                                    <input name="data-conteudo" type="text" class="form-control" id="data-conteudo" value="<?= $dataConteudo ?>">
                                    <?= form_error("data-conteudo") ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">                
                        <div id="conteudo-periodo" style="display: none">
                            <div class="row">
                                <div id="grid-conteudo">
                                    <?php if (!empty($conteudos)): ?>
                                        <?php $this->load->view("professor/diario/grid_conteudo_prova") ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div id="conteudo-escrito" style="display: none">
                            <div class="col-xs-12">
                                <div class="form-group <?= form_error("texto-conteudo") != "" ? "has-error" : "" ?>">
                                    <label>Conteúdo:</label>
                                    <textarea class="form-control" name="texto-conteudo" rows="3" id="texto-conteudo" maxlength="4000"><?= $textoConteudo ?></textarea>
                                    <?= form_error("texto-conteudo") ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer">
                        <div class="form-group">
                            <a class="btn btn-danger" href="<?= site_url("professor/diario/conteudo_prova") ?>"><i class="fa fa-rotate-left"></i> Cancelar</a>
                            <button class="btn btn-success" type="submit">
                                <i class="fa fa-check"></i> Lançar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="<?= SCL_JS ?>bootstrap-datepicker.min.js"></script> 
<script src="<?= SCL_JS ?>daterangepicker.min.js"></script> 
<script src="<?= SCL_JS ?>moment.min.js"></script>
<script>
    /**
     * verifica a forma de lançamento da prova e exibe os campos de acordo com
     * a opção selecionada.
     */
    function formaLancamento() {
        var opcao = $("input[name=opcao]:checked").val();

        if (opcao === "A") {
            $("#conteudo-escrito").hide();
            $("#conteudo-periodo").show();
            $("#conteudo-periodo-campo").show();
            $("#texto-conteudo").val("");
        } else if (opcao === "M") {
            $("#conteudo-escrito").show();
            $("#conteudo-periodo").hide();
            $("#conteudo-periodo-campo").hide();
            $("#data-conteudo").val("");
        }
    }

    $(document).ready(function () {
        formaLancamento();
        $("#data-prova").datepicker({
            language: 'pt-BR',
            format: 'dd/mm/yyyy'
        });

        $('#data-conteudo').daterangepicker({
            format: 'DD/MM/YYYY'
        },
        function (start, end) {
            $("#grid-conteudo").html('<div class="progress progress-striped progress-active"><div class="progress-bar progress-bar-warning" style="width: 100%;"></div></div>');
            $.ajax({
                url: "<?= site_url("professor/diario/grid_conteudo_prova") ?>",
                method: "POST",
                data: {
                    inicio: start.format("YYYY-MM-DD"),
                    fim: end.format("YYYY-MM-DD"),
                    bimestre: $("#bimestre").val(),
                    turma: $("#turma").val(),
                    disciplina: $("#disciplina").val()
                },
                success: function (data) {
                    $('#grid-conteudo').html(data);
                }
            });
        });

        $("#data-conteudo").trigger('change');
    });

    $("input[name=opcao]").change(function () {
        formaLancamento();
    });
</script>

<?php $this->load->view("layout/footer") ?>