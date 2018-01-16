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
            $('.btnExcluirProva').removeAttr('disabled');
            $('.btnExcluirAluno').removeAttr('disabled');
            $('.btnReprografia').removeAttr('disabled');
            $('.btnProvaObjetiva').removeAttr('disabled');
            $('#todos').removeAttr('disabled');
        } else {
            $('.btnExcluirProva').attr('disabled');
            $('.btnExcluirAluno').attr('disabled');
            $('.btnReprografia').attr('disabled');
            $('.btnProvaObjetiva').attr('disabled');
            $('#todos').attr('disabled');
        }
    }
</script>

<table class="display table table-striped table-hover" id="tblGrid">
    <thead>
        <tr class="panel-footer">
            <td></td>
            <td><strong>ID</strong></td>
            <td><strong>N. PROVA</strong></td>
            <td><strong>DISCIPLINA</strong></td>
            <td align="center"><strong>CH</strong></td>
            <td align="center"><strong>QUESTÕES</strong></td>
            <td align="center"><strong>ALUNOS</strong></td>
            <td align="center"><strong>VERSÕES</strong></td>
            <td align="center"><strong>NOTA</strong></td>
            <td><strong>STATUS</strong></td>
        </tr>
    </thead>
    <tbody>
        <?
        $new = new Prova_lib();
        foreach ($resultado as $row) {
            if($row['FLG_PEND_PROCESSAMENTO'] == 1){
            ?>
            <tr>
                <td><input style="display: none" onchange="habilitar()" class="checkbox" name="prova[]" value="<?= $row['CD_PROVA'] ?>" id="prova_<?= $row['CD_PROVA'] ?>" type="radio"></td>
                <td><?= $row['CD_PROVA'] ?></td>
                <td><?= $row['NUM_PROVA'] ?></td>
                <td><?= $row['DISCIPLINAS'] ?></td>
                <td align="center"><?= $row['CHAMADA'].'ª'?></td>
                <td align="center"><?= $row['QUESTOES'] ?></td>
                <td align="center"><?= $row['ALUNOS'] ?></td>
                <td align="center"><?= $row['VERSOES'] ?></td>
                <td align="center"><?= $row['NM_MINI'] ?></td>
                <td align="center">
                    <?= (($row['FLG_PEND_PROCESSAMENTO'] == 0)? '<small class="label label-success">Prova Realizada.</small>' : $new->prova_status($row['CD_STATUS']))?>
                </td>
            </tr>
        <? } } ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="10" height="20px"></td>
        </tr>
        <tr class="panel-footer" style="display: none">
            <td colspan="10">
                <button disabled id="btnExcluirProva" name="btnExcluirProva" type="button" class="btn btn-danger btnExcluirProva">
                  Exclui Prova
                </button>
                <button disabled id="btnExcluirAluno" name="btnExcluirAluno" type="button" class="btn btn-danger2 btnExcluirAluno">
                  Exclui Versões e Alunos
                </button>
                <button disabled id="btnReprografia" name="btnReprografia" type="button" class="btn btn-warning btnReprografia">
                   Reprografia
                </button>
                <button disabled id="btnProvaObjetiva" name="btnProvaObjetiva" type="button" class="btn btn-info btnProvaObjetiva">
                   PDF - Objetiva
                </button>
            </td>
        </tr>
    </tfoot>
</table>
<script>
    $(function () {
        // Initialize Example 2
        $('#tblGrid').dataTable();
    });
</script>

<script>
    
    
    $('.btnReprografia').click(function() {
        swal({
            title: "Reprografia",
            text: "Você tem certeza que deseja enviar essa prova para a Reprografia?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sim, Enviar!",
            cancelButtonText: "Não, Cancelar!",
            closeOnConfirm: false,
            closeOnCancel: true,
        },
        function(isConfirm) {
            if (isConfirm) {
                // Chama a função que inscreverá o aluno na prova manualmente
                $.post("<?= base_url('108/coordenador/frmReprografia') ?>", {
                    prova: $("input[name='prova[]']:checked").serialize(),
                },
                function(data) {
                    swal("Sucesso!", "Inscrições realizadas com sucesso!", "success");
                    $("#tblViewRetorno").html(data);
                    window.setTimeout(refreshPage, 500);
                });
            }
        });
    });
    
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