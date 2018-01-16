<?php $this->load->view('layout/header'); ?>
<script>
    function excluir_grupo(id) {
        var url = "<?= SCL_RAIZ ?>provas/registar_infor?acao=<?= base64_encode('excluir') ?>&id=" + id;
        window.location.href = url;
    }
</script>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Acesso Negado
                </div>
                <h1>A página só pode ser acessada da escola.</h1>
            </div>
        </div>
    </div>
</div>
<script>
     $('#gridTabela').dataTable({
        "sPaginationType": "full_numbers",
        "oLanguage": {
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "sLengthMenu": "Mostrar _MENU_ por página  ",
                "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
                "sInfoEmpty": "Registro não encontrado",
                "sZeroRecords": "Não há registro",
                
            },
        "aaSorting": [[ 0, "desc" ]],  
        "bStateSave": true
    });
    
    $('[data-toggle="frmModal"]').on('click',
                function(e) {
                    $('#frmModal').remove();
                    e.preventDefault();
                    var $this = $(this)
                            , $remote = $this.data('remote') || $this.attr('href')
                            , $modal = $('<div class="modal fade" id="frmModal"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
                    $('body').append($modal);
                    $modal.modal({backdrop: 'static', keyboard: false});
                    $modal.load($remote);
                }
        );
</script>
<?php $this->load->view('layout/footer'); ?>