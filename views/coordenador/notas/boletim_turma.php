<div class="row">
    <div class="section-light col-lg-12 col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Boletim</h3>
                        <div class="panel-toolbar">
                            <div class="btn-group">
                                <form action="<?php= SCL_RAIZ ?>impressao/nota/" target="_blank" method="post">
                                    <input type="hidden" name="aluno" value="<?=$this->input->get('aluno')?>" />
                                    <input type="hidden" name="tipo" value="1" />
                                    <button type="submit" class="btn btn-inverse">
                                        <i class="fa fa-print"></i> Imprimir
                                    </button>
                                </form> 
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table rt cf " id="rt1">
                            <thead class="cf">
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

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //print_r($boletim);
                                foreach ($boletim as $item) {
                                    ?>
                                    <tr>
                                        <td style="font-size:11px"><?= $item['NM_DISCIPLINA'] ?></td>
                                        <td style="font-size:11px"><?= $item['CD_TURMA'] ?></td>

                                        <td class="text-center btn-success" style="font-size:11px"><?php if (!empty($item['NOTA_N09_1B'])) echo number_format($item['NOTA_N09_1B'], 1, '.', '');
                                else '-'; ?></td>
                                        <td class="text-center btn-success" style="font-size:11px"><?php if (!empty($item['FALTAS_1B'])) echo $item['FALTAS_1B'];
                                else echo '0'; ?></td>


                                        <td class="text-center btn-warning" style="font-size:11px"><?php if ($item['NOTA_N09_2B'] != '') echo number_format($item['NOTA_N09_2B'], 1, '.', '');
                                else echo ' - '; ?></td>
                                        <td class="text-center btn-warning" style="font-size:11px"><?php if (!empty($item['FALTAS_2B'])) echo $item['FALTAS_2B'];
                                else echo '0'; ?></td>


                                        <td class="text-center btn-info" style="font-size:11px"><?php if ($item['NOTA_N09_3B'] != '') echo number_format($item['NOTA_N09_3B'], 1, '.', '');
                                else echo ' - '; ?></td>
                                        <td class="text-center btn-info" style="font-size:11px"><?php if (!empty($item['FALTAS_3B'])) echo $item['FALTAS_3B'];
                                else echo '0'; ?></td>


                                        <td class="text-center btn-default" style="font-size:11px"><?php if ($item['NOTA_N09_4B'] != '') echo number_format($item['NOTA_N09_4B'], 1, '.', '');
                                else echo ' - '; ?></td>
                                        <td class="text-center btn-default" style="font-size:11px"><?php if (!empty($item['FALTAS_4B'])) echo $item['FALTAS_4B'];
                                else echo '0'; ?></td>

                                    </tr>
<?php }  ?>
                            </tbody>
                        </table>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-alt btn-success">1º BIMESTRE</button>
                            <button type="button" class="btn btn-alt btn-warning">2º BIMESTRE</button>
                            <button type="button" class="btn btn-alt btn-info">3º BIMESTRE</button>
                            <button type="button" class="btn btn-alt btn-default">4º BIMESTRE</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php exit(); ?>