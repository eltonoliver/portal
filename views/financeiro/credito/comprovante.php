<?
echo '<table align="center" width="250px"><tr><td style="font-size:12px;">';
echo '<h3>Comprovante de Pagamento</h3>';
echo '<hr />';
echo 'Data de Transação: ' . $compra[0]['COMPROVANTE'] . '<br />';
echo 'Aluno: ' . $compra[0]['NM_ALUNO'] . '<br />';
echo 'Bandeira: ';
if ($compra[0]['NM_BANDEIRA'] == 4) {
    echo 'VISA <br />';
} elseif ($compra[0]['NM_BANDEIRA'] == 6) { 
    echo 'MASTERCARD <br />';
}
echo 'Forma de Pagamento: ' . $compra[0]['TP_TRANSACAO'] . '<br />';
echo 'Valor da Compra: ' . number_format($compra[0]['VL_RECEBIDO'],2,'.',',') . '<br />';

if ($compra[0]['FL_STATUS'] == 'COMPRA REALIZADA') {
    echo 'Referência: COMPRA REALIZADA DE CRÉDITO ONLINE<br />';
} else {
    echo 'Referência: ' . $compra[0]['VL_RECEBIDO'] . '<br />';
}
echo '</td></tr>';
echo '<tr><td >';
echo '<hr />';
echo '<div style="font-size:10px; margin-left:50px">Autenticaçao</div>';
echo '<div style="font-size:10px; margin-left:50px"><img  src="'.SCL_RAIZ.'financeiro/boleto/barras?barras='.$compra[0]['AUTENTICACAO'].'"></div>';
echo '<div style="font-size:10px; padding-left:150px">' . $compra[0]['AUTENTICACAO'] . ' </div>';
echo '<hr />';
echo '</td></tr></table>';
?>
