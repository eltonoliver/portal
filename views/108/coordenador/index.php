<? $this->load->view('home/header'); ?>
<script type='text/javascript'>//<![CDATA[
$(window).load(function(){
$(function(){
    $(".btn-toggle").click(function(e){
        e.preventDefault();
        el = $(this).data('element');
        $(el).toggle();
    });
});
});//]]> 

    function txtFiltrar() {
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/coordenador/grdProva') ?>", {
            filtro: 0,
            periodo: $("#FTPeriodo").val(),
            tipo: $("#FTTipo").val(),
            curso: $("#FTCurso").val(),
            serie: $("#FTSerie").val(),
            disciplina: $("#FTDisciplina").val(),
            bimestre: $("#FTBimestre").val(),
            tipo_nota: $("#FTTipoNota").val(),
            chamada: $("#FTChamada").val(),
        },
        function(valor) {
            $("#tblFiltro").html(valor);
        });
    };
    
    function txtNumProvaFiltrar() {
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/coordenador/grdProva') ?>", {
            filtro: 1,
            numProva: $("#avalNumProva").val(),
        },
        function(valor) {
            $("#tblFiltro").html(valor);
        });
    };
</script>
<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-footer">
                <div class="row">
                <div class="col-sm-7">
                    &zwnj;
                </div>
                <div class="col-sm-5">
                    Num. Prova:
                    <div class="input-group btn-group">                        
                        <input placeholder="Ex: 2015000000" class="form-control  input-group-addon" type="text" name="avalNumProva" id="avalNumProva" />
                        <span class="input-group-btn">
                            <button onclick="txtNumProvaFiltrar()" type="button" id="" class="btn btn-labeled btn-info">
                                <span class="btn-label"><i class="fa fa-search"></i></span>
                                Filtrar
                            </button>
                        </span>
                        <span class="input-group-btn">
                            <button type="button" class="btn-toggle btn btn-labeled btn-warning2" data-element="#BuscaAvancada">
                                <span class="btn-label"><i class="fa fa-gear"></i></span>
                                Busca Avançada
                            </button>
                        </span>
                    </div>
                </div>
                    </div>
            </div>
            <div class="panel-body" id="BuscaAvancada" style="display:none">
                <form role="form" class="form-inline">
                    <div class="form-group"><br>
                        <select name="FTPeriodo" id="FTPeriodo" class="form-control m-b">
                            <option value="">PERÍODO</option>
                            <? foreach ($periodo as $row) { ?>
                                <option value="<?= $row['DC_PERIODO'] ?>" <?= $row['DC_PERIODO'] == $this->session->userdata('SGP_PERIODO') ? "selected" : "" ?>>
                                    <?= $row['DC_PERIODO'] ?>
                                </option>
<? } ?>
                        </select>
                    </div>
                    <div class="form-group"><br>
                        <select name="FTTipo" id="FTTipo" class="form-control m-b">
                            <option value="">TIPO DE PROVA</option>
                            <? foreach ($tipo_prova as $row) { ?>
                                <option value="<?= $row['CD_TIPO_PROVA'] ?>"><?= $row['DC_TIPO_PROVA'] ?></option>
<? } ?>
                        </select>
                    </div>
                    <div class="form-group"><br>
                        <select name="FTCurso" id="FTCurso" class="form-control m-b" style="width:150px">
                            <option value="">CURSO</option>
                            <? foreach ($curso as $row) {
                                if ($row['CD_CURSO'] <> 1) { ?>
                                    <option value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO'] ?></option>
    <? }
} ?>
                        </select>
                    </div> 
                    <div class="form-group"><br>
                        <select name="FTSerie" id="FTSerie" class="form-control m-b" style="width:120px">
                            <option value="">SÉRIE</option>
                        </select>
                    </div> 
                    <div class="form-group"><br>
                        <select name="FTBimestre" id="FTBimestre" class="form-control m-b" >
                            <option value="">BIMESTRE</option>
                            <option value="1">1º Bimestre</option>
                            <option value="2">2º Bimestre</option>
                            <option value="3">3º Bimestre</option>
                            <option value="4">4º Bimestre</option>
                            <option value="5">5º Bimestre</option>
                        </select>
                    </div>
                    <div class="form-group"><br>
                        <select name="FTTipoNota" id="FTTipoNota" class="form-control m-b" >
                            <option value="">TIPO DE NOTA</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <select name="FTChamada" id="FTChamada" class="form-control m-b" >
                            <option value="">CHAMADA</option>
                            <option value="1">1ª Chamada</option>
                            <option value="2">2ª Chamada</option>
                        </select>
                        <span class="input-group-btn">
                            <button onclick="txtFiltrar()" type="button" id="" class="btn btn-labeled btn-info">
                                <span class="btn-label"><i class="fa fa-search"></i></span>
                                Filtrar
                            </button>
                        </span>
                    </div>
                    
                    
                </form>
            </div>
            <div class="panel-body" id="tblFiltro">
                <small>Faça primeiro o filtro</small>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $("select[id=FTCurso]").change(function() {
        $("select[id=FTSerie]").html('<option>Carregando</option>');
        $.post("<?= base_url('/comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function(valor) {
            $("select[id=FTSerie]").html(valor);
            $("select[id=FTDisciplina]").html('');
        });
    });

    $("select[name=FTBimestre]").change(function() {
        $("select[name=FTTipoNota]").html('Carregando');
        $.post("<?= base_url('/comum/combobox/notas') ?>", {
            bimestre: $('select[name=FTBimestre]').val(),
            curso: $('select[name=FTCurso]').val(),
        },
        function(valor) {
            $("select[name=FTTipoNota]").html(valor);
        });
    });

    $("select[name=FTCurso]").change(function() {
        $("input[name=FTEstrutura]").html('Carregando');
        $.post("<?= base_url('/comum/combobox/estrutura') ?>", {
            curso: $('select[name=FTCurso]').val(),
        },
        function(valor) {
            $("input[name=FTEstrutura]").val(valor);
        });
    });


</script>
<? $this->load->view('home/footer'); ?>