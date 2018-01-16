<?php $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo validation_errors();
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-warning">
                <div class="panel-heading"> 
                    <a class="btn btn-info" href="<?= SCL_RAIZ ?>colegio/noticia/index">Voltar</a>
                </div>

                <form action="<?= SCL_RAIZ ?>colegio/noticia/frmnoticiamanter" method="post" enctype="multipart/form-data" name="formNoticia" id="formNoticia" id="form" >
                    <div class="panel-body">                     
                        <input name="acao" type="hidden" id="acao" value="<?= $acao ?>" />
                        <input name="bt_acao" type="hidden" id="bt_acao" value="<?= $bt_acao ?>" />
                        <input name="bt_cor" type="hidden" id="bt_cor" value="<?= $bt_cor ?>" />
                        <input name="id_noticia" type="hidden" id="bt_cor" value="<?= $codigo ?>" />
                        <div class="col-xs-12">
                            <div class="col-sm-12">
                                <?php
                                echo br();
                                echo form_label("<strong>CÓDIGO: </strong>");
                                echo br();
                                echo form_input('sclcodigo', '' . $codigo . '', 'class="form-control" readonly="readonly"');
                                echo br();
                                echo form_label("<strong>AUTOR: </strong>");
                                echo br();
                                echo form_input('sclautor', '' . $autor . '', 'class="form-control" readonly="readonly"');
                                echo br();
                                echo form_label("<strong>TIPO NOTICIA: </strong>");
                                echo br();
                                #   print_r($not_tipo);
                                ?>
                                <select name="tipo" class="form-control">
                                    <?php
                                    foreach ($not_tipo as $t) {
                                        ?>
                                        <option <?php if ($t['CD_TIPO'] == $tipo) echo "selected"; ?> value="<?= $t['CD_TIPO'] ?>"><?= $t['DC_TIPO'] ?></option>
                                    <?php } ?>
                                </select>
                                <?php
                                echo br();
                                echo form_label("<strong> TÍTULO: </strong>");
                                echo br();
                                ?>
                                <input class="form-control" type="text" value="<?= $scltitulo ?>" name="scltitulo">
                                <div class="input-group">
                                    <div class="checkbox">
                                        <label>
                                            <input class="ace" type="checkbox" name="sclstatus" value="1" <?php
                                            if ($sclstatus == 1) {
                                                echo "checked";
                                            } else {
                                                echo "";
                                            }
                                            ?>>
                                            <span class="lbl"> Publicar Notícia?</span>
                                        </label>
                                    </div>

                                    <?php if ($this->session->userdata('SCL_SSS_USU_CODIGO') == 5265) { ?>

                                        <div class="checkbox">
                                            <label>
                                                <input class="ace" type="checkbox" name="sclpopup" value="1" <?php
                                                if ($sclpopup == 1) {
                                                    echo "checked";
                                                } else {
                                                    echo "";
                                                }
                                                ?>>
                                                <span class="lbl"> Destacar noticia em alerta?</span>
                                            </label>
                                        </div>

                                    <?php } ?>
                                </div>
                                <div class="col-xs-3">
                                    <label>DATA INÍCIO</label><br/>
                                    <input class="form-control" type="text" name="dtInicio" id="dtInicio" value="<?= $dtInicio ?>">
                                </div>

                                <div class="col-xs-3">
                                    <label>DATA FIM</label><br/>
                                    <input class="form-control" type="text" name="dtFim" id="dtFim" value="<?= $dtFim ?>">
                                </div>
                                <div class="col-xs-12">
                                    <?php
                                    echo form_label("<strong>ARQUIVO: </strong>");
                                    echo br();
                                    echo form_upload('arquivo', '', 'class="form-control" id="arquivo"');
                                    if ($_GET['acao'] == 'U') {
                                        echo '<span class="text-danger">Só escolha outro arquivo se quizer alterar o anterior.</span>';
                                    }
                                    ?>
                                </div>
                                <br>
                                <br>                    
                            </div>
                        </div>                      
                    </div>

                    <div class="modal-footer">
                        <div class="pull-left"><a href="<?= SCL_RAIZ ?>colegio/noticia/index" class="btn btn-inverse"><i class="fa fa-backward"></i> Cancelar</a></div>
                        <button type="submit" id="btn_frmMensagem" class="btn btn-<?= $bt_cor ?>"> <?= $bt_acao ?> Registro <i class="fa fa-save"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("#dtInicio").datepicker({
        language: 'pt-BR',
        format: 'dd/mm/yyyy'
    });

    $("#dtFim").datepicker({
        language: 'pt-BR',
        format: 'dd/mm/yyyy'
    });

    $('#gridview').dataTable({
        "sPaginationType": "full_numbers"
    });
</script>
<?php $this->load->view('layout/footer'); ?>