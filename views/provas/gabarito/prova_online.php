<?php $this->load->view('layout/header'); ?>

<div id="content">
    <div class="row">
        <div class="col-md-3 pull-left">
            <div class="form-group">
                <label>BIMESTRE</label>
                <select id="FTBimestreOnline" class="form-control">
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
                <a id="link-gabarito-online" target="_blank" class="btn btn-default">
                    <i class="fa fa-print"></i> IMPRIMIR
                </a>
            </div>
        </div>
    </div>

    <div id="grid-gabaritos-online"></div>
</div>

<script type="text/javascript">
    $("#FTBimestreOnline").change(function () {
        var bimestre = $("#FTBimestreOnline").val();
        
        if (bimestre !== "") {
            $("#grid-gabaritos-online").html('<?= LOAD_BAR?>');
            
            $.ajax({
                url: "<?= site_url("provas/gabarito/grid_prova_online") ?>",
                method: "post",
                data: {
                    bimestre: bimestre,
                    token: "<?= $token ?>"
                },
                success: function (response) {
                    $("#grid-gabaritos-online").html(response);
                }
            });
        }
    });

    $("#link-gabarito-online").click(function (e) {
        e.preventDefault();
        var url = "https://seculomanaus.com.br/academico/108/relatorio_aluno/gabaritosProvasOnline?token=<?= $token ?>";
        //var url = "http://10.229.63.53/academico/108/relatorio_aluno/gabaritosProvasOnline?token=<?= $token ?>";
        //var url = "https://seculomanaus.com.br/portal/prova_gabarito/avaliacao_online/gabaritosProvasOnline?token=<?= $token ?> 
        if ($("#FTBimestreOnline").val() !== "") {
            url += "&bimestre=" + $("#FTBimestreOnline").val();
            window.open(url, "_blank");
        }
    });
</script>

<?php $this->load->view('layout/footer'); ?>