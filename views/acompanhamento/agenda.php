<div class="row">
    <div class="col-md-12">

        <div class="form-group">
            <label>Informe o Período</label>
            <div class="input-group col-sm-3"> <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input name="periodo" type="text" class="form-control" id="daterange">
            </div>
        </div>

        <div class="panel panel-info"  id="conteudo_tabela">
            <div class="panel-body" id="agenda-conteudo" style="min-height:250px">
            </div>
        </div>

    </div>
    <!-- Área que vai atualizar :final   -->
</div>

<script src="<?= SCL_JS ?>moment.min.js"></script>
<script type="text/javascript">
    function popularTabela(inicio, fim) {
        $("#conteudo").html('<?= LOAD_BAR ?>');
        $.ajax({
            url: "<?= site_url("secretaria/academico/agenda_lista_responsavel") . "?token=" . $token ?>" + "&inicio=" + inicio + "&fim=" + fim,
            success: function (data) {
                $('#agenda-conteudo').html(data);
            }
        });
    }

    $(document).ready(function () {
        var data = "<?= date('d/m/Y') ?>";
        popularTabela(data, data);
    });

    $('#daterange').daterangepicker({
        format: 'DD/MM/YYYY'
    },
    function (start, end) {
        popularTabela(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'));
    });
</script>

<?php exit(); ?>