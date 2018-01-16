<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cobranca extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('financeiro/cobranca_model','cobranca', TRUE);
        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library(array('form_validation', 'session'));
        //if($this->session->userdata('SCL_SSS_USU_CODIGO') == FALSE){redirect(base_url(), 'refresh');}
    }
    
    function verificar($telefone) {
        $tel = ereg_replace("[^0-9_]", "", strtr($telefone, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC")); // Deixa apenas os numeros Ex. (92) 9999-9999 // Retorna $tel = 9299999999
        $strtel = strlen($tel); // Verifica o numero de digitos validos EX. 9299999999 // Retorna $strtel = '10'
        $var = substr($tel, -8); // Remove os dois primeiros digitos da variavel $telcom EX. 9299999999 // Retorna $var = '99999999'
        $ind = substr($var, 0, 1); // Verifica o primeiro numero da variavel $varcom EX. 99999999 // Retorna $ind = '9'
        $pref = substr($tel, 0, 2); // Verifica os dois primeiros numero da variável $telcom EX. 9299999999 // Retorna $strtel = '92'
        if (($strtel == 10) && ($ind > 7)) { 
            $telefone = $pref . $var;
            return($telefone);
        }else{
            return(false);
        }
        
    }
    

    function index() {
        
        $data = array(
            'titulo' => '<h1> Financeiro <i class="fa fa-angle-right"></i> Mensalidade </h1>',
            'navegacao' => 'Financeiro > Mensalidade',
            'devedor'=>$this->cobranca->devedores()
        );
        //foreach($this->input->get_post('responsavel') as $item){	
        $mensagem = "Seculo: Ainda nao localizamos o pagamento de mensalidade de seu filho, para emitir um novo boleto acesse www.seculomanaus.com.br/portal ou Ligue 3211-0196.";
        //$campo = explode(':',$item);
        $campo[1] = 9291124117;
        $codigoVerificadorSMS = 20 . date('hms');
        $telefone = $this->verificar($campo[1]);
        
        if ($telefone != FALSE) { // v2erifica se o telefone é celular
            echo $url = '<iframe src="https://ww2.iagentesms.com.br/webservices/http.php?metodo=envio&usuario=seculomanaus&senha=20022014&celular=' . $telefone . '&mensagem=' . $mensagem . '&codigosms=' . $codigoVerificadorSMS . '"></iframe>';
           //		}
           //echo ' ok';		  
           //$this->load->view('financeiro/cobranca/index', $data);
        }else{
            echo 'Número de Telefone Inválido: ' .$campo[1];
        }
    }

}