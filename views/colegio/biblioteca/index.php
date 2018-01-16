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
                    Bibliote Online
                </div>
                <div class="panel-body">
                    <ul id="myTab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#home" data-toggle="tab">
                                <h4> Reservar Livros </h4>
                            </a>
                        </li>
                        <li>
                            <a href="#profile" data-toggle="tab">
                                <h4> Livros Emprestados </h4>
                            </a>
                        </li>
                    </ul>
                    <br>
                    <div class="tab-content">
                        <div class="tab-pane in active" id="home">
                            <div class="row">
                                <form class="form-horizontal form-bordered" method="post" id="frmPesquisar" name="frmPesquisar">   
                                    <div class="col-xs-12">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
                                            <tr>
                                                <td width="50%">Autor</td>
                                                <td width="50%">Livro</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input name="codautor" id="codautor" type="hidden" size="2" readonly="readonly"/>
                                                    <input name="autor" id="autor" style="width:100%" class="form-control"/>
                                                </td>
                                                <td>
                                                    <input name="codlivro" id="codlivro" type="hidden" size="2" readonly="readonly"/>
                                                    <input name="livro" id="livro" style="width:100%" class="form-control"/>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="tab-pane" id="profile">
                            <div class="tabbable">
                                <div class="tab-content no-border no-padding"> 
                                    <div class="table-responsive">
                                        <form method="post" id="frmReserva">
                                    <table id="data-table" class="table table-striped table-bordered table-hover">
                                      <thead>
                                        <tr>
                                          <th>Livro</th>
                                          <th>Autor</th>
                                          <th>Entrega</th>
                                          <th class="hidden-480">Status</th>
                                          <th>Renovar</th>
                                        </tr>
                                      </thead>
                                        <tbody>
                                           <!--inicio do laco-->
                                          <?php
                                            foreach ($lista_emp as $item) {
                                          ?>
                                          <tr>
                                            <td>
                                                <?=$item->TIT_SUBTIT?>
                                                <input type="hidden" id="CD_EMPRESTIMO" value="<?=$item->CD_EMPRESTIMO?>"/>
                                                <input type="hidden" id="DT_DEVOLUCAO" value="<?=$item->DT_DEV_PREVISTA?>"/>
'                                            </td>
                                            <td><?=$item->AUTOR?></td>
                                            <td><?=$item->DT_DEV_PREVISTA?></td>
                                            <td class="hidden-480">
                                                <?php
                                                if($item->DT_DEV_PREVISTA < date('d/m/Y')){
                                                    $status = '<span class="label label-sm label-warning">Atrasado</span>';
                                                }else{
                                                    $status = '<span class="label label-sm label-success">OK</span>';
                                                }
                                                
                                                echo $status;
                                                ?>
                                            </td>
                                            <td>
                                              <?php 
                                                if($item->DT_DEV_PREVISTA == date('d/m/Y')){
                                                    $renovar = '<a id="renovar" class="btn btn-xs btn-success">
                                                                    <i class="icon-ok bigger-120"></i>
                                                                    Renovar
                                                                  </a> <div id="load"> </div>'; 
                                                }else{
                                                    $renovar = '<span class="label label-warning arrowed arrowed-right">Renovação não liberda</span>';
                                                }
                                                ?>
                                                
                                              <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                                <? echo $renovar; ?>
                                              </div>
                                            </td>
                                          </tr>
                                           <?php  } ?>
                                        </tbody>
                                      </table>
                                      </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div id="load"></div>
                    </div>
                </div>

            </div>
            
            <div id="gridlivro">
                            
                
            </div>
            
            
        </div>
    </div>
</div>
<script>
    $('#data-table').dataTable({
        "sPaginationType": "full_numbers"
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("input[name=autor]").change(function() {
            $("#gridlivro").html('<?= modal_load ?>');
            $.post("<?= SCL_RAIZ ?>colegio/biblioteca/gridautor", {
                autor: $(this).val(),
                livro: $("input[name=livro]").val()

            },
            function(valor) {
                $("#gridlivro").html(valor);
            })
        })

        $("input[name=livro]").change(function() {
            $("#gridlivro").html('<?= modal_load ?>');
            $.post("<?= SCL_RAIZ ?>colegio/biblioteca/gridautor", {
                livro: $(this).val(),
                autor: $("input[name=autor]").val()
            },
            function(valor) {
                $("#gridlivro").html(valor);
            })
        })
        //renovar
         $("#renovar").click(function() { 
            $("#load").html('<i class="icon-spinner icon-spin orange bigger-125"></i>');
            $.post("<?= SCL_RAIZ ?>colegio/biblioteca/renovar_livro", {
                cd_emprestimo: $("#CD_EMPRESTIMO").val(),
                dt_devolucao: $("#DT_DEVOLUCAO").val()
            },
            function(valor) { 
                $("#load").html(valor);
                location.reload();
            })
        })
        
  
    })
</script>
<?php $this->load->view('layout/footer'); ?>