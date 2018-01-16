<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Funcionario extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('secretaria/funcionario_model', 'funcionario', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file', 'funcoes'));
        $this->load->library(array('form_validation', 'session', 'email', 'upload', 'pagination'));
    }

    function index() {
        // TRATA OS FUNCIONARIOS
        
        $data = array('titulo' => 'Relação e Funcionarios',
                      'pessoa' => $this->funcionario->lFuncionario());
        $this->load->view('/secretaria/funcionario/index', $data);
    }
    
    function excel() {
        header('Content-type: text/xsl');
        header('Content-disposition: attachment;filename=funcionarios.txt');
       
        // TRATA OS FUNCIONARIOS
        $lFuncionario = $this->funcionario->lFuncionario($dados);
        
        
        $data = array('titulo' => 'Relação e Funcionarios',
                      'pessoa' => $lFuncionario );
        $this->load->view('/secretaria/funcionario/funcionario', $data);
    }
}