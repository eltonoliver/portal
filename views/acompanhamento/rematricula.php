<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <script type="text/javascript">
            function validarForm() {
                $("#RemResposta").html('<img src="<?=base_url('assets/images/loader.gif')?>" id="preload">');
                $.post("<?= base_url('acompanhamento/frmManterRematricula/' . $rematricula[0]['CD_ALUNO'] . '') ?>", {},
                function(valor) {
                    $("#RemResposta").html(valor);
                    location.reload();
                });
            };
        </script>
        <div class="modal-header btn-info">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-refresh"></i> Requitimento de Renovação de Matrícula</h4>
        </div>
        <div class="panel-body">
            <iframe src="<?= base_url('acompanhamento/SolicitacaoRematricula/' . $rematricula[0]['CD_ALUNO'] . '') ?>" frameborder="0" height="300" width="100%" ></iframe>
            <img src="<?=base_url('assets/images/loader.gif')?>" id="preload">
            <script language="javascript">
            $('iframe').css('display', 'none');
            $('iframe').load(function() {
            $('iframe').css('display', 'block');
            $('#preload').css('display', 'none');
            });
            </script>
        </div>
        <div id="RemResposta">

        </div>
        <div class="modal-footer text-center text-cente">
            <strong>Aceitar a Renovação de Matrícula? </strong><br/>
            <button class="btn btn-danger" data-dismiss="modal" id="frmarquivo_btn" ><i class="fa fa-refresh"></i> Não Aceito </button>
            <button onclick="validarForm()" class="btn btn-success"><i class="fa fa-hand-o-up"></i> Aceito </button>
        </div>            
    </div>
</div>
<? exit(); ?>

