<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comprar extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('financeiro/pagamento_model', 'pagamento', TRUE);
        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library(array('session', 'logger', 'cielo'));
    }    

    function retorno() {
        $data = array(
            'titulo' => '<h1> Financeiro <i class="fa fa-angle-right"></i> Compra de Crédito Online </h1>',
            'navegacao' => 'Financeiro > Compra de Crédito Online ',
        );
        $params = array(
                'aluno' => $this->session->userdata('CES_CIELO_ALUNO'),
                'bandeira' => $this->session->userdata('CES_CIELO_BANDEIRA'),
                'forma' => $this->session->userdata('CES_CIELO_FORMA'),
                'total' => $this->session->userdata('CES_CIELO_TOTAL'),
            );
       
        $gateway = new Cielo();
        
        $retorno = $gateway->RetornoCompra($params);
        redirect('financeiro/credito', 'refresh');
    }

    function Pedidos() {

        $gateway = new Cielo();
        $novo = $gateway->Pedidos($params);
        /*         * **********   Chama a Library Cielo (fim) ***************** */
    }

}