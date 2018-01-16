<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Conteudo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('professor/conteudo_model', 'conteudo', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file','funcoes'));
        $this->load->library(array('form_validation', 'session', 'upload'));

    }

    function index() {    
        $paramentro = array('operacao'=>'LT',
                            'periodo'=> $this->session->userdata('SCL_SSS_USU_PERIODO'),
                            'cd_professor'=>$this->session->userdata('SCL_SSS_USU_PCODIGO'));
        $data = array(
            'titulo' => '<h1> Contéudo <i class="fa fa-angle-double-right"></i> Ministrado</h1>',
            'grade' => $this->conteudo->sp_coonteudo($paramentro)
        );
        
        $this->load->view('professor/conteudo/index', $data);
    }
    
}
