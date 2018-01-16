<!--<script type="text/javascript" src="<?//= SCL_JS ?>script.js"></script>  --> 

<?php
    $registro = $registro[0];
    if($registro['CD_REGISTRO']!=''){
        $data = date('d/m/Y', strtotime($registro['DT_REGISTRO']));
        $periodo = $registro['PERIODO'];
        $dis = 'disabled="disabled"';
    }else{
        $dis = '';
        $data = date('d/m/Y');
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
    }
?>

<form action="<?= SCL_RAIZ ?>professor/registro_diario/do_salvar" method="post" id="frmRegistro" >
    <input name="cd_registro" type="hidden" value="<?=$registro['CD_REGISTRO']?>" />
    
    <div class="modal-header btn-warning">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" ><?=(($registro['CD_REGISTRO']=="")? "Novo": "Editar")?> Registro</h4>
    </div>
    
    <div class="modal-body">
        <div class="row">
            <div class="col-md-2">
                <label class="label-grey" for="turma"> Periodo </label>
            </div>
            <div class="col-md-2">
                <input type="text" id="periodo" name="periodo" placeholder="AAAA/S" maxlength="6" size="6" value="<?=$periodo ?>" readonly=""/>
            </div>
       
            <div class="col-md-1">
                <label for="turma"> Data: </label>
            </div>
            <div class="col-md-3">
                <input type="text" id="data" name="data" value="<?=$data?>" size="10" readonly=""/>
            </div>
        </div>
        <br>
        
        <div class="row">
            <div class="col-md-2">
                <label class="label-grey" for="turma"> Turma</label>
            </div>
            <div class="col-md-5">
                <select <?=$dis?> id="turma_model" name="turma" class="form-control">
                    <option value="">Selecione uma turma</option>
                    <?php

                    if ($registro['CD_TURMA']!=""){
                        echo "<option value=".$registro['CD_TURMA']." selected>".$registro['CD_TURMA']."</option>";
                    }else{

                        foreach ($turmas as $t) {
                            echo '<option value="'.$t['CD_TURMA'].'">' . $t['CD_TURMA'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <br>
       
        <div class="row">    
            <div class="col-md-2">
                <label class="label-grey" for="aluno"> Aluno: </label>
            </div>
            <div class="col-md-9">
                <select <?=$dis?> id="aluno_model" name="aluno[]" class="form-control input-sm" multiple="" required="">
                    <?php
                    if ($registro['CD_ALUNO']!=""){
                        echo "<option value=".$registro['CD_ALUNO']." selected>".$registro['CD_ALUNO']." - ".$registro['NM_ALUNO']."</option>";
                    }
                    ?>
                </select>

            </div>
        </div>    
        <br>
        
        <div class="row">
            <div class="col-md-2 form-group">
                <label class="label-grey" for="descricao"> Descrição: </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <textarea id="descricao" name="descricao" rows="5" for="descricao" class="col-md-12" required=""><?php echo $registro['DS_REGISTRO'];?></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Salvar</button>
    </div>
</form>

 <script src="<?=base_url('assets/js/')?>/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="<?=base_url('assets/js/bootstrap-multiselect.js')?>"></script>
    <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-multiselect.css')?>" type="text/css"/>
    

<script type="text/javascript">
    $(function(){
    $("select[id=aluno_model]").multiselect();
            $('.input-daterange').datepicker({
                 endDate: '+0d',
                autoclose: true
            });
    });
    
    $("#turma_model").change(function() {
        $("select[id=aluno_model]").multiselect('destroy');
        $("select[id=aluno_model]").html('Carregando');
        $.post("<?= base_url('comum/combobox/listaAlunosTurma') ?>", {
             turma: $("#turma_model").val()
        },
        function(data) {
            $("select[id=aluno_model]").html(data);
            $('#aluno_model').multiselect({
                enableClickableOptGroups: true,
                enableCollapsibleOptGroups: true,
                enableFiltering: true,
                includeSelectAllOption: true,
                nonSelectedText: 'Selecione o(os) aluno(os)'
               
            });
            // evitar bug do multiselect em modals
             // em que ao clicar não exibe lista            
            $('.dropdown-toggle').dropdown();
        });
    });
    
</script>

<?php exit; ?>