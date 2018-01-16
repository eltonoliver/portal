


<?= str_pad('MATRICULA',13," ",STR_PAD_RIGHT).str_pad('NOME',43," ",STR_PAD_RIGHT).str_pad('FUNÇÃO',15," ",STR_PAD_RIGHT).str_pad('RG',15," ",STR_PAD_RIGHT).str_pad('CPF',14," ",STR_PAD_RIGHT).str_pad('CTPS',15," ",STR_PAD_RIGHT).str_pad('VIA',5," ",STR_PAD_RIGHT).str_pad('ADMISSAO',10," ",STR_PAD_RIGHT)?>

<?
foreach ($pessoa as $p) {
$s = $this->funcionario->Professor($s = array('codigo' => $p->CD_PROFESSOR));
if ($s[0]['FOTO'] != '') {?>
<?= $s[0]['CHAPA_COM_DV'] . $s[0]['VIA'] ?>   <?= str_pad($p->NM_PROFESSOR,40," ",STR_PAD_RIGHT) ?> PROFESSOR(A)   <?= str_pad($s[0]['RG'],15," ",STR_PAD_RIGHT) ?><?= str_pad($s[0]['CPF'],14," ",STR_PAD_RIGHT) ?><?= str_pad($s[0]['CTPS'],15," ",STR_PAD_RIGHT) ?><?= str_pad($s[0]['VIA'],5," ",STR_PAD_RIGHT) ?><?= str_pad(date('d/m/Y', strtotime($s[0]['DT_ADMISSAO'])),10," ",STR_PAD_RIGHT) ?>         
<?}}?>
<? exit(); ?>