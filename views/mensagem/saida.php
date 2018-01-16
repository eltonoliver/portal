<? $this->load->view('layout/header'); ?>
<script src="<?= SCL_JS ?>jquery-1.11.0.min.js"></script> 
<script type="text/javascript">
    function remover(codigo) {
        $.ajax({
            url: "<?= base_url('mensagem/excluir') ?>",
            type: "POST",
            dataType: "json",
            data: {
                codigo: codigo
            },
            success: function (data, textMessage) {
                if (data['success']) {
                    $("#excluir-" + codigo).closest('li').hide();
                }
            }

        });
    }
</script>
<div id="content">
    <div class="row">
        <!-- Menu lateral de Caixa de Entrada e Saída-->
        <?=
        $this->load->view('mensagem/menu', array(
            'tipo' => $tipo,
        ))
        ?>

        <!-- Área que vai atualizar :inicio   -->
        <div class="col-md-9" id="CarregarMensagem">
            <?= $this->load->view("mensagem/saida_listar"); ?>
        </div>
        <!-- Área que vai atualizar :final   -->
    </div>
</div>
<? $this->load->view('layout/footer'); ?>