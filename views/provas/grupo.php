<?php $this->load->view('layout/header'); ?>
<script>
    function excluir_grupo(id) {
        var url = "<?= SCL_RAIZ ?>provas/registar_infor?acao=<?= base64_encode('excluir') ?>&id=" + id;
        window.location.href = url;
    }
</script>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <a href="<?= SCL_RAIZ ?>provas/questoes/cadastro_grupo?token=<?=base64_encode("cadastrar")?>" class="btn btn-default"><i class="icon-plus"></i> Novo Grupo</a>
                </div>
                <table border="1" id="gridTabela" class="table table-striped table-bordered table-responsive table-hover">
                        <thead class="well">
                            <tr>
                                <th width="10%">ID</th>
                                <th width="45%">Descricao</th>
                                <th width="45%">Disciplina</th>
                                <th class="text-center">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            foreach ($listar as $row) { ?>
                                <tr style="font-size:12px">
                                    <td><?= $row['CD_GRUPO'] ?></td>
                                    <td><?= $row['DC_GRUPO'] ?></td>
                                    <td><?= $row['NM_DISCIPLINA'] ?></td>
                                    <th width="15%">
                                        <a class="btn btn-warning" href="<?= SCL_RAIZ ?>provas/questoes/cadastro_grupo?token=<?=base64_encode('editar')?>&id=<?=base64_encode($row['CD_GRUPO']) ?>" data-toggle="modal">
                                            <i class="fa fa-edit"></i> 
                                        </a>
<!--                                        <a href="#modal<?= $row['CD_GRUPO'] ?>" role="button" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash-o"></i></a>-->
                                        
                                        
                                        <a href="<?= SCL_RAIZ ?>provas/questoes/subgrupo?token=<?=base64_encode($row['CD_GRUPO']) ?>" class="btn btn-info">
                                            <i class="fa fa-sitemap"></i>  
                                        </a>
                                        
                                        
                                        <div class="modal fade" id="modal<?=$row['CD_GRUPO'] ?>" tabindex="-1" role="dialog" aria-labelledby="modalConfirmLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h3 class="modal-title thin" id="modalConfirmLabel">Excluir Registro</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form role="form">
                                                            <h4>Esta operação não terá mas retorno</h4>
                                                            <h4>Ao excluir o grupo todos os subgrupos associados serão excluidos também?</h4>
                                                            <h3 class="text-danger">Tem certeza que deseja exluir o regsitro?</h3>
                                                            <hr>
                                                            <h2><?= $row['DC_GRUPO'] ?></h2>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Cancelar</button>
                                                        <button class="btn btn-danger" onclick="excluir_atividade(<?= $row['CD_GRUPO'] ?>)">Excluir</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            <?php }  ?>
                                <tfoot>
                                <td colspan="4" class="text-right">
                                    Legenda: <i class="btn btn-warning fa fa-edit"></i> Editar Grupo | <i class="btn btn-info fa fa-sitemap"></i> Add Subgrupo
                                </td>
                                </tfoot>
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
        "bStateSave": true
    });
    
    $('[data-toggle="frmModal"]').on('click',
                function(e) {
                    $('#frmModal').remove();
                    e.preventDefault();
                    var $this = $(this)
                            , $remote = $this.data('remote') || $this.attr('href')
                            , $modal = $('<div class="modal fade" id="frmModal"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
                    $('body').append($modal);
                    $modal.modal({backdrop: 'static', keyboard: false});
                    $modal.load($remote);
                }
        );
</script>
<?php $this->load->view('layout/footer'); ?>