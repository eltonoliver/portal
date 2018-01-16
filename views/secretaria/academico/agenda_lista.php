<div style="display: table; width: 100%">
    <?php $count = 0; ?>

    <?php foreach ($conteudo as $r): ?>
    
        <?php if ($r['NM_DISCIPLINA'] != ''): ?>
            <?php $count++; ?>
    
            <?php if ($count === 1): ?>
                <div class="row" style="display: table-row">
                <?php endif; ?>

                <div class="col-sm-4" style="padding:10px; border-right:1px solid #CCC; border-bottom:1px solid #CCC; display: table-cell; float: none">
                    <div class="media">
                        <div class="pull-left"><img src="<?= SCL_IMG ?>user.png" class="media-object" /></div>
                        <div class="media-body">
                            <div class="media-heading">
                                <h4 class="title">
                                    <a><?= $r['NM_DISCIPLINA'] ?></a>
                                    <br/><small><?= $r['NM_PROFESSOR'] ?></small>
                                    <br/><a><?= date('d/m/Y', strtotime($r['DT_AULA'])) ?></a>
                                </h4>
                                <a class="btn btn-info" href="javascript:void(0);" data-toggle="modal" data-target="#<?= $r['CD_DISCIPLINA'] . date('dmY', strtotime($r['DT_AULA'])) ?>"> <i class="fa fa-search"></i> Visualizar</a>
                            </div>
                        </div>
                    </div>  
                </div>

                <!-- MODAL DISCIPLINAS -->
                <div style="display: table-cell">
                    <div class="modal fade" id="<?= $r['CD_DISCIPLINA'] . date('dmY', strtotime($r['DT_AULA'])) ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header btn-info">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><i class="fa fa-calendar"></i> <?= date('d/m/Y', strtotime($r['DT_AULA'])) ?> - <?= $r['NM_DISCIPLINA'] ?> </h4>
                                </div>
                                <div class="modal-body"> 
                                    <i class="fa fa-user"></i> Disciplina: <strong><?= $r['NM_DISCIPLINA'] ?></strong><br/>
                                    <i class="fa fa-user"></i> Professor: <strong><?= $r['NM_PROFESSOR'] ?></strong><br/>
                                    <i class="fa fa-calendar"></i> Data da Aula: <strong><?= date('d/m/Y', strtotime($r['DT_AULA'])) ?></strong><br/>
                                    <i class="fa fa-list"></i> Conteúdo Ministrado: <strong><?= $r['CONTEUDO'] ?></strong><br/>
                                    <? if(!empty($r['TAREFA_CASA'])){?><i class="fa fa-home"></i> Tarefa para Casa: <strong><?= $r['TAREFA_CASA'] ?></strong><br/><? } ?>
                                    <? if(!empty($r['ANEXO'])){?><i class="fa fa-download"></i> Anexo: <strong><?= $r['DESCRICAO'] ?> - <a href="<?= SCL_RAIZ . 'application/upload/professor/' . $r['CD_PROFESSOR'] . '/' . $r['ANEXO'] ?>" target="_blank" class="btn btn-xs btn-info"> baixar agora </a></strong><br/><? } ?>
                                </div>
                                <div class="modal-footer clearfix">
                                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                                </div>
                            </div>
                            <!-- /.modal-content --> 
                        </div>
                        <!-- /.modal-dialog --> 
                    </div>
                    <!-- /.modal -->
                </div>

                <?php if ($count === 3): ?>
                </div>
                <?php $count = 0; ?>

            <?php endif; ?>

        <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php exit(); ?>