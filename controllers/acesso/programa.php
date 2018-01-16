<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Programa extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('desenvolvimento/acesso_model', 'acesso', TRUE);
        $this->load->model('administrativo/administrativo_model', 'admin', TRUE);

        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library(array('form_validation', 'session'));
    }

    function index() {

        $data = array(
            'titulo' => '<h1> Controle de Acesso <i class="fa fa-angle-right"></i> Programa </h1>',
            'navegacao' => 'Controle de Acesso > Programa',
            'sistema' => $this->acesso->sistema(array('operacao'=>'L')),
        );
        
        $this->load->view('acesso/programa/index', $data);
    }
    
    function tabela() {

        $data = array(
            'listar' => $this->acesso->programa(array('operacao'=>'FS', 
                                                      'sistema'=>$this->input->get_post('sistema'))),
        );
        $this->load->view('acesso/programa/tabela', $data);
    }
    
    function view() {
        
        if($this->input->get_post('tipo') != 'adicionar'){
            $filtro = $this->acesso->programa(array('operacao'=>'F', 'codigo'=>$this->input->get_post('codigo')));
        }else{
            $filtro = '';
        }

        $data = array(
            'titulo' => $this->input->get_post('tipo'),
            'sistema' => $this->acesso->sistema(array('operacao'=>'L')),
            'filtro' => $filtro,
            'modal' => $this->input->get_post('modal'),
        );
        $this->load->view('acesso/programa/view', $data);
    }
    
    function manter() {
        
        $parametro = array('operacao'=>$this->input->get_post('operacao'),
                           'codigo'=>$this->input->get_post('codigo'),
                           'nome'=>$this->input->get_post('nome'),
                           'sistema'=>$this->input->get_post('tsistema'),
                           'formulario'=>$this->input->get_post('formulario'),
                           'observacao'=>$this->input->get_post('observacao'),
                           'classe'=>$this->input->get_post('classe'),
                           );
        $retorno = $this->acesso->programa($parametro);
        if($retorno == 0){
            echo "Erro ao ".$this->input->get_post('tipo')." Cadastro";
            echo '';
            print_r($parametro);
        }else{
            
            echo '';
            echo "".$this->input->get_post('tipo')." realizado";
        }
        
    }

}