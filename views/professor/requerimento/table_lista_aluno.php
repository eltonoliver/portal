<?php  if(count($alunos[0]) > 0) { ?>
<script type="text/javascript">
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mvalor(v){
    v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
    v=v.replace(/(\d)(\d{1})$/,"$1.$2");//coloca a virgula antes dos 2 últimos dígitos
    return v;
}
</script>

<script type="text/javascript">
function ValidaValor(obj, valor_permitido) {
if (parseFloat(obj.value) > valor_permitido) {
  alert("A Nota máxima e 10");
  obj.value = valor_permitido;
  return false;
}
}
</script>

<script type="text/javascript">
function marcardesmarcar(){
  $('.marcar').each(
         function(){
           if ($(this).prop( "disabled")){
                $(this).prop("checked", false);
         //       $(this).prop("disabled", false);
                document.getElementById("toda_turma").value = 0;
            }else{ 
                $(this).prop("checked", true);
      //         $(this).prop("disabled", true);
                document.getElementById("toda_turma").value = 1;
            }           
         }
    );
}
</script>  

<script language="javascript">
function validaForm(){
	var algumChecado = false;   
        var inputs = document.limpar_nota.getElementsByTagName('input')
        for(i=0;i<inputs.length;i++){
        	if(inputs[i].type == 'checkbox' && inputs[i].checked == true){
			algumChecado = true;
			return;
 		}
   	   }
        
	if(!algumChecado){
	        alert("Selecione pelo menos um aluno.")
                return false;
	}
	return true;        	
}
</script>
<?php #print_r($alunos);?>
<form method="post" enctype="multipart/form-data" id="limpar_nota" name="limpar_nota" action="<?=SCL_RAIZ?>professor/requerimento/lancar" onSubmit="return validaForm()" >
    <input type="hidden" name="TIPO" id="TIPO" value="<?=$tipo_req?>" />
    <input type="hidden" name="CD_TURMA" id="CD_TURMA" value="<?=$cd_tuma?>" />
    <input type="hidden" name="CD_DISCIPLINA" id="CD_DISCIPLINA" value="<?=$cd_disciplina?>" />
    <input type="hidden" name="CD_CURSO" id="CD_CURSO" value="<?=$cd_curso?>" />
    <input type="hidden" name="BIMESTRE" id="BIMESTRE" value="<?=$bimestre?>" />
    <input type="hidden" name="TIPO_NOTA" id="BIMESTRE" value="<?=$tipo_nota?>" />
    <input type="hidden" name="TURNO" id="BIMESTRE" value="<?=$turno?>" />
    <input type="hidden" id="toda_turma" name="toda_turma"/>
    <table class="table  table-bordered table-hover" id="sample-table-1">
        <thead>
            <tr>
                <td colspan="5" class="alert alert-warning text-center">
                    <label>
                    <span class="bigger-110 no-text-shadow center">
                        <?php if($tipo_req==2){?>
                            Selecione os alunos que deseja alterar a nota.
                        <?php }else{ ?>
                            Selecione os alunos que deseja limpar/alterar a nota.
                        <?php } ?>
                    </span>
                    </label>
                </td>
            </tr>
            <tr>
                <td colspan="4" class="alert alert-warning text-right">
                    <label>
                    <span class="bigger-110 no-text-shadow center">
                        <?php if($tipo_req==2){?>
                            Clique no botão ao lado caso queria alterar a nota da turma toda.
                        <?php }else{ ?>
                            Clique no botão ao lado caso queria limpar a nota da turma toda.
                        <?php } ?>
                    </span>
                    </label>
                </td>
                <td colspan="1" class="alert alert-warning text-center">
                <button class='btn btn-warning btn-sm' type='button' title='Todos' id='todos' onclick='marcardesmarcar();' ><i class='fa fa-check'></i></button>
                </td>
            </tr>
            <tr>
                <td align="center"><strong>Matricula</strong></td>
                <td class="text-left"><strong>Nome</strong></td>
                <td align="center"><strong>Nota Lançada</strong></td>
                <td align="center"><strong>Motivo</strong></td>
                <td align="center"><strong><?php if($tipo_req==2){?>Nova Nota <?php }else{ ?>Limpar <?php } ?></strong></td>
            </tr>
        </thead>
        <tbody>
            <?php 
                for ($i = 0; $i < count($alunos); $i++) {
            ?>
            <tr>
                <td align="center">
                    <?=$alunos[$i]['CD_ALUNO']?>
                </td>
                <td class="text-left"><?=$alunos[$i]['NM_ALUNO']?></td>
                <td align="center"  ><?=$alunos[$i]['NOTA']?></td>
                <td align="center"  >
                    <select name="motivo[]" id="motivo" class="marcar">
                        <?php foreach ($motivo as $m) {?>
                        <option value="<?=$m['CD_REQ_MOTIVO']?>;<?=$alunos[$i]['CD_ALUNO']?>"><?=$m['DC_MOTIVO']?></option>
                        <?php } ?>
                    </select>
                </td>
                <td align="center" class="alert alert-success">
                    <?php  if($tipo_req == 1){?>
                    <input type="checkbox" name="CD_ALUNO[]" id="CD_ALUNO" checked="" disabled=""  class="marcar" value="<?=$alunos[$i]['CD_ALUNO']?>" />
                    <input type="hidden" name="CD_ALUNO[]" id="CD_ALUNO"  class="marcar" value="<?=$alunos[$i]['CD_ALUNO']?>" />
                    <?php }else{ ?>
                    <input type="checkbox" name="CD_ALUNO[]" id="CD_ALUNO"  class="marcar" value="<?=$alunos[$i]['CD_ALUNO']?>" />
                    <input type="text" name="NOTA_ALUNO[<?=$alunos[$i]['CD_ALUNO']?>]" id="NOTA_ALUNO" checked="" class="marcar" value="" placeholder="00.0" size="5" maxlength="4" onkeydown="mascara(this, mvalor );" onblur="mascara(this, mvalor );" onkeyup="ValidaValor(this, 10);" />    
                    <?php } ?>
                </td>
            </tr>
            
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">
                    <p class="text-primary">Observação do requerimento.</p>
                    <input type="text" name="obs" id="obs" required="" class="form-control" />
                </td>
            </tr>
        </tfoot>
    </table> 
    <input type="submit" class="btn btn-success" value="Confirmar" name="confirmar" id="confirmar"/>
    
</form>
<?php
} else {
    echo '<div class="alert alert-danger">
                <button class="close" data-dismiss="alert" type="button">
                    <i class="icon-remove"></i>
                </button>
                <strong>
                    <i class="icon-remove"></i>
                    Info!
                    <br>
                </strong>
                    Nenhum registro encontrado.
                <br>
            </div>';
}
?>
<div id="historico1" class="modal" data-keyboard="false" data-backdrop="static" data-remote="<?=SCL_RAIZ?>/intranet/rh/historico?id=1"><?=modal_load?></div>
<div id="historico2" class="modal" data-keyboard="false" data-backdrop="static" data-remote="<?=SCL_RAIZ?>/intranet/rh/historico?id=2"><?=modal_load?></div>
<div id="historico3" class="modal" data-keyboard="false" data-backdrop="static" data-remote="<?=SCL_RAIZ?>/intranet/rh/historico?id=3"><?=modal_load?></div>

<script>
$(document).ready(function(){
    //$('.chosen-select').chosen(); 
});
</script>