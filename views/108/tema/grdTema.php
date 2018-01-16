<h4>Encontrados</h4>

<table id="tbl" class="table table-hover table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center">CÓDIGO</th>
            <th class="text-center">CURSO</th>
            <th class="text-center">SÉRIE</th>
            <th class="text-center">DISCIPLINA</th>
            <th class="text-center">TEMA</th>            
            <th class="text-center">QTDE CONTEÚDO</th>
            <th class="text-center">AÇÕES</th>
        </tr>
    </thead>

    <tbody>
        <? foreach ($temas as $row) { ?>
            <tr>
                <td class="text-center col-xs-1"><?= $row->CD_TEMA ?></td>
                <td class="text-center col-xs-1"><?= $row->NM_CURSO ?></td>
                <td class="text-center col-xs-1"><?= $row->NM_SERIE ?></td>
                <td class="text-center col-xs-1"><?= $row->NM_DISCIPLINA ?></td>
                <td class="text-justify"><?= $row->DC_TEMA ?></td>                
                <td class="text-center col-xs-1"><?= $row->TOTAL_CONTEUDO ?></td>                                
                <td class="text-center col-xs-2">
                    <a class="btn btn-info btn-xs" href="<?= base_url('108/tema/modalTema') . '?codigo=' . $row->CD_TEMA . '&operacao=E' ?>" data-toggle="frmModalInfo" title="Editar Tema">
                        <i class="fa fa-edit"></i>
                    </a>
                    |
                    <a class="btn btn-danger btn-xs" href="<?= base_url('108/tema/modalTema') . '?codigo=' . $row->CD_TEMA . '&operacao=D' ?>" data-toggle="frmModalInfo" title="Excluir Tema">
                        <i class="fa fa-trash"></i>
                    </a>
                    |
                    <a class="btn btn-success btn-xs" href="<?= base_url('108/conteudo/index') . '?tema=' . $row->CD_TEMA ?>" data-toggle="frmModalInfo" title="Exibir Conteúdo">
                        <i class="fa fa-sitemap"></i>
                    </a>
                </td>
            </tr>
        <? } ?>
    </tbody>
</table>

<?php if ($gerar): ?>
    <button class="btn btn-warning pull-right" onclick="gerarRelatorio()">
        <i class="fa fa-file-pdf-o"></i> RELATÓRIO DE CONTEÚDO
    </button>
<?php endif; ?>

<script type="text/javascript">
    $(document).ready(function () {
        // Datatables
        $('#tbl').DataTable();
    });
</script>