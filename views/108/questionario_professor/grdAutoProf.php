<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    
        <?
        function conceito($p){
            switch ($p){
                case 1: $c = '1 - MUITO INSATISFEITO'; break;
                case 2: $c = 'INSUFICIENTE'; break;
                case 3: $c = 'REGULAR'; break;
                case 4: $c = 'BOM'; break;
                case 5: $c = 'EXCELENTE'; break;
                default:
                    $c = '-';
                break;
            }
            return ($c);
        }

        $ar = array();
        foreach ($listar as $row) {
           $ar[] = $row['CD_PROFESSOR'];
        }
        $pro = array_keys(array_flip($ar));
        
        $list = array();
        foreach ($ar as $q) {
            $list[$q]['codigo'] = $q;            
            foreach ($listar as $row) {
                if($q == $row['CD_PROFESSOR']){
                    $list[$q]['nome'] = $row['NM_PROFESSOR'];
                    $list[$q]['pergunta'][$row['CD_PERGUNTA']] = $row;
                }
            }
        }
        
        foreach ($list as $row) {
        ?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$row['codigo']?>" aria-expanded="false" aria-controls="collapse<?=$row['codigo']?>" class="collapsed">
                    <?= $row['codigo'] .' - '. $row['nome']?>
                </a>
            </h4>
        </div>
            <div id="collapse<?=$row['codigo']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$row['codigo']?>" aria-expanded="false" style="height: 0px;">
                <div class="panel-body">
                    <table class="table table-hover">
                        <tr class="panel-footer">
                            <td><strong>PERGUNTA</strong></td>
                            <td align="center">1º BIMESTRE</td>
                            <td align="center">2º BIMESTRE</td>
                            <td align="center">3º BIMESTRE</td>
                            <td align="center">4º BIMESTRE</td>
                        </tr>
                        <? foreach($row['pergunta'] as $q){ ?>
                        <tr>
                            <td><?= $q['DC_PERGUNTA']?></td>
                            <td align="center"><?=conceito($q['B1'])?></td>
                            <td align="center"><?=conceito($q['B2'])?></td>
                            <td align="center"><?=conceito($q['B3'])?></td>
                            <td align="center"><?=conceito($q['B4'])?></td>
                        </tr>
                        <? } ?>
                    </table>
                </div>
            </div>
        </div>
<? } ?>
</div>
        





<script src="<?=base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
<script type="text/javascript">
$('[data-toggle="frmModalInfo"]').on('click',
        function(e) {
            $('#frmModalInfo').remove();
            e.preventDefault();
            var $this = $(this)
                    , $remote = $this.data('remote') || $this.attr('href')
                    , $modal = $('<div class="modal fade hmodal-danger no-padding"  id="frmModalInfo"  tabindex="-1" role="dialog" ><div class="modal-dialog no-padding" ><div class="modal-content no-padding"></div></div></div>');
            $('body').append($modal);
            $modal.modal({backdrop: 'static', keyboard: false});
            $modal.load($remote);
        }
);
</script>