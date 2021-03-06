<?php $this->load->view('layout/header'); ?>
<script>
//excluir professor
    function excluir_arquivo(id, arquivo) {
        var url = "<?= SCL_RAIZ ?>professor/arquivo/excluir/" + id + "/" + arquivo;
        window.location.href = url;
    }
</script>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            
            <div class="panel panel-<?=$bt_cor?>">
                <div class="panel-heading">
                    <h4><?=$subtitulo?></h4>
                </div>
                <div class="panel-body">
                    <form action="<?=SCL_RAIZ?>jornal/categoria/registar_infor" method="post"  name="formCategoria" id="formCategoria">
                        <?php
                        if($this->input->get('token')){
                            $acao = $this->input->get('token');
                        }else{
                            $acao = $acao;
                        }
                        ?>
                        <input type="hidden" name="acao" value="<?=$acao?>">
                        <input type="hidden" name="bt_cor" value="<?=$bt_cor?>">
                        <input type="hidden" name="bt_acao" value="<?=$bt_acao?>">
                        <?php
                        echo validation_errors();
                        echo get_msg('msgok');
                        echo get_msg('msgerro');
                        ?>
                        <div class="col-xs-12">
                                <label><strong>CÓDIGO: </strong></label>
                                <br>
                                <input class="form-control" type="text" readonly="readonly" value="<?=$dados[0]->CD_CATEGORIA?>" name="codigo">
                                <br>
                                <label><strong>SELECIONE O CADERNO: </strong></label>
                                <br>
                                <select name="caderno" id="caderno" class="form-control">
                                    <option value="">Selecione um Caderno</option>
                                    <?php foreach ($lista_caderno as $l){ ?>
                                    <option value="<?=$l->CD_CADERNO?>" <?php if($l->CD_CADERNO == $dados[0]->CD_CADERNO) echo "selected='selected'";?> ><?=$l->DESCRICAO?></option>
                                    <?php } ?>
                                </select>
                                <br>
                                <label><strong>DESCRIÇÃO DA CATEGORIA: </strong></label>
                                <br>
                                <input class="form-control" type="text" value="<?=$dados[0]->DC_CATEGORIA?>" name="categoria">
                                <br>
                            <div class="modal-footer">
                                <div class="pull-left btn">
                                    <a href="<?=SCL_RAIZ ?>jornal/categoria/" class="btn btn-inverse"><i class="fa fa-backward"></i> Cancelar</a>
                                </div>
                                <button type="submit" id="btn_frmMensagem" class="btn btn-<?=$bt_cor ?>"> <?=$bt_acao ?> Registro <i class="fa fa-save"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#data-table').dataTable({
        "sPaginationType": "full_numbers"
    });
</script>
<?php $this->load->view('layout/footer'); ?>