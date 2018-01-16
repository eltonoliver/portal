<div class="modal-dialog">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-header">
            <h4 class="modal-title">Gerar Versões da Prova :: <?=$filtro[0]['NUM_PROVA']?></h4>
        </div>
        <div class="modal-body">
            <form name="frmProvaDisiplina" id="frmProvaDisiplina">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4 border-right animated-panel zoomIn" style="animation-delay: 0.3s;">
                            <div class="form-group">
                                <label>Quantidades</label>
                                <div class="input-group bootstrap-touchspin">
                                    <input name="qtdVersoes" id="qtdVersoes" value="<?=$filtro[0]['ALUNOS']?>" type="number" class="form-control" style="display: block; font-size:18px; text-align: center">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 animated-panel zoomIn" style="animation-delay: 0.4s;">
                            <h5>
                                Informe quantas versões você deseja criar desta prova.
                            </h5>
                        </div>
                        <div class="col-lg-12  animated-panel zoomIn border-top" style="animation-delay: 0.4s;" id="rs">
                            <small class="label label-danger" id="RTNProvaVersao"></small>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="avalVSProva" name="avalVSProva"  value="<?=$filtro[0]['CD_PROVA']?>" />
                <input type="hidden" name="operacao"  value="" />
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-info btnGerarVersao">Gerar Versões</button>
        </div>
    </div>
    <script>
    $(function() {
        $("#qtdVersoes").TouchSpin({
            min: 1,
            max: 30,
            step: 1,
            decimals: 0,
            boostat: 5,
            maxboostedstep: 10,
        });

        $('.btnGerarVersao').click(function() {
            swal({
                title: "Salvar as Alterações?",
                text: "Salvar altarações realizadas nesta prova, caso haja alguma versão elas também serão atualizadas.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, Salvar Dados!",
                cancelButtonText: "Não, Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    
                    swal("Gerando versões!", "Aguarde enquanto o sistema gera os registros!", "success");

                    $("small[id=RTNProvaVersao]").html('Carregando');
                    $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_versoes/GerarVersoes') ?>", {
                        prova: $("input[name=avalVSProva]").val(), // Prova
                          qtd: $("input[name=qtdVersoes]").val(),  // Quantidade de Provas
                    },
                    function(data) {
                        $("small[id=RTNProvaVersao]").html(data);
                        window.setTimeout(refreshPage, 500);
                    });
                    
                } else {
                    swal("Cancelado", "Os dados não fora salvos", "error");
                }

            });
        });
    });
</script>
</div>
