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
        <table width="800" align="center" >
            <thead>
                <tr>
                    <th width="5%" valign="top"><img src="<?= SCL_IMG ?>logo_relatorio.png" /></th>
                    <th width="95%" align="right" valign="middle">Relatório de 
                        <?php
                        if(count($listar_tipo_nota) > 0){ 
                            foreach($listar_tipo_nota as $l){ 
                        $sel='';
                        if($numero_nota == $l['NUM_NOTA']){?>
                        <label>
                            <?= $l['DC_TIPO_NOTA'] . ' (' . $l['BIMESTRE'] ?>
                            º Bimestre)</label>
                        <?php  } } } ?>
                        <br>
                        Turma: 
                        <?= $turma ?>
                        <br>
                        Disciplina: 
                        <?= $txtdisciplina ?>
                        <br>
                        Data de Emissão: <?= date('d/m/Y h:m:s') ?>
                        <br>
                        Por: <?= $this->session->userdata('SCL_SSS_USU_NOME') ?>
                    </th>
                </tr>
                <tr>
                    <th  style="border-bottom:1px solid #666" colspan="2">&nbsp;</th>
                </tr>
            </thead>
        </table>
        <br>
        <table width="800" align="center">
            <thead>
                <tr>
                    <th width="10%">Relação dos Alunos e Notas</th>
                </tr>
            </thead>
        </table>
        <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
            <thead>
                <tr style="border:1px solid #666; background:#CCC">
                    <th width="20%" height="30" align="center" valign="middle" style="border:1px solid #666">Matrícula</th>
                    <th width="70%" align="center" valign="middle" style="border:1px solid #666">Aluno</th>
                    <th width="10%" align="center" valign="middle" style="border:1px solid #666">Nota</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($listar_aluno) > 0){ foreach($listar_aluno as $row){ ?>
                <tr>
                    <td align="center" valign="middle" style="border:1px solid #666"><?= $row->CD_ALUNO ?></td>
                    <td style="border:1px solid #666" valign="middle"><?= $row->NM_ALUNO ?></td>
                    <td align="center" style="border:1px solid #666">
                        <input name="aluno_<?= $row->CD_ALU_DISC ?>" type="hidden" value="<?= $row->CD_ALU_DISC ?>" >
                        <?php
                        if($row->NOTA) 
                        $valor = $row->NOTA;
                        else 
                        $valor='-';
                        echo $valor; ?>
                    </td>
                </tr>
                <?php  } } ?> 
            </tbody>
        </table>
        <p>&nbsp;</p>
        <table width="800" border="0" align="center">
            <thead>
                <tr>
                    <th width="40%"  style="border-bottom:1px solid #666">&nbsp;</th>
                    <th width="10%">&nbsp;</th>
                    <th width="40%"  style="border-bottom:1px solid #666">&nbsp;</th>
                </tr>
                <tr>
                    <th>Assinatura do Professor</th>
                    <th>&nbsp;</th>
                    <th>Assinatura do Coordenador</th>
                </tr>
            </thead>
        </table>
        <p>&nbsp;</p>
    </body>
</html>