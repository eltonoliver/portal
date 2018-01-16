<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * 
 * VISA ELECTRON :Banco Bradesco, 
 *                Banco do Brasil, 
 *                Santander, 
 *                HSBC, 
 *                Itaú, 
 *                Mercantil, 
 *                Sicredi, 
 *                Banco de Brasília, 
 *                Banco da Amazônia, 
 *                Banco Espírito Santo 
 *                Banco do Nordeste.
 * 
 * MAESTRO: Banco Santander, 
 *          Banco de Brasília,
 *          Bancoob.
 * 
 * 
 */

class Cielo {

    private $logger;
    public $dadosEcNumero = SECULO_CIELO;
    public $dadosEcChave = SECULO_CHAVE_CIELO;
    public $dadosPortadorNumero;
    public $dadosPortadorVal;
    public $dadosPortadorInd;
    public $dadosPortadorCodSeg;
    public $dadosPortadorNome;
    public $dadosPedidoNumero;
    public $dadosPedidoValor;
    public $dadosPedidoMoeda = "986";
    public $dadosPedidoData;
    public $dadosPedidoDescricao;
    public $dadosPedidoIdioma = "PT";
    public $formaPagamentoBandeira;
    public $formaPagamentoProduto;
    public $formaPagamentoParcelas = 1;
    public $urlRetorno;
    public $autorizar = 1;
    public $capturar = true;
    public $tid;
    public $status;
    public $urlAutenticacao;

    const ENCODING = "ISO-8859-1";

    function __construct() {
        // cria um logger
        $this->logger = new Logger();
    }

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
        curl_setopt($sessao_curl, CURLOPT_SSLVERSION, 4);

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
            echo '<html><head><title>Erro na transação</title><meta charset="UTF-8" /></head><body>';
            echo '<span style="color:red;, font-weight:bold;">Ocorreu um erro em sua transação!</span>' . '<br />';
            echo '<span style="font-weight:bold;">Detalhes do erro:</span>' . '<br />';
            echo '<pre>' . $error_msg . '<br /><br />';
            //echo "     XML de envio: " . "<br />" . htmlentities($vmPost);
            echo '</pre>';
            echo '</body></html>';
            $error_msg .= "     XML de envio: " . "\n" . $vmPost;

            // Dispara o erro
            trigger_error($error_msg, E_USER_ERROR);
            return true;
        }

        if ($objResposta->getName() == "erro") {
            $error_msg = "     Código do erro: " . $objResposta->codigo . "\n";
            $error_msg .= "     Mensagem: " . utf8_decode($objResposta->mensagem) . "\n";
            // Gera página HTML
            echo '<html><head><title>Erro na transação</title><meta charset="UTF-8" /></head><body>';
            echo '<span style="color:red;, font-weight:bold;">Ocorreu um erro em sua transação!</span>' . '<br />';
            echo '<span style="font-weight:bold;">Detalhes do erro:</span>' . '<br />';
            echo '<pre>' . $error_msg . '<br /><br />';
            //echo "     XML de envio: " . "<br />" . htmlentities($vmPost);
            echo '</pre>';
            echo '</body></html>';
            $error_msg .= "     XML de envio: " . "\n" . $vmPost;

            // Dispara o erro
            trigger_error($error_msg, E_USER_ERROR);
        }
    }

    function ReturnURL($url) {

        $pageURL = base_url() . $url;

        $file = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
        $ReturnURL = str_replace($file, "retorno", $pageURL);

        return $ReturnURL;
    }

    // Grava erros no arquivo de log
    function Handler($eNum, $eMsg, $file, $line, $eVars) {

        $obj = & get_instance();
        $obj->load->helper('url');
        $obj->load->library('session');


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

    // Geradores de XML
    private function XMLHeader() {
        return '<?xml version="1.0" encoding="' . self::ENCODING . '" ?>';
    }

    private function XMLDadosEc() {
        $msg = '<dados-ec>' . "\n      " .
                '<numero>'
                . $this->dadosEcNumero .
                '</numero>' . "\n      " .
                '<chave>'
                . $this->dadosEcChave .
                '</chave>' . "\n   " .
                '</dados-ec>';

        return $msg;
    }

    private function XMLDadosPortador() {
        $msg = '<dados-portador>' . "\n      " .
                '<numero>'
                . $this->dadosPortadorNumero .
                '</numero>' . "\n      " .
                '<validade>'
                . $this->dadosPortadorVal .
                '</validade>' . "\n      " .
                '<indicador>'
                . $this->dadosPortadorInd .
                '</indicador>' . "\n      " .
                '<codigo-seguranca>'
                . $this->dadosPortadorCodSeg .
                '</codigo-seguranca>' . "\n   ";

        // Verifica se Nome do Portador foi informado
        if ($this->dadosPortadorNome != null && $this->dadosPortadorNome != "") {
            $msg .= '   <nome-portador>'
                    . $this->dadosPortadorNome .
                    '</nome-portador>' . "\n   ";
        }

        $msg .= '</dados-portador>';

        return $msg;
    }

    private function XMLDadosCartao() {
        $msg = '<dados-cartao>' . "\n      " .
                '<numero>'
                . $this->dadosPortadorNumero .
                '</numero>' . "\n      " .
                '<validade>'
                . $this->dadosPortadorVal .
                '</validade>' . "\n      " .
                '<indicador>'
                . $this->dadosPortadorInd .
                '</indicador>' . "\n      " .
                '<codigo-seguranca>'
                . $this->dadosPortadorCodSeg .
                '</codigo-seguranca>' . "\n   ";

        // Verifica se Nome do Portador foi informado				
        if ($this->dadosPortadorNome != null && $this->dadosPortadorNome != "") {
            $msg .= '   <nome-portador>'
                    . $this->dadosPortadorNome .
                    '</nome-portador>' . "\n   ";
        }

        $msg .= '</dados-cartao>';

        return $msg;
    }

    private function XMLDadosPedido() {
        $this->dadosPedidoData = date("Y-m-d") . "T" . date("H:i:s");
        $msg = '<dados-pedido>' . "\n      " .
                '<numero>'
                . $this->dadosPedidoNumero .
                '</numero>' . "\n      " .
                '<valor>'
                . $this->dadosPedidoValor .
                '</valor>' . "\n      " .
                '<moeda>'
                . $this->dadosPedidoMoeda .
                '</moeda>' . "\n      " .
                '<data-hora>'
                . $this->dadosPedidoData .
                '</data-hora>' . "\n      ";
        if ($this->dadosPedidoDescricao != null && $this->dadosPedidoDescricao != "") {
            $msg .= '<descricao>'
                    . $this->dadosPedidoDescricao .
                    '</descricao>' . "\n      ";
        }
        $msg .= '<idioma>'
                . $this->dadosPedidoIdioma .
                '</idioma>' . "\n   " .
                '</dados-pedido>';

        return $msg;
    }

    private function XMLFormaPagamento() {
        $msg = '<forma-pagamento>' . "\n      " .
                '<bandeira>'
                . $this->formaPagamentoBandeira .
                '</bandeira>' . "\n      " .
                '<produto>'
                . $this->formaPagamentoProduto .
                '</produto>' . "\n      " .
                '<parcelas>'
                . $this->formaPagamentoParcelas .
                '</parcelas>' . "\n   " .
                '</forma-pagamento>';

        return $msg;
    }

    private function XMLUrlRetorno() {
        $msg = '<url-retorno>' . $this->urlRetorno . '</url-retorno>';

        return $msg;
    }

    private function XMLAutorizar() {
        $msg = '<autorizar>' . $this->autorizar . '</autorizar>';

        return $msg;
    }

    private function XMLCapturar() {
        $msg = '<capturar>' . $this->capturar . '</capturar>';

        return $msg;
    }

    // Envia Requisição
    public function Enviar($vmPost, $transacao) {
        $this->logger->logWrite("ENVIO: " . $vmPost, $transacao);
        // ENVIA REQUISIÇÃO SITE CIELO
        $vmResposta = $this->httprequest(ENDERECO, "mensagem=" . $vmPost);
        $this->logger->logWrite("RESPOSTA: " . $vmResposta, $transacao);

        $this->VerificaErro($vmPost, $vmResposta);

        return simplexml_load_string($vmResposta);
    }

    // Requisições
    public function RequisicaoTransacao($incluirPortador) {
        $msg = $this->XMLHeader() . "\n" .
                '<requisicao-transacao id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
                . $this->XMLDadosEc() . "\n   ";
        if ($incluirPortador == true) {
            $msg .= $this->XMLDadosPortador() . "\n   ";
        }
        $msg .= $this->XMLDadosPedido() . "\n   "
                . $this->XMLFormaPagamento() . "\n   "
                . $this->XMLUrlRetorno() . "\n   "
                . $this->XMLAutorizar() . "\n   "
                . $this->XMLCapturar() . "\n";

        $msg .= '</requisicao-transacao>';

        $objResposta = $this->Enviar($msg, "Transacao");
        return $objResposta;
    }

    public function RequisicaoTid() {
        $msg = $this->XMLHeader() . "\n" .
                '<requisicao-tid id="' . md5(date("YmdHisu")) . '" versao ="' . VERSAO . '">' . "\n   "
                . $this->XMLDadosEc() . "\n   "
                . $this->XMLFormaPagamento() . "\n" .
                '</requisicao-tid>';

        $objResposta = $this->Enviar($msg, "Requisicao Tid");
        return $objResposta;
    }

    public function RequisicaoAutorizacaoPortador() {
        $msg = $this->XMLHeader() . "\n" .
                '<requisicao-autorizacao-portador id="' . md5(date("YmdHisu")) . '" versao ="' . VERSAO . '">' . "\n"
                . '<tid>' . $this->tid . '</tid>' . "\n   "
                . $this->XMLDadosEc() . "\n   "
                . $this->XMLDadosCartao() . "\n   "
                . $this->XMLDadosPedido() . "\n   "
                . $this->XMLFormaPagamento() . "\n   "
                . '<capturar-automaticamente>' . $this->capturar . '</capturar-automaticamente>' . "\n" .
                '</requisicao-autorizacao-portador>';

        $objResposta = $this->Enviar($msg, "Autorizacao Portador");
        return $objResposta;
    }

    public function RequisicaoAutorizacaoTid() {
        $msg = $this->XMLHeader() . "\n" .
                '<requisicao-autorizacao-tid id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n  "
                . '<tid>' . $this->tid . '</tid>' . "\n  "
                . $this->XMLDadosEc() . "\n" .
                '</requisicao-autorizacao-tid>';

        $objResposta = $this->Enviar($msg, "Autorizacao Tid");
        return $objResposta;
    }

    public function RequisicaoCaptura($PercentualCaptura, $anexo) {
        $msg = $this->XMLHeader() . "\n" .
                '<requisicao-captura id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
                . '<tid>' . $this->tid . '</tid>' . "\n   "
                . $this->XMLDadosEc() . "\n  "
                . '<valor>' . $PercentualCaptura . '</valor>' . "\n";
        if ($anexo != null && $anexo != "") {
            $msg .= '   <anexo>' . $anexo . '</anexo>' . "\n";
        }
        $msg .= '</requisicao-captura>';

        $objResposta = $this->Enviar($msg, "Captura");
        return $objResposta;
    }

    public function RequisicaoCancelamento() {
        $msg = $this->XMLHeader() . "\n" .
                '<requisicao-cancelamento id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
                . '<tid>' . $this->tid . '</tid>' . "\n   "
                . $this->XMLDadosEc() . "\n" .
                '</requisicao-cancelamento>';

        $objResposta = $this->Enviar($msg, "Cancelamento");
        return $objResposta;
    }

    public function RequisicaoConsulta() {
        $msg = $this->XMLHeader() . "\n" .
                '<requisicao-consulta id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
                . '<tid>' . $this->tid . '</tid>' . "\n   "
                . $this->XMLDadosEc() . "\n" .
                '</requisicao-consulta>';

        $objResposta = $this->Enviar($msg, "Consulta");
        return $objResposta;
    }

    // Transforma em/lê string
    public function ToString() {
        $msg = $this->XMLHeader() .
                '<objeto-pedido>'
                . '<tid>' . $this->tid . '</tid>'
                . '<status>' . $this->status . '</status>'
                . $this->XMLDadosEc()
                . $this->XMLDadosPedido()
                . $this->XMLFormaPagamento() .
                '</objeto-pedido>';

        return $msg;
    }

    public function FromString($Str) {
        $DadosEc = "dados-ec";
        $DadosPedido = "dados-pedido";
        $DataHora = "data-hora";
        $FormaPagamento = "forma-pagamento";
        $XML = simplexml_load_string($Str);

        $this->tid = $XML->tid;
        $this->status = $XML->status;
        $this->dadosEcChave = $XML->$DadosEc->chave;
        $this->dadosEcNumero = $XML->$DadosEc->numero;
        $this->dadosPedidoNumero = $XML->$DadosPedido->numero;
        $this->dadosPedidoData = $XML->$DadosPedido->$DataHora;
        $this->dadosPedidoValor = $XML->$DadosPedido->valor;
        $this->formaPagamentoProduto = $XML->$FormaPagamento->produto;
        $this->formaPagamentoParcelas = $XML->$FormaPagamento->parcelas;
    }

    // Traduz cógigo do Status
    public function getStatus() {
        $status;

        switch ($this->status) {
            case "0": $status = "Criada";
                break;
            case "1": $status = "Em andamento";
                break;
            case "2": $status = "Autenticada";
                break;
            case "3": $status = "Não autenticada";
                break;
            case "4": $status = "Autorizada";
                break;
            case "5": $status = "Não autorizada";
                break;
            case "6": $status = "Capturada";
                break;
            case "8": $status = "Não capturada";
                break;
            case "9": $status = "Cancelada";
                break;
            case "10": $status = "Em autenticação";
                break;
            default: $status = "n/a";
                break;
        }

        return $status;
    }

    public function bandeira($bandeira) {
        // TRANSFORMA O NOME DA BANDEIRA NO CODIGO POSTO NO BANCO
        $codigo = '';
        switch ($bandeira) {
            case "visa": $codigo = 4;
                break;
            case "mastercard": $codigo = 2;
                break;
            case "elo": $codigo = 7;
                break;
        }
        return $codigo;
    }

    public function tPagamento($tipo) {
        $codigo = '';
        // TRANSFORMA O TIPO DE PAGAMENTO POR EXTENSO
        switch ($tipo) {
            case "A": $codigo = 'DEBITO';
                break;
            case "1": $codigo = 'CRÉDITO';
                break;
        }
        return $codigo;
    }

    // Novo Pagamento
    public function NovoPagamento($params) {
        session_start();
        
        $logFile = getcwd() . "/application/logs/log.log";
        // Verifica em Resposta XML a ocorrência de erros 
        // Parâmetros: XML de envio, XML de Resposta
        $olderror = set_error_handler("Handler");
        ini_set('error_log', $logFile);
        ini_set('log_errors', 'On');
        ini_set('display_errors', 'On');
        ini_set("date.timezone", "America/Manaus");

        $_SESSION["pedidos"] = new ArrayObject();
        $_SESSION["transacao"] = new ArrayObject();

        $this->formaPagamentoBandeira = $params['bandeira'];
        $this->formaPagamentoProduto = $params['forma'];
        $this->dadosPedidoNumero = $params['pedido'];
        $this->dadosPedidoValor = $params['total'];
        $this->urlRetorno = $this->ReturnURL($params['urlRetorno']);
        // ENVIA REQUISIÇÃO SITE CIELO
        $objResposta = $this->RequisicaoTransacao(false);
        $this->tid = $objResposta->tid;
        $this->pan = $objResposta->pan;
        $this->status = $objResposta->status;
        $urlAutenticacao = "url-autenticacao";
        $this->urlAutenticacao = $objResposta->$urlAutenticacao;
        // Serializa Pedido e guarda na SESSION
        $StrPedido = $this->ToString();
        $_SESSION["pedidos"]->append($StrPedido);
        $Pedido->urlAutenticacao;
        $_SESSION["transacao"] = $_SESSION["pedidos"];
        echo '<script type="text/javascript"> window.location.href = "' . $this->urlAutenticacao . '" </script>';
    }

    public function Retorno() {

        $obj = & get_instance();
        $obj->load->helper('url');
        $obj->load->model('financeiro/pagamento_model', 'pagamento', TRUE);


        if ($_SESSION["transacao"]) {

            // Resgata último pedido feito da SESSION
            $ultimoPedido = $_SESSION["transacao"]->count();
            $ultimoPedido -= 1;

            $this->FromString($_SESSION["transacao"]->offsetGet($ultimoPedido));
            // Consulta situação da transação
            $objResposta = $this->RequisicaoConsulta();
            // Atualiza status

            $this->status = $objResposta->status;
            if ($this->status == '4' || $this->status == '6')
                $finalizacao = true;
            else
                $finalizacao = false;
            // Atualiza Pedido da SESSION
            $StrPedido = $this->ToString();
            $_SESSION["transacao"]->offsetSet($ultimoPedido, $StrPedido);

            $codigo = strval($this->dadosPedidoNumero);
            $tid = strval($this->tid);
            htmlentities($objResposta->asXML());

            $data['dadosPedidoNumero'] = $this->dadosPedidoNumero;   // PEGA O CODIGO DO PEDIDO
            $data['tid'] = $this->tid;                             // PEGA O NUMERO DA TRANSAÇÃO DO PEDIDO CIELO
            $data['finalizacao'] = $finalizacao ? "sim" : "não";     // PEGA O STATUS DE FECHAMENTO DA TRANSAÇÃO
            $data['status'] = $this->getStatus();                  // PEGA O STATUS DA TRANSAÇÃO CIELO

            // Não autenticada || Capturado
            if ($this->getStatus() == 'Não autenticada') {
                $at = array(
                    'operacao' => 'UPD',
                    'codigo' => $codigo,
                    'autenticacao' => $tid,
                    'status' => 'AUTORIZADO'
                );
                print_r($at);
                //$op = $obj->pagamento->transacao($at);


                foreach ($obj->session->userdata('FRM_PRODUTO') as $item) {
                    $row = base64_decode($item);
                    $r = explode(':', $row);
                    $params = array(
                        'operacao' => 'LANCAR',
                        'codigo' => $codigo,
                        'autenticacao' => $tid,
                        'aluno' => $r[0],
                        'produto' => $r[1],
                        'mes' => $r[2],
                        'parcela' => $r[3],
                        'ordem' => $r[4],
                        'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
                        'cartao' => $this->bandeira($obj->session->userdata('FRM_BANDEIRA')),
                        'tipo' => $this->tPagamento($obj->session->userdata('FRM_FORMA_PAGAMENTO')),
                        'status' => 'AUTORIZADO',
                        'recebido' => $r['5'],
                        'historico' => "Pagto. ONLINE com Cartão (" . strtoupper($obj->session->userdata('FRM_BANDEIRA')) . '/' . $this->cielo->tPagamento($this->session->userdata('FRM_FORMA_PAGAMENTO')) . ") || (" . $r[7] . '-' . $r[2] . ") do Aluno(a) " . $r[6] . "",
                    );
                    PRINT_R($params);
                    //$this->pagamento->lancar_pagamento($params);
                }
            } else {
                $at = array(
                    'operacao' => 'UPD',
                    'codigo' => $codigo,
                    'autenticacao' => $tid,
                    'status' => 'CANCELADO'
                );
                print_r($at);
                //$op = $this->pagamento->transacao($at);
            }
        } else {
            echo $ultimoPedido = $obj->session->userdata('transacao')->count();
            echo $ultimoPedido -= 1;
            return( 'Erro de sessão | Entre em contato com o Administrador do Sistema | 92 3211-0191');
        }
    }

    public function RetornoCompra($res) {
        session_start();
        
        $obj = & get_instance();
        $obj->load->helper('url');
        $obj->load->model('financeiro/pagamento_model', 'pagamento', TRUE);
        
        $logFile = getcwd() . "/application/logs/log.log";
        // Verifica em Resposta XML a ocorrência de erros 
        // Parâmetros: XML de envio, XML de Resposta
        $olderror = set_error_handler("Handler");
        ini_set('error_log', $logFile);
        ini_set('log_errors', 'On');
        ini_set('display_errors', 'On');
        ini_set("date.timezone", "America/Manaus");

        if (!isset($_SESSION["pedidos"])) {
            $_SESSION["pedidos"] = new ArrayObject();
        }
        if ($_SESSION["pedidos"]) {
            
            // Resgata último pedido feito da SESSION
            $ultimoPedido = $_SESSION["pedidos"]->count();
            $ultimoPedido -= 1;

            $this->FromString($_SESSION["pedidos"]->offsetGet($ultimoPedido));
            // Consulta situação da transação
            $objResposta = $this->RequisicaoConsulta();
            // Atualiza status

            $this->status = $objResposta->status;
            if ($this->status == '6') // $this->status == '4' || 
                $finalizacao = true;
            else
                $finalizacao = false;

            // Atualiza Pedido da SESSION
            $StrPedido = $this->ToString();
            $_SESSION["pedidos"]->offsetSet($ultimoPedido, $StrPedido);

            $codigo = strval($this->dadosPedidoNumero);
            $tid = strval($this->tid);
            htmlentities($objResposta->asXML());

            $dadosPedidoNumero = $this->dadosPedidoNumero;   // PEGA O CODIGO DO PEDIDO
            $finalizacao = $finalizacao ? "sim" : "não";     // PEGA O STATUS DE FECHAMENTO DA TRANSAÇÃO
            $status = $this->getStatus();                  // PEGA O STATUS DA TRANSAÇÃO CIELO
            //print_r($_SESSION["pedidos"]); 
            //echo $this->formaPagamentoProduto;
            
            //Capturado
            // Não autenticada || Capturado
            //$this->getStatus();
            if ($this->getStatus() == 'Capturada') {
                $at = array(
                    'operacao' => 'UPD',
                    'codigo' => $codigo,
                    'autenticacao' => strval($this->tid),
                    'status' => 'COMPRA REALIZADA'
                );
                //print_r($at);
                $op = $obj->pagamento->transacao($at);
                
                $params = array(
                    'operacao' => 'CREDITO',
                    'codigo' => $codigo,
                    'autenticacao' => $tid,
                    'aluno' => $res['aluno'],
                    'produto' => NULL,
                    'mes' => NULL,
                    'parcela' => NULL,
                    'ordem' => NULL,
                    'responsavel' => $obj->session->userdata('SCL_SSS_USU_CODIGO'),
                    'cartao' => $this->bandeira($res['bandeira']),
                    'tipo' => $this->tPagamento($this->formaPagamentoProduto),
                    'status' => 'COMPRA REALIZADA',
                    'recebido' => str_replace(',','.',$res['total']),
                    'conta' => 12,
                    'historico' => "Compra de Crédito Online com Cartão (" . strtoupper($res['bandeira']) . '/' . $this->tPagamento($this->formaPagamentoProduto) . ")  do Aluno(a) " . $res['aluno']. "",
                );
                //print_r($params);
                $re = $obj->pagamento->lancar_pagamento($params);
            } else {
                $at = array(
                    'operacao' => 'UPD',
                    'codigo' => $codigo,
                    'autenticacao' => $tid,
                    'status' => 'CANCELADO'
                );
                //print_r($at);
                $op = $this->pagamento->transacao($at);
            }
        } else {
            $ultimoPedido = $_SESSION["pedidos"]->count();
            $ultimoPedido -= 1;
            $retorno = 'Erro de sessão | Entre em contato com o Administrador do Sistema | 92 3211-0191';
        }
    }

}

?>