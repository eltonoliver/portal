<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Correcao extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file','funcoes'));
        $this->load->library(array('form_validation', 'session', 'upload'));
        $this->load->model('provas/correcao_model','correcao',TRUE);
        $this->load->model('provas/provas_model','provas',TRUE);
        
        $sessao = $this->session->userdata;
        $ips = explode('.',$sessao['ip_address']);
        //var_dump($sessao);
//        if($ips[0] != '10' ){
//            $this->load->view('provas/bloqueado');
//        }
    }

    function index(){
        $data = array('titulo'=>'Lista de Provas para Correção', 
                     'listar'=>$this->provas->lista_provas()->result()
                     );
        $this->load->view('provas/lista_provas',$data);
    }
    
    function lista_questao_prova(){
        $data = array('titulo'=>'Questões da Prova', 
                     'questoes'=>$this->correcao->lista_questoes($this->input->get('cd_prova'))->result(),
                     'prova'=>$this->correcao->dados_prova($this->input->get('cd_prova'))->result()
                     );
   //print_r($data['questoes']);exit;     
        $this->load->view('provas/correcao/lista_questao_prova',$data);
        
    }

    
    
}

 