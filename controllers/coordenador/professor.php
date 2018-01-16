<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Professor extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('coordenacao/ocorrencia_model', 'ocorrencia', TRUE);
        $this->load->model('colegio/colegio_model', 'colegio', TRUE);
        $this->load->model('secretaria/secretaria_model', 'secretaria', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file', 'funcoes'));
        $this->load->library(array('form_validation', 'session', 'upload'));
    }
//*
// SAMYA 6
// ANA LUIZA 6
// ALBERTO SERAFIM 4
//
//
//*/
    function index() {
        $data = array(
            'titulo' => '<h1> Coordenador <i class="fa fa-angle-double-right"></i> Monitoramento de Notas </h1>',
            'curso' => $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'C')),
        );
        $this->load->view('coordenador/professor/index', $data);
    }
    
    function listar_professor() {
       
        $data = array(
            'listar' =>  $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'TP','turma' => $this->input->get_post('turma'))),
        );
        $this->load->view('coordenador/professor/professor', $data);
    }
    
    function notas_turma() {
       
        $data = array(
            'listar' =>  $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'A','turma' => $this->input->get_post('turma'))),
        );
        $this->load->view('coordenador/professor/turma', $data);
    }
    
    function faltas() {
        $data = array(
            'listar' =>  $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'FALTAS','aluno' => $this->input->get_post('aluno'))),
            'aluno' => base64_encode($this->input->get_post('aluno')),
        );
       $this->load->view('coordenador/professor/faltas', $data);
    }
    
    function notas() {
        
        $parametro = array('aluno' => $this->input->get_post('aluno'),
            'curso' => NULL,
            'serie' => NULL,
            'turma' => NULL,
            'tipo' => 0
        );
        $data = array(
            'boletim' =>  $this->secretaria->boletim($parametro),
            'aluno' => base64_encode($this->input->get_post('aluno')),
        );
       $this->load->view('coordenador/professor/notas', $data);
    }
    
    
    
    function falta_imprimir() {
        $data = array(
            'titulo' => '<h1> Demonstrativo de Faltas do Aluno </h1>',
            'listar' =>  $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'FALTAS','aluno' => base64_decode($this->input->get_post('token')))),
            'aluno' =>  $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'AT','aluno' => base64_decode($this->input->get_post('token')))),
            
        );
        //print_r($data['boletim']);exit();
        $html = $this->load->view('coordenador/professor/falta_imprimir', $data, TRUE);
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $mpdf->SetHTMLHeader($this->load->view('impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', 10, // margin_left
                10, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                0); // margin footer 
        $mpdf->SetDisplayMode('fullpage');
        
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer', $data, true));
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}