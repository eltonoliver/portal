<? $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <? 
        foreach($aluno as $al){ 
           $params = array('codigo' => $al['CD_ALUNO']);
           $listar = $this->secretaria->objeto($params) 
            ?>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <? 
                        foreach($listar as $r){ ?>
                        <li>
                            <div class="media">
                                <div class="pull-left">
                                    <i class="fa fa-list fa-fw fa-2x text-info"></i>
                                </div>                                
                                <div class="pull-right">
                                    <? if(empty($r['ANEXO'])) {?>
                                     <a href="<?= SCL_RAIZ ?>secretaria/declaracao/documento?codigo=<?=$r['CD_DOCUMENTO']?>&aluno=<?=$al['CD_ALUNO']?>" data-toggle="frmDocumento"  class="btn btn-info pull-right" data-target="#frmDocumento" >Emitir</a>
                                    <? }else{ ?>
                                      <a href="<?= SCL_RAIZ ?>application/upload/aluno/<?=$r['ANEXO']?>" class="btn btn-warning pull-right" target="_blank">Visualizar</a>
                                     <? } ?>
                                </div>
                                <div class="media-body">
                                    <a href="#"><?=$r['DC_OBJETO']?></a>
                                </div>                                
                            </div>
                        </li>
                        <? } ?>
                    </ul>
                </div>
            </div>
        </div>
        <? } ?>
    </div>
</div>


<script>
   $('[data-toggle="frmDocumento"]').on('click',
            function(e) {
                $('#frmDocumento').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade" id="frmDocumento"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
</script>
<? $this->load->view('layout/footer'); ?>
