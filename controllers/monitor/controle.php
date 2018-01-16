<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Controle extends CI_Controller {

    function __construct() {
         parent::__construct();
         $this->load->model('seguranca/controle_model','controle',TRUE);
         $this->load->helper(array('form','url','html','funcoes'));
         $this->load->library(array('form_validation','session','tracert'));
    }

    // ALUNOS POR TURMA E NOME
    function index(){
        
        $par = array(
            'operacao' => 'T',
        );
         $data = array(
            'titulo' => '<h1> Monitoria de Acesso ao Colégio</h1>',
            'grafico' => $this->controle->acesso_catraca($par),
        );
        $this->load->view('monitor/controle/index', $data);
    }
    
    // ALUNOS POR TURMA E NOME
    function entrada(){
        $par = array(
            'data' => $this->input->get_post('data'),
            'tipo' => $this->input->get_post('tipo'),
            'passe' => 'E',
            'operacao' => 'L',
        );
         $data = array(
            'pessoa' => $this->controle->acesso_catraca($par),
        );
        $this->load->view('monitor/controle/entrada', $data);
    }
    
    // ALUNOS POR TURMA E NOME
    function saida(){
        $par = array(
            'data' => $this->input->get_post('data'),
            'tipo' => $this->input->get_post('tipo'),
            'operacao' => 'L',
            'passe' => 'S'
        );
         $data = array(
            'pessoa' => $this->controle->acesso_catraca($par),
        );
        $this->load->view('monitor/controle/saida', $data);
    }
    
    // GRÁFICOS
    function grafico(){
        $par = array(
            'data' => $this->input->get_post('data'),
            'tipo' => $this->input->get_post('tipo'),
            'passe' => 'S',
            'operacao' => 'A',
        );
         $data = array(
            'pessoa' => $this->controle->acesso_catraca($par),
        );
        $this->load->view('monitor/controle/grafico', $data);
    }
    
}