<div class="modal-dialog">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-4">
                    <h4>Curso</h4>
                    <select name="avalAliCurso" id="avalAliCurso" class="form-control avalProfessorLista">
                        <option value=""></option>
                        <? foreach ($curso as $row) { ?>
                        <option value="<?= $row['CD_CURSO'] ?>"><?= $row['NM_CURSO'] ?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="col-sm-3">
                    <h4>Série</h4>
                    <select name="avalAliSerie" id="avalAliSerie" class="form-control avalProfessorLista">
                    </select>
                    <input type="hidden" name="avalAliProva" id="avalAliProva" value="<?= $prova?>" />
                </div>
                <div class="col-sm-3">
                    <h4>&zwnj;</h4>
                    <button id="btnInscreverManual" name="btnInscreverManual" type="button" class="btn btn-info btnInscreverManual">Inscrever alunos</button>
                </div>
            </div>
            <div class="modal-footer" id="tblViewRetorno"></div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        </div>
    </div>
    
    <script type="text/javascript">
    $("select[id=avalAliCurso]").change(function() {
        $("select[id=avalAliSerie]").html('<option>Carregando</option>');
        $.post("<?= base_url('comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function(valor) {
            $("select[id=avalAliSerie]").html(valor);
        });
    });

    $("select[id=avalAliSerie]").change(function() {
        $("select[id=avalTurma]").html('<option>Carregando</option>');
        $.post("<?= base_url('comum/combobox/turma') ?>", {
            curso: $("select[id=avalAliCurso]").val(),
            serie: $(this).val()
        },
         function(valor) {
            $("select[id=avalTurma]").html(valor);
         });
    });

</script>

<script>
    $('.btnInscreverManual').click(function() {
        swal({
            title: "Inscrição",
            text: "Você tem certeza que deseja inscrever os alunos desta turma nesta prova?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sim, finalizar!",
            cancelButtonText: "Não, Cancelar!",
            closeOnConfirm: false,
            closeOnCancel: true,
        },
        function(isConfirm) {
            if (isConfirm) {
                // Chama a função que inscreverá o aluno na prova manualmente
                $.post("<?= base_url('108/prova_inscritos/frmNovaInscricaoAlinhamento') ?>", {
                avalProva: $("#avalAliProva").val(),
                avalCurso: $("#avalAliCurso").val(),
                avalSerie: $("#avalAliSerie").val(),
                },
                function(data) {
                    swal("Sucesso!", "Inscrições realizadas com sucesso!", "success");
                    $("#tblViewRetorno").html(data);
                    window.setTimeout(refreshPage, 500);
                });
            }
        });
    });
</script>
</div>
