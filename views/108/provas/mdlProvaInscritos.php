<div class="modal-dialog modal-lg">
    <script type="text/javascript">
        $("select[id=avalTurma]").change(function() {
            $("div[id=tblViewResposta]").html('Carregando');
            $.post("<?= base_url('108/prova_inscritos/grdTurmaAlunos')?>/" + $(this).val() + "", {},
            function(valor) {
                $("div[id=tblViewResposta]").html(valor);
            });
        });
    </script>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h4 class="modal-title">Turmas</h4>
            <select name="avalTurma" id="avalTurma" class="form-control avalProfessorLista">
                <option value=""></option>
                <? foreach ($turma as $row) { ?>
                    <option value="<?= $row['CD_TURMA'] ?>"><?= $row['CD_TURMA'] ?></option>
                <? } ?>
            </select>
        </div>
        <div class="modal-body no-padding" id="tblViewResposta">

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-<?= (($operacao == 'U') ? 'warning' : (($operacao == 'D') ? 'danger' : 'info')) ?> btnSalvarDisciplinas">Salvar Dados</button>
        </div>
    </div>
</div>
