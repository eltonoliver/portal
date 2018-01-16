<? foreach ($listar as $row) { ?>
    <div class="col-xs-3">
        <div class="panel panel-info">
            <div class="panel-body" style="font-size:10px">
                <div class="col-xs-12 thumbnail avatar" >
                    <img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $row['CD_PESSOA'] ?>" style="height:220px" class="media-object">
                </div>
                <?= substr($row['NM_PROFESSOR'], 0, 30) ?><br>
                <strong style="font-size:12px"><?= $row['NM_DISCIPLINA'] ?></strong>
            </div>
            <div class="panel-footer">
                <a href="<?= SCL_RAIZ ?>coordenador/professor/faltas?professor=<?= $row['CD_ALUNO'] ?>&disciplina=<?= $row['CD_DISCIPLINA'] ?>" data-toggle="frmNota"  class="btn btn-warning btn-sm" data-target="#frmNota" >Conteúdos</a>
                <a href="<?= SCL_RAIZ ?>coordenador/professor/faltas?professor=<?= $row['CD_ALUNO'] ?>&disciplina=<?= $row['CD_DISCIPLINA'] ?>" data-toggle="frmNota"  class="btn btn-info btn-sm" data-target="#frmNota" >Notas</a>
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