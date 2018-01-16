<table class="display table table-striped table-hover" id="tblGrid">
    <thead>
        <tr class="panel-footer">
            <td><strong>ID</strong></td>
            <td><strong>N. PROVA</strong></td>
            <td><strong>DISCIPLINA</strong></td>
            <td align="center"><strong>CH</strong></td>
            <td align="center"><strong>QUESTÕES</strong></td>
            <td align="center"><strong>ALUNOS</strong></td>
            <td align="center"><strong>VERSÕES</strong></td>
            <td align="center"><strong>NOTA</strong></td>
            <td><strong>STATUS</strong></td>
            <td align="center"></td>
        </tr>
    </thead>
    <tbody>
        <?
        foreach ($resultado as $row) {
            ?>
            <tr>
                <td><?= $row['CD_PROVA'] ?></td>
                <td><?= $row['NUM_PROVA'] ?></td>
                <td><?= $row['DISCIPLINAS'] ?></td>
                <td align="center"><?= $row['CHAMADA'].'ª'?></td>
                <td align="center"><?= $row['QUESTOES'] ?></td>
                <td align="center"><?= $row['ALUNOS'] ?></td>
                <td align="center"><?= $row['VERSOES'] ?></td>
                <td align="center"><?= $row['NM_MINI'] ?></td>
                <td align="center"><? echo $opcoes; ?></td>
                <td>
                    <a class="btn btn-warning btn-xs" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova/frmNovaProvaConfiguracao/'.$row['CD_PROVA'].'')?>" >
                        <i class="fa fa-edit"></i> Detalhes
                    </a>
                </td>
            </tr>
        <? } ?>
    </tbody>
    <tfoot>
        <tr class="panel-footer">
            <td colspan="11">
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