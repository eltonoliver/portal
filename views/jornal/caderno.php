<?php $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <a href="<?= SCL_RAIZ ?>jornal/caderno/cadastro_caderno?token=<?=base64_encode("cadastrar")?>" class="btn btn-default">
                        <i class="icon-plus"></i> Novo Caderno
                    </a>
                </div>
                <table width="100%" border="0" cellspacing="0"  cellpadding="0" class="table table-striped table-bordered table-hover" id="data-table" aria-describedby="data-table_info">
                    <thead>
                        <tr>
                            <th width="4%"></th>
                            <th width="4%"></th>
                            <th width="25%">CÓDIGO</th>
                            <th width="60%">DESCRIÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($listar as $row) { 
                                ?>
                                <tr>
                                    <td>
                                        <a class="btn btn-warning" href="<?= SCL_RAIZ ?>jornal/caderno/cadastro_caderno?token=<?=base64_encode('editar')?>&id=<?=urlencode(md5_encrypt($row->CD_CADERNO,123))?>" data-toggle="modal">
                                            <i class="fa fa-edit"></i> 
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" href="<?= SCL_RAIZ ?>jornal/caderno/cadastro_caderno?token=<?=base64_encode('excluir')?>&id=<?=urlencode(md5_encrypt($row->CD_CADERNO,123))?>" data-toggle="modal">
                                            <i class="fa fa-trash-o"></i> 
                                        </a>
                                    </td>
                                    <td><?=$row->CD_CADERNO ?></td>
                                    <td><?=$row->DESCRICAO ?></td>

                                </tr>
                            <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#data-table').dataTable({
        "sPaginationType": "full_numbers",
        "oLanguage": {
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "sLengthMenu": "Mostrar _MENU_ por página  ",
                "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
                "sInfoEmpty": "Registro não encontrado",
                "sZeroRecords": "Não há registro",
                
            },
        "aaSorting": [[ 0, "desc" ]], 
    });
</script>
<?php $this->load->view('layout/footer'); ?>