<div class="modal-header btn-warning">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 class="modal-title">CONTEÚDO MINISTRADO / TAREFA PARA CASA</h3>
</div>

<form action="<?= site_url("professor/diario/salvar_conteudo") ?>" method="post">
    <div class="modal-body">             
        <input name="aula" type="hidden" value="<?= $aula['CD_CL_AULA'] ?>" >        
        <input name="data" type="hidden" value="<?= $dataPendencia ?>">

        <div class="row">
            <div class="col-lg-7">
                <p class="text-primary">Conteúdo Ministrado</p>                                        

                <?php if (count($assuntos) == 0) : ?>
                    <p>Não há tema para esta disciplina</p>
                <?php else: ?>                        
                    <div class="panel panel-default" style="overflow-y: auto; max-height: 350px;">  
                        <div class="panel-body text-left" style="padding: 5px">                            
                            <?php foreach ($assuntos as $row): ?>
                                <div style="white-space: nowrap">
                                    <input type="checkbox" name="assunto[]" value="<?= $row['ID_LIVRO_ASSUNTO'] ?>" <?= $row['CD_CL_AULA'] != "" ? "checked disabled" : "" ?>  />
                                    <span <?= $row['CD_CL_AULA'] !== null ? "class='text-danger'" : "" ?>><?= $row['ID_ESTRUTURA'] ?><?= $row['DC_ASSUNTO'] ?></span>                            
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-5">
                <p class="text-primary">Tarefa para Casa</p>
                <textarea spellcheck="true" rows="5" cols="40" name="tarefa"><?= $aula['TAREFA_CASA'] ?></textarea>

                <p class="text-primary">Outros Conteudos</p>
                <textarea spellcheck="true" rows="5" cols="40" name="conteudo"><?= $aula['CONTEUDO'] ?></textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Confirmar</button>
    </div>
</form>

<?php exit; ?>