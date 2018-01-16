
<form name="frm_ocorrencias" id="frmOcorrencias" method="post" action="<?= base_url() ?>ocorrencias/psicologico/upload" enctype='multipart/form-data'>
    <input type="hidden" name="cd_ocorrencia" value="<?=$cd_ocorrencia?>" />
    <input type="hidden" name="cd_aluno" value="<?=$cd_aluno?>" />
    <div class="modal-header btn-info ">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 class="modal-title">Upload de Arquivos</h3>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-12-sm">
                <?php echo get_msg('msg');?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">        
                <label class="control-label">Tipo do Arquivo</label>
                <div class="input-append"  style="margin-top:-5px">
                    <select class="form-control" name="tipo_arquivo[]">
                        <?php foreach ($tipo_arquivo as $t) { ?>
                            <option value="<?= $t['CD_OCORRENCIAS_TIPO_ARQUIVO'] ?>"><?= $t['DESCRICAO'] ?></option>
                        <?php } ?>
                    </select>
                </div> 
            </div>

            <div class="col-xs-8">        
                <label class="control-label">Arquivo</label>
                <div class="input-append"  style="margin-top:-35px">
                    <input type="file" name="arquivo1" style="visibility:hidden;" id="pdffile" />
                    <input type="text" id="subfile" class="input-small" style="width:250px">
                    <a class="btn btn-default" onclick="$('#pdffile').click();">Procurar</a>
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">        
                <label class="control-label">Tipo do Arquivo</label>

                <div class="input-append"  style="margin-top:-5px">
                    <select class="form-control" name="tipo_arquivo[]">
                        <?php foreach ($tipo_arquivo as $t) { ?>
                            <option value="<?= $t['CD_OCORRENCIAS_TIPO_ARQUIVO'] ?>"><?= $t['DESCRICAO'] ?></option>
                        <?php } ?>
                    </select>
                </div> 
            </div>

            <div class="col-xs-8">        
                <label class="control-label">Arquivo</label>
                <div class="input-append"  style="margin-top:-35px">
                    <input type="file" name="arquivo2" style="visibility:hidden;" id="pdffile1" />
                    <input type="text" id="subfile1" class="input-small" style="width:250px">
                    <a class="btn btn-default" onclick="$('#pdffile1').click();">Procurar</a>
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">        
                <label class="control-label">Tipo do Arquivo</label>
                <div class="input-append"  style="margin-top:-5px">
                    <select class="form-control" name="tipo_arquivo[]">
                        <?php foreach ($tipo_arquivo as $t) { ?>
                            <option value="<?= $t['CD_OCORRENCIAS_TIPO_ARQUIVO'] ?>"><?= $t['DESCRICAO'] ?></option>
                        <?php } ?>
                    </select>
                </div> 
            </div>

            <div class="col-xs-8">        
                <label class="control-label">Arquivo</label>
                <div class="input-append"  style="margin-top:-35px">
                    <input type="file" name="arquivo3" style="visibility:hidden;" id="pdffile2" />
                    <input type="text" id="subfile2" class="input-small" style="width:250px">
                    <a class="btn btn-default" onclick="$('#pdffile2').click();">Procurar</a>
                </div> 
            </div>
        </div>


    </div>
</div>
<div class="modal-footer"> 
    <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
    <button type="submit" value="Submit" class="btn btn-success" id="frmarquivo_btn" ><i class="fa fa-plus"></i> Confirmar </button>
</div>
</form>

<script>
    $(document).ready(function () {

        $('#pdffile').change(function () {
            $('#subfile').val($(this).val());
        });
        $('#showHidden').click(function () {
            $('#pdffile').css('visibilty', 'visible');
        });

        $('#pdffile1').change(function () {
            $('#subfile1').val($(this).val());
        });
        $('#showHidden').click(function () {
            $('#pdffile2').css('visibilty', 'visible');
        });

        $('#pdffile2').change(function () {
            $('#subfile2').val($(this).val());
        });
        $('#showHidden').click(function () {
            $('#pdffile2').css('visibilty', 'visible');
        });
    });
</script>
<?php exit(); ?>