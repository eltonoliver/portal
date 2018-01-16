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
                <form action="<?=SCL_RAIZ?>jornal/caderno/registar_infor" method="post"  name="formCategoria" id="formCategoria">
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
                        <div class="col-sm-12">
                            <label><strong>CÓDIGO: </strong></label>
                            <br>
                            <input class="form-control" type="text" readonly="readonly" value="<?=$dados[0]->CD_CADERNO?>" name="codigo">
                            <br>
                            <label><strong>DESCRIÇÃO: </strong></label>
                            <br>
                            <input class="form-control" type="text" value="<?=$dados[0]->DESCRICAO?>" name="caderno">
                            <br>                
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="pull-left btn">
                            <a href="<?=SCL_RAIZ ?>jornal/caderno/" class="btn btn-inverse"><i class="fa fa-backward"></i> Cancelar</a>
                        </div>
                        <button type="submit" id="btn_frmMensagem" class="btn btn-<?=$bt_cor?>"> <?=$bt_acao?> Registro <i class="fa fa-save"></i></button>
                    </div>
                </form>
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