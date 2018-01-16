
<?php

class Soapsms extends CI_controller {

    private $location   = 'http://www.iagentesms.com.br/webservices/ws.php';
    private $uri        = 'http://www.iagentesms.com.br/webservices/';
    private $encoding   = 'ISO-8859-1';
    private $trace      = 1;
    private $exceptions = 0;
    private $user       = 'seculomanaus';
    private $pass       = '20022014';
    private $connect;
    
    
    public $cliente;
    public $celular;
    public $mensagem;
    public $codigo;

    public function __construct() {
        
    }
    
    function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        $retorno = '';
        $caracteres = '';
        //$caracteres .= $lmin;
        if ($maiusculas) $caracteres .= $lmai;
        if ($numeros)    $caracteres .= $num;
        if ($simbolos)   $caracteres .= $simb;
        
        $len = strlen($caracteres);
        
        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand-1];
        }
        return $retorno;
    }

    /* Consultar Saldo na IAGENTE */

    function saldo() {

        $options = array(
            'location'   => $this->location,
            'uri'        => $this->uri,
            'encoding'   => $this->encoding,
            'trace'      => $this->trace,
            'exceptions' => $this->exceptions
        );

        $ws = new SoapClient(NULL, $options);
        $this->connect = $ws->Auth($this->user, $this->pass);

        $saldo = $ws->consulta_saldo();
        return($saldo[1]);
    }

    function resposta() {

        $options = array(
            'location' => $this->location,
            'uri' => $this->uri,
            'encoding' => $this->encoding,
            'trace' => $this->trace,
            'exceptions' => $this->exceptions
        );

        $ws = new SoapClient(NULL, $options);
        $this->connect = $ws->Auth($this->user, $this->pass);

        $saldo = $ws->consulta_saldo();
        return($saldo[1]);
    }

    /**
     * Consulta situação da mensagem enviada.
     * 
     * @return string
     */
    function status() {

        $options = array(
            'location' => $this->location,
            'uri' => $this->uri,
            'encoding' => $this->encoding,
            'trace' => $this->trace,
            'exceptions' => $this->exceptions
        );

        $ws = new SoapClient(NULL, $options);
        $this->connect = $ws->Auth($this->user, $this->pass);

        $saldo = $ws->verifica_status($this->codigo);
        return($saldo[1]);
    }
    
    /* Consultar Saldo na IAGENTE */
    function enviar(){
        $options = array(
                'location'  => $this->location,
                'uri'       => $this->uri,
                'encoding'  => $this->encoding,
                'trace'     => $this->trace,
                'exceptions'=> $this->exceptions
        );
        
        /*
            DADOS PARA ENVIO
            Remetente         Alfa numérico Nome do remetente - opcional
            Destinatário      Inteiro Número de destino
            Mensagem          String Mensagem com até 150 caracteres
            Data              Data e Hora Data do envio - opcional
            Código            Inteiro Código interno do cliente para
        */
        $cliente  = $this->cliente;
        $celular  = $this->celular;
        $mensagem = $this->mensagem;
        $data     = date('d/m/y');
        $codigo   = $this->codigo;
        
        
        /*
            DADOS DE RETORNO
            1 Boolean      1: OK, 0: FALHA
            2 String       Mensagem de falha ou sucesso
            3 Inteiro      ID do agendamento
        */
        $ws = new SoapClient(NULL, $options);
        $this->connect = $ws->Auth($this->user,$this->pass);
        $enviar = $ws->enviar_sms($cliente,$celular,$mensagem,$data,$codigo);
        return($enviar[1]);
    }

}
