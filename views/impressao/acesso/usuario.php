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
<body><br/><br/><br/><br/><br/>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30" align="center"><h4><?= $titulo ?></h4></td>
  </tr>
</table>
<table width="90%" align="center" cellpadding="5" cellspacing="1">
  <tr>
    <th height="30" on  colspan="7" align="left" bgcolor="#CDCCCC" style="font-size:11px">&nbsp;&nbsp;GRUPO: </th>
  </tr>
  <tr>
    <th height="30" align="left" bgcolor="#A0A0A0" style="font-size:11px">&nbsp;&nbsp;PROGRAMA</th>
    <th width="5%" align="center" bgcolor="#A0A0A0" style="font-size:11px">INCLUIR</th>
    <th width="5%" align="center" bgcolor="#A0A0A0" style="font-size:11px">ALTERAR</th>
    <th width="5%" align="center" bgcolor="#A0A0A0" style="font-size:11px">EXCLUIR</th>
    <th width="5%" align="center" bgcolor="#A0A0A0" style="font-size:11px">IMPRIMIR</th>
    <th width="5%" align="center" bgcolor="#A0A0A0" style="font-size:11px">ESPECIAL1</th>
    <th width="5%" align="center" bgcolor="#A0A0A0" style="font-size:11px">ESPECIAL2</th>
  </tr>
  <? foreach ($listar as $r) { ?>
  <tr>
    <td height="25" bgcolor="#D6D6D6" style="font-size:11px"><?= $r['NM_PROGRAMA'] ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><?= $r['INCLUIR'] ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><?= $r['ALTERAR'] ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><?= $r['EXCLUIR'] ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><?= $r['IMPRIMIR'] ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><?= $r['ESPECIAL1'] ?></td>
    <td align="center" bgcolor="#D6D6D6" style="font-size:11px"><?= $r['ESPECIAL2'] ?></td>
  </tr>
  <? } ?>
</table>
</body>
</html>