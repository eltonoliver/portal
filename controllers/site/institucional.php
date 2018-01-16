<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Institucional extends CI_Controller {
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
        $data['titulo'] = '<h1> Site <i class="fa fa-angle-double-right"></i> Dados da Instituição</h1>';
        $dados = array('operacao'=>'L');
        $data['listar'] = $this->site->sp_site_institucional($dados);

        $this->load->view('site/institucional/index',$data);
    }
    
    function cadastrar_institucional() {
        $data = array(
            'titulo'=>'<h3> Site <i class="fa fa-angle-double-right"></i> Novas Informações</h3>',
            'autor'=>$this->session->userdata('SCL_SSS_USU_NOME')
        );
        
        $this->load->view('site/institucional/cadastrar_institucional',$data);
    }
    
    function confirmar(){
        $banner = $this->enviar_anexo('banner');
        $dados = array(
            'operacao'=>'I',
            'titulo'=>$this->input->post('titulo'),
            'descricao'=>$this->input->post('descricao'),
            'autor'=>$this->input->post('autor'),
            'banner'=>$banner
        );
        
        $sucesso = $this->site->sp_site_institucional($dados);
        if($sucesso){
            set_msg('msgok','Registro cadastrado com secesso','sucesso');
        }else{
            set_msg('msgerro','Erro ao cadastrar o registro.','erro');
        }
        redirect(base_url('site/institucional/cadastrar_institucional'), 'refresh');
    }
    
    function editar(){
        $id = base64_decode($this->input->get('id'));
        $dados = array('operacao'=>'C','cd_institucional'=>$id);
        $data = array(
            'titulo'=>'<h3> Site <i class="fa fa-angle-double-right"></i> Novas Informações</h3>',
            'retorno' => $this->site->sp_site_institucional($dados));
        
        $this->load->view('site/institucional/editar_institucional',$data);
    }
    
    function editar_confirmar(){
        $banner = $this->enviar_anexo('banner');
        $dados = array(
            'operacao'=>'E',
            'cd_institucional'=>$this->input->post('id'),
            'titulo'=>$this->input->post('titulo'),
            'descricao'=>$this->input->post('descricao'),
            'banner'=>$banner
        );
        
        $sucesso = $this->site->sp_site_institucional($dados);
        if($sucesso){
            set_msg('msgok','Registro editado com secesso','sucesso');
        }else{
            set_msg('msgerro','Erro ao editar o registro.','erro');
        }
        redirect(base_url('site/institucional/index'), 'refresh');
    }
    
    function excluir(){
        $parametro = array(
            'operacao'=>'D',
            'cd_institucional' => $this->uri->segment(4));
         $sucesso = $this->site->sp_site_institucional($parametro);
         if($sucesso == TRUE){
             set_msg('msgok','Parceiro excluido com secesso','sucesso');
         }else{
             set_msg('msgerro','Erro ao excluir o parceiro.','erro');
         }
         redirect(base_url('site/institucional/index'), 'refresh');
    }
}