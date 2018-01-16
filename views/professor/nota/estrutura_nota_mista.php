
<form action="<?= SCL_RAIZ ?>professor/nota/lancamento" method="post" id="frmnota" >
    
    <div class="modal-header btn-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" >Selecione a estrutura e o tipo de nota a ser lançada</h4>
    </div>


    <div class="modal-body">
        <div class="row">
            <div class="col-lg-4">
                Turma: <label> <?= trim($dados['CD_TURMA']) ?>+</label>
                <input name="curso" type="hidden" id="curso" value="<?= $dados['CD_CURSO'] ?>" />
                <input name="disciplina" type="hidden" id="disciplina" value="<?= $dados['CD_DISCIPLINA'] ?>" />
                <input name="txtdisciplina" type="hidden" id="txtdisciplina" value="<?= $dados['NM_DISCIPLINA'] ?>" />
                <input name="turma" type="hidden" id="turma" value="<?= trim($dados['CD_TURMA']) ?>+" />
            </div>
            <div class="col-lg-8">
                Disciplina: <label> <?= $dados['NM_DISCIPLINA'] ?></label>
            </div>
        </div>

        <div class="row">
            
            <div class="col-lg-12">
                <?php
                //print_r($dados);
                ?>
                <div class="col-lg-6">
                    <p class="text-left">Estrutura de nota</p>
                    <select id="tipo_estrutura" name="tipo_estrutura" class="form-control" required="">
                        <option value="">Selecione uma estrutura</option>
                        <?php
                    if (count($listar_tipo_nota_mista[0]) > 0) {
                        foreach ($listar_tipo_nota_mista as $l) {
                            ?>
                            <option value="<?= $l['CD_ESTRUTURA'] ?>" onblur=""><?= $l['DC_ESTRUTURA'] ?></option>
                        <?php
                        }
                    }
                    ?>
                    </select>
                </div>
                
                
                <div class="col-lg-6">
                    <p class="text-left">Tipo de nota</p>
                    <select id="numero_nota" name="numero_nota" class="form-control" required="">
                        <option value="">Selecione uma estrutura</option>
                        
                    </select>

                </div>


            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
        <?php if (count($listar_tipo_nota_mista[0]) != 0) { ?>
            <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Lançar Notas</button>
        <?php } ?>
    </div>

</form> 

<script>
$(document).ready(function() {    
    $("#tipo_estrutura").change(function() { 
        $("#numero_nota").html('Aguardando Estrutura Nota...');
        $.post("<?= SCL_RAIZ ?>professor/nota/tiponota", {
            tipo: $(this).val()},
        function(valor) { 
            $('select[id=numero_nota]').html(valor);
        });
    });
});
</script>
<?php exit; ?>