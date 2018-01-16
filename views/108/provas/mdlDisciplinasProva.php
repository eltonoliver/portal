<div class="modal-dialog">
    <? $params = $filtro[0]['CD_PROVA'] . $filtro[0]['CD_DISCIPLINA'] . $filtro[0]['TIPO_QUESTAO']; ?>
    <script type="text/javascript">

        function svDisciplina() {
            var dados = jQuery('#frmProvaDisiplina<?= $params ?>').serialize();
            jQuery.ajax({
                type: "POST",
                url: "<?= base_url('108/prova/frmManterProvaDisciplina') ?>",
                data: dados,
                success: function(data) {
                    $("#rs<?= $params ?>").html(data);
                },
            });
            return false;
        };

        function pxNumeroFinal() {
            var inicial = $("[id='avalPosInicial<?= $params ?>']").val();
            var res = (parseInt(inicial) + parseInt(10));
            $("input[id='avalPosFinal<?= $params ?>']").val(res);
        }
        ;

        function vlNotasProvas() {
            var inicial = $("[id='avalNotaMaxima<?= $params ?>']").val();
            var res = (parseInt(10) - parseInt(inicial));
            $("input[id='avalNotaDissertativa<?= $params ?>']").val(res);
        }
        ;


    </script>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-header">
            <h4 class="modal-title">Disciplinas</h4>
        </div>
        <div class="modal-body">
            <form name="frmProvaDisiplina<?= $params ?>" id="frmProvaDisiplina<?= $params ?>">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-8 animated-panel zoomIn" style="animation-delay: 0.3s;">
                            <div class="form-group">
                                <label>Disciplina</label>
                                <select name="avalDisciplina" id="avalDisciplina<?= $params ?>" class="form-control avalProfessorLista input-sm">
                                    <option value=""></option>
                                    <? foreach ($disciplina as $row) { ?>
                                        <option <?= (($row['CD_DISCIPLINA'] == $filtro[0]['CD_DISCIPLINA']) ? 'selected="selected"' : '') ?> value="<?= $row['CD_DISCIPLINA'] ?>"><?= $row['NM_DISCIPLINA'] ?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-xs-4 border-right animated-panel zoomIn" style="animation-delay: 0.3s;">
                            <div class="form-group">
                                <label>Tipo</label><br>
                                <select name="avalTipoQuestoes" id="avalTipoQuestoes<?= $params ?>" class="form-control input-sm">
                                    <option value=""></option>
                                    <option <?= (($filtro[0]['TIPO_QUESTAO'] == 'D') ? 'selected="selected"' : '') ?> value="D">Dissertativas</option>
                                    <option <?= (($filtro[0]['TIPO_QUESTAO'] == 'O') ? 'selected="selected"' : '') ?> value="O">Objetivas</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-xs-4 border-right animated-panel zoomIn" style="animation-delay: 0.3s;">
                            <div class="form-group">
                                <label>Posição Inicial</label>
                                <div class="input-group bootstrap-touchspin">
                                    <input onchange="pxNumeroFinal()" name="avalPosInicial" id="avalPosInicial<?= $params ?>" value="<?= $filtro[0]['POSICAO_INICIAL'] ?>" readonly="readonly" type="text" class="form-control" style="display: block;">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-4  animated-panel zoomIn" style="animation-delay: 0.4s;">
                            <div class="form-group">
                                <label>Posição Final</label>
                                <div class="input-group bootstrap-touchspin">
                                    <input name="avalPosFinal" id="avalPosFinal<?= $params ?>" readonly="readonly" type="text" value="<?= $filtro[0]['POSICAO_FINAL'] ?>" class="form-control" style="display: block;">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-4  animated-panel zoomIn" style="animation-delay: 0.4s;">
                            <div class="form-group">
                                <label>Valor Questão</label>
                                <div class="input-group bootstrap-touchspin">
                                    <input name="vlQuestao" id="vlQuestao<?= $params ?>" type="text" value="<?= $filtro[0]['VL_QUESTAO'] ?>" class="form-control" style="display: block;">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4  animated-panel zoomIn" style="animation-delay: 0.4s;" id="rs"></div>
                    </div>

                </div>
                <input type="hidden" name="avalProva"  value="<?= (($filtro[0]['CD_PROVA'] == '') ? $prova : $filtro[0]['CD_PROVA']) ?>" />
                <input type="hidden" name="operacao"  value="<?= $operacao ?>" />
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-<?= (($operacao == 'U') ? 'warning' : (($operacao == 'D') ? 'danger' : 'info')) ?> btnSalvarDisciplinas">Salvar Dados</button>
        </div>
    </div>
    <script>
        $(function() {
            $("#avalPosInicial<?= $filtro[0]['CD_PROVA'] . $filtro[0]['CD_DISCIPLINA'] . $filtro[0]['TIPO_QUESTAO'] ?>").TouchSpin({
                min: 1,
                max: 100,
                step: 1,
                decimals: 0,
                boostat: 5,
                maxboostedstep: 10,
            });
            $("#avalPosFinal<?= $filtro[0]['CD_PROVA'] . $filtro[0]['CD_DISCIPLINA'] . $filtro[0]['TIPO_QUESTAO'] ?>").TouchSpin({
                min: 1,
                max: 100,
                step: 1,
                decimals: 0,
                boostat: 5,
                maxboostedstep: 10,
            });
            $("#vlQuestao<?= $filtro[0]['CD_PROVA'] . $filtro[0]['CD_DISCIPLINA'] . $filtro[0]['TIPO_QUESTAO'] ?>").TouchSpin({
                min: 0,
                max: 10,
                step: 0.0001,
                decimals: 4,
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
                        svDisciplina();
                        swal("Dados Salvos!", "As alterações foram realizadas com sucesso!.", "success");
                    } else {
                        swal("Cancelado", "Os dados não fora salvos", "error");
                    }
                });
            });

        });

    </script>
</div>
