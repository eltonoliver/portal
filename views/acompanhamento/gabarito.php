<div class="panel panel-info">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-3 pull-left">
                <div class="form-group">
                    <label>BIMESTRE</label>
                    <select id="FTBimestre" class="form-control">
                        <option value="">SELECIONE UM BIMESTRE</option>
                        <option value="1">1º BIMESTRE</option>
                        <option value="2">2º BIMESTRE</option>
                        <option value="3">3º BIMESTRE</option>
                        <option value="4">4º BIMESTRE</option>
                    </select>
                </div>
            </div>

            <div class="col-md-6 pull-right">
                <div class="pull-right">
                    <a id="link-gabarito" target="_blank" class="btn btn-default">
                        <i class="fa fa-print"></i> IMPRIMIR
                    </a>
                </div>
            </div>
        </div>        

        <div id="grid-gabaritos"></div>
    </div>    
</div>

<script type="text/javascript">
    $("#FTBimestre").change(function () {
        var bimestre = $("#FTBimestre").val();

        if (bimestre !== "") {
            $("#grid-gabaritos").html('<?= LOAD_BAR ?>');

            $.ajax({
                url: "<?= site_url("acompanhamento/gabarito") ?>",
                method: "post",
                data: {
                    bimestre: bimestre,
                    token: "<?= $token ?>"
                },
                success: function (response) {
                    $("#grid-gabaritos").html(response);
                }
            });
        }
    });

    $("#link-gabarito").click(function (e) {
        e.preventDefault();
        var url = "https://seculomanaus.com.br/academico/108/relatorio_aluno/gabaritosProvas?token=<?= $token ?>";
        //var url = "http://10.229.63.53/academico/108/relatorio_aluno/gabaritosProvas?token=<?= $token ?>";

        if ($("#FTBimestre").val() !== "") {
            url += "&bimestre=" + $("#FTBimestre").val();
            window.open(url, "_blank");
        }
    });
</script>