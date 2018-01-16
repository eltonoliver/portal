<?php
    $registro = $registro[0];
?>
 
<div class="widget-main">
    <div class="modal-content">
        <div class="modal-header btn-warning">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-close"></i></button>
            <h4 class="modal-title" >Informações do Registro</h4>
        </div>
     
        <div class="modal-body">
            <div class="col-md-2">
                <label class="label-grey" for="turma"> N° Registro: </label>
            </div>
            <div class="col-md-3">
                <text for="turma"> <?php echo $registro['CD_REGISTRO'];?> </text>
            </div>
            <div class="col-md-2">
                <label class="label-grey" for="turma"> Periodo </label>
            </div>
            <div class="col-md-3">
                <text for="turma"> <?php echo $registro['PERIODO'];?> </text>
            </div>

            <br><br>

            <div class="col-md-2">
                <label class="label-grey" for="turma"> Data: </label>
            </div>
            <div class="col-md-3">
                <text for="turma"> <?php echo date('d/m/Y', strtotime($registro['DT_REGISTRO']));?> </text>
            </div>
            
            <br><br>

            <div class="col-md-2">
                <label class="label-grey" for="turma"> Aluno: </label>
            </div>
            <div class="col-md-9">
                <text for="turma"> <?php echo $registro['CD_ALUNO']." - ".$registro['NM_ALUNO'];?> </text>
            </div>

            <br><br>

            <div class="col-md-2">
                <label class="label-grey" for="descricao"> Descrição: </label>
            </div>
            <div class="col-md-12">
                <textarea rows="5" for="descricao" class="col-md-12" readonly="readonly"> <?php echo $registro['DS_REGISTRO'];?> </textarea>
            </div>

        </div>
    
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-close"></i> Fechar</button>     
        </div>
    </div>
</div>

<?php exit; ?>