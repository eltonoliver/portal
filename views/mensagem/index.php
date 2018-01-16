<? $this->load->view('layout/header'); ?>
<script src="<?= SCL_JS ?>jquery-1.11.0.min.js"></script> 
<script>
    $(function () {
        applyPagination();
        function applyPagination() {
            $("#paginacao a").click(function () {
                var url = $(this).attr("href");

                $.ajax({
                    type: "POST",
                    data: {
                        ajax: "1",
                        tipo: $("#tipo").val()
                    },
                    url: url,
                    beforeSend: function () {
                        $("#CarregarMensagem").html("");
                    },
                    success: function (msg) {
                        $("#CarregarMensagem").html(msg);
                        applyPagination();
                    }
                });
                return false;
            });
        }
    });

    function marcar_lida(codigo) {
        $.ajax({
            'url': "<?= base_url('mensagem/marcar_lida') ?>",
            'type': 'POST',
            'data': {
                'codigo': codigo
            }
        });
    }
</script>
<div id="content">    
    <div class="row">
        <!-- Menu Lateral de Caixa de Entrada e Saida-->
        <?= $this->load->view("mensagem/menu"); ?>

        <!-- Área que vai atualizar :inicio   -->
        <div class="col-md-9" id="CarregarMensagem">
            <?= $this->load->view("mensagem/entrada_listar"); ?>            
        </div>
        <!-- Área que vai atualizar :final   -->
    </div>
</div>
<? $this->load->view('layout/footer'); ?>