
<?php

function cifra($campo, $valor) {
    if ($campo == 0) {
        switch ($valor) {
            case 'AT': $tipo = '<label>Aceitação Total</label>';
                break;
            case 'AP': $tipo = '<label>Aceitação Parcial</label>';
                break;
            case 'RP': $tipo = '<label>Repetiu</label>';
                break;
            case 'RJ': $tipo = '<label>Rejeição</label>';
                break;
            default: $tipo = '<dd style="font-size:10px">Não Informado</dd>';
                break;
        }
        return($tipo);
    } elseif ($campo == 1) {
        switch ($valor) {
            case 'TQ': $tipo = 'Tranquilo';
                break;
            case 'AG': $tipo = 'Agitado';
                break;
            case 'ND': $tipo = 'Não Dormiu';
                break;
            default: $tipo = '<dd style="font-size:10px">Não Informado</dd>';
                break;
        }
        return($tipo);
    } elseif ($campo == 2) {
        switch ($valor) {
            case 'NO': $tipo = 'Normal';
                break;
            case 'NE': $tipo = 'Não evacuou';
                break;
            default: $tipo = '<dd style="font-size:10px">Não Informado</dd>';
                break;
        }
        return($tipo);
    }
}
?>

        <div class="panel-body" id="painel">
            <ul class="nav nav-pills nav-stacked col-sm-6">
                <li class="list-info"><a><i class="fa fa-coffee fa-2x pull-left"></i> COLAÇÃO<br><?= cifra(0, $diario[0]['COLACAO']); ?></a></li>
                <li class="list-primary"><a><i class="fa fa-cutlery fa-2x pull-left"></i> ALMOÇO<br>  <?= cifra(0, $diario[0]['ALMOCO']); ?> </a></li>
                <li class="list-warning"><a><i class="fa fa-flag fa-2x pull-left"></i> LANCHE<br> <?= cifra(0, $diario[0]['LANCHE']); ?> </a></li>
            </ul>
            <ul class="nav nav-pills nav-stacked col-sm-6">
                <li class="list-danger"><a><i class="fa fa-cloud fa-2x pull-left"></i> SONO / DESCANSO<br> <?= cifra(1, $diario[0]['SONO']) ?> </a></li>
                <li class="list-default"><a><i class="fa fa-male fa-2x pull-left"></i> EVACUAÇÃO<br> <?= cifra(2, $diario[0]['EVACUACAO']) ?> </a></li>
                <li class="list-default"><a><i class="fa fa-clock-o fa-2x pull-left"></i> <strong><?=$data?></strong> <br> </a></li>
            </ul>
        </div>
        <?
exit();
?>