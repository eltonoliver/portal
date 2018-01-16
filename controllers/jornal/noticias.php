<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Noticias extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('jornal/jornal_model','jornal', TRUE);       
        $this->load->library(array('form_validation','session','tracert','email','upload'));
        $this->load->helper(array('url','form','html','directory','file','funcoes'));
    }
    
    function enviar_anexo($arquivo,$cd_niticia){
        $caminho = ''.$_SERVER['DOCUMENT_ROOT'].'/portal/application/upload/noticia/'.$cd_niticia;
        if(is_dir($caminho)){
            $caminho = ''.$_SERVER['DOCUMENT_ROOT'].'/portal/application/upload/noticia/'.$cd_niticia;
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
        $data['titulo'] = '<h1> Jornal <i class="fa fa-angle-double-right"></i> Lista de Noticias</h1>';
        $dados = array(
                    'operacao'=>'L'
                );
        $data['listar'] = $this->jornal->execultar_sp_noticias($dados);
        $this->load->view('jornal/noticias',$data);
    }
    
    function cadastro_noticia() {
        $data['titulo'] = '<h4> Jornal<i class="fa fa-angle-double-right"></i> Cadastro de Noticias</h4>';
        switch($this->input->get_post('acao')){
            case 1: // INSERIR DADOS NO BANCO
                $data = array(
                    'titulo'=>'<h3> Jornal <i class="fa fa-angle-double-right"></i> Adicionar Noticias </h3>',
                    'acao'=>$this->input->get_post('acao'),
                    'autor'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                    'nm_autor'=>$this->session->userdata('SCL_SSS_USU_NOME'),
                    'bt_cor'=>'success',
                    'bt_acao'=>'Inserir'
                );
            break;
            case 2: // CARREGA AS INFORMACAORS PARA EDITAR DADOS NO BANCO
                $dados = array(
                    'operacao'=>'C','cd_noticia'=>$_GET['codigo']
                );
                $pesquisar = $this->jornal->execultar_sp_noticias($dados);
                foreach($pesquisar as $row){
                    $data['codigo'] = $row['CD_NOTICIAS'];
                    $data['tipo'] = $row['CD_CATEGORIA'];
                    $data['autor'] = $row['AUTOR'];
                    $data['cd_membro'] = $row['CD_MEMBRO'];
                    $data['titulo_noticia'] = $row['TITULO'];
                    $data['texto'] =  $row['DESCRICAO'];
                    $data['titulo'] = '<h3> Colégio <i class="fa fa-angle-double-right"></i> Editar Notícia </h3>';
                    $data['acao'] = $this->input->get_post('acao');
                    $data['bt_cor'] = 'warning';
                    $data['bt_acao'] = 'Editar';
                }
            break;
            case 3: //EXCLUIR DADOS DO BANCO
                $dados = array(
                    'operacao'=>'C','cd_noticia'=>$_GET['codigo']
                );
                $pesquisar = $this->jornal->execultar_sp_noticias($dados);
                foreach($pesquisar as $row){
                    $data['codigo'] = $row['CD_NOTICIAS'];
                    $data['tipo'] = $row['CD_CATEGORIA'];
                    $data['autor'] = $row['AUTOR'];
                    $data['cd_membro'] = $row['CD_MEMBRO'];
                    $data['titulo_noticia'] = $row['TITULO'];
                    $data['texto'] =  $row['DESCRICAO'];
                    $data['titulo'] = '<h3> Colégio <i class="fa fa-angle-double-right"></i> Excluir Noticia </h3>';
                    $data['acao'] = $this->input->get_post('acao');
                    $data['bt_cor'] = 'danger';
                    $data['bt_acao'] = 'Deletar';
                }
            break;
			
        }
        $data['autores'] = $this->jornal->lista_autores();
        $data['categoria'] = $this->jornal->lista_categoria_noticia();
        $this->load->view('jornal/cadastro_noticia',$data);
    }
    
    function registar_infor() {
         $this->form_validation->set_rules('categoria', 'CATEGORIA', 'required');
         $this->form_validation->set_rules('titulo', 'TITULO', 'required');
         $this->form_validation->set_rules('cd_autor', 'AUTOR', 'required');
         $this->form_validation->set_rules('texto', 'TEXTO', 'required');
         if($this->form_validation->run() == FALSE) {
            $data['titulo'] = '<h4> Jornal <i class="icon-double-angle-right"></i> Cadastro de Noticia</h4>';
            $data['categoria'] = $this->input->get_post('categoria');
            $data['cd_autor'] = $this->input->get_post('cd_autor');
            $data['autor'] = $this->input->get_post('autor');
            $data['titulo_noticia'] = $this->input->get_post('titulo');
            $data['texto'] = $this->input->get_post('texto');
            $data['acao'] = $_REQUEST['acao'];
            $data['bt_cor'] = $_REQUEST['bt_cor'];
            $data['bt_acao'] = $_REQUEST['bt_acao'];
            $data['categoria'] = $this->jornal->lista_categoria_noticia();
            $data['autores'] = $this->jornal->lista_autores();
            $this->load->view('jornal/cadastro_noticia',$data);
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
                                    'publicado' => $this->input->get_post('publicado')
                                );
                    $sucesso = $this->jornal->execultar_sp_noticias($parametro);
                    
                    if($sucesso){
                        set_msg('msgok','Noticia inserida com secesso','sucesso');
                    }else{
                        set_msg('msgerro','Erro ao inserir a noticia.','erro');
                    }
                    redirect(base_url('index.php/jornal/noticias/'), 'refresh');
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
                    
                    $sucesso = $this->jornal->execultar_sp_noticias($parametro);
                    if($sucesso == 1){
                        set_msg('msgok','Noticia editada com secesso','sucesso');
                    }else{
                        set_msg('msgerro','Erro ao editar a noticia.','erro');
                    }
                    redirect(base_url('index.php/jornal/noticias/'), 'refresh');
                break;
                case 3: // EXCLUSAO DADOS NO BANCO
                    $parametro = array(
                                       'operacao' => 'D',
                                       'codigo'=>$this->input->get_post('codigo'));
                    $sucesso = $this->jornal->deletar_noticia($this->input->get_post('codigo'));
                    if($sucesso == TRUE){
                        set_msg('msgok','Noticia excluido com secesso','sucesso');
                    }else{
                        set_msg('msgerro','Erro ao excluir a noticia.','erro');
                    }
                    redirect(base_url('index.php/jornal/noticias/'), 'refresh');
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
            redirect(base_url('index.php/jornal/noticias/upload_img?tipo=N&codigo='.$_GET['codigo']), 'refresh');
        }else{
            $data['titulo'] = '<h4> Jornal <i class="fa fa-angle-double-right"></i> Upload Imagem</h4>';
            $data['imagem'] = $this->jornal->lista_imagem_noticia($_GET['codigo']);
            $this->load->view('jornal/upload_img',$data);
        }
    }
    
}