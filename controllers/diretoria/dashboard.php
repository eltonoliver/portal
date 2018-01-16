<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('diretoria/dashboard_model', 'dash', TRUE);

        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library(array('form_validation', 'session','tracert'));
    }

    function index() {

        $data = array(
            'titulo' => '<h3> Diretoria <i class="fa fa-angle-right"></i> Dashboard </h3>',
            'navegacao' => 'Diretoriao > Dashboard'
        );
        $this->load->view('diretoria/dashboard/index', $data);
    }
    
    function filtro() {
      
        switch($this->input->post('tipo')){
           case 0:  // GRÁFICOS DO ACADEMICO 
               $data = array(
			'matricula2014'=>$this->dash->modalidade('2014/1'),
                        'matricula2015'=>$this->dash->modalidade('2015/1'),
			'alunos2014'=>$this->dash->aluno_modalidade('2014/1'),
                        'alunos2015'=>$this->dash->aluno_modalidade('2015/1'),
                        'bolsas'=>$this->dash->bolsa(),
		);
               $view = 'academico';
           ;break;
           case 1: // GRÁFICOS DO ADMINISTRATIVO
               $data = array(
			'aluno_modalidade'=>$this->dash->modalidade(),
		);
               $view = 'administrativo';
               break;
           case 2: // GRÁFICOS DO FINANCEIRO
               $data = array(
			'faturamento'=>$this->dash->faturamento_resumido(),
			'inadiplencia'=>$this->dash->inadiplencia(),
		);
               $view = 'financeiro';
               break;
           
       }
       
       $this->load->view('diretoria/dashboard/'.$view.'', $data);      
        
    }
    
    function mdldevedor(){
        $data = array(
            'alunos' => $this->dash->inadiplencia_aluno($this->input->get_post('ref')),
        );
        
        $this->load->view('diretoria/dashboard/devedores', $data);  
    }
    
    function todosbolsitas() {

        $data['bolsistas'] = $this->dash->bolsistas();
        //print_r($data['bolsistas']);exit();
        $html = $this->load->view('diretoria/dashboard/bolsistas_listar', $data, true);
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $mpdf->SetHTMLHeader($this->load->view('impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', 
                5, // margin_left
                5, // margin right
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