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
                    <a href="<?= SCL_RAIZ ?>jornal/categoria/cadastro_categoria?token=<?=base64_encode("cadastrar")?>" class="btn btn-default"><i class="icon-plus"></i> Nova Categoria</a>
                </div>
                <table border="1" id="gridTabela" class="table table-striped table-bordered table-responsive table-hover">
                        <thead class="well">
                            <tr>
                                <th width="4%"></th>
                                <th width="4%"></th>
                                <th width="60%">CATEGORIA</th>
                                <th width="60%">CADERNO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($listar as $row) { ?>
                                <tr style="font-size:12px">
                                    <td>
                                        <a class="btn btn-warning" href="<?= SCL_RAIZ ?>jornal/categoria/cadastro_categoria?token=<?=base64_encode('editar')?>&id=<?=urlencode(md5_encrypt($row->CD_CATEGORIA,123)) ?>" data-toggle="modal">
                                            <i class="fa fa-edit"></i> 
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" href="<?= SCL_RAIZ ?>jornal/categoria/cadastro_categoria?token=<?=base64_encode('excluir')?>&id=<?=urlencode(md5_encrypt($row->CD_CATEGORIA,123))?>" data-toggle="modal">
                                            <i class="fa fa-trash-o"></i> 
                                        </a>
                                    </td>
                                    <td><?= $row->DC_CATEGORIA ?></td>
                                    <td><?= $row->DESCRICAO ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>
<script>
     $('#gridTabela').dataTable({
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