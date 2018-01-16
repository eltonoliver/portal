<? $this->load->view('home/header'); ?>
<script type='text/javascript'>//<![CDATA[
    $(window).load(function () {
        $(function () {
            $(".btn-toggle").click(function (e) {
                e.preventDefault();
                el = $(this).data('element');
                $(el).toggle();
            });
        });
    });//]]> 

    function txtFiltrar() {
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url('' . $this->session->userdata('SGP_SISTEMA') . '/questionario_professor/grdRegistro') ?>", {
            quest: $("#FTQuest").val(),
            periodo: $("#FTPeriodo").val(),
            bimestre: $("#FTBimestre").val(),
            curso: $("#FTCurso").val(),
            serie: $("#FTSerie").val(),
            turma: $("#FTTurma").val(),
            disciplina: $("#FTDisciplina").val(),
            tipo: $("#FTTipo").val()
        },
        function (valor) {
            $("#tblFiltro").html(valor);
        });
    }
</script>
<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-footer">
                <div class="row">                    
                    <div class="form-inline col-xs-12 text-right">
                        <div class="form-group">
                            <label>QUESTIONÁRIO</label><br>
                            <select name="FTQuest" id="FTQuest" class="form-control input-sm" style="width:150px">
                                <option></option>
                                <?
                                foreach ($quest as $qst) {
                                    if ($qst['CD_QUEST'] > 4) {
                                        ?>
                                        <option value="<?= $qst['CD_QUEST'] ?>"><?= $qst['DC_QUEST'] ?></option>
                                        <?
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>PERÍODO</label><br>
                            <select name="FTPeriodo" id="FTPeriodo" class="form-control input-sm" style="width:150px">
                                <? foreach ($periodo as $per) { ?>
                                    <option value="<?= $per['DC_PERIODO'] ?>"><?= $per['DC_PERIODO'] ?></option>
                                <? } ?>
                            </select>

                        </div>                        
                        <div class="form-group">
                            <label>CURSO</label><br>
                            <select name="FTCurso" id="FTCurso" class="form-control input-sm" style="width:150px">
                                <option value=""></option>
                                <? foreach ($curso as $row) { ?>
                                    <option value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO_RED'] ?></option>
                                <? } ?>
                            </select>
                        </div> 
                        <div class="form-group">
                            <label>SÉRIE</label><br>
                            <select name="FTSerie" id="FTSerie" class="form-control input-sm" style="width:120px">
                                <option value=""></option>
                            </select>
                        </div> 
                        <div class="form-group">
                            <label>TURMA</label><br>
                            <select name="FTTurma" id="FTTurma" class="form-control input-sm" style="width:120px">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>DISCIPLINA</label><br>
                            <select name="FTDisciplina" id="FTDisciplina" class="form-control input-sm" style="width:120px">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>TIPO</label><br>
                            <select name="FTTipo" id="FTTipo" class="form-control input-sm" style="width:120px">
                                <option value="P">POR PERGUNTA</option>
                                <option value="T">POR TÓPICO</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>BIMESTRE</label><br>
                            <select name="FTBimestre" id="FTBimestre" class="form-control input-sm">
                                <option value="">TODOS</option>
                                <option value="1">1º Bimestre</option>
                                <option value="2">2º Bimestre</option>
                                <option value="3">3º Bimestre</option>
                                <option value="4">4º Bimestre</option>
                                <option value="5">5º Bimestre</option>
                            </select>
                        </div>
                        <div class="input-group"><br>
                            <button onclick="txtFiltrar()" type="button" id="" class="btn btn-sm btn-info">
                                <span class="btn-label">
                                    <i class="fa fa-search"></i>
                                </span>
                                Filtrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body" id="tblFiltro">
                <small>Faça primeiro o filtro</small>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $("select[id=FTCurso]").change(function () {
        $("select[id=FTSerie]").html('<option>Carregando</option>');
        $.post("<?= base_url('/comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function (valor) {
            $("select[id=FTSerie]").html(valor);
        });
    });

    $("select[name=FTSerie]").change(function () {
        $("select[name=FTTurma]").html('Carregando');
        $.post("<?= base_url('/comum/combobox/turma') ?>", {
            curso: $('select[name=FTCurso]').val(),
            serie: $('select[name=FTSerie]').val(),
        },
                function (valor) {
                    $("select[name=FTTurma]").html(valor);
                });
    });

    $("select[name=FTSerie]").change(function () {
        $("select[name=FTDisciplina]").html('Carregando');
        $.post("<?= base_url('/comum/combobox/disciplina') ?>", {
            curso: $('select[name=FTCurso]').val(),
            serie: $('select[name=FTSerie]').val(),
        },
                function (valor) {
                    $("select[name=FTDisciplina]").html(valor);
                });
    });
</script>
<? $this->load->view('home/footer'); ?>