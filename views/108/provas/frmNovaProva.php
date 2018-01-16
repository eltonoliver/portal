<? $this->load->view('home/header'); ?>

<script src='<?= base_url("libs/fullcalendar/lib/moment.min.js") ?>'></script>
<script src='<?= base_url("libs/fullcalendar/fullcalendar.js") ?>'></script>
<script src='<?= base_url("libs/fullcalendar/locale/pt-br.js") ?>'></script>

<script type="text/javascript">
    function filtrar() {
        $("#calendario-provas").fullCalendar("refetchEvents");
    }

</script>

<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">    
            <div class="panel-heading">                
            </div>

            <div class="panel-footer">                
                <div class="row">
                    <div class="col-xs-4 clearfix">                                                
                    </div>

                    <div class="col-xs-8">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Bimestre</label><br/>
                                <select name="Bimestre" id="FTBimestre" class="form-control input-sm">
                                    <option value=""></option>
                                    <option value="1">1º BIMESTRE</option>
                                    <option value="2">2º BIMESTRE</option>
                                    <option value="3">3º BIMESTRE</option>
                                    <option value="4">4º BIMESTRE</option>
                                    <option value="5">5º BIMESTRE</option>
                                </select>
                            </div>

                            <div class="col-sm-4" style="padding-left:0px">
                                <label>Curso</label><br/>
                                <select name="Curso" id="FTCurso" class="form-control input-sm">
                                    <option value=""></option>                                    
                                    <? foreach ($curso as $row) { ?>
                                        <option value="<?= $row['CD_CURSO'] ?>">
                                            <?= $row['NM_CURSO_RED'] ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </div>

                            <div class="col-sm-4" style="padding-left:0px">
                                <div class="form-group">
                                    <label>Série</label>
                                    <div class="input-group">
                                        <select name="Serie" id="FTSerie" class="form-control input-sm">
                                            <option value=""></option>
                                        </select>

                                        <span class="input-group-btn">
                                            <button onclick="filtrar()" type="button" class="btn btn-labeled btn-info input-sm">
                                                <span class="btn-label">
                                                    <i class="fa fa-search"></i>
                                                </span>
                                                Filtrar
                                            </button>
                                        </span>
                                    </div>
                                </div>                    
                            </div>
                        </div>
                    </div>
                </div>                    
            </div>

            <div class="panel-body">                
                <div id="calendario-provas">
                </div>

                <fieldset style="margin-top: 10px;">
                    <legend>Legenda</legend>

                    <div style="margin: 5px; font-weight: bold">
                        <span style="background-color: #5cb85c; margin-right: 5px">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                        </span> Cadastrado
                    </div>

                    <div style="margin: 5px; font-weight: bold">
                        <span style="background-color: #d9534f; margin-right: 5px;">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                        </span> Não cadastrado
                    </div>
                </fieldset>
            </div>      
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#calendario-provas").fullCalendar({
            locale: "pt-br",
            events: {
                url: "<?= site_url($this->session->userdata('SGP_SISTEMA') . "/prova/calendario") ?>",
                type: "POST",
                startParam: "inicio",
                endParam: "fim",
                data: function () {
                    return {
                        curso: $("#FTCurso").val(),
                        serie: $("#FTSerie").val(),
                        bimestre: $("#FTBimestre").val()
                    };
                },
                allDayDefault: true
            },
            eventClick: function (calEvent, jsEvent, view) {
                $('#formModalInfo').remove();
                var $this = $(this)
                        , $remote = $this.data('remote') || calEvent.modal
                        , $modal = $('<div class="modal fade hmodal-info"  id="formModalInfo"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
        });
    });

    $("#FTCurso").change(function () {
        $("FTSerie").html('<option>Carregando</option>');
        $.post("<?= base_url('comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function (valor) {
            $("#FTSerie").html(valor);
        });
    });
</script>

<? $this->load->view('home/footer'); ?>