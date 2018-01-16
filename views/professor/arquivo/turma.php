<?php $this->load->view('layout/header'); ?>
<script>
//excluir professor
function excluir_arquivo(id,arquivo) { 
    var url="<?=SCL_RAIZ?>professor/arquivo/excluir/"+id+"/"+arquivo;
    window.location.href=url;
}  
</script>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#cadastrar"><i class="icon-plus"></i> Novo Arquivo</a>
                </div>
                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview" name="gridview">
                    <thead>
                        <tr>
                            <th class="sorting">Descrição</th>
                            <th class="sorting">Tamanho</th>
                            <th class="sorting">Tipo</th>
                            <th class="sorting">Data</th>
                            <th class="sorting"> Turma</th>
                            <th class="sorting text-center" style="width: 13%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php //print_r($grade);
                        if (count($grade) > 0 & !isset($grade['retorno']) & !isset($grade['cursor'])) {
                            foreach ($grade as $row) {
                                ?>
                                <tr class="text-success">
                                    <td><?= $row['DESCRICAO'] ?></td>
                                    <td><?= $row['TAMANHO'] ?> Kb</td>
                                    <td><?php echo end(explode(".", $row['ANEXO']));  ?></td>                                  
                                    <td><?= date("d/m/Y", strtotime($row['DATA'])); ?></td>
                                    <td><?= $row['CD_TURMA'] ?></td>
                                    <td class="sorting text-center">

                                        <a data-toggle="modal" class="btn btn-xs btn-info" href="#view<?= $row['ID'] ?>"><i class="icon-paperclip"></i> anexo</a>
                                        <!--modal visualizar arquivo-->
                                        <div class="modal fade" id="view<?= $row['ID'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                             data-remote="<?= SCL_RAIZ ?>professor/arquivo/view?arquivo=<?=$row['ANEXO'] ?>"> 
                                            <div class="modal-dialog" style="width: 55%;">
                                                <div class="modal-content">
                                                    <?= modal_load ?>
                                                </div>
                                            </div>
                                        </div>

                                        <!--modal deletar arquivo-->
                                        <a data-toggle="modal" class="btn btn-xs btn-danger" href="#delete<?= $row['ID'] ?>"><i class="icon-trash"></i> Deletar</a> 
                                        <div class="modal modal-alert modal-danger fade in" id="delete<?= $row['ID'] ?>" tabindex="-1" role="dialog" style="display: none;">  
                                            <div class="modal-dialog" style="width:30%">
                                                <div class="modal-content">
                                                    <div class="modal-header btn-danger">
                                                        <i class="fa fa-times-circle"></i>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Deseja realmente excluir o arquivo?</p>
                                                        <p>A Turma <label><?php echo $row['CD_TURMA']?></label> não terá mas acesso ao arquivo.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                                                        <a  class="btn btn-danger" onClick="excluir_arquivo(<?=$row['ID']?>,'<?=$row['ANEXO']?>');"><i class="fa fa-check-circle"></i> Excluir</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>        
                                    </td>
                                </tr>
                                <?php
                            }
                        } ?>
                    </tbody>
                </table>
                <!--modal enviar arquivo-->
                <div class="modal fade" id="cadastrar" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                     data-remote="<?= SCL_RAIZ ?>professor/arquivo/cadastrar"> 
                    <div class="modal-dialog" style="width: 40%;">
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
    $('#gridview').dataTable({
        "sPaginationType": "full_numbers"
    });
</script>
<?php $this->load->view('layout/footer'); ?>