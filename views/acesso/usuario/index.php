<? $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <button type="text" data-toggle="modal" data-target="#mdlnovouser" name="btnNusuario" class="btn btn-info"> <i class="fa fa-user"></i> Novo Usuario</button>
                        <button type="text"  name="btnCPermissao" class="btn btn-warning"> <i class="fa fa-users"></i> Copiar Permissão</button>
                        <button type="text"  name="btnnovousuario" class="btn btn-primary"> <i class="fa fa-list"></i>Relatório de Permissões</button>

                    </h3>
                </div>
                <div class="panel-body">
                    <table border="1" id="listar" class="table table-bordered table-responsive table-hover">
                        <thead class="well">
                            <tr>
                                <td>Código</td>
                                <td>Nome</td>
                                <td>Login</td>
                                <td>Função</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($listar as $row) { ?>
                                <tr class="<? if ($row['ATIVO'] == 0) echo 'danger'; ?>" style="font-size:12px">
                                    <td><?= $row['CD_USUARIO'] ?></td>
                                    <td><?= $row['NM_USUARIO'] ?></td>
                                    <td><?= $row['LOGIN'] ?></td>
                                    <td><?= $row['FUNCAO'] ?></td>
                                    <td>
                                        <? if ($row['ATIVO'] == 1) { ?> 
                                            <a class="" href="#"> <i class="fa fa-sitemap bigger-130"></i> </a> | 
                                            <a class="" href="#"> <i class="fa fa-group bigger-130"></i> </a> |
                                            <a class="" href="#"> <i class="fa fa-pencil bigger-130"></i> </a> |
                                            <a class="" href="#"> <i class="fa fa-lock bigger-130"></i> </a> |
                                            <a target="_bank" href="<?=SCL_RAIZ ?>acesso/impressao/usuario?token=<?=base64_encode($row['CD_USUARIO'])?>"> <i class="fa fa-list bigger-130"></i> </a> |
                                        <? } else { ?>
                                            <a data-toggle="modal" data-target="#mdldesbloquear<?= $row['CD_USUARIO'] ?>"> <i class="fa fa-unlock bigger-130"></i> </a>
                                        <? } ?>

                                    </td>
                                </tr>
                            <? } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" align="right"> |
                                    <i class="fa fa-sitemap bigger-130"></i> Permissões | 
                                    <i class="fa fa-group bigger-130"></i> Grupos | 
                                    <i class="fa fa-pencil bigger-130"></i> Editar |  
                                    <i class="fa fa-lock bigger-130"></i> Bloquear | 
                                    <i class="fa fa-unlock bigger-130"></i> Desbloquear |
                                    <i class="fa fa-list bigger-130"></i> Relatório do Usuário|
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.main-content -->
<div class="modal fade" id="mdlnovouser" data-backdrop="static" data-keyboard="false" data-remote="<?= SCL_RAIZ ?>acesso/usuario/modalNovoUsuario">
    <div class="modal-dialog">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<? foreach ($listar as $row) {
    if ($row['ATIVO'] == 1) {
        ?> 

    <? } else { ?>

        <div class="modal fade" id="mdldesbloquear<?= $row['CD_USUARIO'] ?>" data-backdrop="static" data-keyboard="false" data-remote="<?= SCL_RAIZ ?>acesso/usuario/desbloquear">
            <div class="modal-dialog">
                <div class="modal-content">
                </div>
            </div>
        </div>
    <? } ?>
<? } ?>
<script src="<?= SCL_JS ?>jquery.dataTables.min.js"></script> 
<script src="<?= SCL_JS ?>jquery.dataTables.bootstrap.js"></script> 
<script>
    $('#listar').dataTable({
        "sPaginationType": "full_numbers"
    });
</script>
<? $this->load->view('layout/footer'); ?>
