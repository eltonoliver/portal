<div class="modal-dialog">
    <script type="text/javascript">
        $("select[id=avalTurma]").change(function() {
            $("div[id=tblViewResposta]").html('Carregando');
            $.post("<?= base_url('108/prova_inscritos/grdTurmaAlunos') ?>/" + $(this).val() + "", {
                avalProva : <?=$prova[0]['CD_PROVA']?>
            },
            function(valor) {
                $("div[id=tblViewResposta]").html(valor);
            });
        });
    </script>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-body">
            <h4 class="modal-title">Turmas</h4>
            <select onchange="habilitar(this.value)" name="avalTurma" id="avalTurma" class="form-control avalProfessorLista">
                <option value=""></option>
                <? foreach ($turma as $row) { ?>
                    <option value="<?= $row['CD_TURMA'] ?>"><?= $row['CD_TURMA'] ?></option>
                <? } ?>
            </select>
            <input type="hidden" name="avalProva" id="avalProva" value="<?= $prova?>" />
            <div class="modal-body no-padding" id="tblViewResposta"></div>
        </div>
        <div class="modal-footer" id="tblViewRetorno"></div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        </div>
    </div>
</div>
