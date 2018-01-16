<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();

		   $this->load->model('login_model','login', TRUE);
           $this->load->helper(array('form','url','html','directory'));
		   $this->load->library(array('form_validation','session','upload'));
		   if($this->session->userdata('SCL_SSS_USU_ID') == FALSE){ redirect(base_url('index.php'), 'refresh');}
    }

	function index(){
    	redirect(base_url('restrito'), 'refresh');
	}

	function acesso(){

		$data['titulo'] = '<h1> Bem Vindo ao Portal Acadêmico <i class="icon-double-angle-right"></i> Primeiro Acesso </h1>';
		$data['navegacao'] = 'Portal Acadêmico > 1º Acesso';
    	$this->load->view('login/acesso', $data);

	}

	 function primeiro_acesso() {

        $this->form_validation->set_rules('sclusuario', 'usuário', 'required|xss_clean');
        $this->form_validation->set_rules('sclsenha', 'senha', 'required|xss_clean|min_length[6]|max_length[12]|matches[sclsenhaconfirma]');
		$this->form_validation->set_rules('sclsenhaconfirma', 'Confirmar Senha', 'required|xss_clean|min_length[6]|max_length[12]');

		$data = array(

			'titulo'=>'<h1> Bem Vindo ao Portal Acedêmico <i class="icon-double-angle-right"></i> Primeiro Acesso </h1>',
			'navegacao'=>'Bem Vindo ao Portal Acadêmico > 1º Acesso'

		);

        if($this->form_validation->run() == FALSE) {

            $this->load->view('login/acesso',$data);

         } else {

			$result = $this->login->primeiro_acesso($this->input->post('sclusuario'), $this->input->post('sclsenha'));
			if($result){
            	redirect(''.$this->session->userdata('SCL_SSS_TIPO').'/dashboard', 'refresh');
			}else{
				$this->form_validation->set_message('result', "<div class='alert alert-danger'><span class='glyphicon glyphicon-remove-circle'></span> usuário/senha inválidos</div>");
			}
         }
    
     }
	
}