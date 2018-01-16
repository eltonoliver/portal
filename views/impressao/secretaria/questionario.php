
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td height="50" colspan="3" align="center"><h4>RELATÓRIO PEDAGÓGICO INFANTIL</h4></td>
    </tr>
    <tr>
        <td width="64%" align="left">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="9%" align="left" style="font-size:11px">Matrícula:</td>
                    <td width="91%" style="font-size:12px"><strong>
                            <?= $this->input->mascara_string("##.#####-#", $aluno[0]['CD_ALUNO']) ?>
                        </strong></td>
                </tr>
                <tr>
                    <td width="9%" align="left" style="font-size:11px">Nome:</td>
                    <td width="91%" style="font-size:12px"><strong>
                            <?= $aluno[0]['NM_ALUNO'] ?>
                        </strong></td>
                </tr>
                <tr>
                    <td align="left" style="font-size:11px">Turma:</td>
                    <td style="font-size:12px"><strong>
                            <?= $aluno[0]['CD_TURMA'] ?>
                        </strong></td>
                </tr>
                <tr>
                    <td align="left" style="font-size:11px">Curso:</td>
                    <td style="font-size:12px"><strong>
                            <?= $aluno[0]['NM_CURSO'] ?>
                        </strong></td>
                </tr>
                <tr>
                    <td align="left" style="font-size:11px">Série:</td>
                    <td style="font-size:12px"><strong>
                            <?= $aluno[0]['NM_SERIE'] ?>
                        </strong></td>
                </tr>
            </table></td>
        <td width="26%" align="left" valign="middle">&nbsp;</td>
    </tr>
</table>
<br/>

<?
//print_r($aluno);

$div = array();
foreach ($listar as $row) {
$div[] = $row['DC_DIVISAO'];
}
$divisao = array_keys(array_flip($div));
?>
<div class="col-md-10">
    <div class="tab-content">
        <? foreach ($divisao as $d) { ?>
        <div class="tab-pane" id="<?= str_replace(' ', '', $d) ?>">
            <div class="">
                <h4><?= $d ?></h4>
                <table width="100%" cellpadding="2" class="table table-hover " style="background:#FFF">
                    <thead>
                        <tr>
                            <td bgcolor="#939393">Pergunta</td>
                            <td width="15%" align="center" bgcolor="#939393">#</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        foreach ($listar as $r) {
                        if (str_replace(' ', '', $d) == str_replace(' ', '', $r['DC_DIVISAO'])) {
                        ?>
                        <tr>
                            <td bgcolor="#F7F7F7" style="font-size:13px"><?= $r['DC_PERGUNTA'] ?></td>
                            <td align="center" bgcolor="#F7F7F7" style="font-size:10px">
                                <? echo $r['DC_RESPOSTA_PADRAO'];?>
                            </td>
                        </tr>
                        <?
                        }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <? } ?>
    </div>
</div>