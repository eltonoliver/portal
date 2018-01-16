<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uniformes extends CI_Controller {
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
        if($this->input->post('acao') == 1){
            $dados = array('operacao'=>'LU' );
            $uniforme = $this->site->sp_site($dados);
            
 
            $banner = $this->enviar_anexo('banner');
            $dados1 = array(
                'descricao'=>$this->input->post('descricao'),
                'banner'=>$banner);
             
            //print_r(count($dados));
            
            if(count($uniforme[0]['CD_UNIFORME']) == 0){
                $dados1['operacao'] = 'IU';
                $sucesso = $this->site->sp_site($dados1);
            }else{
                $dados1['operacao'] = 'EU';
                $sucesso = $this->site->sp_site($dados1);
            }
            
            if($sucesso){
                set_msg('msgok','Registro inserido com secesso','sucesso');
            }else{
                set_msg('msgerro','Erro ao inserir o registro.','erro');
            }
            redirect(base_url('site/uniformes/index'), 'refresh');
        }else{
            $data['titulo'] = '<h1> Site <i class="fa fa-angle-double-right"></i> Dados do Uniformes</h1>';
            $dados2 = array('operacao'=>'LU');
            $data['uniforme'] = $this->site->sp_site($dados2);

            $this->load->view('site/uniformes/cadastro_uniformes',$data);
        }
    }
}