<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Aluno extends CI_Controller {

    function __construct() {
         parent::__construct();
         $this->load->model('secretaria/secretaria_model','secretaria',TRUE);
         $this->load->model('colegio/colegio_model','colegio',TRUE);
         $this->load->helper(array('form','url','html','funcoes'));
         $this->load->library(array('form_validation','session'));
    }

    // ALUNOS POR TURMA E NOME
    function index(){
         $data = array(
            'titulo' => '<h1> Monitoria de Aluno </h1>',
            'aluno' => $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao'=>'TODOS')),
        );
        $this->load->view('monitor/aluno/index', $data);
    }
    
    // TEMPOS DO ALUNO
    function tempo(){
         
         
         if($this->input->get_post('codigo') == NULL){
            echo '<div class="col-sm-12 well">Selecione um aluno</div>';
        }else{
            $data = array(
                'tipo' => $this->input->get_post('tipo'),
                'tempo' => $this->secretaria->tempos(array('aluno' => $this->input->get_post('codigo'), 'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'))),
            );
            $this->load->view('monitor/aluno/frmTempo', $data);
        }
    }
}