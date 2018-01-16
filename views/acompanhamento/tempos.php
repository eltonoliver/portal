<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary"  id="conteudo_tabela">
            <div class="panel-body">
                <table class="table table-hover rt cf " id="rt1">
                    <thead class="cf">
                        <tr>
                            <th class="text-center">TEMPO </th>
                            <th class="text-center">SEGUNDA</th>
                            <th class="text-center">TERÇA</th>
                            <th class="text-center">QUARTA</th>
                            <th class="text-center">QUINTA</th>
                            <th class="text-center">SEXTA</th>
                            <th class="text-center">SÁBADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contador = count($tempos);
                        for ($i = 0; $i < $contador; $i++) {
                            ?>
                            <tr>
                                <td class="text-center"> <?= $tempos[$i]['TEMPO'] ?></td>
                                <td class="text-center <?= FL_DIA == 1 ? "success" : "" ?>" style="font-size:11px"> 
                                    <?php
                                    $tem = explode('<br />', trim(nl2br($tempos[$i]['SEGUNDA'])));

                                    if (trim($tem[1]) == 'ESTUDO DIRIGIDO') {
                                        echo $tem[1] . '<br/>';
                                        echo $tem[2] . '<br/>';
                                        echo $tem[3] . '<br/>';
                                    } else {
                                        echo nl2br($tempos[$i]['SEGUNDA']);
                                    }
                                    ?> 
                                </td>

                                <td class="text-center <?= FL_DIA == 2 ? "success" : "" ?>" style="font-size:11px"> 
                                    <?php
                                    $tem = explode('<br />', trim(nl2br($tempos[$i]['TERCA'])));

                                    if (trim($tem[1]) == 'ESTUDO DIRIGIDO') {
                                        echo $tem[1] . '<br/>';
                                        echo $tem[2] . '<br/>';
                                        echo $tem[3] . '<br/>';
                                    } else {
                                        echo nl2br($tempos[$i]['TERCA']);
                                    }
                                    ?>                                    
                                </td>
                                <td class="text-center <?= FL_DIA == 3 ? "success" : "" ?>" style="font-size:11px"> 
                                    <?php
                                    $tem = explode('<br />', trim(nl2br($tempos[$i]['QUARTA'])));

                                    if (trim($tem[1]) == 'ESTUDO DIRIGIDO') {
                                        echo $tem[1] . '<br/>';
                                        echo $tem[2] . '<br/>';
                                        echo $tem[3] . '<br/>';
                                    } else {
                                        echo nl2br($tempos[$i]['QUARTA']);
                                    }
                                    ?> 
                                </td>
                                <td class="text-center <?= FL_DIA == 4 ? "success" : "" ?>" style="font-size:11px"> 
                                    <?php
                                    $tem = explode('<br />', trim(nl2br($tempos[$i]['QUINTA'])));

                                    if (trim($tem[1]) == 'ESTUDO DIRIGIDO') {
                                        echo $tem[1] . '<br/>';
                                        echo $tem[2] . '<br/>';
                                        echo $tem[3] . '<br/>';
                                    } else {
                                        echo nl2br($tempos[$i]['QUINTA']);
                                    }
                                    ?> 
                                </td>
                                <td class="text-center <?= FL_DIA == 5 ? "success" : "" ?>" style="font-size:11px">
                                    <?php
                                    $tem = explode('<br />', trim(nl2br($tempos[$i]['SEXTA'])));

                                    if (trim($tem[1]) == 'ESTUDO DIRIGIDO') {
                                        echo $tem[1] . '<br/>';
                                        echo $tem[2] . '<br/>';
                                        echo $tem[3] . '<br/>';
                                    } else {
                                        echo nl2br($tempos[$i]['SEXTA']);
                                    }
                                    ?> 
                                </td>
                                <td class="text-center <?= FL_DIA == 6 ? "success" : "" ?>" style="font-size:11px"> 
                                    <?php
                                    $tem = explode('<br />', trim(nl2br($tempos[$i]['SABADO'])));

                                    if (trim($tem[1]) == 'ESTUDO DIRIGIDO') {
                                        echo $tem[1] . '<br/>';
                                        echo $tem[2] . '<br/>';
                                        echo $tem[3] . '<br/>';
                                    } else {
                                        echo nl2br($tempos[$i]['SABADO']);
                                    }
                                    ?> 
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>        
            </div>
        </div>

    </div>
    <!-- Área que vai atualizar :final   -->
</div>

<?php exit(); ?>