<? $this->load->view('home/header'); ?>
<script type="text/javascript">
    function txtFiltrar() {
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url('relatorios/frmRelTblTema') ?>", {
            curso: $("#FTCurso").val(),
            serie: $("#FTSerie").val(),
            disciplina: $("#FTDisciplina").val(),
        },
        function(valor) {
            $("#tblFiltro").html(valor);
        });
    };
</script>
<section>
    <div class="content-wrapper">
        <div class="content-heading">
            Relatório por Temas
            <small data-localize="dashboard.WELCOME"></small>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- START panel-->
                <div class="panel panel-default">
                    <div class="panel-heading">Relatório de Questões</div>
                    <div class="panel-footer">
                        <form role="form" class="form-inline">
                            <div class="form-group">
                                <select name="FTCurso" id="FTCurso" class="form-control m-b" >
                                    <option value="">Escolha o Curso</option>
                                    <? foreach($curso as $row){ ?>
                                    <option value="<?=$row['CD_CURSO']?>"><?=$row['NM_CURSO']?></option>
                                    <? } ?>
                                </select>
                            </div> 
                            <div class="form-group">
                                <select name="FTSerie" id="FTSerie" class="form-control m-b" >
                                    <option value="">Escolha o Série</option>
                                </select>
                            </div> 
                            <div class="form-group">
                                <select name="FTDisciplina" id="FTDisciplina" class="form-control m-b" >
                                    <option value="">Escolha a Disciplina</option>
                                </select>
                            </div> 
                            <div class="form-group">
                                <button onclick="txtFiltrar()" type="button" id="" class="btn btn-labeled btn-info">
                                <span class="btn-label"><i class="fa fa-search"></i></span>
                                Filtrar
                                </button>
                            </div> 
                        </form>
                    </div>
                    <div class="panel-body">
                        <div role="tabpanel" id="tblFiltro">
                            
                        </div>
                    </div>
                </div>
                <!-- END panel-->
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    
    $("select[id=FTCurso]").change(function() {
        $("select[id=FTSerie]").html('<option>Carregando</option>');
        $.post("<?= base_url('combobox/serie') ?>", {
            curso: $(this).val()
        },
        function(valor) {
            $("select[id=FTSerie]").html(valor);
            $("select[id=FTDisciplina]").html('');
        });
    });

    $("select[id=FTSerie]").change(function() {
        $("select[id=FTDisciplina]").html('<option>Carregando</option>');
        $.post("<?= base_url('combobox/disciplina') ?>", {
            curso: $("select[id=FTCurso]").val(),
            serie: $("select[id=FTSerie]").val(),
        },
        function(valor) {
            $("select[id=FTDisciplina]").html(valor);
        });
    });

    $("select[id=FTBimestre]").change(function() {
        $("select[id=FTDisciplina]").html('<option>Carregando</option>');
        $.post("<?= base_url('combobox/disciplina') ?>", {
            curso: $("select[id=FTCurso]").val(),
            serie: $("select[id=FTSerie]").val(),
        },
        function(valor) {
            $("select[id=FTDisciplina]").html(valor);
        });
    });
    
    $('[data-toggle="frmModal"]').on('click',
        function(e) {
            $('#frmModal').remove();
            e.preventDefault();
            var $this = $(this)
                    , $remote = $this.data('remote') || $this.attr('href')
                    , $modal = $('<div class="modal fade"  id="frmModal"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
            $('body').append($modal);
            $modal.modal({backdrop: 'static', keyboard: false});
            $modal.load($remote);
        }
    );
</script>
<? $this->load->view('home/footer'); ?>