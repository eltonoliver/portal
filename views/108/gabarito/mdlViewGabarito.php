<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">Gabarito da Prova</h5>
            <small><?=$prova[0]['TITULO']?></small>
        </div>
        <div class="modal-body">
            <table width="100%" style="background: #CCC" class="no-padding">
                <tr>
                    <td align="right" width="300">
                    </td>
                    <td align="right" valign="middle">
                        Para saber qual é o gabarito correto de sua prova, verifique o código da versão conforme imagem 
                        ao lado destacada em azul.
                    </td>
                    <td align="right">
                        <img src="<?= base_url('assets/images/versao.png') ?>" width="250" />
                    </td>
                </tr>
            </table>
            <?
            $new = new Prova_lib();
            foreach ($gabarito as $l) {
                ?>
                <table width="100%" align="center"  class="no-padding">
                    <tr>
                        <?
                        $c = count($l['GABARITO']);
                        $w = (100 / $c);
                        foreach ($l['GABARITO'] as $g) {
                            ?>
                            <td style="border:1px solid #CCC; padding:5px; background: #CCC" align="center" width="<?= $w ?>%"><i><?= $g['POSICAO'] ?></i></td>
                        <? } ?>
                    </tr>
                    <tr>
                        <? foreach ($l['GABARITO'] as $g) { ?>
                            <td align="center" style="border:1px solid #CCC; padding:5px; font-size: 16px"><strong><i><?= (($g['RESPOSTA_CERTA'] != '' ) ? $new->resposta($g['RESPOSTA_CERTA']) : '*') ?></i></strong></td>
                    <? } ?>
                    </tr>
                    <tr>
                        <td valign="bottom" colspan="<?= count($l['GABARITO']); ?>" align="left"><strong style="font-size:14px"><?= $l['NUM_PROVA'] ?></strong></td>
                    </tr>
                </table>
                <? } ?>
            <br/>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger2" data-dismiss="modal">Fechar</button>
        </div>
    </div>
</div>
