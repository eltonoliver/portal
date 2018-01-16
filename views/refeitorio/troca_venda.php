<?php $this->load->view('layout/header'); ?>
<script>

$(function() {

    $('.sonums').keypress(function(event) {
        var tecla = (window.event) ? event.keyCode : event.which;
        if ((tecla > 47 && tecla < 58)) return true;
        else {
            if (tecla != 8) return false;
            else return true;
        }
    });

});
</script>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    Informe o Número do Cupom para troca
                </div>
                <div class="input-group">
                    <span class="input-group-btn">
                        <input class="btn btn-info" type="submit" value="CLIQUE AQUI PARA PESQUISAR" name="pesquisa" style="height: 50px">
                            <i class="fa fa-search"></i> 
                        
                    </span>
                    <input type="text" style="height: 50px" required="required" placeholder="Informe o número do cupom" class="form-control sonums" name="cupom" id="cupom" pattern="[0-9]+$">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div id="grid">
                            
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("input[name=cupom]").change(function() { 
            $("#grid").html('<?= modal_load ?>');
            $.post("<?= SCL_RAIZ ?>refeitorio/cantina/lista_venda", {
                cupom: $(this).val()

            },
            function(valor) {
                $("#grid").html(valor);
            })
        });
        
        
         $(document).ready(function() {
            $('#celular').multiselect({
                enableFiltering: true,
                includeSelectAllOption: true
            });
        });
    });
</script>
<?php $this->load->view('layout/footer'); ?>