<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Atividade extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('secretaria/secretaria_model', 'secretaria', TRUE);
        $this->load->model('coordenacao/ocorrencia_model', 'ocorrencia', TRUE);
        $this->load->model('colegio/colegio_model', 'colegio', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'funcoes'));
        $this->load->library(array('form_validation', 'session'));
    }

    // ALUNOS POR TURMA E NOME
    function index() {
        $data = array(
            'titulo' => '<h1> Monitoria de Aluno </h1>',
            'curso' => $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'C')),
        );
        
        $this->load->view('monitor/atividade/index', $data);
    }

    // TEMPOS DO ALUNO
    function tabela() {
        
        $parametro = array(
            'operacao' => 'A', //MOSTRAR AS SÉRIES FILTRADAS PELOS CAMPOS
            'curso' => $this->input->get_post('curso'),
            'serie' => $this->input->get_post('serie'),
            'turma' => $this->input->get_post('turma'),
        );

        $data = array(
            'aluno' =>  $this->colegio->sp_curso_serie_turma_aluno($parametro),
        );
        $this->load->view('monitor/atividade/tabela', $data);
    }
    
    
    function imprimir() {
        $parametro = array(
            'operacao' => 'A', //MOSTRAR AS SÉRIES FILTRADAS PELOS CAMPOS
            'curso' => $this->input->get_post('curso'),
            'serie' => $this->input->get_post('serie'),
            'turma' => $this->input->get_post('turma'),
        );

        $data = array(
            'titulo' => 'Relação de Atividades Extras da Turma: '.$this->input->post('turma').'',
            'aluno' =>  $this->colegio->sp_curso_serie_turma_aluno($parametro),
        );
        
        //print_r($data['boletim']);exit();
        $html = $this->load->view('monitor/atividade/imprimir', $data, true);
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $mpdf->SetHTMLHeader($this->load->view('impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', 
                10, // margin_left
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