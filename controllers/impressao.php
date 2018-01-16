<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Impressao extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('responsavel_model', 'responsavel', TRUE);
        $this->load->model('secretaria/secretaria_model', 'secretaria', TRUE);
        $this->load->model('professor/infantil_model', 'infantil', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file'));
        $this->load->library(array('form_validation', 'session', 'email', 'upload', 'pagination'));
    }

    function nota() {
        /*
         * VARIÁVEL TIPO DEFINE O TIPO DE DADOS DO BOLETIM
         * 0 = DEMONSTRATIVO DE NOTAS (TODAS AS NOTAS QUE FORMAM A MÉDIA DE CADA BIMESTRE)
         * 1 = BOLETIM DE NOTAS (MÉDIAS E FALTAS DE CADA BIMESTRE)
         */
        
        $parametro = array('aluno' => $this->input->post('aluno'),
            'curso' => NULL,
            'serie' => NULL,
            'turma' => NULL,
            'tipo'=> $this->input->post('tipo')
        );
        
        if($this->input->post('tipo') == 0){
           $data['titulo'] = "Demonstrativo de Notas do Aluno";
           $data['tipo'] = 0;
           $layout = 'L'; // MONTA O LAYOUT DO PDF
        }elseif($this->input->post('tipo') == 1){
           $data['titulo'] = "Boletim do Aluno";
           $data['tipo'] = 1;
           $layout = 'L'; // MONTA O LAYOUT DO PDF - VISUALIZAÇÃO
        }
        
        $data['boletim'] = $this->secretaria->boletim($parametro);
        
        //print_r($data['boletim']);exit();
        $html = $this->load->view('impressao/secretaria/nota', $data, true);
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $mpdf->SetHTMLHeader($this->load->view('impressao/header', $data, true));
        $mpdf->AddPage(''.$layout.'', // L - landscape, P - portrait
                '', '', '', '', 0, // margin_left
                0, // margin right
                20, // margin top
                0, // margin bottom
                0, // margin header
                0); // margin footer 
        $mpdf->SetDisplayMode('fullpage');
        
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer', $data, true));
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
    
    function questionario() {
        
        $parametro = array(
            'operacao'=> 'LN',
            'aluno'=>base64_decode($this->input->get_post('token')),
            'bimestre' => 2
                            );
         $para1 = array('operacao'=> 'ALUNO',
                           'aluno'=>base64_decode($this->input->get_post('token'))
                            );
        $data['aluno'] = $this->secretaria->aluno_turma($para1);
        $data['listar'] = $this->infantil->questonario($parametro);
        
        //print_r($data['boletim']);exit();
        $html = $this->load->view('impressao/secretaria/questionario', $data, true);
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
        $mpdf->Output($this->input->get_post('token').'.pdf','I');
    }
    
    function quest() {
        $parametro = array('operacao'=> 'L',
                           'aluno'=>$this->input->get_post('token'),//base64_decode($this->input->get_post('token')),
                           'questionario'=>$this->input->get_post('qs')
                            );
         $para1 = array('operacao'=> 'ALUNO',
                           'aluno'=>$this->input->get_post('token'),//base64_decode($this->input->get_post('token'))
                            );
        $data['aluno'] = $this->secretaria->aluno_turma($para1);
        $data['listar'] = $this->infantil->questonario($parametro);
        
        //print_r($data['boletim']);exit();
        $html = $this->load->view('impressao/secretaria/questionario', $data, true);
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
        $mpdf->Output($this->input->get_post('token').'.pdf','D');
    }

}

