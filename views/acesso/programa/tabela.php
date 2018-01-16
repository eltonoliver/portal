<table border="1" id="gridTabela" class="table table-striped table-bordered table-responsive table-hover">
    <thead class="well">
        <tr>
            <th>Código</th>
            <th>Sistema</th>
            <th>Programa</th>
            <th style="width:15%"></th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($listar as $row) { ?>
            <tr style="font-size:12px">
                <td><?= $row['CD_PROGRAMA'] ?></td>
                <td><?= $row['DC_SISTEMA'] ?></td>
                <td><?= $row['NM_PROGRAMA'] ?></td>
                <td>
                    <a class="btn btn-xs btn-info" href="#" data-toggle="modal" data-target="#mdlEditar<?= $row['CD_PROGRAMA'] ?>">
                        <i class="fa fa-edit"> Editar</i>
                    </a>
                    &nbsp;
                    <a class="btn btn-xs btn-danger" href="#" data-toggle="modal" data-target="#mdlDeletar<?= $row['CD_PROGRAMA'] ?>">
                        <i class="fa fa-trash-o"> Deletar</i>
                    </a>

                    <!-- /.main-content -->
                    <div class="modal fade" id="mdlEditar<?= $row['CD_PROGRAMA'] ?>" data-remote="<?= SCL_RAIZ ?>acesso/programa/view?tipo=editar&codigo=<?= $row['CD_PROGRAMA'] ?>&modal=mdlEditar<?= $row['CD_PROGRAMA'] ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            </div><!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                    <!-- /.main-content -->
                    <div class="modal fade" id="mdlDeletar<?= $row['CD_PROGRAMA'] ?>" data-remote="<?= SCL_RAIZ ?>acesso/programa/view?tipo=deletar&codigo=<?= $row['CD_PROGRAMA'] ?>&modal=mdlDeletar<?= $row['CD_PROGRAMA'] ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            </div><!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                </td>
            </tr>
        <? } ?>
    </tbody>
</table>
<script>
    $('#gridTabela').dataTable({
        "sPaginationType": "full_numbers"
    });
</script>
<? exit(); ?>