<div class="panel-body">
<? foreach ($listar as $row) { ?>
    <div class="col-xs-3">
        <div class="panel panel-info">
            <div class="panel-body">
                <div class="col-xs-12 thumbnail avatar" style=" height:220px">
                    <img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $row['CD_ALUNO'] ?>" class="media-object">
                </div>
            </div>
            <div class="panel-heading" style="font-size:12px">
               <?= substr($row['NM_ALUNO'], 0, 22) ?><br/>
               Curso: <?=$row['NM_CURSO']?><br/>
               Série: <?=$row['NM_SERIE']?>
            </div>
            <div class="panel-footer">
                <ul class="nav nav-pills nav-stacked">
                <li class="list-default"><a href="<?= SCL_RAIZ ?>secretaria/aluno/ficha?aluno=<?= $row['CD_ALUNO'] ?>" data-toggle="frmAluno"  data-target="#frmAluno" >Ficha do Aluno</a></li>
                <li class="list-default"><a href="<?= SCL_RAIZ ?>secretaria/aluno/saude?aluno=<?= $row['CD_ALUNO'] ?>" data-toggle="frmAluno"  data-target="#frmAluno" >Informações de Saúde</a></li>
                </ul>
            </div>
        </div>
    </div>
<? } ?>
</div>
<div class="panel-footer"> 
</div>


<script>
    $('[data-toggle="frmAluno"]').on('click',
            function(e) {
                $('#frmAluno').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade" id="frmAluno"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
</script>
<? exit(); ?>

