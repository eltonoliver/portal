<?php
$ver = true;
if ($ver == true) {
    ?>

    <div class="row">
        <div class="section-light col-lg-12 col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Boletim</h3>
                            <div class="panel-toolbar">
                                <div class="btn-group">
                                    <form action="<?= site_url("impressao/nota/") ?>" target="_blank" method="post">
                                        <input type="hidden" name="aluno" value="<?= $aluno ?>" />
                                        <input type="hidden" name="tipo" value="1" />
                                        <button type="submit" class="btn btn-inverse">
                                            <i class="fa fa-print"></i> Imprimir
                                        </button>
                                    </form> 
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="font-size:11px">Disciplina</th>
                                        <th style="font-size:11px">Turma</th>

                                        <th class="text-center btn-success" style="font-size:11px">MÉDIA</th>
                                        <th class="text-center btn-success" style="font-size:11px">FALTA</th>
                                        <th class="text-center btn-warning" style="font-size:11px">MÉDIA</th>
                                        <th class="text-center btn-warning" style="font-size:11px">FALTA</th>
                                        <th class="text-center btn-info" style="font-size:11px">MÉDIA</th>
                                        <th class="text-center btn-info" style="font-size:11px">FALTA</th>
                                        <th class="text-center btn-default" style="font-size:11px">MÉDIA</th>
                                        <th class="text-center btn-default" style="font-size:11px">FALTA</th>

                                        <th class="text-center btn-default" style="font-size:11px">MEDIA ANUAL</th>
                                        <th class="text-center btn-default" style="font-size:11px;">NRF</th>
                                        <th class="text-center btn-default" style="font-size:11px;">MARF</th>
                                        <th class="text-center btn-default" style="font-size:11px;">MACC</th>

                                        <th class="text-center btn-default" style="font-size:11px;">SITUAÇÃO</th>
                                    </tr>
                                </thead>
                                <tbody style="color:#000"><? #print_r($boletim); ?>
                                    <?

                                    foreach ($boletim as $item) {
                                    ?>
                                    <tr >
                                        <td style="font-size:11px"><?= $item['NM_DISCIPLINA'] ?></td>
                                        <td style="font-size:11px"><?= $item['CD_TURMA'] ?></td>

                                        <td class="text-center" style="font-size:11px"><? if (!empty($item['NOTA_N01_1B'])) echo number_format($item['NOTA_N01_1B'], 1, '.', '');
                                            else '-'; ?></td>
                                        <td class="text-cente" style="font-size:11px"><? if (!empty($item['FALTAS_1B'])) echo $item['FALTAS_1B'];
                                            else echo '0'; ?></td>


                                        <td class="text-center" style="font-size:11px"><? if ($item['NOTA_N01_2B'] != '') echo number_format($item['NOTA_N01_2B'], 1, '.', '');
                                            else echo ' - '; ?></td>
                                        <td class="text-cent" style="font-size:11px"><? if (!empty($item['FALTAS_2B'])) echo $item['FALTAS_2B'];
                                            else echo '0'; ?></td>


                                        <td class="text-center" style="font-size:11px"><? if ($item['NOTA_N01_3B'] != '') echo number_format($item['NOTA_N01_3B'], 1, '.', '');
                                            else echo ' - '; ?></td>
                                        <td class="text-cente" style="font-size:11px"><? if (!empty($item['FALTAS_3B'])) echo $item['FALTAS_3B'];
                                            else echo '0'; ?></td>


                                        <td class="text-cente" style="font-size:11px"><? if ($item['NOTA_N01_4B'] != '') echo number_format($item['NOTA_N01_4B'], 1, '.', '');
                                            else echo ' - '; ?></td>
                                        <td class="text-center" style="font-size:11px"><? if (!empty($item['FALTAS_4B'])) echo $item['FALTAS_4B'];
                                            else echo '0'; ?></td>


                                        <td class="text-center" style="font-size:11px">
                                            <strong>
                                                <? if (!empty($item['NOTA_MF']))

                                                echo $item['NOTA_MF'];
                                                else 
                                                echo '-'; ?></strong></td>
                                                
                                                
                                       <? if($item['CD_CURSO'] == 2){  ?>

                                            <td class="text-center" style="font-size:11px;">
                                                <? if (!empty($item['NOTA_RF'])) echo $item['NOTA_RF']; else echo '-'; ?>
                                            </td>
                                            <td class="text-center" style="font-size:11px;">
                                                <? if (!empty($item['NOTA_MARF'])) echo $item['NOTA_MARF']; else echo '-'; ?>
                                            </td>
                                            <td class="text-center" style="font-size:11px;">
                                                <?  echo number_format((($item['NOTA_MACC'] != $item['NOTA_MARF']) ? $item['NOTA_MACC'] : '-'), 1, '.', ''); ?>
                                            </td>
                                            <td class="text-center" style="font-size:11px;">
                                                <? if (!empty($item['DC_SITUACAO'])) echo $item['DC_SITUACAO']; else echo ''; ?>
                                                <?= (($item['NOTA_MACC'] != $item['NOTA_MARF']) ? ' ' : '' ); ?>
                                            </td>
                                        
                                        <? }else{ ?>
                                        
                                                <td class="text-center" style="font-size:11px;">
                                                    <? if (!empty($item['NOTA_RF'])) echo $item['NOTA_RF']; else echo '-'; ?>
                                                </td>
                                                <td class="text-center" style="font-size:11px;">
                                                    <? if (!empty($item['NOTA_MARF'])) echo $item['NOTA_MARF']; else echo '-'; ?>
                                                </td>
                                                <td class="text-center" style="font-size:11px;">
                                                    <?  echo number_format((($item['NOTA_MACC'] != $item['NOTA_MARF']) ? $item['NOTA_MACC'] : '-'), 1, '.', ''); ?>
                                                </td>
                                                <td class="text-center" style="font-size:11px;">
                                                    <? if (!empty($item['DC_SITUACAO'])) echo $item['DC_SITUACAO']; else echo ''; ?>                                         
                                                    <?=(($item['NOTA_MACC'] != $item['NOTA_MARF']) ? ' ' : '' ); ?>
                                                </td>
                                        
                                        <? } ?>

                                    </tr>
                                    <? } ?>
                                </tbody>
                            </table>
                            <div class="panel-footer">
                                <button type="button" class="btn btn-alt btn-success">1º BIMESTRE</button>
                                <button type="button" class="btn btn-alt btn-warning">2º BIMESTRE</button>
                                <button type="button" class="btn btn-alt btn-info">3º BIMESTRE</button>
                                <button type="button" class="btn btn-alt btn-default">4º BIMESTRE</button>

                                <button type="button" class="btn btn-alt btn-default">MF - Média Final</button>
                                <button type="button" class="btn btn-alt btn-default">NRF - Nota Recuperação Final</button>
                                <button type="button" class="btn btn-alt btn-default">MARF - Média Anual Recuperação Final</button>
                                <button type="button" class="btn btn-alt btn-default">MACC - Média Após Conselho de Classe</button>

                                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Voltar</button>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

<?php } ?>
<?php exit(); ?>