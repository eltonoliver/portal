<script>
    function limitaTextarea(valor) {
        quantidade = 134;
        total = valor.length;

        if (total <= quantidade) {
            resto = quantidade - total;
            document.getElementById('contador').innerHTML = resto;
        } else {
            document.getElementById('mensagem').value = valor.substr(0, quantidade);
        }
    }
</script>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header btn-warning">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-users"></i> Escolha o Destinátario </h4>
        </div>
        <div class="modal-body">
            <form action="<?= SCL_RAIZ ?>mensagem/enviar" method="post" name="frmmensagem" id="form" class="form-inline" enctype="multipart/form-data">

                <div class="input-group" style="margin-left:11px"> 
                    <span class="input-group-addon"> 
                        <i class="icon-group bigger-110"></i> Contatos </span>
                    <select name="grupo" id="grupo" class="form-control col-sm-5">
                        <?= $listargrupo ?>
                    </select>
                </div>  

                <div class="col-sm-6">
                    <label class="col-sm-12">MEUS CONTATOS:</label>
                    <select name="contato" id="contato" size="10" multiple style="width:100%" class="form-control">
                    </select>
                    <label class="col-xs-12">
                        <button id="moverightall" type="button" class="btn btn-success btn-xs pull-right" onclick="move_list_items_all('contato', 'destino');"><i class="fa fa-angle-double-right bigger-160"></i></button>
                        <button id="moveright" type="button"  class="btn btn-warning btn-xs pull-right" onclick="move_list_items('contato', 'destino');"><i class="fa fa-angle-right bigger-160"></i></button>
                    </label>
                </div>
                <div class="col-sm-6">
                    <label class="col-sm-12">ENVIAR PARA:</label>
                    <select name="destino[]" id="destino" size="10" style="width:100%" multiple class="form-control">
                    </select>
                    <label class="col-xs-12">
                        <button id="moveleft" type="button" class="btn btn-warning btn-xs" onclick="move_list_items('destino', 'contato');"><i class="fa fa-angle-left bigger-160"></i></button>
                        <button id="moveleftall" type="button" class="btn btn-success btn-xs" onclick="move_list_items_all('destino', 'contato');"><i class="fa fa-angle-double-left bigger-160"></i></button>
                    </label>
                </div>    
            </form>
            &zwnj;
        </div>
        <div class="modal-footer">
            <button class="btn btn-default pull-left" data-dismiss="modal" id="frmarquivo_btn"><i class="fa fa-refresh"></i> Fechar </button>
            <button class="btn btn-default pull-right" data-dismiss="modal" id="frmarquivo_btn"><i class="fa fa-ticket"></i> Finalizar </button>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("select[name=grupo]").change(function() {
            $("select[id=contato]").html('Aguardando contato');
            $.post("<?= SCL_RAIZ ?>/colegio/mensagem/grupo_listar", {
                grupo: $(this).val()},
            function(valor) {
                $("select[id=contato]").html(valor);
            })
        })
    })
</script> 
<script language="javascript" type="text/javascript">
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
    function move_list_items(sourceid, destinationid) {
        $("#" + sourceid + "  option:selected").appendTo("#" + destinationid);
        selectAll('destino', true)
    }
    function move_list_items_all(sourceid, destinationid) {
        $("#" + sourceid + " option").appendTo("#" + destinationid);
        selectAll('destino', true)
    }
</script>
<? exit(); ?>

