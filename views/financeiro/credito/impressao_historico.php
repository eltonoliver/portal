
<table width="800px" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%" height="50" align="left"><img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?=$aluno[0]['CD_ALUNO'] ?>" class="media-object" style="height:120px" /></td>
    <td width="64%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="9%" align="right" style="font-size:11px">Matrícula:</td>
          <td width="91%" style="font-size:12px"><strong>
            <?=$this->input->mascara_string("##.#####-#",$aluno[0]['CD_ALUNO'])?>
            </strong></td>
        </tr>
        <tr>
          <td width="9%" align="right" style="font-size:11px">Nome:</td>
          <td width="91%" style="font-size:12px"><strong>
            <?=$aluno[0]['NM_ALUNO'] ?>
            </strong></td>
        </tr>
        <tr>
          <td align="right" style="font-size:11px">Turma:</td>
          <td style="font-size:12px"><strong>
            <?=$aluno[0]['CD_TURMA'] ?>
            </strong></td>
        </tr>
        <tr>
          <td align="right" style="font-size:11px">Curso:</td>
          <td style="font-size:12px"><strong>
            <?=$aluno[0]['NM_CURSO'] ?>
            </strong></td>
        </tr>
        <tr>
          <td align="right" style="font-size:11px">Série:</td>
          <td style="font-size:12px"><strong>
            <?=$aluno[0]['ORDEM_SERIE'] ?>
            º</strong></td>
        </tr>
      </table></td>
    <td width="26%" align="right" valign="middle"><h6>Data de Emissão:
        <?=date('d/m/Y H:i:s');?>
        <br>
        Emitente:
        <?=$this->session->userdata('SCL_SSS_USU_NOME')?>
      </h6></td>
  </tr>
</table>
<br/>
<table border="0" cellpadding="5" cellspacing="0" width="800px" align="center">
    <tr>
        <td colspan="6" align="center"><h3>Histórico de Consumo</h3><hr/></td>
    </tr>
    <tr>
        <td style="font-size:10px; border:solid 1px #1a2129; background: #e1e4e2">Dia</td>
        <td style="font-size:10px; border:solid 1px #1a2129; background: #e1e4e2">Pedido</td>
        <td style="font-size:10px; border:solid 1px #1a2129; background: #e1e4e2">Produto</td>
        <td style="font-size:10px; border:solid 1px #1a2129; background: #e1e4e2" align="center">Qtd</td>
        <td style="font-size:10px; border:solid 1px #1a2129; background: #e1e4e2" align="center">Un.</td>
        <td style="font-size:10px; border:solid 1px #1a2129; background: #e1e4e2" align="right">Total (R$)</td>
    </tr>
    <? foreach ($extrato as $r) { ?>
        <tr>
            <td align="center" style="font-size:9px; border:solid 1px #1a2129"><?= $r['DTVENDA'] ?></td>
            <td align="center" style="font-size:9px; border:solid 1px #1a2129"><?= $r['ID_VENDA'] ?></td>
            <td align="left" style="font-size:9px; border:solid 1px #1a2129"><?= $r['DC_CATEGORIA'] . ' - ' . $r['DC_PRODUTO'] ?></td>
            <td align="center" style="font-size:9px; border:solid 1px #1a2129"><?= $r['QUANTIDADE'] ?></td>
            <td align="center" style="font-size:9px; border:solid 1px #1a2129"><?= number_format($r['PRECO_UNITARIO'], 2, ',', '.') ?></td>
            <td align="right" style="font-size:9px; border:solid 1px #1a2129"><?= number_format($r['SUBTOTAL'], 2, ',', '.') ?></td>
        </tr>
    <? } ?>
</table>
<? //exit();?>

