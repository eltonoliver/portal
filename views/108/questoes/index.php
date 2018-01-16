<? $this->load->view('home/header'); ?>

<script type="text/javascript">
    function salvarFiltro() {
        var dados;
        var pesquisou = false;

        if ($("#filtro").val() === "A") {
            pesquisou = true;
            dados = {
                curso: $("#FTCurso").val(),
                serie: $("#FTSerie").val(),
                disciplina: $("#FTDisciplina").val()
            };
        } else if ($("#filtro").val() === "S") {
            pesquisou = true;
            dados = {
                codigo: $("#FTCodigo").val()
            };
        }

        if (pesquisou) {
            dados['pagina'] = $("#tbl").length > 0 ? $("#tbl").DataTable().page() : 0;

            $.ajax({
                url: "<?= site_url("108/questoes/salvarFiltro") ?>",
                method: "post",
                data: dados
            });
        }
    }

    function filtrarSimples(pagina) {
        $("#filtro").val("S");
        salvarFiltro();
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url('108/questoes/grdQuestoes') ?>", {
            codigo: $("#FTCodigo").val()
        },
        function (valor) {
            $("#tblFiltro").html(valor);
            if (pagina) {
                $('#tbl').DataTable().page(pagina).draw(false);
            }
        });
    }

    function filtrarAvancado(pagina) {
        $("#filtro").val("A");
        salvarFiltro();
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url('108/questoes/grdQuestoes') ?>", {
            curso: $("#FTCurso").val(),
            serie: $("#FTSerie").val(),
            disciplina: $("#FTDisciplina").val()
        },
        function (valor) {
            $("#tblFiltro").html(valor);
            if (pagina) {
                $('#tbl').DataTable().page(pagina).draw(false);
            }
        });
    }

    function toggle() {
        $("#BuscaAvancada").toggle();
        $("#FTCurso").val("");
        $("#FTSerie").html("");
        $("#FTDisciplina").html("");
    }

    //apenas mostra a mensagem do sweet alert
    function mostrarMensagem(titulo, mensagem, tipo) {
        swal({
            title: titulo,
            text: mensagem,
            type: tipo,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ok",
            closeOnConfirm: true
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        //disparar mensagens de aviso
        var tipo = "<?= $tipo ?>";
        var mensagem = "<?= $mensagem ?>";

        if (tipo !== "" && mensagem !== "") {
            mostrarMensagem("Mensagem", mensagem, tipo);
        }
    });
</script>

<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">    
            <div class="panel-heading">                
            </div>

            <div class="panel-footer">                
                <div class="row">
                    <div class="col-sm-7">
                        <a class="btn btn-labeled btn-info" href="<?= base_url('108/questoes/frmQuestao?operacao=I') ?>" style="margin-top:7px">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            Adicionar Questão
                        </a>                        
                    </div>

                    <div class="col-xs-5">
                        Código
                        <div class="input-group btn-group">                        
                            <input class="form-control  input-group-addon" type="number" name="FTCodigo" id="FTCodigo" value="<?= $codigo ?>"/>

                            <span class="input-group-btn">
                                <button type="button" onclick="filtrarSimples()" class="btn btn-labeled btn-info">
                                    <span class="btn-label"><i class="fa fa-search"></i></span>
                                    Filtrar
                                </button>
                            </span>

                            <span class="input-group-btn">
                                <button type="button" class="btn btn-toggle btn btn-labeled btn-warning" onclick="toggle()">
                                    <span class="btn-label"><i class="fa fa-gear"></i></span>
                                    Busca Avançada
                                </button>
                            </span>
                        </div>
                    </div>
                </div>                    
            </div>

            <div class="panel-body" id="BuscaAvancada" style="<?= $disciplina != null ? "" : "display:none  " ?>">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Curso</label><br/>
                            <select name="FTCurso" id="FTCurso" class="form-control">
                                <option value=""></option>
                                <? foreach ($cursos as $row) { ?>
                                    <option value="<?= $row->CD_CURSO ?>" <?= $row->CD_CURSO == $curso ? "selected=selected" : "" ?>>
                                        <?= $row->NM_CURSO_RED ?>
                                    </option>
                                <? } ?>
                            </select>
                        </div> 
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Série</label><br/>
                            <select name="FTSerie" id="FTSerie" class="form-control">
                                <option value=""></option>
                                <? foreach ($series as $row) { ?>
                                    <option value="<?= $row->ORDEM_SERIE ?>" <?= $row->ORDEM_SERIE == $serie ? "selected=selected" : "" ?>>
                                        <?= $row->NM_SERIE ?>
                                    </option>
                                <? } ?>
                            </select>
                        </div> 
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Disciplina</label>
                            <div class="input-group">
                                <select name="FTDisciplina" id="FTDisciplina" class="form-control">
                                    <option value=""></option>
                                    <? foreach ($disciplinas as $row) { ?>
                                        <option value="<?= $row->CD_DISCIPLINA ?>" <?= $row->CD_DISCIPLINA == $disciplina ? "selected=selected" : "" ?>>
                                            <?= str_pad($row->CD_DISCIPLINA, 3, "0", STR_PAD_LEFT) . ' - ' . $row->NM_DISCIPLINA ?>
                                        </option>
                                    <? } ?>
                                </select>

                                <span class="input-group-btn">
                                    <button onclick="filtrarAvancado()" type="button" class="btn btn-labeled btn-info">
                                        <span class="btn-label"><i class="fa fa-search"></i></span>
                                        Filtrar
                                    </button>
                                </span>
                            </div>
                        </div>                    
                    </div>
                </div>

                <input type="hidden" id="filtro" value="">
            </div>

            <div class="panel-body">
                <div role="tabpanel" id="tblFiltro">
                </div>
            </div>       
        </div>
    </div>
</div>

<script type="text/javascript">
    $("select[id=FTCurso]").change(function () {
        $("select[id=FTSerie]").html('<option>Carregando</option>');
        $.post("<?= base_url('comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function (valor) {
            $("select[id=FTSerie]").html(valor);
            $("select[id=FTDisciplina]").html('');
        });
    });

    $("select[id=FTSerie]").change(function () {
        $("select[id=FTDisciplina]").html('<option>Carregando</option>');
        $.post("<?= base_url('comum/combobox/disciplina') ?>", {
            curso: $("select[id=FTCurso]").val(),
            serie: $("select[id=FTSerie]").val()
        },
        function (valor) {
            $("select[id=FTDisciplina]").html(valor);
        });
    });
</script>

<?php if ($filtro): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            var questao = $("#FTCodigo").val();
            var disciplina = $("#FTDisciplina").val();
            var pagina = <?= $pagina ?>;

            if (disciplina !== "") {
                filtrarAvancado(pagina);
            } else if (questao !== "") {
                filtrarSimples(pagina);
            }
        });
    </script>
<?php endif; ?>

<? $this->load->view('home/footer'); ?>