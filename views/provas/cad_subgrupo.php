<?php $this->load->view('layout/header'); ?>
<!--
<div class="modal-dialog" style="width: 80%">
    <div class="modal-content">
        <div class="modal-header btn-success">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-credit-card"></i> Cadastrar Subgrupo para o Grupo: <strong><?=$dados['DC_GRUPO']?></strong></h4>
        </div>
        
        <div class="modal-body">
            <form action="<?=SCL_RAIZ?>provas/questoes/registar_subgrupo" method="post"  name="formCategoria" id="formCategoria">
                <input type="hidden" name="acao" value="<?=  base64_encode($acao)?>" />
                <input type="hidden" name="autor" value="<?=$dados['CD_USUARIO']?>" />
                <input type="hidden" name="grupo" value="<?=$dados['CD_GRUPO']?>" />
                <?php                
                echo get_msg('msgok');
                echo get_msg('msgerro');
                ?>
                <div class="col-xs-12">
                    <label><strong>DESCRIÇÃO DO SUBGRUPO: </strong></label>
                    <br>
                    <input class="form-control" type="text" value="" id="subgrupo" name="subgrupo" required="">
                    <br>
                    <div class="modal-footer">
                        <button type="submit" id="btn_frmMensagem" class="btn btn-<?=$bt_cor ?>"> <?=$bt_acao ?> Registro <i class="fa fa-save"></i></button>
                    </div>
                </div>
            </form>
        </div>
            <div class="panel-body">   
                <h4 class="text-center">Subgrupo Cadastrados</h4>
                <table border="1" id="gridTabela" class="table table-striped table-bordered table-responsive table-hover">
                        <thead class="well">
                            <tr>
                                <th width="10%">ID</th>
                                <th width="80%">Descricao</th>
                                <th class="text-center">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            foreach ($listarsub as $row) { ?>
                                <tr style="font-size:12px">
                                    <td><?= $row['CD_SUBGRUPO'] ?></td>
                                    <td><?= $row['DC_SUBGRUPO'] ?></td>
                                    <th width="15%">
                                        <a class="btn btn-danger" href="<?= SCL_RAIZ ?>jornal/categoria/cadastro_categoria?token=<?=base64_encode('excluir')?>&id=<?=urlencode(md5_encrypt($row->CD_CATEGORIA,123))?>" data-toggle="modal">
                                            <i class="fa fa-sitemap"></i> 
                                        </a>
                                       
                                    </th>
                                </tr>
                            <?php }  ?>
                        </tbody>
                    </table>

            </div> 
            <div class="modal-footer">
                <button class="btn btn-danger pull-left" data-dismiss="modal" id="frmarquivo_btn" ><i class="fa fa-refresh"></i> Fechar </button>
            </div>
    </div>
</div>-->



<div id="content">
    <div class="row">
        <div class="col-xs-12">

            <div class="panel panel-<?= $bt_cor ?>">
                
                <div class="panel-heading">
                    <h4><?= $subtitulo ?></h4>
                   
                </div>
                <div class="panel-body">
                    <?php
                    echo get_msg('msgok');
                    echo get_msg('msgerro');
                    ?>
                    
                    <form action="<?=SCL_RAIZ?>provas/questoes/registar_subgrupo" method="post"  name="formCategoria" id="formCategoria" class="form-horizontal">
                        <input type="hidden" name="acao" value="<?=  base64_encode($acao)?>" />
                        <input type="hidden" name="grupo" value="<?=$dados[0]->CD_GRUPO?>" />
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="disc">Subgrupo</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" value="" id="subgrupo" name="subgrupo" required="">
                            </div>
                        </div>
                       
                        
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" id="btn_frmMensagem" class="btn btn-<?=$bt_cor ?>"> <?=$bt_acao ?> Registro <i class="fa fa-save"></i></button>
                                <a href="<?= SCL_RAIZ ?>provas/questoes/lista_grupo/" class="btn btn-danger">Cancelar</a>
                            </div>
                        </div>
                        
                    </form>
                </div>
                    
            </div>                    
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-12">
            <h4 class="text-center">Subgrupo Cadastrados</h4>
                <table border="1" id="gridTabela" class="table table-striped table-bordered table-responsive table-hover">
                        <thead class="well">
                            <tr>
                                <th width="10%">ID</th>
                                <th width="80%">Descricao</th>
                                <th class="text-center">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            
                            foreach ($listarsub as $row) { ?>
                                <tr style="font-size:12px">
                                    <td><?= $row['CD_SUBGRUPO'] ?></td>
                                    <td><?= $row['DC_SUBGRUPO'] ?></td>
                                    <th width="15%">
<!--                                        <a class="btn btn-danger" href="<?= SCL_RAIZ ?>jornal/categoria/cadastro_categoria?token=<?=base64_encode('excluir')?>&id=<?=urlencode(md5_encrypt($row->CD_CATEGORIA,123))?>" data-toggle="modal">
                                            <i class="fa fa-edit"></i> 
                                        </a>-->
                                       
                                    </th>
                                </tr>
                            <?php }  ?>
                        </tbody>
                    </table>
            
        </div>
    </div>
</div>

<?php $this->load->view('layout/footer'); ?>


