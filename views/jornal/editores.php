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
                    <a href="<?=SCL_RAIZ ?>jornal/editores/cadastro_editor" class="btn btn-info"><i class="icon-plus"></i> Novo Editor</a>
                </div>
                <div id="load"></div>
                        <table width="100%" border="0" cellspacing="0"  cellpadding="0" class="table table-striped table-bordered table-hover" id="data-table" aria-describedby="data-table_info">
                            <thead>
                                <tr>
                                    <th width="10%" class="center">AÇÕES</th>
                                    <th>NOME</th>
                                    <th>TIPO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php      
                                if (count(@listar) > 0) { 
                                    foreach ($listar as $row) { 
                                        ?>
                                        <tr>
                                            <td class="text-center">
<!--                                                <button class="btn btn-danger" id="bootbox-confirm" onclick="excluir(<?=$row->CD_MEMBRO?>);">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>-->
<!--                                                <a title="Excluir Artigo" class="btn btn-danger btn-xs" href="">
                                                    <i class="icon-trash bigger-110 icon-only"></i> 
                                                </a>-->
                                                <a data-toggle="modal" class="btn btn-xs btn-danger" href="#delete<?=$row->CD_MEMBRO?>"><i class="fa fa-trash-o"></i></a> 
                                            </td>
                                           
                                            <td><?= $row->EDITOR?></td>
                                            <td><?= $row->DC_MEMBRO ?> </td>
                                            
                                        </tr>
                                        <div class="modal modal-alert modal-danger fade in" id="delete<?=$row->CD_MEMBRO?>" tabindex="-1" role="dialog" style="display: none;">  
                                            <div class="modal-dialog" style="width:30%">
                                                <div class="modal-content">
                                                    <div class="modal-header btn-danger">
                                                        <i class="fa fa-times-circle"></i> Remoção de Editor
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Deseja realmente remover a permissão de escrever artigos/noticias do usuário?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancelar</button>
                                                        <a  class="btn btn-danger" onClick="excluir(<?=$row->CD_MEMBRO?>);"><i class="fa fa-check-circle"></i> Excluir</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    <?php }
                                        } else { ?>
                                    <tr>
                                        <td colspan="8" align="center"><strong>NÃO HÁ EDITORES CADASTRADO</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" align="center"></td>
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
        "sPaginationType": "full_numbers"
    });
</script>
<script>
function excluir(cd_membro){ 
    var url="<?= SCL_RAIZ ?>jornal/editores/excluir_editor/"+cd_membro;
    window.location.href=url;
}
</script>
<?php $this->load->view('layout/footer'); ?>