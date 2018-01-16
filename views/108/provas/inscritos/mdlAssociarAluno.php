<div class="modal-dialog">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-body">
            <h4 class="modal-title">Associar as provas aos alunos.</h4>
            <input type="hidden" name="nrProva" id="nrProva" value="<?= $prova?>" />
            <div class="modal-body no-padding" id="tblViewResposta"></div>
        </div>
        <div class="modal-footer" id="tblViewRetorno"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-info" id="btnAssociar">Associar Agora!</button>
        </div>
    </div>
    <script type="text/javascript">
        $("#btnAssociar").click(function() {
            $("div[id=tblViewRetorno]").html('<option>Carregando</option>');
            $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_inscritos/mdlAssociar') ?>", {
                prova: $("input[id=nrProva]").val(),
            },
            function(valor) {
                $("div[id=tblViewRetorno]").html(valor);
                window.setTimeout(refreshPage, 500);
            });
        });
    </script>
</div>
