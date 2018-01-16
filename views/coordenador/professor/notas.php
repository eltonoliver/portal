<div class="modal-dialog" style="width:100%">
    <div class="modal-content">
        <div class="panel-heading btn-info">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-user"></i> Notas do Aluno</h4>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <tr class="well">
                        <th style="font-size:11px" colspan="2"></th>

                        <th colspan="8" class="text-center btn-success" style="font-size:11px">1º Bimestre</th>

                        <th colspan="8" class="text-center btn-warning" style="font-size:11px">2º Bimestre</th>

                        <th colspan="8" class="text-center btn-info" style="font-size:11px">3º Bimestre</th>

                        <th colspan="8" class="text-center btn-danger" style="font-size:11px">4º Bimestre</th>
                    </tr>

                    <tr class="well">
                        <th style="font-size:11px">Disciplina</th>
                        <th style="font-size:11px">Turma</th>

                        <th class="text-center btn-success" style="font-size:11px">P1</th>
                        <th class="text-center btn-success" style="font-size:11px">RP1</th>
                        <th class="text-center btn-success" style="font-size:11px">MAIC</th>
                        <th class="text-center btn-success" style="font-size:11px">P2</th>
                        <th class="text-center btn-success" style="font-size:11px">RMB</th>
                        <th class="text-center btn-success" style="font-size:11px">NQ</th>
                        <th class="text-center btn-success" style="font-size:11px">NC</th>
                        <th class="text-center btn-success" style="font-size:11px"></th>

                        <th class="text-center btn-warning" style="font-size:11px">P1</th>
                        <th class="text-center btn-warning" style="font-size:11px">RP1</th>
                        <th class="text-center btn-warning" style="font-size:11px">MAIC</th>
                        <th class="text-center btn-warning" style="font-size:11px">P2</th>
                        <th class="text-center btn-warning" style="font-size:11px">RMB</th>
                        <th class="text-center btn-warning" style="font-size:11px">NQ</th>
                        <th class="text-center btn-warning" style="font-size:11px">NC</th>
                        <th class="text-center btn-warning" style="font-size:11px"></th>

                        <th class="text-center btn-info" style="font-size:11px">P1</th>
                        <th class="text-center btn-info" style="font-size:11px">RP1</th>
                        <th class="text-center btn-info" style="font-size:11px">MAIC</th>
                        <th class="text-center btn-info" style="font-size:11px">P2</th>
                        <th class="text-center btn-info" style="font-size:11px">RMB</th>
                        <th class="text-center btn-info" style="font-size:11px">NQ</th>
                        <th class="text-center btn-info" style="font-size:11px">NC</th>
                        <th class="text-center btn-info" style="font-size:11px"></th>

                        <th class="text-center btn-danger" style="font-size:11px">P1</th>
                        <th class="text-center btn-danger" style="font-size:11px">RP1</th>
                        <th class="text-center btn-danger" style="font-size:11px">MAIC</th>
                        <th class="text-center btn-danger" style="font-size:11px">P2</th>
                        <th class="text-center btn-danger" style="font-size:11px">RMB</th>
                        <th class="text-center btn-danger" style="font-size:11px">NQ</th>
                        <th class="text-center btn-danger" style="font-size:11px">NC</th>
                        <th class="text-center btn-danger" style="font-size:11px"></th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    //print_r($boletim);
                    foreach ($boletim as $item) {
                        ?>
                        <tr>
                            <td style="font-size:11px" class="well"><?= $item['NM_DISCIPLINA'] ?></td>
                            <td style="font-size:11px" class="well"><?= $item['CD_TURMA'] ?></td>

                            <td class="text-center btn-success" style="font-size:11px"><?
                                if (!empty($item['NOTA_N01_1B']))
                                    echo number_format($item['NOTA_N01_1B'], 1, '.', '');
                                else
                                    echo '-';
                                ?></td>
                            <td class="text-center btn-success" style="font-size:11px"><?
                                if ($item['NOTA_N05_1B'] != '')
                                    echo number_format($item['NOTA_N05_1B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-success" style="font-size:11px"><?
                                if ($item['NOTA_N02_1B'] != '')
                                    echo number_format($item['NOTA_N02_1B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-success" style="font-size:11px"><?
                                if ($item['NOTA_N03_1B'] != '')
                                    echo number_format($item['NOTA_N03_1B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-success" style="font-size:11px"><?
                            if ($item['NOTA_N08_1B'] != '')
                                echo number_format($item['NOTA_N08_1B'], 1, '.', '');
                            else
                                echo ' - ';
                                ?></td>
                            <td class="text-center btn-success" style="font-size:11px"><?
                            if ($item['NOTA_N10_1B'] != '')
                                echo number_format($item['NOTA_N10_1B'], 1, '.', '');
                            else
                                echo ' - ';
                                ?></td>



                            <td class="text-center btn-success" style="font-size:11px"><?
                                if ($item['NOTA_N10_1B'] != '')
                                    echo number_format($item['NOTA_N10_1B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-success" style="font-size:11px"><?
                                if ($item['NOTA_N10_1B'] != '')
                                    echo number_format($item['NOTA_N10_1B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>





                            <td class="text-center btn-warning" style="font-size:11px"><?
                                if (!empty($item['NOTA_N01_2B']))
                                    echo number_format($item['NOTA_N01_2B'], 1, '.', '');
                                else
                                    echo '-';
                                ?></td>
                            <td class="text-center btn-warning" style="font-size:11px"><?
                            if ($item['NOTA_N05_2B'] != '')
                                echo number_format($item['NOTA_N05_2B'], 1, '.', '');
                            else
                                echo ' - ';
                                ?></td>
                            <td class="text-center btn-warning" style="font-size:11px"><?
                                if ($item['NOTA_N02_2B'] != '')
                                    echo number_format($item['NOTA_N02_2B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-warning" style="font-size:11px"><?
                                if ($item['NOTA_N03_2B'] != '')
                                    echo number_format($item['NOTA_N03_2B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-warning" style="font-size:11px"><?
                                if ($item['NOTA_N08_2B'] != '')
                                    echo number_format($item['NOTA_N08_2B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-warning" style="font-size:11px"><?
                                if ($item['NOTA_N10_2B'] != '')
                                    echo number_format($item['NOTA_N10_2B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>



                            <td class="text-center btn-warning" style="font-size:11px"><?
                                if ($item['NOTA_N08_2B'] != '')
                                    echo number_format($item['NOTA_N08_2B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-warning" style="font-size:11px"><?
                                if ($item['NOTA_N10_2B'] != '')
                                    echo number_format($item['NOTA_N10_2B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>








                            <td class="text-center btn-info" style="font-size:11px"><?
                                if (!empty($item['NOTA_N01_3B']))
                                    echo number_format($item['NOTA_N01_3B'], 1, '.', '');
                                else
                                    echo '-';
                                ?></td>
                            <td class="text-center btn-info" style="font-size:11px"><?
                                if ($item['NOTA_N05_3B'] != '')
                                    echo number_format($item['NOTA_N05_3B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-info" style="font-size:11px"><?
                                if ($item['NOTA_N02_3B'] != '')
                                    echo number_format($item['NOTA_N02_3B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-info" style="font-size:11px"><?
                                if ($item['NOTA_N03_3B'] != '')
                                    echo number_format($item['NOTA_N03_3B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-info" style="font-size:11px"><?
                                if ($item['NOTA_N08_3B'] != '')
                                    echo number_format($item['NOTA_N08_3B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-info" style="font-size:11px"><?
                                if ($item['NOTA_N10_3B'] != '')
                                    echo number_format($item['NOTA_N10_3B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>





                            <td class="text-center btn-info" style="font-size:11px"><?
                                if ($item['NOTA_N08_3B'] != '')
                                    echo number_format($item['NOTA_N08_3B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-info" style="font-size:11px"><?
                                if ($item['NOTA_N10_3B'] != '')
                                    echo number_format($item['NOTA_N10_3B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>








                            <td class="text-center btn-danger" style="font-size:11px"><?
                                if (!empty($item['NOTA_N01_4B']))
                                    echo number_format($item['NOTA_N01_4B'], 1, '.', '');
                                else
                                    echo '-';
                                ?></td>
                            <td class="text-center btn-danger" style="font-size:11px"><?
                            if ($item['NOTA_N05_4B'] != '')
                                echo number_format($item['NOTA_N05_4B'], 1, '.', '');
                            else
                                echo ' - ';
                                ?></td>
                            <td class="text-center btn-danger" style="font-size:11px"><?
                                if ($item['NOTA_N02_4B'] != '')
                                    echo number_format($item['NOTA_N02_4B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-danger" style="font-size:11px"><?
                                if ($item['NOTA_N03_4B'] != '')
                                    echo number_format($item['NOTA_N03_4B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-danger" style="font-size:11px"><?
                                if ($item['NOTA_N08_4B'] != '')
                                    echo number_format($item['NOTA_N08_4B'], 1, '.', '');
                                else
                                    echo ' - ';
                                ?></td>
                            <td class="text-center btn-danger" style="font-size:11px"><?
    if ($item['NOTA_N10_4B'] != '')
        echo number_format($item['NOTA_N10_4B'], 1, '.', '');
    else
        echo ' - ';
    ?></td>

                            <td class="text-center btn-danger" style="font-size:11px"><?
    if ($item['NOTA_N08_4B'] != '')
        echo number_format($item['NOTA_N08_4B'], 1, '.', '');
    else
        echo ' - ';
    ?></td>
                            <td class="text-center btn-danger" style="font-size:11px"><?
    if ($item['NOTA_N10_4B'] != '')
        echo number_format($item['NOTA_N10_4B'], 1, '.', '');
    else
        echo ' - ';
    ?></td>



                        </tr>
<? } ?>
                </tbody>
            </table>
        </div>
        <div class="panel-footer left">
            <label class="label label-info center"> NC - Nota Calculada |  NT - Nota Obitida</label>
            <a class="btn btn-danger  pull-right" data-dismiss="modal"><i class="fa fa-refresh"></i> Fechar </a>
        </div>
    </div>
</div>
<? exit(); ?>

