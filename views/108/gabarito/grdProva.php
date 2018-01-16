<? //print_r($resultado);?>

<table class="display table table-striped table-hover" id="tblGrid">
    <thead>
        <tr class="panel-footer">
            <td><strong>ID</strong></td>
            <td><strong>N. PROVA</strong></td>
            <td><strong>DISCIPLINA</strong></td>
            <td align="center"><strong>CH</strong></td>
            <td align="center"><strong>QUESTÕES</strong></td>
            <td align="center"><strong>ALUNOS</strong></td>
            <td align="center"><strong>VERSÕES</strong></td>
            <td align="center"><strong>NOTA</strong></td>
            <td><strong>STATUS</strong></td>
            <td align="center"><strong>AÇÕES</strong></td>
        </tr>
    </thead>
    <tbody>
        <?
        $new = new Prova_lib();
        foreach ($resultado as $row) {
            ?>
            <tr>
                <td><?= $row['CD_PROVA'] ?></td>
                <td><?= $row['NUM_PROVA'] ?></td>
                <td><?= $row['DISCIPLINAS'] ?></td>
                <td align="center"><?= $row['CHAMADA'].'ª'?></td>
                <td align="center"><?= $row['QUESTOES'] ?></td>
                <td align="center"><?= $row['ALUNOS'] ?></td>
                <td align="center"><?= $row['VERSOES'] ?></td>
                <td align="center"><?= $row['NM_MINI'] ?></td>
                <td align="center"><?= $new->prova_status($row['CD_STATUS'])?></td>
                <td class="text-center">
                    <? if($row['RESPOSTAS'] == ''){?>
                        <a class="btn btn-success btn-xs" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_gabarito/mdlGabaritarProvaSelecionarVersao/'.$row['CD_PROVA'].'')?>" data-toggle="frmModalFull">
                            <i class="fa fa-check-circle"></i> Gabaritar
                        </a>
                    <? }else{ ?>
                        <a class="btn btn-warning btn-xs" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_gabarito/mdlGabaritarProvaSelecionarVersao/'.$row['CD_PROVA'].'')?>"  data-toggle="frmModalFull">
                            <i class="fa fa-search"></i> Visualizar
                        </a>
                    <? } ?>
                        <a class="btn btn-info btn-xs" target="_blank" href="https://www.seculomanaus.com.br/gestordeprovas/banco/gabarito/frmImprimir/?id=<?= base64_encode($row['CD_PROVA'])?>">
                            <i class="fa fa-search"></i> Gabarito Geral
                        </a>
                    
                        <a class="btn btn-warning btn-xs" target="_blank" href="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_gabarito/avaliacao/?id='.base64_encode($row['CD_PROVA']).'')?>" type="button">
                            <i class="fa fa-eye"></i> PROVA CORRIGIDA
                        </a>
                    
                </td>
            </tr>
        <? } ?>
    </tbody>
    <tfoot>
        <tr class="panel-footer">
            <td colspan="11">
            </td>
        </tr>
    </tfoot>
</table>

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
    
$('[data-toggle="frmModalFull"]').on('click',
        function(e) {
            $('#frmModalFull').remove();
            e.preventDefault();
            var $this = $(this)
                    , $remote = $this.data('remote') || $this.attr('href')
                    , $modal = $('<div class="modal fade hmodal-danger no-padding"  id="frmModalFull"  tabindex="-1" role="dialog" ><div class="modal-dialog" ><div class="modal-content"></div></div></div>');
            $('body').append($modal);
            $modal.modal({backdrop: 'static', keyboard: false});
            $modal.load($remote);
        }
);
</script>