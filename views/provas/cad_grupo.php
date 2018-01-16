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

            <div class="panel panel-<?= $bt_cor ?>">
                
                <div class="panel-heading">
                    <h4><?= $subtitulo ?></h4>
                   
                </div>
                <?php print_r($dados);?>
                <div class="panel-body">
                    <?php
                    echo get_msg('msgok');
                    echo get_msg('msgerro');
                    ?>
                    
                    <form action="<?=SCL_RAIZ?>provas/questoes/registar_infor" method="post"  name="formCategoria" id="formCategoria" class="form-horizontal">
                       <input type="hidden" name="acao" value="<?=  base64_encode($acao)?>" />
                        <input type="hidden" name="autor" value="<?=$autor?>" />
                        <input type="hidden" name="cd_grupo" value="<?=$dados[0]->CD_GRUPO?>" />
                        <?php
                        if($_GET['cd']){
                            $cd_disc = $_GET['cd'];
                        }else{
                            $cd_disc = $dados[0]->CD_DISCIPLINA;
                        }
                        ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="disc">Disciplina</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="disc" id="disc" required >
                                    <option value="" class="text-muted">Selecione a Disciplina</option>
                                    <?php foreach($disciplina as $r){ ?>
                                       <option value="<?=$r->CD_DISCIPLINA?>" <?php if($cd_disc == $r->CD_DISCIPLINA ) echo "selected";?>><?=$r->NM_DISCIPLINA?></option>';	
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="pergunta">Descrição</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" value="<?=$dados[0]->DC_GRUPO?>" id="descricao" name="descricao" required="">
                            </div>
                        </div>
                        
                        
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" id="btn_frmMensagem" class="btn btn-<?=$bt_cor ?>"> <?=$bt_acao ?> Registro <i class="fa fa-save"></i></button>
                                <a href="<?= SCL_RAIZ ?>provas/questoes/lista_grupo/" class="btn btn-danger">Cancelar</a>
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