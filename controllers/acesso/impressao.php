<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Impressao extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('desenvolvimento/acesso_model', 'acesso', TRUE);
        $this->load->model('administrativo/administrativo_model', 'admin', TRUE);

        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library(array('form_validation', 'session','encrypt'));
    }

    function usuario() {
        
        $parametro = array('usuario' => base64_decode($this->input->get_post('token')),
                           'operacao' => 'LP'
        );
        $data = array(
                      'titulo' => "Relatório de Permissões de Usuário",
                      'listar' => $this->acesso->usuario($parametro),
                      );
        $html = $this->load->view('impressao/acesso/usuario', $data, true);
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $mpdf->SetHTMLHeader($this->load->view('impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', 0, // margin_left
                0, // margin right
                5, // margin top
                0, // margin bottom
                0, // margin header
                0); // margin footer 
        $mpdf->SetDisplayMode('fullpage');
        
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer', $data, true));
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

}