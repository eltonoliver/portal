<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>
<?= SCL_TITULO ?>
</title>
<meta name="description" content="">
<meta name="author" content="Amazonas Copiadoras Ltda">
<meta name="robots" content="index, follow">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%" height="50" align="left"><img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?=$boletim[0]['CD_ALUNO'] ?>" class="media-object" style="height:120px" /></td>
    <td width="64%" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="9%" align="right" style="font-size:11px">Matrícula:</td>
          <td width="91%" style="font-size:12px"><strong>
            <?=$this->input->mascara_string("##.#####-#",$boletim[0]['CD_ALUNO'])?>
            </strong></td>
        </tr>
        <tr>
          <td width="9%" align="right" style="font-size:11px">Nome:</td>
          <td width="91%" style="font-size:12px"><strong>
            <?=$boletim[0]['NM_ALUNO'] ?>
            </strong></td>
        </tr>
        <tr>
          <td align="right" style="font-size:11px">Turma:</td>
          <td style="font-size:12px"><strong>
            <?=$boletim[0]['CD_TURMA'] ?>
            </strong></td>
        </tr>
        <tr>
          <td align="right" style="font-size:11px">Curso:</td>
          <td style="font-size:12px"><strong>
            <?=$boletim[0]['NM_CURSO'] ?>
            </strong></td>
        </tr>
        <tr>
          <td align="right" style="font-size:11px">Série:</td>
          <td style="font-size:12px"><strong>
            <?=$boletim[0]['CD_SERIE'] ?>
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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30" align="center"><h4>
        <?= $titulo ?>
      </h4></td>
  </tr>
</table>
<? if($tipo == 1){ ?>
<table align="center" width="90%">
  <tr>
    <th height="30" bgcolor="#A0A0A0" style="font-size:11px">Disciplina</th>
    <th align="center" bgcolor="#A0A0A0" style="font-size:11px">Turma</th>
    <th align="center" bgcolor="#A0A0A0" style="font-size:11px">MÉDIA</th>
    <th align="center" bgcolor="#A0A0A0" style="font-size:11px">FALTA</th>
    <th align="center" bgcolor="#A0A0A0" style="font-size:11px">MÉDIA</th>
    <th align="center" bgcolor="#A0A0A0" style="font-size:11px">FALTA</th>
    <th align="center" bgcolor="#A0A0A0" style="font-size:11px">MÉDIA</th>
    <th align="center" bgcolor="#A0A0A0" style="font-size:11px">FALTA</th>
    <th align="center" bgcolor="#A0A0A0" style="font-size:11px">MÉDIA</th>
    <th align="center" bgcolor="#A0A0A0" style="font-size:11px">FALTA</th>
  </tr>
  <?
            
            foreach ($boletim as $item) {
                ?>
  <tr>
    <td height="25" bgcolor="#D6D6D6" style="font-size:11px"><?= $item['NM_DISCIPLINA'] ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><?= $item['CD_TURMA'] ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><?
                        if (!empty($item['NOTA_N01_1B']))
                            echo $item['NOTA_N01_1B'];
                        else
                            '-';
                        ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><?
                        if (!empty($item['FALTAS_1B']))
                            echo $item['FALTAS_1B'];
                        else
                            echo '0';
                        ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><?
                        if ($item['NOTA_N01_2B'] != '')
                            echo $item['NOTA_N01_2B'];
                        else
                            echo ' - ';
                        ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><?
                        if (!empty($item['FALTAS_2B']))
                            echo $item['FALTAS_2B'];
                        else
                            echo '0';
                        ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><?
                    if ($item['NOTA_N01_3B'] != '')
                        echo $item['NOTA_N01_3B'];
                    else
                        echo ' - ';
                        ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><?
                    if (!empty($item['FALTAS_3B']))
                        echo $item['FALTAS_3B'];
                    else
                        echo '0';
                        ?></td>
    <td align="center" bgcolor="#D6D6D6" class="text-center btn-default" style="font-size:11px"><?
                        if ($item['NOTA_N01_4B'] != '')
                            echo $item['NOTA_N01_4B'];
                        else
                            echo ' - ';
                        ?></td>
    <td align="center" bgcolor="#D6D6D6" class="text-center btn-default" style="font-size:11px"><?
                        if (!empty($item['FALTAS_4B']))
                            echo $item['FALTAS_4B'];
                        else
                            echo '0';
                        ?></td>
  </tr>
  <? } ?>
</table>
<? } elseif($tipo == 0){ ?>
<table width="90%" align="center">
  <tr>
    <th rowspan="2" align="center" bgcolor="#A0A0A0" style="font-size:11px">Disciplina</th>
    <th height="30" colspan="7" align="center" bgcolor="#A0A0A0" style="font-size:11px">1º Bimestre</th>
    <th colspan="6" align="center" bgcolor="#BEBEBE" style="font-size:11px">2º Bimestre</th>
    <th colspan="6" align="center" bgcolor="#A0A0A0" style="font-size:11px">3º Bimestre</th>
    <th colspan="6" align="center" bgcolor="#BEBEBE" style="font-size:11px">4º Bimestre</th>
  </tr>
  <tr>
    <th width="4%" height="30" align="center" bgcolor="#A0A0A0" style="font-size:11px">Turma</th>
    <th width="3%" align="center" bgcolor="#A0A0A0" style="font-size:11px">P1</th>
    <th width="3%" align="center" bgcolor="#A0A0A0" style="font-size:11px">RP1</th>
    <th width="3%" align="center" bgcolor="#A0A0A0" style="font-size:11px">MAIC</th>
    <th width="3%" align="center" bgcolor="#A0A0A0" style="font-size:11px">P2</th>
    <th width="3%" align="center" bgcolor="#A0A0A0" style="font-size:11px">RMB</th>
    <th width="3%" align="center" bgcolor="#A0A0A0" style="font-size:11px">NQ</th>
    <th width="3%" align="center" bgcolor="#BEBEBE" style="font-size:11px">P1</th>
    <th width="3%" align="center" bgcolor="#BEBEBE" style="font-size:11px">RP1</th>
    <th width="3%" align="center" bgcolor="#BEBEBE" style="font-size:11px">MAIC</th>
    <th width="3%" align="center" bgcolor="#BEBEBE" style="font-size:11px">P2</th>
    <th width="3%" align="center" bgcolor="#BEBEBE" style="font-size:11px">RMB</th>
    <th width="3%" align="center" bgcolor="#BEBEBE" style="font-size:11px">NQ</th>
    <th width="3%" align="center" bgcolor="#A0A0A0" style="font-size:11px">P1</th>
    <th width="3%" align="center" bgcolor="#A0A0A0" style="font-size:11px">RP1</th>
    <th width="3%" align="center" bgcolor="#A0A0A0" style="font-size:11px">MAIC</th>
    <th width="3%" align="center" bgcolor="#A0A0A0" style="font-size:11px">P2</th>
    <th width="3%" align="center" bgcolor="#A0A0A0" style="font-size:11px">RMB</th>
    <th width="3%" align="center" bgcolor="#A0A0A0" style="font-size:11px">NQ</th>
    <th width="3%" align="center" bgcolor="#BEBEBE" style="font-size:11px">P1</th>
    <th width="3%" align="center" bgcolor="#BEBEBE" style="font-size:11px">RP1</th>
    <th width="3%" align="center" bgcolor="#BEBEBE" style="font-size:11px">MAIC</th>
    <th width="3%" align="center" bgcolor="#BEBEBE" style="font-size:11px">P2</th>
    <th width="3%" align="center" bgcolor="#BEBEBE" style="font-size:11px">RMB</th>
    <th width="3%" align="center" bgcolor="#BEBEBE" style="font-size:11px">NQ</th>
  </tr>
  <?
                                //print_r($boletim);
                                foreach ($boletim as $item) {
                                    ?>
  <tr>
    <td height="25" bgcolor="#D6D6D6" style="font-size:11px"><?= $item['NM_DISCIPLINA'] ?></td>
    <td bgcolor="#D6D6D6" style="font-size:11px"><?= $item['CD_TURMA'] ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><? if (!empty($item['NOTA_N01_1B'])) echo number_format($item['NOTA_N01_1B'], 1, '.', '');
                                else echo '-'; ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><? if ($item['NOTA_N05_1B'] != '') echo number_format($item['NOTA_N05_1B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><? if ($item['NOTA_N02_1B'] != '') echo number_format($item['NOTA_N02_1B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><? if ($item['NOTA_N03_1B'] != '') echo number_format($item['NOTA_N03_1B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><? if ($item['NOTA_N08_1B'] != '') echo number_format($item['NOTA_N08_1B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><? if ($item['NOTA_N10_1B'] != '') echo number_format($item['NOTA_N10_1B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#EBEBEB" style="font-size:11px"><? if (!empty($item['NOTA_N01_2B'])) echo number_format($item['NOTA_N01_2B'], 1, '.', '');
                                else echo '-'; ?></td>
    <td align="center" bgcolor="#EBEBEB" style="font-size:11px"><? if ($item['NOTA_N05_2B'] != '') echo number_format($item['NOTA_N05_2B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#EBEBEB" style="font-size:11px"><? if ($item['NOTA_N02_2B'] != '') echo number_format($item['NOTA_N02_2B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#EBEBEB" style="font-size:11px"><? if ($item['NOTA_N03_2B'] != '') echo number_format($item['NOTA_N03_2B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#EBEBEB" style="font-size:11px"><? if ($item['NOTA_N08_2B'] != '') echo number_format($item['NOTA_N08_2B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#EBEBEB" style="font-size:11px"><? if ($item['NOTA_N10_2B'] != '') echo number_format($item['NOTA_N10_2B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><? if (!empty($item['NOTA_N01_3B'])) echo number_format($item['NOTA_N01_3B'], 1, '.', '');
                                else echo '-'; ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><? if ($item['NOTA_N05_3B'] != '') echo number_format($item['NOTA_N05_3B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><? if ($item['NOTA_N02_3B'] != '') echo number_format($item['NOTA_N02_3B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><? if ($item['NOTA_N03_3B'] != '') echo number_format($item['NOTA_N03_3B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><? if ($item['NOTA_N08_3B'] != '') echo number_format($item['NOTA_N08_3B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><? if ($item['NOTA_N10_3B'] != '') echo number_format($item['NOTA_N10_3B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#EBEBEB" style="font-size:11px"><? if (!empty($item['NOTA_N01_4B'])) echo number_format($item['NOTA_N01_4B'], 1, '.', '');
                                else echo '-'; ?></td>
    <td align="center" bgcolor="#EBEBEB" style="font-size:11px"><? if ($item['NOTA_N05_4B'] != '') echo number_format($item['NOTA_N05_4B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#EBEBEB" style="font-size:11px"><? if ($item['NOTA_N02_4B'] != '') echo number_format($item['NOTA_N02_4B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#EBEBEB" style="font-size:11px"><? if ($item['NOTA_N03_4B'] != '') echo number_format($item['NOTA_N03_4B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#EBEBEB" style="font-size:11px"><? if ($item['NOTA_N08_4B'] != '') echo number_format($item['NOTA_N08_4B'], 1, '.', '');
                                else echo ' - '; ?></td>
    <td align="center" bgcolor="#EBEBEB" style="font-size:11px"><? if ($item['NOTA_N10_4B'] != '') echo number_format($item['NOTA_N10_4B'], 1, '.', '');
                                else echo ' - '; ?></td>
  </tr>
  <? } ?>
  
</table>
<? } ?>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="20" align="right" valign="top"><h6>* Não é um documento oficial, para o boletim acadêmico do aluno, entre em contato com a secretaria do colégio.</h6></td>
  </tr>
  <tr>
    <td height="50" align="left" style="font-size:11px">
    
    <? if($tipo == 0){ 
		echo '<h5>Legenda</h5>'; 
		echo $boletim[0]['NM_MINI_N01_1B'].' = '.$boletim[0]['DC_TIPO_NOTA_N01_1B'].'<br/>';
		echo $boletim[0]['NM_MINI_N05_1B'].' = '.$boletim[0]['DC_TIPO_NOTA_N05_1B'].'<br/>';
		echo $boletim[0]['NM_MINI_N02_1B'].' = '.$boletim[0]['DC_TIPO_NOTA_N02_1B'].'<br/>';
		echo $boletim[0]['NM_MINI_N03_1B'].' = '.$boletim[0]['DC_TIPO_NOTA_N03_1B'].'<br/>';
		echo $boletim[0]['NM_MINI_N08_1B'].' = '.$boletim[0]['DC_TIPO_NOTA_N08_1B'].'<br/>';
		echo $boletim[0]['NM_MINI_N10_1B'].' = '.$boletim[0]['DC_TIPO_NOTA_N10_1B'].'<br/>';
	 } ?>
    </td>
  </tr>
</table>
</body>
</html>
