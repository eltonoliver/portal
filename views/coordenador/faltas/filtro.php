<style>
.text-vertical {
    /* Safari */
-webkit-transform: rotate(-90deg);

/* Firefox */
-moz-transform: rotate(-90deg);

/* IE */
-ms-transform: rotate(-90deg);

/* Opera */
-o-transform: rotate(-90deg);

/* Internet Explorer */
filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);

}

</style>
<?

 $nome = array();
$disciplina = array();
foreach($listar as $row){
    $nome[] = $row['NM_ALUNO']; 
    $disciplina[] = $row['NM_DISCIPLINA'];
}




$nome = array_unique($nome);
$disciplina = array_unique($disciplina);
?>
    <div class="col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading" style="font-size:10px">
               <?=$titulo ?>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview" name="gridview">
                    <thead>
                        <tr>
                            <th> Aluno</th>
                            <?php
                        if (count($aulas) > 0) {
                            foreach ($aulas as $aula) {
                                ?>
                            <th style="font-size:10px; text-align: center"  width="5%"> <?=$aula['TEMPO_AULA']?>º<br/> <?=$aula['NM_DISCIPLINA']?></th>
                        <? }}?>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php
                        if (count($nome) > 0) {
                            foreach ($nome as $row) {
                                ?>
                                <tr>
                                    <td><i class="fa fa-user 2x"></i> <?=$row?> </td>
                                    <? 
                                    foreach($disciplina as $d) { 
                                        foreach($listar as $l){
                                            if(($row == $l['NM_ALUNO']) && ($d == $l['NM_DISCIPLINA'])){
                                        ?>
                                    <td style="text-align:center" class="center <? if($l['FLG_PRESENTE'] == 'S') echo 'success'; else echo 'danger';?>"><?=$l['FLG_PRESENTE']?></td>
                                    <? } } }?>
                                </tr>
                        <?php } } ?>
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
            
            </div>
        </div>
    </div>

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