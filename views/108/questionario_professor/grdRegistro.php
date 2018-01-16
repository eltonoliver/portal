<table class="display table table-hover" id="tblGrid">
    <?
    $pro = '';
    $dic = '';
    foreach ($lista as $row) {
        $al = ($row['MUITO_SATISFEITO'] +
                $row['INSUFICIENTE'] +
                $row['REGULAR'] +
                $row['BOM'] +
                $row['EXCELENTE']
                );

        if ($pro != $row['CD_PROFESSOR'] || $dic != $row['CD_DISCIPLINA']) {
            $pro = $row['CD_PROFESSOR'];
            $dic = $row['CD_DISCIPLINA'];
            ?>
            <tr class="panel-footer">
                <td colspan="6"><strong><?= $row['NM_PROFESSOR'] . ' - ' . $row['NM_DISCIPLINA'] ?></strong></td>
            </tr>
            <tr class="panel-footer">
                <td><br><strong>PERGUNTA</strong></td>
                <td align="center"> MUITO <br>INSATISFEITO</td>
                <td align="center" valign="botton"> <br>INSUFICIENTE</td>
                <td align="center"> <br>REGULAR</td>
                <td align="center"> <br>BOM</td>
                <td align="center"> <br>EXCELENTE</td>
            </tr>
        <? } ?>

        <?php
        $corLinha = "";
        switch ($row['BIMESTRE']) {
            case 1:
                $corLinha = "success";
                break;
            case 2:
                $corLinha = "warning";
                break;
            case 3:
                $corLinha = "info";
                break;
            case 4:
                $corLinha = "danger";
                break;
            default:
                $corLinha = "";
        }
        ?>
        <tr class="<?= !empty($corLinha) ? $corLinha : "" ?>">
            <td><?= $row['DC_PERGUNTA'] ?></td>
            <td align="center"><?= number_format(($row['MUITO_SATISFEITO'] * 100) / $al, 1, '.', '') ?>%</td>
            <td align="center"><?= number_format(($row['INSUFICIENTE'] * 100) / $al, 1, '.', '') ?>%</td>
            <td align="center"><?= number_format(($row['REGULAR'] * 100) / $al, 1, '.', '') ?>%</td>
            <td align="center"><?= number_format(($row['BOM'] * 100) / $al, 1, '.', '') ?>%</td>
            <td align="center"><?= number_format(($row['EXCELENTE'] * 100) / $al, 1, '.', '') ?>%</td>
        </tr>
    <? } ?>
</table>

<div class="row">        
    <div class="col-md-6 pull-left">
        <label>Legenda:</label>
        <button class="btn alert-success">1º Bimestre</button>
        <button class="btn alert-warning">2º Bimestre</button>
        <button class="btn alert-info">3º Bimestre</button>
        <button class="btn alert-danger">4º Bimestre</button>    
    </div>

    <div class="col-md-6 pull-right text-right">        
        <a class="btn btn-primary" href="<?= $urlRelatorio ?>" target="_blank" data-method="post">
            Gerar Relatório
        </a>    
    </div>
</div>

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript">
    $('[data-toggle="frmModalInfo"]').on('click',
            function (e) {
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