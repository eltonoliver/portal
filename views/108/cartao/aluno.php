<?
$linhas = ($cartao[0]['QTDE_QUESTOES'] / 2);
$n_prova = strlen($cartao[0]['NUM_PROVA']);
$n_aluno = strlen($cartao[0]['CD_ALUNO']);
?>
<table style="width:8.2cm">
    <? for($j; $j < $n_aluno; $j++){ ?>
    <tr style="font-size:9px">
        <td align="center"></td>
        <td align="center" style="padding: 2px; width:7.5%"><?=substr($cartao[0]['CD_ALUNO'],$j,1)?></td>
        <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000; <?=((substr($cartao[0]['CD_ALUNO'],$j,1) == 0)? 'background:#000;' : '')?>">0</td>
        <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000; <?=((substr($cartao[0]['CD_ALUNO'],$j,1) == 1)? 'background:#000;' : '')?>">1</td>
        <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000; <?=((substr($cartao[0]['CD_ALUNO'],$j,1) == 2)? 'background:#000;' : '')?>">2</td>
        <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000; <?=((substr($cartao[0]['CD_ALUNO'],$j,1) == 3)? 'background:#000;' : '')?>">3</td>
        <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000; <?=((substr($cartao[0]['CD_ALUNO'],$j,1) == 4)? 'background:#000;' : '')?>">4</td>
        <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000; <?=((substr($cartao[0]['CD_ALUNO'],$j,1) == 5)? 'background:#000;' : '')?>">5</td>
        <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000; <?=((substr($cartao[0]['CD_ALUNO'],$j,1) == 6)? 'background:#000;' : '')?>">6</td>
        <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000; <?=((substr($cartao[0]['CD_ALUNO'],$j,1) == 7)? 'background:#000;' : '')?>">7</td>
        <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000; <?=((substr($cartao[0]['CD_ALUNO'],$j,1) == 8)? 'background:#000;' : '')?>">8</td>
        <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000; <?=((substr($cartao[0]['CD_ALUNO'],$j,1) == 9)? 'background:#000;' : '')?>">9</td>
        <td align="center"></td>
    </tr>
    <? } ?>
    <tr>
        <td align="center" colspan="11" height="10"></td>
    </tr>
    
    <? for($i; $i < $n_prova; $i++){ ?>
    <tr style="font-size:9px">
        <td align="center"></td>
        <td align="center" style="padding: 2px; width:7.5%"><?=substr($cartao[0]['NUM_PROVA'],$i,1)?></td>
        <td align="center" style="<?=((substr($cartao[0]['NUM_PROVA'],$i,1) == 0)? 'background:#000;' : '')?> padding: 2px; width:7.5%; border: 1px solid #000">0</td>
        <td align="center" style="<?=((substr($cartao[0]['NUM_PROVA'],$i,1) == 1)? 'background:#000;' : '')?> padding: 2px; width:7.5%; border: 1px solid #000">1</td>
        <td align="center" style="<?=((substr($cartao[0]['NUM_PROVA'],$i,1) == 2)? 'background:#000;' : '')?> padding: 2px; width:7.5%; border: 1px solid #000">2</td>
        <td align="center" style="<?=((substr($cartao[0]['NUM_PROVA'],$i,1) == 3)? 'background:#000;' : '')?> padding: 2px; width:7.5%; border: 1px solid #000">3</td>
        <td align="center" style="<?=((substr($cartao[0]['NUM_PROVA'],$i,1) == 4)? 'background:#000;' : '')?> padding: 2px; width:7.5%; border: 1px solid #000">4</td>
        <td align="center" style="<?=((substr($cartao[0]['NUM_PROVA'],$i,1) == 5)? 'background:#000;' : '')?> padding: 2px; width:7.5%; border: 1px solid #000">5</td>
        <td align="center" style="<?=((substr($cartao[0]['NUM_PROVA'],$i,1) == 6)? 'background:#000;' : '')?> padding: 2px; width:7.5%; border: 1px solid #000">6</td>
        <td align="center" style="<?=((substr($cartao[0]['NUM_PROVA'],$i,1) == 7)? 'background:#000;' : '')?> padding: 2px; width:7.5%; border: 1px solid #000">7</td>
        <td align="center" style="<?=((substr($cartao[0]['NUM_PROVA'],$i,1) == 8)? 'background:#000;' : '')?> padding: 2px; width:7.5%; border: 1px solid #000">8</td>
        <td align="center" style="<?=((substr($cartao[0]['NUM_PROVA'],$i,1) == 9)? 'background:#000;' : '')?> padding: 2px; width:7.5%; border: 1px solid #000">9</td>
        <td align="center"></td>
    </tr>
    <? } ?>
</table>
<table style="width:8.2cm">
    <tr>
        <td colspan="14" height="5">

        </td>
    </tr>
    <? for ($i = 1; $i <= $linhas; $i++) { ?>
        <tr style="font-size:10px">
            <td align="center" style="background:#000; padding: 2px; width:3%"></td>
            <td align="center" style="background:#000; color:#FFF; padding: 2px; width:4%"><?= $i ?></td>
            <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000">A</td>
            <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000">B</td>
            <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000">C</td>
            <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000">D</td>
            <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000">E</td>

            <td align="center" style="background:#000; color:#FFF; padding: 2px; width:4%"><?= ($linhas + $i) ?></td>
            <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000">A</td>
            <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000">B</td>
            <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000">C</td>
            <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000">D</td>
            <td align="center" style="padding: 2px; width:7.5%; border: 1px solid #000">E</td>
            <td align="center" style="padding: 2px; width:3%"></td>
        </tr>
    <? } ?>
</table>