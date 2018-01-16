<script type='text/javascript'>//<![CDATA[

    $(function() {
        $('#todos').click(function() {
            var val = this.checked;
            $('input[name=lstAlunos[]]').each(function() {
                $(this).prop('checked', val);
            });
        });
    });
    function habilitar(id) {
        if (id != '') {
            $('.btnInscreverManual').removeAttr('disabled');
            $('#todos').removeAttr('disabled');
        } else {
            $('.btnInscreverManual').attr('disabled');
            $('#todos').attr('disabled');
        }
    }
</script>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <td></td>
            <td>
                LISTA DE ALUNOS DA TURMA :: <?= $lista[0]['CD_TURMA'] ?>
            </td>
        </tr>
    </thead>
    <tbody>
        <? foreach ($lista as $row) { ?>
            <tr height="10px">
                <td></td>
                <td>
                    <div class="checkbox checkbox-info no-margins">
                        <input onchange="habilitar()" class="checkbox" name="lstAlunos[]" value="<?= $row['CD_ALUNO'] ?>" id="lstAlunos<?= $row['CD_ALUNO'] ?>" type="checkbox">
                        <label for="lstAlunos<?= $row['CD_ALUNO'] ?>">
                            <?= $row['CD_TURMA'] . ' - ' . $row['CD_ALUNO'] . ' - <strong>' . $row['NM_ALUNO'] . '</strong>' ?>
                        </label>
                    </div>
                </td>
            </tr>
        <? } ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td>
                <input type="hidden" name="avalProva" id="avalProva" value="<?= $prova?>" />
                <button disabled id="btnInscreverManual" name="btnInscreverManual" type="button" class="btn btn-<?= (($operacao == 'U') ? 'warning' : (($operacao == 'D') ? 'danger' : 'info')) ?> btnInscreverManual">Inscrever Selecionados</button>
            </td>
        </tr>
    </tfoot>
</table>
<script>
    $('.btnInscreverManual').click(function() {
        swal({
            title: "Inscrição",
            text: "Você tem certeza que deseja inscrever esses alunos nesta prova?",
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
                $.post("<?= base_url('108/prova_inscritos/frmNovaInscricao') ?>", {
                avalProva: $("#avalProva").val(),
                    aluno: $("input[name='lstAlunos[]']:checked").serialize(),
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