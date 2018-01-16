<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Noticias extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('site/site_model','site', TRUE);       
        $this->load->library(array('form_validation','session','email','upload'));
        $this->load->helper(array('url','form','html','directory','file','funcoes'));
    }
    
    function enviar_anexo($arquivo){
        $caminho = ''.$_SERVER['DOCUMENT_ROOT'].'/portal/application/upload/noticia/site/';
        if(is_dir($caminho)){
            $caminho = ''.$_SERVER['DOCUMENT_ROOT'].'/portal/application/upload/noticia/site/';
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
        $data['titulo'] = '<h1> Site <i class="fa fa-angle-double-right"></i> Lista de Noticias</h1>';
        $dados = array('operacao'=>'L');
        $data['listar'] = $this->site->sp_site_noticias($dados);

        $this->load->view('site/noticias/index',$data);
    }
    
    function cadastrar_noticia() {
        $data = array(
            'titulo'=>'<h3> Site <i class="fa fa-angle-double-right"></i> Adicionar Noticias </h3>',
            'autor'=>$this->session->userdata('SCL_SSS_USU_NOME')
        );
        
        $this->load->view('site/noticias/cadastro_noticia',$data);
    }
    
    function cadastrar(){
        $imagem = $this->enviar_anexo('imagem');
        $dados = array(
            'operacao'=>'I',
            'autor'=>$this->input->post('autor'),
            'imagem'=>$imagem,
            'titulo'=>$this->input->post('titulo'),
            'descricao'=>$this->input->post('descricao'),
            'data'=>$this->input->post('dt_evento')
        );
        
        $sucesso = $this->site->sp_site_noticias($dados);
        if($sucesso){
            set_msg('msgok','Noticia inserida com secesso','sucesso');
        }else{
            set_msg('msgerro','Erro ao inserir a noticia.','erro');
        }
        redirect(base_url('index.php/site/noticias/cadastrar_noticia'), 'refresh');
    }
    
    
    function editar_noticia(){
        $cd_noticia = base64_decode($this->input->get('cd_noticia'));
        $parametro = array('operacao'=>'C','cd_noticias'=>$cd_noticia);
        $data = array(
            'titulo'=>'<h3> Site <i class="fa fa-angle-double-right"></i> Editar Noticias </h3>',
            'dados'=>$this->site->sp_site_noticias($parametro)
        );
        $this->load->view('site/noticias/editar_noticia',$data);
    }
    
    function editar(){
        $imagem = $this->enviar_anexo('imagem');
        $dados = array(
            'operacao'=>'U',
            'cd_noticias'=>$this->input->post('cd_noticias'),
            'autor'=>$this->input->post('autor'),
            'imagem'=>$imagem,
            'titulo'=>$this->input->post('titulo'),
            'descricao'=>$this->input->post('descricao'),
            'data'=>$this->input->post('dt_evento')
        );
        
        $sucesso = $this->site->sp_site_noticias($dados);
        if($sucesso){
            set_msg('msgok','Noticia editada com secesso','sucesso');
        }else{
            set_msg('msgerro','Erro ao editar a noticia.','erro');
        }
        redirect(base_url('index.php/site/noticias/index'), 'refresh');
    }
    
    function excluir(){
        $parametro = array(
            'operacao'=>'D',
            'cd_noticias' => $this->uri->segment(4));
         $sucesso = $this->site->sp_site_noticias($parametro);
         if($sucesso == TRUE){
             set_msg('msgok','Parceiro excluido com secesso','sucesso');
         }else{
             set_msg('msgerro','Erro ao excluir o parceiro.','erro');
         }
         redirect(base_url('site/noticias/index'), 'refresh');
    }
    
//    
//    function registar_infor() {
//         $this->form_validation->set_rules('categoria', 'CATEGORIA', 'required');
//         $this->form_validation->set_rules('titulo', 'TITULO', 'required');
//         $this->form_validation->set_rules('cd_autor', 'AUTOR', 'required');
//         $this->form_validation->set_rules('texto', 'TEXTO', 'required');
//         if($this->form_validation->run() == FALSE) {
//            $data['titulo'] = '<h4> Jornal <i class="icon-double-angle-right"></i> Cadastro de Noticia</h4>';
//            $data['categoria'] = $this->input->get_post('categoria');
//            $data['titulo_noticia'] = $this->input->get_post('titulo');
//            $data['texto'] = $this->input->get_post('texto');
//            $data['acao'] = $_REQUEST['acao'];
//            $data['bt_cor'] = $_REQUEST['bt_cor'];
//            $data['bt_acao'] = $_REQUEST['bt_acao'];
//            $data['categoria'] = $this->jornal->lista_categoria_noticia();
//            $data['autores'] = $this->jornal->lista_autores();
//            $this->load->view('jornal/cadastro_noticia',$data);
//         }else{
//            switch($this->input->get_post('acao')){
//                case 1: // INSERIR DADOS NO BANCO
//                    $anexo = $this->enviar_anexo('arquivo');
//                    $parametro = array(
//                                    'operacao' => 'I',
//                                    'autor' => $this->input->get_post('cd_autor'),
//                                    'categoria'=>$this->input->get_post('categoria'),
//                                    'titulo' => $this->input->get_post('titulo'),
//                                    'capa' => $anexo,
//                                    'texto' => $this->input->get_post('texto'),
//                                    'publicado' => $this->input->get_post('publicado')
//                                );
//                    $sucesso = $this->jornal->execultar_sp_noticias($parametro);
//                    
//                    if($sucesso){
//                        set_msg('msgok','Noticia inserida com secesso','sucesso');
//                    }else{
//                        set_msg('msgerro','Erro ao inserir a noticia.','erro');
//                    }
//                    redirect(base_url('index.php/jornal/noticias/'), 'refresh');
//                break;
//                case 2: // EDITA DADOS NO BANCO
//                    $anexo = $this->enviar_anexo('arquivo');   
//                    $parametro = array(
//                                       'operacao' => 'U',
//                                       'categoria'=>$this->input->get_post('categoria'),
//                                       'autor' => $this->input->get_post('cd_autor'),
//                                       'titulo' => $this->input->get_post('titulo'),
//                                       'capa' => $anexo,
//                                       'texto' => $this->input->get_post('texto'),
//                                       'publicado' => $this->input->get_post('publicado'),
//                                       'codigo'=>$this->input->get_post('codigo'));
//                    
//                    $sucesso = $this->jornal->execultar_sp_noticias($parametro);
//                    if($sucesso == 1){
//                        set_msg('msgok','Noticia editada com secesso','sucesso');
//                    }else{
//                        set_msg('msgerro','Erro ao editar a noticia.','erro');
//                    }
//                    redirect(base_url('index.php/jornal/noticias/'), 'refresh');
//                break;
//                case 3: // EXCLUSAO DADOS NO BANCO
//                    $parametro = array(
//                                       'operacao' => 'D',
//                                       'codigo'=>$this->input->get_post('codigo'));
//                    $sucesso = $this->jornal->deletar_noticia($this->input->get_post('codigo'));
//                    if($sucesso == TRUE){
//                        set_msg('msgok','Noticia excluido com secesso','sucesso');
//                    }else{
//                        set_msg('msgerro','Erro ao excluir a noticia.','erro');
//                    }
//                    redirect(base_url('index.php/jornal/noticias/'), 'refresh');
//                break;	 
//            }
//         }
//    }
//    
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