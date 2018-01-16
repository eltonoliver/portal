<?

$mes = date('m');
switch ($mes){
 
case 1: $mes = "Janeiro"; break;
case 2: $mes = "Fevereiro"; break;
case 3: $mes = "Março"; break;
case 4: $mes = "Abril"; break;
case 5: $mes = "Maio"; break;
case 6: $mes = "Junho"; break;
case 7: $mes = "Julho"; break;
case 8: $mes = "Agosto"; break;
case 9: $mes = "Setembro"; break;
case 10: $mes = "Outubro"; break;
case 11: $mes = "Novembro"; break;
case 12: $mes = "Dezembro"; break;
 
}

?>

<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
<table width="80%" align="center" cellpadding="5" cellspacing="1">
  <tr>
    <td height="30" align="center"><h4><?=$doc[0]['NM_DOCUMENTO']?></h4></td>
  </tr>
  <tr>
    <td height="30" align="left">
        <br /><br />
        <p  style="text-align:justify; text-indent: 30px; line-height:300%;">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $doc[0]['TEXTO_DOCUMENTO']?>
        </p>
    </td>
  </tr>
  <tr>
    <td height="30" align="center">
    </td>
  </tr>
  <tr>
    <td height="30" align="center">
        <br /><br /><br /><br />
        Manaus, <?=date('d').' de '.$mes.' de '.date('Y');?>.
    </td>
  </tr>
</table>
