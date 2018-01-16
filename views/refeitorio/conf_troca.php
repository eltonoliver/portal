<script type="text/javascript" src="<?= SCL_JS ?>bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?= SCL_CSS ?>bootstrap-multiselect.css" type="text/css" />


<div class="modal-header btn-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" >Selecione o Produto de Troca</h4>
</div>

<form action="<?= SCL_RAIZ ?>refeitorio/cantina/trocar" method="post" enctype="multipart/form-data" id="frm_produto" name="frm_produto">

    <!--produto original-->
    <div class="widget-main">
        Dados do produto original
            <div class="modal-body" id="frmmodal">
                <div class="input-group"> 
                    <span class="input-group-addon"> <i class="icon-group bigger-110"></i> Produto Origem </span>
                    <input type="text" readonly="" value="<?=$estorno->NM_MATERIAL?>" name="produto" class="input-group form-control col-sm-5">
                    <span class="input-group-addon"> <i class="icon-group bigger-110"></i> QTDE </span>
                    <input type="text" readonly="" value="<?=$estorno->QUANTIDADE?>" name="qtde_origem" class="input-group form-control col-sm-5">
                    
                </div> 
            </div>    
    </div>
    
    <?php  foreach($estorno as $value){ ?>
    <input type="hidden" name="estorno[]" value="<?=$value?>">
    <?php } ?>
   
    <div class="widget-main">
        Abaixo os produtos válidos para troca
            <div class="modal-body" id="frmmodal">
                <div class="input-group"> 
                    <span class="input-group-addon"> <i class="icon-group bigger-110"></i> Novo Produto </span>
                    <select name="baixa" id="baixa" class="select form-control col-sm-5" required data-filter="true"> 
                        <option value="">Escolha o produto de troca</option>
                        <?php foreach ($produtos as $r) { ?>
                        <option value="<?=$r->ID_PRODUTO?>;<?=$r->CD_UNIDADE_MEDIDA?>;<?=$r->CD_MATERIAL_BAIXA?>;<?=$r->CD_UNIDADE_MEDIDA_BAIXA?>"><?=$r->DC_PRODUTO?></option>
                         <?php } ?>
                    </select>
                    <span class="input-group-addon"> <i class="icon-group bigger-110"></i> QTDE </span>
                    <input type="text" value="1" name="qtde_troca" class="input-group form-control col-sm-5">
                </div> 
            </div>    
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Confirmar</button>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        $('.selectpicker').selectpicker({
            data-live-search="true"
        });
    });
</script>
<?php exit; ?>