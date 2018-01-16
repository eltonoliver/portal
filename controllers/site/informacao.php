<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Informacao extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('site/site_model','site', TRUE);       
        $this->load->library(array('form_validation','session','email','upload'));
        $this->load->helper(array('url','form','html','directory','file','funcoes'));
    }
    
    function enviar_anexo($arquivo){
        $caminho = ''.$_SERVER['DOCUMENT_ROOT'].'/portal/application/upload/site/';
        if(is_dir($caminho)){
            $caminho = ''.$_SERVER['DOCUMENT_ROOT'].'/portal/application/upload/site/';
        }else{
            mkdir ($caminho, 0777);
        }
        
        $data['caminho'] = $caminho;#''.$_SERVER['DOCUMENT_ROOT'].'/seculo/application/upload/funcionario/';
        $data['diretorio'] = directory_map($data['caminho']);
        $file = "".$arquivo."";
        $config['upload_path'] = $caminho;#''.$_SERVER['DOCUMENT_ROOT'].'/seculo/application/upload/funcionario/';
        $config['allowed_types'] = '*';
        $config['max_size']	= '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name']  = true;
      
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload($file)){
                return NULL;
        }else{
                $dados = $this->upload->data();
                $anexo =  $dados['raw_name'].$dados['file_ext'];
                return $anexo;
        }
    }
    
    function index() { 
        $data['titulo'] = '<h1> Site <i class="fa fa-angle-double-right"></i> Informações Gerais</h1>';
        $dados = array('operacao'=>'INFO');
        $data['info'] = $this->site->sp_site($dados);

        $this->load->view('site/info/index',$data);
    }
    
    function cadastrar(){
        $dados = array('operacao'=>'INFO');
        $info = $this->site->sp_site($dados);
        
        $dados1 = array(
                'apresentacao'=>$this->input->post('apresentacao'),
                'ens_infantil'=>$this->input->post('ens_infantil'),
                'ens_fundamental'=>$this->input->post('ens_fundamental'),
                'ens_medio'=>$this->input->post('ens_medio'),
                );
        
        if(count($info[0]['CD_INFO']) == 0){
            $dados1['operacao'] = 'IINFO';
            $sucesso = $this->site->sp_site($dados1);
        }else{
            $dados1['operacao'] = 'EINFO';
            $sucesso = $this->site->sp_site($dados1);
        }

        if($sucesso){
            set_msg('msgok','Registro inserido com secesso','sucesso');
        }else{
            set_msg('msgerro','Erro ao inserir o registro.','erro');
        }
        redirect(base_url('site/informacao/index'), 'refresh');
    }
}