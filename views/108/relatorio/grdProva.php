<table class="display table table-hover" id="tblGrid">
    <thead>
        <tr class="panel-footer">
            <td><strong>ID</strong></td>
            <td><strong>N. PROVA</strong></td>
            <td><strong>DT. PROVA</strong></td>
            <td><strong>DISCIPLINA</strong></td>
            <td class="text-center"><strong>CH</strong></td>
            <td class="text-center"><strong>NOTA</strong></td>
            <td class="text-center"><strong>STATUS</strong></td>
            <td class="text-center"><strong></strong></td>
        </tr>
    </thead>
    <tbody>
        <? foreach ($resultado as $row) { ?>
            <tr>
                <td>
            <?= $row['CD_PROVA'] ?></td>
                <td><?= $row['NUM_PROVA'] ?></td>
                <td><?= date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$row['DT_PROVA'])))));?></td>
                <td><?= $row['DISCIPLINAS'] ?></td>
                <td class="text-center"><?= $row['CHAMADA'].'ª'?></td>
                <td class="text-center"><?= $row['NM_MINI'] ?></td>
                <td class="text-center">
                    <?= (($row['FLG_PEND_PROCESSAMENTO'] == 0)? '<small class="label label-success"><i class="fa fa-check"></i></small>' : '<small class="label label-danger"><i class="fa fa-times"></i></small>')?>
                </td>
                <td class="text-center">
                    <a class="btn btn-xs" href="<?=base_url($tela.'frmRelatorio?p='.base64_encode(json_encode($row)).'')?>">
                        <i class="fa fa-search-plus"></i> Exibir
                    </a>
                    
                    <a target='_blank' class="btn btn-xs" href="<?=base_url('108/prova_gabarito/relatorio_opcao/?id='.base64_encode($row['CD_PROVA']).'')?>">
                        <i class="fa fa-search-plus"></i> Prova Gabaritada
                    </a>
                </td>
            </tr>
        <? } ?>
    </tbody>
</table>
<script>
    $(function () {
        $('#tblGrid').dataTable();
    });
</script>