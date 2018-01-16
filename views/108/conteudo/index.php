<script type="text/javascript">
    function atualizar(id) {
        $("#tblConteudoGrid").html('<?= LOAD ?>');
        $.post("<?= base_url('108/conteudo/gridConteudo') ?>", {
            tema: id
        },
        function (valor) {
            $("#tblConteudoGrid").html(valor);
        });
    }
</script>

<div id="modal-conteudo" class="modal-dialog">
    <div class="color-line"></div>

    <div class="modal-content">
        <div class="modal-header">
            <h4><?= $titulo ?></h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-xs-4 form-group">
                    <label>Curso</label>
                    <input disabled class="form-control" value="<?= $tema->NM_CURSO ?>"> 
                </div>

                <div class="col-xs-4 form-group">
                    <label>Série</label>
                    <input disabled class="form-control" value="<?= $tema->NM_SERIE ?>"> 
                </div>

                <div class="col-xs-4 form-group">
                    <label>Disciplina</label>
                    <input disabled class="form-control" value="<?= $tema->NM_DISCIPLINA ?>"> 
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    <label>Tema</label>
                    <input disabled class="form-control" value="<?= $tema->DC_TEMA ?>"> 
                </div>                
            </div>

            <div id="tblConteudoGrid" style="overflow: auto; height: 200px">
                <?= $this->load->view("108/conteudo/gridConteudo", null, true) ?>
            </div>
        </div>

        <div class="modal-footer">
            <a id="btnTemaView" class="btn btn-info pull-left" href="<?= base_url('108/conteudo/modalConteudo?tema=' . $tema->CD_TEMA . '&operacao=I') ?>" data-toggle="frmModalConteudo">
                <i class="fa fa-plus"></i> Adicionar Conteúdo
            </a>

            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>

    <script type="text/javascript">
        $('#modal-conteudo').on('click', '[data-toggle="frmModalConteudo"]',
                function (e) {
                    $('#frmModalConteudo').remove();
                    e.preventDefault();
                    var $this = $(this)
                            , $remote = $this.data('remote') || $this.attr('href')
                            , $modal = $('<div class="modal fade"  id="frmModalConteudo"  tabindex="-1" role="dialog" style="background: url(<?= base_url('assets/images/bgmodal.png') ?>)" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
                    $('body').append($modal);
                    $modal.modal({backdrop: 'static', keyboard: false});
                    $modal.load($remote);
                }
        );
    </script>
</div>