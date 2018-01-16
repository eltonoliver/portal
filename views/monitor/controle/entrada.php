<div class="panel-body">
    <ul  class="list-unstyled friend-list nav nav-pills nav-stacked"  style="height:350px; overflow:scroll">
        <? foreach ($pessoa as $row) { ?>
            <li class='list-warning'>
                <a style="font-size:11px">
                    <span class="label label-success"><?= $row['DT_HR_ACESSO'] ?></span>
                    <img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $row['CD_USUARIO'] ?>">
                    <?= $row['CD_USUARIO'] ?> - <?= substr($row['NM_USUARIO'], 0, 25) ?>..
                </a>
            </li>
        <? } ?>
    </ul>
</div>
<div class="panel-footer">
    <div href="#" class="btn btn-primary">Total de Pessoas: <?=count($pessoa)?></div>
</div>
<? exit(); ?>

