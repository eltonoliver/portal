<? $this->load->view('layout/header'); ?>
<div class="row">
    <div class="section-light col-lg-12 col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Demonstrativo de Notas
                        </h3>

                        <div class="panel-toolbar">
                            <div class="btn-group">
                                <form action="<?= SCL_RAIZ ?>impressao/nota/" target="_blank" method="post">                                    
                                    <input type="hidden" name="aluno" value="<?= $aluno?>" />
                                    <input type="hidden" name="tipo" value="0" />
                                    <button type="submit" class="btn btn-inverse">
                                        <i class="fa fa-print"></i> Imprimir
                                    </button>
                                </form> 
                            </div>
                        </div>
                    </div>                    
                    <div class="panel-body" style="overflow:scroll">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="font-size:11px">Disciplina</th>
                                    <th style="font-size:11px">Turma</th>

                                    <!-- 1º Bimestre -->
                                    <th class="text-center btn-success" style="font-size:11px"><?= $boletim[0]['NM_MINI_N01_1B'] ?></th>
                                    <th class="text-center btn-success" style="font-size:11px"><?= $boletim[0]['NM_MINI_N02_1B'] ?></th>
                                    <th class="text-center btn-success" style="font-size:11px"><?= $boletim[0]['NM_MINI_N03_1B'] ?></th>
                                    <th class="text-center btn-success" style="font-size:11px"><?= $boletim[0]['NM_MINI_N04_1B'] ?></th>
                                    <th class="text-center btn-success" style="font-size:11px">F</th>

                                    <!-- 2º Bimestre -->
                                    <th class="text-center btn-warning" style="font-size:11px"><?= $boletim[0]['NM_MINI_N01_2B'] ?></th>
                                    <th class="text-center btn-warning" style="font-size:11px"><?= $boletim[0]['NM_MINI_N02_2B'] ?></th>
                                    <th class="text-center btn-warning" style="font-size:11px"><?= $boletim[0]['NM_MINI_N03_2B'] ?></th>
                                    <th class="text-center btn-warning" style="font-size:11px"><?= $boletim[0]['NM_MINI_N04_2B'] ?></th>                                    
                                    <th class="text-center btn-warning" style="font-size:11px"><?= $boletim[0]['NM_MINI_N05_2B'] ?></th>
                                    <th class="text-center btn-warning" style="font-size:11px">F</th>

                                    <!-- 3º Bimestre -->
                                    <th class="text-center btn-info" style="font-size:11px"><?= $boletim[0]['NM_MINI_N01_3B'] ?></th>
                                    <th class="text-center btn-info" style="font-size:11px"><?= $boletim[0]['NM_MINI_N02_3B'] ?></th>
                                    <th class="text-center btn-info" style="font-size:11px"><?= $boletim[0]['NM_MINI_N03_3B'] ?></th>
                                    <th class="text-center btn-info" style="font-size:11px"><?= $boletim[0]['NM_MINI_N04_3B'] ?></th>                                                                        
                                    <th class="text-center btn-info" style="font-size:11px">F</th>

                                    <!-- 4º Bimestre -->
                                    <th class="text-center btn-danger" style="font-size:11px"><?= $boletim[0]['NM_MINI_N01_4B'] ?></th>
                                    <th class="text-center btn-danger" style="font-size:11px"><?= $boletim[0]['NM_MINI_N02_4B'] ?></th>
                                    <th class="text-center btn-danger" style="font-size:11px"><?= $boletim[0]['NM_MINI_N03_4B'] ?></th>
                                    <th class="text-center btn-danger" style="font-size:11px"><?= $boletim[0]['NM_MINI_N04_4B'] ?></th>                                    
                                    <th class="text-center btn-danger" style="font-size:11px"><?= $boletim[0]['NM_MINI_N05_4B'] ?></th>                                    
                                    <th class="text-center btn-danger" style="font-size:11px">F</th>                                    
                                </tr>
                            </thead>

                            <tbody>
                                <?                                
                                foreach ($boletim as $item) {
                                ?>
                                <tr>
                                    <td style="font-size:11px"><?= $item['NM_DISCIPLINA'] ?></td>
                                    <td style="font-size:11px"><?= $item['CD_TURMA'] ?></td>

                                    <!-- 1º Bimestre -->
                                    <td class="text-center btn-success" style="font-size:11px">
                                        <?= !empty($item['NOTA_N01_1B']) ? number_format($item['NOTA_N01_1B'], 1, '.', '') : '-' ?>
                                    </td>
                                    <td class="text-center btn-success" style="font-size:11px">
                                        <?= !empty($item['NOTA_N03_1B']) ? number_format($item['NOTA_N02_1B'], 1, '.', '') : '-' ?>
                                    </td>
                                    <td class="text-center btn-success" style="font-size:11px">
                                        <?= !empty($item['NOTA_N03_1B']) ? number_format($item['NOTA_N03_1B'], 1, '.', '') : '-' ?>
                                    </td>
                                    <td class="text-center btn-success" style="font-size:11px">
                                        <?= !empty($item['NOTA_N04_1B']) ? number_format($item['NOTA_N04_1B'], 1, '.', '') : '-' ?>
                                    </td>                                        
                                    <td class="text-center btn-success" style="font-size:11px">
                                        <?= !empty($item['FALTAS_1B']) ? $item['FALTAS_1B'] : '-' ?>
                                    </td>

                                    <!-- 2º Bimestre -->
                                    <td class="text-center btn-warning" style="font-size:11px">
                                        <?= !empty($item['NOTA_N01_2B']) ? number_format($item['NOTA_N01_2B'], 1, '.', '') : '-' ?>
                                    </td>
                                    <td class="text-center btn-warning" style="font-size:11px">
                                        <?= !empty($item['NOTA_N03_2B']) ? number_format($item['NOTA_N02_2B'], 1, '.', '') : '-' ?>
                                    </td>
                                    <td class="text-center btn-warning" style="font-size:11px">
                                        <?= !empty($item['NOTA_N03_2B']) ? number_format($item['NOTA_N03_2B'], 1, '.', '') : '-' ?>
                                    </td>
                                    <td class="text-center btn-warning" style="font-size:11px">
                                        <?= !empty($item['NOTA_N04_2B']) ? number_format($item['NOTA_N04_2B'], 1, '.', '') : '-' ?>
                                    </td>                                        
                                    <td class="text-center btn-warning" style="font-size:11px">
                                        <?= !empty($item['NOTA_N05_2B']) ? number_format($item['NOTA_N05_2B'], 1, '.', '') : '-' ?>
                                    </td>                                        
                                    <td class="text-center btn-warning" style="font-size:11px">
                                        <?= !empty($item['FALTAS_2B']) ? $item['FALTAS_2B'] : '-' ?>
                                    </td>

                                    <!-- 3º Bimestre -->
                                    <td class="text-center btn-info" style="font-size:11px">
                                        <?= !empty($item['NOTA_N01_3B']) ? number_format($item['NOTA_N01_3B'], 1, '.', '') : '-' ?>
                                    </td>
                                    <td class="text-center btn-info" style="font-size:11px">
                                        <?= !empty($item['NOTA_N03_3B']) ? number_format($item['NOTA_N02_3B'], 1, '.', '') : '-' ?>
                                    </td>
                                    <td class="text-center btn-info" style="font-size:11px">
                                        <?= !empty($item['NOTA_N03_3B']) ? number_format($item['NOTA_N03_3B'], 1, '.', '') : '-' ?>
                                    </td>
                                    <td class="text-center btn-info" style="font-size:11px">
                                        <?= !empty($item['NOTA_N04_3B']) ? number_format($item['NOTA_N04_3B'], 1, '.', '') : '-' ?>
                                    </td>                                        
                                    <td class="text-center btn-info" style="font-size:11px">
                                        <?= !empty($item['FALTAS_3B']) ? $item['FALTAS_3B'] : '-' ?>
                                    </td>

                                    <!-- 4º Bimestre -->
                                    <td class="text-center btn-danger" style="font-size:11px">
                                        <?= !empty($item['NOTA_N01_4B']) ? number_format($item['NOTA_N01_4B'], 1, '.', '') : '-' ?>
                                    </td>
                                    <td class="text-center btn-danger" style="font-size:11px">
                                        <?= !empty($item['NOTA_N02_4B']) ? number_format($item['NOTA_N02_4B'], 1, '.', '') : '-' ?>
                                    </td>
                                    <td class="text-center btn-danger" style="font-size:11px">
                                        <?= !empty($item['NOTA_N03_4B']) ? number_format($item['NOTA_N03_4B'], 1, '.', '') : '-' ?>
                                    </td>
                                    <td class="text-center btn-danger" style="font-size:11px">
                                        <?= !empty($item['NOTA_N04_4B']) ? number_format($item['NOTA_N04_4B'], 1, '.', '') : '-' ?>
                                    </td>                                        
                                    <td class="text-center btn-danger" style="font-size:11px">
                                        <?= !empty($item['NOTA_N05_4B']) ? number_format($item['NOTA_N05_4B'], 1, '.', '') : '-' ?>
                                    </td>                                        
                                    <td class="text-center btn-danger" style="font-size:11px">
                                        <?= !empty($item['FALTAS_4B']) ? $item['FALTAS_4B'] : '-' ?>
                                    </td>
                                </tr>
                                <? } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-alt btn-success">1º BIMESTRE</button>
                        <button type="button" class="btn btn-alt btn-warning">2º BIMESTRE</button>
                        <button type="button" class="btn btn-alt btn-info">3º BIMESTRE</button>
                        <button type="button" class="btn btn-alt btn-danger">4º BIMESTRE</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<? $this->load->view('layout/footer'); ?>
<? exit(); ?>