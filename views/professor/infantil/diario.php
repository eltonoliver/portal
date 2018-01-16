<div class="modal-header btn-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" ><?= $titulo ?></h4>
</div>
<form action="<?= SCL_RAIZ ?>professor/infantil/diario_lancar" method="post" enctype="multipart/form-data" id="frmfrequencia" >
<div class="widget-body">
        <input name="turma" type="hidden" id="turma" value="<?= $turma ?>" />
        <table width="100%" class="table table-bordered table-hover" id="gridview" aria-describedby="sample-table-2_info">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th>ALUNO</th>
                    <th>COLAÇÃO</th>
                    <th>ALMOÇO</th>
                    <th>LANCHE</th>
                    <th>SONO / DESCANSO</th>
                    <th>EVACUAÇÃO </th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($alunos) > 0) {
                    foreach ($alunos as $row) {
                        ?>
                        <tr>
                            <td>
                                <div class="user"><img src="<?=SCL_RAIZ?>restrito/foto?codigo=<?=$row['CD_ALUNO']?>" title="<?=$row['NM_ALUNO']?>" width="100%" /></div>
                            </td>
                            <td style="text-align: left; vertical-align:middle"><?= $row['NM_ALUNO'] ?></td>
                            <td width="10%"  style="vertical-align:middle">
                                <select name="colacao<?= $row['CD_ALUNO'] ?>" id="colacao<?= $row['CD_ALUNO'] ?>">
                                    <option value=""></option>
                                    <option <?php if ($row['COLACAO'] == "AT") echo 'selected="selected"'; ?> value="AT">Aceitação Total</option>
                                    <option <?php if ($row['COLACAO'] == "AP") echo 'selected="selected"'; ?> value="AP">Aceitação Parcial</option>
                                    <option <?php if ($row['COLACAO'] == "RP") echo 'selected="selected"'; ?> value="RP">Repetiu</option>
                                    <option <?php if ($row['COLACAO'] == "RJ") echo 'selected="selected"'; ?> value="RJ">Rejeição</option>
                                </select>
                            </td>
                            <td width="10%"  style="vertical-align:middle">
                                <select name="almoco<?= $row['CD_ALUNO'] ?>" id="almoco<?= $row['CD_ALUNO'] ?>">
                                    <option value=""></option>
                                    <option <?php if ($row['ALMOCO'] == "AT") echo "selected='selected'"; ?> value="AT">Aceitação Total</option>
                                    <option <?php if ($row['ALMOCO'] == "AP") echo "selected='selected'"; ?> value="AP">Aceitação Parcial</option>
                                    <option <?php if ($row['ALMOCO'] == "RP") echo "selected='selected'"; ?> value="RP">Repetiu</option>
                                    <option <?php if ($row['ALMOCO'] == "RJ") echo "selected='selected'"; ?> value="RJ">Rejeição</option>
                                </select>
                            </td>
                            <td width="10%"  style="vertical-align:middle">
                                <select name="lanche<?= $row['CD_ALUNO'] ?>" id="lanche<?= $row['CD_ALUNO'] ?>">
                                    <option value=""></option>
                                    <option <?php
                                        if ($row['LANCHE'] == 'AT') {
                                            echo 'selected="selected"';
                                        }
                                        ?> value="AT">Aceitação Total</option>
                                    <option <?php
                                    if ($row['LANCHE'] == 'AP') {
                                        echo 'selected="selected"';
                                    }
                                    ?> value="AP">Aceitação Parcial</option>
                                    <option <?php
                                    if ($row['LANCHE'] == 'RP') {
                                        echo 'selected="selected"';
                                    }
                                    ?> value="RP">Repetiu</option>
                                    <option <?php
                                    if ($row['LANCHE'] == 'RJ') {
                                        echo 'selected="selected"';
                                    }
                                    ?> value="RJ">Rejeição</option>
                                </select>
                            </td>
                            <td width="10%"  style="vertical-align:middle">
                                <select name="descanso<?= $row['CD_ALUNO'] ?>" id="descanso<?= $row['CD_ALUNO'] ?>">
                                    <option value=""></option>
                                    <option <?php
                            if ($row['SONO'] == 'TQ') {
                                echo 'selected="selected"';
                            }
                            ?> value="TQ">Tranquilo</option>
                                    <option <?php
                                    if ($row['SONO'] == 'AG') {
                                        echo 'selected="selected"';
                                    }
                                    ?> value="AG">Agitado</option>
                                    <option <?php
                                    if ($row['SONO'] == 'ND') {
                                        echo 'selected="selected"';
                                    }
                                    ?> value="ND">Não Dormiu</option>
                                </select>
                            </td>
                            <td width="10%"  style="vertical-align:middle">
                                <select name="evacuacao<?= $row['CD_ALUNO'] ?>" id="evacuacao<?= $row['CD_ALUNO'] ?>">
                                    <option value=""></option>
                                    <option <?php
                                    if ($row['EVACUACAO'] == 'NO') {
                                        echo 'selected="selected"';
                                    }
                                    ?> value="NO">Normal</option>
                                    <option <?php
                                    if ($row['EVACUACAO'] == 'NE') {
                                        echo 'selected="selected"';
                                    }
                                    ?> value="NE">Não Evacuou</option>
                                </select>
                            </td>
                        </tr>
                <?php }  } ?>
            </tbody>
        </table>  
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
    <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Lançar</button>
</div>

</form>
<?php exit; ?>

