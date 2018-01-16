<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Professor extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('secretaria/funcionario_model', 'funcionario', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file', 'funcoes'));
        $this->load->library(array('form_validation', 'session', 'email', 'upload', 'pagination'));
    }

    function index() {
       //header('Content-type: text/xsl');
       //header('Content-disposition: attachment;filename=professores.xls');
        
        // TRATA OS FUNCIONARIOS
        $lProfessor = $this->funcionario->lProfessor($dados);
        
        
        $data = array('titulo' => 'Relação e Funcionarios',
                      'professor' => $lProfessor );
        $this->load->view('/secretaria/professor/index', $data);
    }
    
    function excel() {
       header('Content-type: text/xsl');
       header('Content-disposition: attachment;filename=professor.txt');
       
        // TRATA OS FUNCIONARIOS
        $listar = $this->funcionario->lProfessor($dados);
        
        
        $data = array('titulo' => 'Relação e Funcionarios',
                      'pessoa' => $listar);
        $this->load->view('/secretaria/professor/excel', $data);
    }
}