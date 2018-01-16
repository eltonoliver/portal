<?php $this->load->view('layout/header'); ?>


<script>
    function excluir(livro) {
        var url = "<?= SCL_RAIZ ?>professor/livro/excluir_livro?acao=excluir&livro=" + livro;
        window.location.href = url;
    }
</script>


<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-warning">
                <?php echo get_msg('msg')?>
                <div class="panel-heading">
                    <a href="#" data-toggle="modal" class="btn btn-info" data-target="#cadastrar"> Novo Livro &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus"></i></a>
                </div>

                <div class="panel-body">

                    <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview" >
                        <thead>
                            <tr>
                                <th class="sorting">ID</th>
                                <th class="sorting">Nome</th>
                                <th class="sorting">Curso</th>
                                <th class="sorting">Serie</th>
                                <th class="sorting">Disciplina</th>
                                <th class="sorting text-center" style="width: 13%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($lista as $row) {
                                ?>
                                <tr class="text-success">
                                    <td><?= $row['ID_LIVRO'] ?></td>
                                    <td><?= $row['LIVRO_TITULO'] ?></td>
                                    <td><?= $row['NM_CURSO_RED'] ?></td>
                                    <td><?= $row['ORDEM_SERIE'] ?>° Série</td>
                                    <td><?= $row['NM_DISCIPLINA'] ?></td>
                                    <td class="sorting text-center">
                                        <a class="btn btn-xs btn-info" href="<?= SCL_RAIZ ?>professor/livro/conteudo?cd=<?= base64_encode($row['ID_LIVRO']) ?>"><i class="fa fa-arrow-circle-right"></i></a> 

                                        <a href="#" data-toggle="modal" class="btn btn-xs btn-warning" data-target="#editar<?= $row['ID_LIVRO'] ?>"> <i class="fa fa-edit"></i></a>
                                        <div class="modal fade" id="editar<?= $row['ID_LIVRO'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                             data-remote="<?= SCL_RAIZ ?>professor/livro/cadastrar_livro?acao=editar&id_livro=<?= $row['ID_LIVRO'] ?>"> 
                                            <div class="modal-dialog" style="width: 80%;">
                                                <div class="modal-content">
                                                    <?= modal_load ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <?php if ($this->session->userdata('SCL_SSS_USU_CODIGO') == 5502) { ?>
                                            <a class="btn btn-xs btn-danger" href="#" data-toggle="modal" data-target="#excluir<?= $row['ID_LIVRO'] ?>"><i class="fa fa-trash-o"></i></a>
                                        <?php } ?>

                                        <div class="modal inmodal" id="excluir<?= $row['ID_LIVRO'] ?>" tabindex="-1" role="dialog"  aria-hidden="true"> 
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <i class="fa fa-remove modal-icon"></i>
                                                        <h4 class="modal-title">Excluir Registro</h4>
                                                        <small>Esse preocesso não poderá ser desfeito</small>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Tem certeza que deseja excluir o registro?</strong></p>
                                                        <h5><?= $row['LIVRO_TITULO'] ?></h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                                                        <button type="button" class="btn btn-danger" onClick="excluir(<?= $row['ID_LIVRO'] ?>)">Excluir</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!--modal enviar arquivo-->
                <div class="modal fade" id="cadastrar" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                     data-remote="<?= SCL_RAIZ ?>professor/livro/cadastrar_livro?acao=novo"> 
                    <div class="modal-dialog" style="width: 80%;">
                        <div class="modal-content">
                            <?= modal_load ?>
                        </div>
                    </div>
                </div>


                <!--modal enviar arquivo-->


            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#gridview').dataTable({
        "stateSave" : true,
    //    "sPaginationType": "full_numbers",
        "iDisplayLength": 100,
        
    });
});
</script>
<? $this->load->view('layout/footer'); ?>