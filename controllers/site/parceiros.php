<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parceiros extends CI_Controller {
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
        $data['titulo'] = '<h1> Site <i class="fa fa-angle-double-right"></i> Lista de Parceiros</h1>';
        $dados = array('operacao'=>'L');
        $data['listar'] = $this->site->sp_site_parceiro($dados);

        $this->load->view('site/parceiro/index',$data);
    }
    
    function cadastrar_parceiro() {
        $data = array(
            'titulo'=>'<h3> Site <i class="fa fa-angle-double-right"></i> Adicionar Parceiros </h3>',
            'autor'=>$this->session->userdata('SCL_SSS_USU_NOME')
        );
        
        $this->load->view('site/parceiro/cadastro_parceiro',$data);
    }
    
    function cadastrar(){
        $logo = $this->enviar_anexo('logo');
        $banner = $this->enviar_anexo('banner');
        $dados = array(
            'operacao'=>'I',
            'nome'=>$this->input->post('nome'),
            'titulo'=>$this->input->post('titulo'),
            'descricao'=>$this->input->post('descricao'),
            'banner'=>$banner,
            'logo'=>$logo,
            'cd_usuario'=>$this->input->post('autor')
        );
        
        $sucesso = $this->site->sp_site_parceiro($dados);
        if($sucesso){
            set_msg('msgok','Parceiro cadastrado com secesso','sucesso');
        }else{
            set_msg('msgerro','Erro ao cadastrar o Parceiro.','erro');
        }
        redirect(base_url('site/parceiros/cadastrar_parceiro'), 'refresh');
    }
    
    function excluir(){
        $parametro = array(
            'operacao'=>'D',
            'cd_parceiro' => $this->uri->segment(4));
         $sucesso = $this->site->sp_site_parceiro($parametro);
         if($sucesso == TRUE){
             set_msg('msgok','Parceiro excluido com secesso','sucesso');
         }else{
             set_msg('msgerro','Erro ao excluir o parceiro.','erro');
         }
         redirect(base_url('site/parceiros/index'), 'refresh');
    }
  
    function editar(){
        $parametro = array(
            'operacao'=>'C',
            'cd_parceiro' => base64_decode($this->input->get('cd')));
        $data = array(
            'titulo'=>'<h3> Site <i class="fa fa-angle-double-right"></i> Editar Parceiros </h3>',
            'dados'=>$this->site->sp_site_parceiro($parametro)
        );
        
        $this->load->view('site/parceiro/editar_parceiro',$data);
    }
    function editar_parceiro(){
        $logo = $this->enviar_anexo('logo');
        $banner = $this->enviar_anexo('banner');
        $dados = array(
            'operacao'=>'U',
            'cd_parceiro'=>$this->input->post('cd_parceiro'),
            'nome'=>$this->input->post('nome'),
            'titulo'=>$this->input->post('titulo'),
            'descricao'=>$this->input->post('descricao'),
            'cd_usuario'=>$this->input->post('autor')
        );
        if($logo != ''){
            $dados['logo'] = $logo;
        }
        if($banner != ''){
            $dados['banner'] = $banner;
        }
    #    print_r($dados);exit;
        $sucesso = $this->site->sp_site_parceiro($dados);
        if($sucesso){
            set_msg('msgok','Parceiro editada com secesso','sucesso');
        }else{
            set_msg('msgerro','Erro ao editar a parceiro.','erro');
        }
        redirect(base_url('index.php/site/parceiros/index'), 'refresh');
    }
   
//    function upload_img(){
//        if($_POST){ 
//            $con = explode(",", $_POST['contador']);
//            for ($i = 0; $i < count($con); $i++) {
//                if($_FILES['arquivo'.$i]['name'] != ""){
//                    $imagem = $this->enviar_anexo('arquivo'.$i,$this->input->get_post('codigo'));   
//                    $this->jornal->insert_imagem($imagem,$this->input->get_post('codigo'),$this->input->get_post('tipo'));
//                }
//            }
//            redirect(base_url('index.php/jornal/noticias/upload_img?tipo=N&codigo='.$_GET['codigo']), 'refresh');
//        }else{
//            $data['titulo'] = '<h4> Jornal <i class="fa fa-angle-double-right"></i> Upload Imagem</h4>';
//            $data['imagem'] = $this->jornal->lista_imagem_noticia($_GET['codigo']);
//            $this->load->view('jornal/upload_img',$data);
//        }
//    }
    
}