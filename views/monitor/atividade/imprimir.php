<table width="100%" style="width:100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center" bgcolor="#CCC0" colspan="7"  style="font-size:16px;" with="10%"> 
            <i class="fa fa-clock-o"></i> Relação de Atividades Extras da Turma: <?= $this->input->post('turma') ?> 
        </td>
    </tr>
    
    <tr>
        <td align="left"   bgcolor="#CCC0" >Nome</td>
        <td align="center" bgcolor="#CCC0"   style="font-size:10px;" width="10%"> SEGUNDA </td>
        <td align="center" bgcolor="#D6D6D6"  style="font-size:10px;" width="10%"> TERÇA   </td>
        <td align="center" bgcolor="#D6D6D6"  style="font-size:10px;" width="10%"> QUARTA  </td>
        <td align="center" bgcolor="#D6D6D6" style="font-size:10px;" width="10%"> QUINTA  </td>
        <td align="center" bgcolor="#D6D6D6"  style="font-size:10px;" width="10%"> SEXTA   </td>
        <td align="center" bgcolor="#D6D6D6" style="font-size:10px;" width="10%"> SÁBADO  </td>
    </tr>
    <? foreach ($aluno as $s) {
    $tempo = $this->secretaria->atividade(array('aluno' => $s['CD_ALUNO'], 'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO')));
    if ($tempo != 1) {$i = 0;
        foreach ($tempo as $r) { 
        
       ?>
    <tr>
        <? if($i == 0) { ?>
        <td bgcolor="#D6D6D6" rowspan="<?=count($tempo)?>" align="left" style="font-size:10px;"><strong> <?= $s['CD_ALUNO'] . ' - ' . $s['NM_ALUNO'] ?></strong></td>
        <? } ?>
        <td bgcolor="#D6D6D6" align="center" style="font-size:10px;">  <? $tem = explode('<br />', trim(nl2br($r['SEGUNDA']))); echo $tem[1]; ?> </td>
        <td bgcolor="#D6D6D6" align="center" style="font-size:10px;"> <? $tem = explode('<br />', trim(nl2br($r['TERCA']))); echo $tem[1];  ?> </td>
        <td bgcolor="#D6D6D6" align="center" style="font-size:10px;"> <? $tem = explode('<br />', trim(nl2br($r['QUARTA']))); echo $tem[1];  ?>  </td>
        <td bgcolor="#D6D6D6" align="center" style="font-size:10px;"> <? $tem = explode('<br />', trim(nl2br($r['QUINTA'])));  echo $tem[1];  ?> </td>
        <td bgcolor="#D6D6D6" align="center" style="font-size:10px;"> <? $tem = explode('<br />', trim(nl2br($r['SEXTA'])));  echo $tem[1]; ?> </td>
        <td bgcolor="#D6D6D6" align="center" style="font-size:10px;"> <? $tem = explode('<br />', trim(nl2br($r['SABADO']))); echo $tem[1];  ?> </td>
    </tr>
  <? $i = $i+1; } } } ?>
</table>