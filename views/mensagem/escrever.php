<? $this->load->view('layout/header'); ?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.2.min.js"></script>
<script language="javascript" type="text/javascript">
    function move_list_items(sourceid, destinationid)
  {
    $("#"+sourceid+"  option:selected").appendTo("#"+destinationid);
  }

  //this will move all selected items from source list to destination list
  function move_list_items_all(sourceid, destinationid)
  {
    $("#"+sourceid+" option").appendTo("#"+destinationid);
  }
  
  function selectAll(selectBox, selectAll) {
        // have we been passed an ID
        if (typeof selectBox == "string") {
            selectBox = document.getElementById(selectBox);
        }
        // is the select box a multiple select box?
        if (selectBox.type == "select-multiple") {
            for (var i = 0; i < selectBox.options.length; i++) {
                selectBox.options[i].selected = selectAll;
            }
        }
    }
</script>
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="page-content">
                <!-- /.page-header -->
                <div class="row">
                    <form action="<?= SCL_RAIZ ?>mensagem/enviar" method="post" name="frmmensagem" id="form" class="form-inline" enctype="multipart/form-data">
                        <div class="col-sm-7">
                            <div class="input-group" style="margin-left:11px"> 
                                <span class="input-group-addon"> 
                                    <i class="icon-group bigger-110"></i> Contatos </span>
                                <select name="grupo" id="grupo" class="form-control col-sm-5">
                                    <?= $listargrupo ?>
                                </select>
                            </div>  
                            <div class="col-sm-12"><br />  

                                <div class="col-sm-8">
                                    <label class="col-sm-12">MEUS CONTATOS:</label>
                                    <select name="contato" id="contato" size="10" multiple style="width:100%" class="form-control">
                                    </select>
                                    <label class="col-xs-3  pull-right">
                                        <button id="moverightall" type="button" class="btn btn-success btn-xs" onclick="move_list_items_all('contato', 'destino');"><i class="fa fa-angle-double-right bigger-160"></i></button>&zwj; | 
                                        <button id="moveright" type="button"  class="btn btn-warning btn-xs" onclick="move_list_items('contato', 'destino');"><i class="fa fa-angle-right bigger-160"></i></button>
                                    </label>
                                </div>
                                <div class="col-sm-4">
                                    <label class="col-sm-12">ENVIAR PARA:</label>
                                    <select name="destino[]" id="destino" size="10" style="width:100%" multiple class="form-control">
                                    </select>
                                    <label class="col-xs-12">
                                        <button id="moveleft" type="button" class="btn btn-warning btn-xs" onclick="move_list_items('destino', 'contato');"><i class="fa fa-angle-left bigger-160"></i></button>&zwj; | 
                                        <button id="moveleftall" type="button" class="btn btn-success btn-xs" onclick="move_list_items_all('destino', 'contato');"><i class="fa fa-angle-double-left bigger-160"></i></button>
                                    </label>
                                </div>
                            </div>         
                        </div>
                        <div class="col-sm-5">
                            <?
                            echo validation_errors();
                            echo br();
                            echo form_label("<strong>Assunto: </strong>");
                            echo br();
                            echo form_input('sclassunto', '', 'class="form-control" maxlength="50"');
                            echo br();
                            echo form_label("<strong>Mensagem: </strong>");
                            echo br();
                            echo form_textarea('sclmsg', '', 'class="form-control"');
                            echo br();
                            echo form_label("<strong>Arquivo: </strong>");
                            echo br();
                            echo form_upload('arquivo', '', 'class="form-control" id="arquivo"');
                            echo br();
                            echo br();
                            ?>
                            <input name="Reset" type="reset" class="btn btn-info"  value="Limpar" />
                            <a class="btn btn-danger" href="<?= SCL_RAIZ ?>mensagem/"> <i class="icon-remove"></i> Cancelar </a>
                            <button type="submit" class="btn btn-success" onclick="selectAll('destino', true);"> <i class="icon-share"></i> >Enviar  </button>
                        </div> 
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
                                            $(document).ready(function() {
                                                $("select[name=grupo]").change(function() {
                                                    $("select[id=contato]").html('Aguardando contato');
                                                    $.post("<?= SCL_RAIZ ?>mensagem/grupo_listar", {
                                                        grupo: $(this).val()},
                                                    function(valor) {
                                                        $("select[id=contato]").html(valor);
                                                    })
                                                })
                                            });

</script> 

<? $this->load->view('layout/footer'); ?>