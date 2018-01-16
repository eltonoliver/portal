<? $this->load->view('home/header'); ?>

<script type="text/javascript">
    function filtrarSimples(pagina) {
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url('108/tema/grdTema') ?>", {
            codigo: $("#FTCodigo").val(),            
            gerar: 0
        },
        function (valor) {
            $("#tblFiltro").html(valor);
            if (pagina) {
                $('#tbl').DataTable().page(pagina).draw(false);
            }
        });
    }

    function filtrarAvancado(pagina) {
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url('108/tema/grdTema') ?>", {
            curso: $("#FTCurso").val(),
            serie: $("#FTSerie").val(),
            disciplina: $("#FTDisciplina").val(),
            gerar: 1
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

    function gerarRelatorio() {
        var url = "<?= site_url("108/tema/relatorioTemaConteudo") ?>";

        if ($("#FTDisciplina").val() != "") {
            url += "?curso=" + $("#FTCurso").val();
            url += "&serie=" + $("#FTSerie").val();
            url += "&disciplina=" + $("#FTDisciplina").val();
            window.open(url, "_blank");
        } else {
            mostrarMensagem("Aviso", "Aplique um filtro para gerar o relatório", "warning");
        }
    }
</script>

<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-heading">                
            </div>

            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-7">
                        <a class="btn btn-labeled btn-info" href="<?= base_url('108/tema/modalTema?operacao=I') ?>" data-toggle="frmModalInfo" style="margin-top:7px">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            Adicionar Tema
                        </a>                        
                    </div>

                    <div class="col-sm-5">
                        Código
                        <div class="input-group btn-group">                        
                            <input class="form-control  input-group-addon" type="number" name="FTCodigo" id="FTCodigo" />

                            <span class="input-group-btn">
                                <button onclick="filtrarSimples()" type="button" class="btn btn-labeled btn-info">
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

            <div class="panel-body" id="BuscaAvancada" style="display:none">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Curso</label><br/>
                            <select name="FTCurso" id="FTCurso" class="form-control">
                                <option value=""></option>
                                <? foreach ($cursos as $row) { ?>
                                    <option value="<?= $row->CD_CURSO ?>"><?= $row->NM_CURSO_RED ?></option>
                                <? } ?>
                            </select>
                        </div> 
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Série</label><br/>
                            <select name="FTSerie" id="FTSerie" class="form-control">
                                <option value=""></option>
                            </select>
                        </div> 
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Disciplina</label>
                            <div class="input-group">
                                <select name="FTDisciplina" id="FTDisciplina" class="form-control">
                                    <option value=""></option>
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
            </div>

            <div class="panel-body">
                <div role="tabpanel" class="table-responsive" id="tblFiltro">
                </div>
            </div>
        </div>
        <!-- END panel-->
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
            serie: $("select[id=FTSerie]").val(),
        },
                function (valor) {
                    $("select[id=FTDisciplina]").html(valor);
                });
    });
    $('.content').on('click', '[data-toggle="frmModalInfo"]',
            function (e) {
                $('#frmModalInfo').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade hmodal-infor"  id="frmModalInfo"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
</script>

<? $this->load->view('home/footer'); ?>