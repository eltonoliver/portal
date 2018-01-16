<?php $this->load->view('layout/header'); ?>

<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    Confirmar Reserva
                </div>
                <div class="panel-body">
                <form method="post" id="frmReserva">
                <div id="assunto" class="tab-pane active">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
                    <tr>
                        <td width="50%" colspan="2"><h2 class='lighter smaller'>Detalhes da Reserva</h2></td>
                    </tr>
                    <tr>
                      <td>
                          <?php
                            foreach ($livro as $d) {
                              echo "<h4 class='lighter smaller'>Autor: <font style='font-weight: bold '>".$d->AUTOR." </font></h4>
                                    <h4 class='lighter smaller'>Livro: <font style='font-weight: bold '>".$d->TITULO."</font></h4>";  
                            }
                          ?>
                      </td>
                      <td>
                         <h4 class='lighter smaller'>Dados da Reserva:</h4>
                         <h4 class='lighter smaller'>Reserva Valida até o dia: <font style="color:red"><?=$dias?></font>
                         </h4>
                         <h4 class='lighter smaller'>Registro nº: <?=$_GET['mfn']?></h4>
                      </td>
                    </tr>
                  </table>
                  <?php 
                    //verifico se estar no limite de emprestimo
                    if($max_reserva == $reserva_ativa->QTDE){
                        echo '<div class="alert alert-warning">
                               <button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>
                               <strong>Alerta!</strong>
                               Limite de reservas Atingido<br><p>
                               <a href="'.SCL_RAIZ."colegio/biblioteca/index".'" class="btn btn-sm btn-success">Voltar</a>
                               <p>
                             </div>';
                    }else{
                    //varifica se ja fez a reserva do livro
                    if($reserva->QTDE == 1){?>
                    <a class="btn btn-warning" href="<?=SCL_RAIZ?>colegio/biblioteca/index">
                      <i class="fa fa-backward"></i>
                          Voltar
                    </a> Você tem uma Reserva válida até: <font style="color:red; font-weight: bold"><?=$reserva->DT_VALIDADE;?></font>
                  <?php }else{?>
                    <a href="#<?=$_GET['mfn']?>" data-toggle="modal">
                        <button class="btn btn-success" onclick="confirmar();" type="submit">
                          <i class="fa fa-save"></i>
                          Confirmar
                        </button>
                    </a>
                    <?php }} ?>
                  <div id="resultado"> </div>
                </div>
              </form>
                </div>

            </div>    
        </div>
    </div>
</div>
<div class="modal fade" id="<?=$_GET['mfn']?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
    data-remote="<?=SCL_RAIZ?>colegio/biblioteca/inserir_reserva?mfn=<?=$_GET['mfn']?>&dt=<?=$dias?>"> 
   <div class="modal-dialog" style="width: 55%;">
       <div class="modal-content">
           <?= modal_load ?>
       </div>
   </div>
</div>
<script>
    $('#data-table').dataTable({
        "sPaginationType": "full_numbers"
    });
</script>
<script type="text/javascript">
    function confirmar(){  
        jQuery(document).ready(function(){ 
            jQuery('#frmReserva').submit(function(){ 
                $("#resultado").html('<?=modal_load?>');
                var dados = jQuery( this ).serialize();
                jQuery.ajax({
                        type: "POST",
                        url: "<?=SCL_RAIZ?>colegio/biblioteca/inserir_reserva",
                        data: dados,
                        success: function( data )
                        {
                                $( "#resultado" ).html( data );
                        }
                        
                });

                return false;
            })
          })
    }
</script>
<?php $this->load->view('layout/footer'); ?>