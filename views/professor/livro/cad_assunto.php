<?php error_reporting(1); ?>
<form name="frm_assunto" id="frm_assunto" method="post" action="">

    <input type="hidden" name="id_livro" value="<?= $id_livro ?>" />
    <input type="hidden" name="id_assunto" value="<?= $id_assunto ?>" />
    <input type="hidden" name="estrutura" value="<?= $estrutura ?>" />
    <input type="hidden" name="acao" value="<?= $acao ?>" />

    <div class="modal-header btn-<?=$cor?> ">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 class="modal-title"><?=$titulo?></h3>
        <?php #print_r($dados)?>
    </div>
    <div class="modal-body">
        <div class="col-12-sm"> 
            <div id="retornoq"></div>
            <div id="retorno" class="alert alert-success" style="display: none">Registro Cadastrado com Sucesso...</div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="40%">
                        <div class="form-group">
                            <label class="control-label text-left"><strong>Bimestre</strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-10"> <span class="input-group-addon"><i class="fa fa-list"></i></span>
                                    <select name="bimestre" id="bimestre" class="form-control" required="required">
                                        <option value="">Selecione o Bimestre</option>
                                        <?php if($acao == 'editar'){ ?>
                                        <option <?php if($dados[0]['BIMESTRE'] == 1){ echo "selected='selected'";} ?> value="1">1° Bimestre</option>
                                        <option <?php if($dados[0]['BIMESTRE'] == 2){ echo "selected='selected'";} ?> value="2">2° Bimestre</option>
                                        <option <?php if($dados[0]['BIMESTRE'] == 3){ echo "selected='selected'";} ?> value="3">3° Bimestre</option>
                                        <option <?php if($dados[0]['BIMESTRE'] == 4){ echo "selected='selected'";} ?> value="4">4° Bimestre</option>
                                        <?php }else{ ?>
                                        <option value="1">1° Bimestre</option>
                                        <option value="2">2° Bimestre</option>
                                        <option value="3">3° Bimestre</option>
                                        <option value="4">4° Bimestre</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td width="34%">
                        <div class="form-group">
                            <label class="control-label"><strong>Assunto</strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-10"> <span class="input-group-addon"><i class="fa fa-text-height"></i></span>
                                    <input name="assunto" type="text" required="required" class="form-control"  placeholder="Assunto" id="assunto" size="20"  value="<?php if($acao == 'editar'){ echo  $dados[0]['DC_ASSUNTO'];}?>">
                                </div>
                            </div>
                        </div>
                    </td>

                    <td width="34%">
                        <div class="form-group">
                            <label class="control-label"><strong>Imagem</strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-10"> <span class="input-group-addon"><i class="fa fa-file"></i></span>
                                    <input name="autor" disabled="" type="file" class="form-control"  id="autor" size="20"  value="">
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>


            </table>
        </div>
    </div>
    <div class="modal-footer"> 
        <a href="<?=base_url()?>professor/livro/conteudo?cd=<?=base64_encode($this->input->get_post('id'))?>" class="btn btn-default" ><i class="fa fa-rotate-left"></i> Cancelar</a>
        <button type="submit" value="Submit" class="btn btn-<?=$cor?>" id="btn_confirmar" ><i class="fa fa-plus"></i> <?=$botao?> </button>
    </div>
</form>
    <link rel="stylesheet" href="<?= SCL_JS ?>/jquery-validation/demo/css/screen.css">
    <script src="<?= SCL_JS ?>/jquery-validation/dist/jquery.validate.js"></script>


    <script>
        $().ready(function () {
            $("#frm_assunto").validate({});
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#frm_assunto").submit(function (e) {
                e.preventDefault(); // <-- important
                if ($("#frm_assunto").valid()) {

                   // $('#retorno').html('<div class="alert alert-warning">Validando...</div>');
                    var dados = $("#frm_assunto").serialize();
                    jQuery.ajax({
                        type: "POST",
                        url: "<?= base_url() ?>professor/livro/conf_assunto",
                        data: dados,
                        success: function (data) {
                            if (data == 1) {
                                //$('#retorno').html('<div class="alert alert-success">Registro Cadastrado com Sucesso...</div>');
                                $("#retorno").fadeIn(2000);
                                $('#assunto').val('');
                                $("#retorno").fadeOut(2000);
                              //  location.reload();
                            } else {
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