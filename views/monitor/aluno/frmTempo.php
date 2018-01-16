<div class="col-sm-12">
    <? //print_r($tempo); ?>
    <table class="table table-striped table-sorting table-hover">
        <thead>
            <tr>
                <td colspan="8"><h3><i class="fa fa-clock-o"></i> Tempos de Usuários</h3></td>
            </tr>
            <tr>
                <td align="center">Dias #</td>
                <td align="center">Segunda</td>
                <td align="center">Terça</td>
                <td align="center">Quarta</td>
                <td align="center">Quinta</td>
                <td align="center">Sexta</td>
                <td align="center">Sábado</td>
            </tr>
        </thead>
        <tbody>
            <? foreach($tempo as $r) {?>
            <tr>
                <td align="center" style="font-size:10px"><?=$r['TEMPO']?></td>
                <td align="center" style="font-size:10px; line-height:150%;"><?=trim(nl2br($r['SEGUNDA']))?></td>
                <td align="center" style="font-size:10px; line-height:150%;"><?=nl2br($r['TERCA'])?></td>
                <td align="center" style="font-size:10px; line-height:150%;"><?=nl2br($r['QUARTA'])?></td>
                <td align="center" style="font-size:10px; line-height:150%;"><?=nl2br($r['QUINTA'])?></td>
                <td align="center" style="font-size:10px; line-height:150%;"><?=nl2br($r['SEXTA'])?></td>
                <td align="center" style="font-size:10px; line-height:150%;"><?=nl2br($r['SABADO'])?></td>
             
            </tr>
            <? } ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
<? exit(); ?>

