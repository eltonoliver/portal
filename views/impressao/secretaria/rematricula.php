<table width="100%" border="0" align="center" cellpadding="3" cellspacing="3">
  <tr>
      <td align="center">
          <h4>Requerimento de Renovação de Matrícula para 2018.</h4>
      </td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" style="font-size:12px;; border: none">
  <tr>
      <td colspan="3" height="30" align="left" style="background: #C0C0C0">
          <h4>1. DADOS DO ALUNO.</h4>
      </td>
  </tr>
  <tr>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Matrícula:</small> <br/><?=$rematricula[0]['CD_ALUNO']?>
      </td>  
      <td colspan="2" align="left" valign="top" style="background: #EFEFEF">
       <small>Nome:</small> <br/><?=$rematricula[0]['NM_ALUNO']?>
      </td>
  </tr>
  <tr>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small> Modalidade:</small> <br/><?=$rematricula[0]['DC_MODALIDADE']?>  
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Curso:</small> <br/><?=$rematricula[0]['NM_CURSO_RED']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
        <small>Série:</small> <br/><?=$rematricula[0]['NM_SERIE']?>  
      </td>
  </tr>  
</table>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="0" style="font-size:12px">
  <tr>
      <td colspan="4" height="30" align="left"  style="background: #C0C0C0">
          <h4>2. ENDEREÇO.</h4>
      </td>
  </tr>
  <tr>
      <td colspan="2" align="left" valign="top" style="background: #EFEFEF">
       <small>Logradouro:</small> <br/><?=$rematricula[0]['ALU_ENDERECO']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Número:</small> <br/><?=$rematricula[0]['ALU_END_NUMERO']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>CEP:</small> <br/><?=$rematricula[0]['ALU_CEP']?>
      </td>
  </tr>
  <tr>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Complemento:</small> <br/><?=$rematricula[0]['ALU_END_COMPLEMENTO']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small> Bairro:</small> <br/><?=$rematricula[0]['ALU_BAIRRO']?>  
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Cidade:</small> <br/><?=$rematricula[0]['ALU_CIDADE']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small> Estado:</small> <br/><?=$rematricula[0]['ALU_ESTADO']?>  
      </td>
  </tr>
  <tr>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>E-mail:</small> <br/><?=$rematricula[0]['ALU_EMAIL']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
        <small>Tel. Residencial:</small> <br/><?=$rematricula[0]['ALU_TEL_RES']?>  
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Tel. Celular:</small> <br/><?=$rematricula[0]['ALU_TEL_CEL']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small> Tel. Comercial:</small> <br/><?=$rematricula[0]['ALU_TEL_COM']?>  
      </td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" style="font-size:12px">
  <tr>
      <td colspan="3" height="30" align="left" style="background: #C0C0C0; ">
          <h4>3. DADOS DO PAI.</h4>
      </td>
  </tr>
  <tr>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Nome:</small> <br/><?=$rematricula[0]['NM_PAI']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Data de Nascimento:</small> <br/><?=date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$rematricula[0]['PAI_DATA_NASC'])))))?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
        <small>Telefone:</small> <br/><?=$rematricula[0]['PAI_TELEFONE']?>  
      </td>
  </tr>
  <tr>
      <td colspan="2"  align="left" valign="top" style="background: #EFEFEF">
       <small>Empresa:</small> <br/><?=$rematricula[0]['PAI_LOCAL_TRABALHO']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Ocupação:</small> <br/><?=$rematricula[0]['PAI_PROFISSAO']?>
      </td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" style="font-size:12px">
  <tr>
      <td colspan="3" height="30" align="left" style="background: #C0C0C0; ">
          <h4>4. DADOS DA MÃE.</h4>
      </td>
  </tr>
  <tr>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Nome:</small> <br/><?=$rematricula[0]['NM_MAE']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Data de Nascimento:</small> <br/><?=date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$rematricula[0]['MAE_DATA_NASC'])))))?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
        <small>Telefone:</small> <br/><?=$rematricula[0]['MAE_TELEFONE']?>  
      </td>
  </tr>
  <tr>
      <td height="30" colspan="2" align="left" valign="top" style="background: #EFEFEF">
       <small>Empresa:</small> <br/><?=$rematricula[0]['MAE_LOCAL_TRABALHO']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Ocupação:</small> <br/><?=$rematricula[0]['MAE_PROFISSAO']?>
      </td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" style="font-size:12px">
  <tr>
      <td colspan="4" height="30" align="left" style="background: #C0C0C0; ">
          <h4>5. DADOS DO RESPONSÁVEL FINANCEIRO.</h4>
      </td>
  </tr>
  <tr>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Nome:</small> <br/><?=$rematricula[0]['NM_RESPONSAVEL']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>CPF:</small> <br/><?=$rematricula[0]['RES_CPF']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>RG:</small> <br/><?=$rematricula[0]['RES_IDENT_NR']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Orgão Expedidor:</small> <br/><?=$rematricula[0]['RES_IDENT_ORGAO']?>
      </td>
  </tr>
  <tr>
      <td colspan="2" align="left" valign="top" style="background: #EFEFEF">
       <small>Logradouro:</small> <br/><?=$rematricula[0]['RES_ENDERECO']?>
      </td>
      <td colspan="2" align="left" valign="top" style="background: #EFEFEF">
       <small>Número:</small> <br/><?=$rematricula[0]['RES_END_NUMERO']?>
      </td>
  </tr>
  <tr>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>CEP:</small> <br/><?=$rematricula[0]['RES_CEP']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
        <small>Cidade:</small> <br/><?=$rematricula[0]['RES_CIDADE']?>  
      </td>
      <td colspan="2" align="left" valign="top" style="background: #EFEFEF">
       <small>Estado:</small> <br/><?=$rematricula[0]['RES_ESTADO']?>
      </td>
  </tr>
  <tr>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>E-mail:</small> <br/><?=$rematricula[0]['RES_EMAIL']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Tel. Residencial:</small> <br/><?=$rematricula[0]['RES_TEL_RES']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Tel. Celular:</small> <br/><?=$rematricula[0]['RES_TEL_CEL']?>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>Tel. Comercial:</small> <br/><?=$rematricula[0]['RES_TEL_COM']?>
      </td>
  </tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="2" style="font-size:12px">
  <tr>
      <td colspan="3" height="30" align="left" style="background: #C0C0C0; ">
          <h4>6. DADOS DO RESPONSÁVEL PEDAGÓGICO.</h4>
      </td>
  </tr>
  <tr>
      <td height="30" align="left" valign="top" style="background: #EFEFEF">
       <small>Nome:</small> <br/>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>E-mail:</small> <br/>
      </td>
      <td align="left" valign="top" style="background: #EFEFEF">
       <small>RG:</small> <br/>
      </td>
  </tr>
  <tr>
      <td colspan="3" align="left" valign="top">
          <br/><br/>
          Por meio deste, declaro no qualidade de responsável financeiro que autorizo a 
          reserva da vaga para a matrícula /2018 neste 
          Estabelecimento de Ensino do aluno(a) <?=$rematricula[0]['NM_ALUNO']?> para cursar a <?=$proxima[0]['PROX_NM_SERIE']?>
          série do <?=$proxima[0]['PROX_NM_CURSO']?>.
          <br/><br/>
          Informamos que este documento deverá ser assinado e devolvido a escola até o dia 31/10/2017, 
          para que possamos reservar sua vaga.<br/><br/>
          Obs: Qualquer alteração de dados na ficha deverá ser feita junto à secretaria.<br/><br/>
      </td>
  </tr>
  <tr>
      <td colspan="3" height="100" align="center" valign="bottom">
          Manaus-AM, <?=date('d')?> de outubro de <?=date('Y')?>.<br/><br/><br/>
          _________________________________________________________________________<br/>
            <?=$rematricula[0]['NM_RESPONSAVEL']?>
      </td>
  </tr>
</table>
