<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
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
      </table></td>
  </tr>
</table>
<table width="90%" align="center" cellpadding="5" cellspacing="1">
  <tr>
    <td height="30" align="center"><h5><?= $titulo ?> <br/> Atividades Curriculares</h5></td>
  </tr>
</table>
<br/>
<? foreach ($listar as $r) { 
        if(($r['TURNO'] == 'A') && ($r['CD_JUSTIFICATIVA'] == ''))
            $i++;
        elseif($r['TURNO'] == 'B')
            $j++;
 }?>
Total de Faltas:<?=$i?> 
<br/>
<table class="table table-bordered table-striped"width="100%">
    <tr>
        <td bgcolor="#A0A0A0" style="font-size:14px">Dia</td>
        <td bgcolor="#A0A0A0" style="font-size:14px">Turno</td>
        <td bgcolor="#A0A0A0" style="font-size:14px">Tempo</td>
        <td bgcolor="#A0A0A0" style="font-size:14px">Disciplina</td>
        <td bgcolor="#A0A0A0" style="font-size:14px">Professor</td>
    </tr>
    <? foreach ($listar as $r) { 
        if(($r['TURNO'] == 'A') && ($r['CD_JUSTIFICATIVA'] == '')){
       // print_r($listar);
        ?>
        <tr>
            <td bgcolor="#D6D6D6" style="font-size:11px; padding: 5px"><?= date('d/m/Y', strtotime($r['DT_AULA'])) ?></td>
            <td bgcolor="#D6D6D6" style="font-size:11px"><? if($r['TURNO'] == 'A') echo 'MANHÃ'; elseif($r['TURNO'] == 'B') echo 'TARDE'; ?></td>
            <td bgcolor="#D6D6D6" style="font-size:11px"><?= $r['TEMPO_AULA'] ?> º Tempo</td>
            <td bgcolor="#D6D6D6" style="font-size:11px"><?=$r['CD_DISCIPLINA'].' - '. $r['NM_DISCIPLINA'] ?></td>
            <td bgcolor="#D6D6D6" style="font-size:11px"><?= $r['NM_PROFESSOR'] ?></td>
        </tr>
    <? } }?>
</table>






<table width="90%" align="center" cellpadding="5" cellspacing="1">
  <tr>
    <td height="30" align="center"><h5><?= $titulo ?> <br/> Atividades Extra</h5></td>
  </tr>
</table>
<br/>
Total de Faltas:<?=$j?> 
<br/>
<table class="table table-bordered table-striped"width="100%">
    <tr>
        <td bgcolor="#A0A0A0" style="font-size:14px; padding: 5px">Dia</td>
        <td bgcolor="#A0A0A0" style="font-size:14px; padding: 5px">Turno</td>
        <td bgcolor="#A0A0A0" style="font-size:14px; padding: 5px">Tempo</td>
        <td bgcolor="#A0A0A0" style="font-size:14px; padding: 5px">Disciplina</td>
        <td bgcolor="#A0A0A0" style="font-size:14px; padding: 5px">Professor</td>
    </tr>
    <? foreach ($listar as $r) { 
        if($r['TURNO'] == 'B' ){
       // print_r($listar);
        ?>
        <tr>
            <td bgcolor="#D6D6D6" style="font-size:11px; padding: 5px"><?= date('d/m/Y', strtotime($r['DT_AULA'])) ?></td>
            <td bgcolor="#D6D6D6" style="font-size:11px; padding: 5px"><? if($r['TURNO'] == 'A') echo 'MANHÃ'; elseif($r['TURNO'] == 'B') echo 'TARDE'; ?></td>
            <td bgcolor="#D6D6D6" style="font-size:11px; padding: 5px"><?= $r['TEMPO_AULA'] ?> º Tempo</td>
            <td bgcolor="#D6D6D6" style="font-size:11px; padding: 5px"><?=$r['CD_DISCIPLINA'].' - '. $r['NM_DISCIPLINA'] ?></td>
            <td bgcolor="#D6D6D6" style="font-size:11px; padding: 5px"><?= $r['NM_PROFESSOR'] ?></td>
        </tr>
    <? } }?>
</table>
<? //exit();?>