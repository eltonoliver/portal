<link href="<?= SCL_CSS ?>bootstrap-select.min.css" rel="stylesheet" type="text/css">
<link href="<?= SCL_CSS ?>style.css?v=1.0" rel="stylesheet">
</script><script src="<?= SCL_JS ?>script.js"></script>   


<div class="modal-header btn-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" >Lista de Chamada</h4>
</div>
<form action="<?= SCL_RAIZ ?>professor/arquivo/upload_arquivo_turma" method="post" enctype="multipart/form-data" id="frmfrequencia" >
    <div class="widget-main">
        <input name="acao" type="hidden" value="add" />
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
                <tr>
                    <td width="100%"><label class="col-md-3 control-label" for="descricao"> Turma </label></td>
                </tr>
                <tr>
                    <td>
                        <div class="col-md-12">
                            <select id="turma[]" name="turma[]" class="form-control" size="5" multiple="">
                                <?php
                                foreach ($turma as $t) {
                                    echo '<option value="'.$t['CD_TURMA'].':'.$t['CD_DISCIPLINA'].'">' . $t['CD_TURMA'] . ' - ' . $t['NM_DISCIPLINA'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td><label class="col-md-3 control-label" for="descricao"> Descrição</label></td>
                </tr>
                <tr>
                    <td>
                        <div class="col-md-12">
                            <textarea name="descricao" rows="3" id="descricao" style="width:100%"></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label class="col-md-3 control-label" for="descricao"> Arquivos </label></td>
                </tr>
                <tr>
                    <td><div class="col-md-12"><input type="file" id="arquivo1" name="arquivo1"><label class="file-label" data-title="Procurar"><span class="file-name" data-title="Sem arquivo em anexo ..."><i class="icon-upload-alt"></i></span></label><a class="remove" href="#"><i class="icon-remove"></i></a></div></td>
                </tr>
                <tr>
                    <td><div class="col-md-12"><input type="file" id="arquivo2" name="arquivo2"><label class="file-label" data-title="Procurar"><span class="file-name" data-title="Sem arquivo em anexo ..."><i class="icon-upload-alt"></i></span></label><a class="remove" href="#"><i class="icon-remove"></i></a></div></td>
                </tr>
                <tr>
                    <td><div class="col-md-12"><input type="file" id="arquivo3" name="arquivo3"><label class="file-label" data-title="Procurar"><span class="file-name" data-title="Sem arquivo em anexo ..."><i class="icon-upload-alt"></i></span></label><a class="remove" href="#"><i class="icon-remove"></i></a></div></td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Confirmar</button>
    </div>
</form>

<?php exit; ?>