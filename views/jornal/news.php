<?php $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <a href="<?=SCL_RAIZ ?>jornal/news/cadastrar_news?token=<?=base64_encode("cadastrar")?>" class="btn btn-default"><i class="icon-plus"></i> Nova Notícia</a>
                </div>
                <table width="100%" border="0" cellspacing="0"  cellpadding="0" class="table table-striped table-bordered table-hover" id="data-table" aria-describedby="data-table_info">
                            <thead>
                                <tr>
                                    <th width="4%"></th>
                                    <th width="4%"></th>
                                    <th>CATEGORIA</th>
                                    <th>TITULO</th>
                                    <th>AUTOR</th>
                                    <th>DATA</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php                        
                                    foreach ($listar as $row) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php
                                                if($this->session->userdata('SCL_SSS_USU_CODIGO') == $row['CD_AUTOR'] or $this->session->userdata('SCL_SSS_USU_TIPO') == 30 or $this->session->userdata('SCL_SSS_USU_CODIGO') == 5257 ){
                                                ?>
                                                <a title="Editar Artigo" class="btn btn-warning" href="<?= SCL_RAIZ ?>jornal/news/cadastrar_news?token=<?=base64_encode('editar')?>&id=<?=urlencode(md5_encrypt($row['CD_NEWS'],123))?>">
                                                    <i class="fa fa-edit"></i> 
                                                </a>
                                                <?php } else { echo "---";} ?>
                                            </td>
                                            <td>
                                                <?php
                                                if($this->session->userdata('SCL_SSS_USU_CODIGO') == $row['CD_AUTOR'] or $this->session->userdata('SCL_SSS_USU_TIPO') == 30){
                                                ?>
                                                <a title="Excluir Artigo" class="btn btn-danger" href="<?= SCL_RAIZ ?>jornal/news/cadastrar_news?token=<?=base64_encode('excluir')?>&id=<?=urlencode(md5_encrypt($row['CD_NEWS'],123))?>">
                                                    <i class="fa fa-trash-o"></i> 
                                                </a>
                                                <?php } else { echo "---";} ?>
                                            </td>
                                            <td><?= $row['DC_CATEGORIA'] ?></td>
                                            <td>
                                                <?php if($row['PUBLICADO']==1){ ?>
                                                <a href="<?=SCL_JOR?>index.php/noticias/noticias_detalhe?id=<?=$row['CD_NOTICIAS']?>" title="Clique aqui para visualizar a notícia" target="_blank"><?= $row['TITULO']?></a>
                                                <?php }else{ echo $row['TITULO'];} ?>
                                            </td>
                                                
                                            <td><?= $row['AUTOR']?></td>
                                            <td><?= date('d/m/Y',strtotime($row['DT_EVENTO']))?></td>
                                            <td style="background-color: <?php if($row['PUBLICADO']==0){ echo "#d3413b;";}else{echo "#8B9DBE;";} ?> "><?php if($row['PUBLICADO']==0){ echo "Não Publicada";}else{echo "Publicado";} ?></td>
                                            
                                        </tr>
                                            <?php } ?>
                                </tbody>
                            </table>
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