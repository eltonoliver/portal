<?php $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <a href="<?= SCL_RAIZ ?>colegio/noticia/frmnoticia?acao=I" class="btn btn-info"><i class="fa fa-plus-square"></i> Nova Noticia</a>
                </div>
                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview" name="gridview">
                    <thead>
                        <tr>
                            <th width="4%" colspan="2"></th>
                            <th width="25%">Autor</th>
                            <th width="60%">Titulo</th>
                            <th width="60%">Início</th>
                            <th width="60%">Fim</th>
                            <th width="15%">Status</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                        if (count($listar) > 0) {
                            foreach ($listar as $row) {
                                ?>
                                <tr>
                                    <td>
                                        <a class="btn btn-warning btn-xs" href="<?= SCL_RAIZ ?>colegio/noticia/frmnoticia?acao=U&codigo=<?= $row['ID_NOTICIA']; ?>" data-toggle="modal">
                                            <i class="fa fa-edit"></i> 
                                        </a>
                                    </td>
                                    <td> 
                                        <a class="btn btn-danger btn-xs" href="<?= SCL_RAIZ ?>colegio/noticia/frmnoticia?acao=E&codigo=<?= $row['ID_NOTICIA']; ?>" data-toggle="modal">
                                            <i class="fa fa-trash-o"></i> 
                                        </a>
                                    </td>
                                    <td><?= $row['AUTOR'] ?></td>
                                    <td>
                                        <a href="<?= SCL_UPLOAD ?>/noticia/<?= $row['CHAMADA']; ?>" target="_blank">
                                            <?= $row['TITULO']; ?>
                                        </a>
                                    </td>
                                    <td><?=$row['DT_INICIO']; ?></td>
                                    <td><?=$row['DT_FIM']; ?></td>
                                    <td>
                                        <?php if ($row['STATUS'] == 0)
                                            echo "<span class='label label-danger'>Não Publicado</span>";
                                        if ($row['STATUS'] == 1)
                                            echo "<span class='label label-success'>Publicado</span>";
                                        ?> 
                                    </td>
                                </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#gridview').dataTable({
        "sPaginationType": "full_numbers"
    });
</script>
<?php $this->load->view('layout/footer'); ?>