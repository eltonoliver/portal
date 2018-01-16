<!-- Nav tabs-->
<ul role="tablist" class="nav nav-tabs">
    <li role="presentation" class="active">
        <a href="#tab01" aria-controls="home" data-toggle="tab">QUESTÕES TOTAIS</a>
    </li>
    <li role="presentation" class="">
        <a href="#tab02" aria-controls="home" data-toggle="tab">QUESTÕES LIVRES</a>
    </li>
    <li role="presentation" class="">
        <a href="#tab03" aria-controls="home" data-toggle="tab">QUESTÕES USADAS</a>
    </li>
</ul>
<!-- Tab panes-->
<div class="tab-content">                               
    <div role="tabpanel" id="tab01" class="tab-pane active">
        <table class="table table-striped table-hover">
            <tbody>
                <tr>
                    <td>DISCIPLINA</td>
                    <td>TEMA</td>
                    <td align="center">TOTAL</td>
                </tr>
            </tbody>
            <tbody>
                <?
                foreach ($total as $q) {
                    ?>
                    <tr>
                        <td><?= $q['NM_DISCIPLINA'] ?></td>
                        <td><?= $q['DC_TEMA'] ?></td>
                        <td align="center"><?= $q['TOTAL'] ?></td>
                    </tr>
                <? } ?>
            </tbody>
        </table>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab02">
        <table class="table table-striped table-hover">
            <tbody>
                <tr>
                    <td>DISCIPLINA</td>
                    <td>TEMA</td>
                    <td align="center">TOTAL</td>
                </tr>
            </tbody>
            <tbody>
                <?
                foreach ($livres as $r) {
                    ?>
                    <tr>
                        <td><?= $r['NM_DISCIPLINA'] ?></td>
                        <td><?= $r['DC_TEMA'] ?></td>
                        <td align="center"><?= $r['TOTAL'] ?></td>
                    </tr>
                <? } ?>
            </tbody>
        </table>
    </div>
    <div role="tabpanel" class="tab-pane" id="tab03">
        <table class="table table-striped table-hover">
            <tbody>
                <tr>
                    <td>DISCIPLINA</td>
                    <td>TEMA</td>
                    <td align="center">TOTAL</td>
                </tr>
            </tbody>
            <tbody>
                <?
                foreach ($usadas as $u) {
                    ?>
                    <tr>
                        <td><?=$u['NM_DISCIPLINA'] ?></td>
                        <td><?=$u['DC_TEMA'] ?></td>
                        <td align="center"><?=$u['TOTAL'] ?></td>
                    </tr>
                <? } ?>
            </tbody>
        </table>
    </div>
</div>