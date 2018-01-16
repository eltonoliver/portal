
<?php

// Envia requisição
function httprequest($paEndereco, $paPost) {

    $sessao_curl = curl_init();
    curl_setopt($sessao_curl, CURLOPT_URL, $paEndereco);

    curl_setopt($sessao_curl, CURLOPT_FAILONERROR, true);

    //  CURLOPT_SSL_VERIFYPEER
    //  verifica a validade do certificado
    curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYPEER, true);
    //  CURLOPPT_SSL_VERIFYHOST
    //  verifica se a identidade do servidor bate com aquela informada no certificado
    curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYHOST, 2);

    //  CURLOPT_SSL_CAINFO
    //  informa a localização do certificado para verificação com o peer
    curl_setopt($sessao_curl, CURLOPT_CAINFO, getcwd() . "/assets/ssl/VeriSignClass3PublicPrimaryCertificationAuthority-G5.crt");
    curl_setopt($sessao_curl, CURLOPT_SSLVERSION, 3);

    //  CURLOPT_CONNECTTIMEOUT
    //  o tempo em segundos de espera para obter uma conexão
    curl_setopt($sessao_curl, CURLOPT_CONNECTTIMEOUT, 10);

    //  CURLOPT_TIMEOUT
    //  o tempo máximo em segundos de espera para a execução da requisição (curl_exec)
    curl_setopt($sessao_curl, CURLOPT_TIMEOUT, 40);

    //  CURLOPT_RETURNTRANSFER
    //  TRUE para curl_exec retornar uma string de resultado em caso de sucesso, ao
    //  invés de imprimir o resultado na tela. Retorna FALSE se há problemas na requisição
    curl_setopt($sessao_curl, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($sessao_curl, CURLOPT_POST, true);
    curl_setopt($sessao_curl, CURLOPT_POSTFIELDS, $paPost);

    $resultado = curl_exec($sessao_curl);

    curl_close($sessao_curl);

    if ($resultado) {
        return $resultado;
    } else {
        return curl_error($sessao_curl);
    }
}

// Monta URL de retorno
function ReturnURL($tipo) {

    switch($tipo){
        case 'h': 
            $pageURL = 'http://localhost/portal/financeiro/pagamento/retorno';
        break;
        case 'p': 
            $pageURL = 'https://www.seculomanaus.com.br/homologacao/financeiro/pagamento/retorno';
        break;
    
    }

    $file = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
    $ReturnURL = str_replace($file, "retorno", $pageURL);

    return $ReturnURL;
}

$logFile = getcwd() . "application/logs/log.log";

// Verifica em Resposta XML a ocorrência de erros 
// Parâmetros: XML de envio, XML de Resposta
function VerificaErro($vmPost, $vmResposta) {
    $error_msg = null;

    try {
        if (stripos($vmResposta, "SSL certificate problem") !== false) {
            throw new Exception("CERTIFICADO INVÁLIDO - O certificado da transação não foi aprovado", "099");
        }

        $objResposta = simplexml_load_string($vmResposta, null, LIBXML_NOERROR);
        if ($objResposta == null) {
            throw new Exception("HTTP READ TIMEOUT - o Limite de Tempo da transação foi estourado", "099");
        }
    } catch (Exception $ex) {
        $error_msg = "     Código do erro: " . $ex->getCode() . "\n";
        $error_msg .= "     Mensagem: " . $ex->getMessage() . "\n";

        // Gera página HTML
        echo '<html><head><title>Erro na transação</title></head><body>';
        echo '<span style="color:red;, font-weight:bold;">Ocorreu um erro em sua transação!</span>' . '<br />';
        echo '<span style="font-weight:bold;">Detalhes do erro:</span>' . '<br />';
        echo '<pre>' . $error_msg . '<br /><br />';
        //echo "     XML de envio: " . "<br />" . htmlentities($vmPost);
        echo '</pre><p><center>';
        echo '<input type="button" value="Retornar" onclick="javascript:if(window.opener!=null){window.opener.location.reload();' .
        'window.close();}else{window.location.href=' . "'index.php';" . '}" />';
        echo '</center></p></body></html>';
        $error_msg .= "     XML de envio: " . "\n" . $vmPost;

        // Dispara o erro
        trigger_error($error_msg, E_USER_ERROR);
        return true;
    }

    if ($objResposta->getName() == "erro") {
        $error_msg = "     Código do erro: " . $objResposta->codigo . "\n";
        $error_msg .= "     Mensagem: " . utf8_decode($objResposta->mensagem) . "\n";
        // Gera página HTML
        echo '<html><head><title>Erro na transação</title></head><body>';
        echo '<span style="color:red;, font-weight:bold;">Ocorreu um erro em sua transação!</span>' . '<br />';
        echo '<span style="font-weight:bold;">Detalhes do erro:</span>' . '<br />';
        echo '<pre>' . $error_msg . '<br /><br />';
        //echo "     XML de envio: " . "<br />" . htmlentities($vmPost);
        echo '</pre><p><center>';
        echo '<input type="button" value="Retornar" onclick="javascript:if(window.opener!=null){window.opener.location.reload();' .
        'window.close();}else{window.location.href=' . "'index.php';" . '}" />';
        echo '</center></p></body></html>';
        $error_msg .= "     XML de envio: " . "\n" . $vmPost;

        // Dispara o erro
        trigger_error($error_msg, E_USER_ERROR);
    }
}

// Grava erros no arquivo de log
function Handler($eNum, $eMsg, $file, $line, $eVars) {
    $logFile = getcwd() . "/application/logs/log.log";
    $e = "";
    $Data = date("Y-m-d H:i:s (T)");

    $errortype = array(
        E_ERROR => 'ERROR',
        E_WARNING => 'WARNING',
        E_PARSE => 'PARSING ERROR',
        E_NOTICE => 'RUNTIME NOTICE',
        E_CORE_ERROR => 'CORE ERROR',
        E_CORE_WARNING => 'CORE WARNING',
        E_COMPILE_ERROR => 'COMPILE ERROR',
        E_COMPILE_WARNING => 'COMPILE WARNING',
        E_USER_ERROR => 'ERRO NA TRANSACAO',
        E_USER_WARNING => 'USER WARNING',
        E_USER_NOTICE => 'USER NOTICE',
        E_STRICT => 'RUNTIME NOTICE',
        E_RECOVERABLE_ERROR => 'CATCHABLE FATAL ERROR'
    );

    $e .= "**********************************************************\n";
    $e .= $eNum . " " . $errortype[$eNum] . " - ";
    $e .= $Data . "\n";
    $e .= "     ARQUIVO: " . $file . "(Linha " . $line . ")\n";
    $e .= "     MENSAGEM: " . "\n" . $eMsg . "\n\n";

    error_log($e, 3, $logFile);
}

$olderror = set_error_handler("Handler");
ini_set('error_log', $logFile);
ini_set('log_errors', 'On');
ini_set('display_errors', 'On');
ini_set("date.timezone", "America/Manaus");
?>
