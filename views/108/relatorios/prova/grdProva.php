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
        $new = new Prova_lib();
        foreach ($resultado as $row) {
            ?>
            <tr>
                <td>
            <?= $row['CD_PROVA'] ?></td>
                <td><?= $row['NUM_PROVA'] ?></td>
                <td><?= $row['DISCIPLINAS'] ?></td>
                <td align="center"><?= $row['CHAMADA'].'ª'?></td>
                <td align="center"><?= $row['QUESTOES'] ?></td>
                <td align="center"><?= $row['ALUNOS'] ?></td>
                <td align="center"><?= $row['VERSOES'] ?></td>
                <td align="center"><?= $row['NM_MINI'] ?></td>                
                <? if ($row['FLG_PEND_PROCESSAMENTO'] == 0){ ?>
                <td align="center">
                    <?= (($row['FLG_PEND_PROCESSAMENTO'] == 0)? '<small class="label label-success">Prova Realizada.</small>' : $new->prova_status($row['CD_STATUS']))?>
                </td>
                <td>
                    <a class="btn btn-warning btn-xs" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/relatorio_prova/mdlGraficoProva/'.$row['CD_PROVA'].'')?>" >
                        <i class="fa fa-line-chart"></i> Gráficos
                    </a>                    
                </td>
                <? }else{ ?>
                <td colspan="2" align="center">
                    <small class="label label-danger"> Esta Prova ainda não foi processada!</small>
                </td>
                <? } ?>
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
        $('#tblGrid').dataTable();
    });
</script>