<form name="frm_livro" id="frm_livro" method="post" action="">
    <div class="modal-header btn-<?=$cor?> ">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 class="modal-title"><?=$titulo?></h3>
        <?php  if($acao == 'editar'){?>
        <input type="hidden" name="id_livro" value="<?= @$dados[0]['ID_LIVRO'] ?>" />
        <?php } ?>
        <input type="hidden" name="acao" value="<?= $acao ?>" />
    </div>
    <div class="modal-body">
        <div class="col-12-sm"> 
            <div id="retorno"></div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="40%">
                        <div class="form-group">
                            <label class="control-label"><strong>Curso </strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-10"> <span class="input-group-addon"><i class="fa fa-list"></i></span>
                                    
                                    <select name="curso" id="curso" class="form-control" required="required">
                                        <option value="">Selecione o Curso</option>
                                        <? foreach ($curso as $item) { ?>
                                            <option <?php if(!empty($dados[0]['CD_CURSO'] )){if($dados[0]['CD_CURSO'] == $item['CD_CURSO']){ echo 'selected="selected"'; } }?> value="<?= $item['CD_CURSO'] ?>">
                                                <?= $item['NM_CURSO'] ?>
                                            </option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td width="34%">
                        <div class="form-group">
                            <label class="control-label"><strong>Série</strong></label>
                            <div class="controls row">
                                
                                <div class="input-group col-sm-10"> <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                    <select name="serie" id="serie" class="form-control" required="required">
                                        <option value=""></option>
                                        <? 
                                        if($acao == 'editar'){
                                        foreach ($serie as $s) { ?>
                                            <option <?php if(!empty($dados[0]['CD_SERIE'] )){if($dados[0]['CD_SERIE'] == $s['ORDEM_SERIE']){ echo 'selected="selected"'; }} ?> value="<?= $s['ORDEM_SERIE'] ?>">
                                                <?= $s['NM_SERIE'] ?>
                                            </option>
                                        <? }} ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </td>
                    
                    <td width="34%">
                        <div class="form-group">
                            <label class="control-label"><strong>Autor</strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-10"> <span class="input-group-addon"><i class="fa fa-user-md"></i></span>
                                    <input name="autor" type="text" class="form-control"  placeholder="Autor do Livro" id="autor" size="20"  value="<?php if(!empty($dados[0]['AUTOR'] )){ echo $dados[0]['AUTOR'];}?>">
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
                
                <tr>
                    <td width="40%">
                        <div class="form-group">
                            <label class="control-label"><strong>Ano Edição </strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-10"> <span class="input-group-addon"><i class="fa fa-book"></i></span>
                                    <input name="ano_edicao" type="text" class="form-control"  placeholder="Ano de Edição" id="ano_edicao" size="20"  value="<?php if(!empty($dados[0]['ANO_EDICAO'] )){ echo $dados[0]['ANO_EDICAO'];}?>">
                                </div>
                            </div>
                        </div>
                    </td>

                    <td width="34%">
                        <div class="form-group">
                            <label class="control-label"><strong>Editora</strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-10"> <span class="input-group-addon"><i class="fa fa-text-width"></i></span>
                                    <input name="editora" type="text" class="form-control"  placeholder="Editora do Livro" id="editora" size="20"  value="<?php if(!empty($dados[0]['EDITORA'] )){ echo $dados[0]['EDITORA'];}?>">
                                </div>
                            </div>
                        </div>
                    </td>
                    
                    <td width="34%">
                        <div class="form-group">
                            <label class="control-label"><strong>Nome do Livro</strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-10"> <span class="input-group-addon"><i class="fa fa-text-width"></i></span>
                                    <input name="nome" type="text" class="form-control" required="required" placeholder="Nome do Livro" id="nome" size="20"  value="<?php if(!empty($dados[0]['LIVRO_TITULO'] )){ echo $dados[0]['LIVRO_TITULO'];}?>">
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
                
                <tr>
                    <td width="40%">
                        <div class="form-group">
                            <label class="control-label"><strong>Disciplina </strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-10"> <span class="input-group-addon"><i class="fa fa-book"></i></span>
                                    <select name="cd_disciplina" id="cd_disciplina" class="form-control" required="required">
                                        <option value="">Selecione uma Disciplina</option>
                                        <? foreach ($disciplina as $item) { ?>
                                            <option <?php if(!empty($dados[0]['CD_DISCIPLINA'] )){if($dados[0]['CD_DISCIPLINA'] == $item['CD_DISCIPLINA']){ echo 'selected="selected"'; }} ?> value="<?= $item['CD_DISCIPLINA'] ?>">
                                                <?= $item['NM_DISCIPLINA'] ?>
                                            </option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td width="34%">
                        <div class="form-group">
                            <label class="control-label"><strong>Código de Referencia</strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-10"> <span class="input-group-addon"><i class="fa fa-file"></i></span>
                                    <input name="cod_ref" type="text" class="form-control"  placeholder="Código Referencia" id="cod_ref" size="20"  value="<?php if(!empty($dados[0]['CODIGO_REFERENCIA'] )){ echo $dados[0]['CODIGO_REFERENCIA'];}?>">
                                </div>
                            </div>
                        </div>
                    </td>
                    
                    <td width="34%">
                        <div class="form-group">
                            <label class="control-label"><strong>Livro Ativo?</strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-10"> <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                    <select name="ativo" id="ativo" class="form-control" required="required">
                                        <option <?php if(!empty($dados[0]['ATIVO'] )){if($dados[0]['ATIVO'] == 1){ echo 'selected="selected"'; } } ?>  value="1">Sim</option>
                                        <option <?php if(!empty($dados[0]['ATIVO'] )){if($dados[0]['ATIVO'] == 2){ echo 'selected="selected"'; } } ?>value="0">Não</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
                
                <tr>
                    <td colspan="3">
                        <div class="form-group">
                            <label class="control-label"><strong>Observação</strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-11"> <span class="input-group-addon"><i class="fa fa-text-width"></i></span>
                                    <input name="obs" type="text" class="form-control" placeholder="Observação" id="obs"  value="<?php if(!empty($dados[0]['OBSERVACAO'] )){ echo $dados[0]['OBSERVACAO'];}?>">
                                </div>
                            </div>
                        </div>
                    </td> 
                </tr>
                
            </table>
        </div>
    </div>
    <div class="modal-footer"> 
        <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
        <button type="submit" value="Submit" class="btn btn-<?=$cor?>" id="btn_confirmar" ><i class="fa fa-plus"></i> <?=$botao?> </button>
    </div>
</form>
<link rel="stylesheet" href="<?= SCL_JS ?>/jquery-validation/demo/css/screen.css">
<script src="<?= SCL_JS ?>/jquery-validation/dist/jquery.validate.js"></script>

<script>
    $(document).ready(function () {

        $("select[name=curso]").change(function () {
            $("select[id=serie]").html('Aguardando série');
            $.post("<?= SCL_RAIZ ?>colegio/colegio/curso_serie", {
                curso: $(this).val()},
            function (valor) {
                $("select[id=serie]").html(valor);
            })
        });
    });
</script>
<script>
    $().ready(function () {
        $("#frm_livro").validate({});
    });
</script>

<script>
    $(document).ready(function () {
        $("#frm_livro").submit(function (e) {
            e.preventDefault(); // <-- important
            if ($("#frm_livro").valid()) {
                
                $('#retorno').html('<div class="alert alert-warning">Validando...</div>');
                var dados = $("#frm_livro").serialize();
                jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url() ?>professor/livro/conf_livro",
                    data: dados,
                    success: function (data) { 
                        if(data == 1){
                            $('#retorno').html('<div class="alert alert-success">Registro Cadastrado com Sucesso...</div>');
                            window.location = '<?=base_url()?>professor/livro/index';
                        }else{
                            $('#retorno').html('<div class="alert alert-danger">Erro ao Cadastrar o livro</div>');
                            document.getElementById("frm_livro").reset();
                        }            
                    }
                });
            return false;
            }
        });

    });
</script>





<?php exit; ?>