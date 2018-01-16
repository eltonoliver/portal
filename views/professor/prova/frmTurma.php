<?php $this->load->view('layout/header'); ?>

<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h1 class="panel-title text-left">Demonstrativo de Notas :: <?=$row->CD_TURMA . ' - ' . $row->NM_DISCIPLINA?></h1>
                </div>
                <table class='table table-hover'>
                    <thead>
                        <tr>
                            <td class='border-right' colspan='2' valign='center'></td>
                            <td class='border-right' colspan='4' align='center'>1º BIMESTRE</td>
                            <td class='border-right' colspan='4' align='center'>2º BIMESTRE</td>
                            <td class='border-right' colspan='4' align='center'>3º BIMESTRE</td>
                            <td class='border-right' colspan='4' align='center'>4º BIMESTRE</td>
                        </tr>
                        <tr>
                            <td valign='center'>MATRÍCULA</td>
                            <td class='border-right' valign='center' class="sorting_asc">ALUNO</td>
                            <td align='center' class="sorting_desc_disabled">P1</td>
                            <td align='center' class="sorting_desc_disabled">P2</td>
                            <td align='center' class="sorting_desc_disabled">MAIC</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                            <td align='center' class="sorting_desc_disabled">P1</td>
                            <td align='center' class="sorting_desc_disabled">P2</td>
                            <td align='center' class="sorting_desc_disabled">MAIC</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                            <td align='center' class="sorting_desc_disabled">P1</td>
                            <td align='center' class="sorting_desc_disabled">P2</td>
                            <td align='center' class="sorting_desc_disabled">MAIC</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                            <td align='center' class="sorting_desc_disabled">P1</td>
                            <td align='center' class="sorting_desc_disabled">P2</td>
                            <td align='center' class="sorting_desc_disabled">MAIC</td>
                            <td class='border-right bg-primary sorting_desc_disabled' align='center'>MBF</td>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach ($lista as $l) {
                                ?>
                                <tr class="<?=(($l['STATUS'] == 1)? 'bg-success' : 'bg-danger')?>" style="font-size:12px">
                                    <td><?= $l['CD_ALUNO'] ?></td>
                                    <td class='border-right'><?= $l['NM_ALUNO'] ?></td>
                                    
                                    <td align='center' class="<?= (($l['BIMESTRE'][1]['P1'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][1]['P1'] != '') ? number_format($l['BIMESTRE'][1]['P1'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][1]['P2'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][1]['P2'] != '') ? number_format($l['BIMESTRE'][1]['P2'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][1]['MAIC'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][1]['MAIC'] != '') ? number_format($l['BIMESTRE'][1]['MAIC'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="bg-primary border-right" ><strong><?= (($l['BIMESTRE'][1]['MBF'] != '') ? number_format($l['BIMESTRE'][1]['MBF'], 1, '.', '') : '-') ?></strong></td>

                                    <td align='center' class="<?= (($l['BIMESTRE'][2]['P1'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][2]['P1'] != '') ? number_format($l['BIMESTRE'][2]['P1'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][2]['P2'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][2]['P2'] != '') ? number_format($l['BIMESTRE'][2]['P2'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][2]['MAIC'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][2]['MAIC'] != '') ? number_format($l['BIMESTRE'][2]['MAIC'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="bg-primary border-right" ><strong><?= (($l['BIMESTRE'][2]['MBF'] != '') ? number_format($l['BIMESTRE'][2]['MBF'], 1, '.', '') : '-') ?></strong></td>

                                    <td align='center' class="<?= (($l['BIMESTRE'][3]['P1'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][3]['P1'] != '') ? number_format($l['BIMESTRE'][3]['P1'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][3]['P2'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][3]['P2'] != '') ? number_format($l['BIMESTRE'][3]['P2'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][3]['MAIC'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][3]['MAIC'] != '') ? number_format($l['BIMESTRE'][3]['MAIC'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="bg-primary border-right" ><strong><?= (($l['BIMESTRE'][3]['MBF'] != '') ? number_format($l['BIMESTRE'][3]['MBF'], 1, '.', '') : '-') ?></strong></td>

                                    <td align='center' class="<?= (($l['BIMESTRE'][4]['P1'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][4]['P1'] != '') ? number_format($l['BIMESTRE'][4]['P1'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][4]['P2'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][4]['P2'] != '') ? number_format($l['BIMESTRE'][4]['P2'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="<?= (($l['BIMESTRE'][4]['MAIC'] >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l['BIMESTRE'][4]['MAIC'] != '') ? number_format($l['BIMESTRE'][4]['MAIC'], 1, '.', '') : '-') ?></strong></td>
                                    <td align='center' class="bg-primary border-right" ><strong><?= (($l['BIMESTRE'][4]['MBF'] != '') ? number_format($l['BIMESTRE'][4]['MBF'], 1, '.', '') : '-') ?></strong></td>
                                </tr>
                            <? } ?>
                    </tbody>
                </table>                
            </div>
        </div>
        <div class="col-sm-4">
            <table class='table table-striped'>
                <thead>
                    <tr> 
                        <td class='border-left' colspan='3'>
                            <strong>1º BIMESTRE</strong>
                        </td>
                    </tr>
                    <tr class="bg-primary">
                        <td valign='center'>PROVA</td>
                        <td class='border-right' valign='center'>DATA</td>
                        <td valign='center'>NOTA</td>
                        <td valign='center'></td>
                    </tr>
                </thead>
                <tbody>
                    <? foreach ($provas as $p) { ?>
                        <tr data-toggle="Token" style="font-size:12px; cursor: pointer" data-token="<?=base64_encode(json_encode($p))?>">
                            <td><?= $p->NUM_PROVA?></td>
                            <td class='border-right'><?= date('d/m/Y', strtotime(implode("-", array_reverse(explode("/",$p->DT_PROVA)))))?></td>
                            <td><?= $p->NM_MINI?></td>
                            <td>
                                
                            </td>
                        </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
        <div class="col-sm-8 well">
            <fieldset id="resultado">
               
            </fieldset>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('[data-toggle="frmModal"]').on('click', function (e) {
        $('#frmModal').remove();
        e.preventDefault();
        var $this = $(this)
                , $remote = $this.data('remote') || $this.attr('href')
                , $modal = $('<div class="modal fade" id="frmModal"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
        $('body').append($modal);
        $modal.modal({backdrop: 'static', keyboard: false});
        $modal.load($remote);
    });
    $('[data-toggle="Token"]').on('click', function (e) {
        var token = $(this).data('token');
        $("#resultado").html('<small>Carregando...</small>');
        $.ajax({
            type: "POST",
            url: "<?= base_url('professor/provas/frmTurmaProvaResultado') ?>",
            data: {
                token : token
            },
            success: function (data) {
                $("#resultado").html(data);
            }
        });
    });
</script>
<?php $this->load->view('layout/footer'); ?>