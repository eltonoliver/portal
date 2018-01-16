<?php if (!empty($mensagem)): ?>
    <div class="modal-header alert-dismissable btn-warning">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Importante</h4>
    </div>   

    <div class="modal-body">        
        <?= $mensagem ?>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">
            <i class="fa fa-check"></i> Ok
        </button>
    </div>    
<?php else: ?>
    <div class="modal-header btn-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" >Conteúdo Ministrado / Tarefa para casa</h4>
    </div>

    <form action="<?= SCL_RAIZ ?>professor/diario/editar_conteudo" method="post" enctype="multipart/form-data" id="frmfrequencia" onsubmit="validar(event)">
        <div class="modal-body">             
            <input name="plano" type="hidden" id="plano" value="<?= $this->input->get_post('plano') ?>" />
            <input name="turma" type="hidden" id="turma" value="<?= $this->input->get_post('turma') ?>" />
            <input name="cl_aula" type="hidden" id="cl_aula" value="<?= $this->input->get_post('aula') ?>" />
            <input name="subturma" type="hidden" id="subturma" value="<?= $this->input->get_post('subturma') ?>" />
            <input name="data-pendencia" type="hidden" value="<?= $this->input->get_post("data-pendencia") ?>">
            <input name="opcao" type="hidden" value="<?= $this->input->get_post("opcao") ?>">

            <div class="row">
                <div class="col-lg-7">
                    <p class="text-primary">Conteúdo Ministrado</p>                                        

                    <?php if (!isset($assunto['retorno']) & !isset($assunto['cursor'])) : ?>
                        <div class="panel panel-default" style="overflow-y: auto; max-height: 350px;">
                            <div class="panel-body" style="padding: 5px">                            
                                <?php foreach ($assunto as $s): ?>
                                    <div style="white-space: nowrap">
                                        <input type="checkbox" name="assunto[]" value="<?= $s['ID_LIVRO_ASSUNTO'] ?>" <?= $s['CD_CL_AULA'] != "" ? "checked disabled" : "" ?>  />
                                        <span <?= $s['CD_CL_AULA'] != "" ? "class='text-danger'" : "" ?>><?= $s['ID_ESTRUTURA'] ?><?= $s['DC_ASSUNTO'] ?></span>                            
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>                            
                        <p>Não há tema para esta disciplina</p>
                    <?php endif; ?>                        
                </div>

                <div class="col-lg-5">
                    <p class="text-primary">Tarefa para Casa.</p>
                    <textarea spellcheck="true" rows="5" cols="40" name="tarefa"><?= $conteudo_lancado[0]['TAREFA_CASA'] ?></textarea>
                    <p class="text-primary">Outros Conteudos.</p>
                    <textarea <?= $requer == "N" ? "" : "required='true'" ?> spellcheck="true" rows="5" cols="40" name="conteudo"><?= $conteudo_lancado[0]['CONTEUDO'] ?></textarea>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
            <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Confirmar</button>
        </div>
    </form>
<?php endif; ?>

<?php exit; ?>