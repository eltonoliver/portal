<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $titulo ?></h3>
        <div class="panel-toolbar">
            <div class="btn-group"> <?= $mensagem_tt ?> Mensage<?php
                if ($mensagem_tt > 1)
                    echo 'ns';
                else
                    echo 'm';
                ?> 
            </div>
            <div class="btn-group" id="paginacao">
                <?= $paginacao; ?>                      
            </div>
            <div class="btn-group"><a href="<?= SCL_RAIZ ?>mensagem/escrever" class="btn btn-success">Escrever Mensagem</a></div>
        </div>
    </div>
    <div class="panel-body">
        <ul class="list-unstyled item-listing">
            <?php
            if (count($mensagem) > 0) {
            foreach ($mensagem as $item) {
            ?>
            <li>
                <div class="media">
                    <div class="pull-left">
                        <a href="#">                            
                            <img class="media-object" src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $item['DE'] ?>" width="50">                            
                        </a>
                    </div>
                    <div class="pull-right">
                        <div class="btn-group">
                            <?php if ($item['ANEXO'] != NULL) { ?>
                            <a href="#" class="btn btn-sm btn-default" data-toggle="tooltip" title="Baixar Arquivo"><i class="fa fa-fw fa-download"></i></a>
                            <?php } ?>                            
                            <a href="#excluir-<?= $item['ID'] ?>" class="btn btn-sm btn-default" data-toggle="modal" title="Deletar Mensagem"><i class="fa fa-fw fa-trash-o"></i></a>                            
                        </div>
                    </div>
                    <div class="media-body"><a href="#<?= $item['ID'] ?>" data-toggle="modal"><?= $item['SUBJECT'] ?></a>
                        <p class="small"><?= substr($item['CONTENT'], 0, 200) ?>...</p>
                        <p class="small text-muted"><?= date('d/m/Y h:m', strtotime($item['DATA'])); ?></p>
                    </div>

                    <div class="modal fade" tabindex="-1"  role="dialog" id="<?= $item['ID'] ?>" >
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header btn-danger">
                                    <h4 class="modal-title"><?= $item['SUBJECT'] ?></h4></div>
                                <div class="modal-body">
                                    <h4>De: <?= $item['DEST'] ?></h4>
                                    <p><?= nl2br($item['CONTENT']) ?></p>
                                    <?php if ($item['ANEXO'] != NULL) { ?>
                                    <a target="_blank" href="<?= base_url('application/upload/mensagem/' . $item['ANEXO']) ?>"  class="btn btn-sm btn-default" title="Baixar Arquivo">
                                        <i class="fa fa-fw fa-download"></i> Baixar Anexo
                                    </a>
                                    <?php } ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" role="dialog" id="excluir-<?= $item['ID'] ?>">
                        <div class="modal-dialog modal-xs">
                            <div class="modal-content">
                                <div class="modal-header btn-danger">
                                    <h4 class="modal-title">Excluir Mensagem</h4>
                                </div>

                                <div class="modal-body">
                                    <p>Você deseja excluir este registro?</p>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-default" data-dismiss="modal">Não</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="remover(<?= $item['ID']?>)">Sim</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php
            }
            }
            ?>
        </ul>
    </div>
</div>