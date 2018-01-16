<!DOCTYPE HTML PUBLIC '-/W3C/DTD HTML 4.0 Transitional/EN'>
<html>
<head>
<title>
<?= SCL_DEF_TITULO ?>
- Boletos</title>
<meta http-equiv=Content-Type content=text/html charset=UTF-8>
<link href="<?=SCL_CSS?>boleto.css" rel="stylesheet" media="all">
</head>
<body>

<table width="680" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> 
      <div class="texto">
      	Imprima em impressora jato de tinta (ink jet) ou laser em qualidade normal ou alta (Não use modo econômico).<br>
      	Utilize folha A4 (210 x 297 mm) ou Carta (216 x 279 mm) e margens mínimas à esquerda e à direita do formulário.<br>
      	Corte na linha indicada. Não rasure, risque, fure ou dobre a região onde se encontra o código de barras.<br>
      	Caso não apareça o código de barras no final, clique em F5 para atualizar esta tela.
      	Caso tenha problemas ao imprimir, copie a seqüencia numérica abaixo e pague no caixa eletrônico ou no internet banking:<br>
      <div>
      <div class="label">Linha Digitável: <?=$boleto['linhaDigitavel'] ?> </div>
      <div class="label">Valor: R$ <?=number_format($boleto['valor_cobrado'],2,',','.')?></div>
      </td>
  </tr>
  <tr>
    <td>
      <table width="100%" border=0 align=center cellpadding=0 cellspacing=0 style="border-bottom:1px dotted #000000">
        <tr>
          <td width="1%" align="left"><img SRC="<?= "http://" . $_SERVER['HTTP_HOST'] . "/portal" ?>/assets/images/logo.png" width="15%"></td>
          <td width=59%></td>
          <td width=40% valign="middle" align="right" class="texto">
		    <?=$boleto['cedente']?><br>
            <?=$boleto['cedente_endereco']?><br>
            <?=$boleto['cedente_cnpj']?></td>
        </tr>
      </table>
      </td>
  </tr>
  <tr>
    <td>
    
    
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0px; padding:0px">
            <tr>
          <td width="10%" class="b_esquerda">
             <img src="<?=SCL_IMG?>boleto/<?=$boleto['codigoBanco']?>.jpg" border=0></td>
          <td width="6%" align="center" valign="bottom"  class="b_esquerda">
            <div class="texto_banco"><?=$boleto['codigo_banco_com_dv']?></div>
          </td>
          <td width="84%" align="right" valign="bottom" class="b_direita" style="font-size:12px">
            RECIBO DO SACADO</td>
        </tr>
      </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0px; padding:0px">
        <tr>
          <td height="5" colspan="6" class="label b_esquerda_cima">
          	Local de Pagamento</td>
          <td width="20%">
          	<div class="label">Vencimento</div>
          </td>
        </tr>
        <tr>
          <td height="5" colspan="6" class="b_esquerda texto"> <?=$boleto['txtbanco']?> </td>
          <td align="right" class="b_direita texto_direita">
            <?=$boleto['vencimento']?>
          </td>
        </tr>
        <tr>
          <td colspan="6" rowspan="2" valign="top" class="b_esquerda">
          	<div class="label">Cedente</div>
		  <?=$boleto['cedente']?> 
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <?=$boleto['cedente_cnpj']?></td>
          <td valign="top">
          	<div class="label">Agencia/Código Cedente</div>
          </td>
        </tr>
        <tr>
          <td align="right" valign="top" class="b_direita texto_direita">
            <?=$boleto['agencia']?>
          </td>
        </tr>
        <tr>
          <td width="10%" rowspan="2" class="b_esquerda"><div class="label">Data do Documento</div><?=$boleto['data_doc']?></td>
          <td colspan="2" rowspan="2" class="b_esquerda"><div class="label">Nº do Documento</div><?=$boleto['numero_doc']?></td>
          <td width="7%" rowspan="2" align="center" class="b_esquerda"><div class="label">Espécie Doc.</div><?=$boleto['especie']?></td>
          <td width="7%" rowspan="2" align="center" class="b_esquerda"><div class="label">Aceite</div><?=$boleto['aceite']?></td>
          <td width="30%" rowspan="2" class="b_esquerda"><div class="label">Dt. do Processamento</div>
          <?=$boleto['dt_processamento']?></td>
          <td height="15"><div class="label">Nosso Número</div></td>
        </tr>
        <tr>
          <td height="15" align="right" class="b_direita texto_direita"><?=$boleto['nosso_numero']?></td>
        </tr>
        <tr>
          <td rowspan="2" class="b_esquerda"><div class="label">Uso do Banco</div></td>
          <td width="7%" rowspan="2" align="center" class="b_esquerda"><div class="label">Carteira</div><?=$boleto['carteira']?></td>
          <td width="7%" rowspan="2" align="center" class="b_esquerda"><div class="label">Espécie</div><?=$boleto['especie']?></td>
          <td colspan="2" rowspan="2" class="b_esquerda"><div class="label">Quantidade</div><?=$boleto['quantidade']?></td>
          <td rowspan="2" class="b_esquerda"><div class="label">Valor</div><?=$boleto['valor_documento']?></td>
          <td height="15"><div class="label">(=) Valor do Documento</div></td>
        </tr>
        <tr>
          <td height="15" align="right" class="b_direita texto_direita"><?=$boleto['valorBoleto']?></td>
        </tr>
        <tr>
          <td colspan="6" rowspan="6" class="b_esquerda texto">
          	<?=$boleto['instrucao']?>
          </td>
          <td height="30" class="b_direita">
          	<div class="label">(-) Desconto / Abatimento</div>
			<div class="texto_direita"><?=$boleto['desconto']?></div>
          </td>
        </tr>
        <tr>
          <td height="15">
          	<div class="label">(-) Outras Deduções</div>
          </td>
        </tr>
        <tr>
          <td height="15" align="right" class="b_direita"><span class="texto" style="text-align:right">
            <?=$boleto['outos_descontos']?>
          </span></td>
        </tr>
        <tr>
          <td height="30" class="b_direita"><div class="label">(+) Mora/Multa</div><div class="texto"><?=$boleto['mora_multa']?></div></td>
        </tr>
        <tr>
          <td height="30" class="b_direita"><div class="label">(+) Outros Acrécimos</div><div class="texto"><?=$boleto['outras_multas']?></div></td>
        </tr>
        <tr>
          <td height="30" class="b_direita">
          	<div class="label">(=) Valor Cobrado</div>
			<div class="texto_direita"></div>
          </td>
        </tr>
        <tr>
          <td colspan="7" class="b_direita">
         	<div class="label">Sacado</div>
			<div class="texto"><?=$boleto['sacado'].$boleto['sacado_cpf']?></div>
            <div class="label">Código da Baixa</div>
			<div class="texto"><?=$boleto['codigo_baixa']?></div>
          </td>
        </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:1px dotted #000000">
      <tr>
        <td width="408" height="60" bgcolor="#D6D6D6" style="font-size:10px">
            Recebimento através do cheque no._________________ do banco ____________  <br/>
            Esta quitação só terá validade após pagamento do cheque pelo banco sacado.
        </td>
        <td width="40%" align="center" valign="top" class="borda_autentica"><div class="label">Autenticação Mecânica - Recibo do Sacado</div></td>
      </tr>
    </table>

        
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0px; padding:0px">
            <tr>
          <td width="10%" class="b_esquerda">
             <img src="<?=SCL_IMG?>boleto/<?=$boleto['codigoBanco']?>.jpg" border=0></td>
          <td width="6%" align="center" valign="bottom"  class="b_esquerda">
            <div class="texto_banco"><?=$boleto['codigo_banco_com_dv']?></div>
          </td>
          <td width="84%" align="right" valign="bottom" class="b_direita" style="font-size:14px">
            <?=$boleto['linhaDigitavel'] ?><br />
          </td>
        </tr>
      </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:0px; padding:0px">
        <tr>
          <td height="5" colspan="6" class="label b_esquerda_cima">
          	Local de Pagamento</td>
          <td width="20%">
          	<div class="label">Vencimento</div>
          </td>
        </tr>
        <tr>
          <td height="5" colspan="6" class="b_esquerda texto"> 
              <?=$boleto['txtbanco']?>
          </td>
          <td align="right" class="b_direita texto_direita">
            <?=$boleto['vencimento']?>
          </td>
        </tr>
        <tr>
          <td colspan="6" rowspan="2" valign="top" class="b_esquerda">
          	<div class="label">Cedente</div>
		  <?=$boleto['cedente']?> 
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <?=$boleto['cedente_cnpj']?></td>
          <td valign="top">
          	<div class="label">Agencia/Código Cedente</div>
          </td>
        </tr>
        <tr>
          <td align="right" valign="top" class="b_direita texto_direita">
            <?=$boleto['agencia']?>
          </td>
        </tr>
        <tr>
          <td width="10%" rowspan="2" class="b_esquerda"><div class="label">Data do Documento</div><?=$boleto['data_doc']?></td>
          <td colspan="2" rowspan="2" class="b_esquerda"><div class="label">Nº do Documento</div><?=$boleto['numero_doc']?></td>
          <td width="7%" rowspan="2" align="center" class="b_esquerda"><div class="label">Espécie Doc.</div><?=$boleto['especie']?></td>
          <td width="7%" rowspan="2" align="center" class="b_esquerda"><div class="label">Aceite</div><?=$boleto['aceite']?></td>
          <td width="30%" rowspan="2" class="b_esquerda"><div class="label">Dt. do Processamento</div>
          <?=$boleto['dt_processamento']?></td>
          <td height="15"><div class="label">Nosso Número</div></td>
        </tr>
        <tr>
          <td height="15" align="right" class="b_direita texto_direita"><?=$boleto['nosso_numero']?></td>
        </tr>
        <tr>
          <td rowspan="2" class="b_esquerda"><div class="label">Uso do Banco</div></td>
          <td width="7%" rowspan="2" align="center" class="b_esquerda"><div class="label">Carteira</div><?=$boleto['carteira']?></td>
          <td width="7%" rowspan="2" align="center" class="b_esquerda"><div class="label">Espécie</div><?=$boleto['especie']?></td>
          <td colspan="2" rowspan="2" class="b_esquerda"><div class="label">Quantidade</div><?=$boleto['quantidade']?></td>
          <td rowspan="2" class="b_esquerda"><div class="label">Valor</div><?=$boleto['valor_documento']?></td>
          <td height="15"><div class="label">(=) Valor do Documento</div></td>
        </tr>
        <tr>
          <td height="15" align="right" class="b_direita texto_direita"><?=$boleto['valorBoleto']?></td>
        </tr>
        <tr>
          <td colspan="6" rowspan="6" class="b_esquerda texto">
          	<?=$boleto['instrucao']?>
          </td>
          <td height="30" class="b_direita">
          	<div class="label">(-) Desconto / Abatimento</div>
			<div class="texto_direita"><?=$boleto['desconto']?></div>
          </td>
        </tr>
        <tr>
          <td height="15">
          	<div class="label">(-) Outras Deduções</div>
          </td>
        </tr>
        <tr>
          <td height="15" align="right" class="b_direita"><span class="texto" style="text-align:right">
            <?=$boleto['outos_descontos']?>
          </span></td>
        </tr>
        <tr>
          <td height="30" class="b_direita"><div class="label">(+) Mora/Multa</div><div class="texto"><?=$boleto['mora_multa']?></div></td>
        </tr>
        <tr>
          <td height="30" class="b_direita"><div class="label">(+) Outros Acrécimos</div><div class="texto"><?=$boleto['outras_multas']?></div></td>
        </tr>
        <tr>
          <td height="30" class="b_direita">
          	<div class="label">(=) Valor Cobrado</div>
			<div class="texto_direita"></div>
          </td>
        </tr>
        <tr>
          <td colspan="7" class="b_direita">
         	<div class="label">Sacado</div>
			<div class="texto"><?=$boleto['sacado'].$boleto['sacado_cpf']?></div>
            <div class="label">Código da Baixa</div>
			<div class="texto"><?=$boleto['codigo_baixa']?></div>
          </td>
        </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="60%">
            <img src="<?=SCL_RAIZ?>financeiro/boleto/barras?barras=<?=$boleto['codigoBarras']?>"></td>
        <td width="40%" align="center" valign="top" class="borda_autentica"><div class="label">Autenticação mecânica - Ficha de Compensação</div></td>
      </tr>
    </table>
    
    
    	
	</td>
  </tr>
</table>
</BODY>
</HTML>
<? //exit?>