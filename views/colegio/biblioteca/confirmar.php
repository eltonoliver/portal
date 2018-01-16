<div class="modal-header btn-danger alert-dismissable">
    <h4 class="modal-title" >Confirmação de Reserva</h4>
</div>

<div class="widget-main">
   <div class="row">
       <div class="col-md-12">
           <div class="panel panel-default">
               <div class="panel-heading">
                   <h3 class="panel-title">Reserva nº <?php echo $retorno->CD_RESERVA?> </h3>
               </div>
               <div class="panel-body">
                   <p><strong>Registro:</strong> <strong><?=$retorno->MFN?></strong></p>
                   <p><strong>Livro:</strong> <?php echo $retorno->TIT_SUBTIT?></p>
                   <p><strong> Autor:</strong> <?php echo $retorno->PRE_SOBRE?> </p>
                   <p><strong> Reserva Válida:</strong> <?php echo $retorno->DT_VALIDADE_RESERVA?>  </p>
               </div>
           </div>
       </div>
   </div>
</div>


<div class="modal-footer">
    <a href="<?=SCL_RAIZ?>colegio/biblioteca/" class="btn btn-success">OK <i class="icon-ok"></i></a>
</div>
<!--<div class="modal-dialog">
  <div class="modal-content">
      <div class="left">
        <div class="col-xs-12">
          <div class="widget-box">
            <div class="widget-header header-color-orange">
              <h5 class="bigger lighter"> <i class="icon-share "></i> <strong>Reserva nº <? echo $retorno->CD_RESERVA?> </strong></h5>
            </div>
            <div class="widget-body">
              <div class="widget-main"> 
                <i class="icon-reorder"></i> <strong>Registro:</strong> <strong><?=$retorno->MFN?></strong>
                <br /><br />
                <i class="icon-book"></i> <strong>Livro:</strong> <? echo $retorno->TIT_SUBTIT?>
                <br /><br />
                <i class="icon-user"></i><strong> Autor:</strong> <? echo $retorno->PRE_SOBRE?> 
                <br /><br />
                <i class="icon-time"></i><strong> Reserva Válida:</strong> <? echo $retorno->DT_VALIDADE_RESERVA?> 
              </div>
            </div>
          </div>
        </div>
      </div>
   
    <div class="modal-footer"> 
        <a href="<?=SCL_RAIZ?>/colegio/biblioteca/" class="btn btn-success">OK <i class="icon-ok"></i></a>
    </div>
  </div>
</div>-->
<? exit;?>
