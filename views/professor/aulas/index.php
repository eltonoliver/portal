<?php $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-primary">
                <?php 
                    echo get_msg('msgok'); 
                    echo get_msg('msgerro'); 
                ?>
                <div class="panel-heading">
                    <h3 class="panel-title">Lista de disciplinas</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover small">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Disciplina</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  foreach ($disciplina as $d) { ?>
                            <tr>
                                <td><?=$d['CD_DISCIPLINA'] ?></td>
                                <td><?=$d['NM_DISCIPLINA'] ?></td>
                                <td class="text-center">
                                    <div class="btn-group text-left">
                                        <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-demo-space btn-xs"> 
                                            Cadastros <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?=SCL_RAIZ?>professor/aulas/cadastrar_conteudo/<?=$d['CD_DISCIPLINA'] ?>">Cadastrar Conteúdo</a></li>
                                            <li><a href="<?=SCL_RAIZ?>professor/aulas/cadastrar_aula/<?=$d['CD_DISCIPLINA'] ?>">Cadastrar slides</a></li>
                                        </ul>
                                    </div>
                                    
                                    <div class="btn-group text-left">
                                        <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-demo-space btn-xs"> 
                                            Visulaizar <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a data-toggle="modal" href="<?=SCL_RAIZ?>professor/aulas/lista_conteudo/<?=$d['CD_DISCIPLINA']?>">Lista de Conteúdos</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="lista_slide<?=$d['CD_DISCIPLINA']?>" data-backdrop="static" data-keyboard="false" data-remote="<?=SCL_RAIZ?>professor/aulas/lista_slide/<?=$d['CD_DISCIPLINA']?>">
                                <div class="modal-dialog" style="width:50%">
                                    <div class="modal-content"><?=modal_load?>  
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
          
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('layout/footer'); ?>
