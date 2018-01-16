<table id="tbl-conteudo" class="table table-hover table-striped table-bordered table-condensed">
    <thead>
        <tr>                            
            <th class="text-center">CONTEÚDO</th>
            <th class="text-center">AÇÕES</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($conteudos as $row): ?>
            <tr>
                <td class="text-justify">
                    <?= strip_tags($row->DC_CONTEUDO->read($row->DC_CONTEUDO->size())) ?>
                </td>                            

                <td class="text-center col-xs-2">
                    <a href="<?= base_url('108/conteudo/modalConteudo?tema=' . $tema->CD_TEMA . '&codigo=' . $row->CD_CONTEUDO . '&operacao=E') ?>" data-toggle="frmModalConteudo" class="btn btn-info btn-xs">
                        <i class="fa fa-edit"></i>
                    </a>
                    |
                    <a href="<?= base_url('108/conteudo/modalConteudo?tema=' . $tema->CD_TEMA . '&codigo=' . $row->CD_CONTEUDO . '&operacao=D') ?>" data-toggle="frmModalConteudo" class="btn btn-danger btn-xs">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>                            
            </tr>
        <?php endforeach; ?>

        <?php if (count($conteudos) == 0): ?>
            <tr>
                <td colspan="2">
                    <p class="text-center">Nenhum conteúdo foi cadastrado para o tema.</p>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>