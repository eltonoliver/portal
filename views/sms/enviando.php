<div class="row">
<?php
$smssoap = new Soapsms();
foreach($dados as $r){
    $smssoap->celular = $r['celular'];
    $smssoap->mensagem = $r['mensagem'];
    $smssoap->codigo = $r['codigosms'];
    $re = $smssoap->enviar();
    echo $retorno = '<div class="text-success">Enviado com sucesso!</div>';
}
?>
    </div>
 <? exit(); ?>

