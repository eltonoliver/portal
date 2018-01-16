<?php $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-warning">
                <table width="100%" class="table table-bordered table-hover" id="gridview" aria-describedby="sample-table-2_info">
                     <thead>
                        <tr class="panel-heading">                            
                            <th class="sorting">Curso</th>
                            <th class="sorting">Série</th>
                            <th class="sorting">Turma</th>
                            <th class="sorting_disabled text-center" style="width:10%" aria-label="">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($turmas as $t) { ?>
                        <tr>
                            <td><?=$t['NM_CURSO']?></td>
                            <td><?=$t['NM_SERIE']?></td>
                            <td><?=$t['CD_TURMA']?></td>
                            <td class="text-center">
                                <a data-toggle="modal" class="btn btn-success" href="#view<?= $t['CD_TURMA'] ?>"><i class="fa fa-check-circle"></i> Acompanhamento Diário</a>
                                <!--modal acompanhamento-->
                                <div class="modal fade" id="view<?=$t['CD_TURMA'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                     data-remote="<?=SCL_RAIZ?>professor/infantil/acomp_diario?turma=<?=$t['CD_TURMA']?>"> 
                                    <div class="modal-dialog" style="width: 80%;">
                                        <div class="modal-content">
                                            <?= modal_load ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>  
                
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('layout/footer'); ?>