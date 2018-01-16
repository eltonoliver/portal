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
                        <div class="col-lg-3 border-right animated-panel zoomIn" style="animation-delay: 0.3s;">
                            <div class="form-group">
                                <label>Quantidades</label>
                                <div class="input-group bootstrap-touchspin">
                                    <input name="qtdVersoes" id="qtdVersoes" value="5" readonly="readonly" type="text" class="form-control" style="display: block; font-size:20px">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 animated-panel zoomIn" style="animation-delay: 0.4s;">
                            <h5>
                                Informe quantas versões você deseja criar desta prova.
                            </h5>
                        </div>
                        <div class="col-lg-12  animated-panel zoomIn border-top" style="animation-delay: 0.4s;" id="rs">
                            <br /><small class="label label-danger"> * Após criar as versões, o cancelamento só pode ser feito pelo coordenador da área.</small>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="avalProva"  value="<?=$filtro[0]['CD_PROVA']?>" />
                <input type="hidden" name="operacao"  value="" />
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-info btnSalvarDisciplinas">Gerar Versões</button>
        </div>
    </div>
    <script>
    $(function() {
        $("#qtdVersoao--").TouchSpin({
            min: 1,
            max: 30,
            step: 1,
            decimals: 0,
            boostat: 5,
            maxboostedstep: 10,
        });
        
        $('.btnSalvarDisciplinas').click(function() {
            swal({
                title: "Salvar as Alterações?",
                text: "Salvar altarações realizadas nesta prova, caso haja alguma versão elas também serão atualizadas.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Sim, Salvar Dados!",
                cancelButtonText: "Não, Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: false},
            function(isConfirm) {
                if (isConfirm) {
                    swal("Dados Salvos!", "As alterações foram realizadas com sucesso!.", "success");
                } else {
                    swal("Cancelado", "Os dados não fora salvos", "error");
                }
            });
        });
        
    });

</script>
</div>
