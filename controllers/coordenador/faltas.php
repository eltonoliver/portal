<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faltas extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('coordenacao/coordenador_model', 'coordenador', TRUE);
        $this->load->model('secretaria/secretaria_model', 'secretaria', TRUE);
        $this->load->model('professor/diario_model', 'diario', TRUE);
        $this->load->model('colegio/colegio_model', 'colegio', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file','funcoes'));
        $this->load->library(array('form_validation', 'session', 'upload'));

    }
    
    function index(){
        $parametro = array(
                            'operacao'=>'C', //MOSTRAR OS CURSOS
                            'curso'=>NULL
                            );
        $data = array(
            'titulo' => 'Coordenador <i class="fa fa-angle-double-right"></i> Monitoramento de Faltas ',
            'curso' => $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'C')),
        );
        $this->load->view('coordenador/faltas/main',$data);
    }
    
    function alunos_faltosos(){
        $paramento = array( 'operacao'=>'FALTOSOS',
                           );   
        $data = array(
            'titulo' => 'Coordenador <i class="fa fa-angle-double-right"></i> 
             Monitoramento de Faltas <i class="fa fa-angle-double-right"></i>
             Alunos Faltosos',
            'listar' =>  $this->diario->sp_diario($paramento)
        );
        $this->load->view('coordenador/faltas/faltosos',$data);
    }
    
    function por_turma(){
        $parametro = array(
                            'operacao'=>'C', //MOSTRAR OS CURSOS
                            'curso'=>NULL
                            );
        $data = array(
            'titulo' => 'Coordenador <i class="fa fa-angle-double-right"></i> Monitoramento de Notas ',
            'curso' => $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'C')),
        );
        $this->load->view('coordenador/faltas/index',$data);
    }
    
    function filtro(){

        $parametro = array(
            'operacao'=>'FTURMA', //MOSTRAR OS CURSOS
            'turma'=>$this->input->get_post('turma'), //MOSTRAR OS CURSOS
            'data'=>$this->input->get_post('data'), //MOSTRAR OS CURSOS
        );
        
         $parametro2 = array(
            'operacao'=>'AULAS', //MOSTRAR OS CURSOS
            'turma'=>$this->input->get_post('turma'), //MOSTRAR OS CURSOS
            'data'=>$this->input->get_post('data'), //MOSTRAR OS CURSOS
        );
        
        $data = array(
            'titulo' => '<h1> Coordenador <i class="fa fa-angle-double-right"></i> Monitoramento de Notas </h1>',
            'listar' => $this->coordenador->aluno($parametro),
            'aulas' => $this->coordenador->aluno($parametro2),
        );
        $this->load->view('coordenador/faltas/filtro', $data);
    } 
}