<!DOCTYPE html>
<html class="no-js fuelux">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <title><?= SCL_DEF_TITULO ?></title>
        <meta name="description" content="overview &amp; stats">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body class="login-layout" style="">
        <table width="800" align="center">
            <thead>
                <tr>
                    <th width="10%">Protocolo de Consulta</th>
                </tr>
            </thead>
        </table>
    <hr>
        
        <table width="800" border="0"  cellpadding="0" cellspacing="0">
            <thead>
                <tr style="border: 0px solid #666; font-family: Verdana, Geneva, sans-serif; font-size: 14px;">
                    <th width="13%" height="30" align="left" valign="middle" ><strong>Matrícula</strong>: </th>
                    <th width="87%" height="30" align="left" valign="middle" ><?=$dados[0]['CD_ALUNO']?></th>
                </tr>
                <tr style="border:0px solid #666; ">
                  <th width="13%" height="30" align="left" valign="middle" style="font-family: Verdana, Geneva, sans-serif; font-size: 14px;">Nome: </th>
                    <th width="87%" height="30" align="left" valign="middle"><?=$dados[0]['NM_ALUNO']?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" align="center" valign="middle" style="border: 1px solid #ccc; font-size: 12px; background-color: #ccc"></td>
                </tr>
                <tr><td colspan="2"></td></tr><tr><td colspan="2"></td></tr><tr><td colspan="2"></td></tr>
                <tr style="font-family: Verdana, Geneva, sans-serif; font-size: 14px;"><td align="center" colspan="2"><font style="text-transform: uppercase; font-weight: bold; text-decoration: underline;">Relato Descritivo</font></td></tr>
                <tr><td colspan="2"></td></tr><tr><td colspan="2"></td></tr><tr><td colspan="2"></td></tr>
                <tr style="font-family: Verdana, Geneva, sans-serif; font-size: 14px;">
                    <td colspan="2" align="rigth" valign="middle" style="border: 0px solid #666; font-size: 12px;"><?=$dados[0]['DESCRICAO']?></td>
                </tr>
                <tr><td colspan="2"></td></tr><tr><td colspan="2"></td></tr><tr><td colspan="2"></td></tr>
                <tr>
                    <td colspan="2" align="center" valign="middle" style="border: 1px solid #ccc; font-size: 12px; background-color: #ccc"></td>
                </tr>
            </tbody>
        </table>
    <br>
        <table width="800" border="0" align="center">
            <caption>Assinaturas</caption>
            <thead>
            <tr>    
                <td></td>
            </tr>
            </thead>    
            <tbody>
                <tr>
                    <th width="40%"  style="border-bottom:1px solid #666">&nbsp;</th>
                </tr>
                <tr>
                    <th>Assinatura do(a) Psicologo(a)</th>
                </tr>
                <tr>
                    <th width="40%">&nbsp;</th>
                </tr>
                
                <!--assinatura dos participantes-->
                <?php foreach ($participante as $p){ ?>
                <tr>
                    <th width="40%"  style="border-bottom:1px solid #666">&nbsp;</th>
                </tr>
                <tr>
                    <th><?=$p['NOME']?></th>
                </tr>
                <tr>
                    <th width="40%">&nbsp;</th>
                </tr>
                <?php } ?>
                
                
            </tbody>
        </table>
        <p>&nbsp;</p>
    </body>
</html>