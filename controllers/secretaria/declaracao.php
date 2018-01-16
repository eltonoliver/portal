<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Declaracao extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('responsavel_model', 'responsavel', TRUE);
        $this->load->model('coordenacao/ocorrencia_model', 'ocorrencia', TRUE);
        $this->load->model('secretaria/secretaria_model', 'secretaria', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file', 'funcoes'));
        $this->load->library(array('form_validation', 'session', 'email', 'upload', 'pagination'));
    }

    function index() {

        $data = array(
            'titulo' => 'Declarações & Solicitações',
            'aluno' => $this->responsavel->acompanhamento(array('operacao' => 'L', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO')))
        );
        $this->load->view('/secretaria/declaracao/index', $data);
    }

    function documento() {

        $data = array(
            'titulo' => 'Declarações & Solicitações',
            'aluno' => $this->input->get('aluno'),
            'documento' => $this->input->get('codigo'),
        );
        $this->load->view('/secretaria/declaracao/frmdocumento', $data);
    }

    function pdf() {
        $authent = (time('dmYhmis') . '' . $this->input->post('aluno') . $this->input->post('documento'));
        $params = array(
            'codigo' => $this->input->post('aluno'),
            'documento' => $this->input->post('documento'),
            'anexo' => $this->input->post('aluno') . '/Documentos/' . $authent . '.pdf',
            'autenticador' => $authent,
        );
        $data = array(
            'doc' => $this->secretaria->declaracao($params),
            'autentique' => $authent
        );
        $html = $this->load->view('/secretaria/declaracao/documento', $data, true);

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $mpdf->SetHTMLHeader($this->load->view('impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', 0, // margin_left
                0, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                0); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer_decl', $data, true));
        $mpdf->WriteHTML($html);
        $mpdf->Output('' . $_SERVER['DOCUMENT_ROOT'] . '/portal/application/upload/aluno/' . $this->input->post('aluno') . '/Documentos/' . $authent . '.pdf', 'f');

        redirect(base_url() . 'secretaria/declaracao');
    }

}