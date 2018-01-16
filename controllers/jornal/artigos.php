<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Artigos extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('jornal/jornal_model','jornal', TRUE);       
        $this->load->library(array('form_validation','session','email','upload'));
        $this->load->helper(array('url','form','html','directory','file','funcoes'));
    }
    
    function enviar_anexo($arquivo,$cd_artigo){
        $caminho = ''.$_SERVER['DOCUMENT_ROOT'].'/portal/application/upload/artigo/'.$cd_artigo;
        if(is_dir($caminho)){
            $caminho = ''.$_SERVER['DOCUMENT_ROOT'].'/portal/application/upload/artigo/'.$cd_artigo;
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
        
        $data['titulo'] = 'Jornal <i class="fa fa-angle-double-right"></i> Lista de Artigos';
        $dados = array(
                    'operacao'=>'L'
                );
        $data['listar'] = $this->jornal->execultar_sp_artigo($dados);
        $this->load->view('jornal/artigos',$data);
    }
    
    function cadastro_artigo() { 
        switch($this->input->get_post('acao')){
            case 1: // INSERIR DADOS NO BANCO
                $data = array(
                    'titulo'=>'<h3> Jornal <i class="fa fa-angle-double-right"></i> Adicionar Artigo </h3>',
                    'acao'=>$this->input->get_post('acao'),
                    'autor'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                    'nm_autor'=>$this->session->userdata('SCL_SSS_USU_NOME'),
                    'bt_cor'=>'success',
                    'bt_acao'=>'Inserir'
                );
            break;
            case 2: // EDITAR DADOS NO BANCO
                $dados = array(
                    'operacao'=>'C','cd_artigo'=>$_GET['codigo']
                );
                $pesquisar = $this->jornal->execultar_sp_artigo($dados);
                
                foreach($pesquisar as $row){ 
                    $data['codigo'] = $row['CD_ARTIGO'];
                    $data['tipo'] = $row['CD_CATEGORIA'];
                    $data['cd_autor'] = $row['AUTOR'];
                    $data['cd_membro'] = $row['CD_MEMBRO'];
                    $data['titulo_artigo'] = $row['TITULO'];
                    $data['texto'] =  $row['DESCRICAO'];
                    $data['titulo'] = '<h3> Colégio <i class="fa fa-angle-double-right"></i> Editar Artigo </h3>';
                    $data['acao'] = $this->input->get_post('acao');
                    $data['bt_cor'] = 'warning';
                    $data['bt_acao'] = 'Editar';
                }
            break;
            case 3: //EXCLUIR DADOS DO BANCO
                $dados = array(
                    'operacao'=>'C','cd_artigo'=>$_GET['codigo']
                );
                $pesquisar = $this->jornal->execultar_sp_artigo($dados);
               # $pesquisar = $this->jornal->pesquisar_artigo($_GET['codigo']);
                foreach($pesquisar as $row){
                    $data['codigo'] = $row['CD_ARTIGO'];
                    $data['tipo'] = $row['CD_CATEGORIA'];
                    $data['cd_autor'] = $row['AUTOR'];
                    $data['cd_membro'] = $row['CD_MEMBRO'];
                    $data['titulo_artigo'] = $row['TITULO'];
                    $data['texto'] =  $row['DESCRICAO'];
                    $data['titulo'] = '<h3> Colégio <i class="fa fa-angle-double-right"></i> Excluir Noticia </h3>';
                    $data['acao'] = $this->input->get_post('acao');
                    $data['bt_cor'] = 'danger';
                    $data['bt_acao'] = 'Deletar';
                }
            break;
			
        }
        $data['autores'] = $this->jornal->lista_autores();
        $data['categoria'] = $this->jornal->lista_categoria_artigo();
        $this->load->view('jornal/cadastro_artigo',$data);
    }
    
    function registar_infor() { 
         $this->form_validation->set_rules('categoria', 'CATEGORIA', 'required');
         $this->form_validation->set_rules('titulo', 'TITULO', 'required');
         $this->form_validation->set_rules('cd_autor', 'AUTOR', 'required');
         $this->form_validation->set_rules('texto', 'TEXTO', 'required');
         if($this->form_validation->run() == FALSE) {
            $data['titulo'] = '<h4> Jornal <i class="fa fa-angle-double-right"></i> Cadastro de Categorias</h4>';
            $data['categoria'] = $this->input->get_post('categoria');
            $data['cd_autor'] = $this->input->get_post('cd_autor');
            $data['autor'] = $this->input->get_post('autor');
            $data['titulo_artigo'] = $this->input->get_post('titulo');
            $data['texto'] = $this->input->get_post('texto');
            $data['acao'] = $_REQUEST['acao'];
            $data['bt_cor'] = $_REQUEST['bt_cor'];
            $data['bt_acao'] = $_REQUEST['bt_acao'];
            $data['categoria'] = $this->jornal->lista_categoria_artigo();
            $data['autores'] = $this->jornal->lista_autores();
            $this->load->view('jornal/cadastro_artigo',$data);
         }else{
             
            switch($this->input->get_post('acao')){
                case 1: // INSERIR DADOS NO BANCO
                    $anexo = $this->enviar_anexo('arquivo');
                    $parametro = array(
                                    'operacao' => 'I',
                                    'autor' => $this->input->get_post('cd_autor'),
                                    'categoria'=>$this->input->get_post('categoria'),
                                    'titulo' => $this->input->get_post('titulo'),
                                    'capa' => $anexo,
                                    'texto' => $this->input->get_post('texto'),
                                    'publicado' => ($this->input->get_post('publicado')? 1:0)
                                );
                   
                    $sucesso = $this->jornal->execultar_sp_artigo($parametro);
                    if($sucesso){
                        set_msg('msgok','Noticia inserida com secesso','sucesso');
                    }else{
                        set_msg('msgerro','Erro ao inserir a noticia.','erro');
                    }
                    redirect(base_url('index.php/jornal/artigos/'), 'refresh');
                break;
                case 2: // EDITA DADOS NO BANCO
                    $anexo = $this->enviar_anexo('arquivo');              
                    $parametro = array(
                                       'operacao' => 'U',
                                       'categoria'=>$this->input->get_post('categoria'),
                                       'autor' => $this->input->get_post('cd_autor'),
                                       'titulo' => $this->input->get_post('titulo'),
                                       'capa' => $anexo,
                                       'texto' => $this->input->get_post('texto'),
                                       'publicado' => $this->input->get_post('publicado'),
                                       'codigo'=>$this->input->get_post('codigo'));
                    
                    $sucesso = $this->jornal->execultar_sp_artigo($parametro);
                 #   $sucesso = $this->jornal->editar_artigo($parametro);
                    if($sucesso == TRUE){
                        set_msg('msgok','Noticia editada com secesso','sucesso');
                    }else{
                        set_msg('msgerro','Erro ao editar a noticia.','erro');
                    }
                    redirect(base_url('index.php/jornal/artigos/'), 'refresh');
                break;
                case 3: // EXCLUSAO DADOS NO BANCO
                    $codigo = $this->input->get_post('codigo');
                    $sucesso = $this->jornal->deletar_artigo($codigo);
                    if($sucesso == TRUE){
                        set_msg('msgok','Noticia excluido com secesso','sucesso');
                    }else{
                        set_msg('erro','<p class="alert alert-danger">Erro ao excluir o artigo.</p>');
                    }
                    redirect(base_url('index.php/jornal/artigos/'), 'refresh');
                break;	 
            }
         }
    }
    
    function upload_img(){
        if($_POST){ 
            $con = explode(",", $_POST['contador']);
            for ($i = 0; $i < count($con); $i++) {
                if($_FILES['arquivo'.$i]['name'] != ""){
                    $imagem = $this->enviar_anexo('arquivo'.$i,$this->input->get_post('codigo'));   
                    $this->jornal->insert_imagem($imagem,$this->input->get_post('codigo'),$this->input->get_post('tipo'));
                }
            }
            redirect(base_url('index.php/jornal/artigos/upload_img?tipo=A&codigo='.$_GET['codigo']), 'refresh');
        }else{
            $data['titulo'] = '<h4> Jornal <i class="fa fa-angle-double-right"></i> Upload Imagem</h4>';
            $data['imagem'] = $this->jornal->lista_imagem_artigo($_GET['codigo']);
            $this->load->view('jornal/upload_img',$data);
        }
    }
    
}