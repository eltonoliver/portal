

<form class="form-horizontal" id="form_inicio" name="form_inicio" method="post" action="<?= SCL_RAIZ ?>provas/questoes/cadastro_questao" >                           
    <div class="modal-content">
        <div class="modal-header btn-success">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-file"></i> Primeiros Passos</h4>
        </div>
        
        <div class="panel-body">   
            <div class="row">
                <div class="col-xs-12">
                    Selecione o Curso, Série e Disciplina da questão
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12">
                    
                    <div class="form-group">
                            <label class="col-sm-3 control-label text-info" for="disc">Prova</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="prova" id="prova" required >
                                    <option value="" class="text-muted">Selecione a Prova</option>
                                    <?php
                                    foreach ($provas as $p) { ?>
                                        <option value="<?= $p->CD_PROVA ?>">
                                            <?= $p->TITULO ?> - <?= formata_data($p->DT_PROVA,'br') ?> - <?= $p->NM_CURSO ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-info" for="disc">Curso</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="curso" id="curso" required >
                                    <option value="" class="text-muted">Selecione a disciplina</option>
                                    <?php
                                    foreach ($curso as $item) { ?>
                                        <option value="<?= $item['CD_CURSO'] ?>">
                                            <?= $item['NM_CURSO'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-info" for="disc">Série</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="serie" id="serie" required >
                                    <option value="" class="text-muted">Selecione uma Série</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-info" for="disc">Disciplina</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="disc" id="disc" required >
                                    <option value="" class="text-muted">Selecione a Disciplina</option>
                                    <?php foreach($disciplina as $r){ ?>
                                       <option value="<?=$r['CD_DISCIPLINA']?>"><?=$r['NM_DISCIPLINA']?></option>';	
                                    <?php } ?>
                                </select>
                            </div>
                        </div> 
                </div>
                
            </div>

        </div> 
        
        <div class="modal-footer">
            <button class="btn btn-danger pull-left" data-dismiss="modal" id="frmarquivo_btn" ><i class="fa fa-refresh"></i> Fechar </button>
            <input type="submit" value="Continuar" name="continuar" class="btn btn-primary">
        </div>
        
    </div>
</form>     
<script>
    $(document).ready(function() {
        $("select[name=curso]").change(function() {
            $("select[id=serie]").html('Aguardando série');
            $.post("<?= SCL_RAIZ ?>colegio/colegio/curso_serie", {
                curso: $(this).val()},
            function(valor) {
                $("select[id=serie]").html(valor);
            });
        });
        
        $("select[name=prova]").change(function() {
            $("select[id=disc]").html('Aguardando disciplina');
            $.post("<?= SCL_RAIZ ?>provas/questoes/disciplina", {
                prova: $(this).val()},
            function(valor) {
                $("select[id=disc]").html(valor);
            });
        });
        
        $("select[name=grupo]").change(function() { 
            $("select[id=assunto]").html('Aguardando disciplina');
            $.post("<?= SCL_RAIZ ?>provas/questoes/lista_subgrupo", {
                grupo: $(this).val()},
            function(valor) {
                $("select[id=assunto]").html(valor);
            });
        });
    });
</script>   
<?php exit(); ?>


