<table border="1" id="gridTabela" class="table table-striped table-bordered table-responsive table-hover">
    <thead class="well">
        <tr>
            <th>Código</th>
            <th>Telefone</th>
            <th>Destinatário</th>
            <th>Aluno</th>
            <th>Mensagem</th>
            <th>Data</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listar as $row) { ?>
            <tr style="font-size:12px" id="<?= $row['CD_AUTENTICACAO'] ?>">
                <td><?= $row['CD_SMS'] ?></td>
                <td><?= $row['NR_TELEFONE'] ?></td>
                <td><?= $row['DESTINATARIO'] ?></td>
                <td><?= $row['NM_ALUNO'] ?></td>
                <td><?= $row['DS_MENSAGEM'] ?></td>
                <td><?= date('d/m/Y', strtotime($row['DT_ENVIO'])) ?></td>
                <td class="status">
                    <div class="text-center loading">
                        <i class="fa fa-refresh fa-spin fa-2x"></i>
                        <span class="sr-only">Loading...</span>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
if ($ajax) {
    exit();
}
?>