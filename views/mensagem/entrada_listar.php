<input type="hidden" name="tipo" id="tipo" value="<?= $tipo ?>">

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?= $titulo ?></h3>
        <div class="panel-toolbar">
            <div class="btn-group"> <?= $mensagem_tt ?> Mensage<?php
                if ($mensagem_tt > 1)
                    echo 'ns';
                else
                    echo 'm';
                ?> </div>
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
                    <li class="active">
                        <div class="media">
                            <div class="pull-left thumbnail avatar">
                                <a href="#<?= $item['ID'] ?>" data-toggle="modal">                            
                                    <img class="media-object" src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $item['DE'] ?>" width="50">                            
                                </a>
                            </div>
                            <div class="media-body"><a href="#<?= $item['ID'] ?>" data-toggle="modal" onclick="marcar_lida(<?= $item['ID'] ?>)"><?= $item['SUBJECT'] ?></a>
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
                                            <? if ($item['ANEXO'] != NULL) { ?>
                                            <a target="_blank" href="<?= base_url('application/upload/mensagem/' . $item['ANEXO']) ?>" class="btn btn-sm btn-default" title="Baixar Arquivo">
                                                <i class="fa fa-fw fa-download"></i> Baixar Anexo
                                            </a>
                                            <? } ?>
                                            <hr />
                                            <div class="well well-sm">
                                                <form action="<?= SCL_RAIZ ?>mensagem/enviar" method="post" name="frmresposta" enctype="multipart/form-data">
                                                    <input name="sclassunto" type="hidden" value="RES: <?= $item['SUBJECT'] ?>" />
                                                    <input name="destino[]" type="hidden" value="<?= $item['DE'] ?>" />
                                                    <input name="idmsg" type="hidden" value="<?= $item['IDMSG'] ?>">
                                                    <h4 class="modal-title">Resposta Rápida</h4>
                                                    <br />
                                                    <label>Mensagem</label>
                                                    <textarea name="sclmsg" class="form-control" ></textarea> 
                                                    <div class="form-group">
                                                        <label>Anexar Arquivo</label>
                                                        <div class="">
                                                            <input type="file" class="form-control" id="arquivo" name="arquivo" />
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success" ><i class="fa fa-fw fa-mail-forward"></i> Responder</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
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
