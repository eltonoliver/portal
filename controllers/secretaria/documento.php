<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Documento extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('responsavel_model', 'responsavel', TRUE);
        $this->load->model('secretaria/secretaria_model', 'secretaria', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file', 'funcoes'));
        $this->load->library(array('form_validation', 'session', 'email', 'upload', 'pagination'));
    }

    function index() {

        $data = array(
            'titulo' => 'Documentos Pendentes',
            'aluno' => $this->responsavel->acompanhamento(array('operacao' => 'L', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO')))
        );
        $this->load->view('/secretaria/documento/index', $data);
    }

}