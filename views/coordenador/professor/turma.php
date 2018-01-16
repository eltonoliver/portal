<? foreach ($listar as $row) { ?>
    <div class="col-xs-2">
        <div class="panel panel-info">
            <div class="panel-heading" style="font-size:10px">
               <?= substr($row['NM_ALUNO'], 0, 15) ?>
            </div>
            <div class="panel-body">
                <div class="col-xs-12 thumbnail avatar" style=" height:120px">
                    <img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $row['CD_ALUNO'] ?>" class="media-object">
                </div>
            </div>
            <div class="panel-footer">
                <a href="<?= SCL_RAIZ ?>coordenador/professor/notas?aluno=<?= $row['CD_ALUNO'] ?>" data-toggle="frmNota" class="btn btn-info btn-sm" data-target="#frmNota" >Notas</a>
                <a href="<?= SCL_RAIZ ?>coordenador/professor/faltas?aluno=<?= $row['CD_ALUNO'] ?>" data-toggle="frmNota"  class="btn btn-danger btn-sm" data-target="#frmNota" >Faltas</a>
            </div>
        </div>
    </div>
<? } ?>

<script>
    $('[data-toggle="frmNota"]').on('click',
            function(e) {
                $('#frmNota').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade" id="frmNota"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
</script>




<? exit(); ?>