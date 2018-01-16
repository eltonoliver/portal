<table class="display table table-striped table-hover" id="tblGrid">
    <thead>
        <tr class="panel-footer">
            <td><strong>ID</strong></td>
            <td><strong>N. PROVA</strong></td>
            <td><strong>DT. PROVA</strong></td>
            <td><strong>DISCIPLINA</strong></td>
            <td class="text-center"><strong>CH</strong></td>
            <td class="text-center"><strong>QUESTÕES</strong></td>
            <td class="text-center"><strong>ALUNOS</strong></td>
            <td class="text-center"><strong>VERSÕES</strong></td>
            <td class="text-center"><strong>NOTA</strong></td>
            <td class="text-center"><strong>STATUS</strong></td>
            <td class="text-center"><strong>OPÇÕES</strong></td>
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
                <td><?= date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$row['DT_PROVA'])))));?></td>
                <td><?= $row['DISCIPLINAS'] ?></td>
                <td class="text-center"><?= $row['CHAMADA'].'ª'?></td>
                <td class="text-center"><?= $row['QUESTOES'] ?></td>
                <td class="text-center"><?= $row['ALUNOS'] ?></td>
                <td class="text-center"><?= $row['VERSOES'] ?></td>
                <td class="text-center"><?= $row['NM_MINI'] ?></td>
                <td class="text-center">
                    <?= (($row['FLG_PEND_PROCESSAMENTO'] == 0)? '<small class="label label-success">Prova Realizada.</small>' : $new->prova_status($row['CD_STATUS']))?>
                </td>
                <td class="text-center">
                    <a class="btn btn-warning btn-xs" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova/frmNovaProvaConfiguracao/'.$row['CD_PROVA'].'')?>" >
                        <i class="fa fa-edit"></i> Detalhes
                    </a>
                     <a class="btn btn-danger btn-xs" href="#" onclick="btnExcluir(<?=$row['CD_PROVA']?>);">
                        <i class="fa fa-trash-o"></i> Excluir versões
                    </a>
                </td>
            </tr>
        <? } ?>
    </tbody>
    <tfoot>
        <tr class="panel-footer">
            <td colspan="12">
            </td>
        </tr>
    </tfoot>
</table>
<script>
    $(function () {
        // Initialize Example 2
        $('#tblGrid').dataTable();
    });
    
    function btnExcluir(id){  
        swal({
            title: "Excluir Versões da Prova",
            text: "Você deseja realmente excluir as versões desta prova?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true},
        function(isConfirm) {
            if (isConfirm) {
                swal("Excluir versões!", "Aguarde enquanto o sistema exclui os registros!", "success");
                $.post("<?= base_url('108/prova/excluirVersoes') ?>", {
                    prova: id
                },
                function (valor) {
                    
                    window.open('<?=base_url('108/prova/index')?>', '_self');
                });
            } 
        }); 
    }
</script>