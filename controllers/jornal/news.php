<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class News extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('jornal/jornal_model','jornal', TRUE);       
        $this->load->library(array('form_validation','session','email','upload'));      
        $this->load->helper(array('url','form','html','directory','file','funcoes','captcha'));
    }
            
    public function thumbs($imagem, $largura, $altura){
        $config['image_library'] = 'GD';
            $config['source_image'] = ''.$_SERVER['DOCUMENT_ROOT'].'/portal/application/upload/news/'.$imagem.'';
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $largura;
        $config['height'] = $altura;
        $this->load->library('image_lib', $config);
        $this->image_lib->resize();
    }
    
    function enviar_anexo($arquivo){
        $caminho = ''.$_SERVER['DOCUMENT_ROOT'].'/portal/application/upload/news/';
        if(is_dir($caminho)){
            $caminho = ''.$_SERVER['DOCUMENT_ROOT'].'/portal/application/upload/news/';
        }else{
            mkdir ($caminho, 0777);
        }
        $data['caminho'] = $caminho;
        $data['diretorio'] = directory_map($data['caminho']);
        $file = "".$arquivo."";
        $config['upload_path'] = $caminho;
        $config['allowed_types'] = '*';
        $config['max_size']	= '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name']  = true;
   
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($file)){
            return NULL;
        }else{
            $dados = $this->upload->data();
            $anexo =  $dados['raw_name'].$dados['file_ext'];
            return $anexo;
        }
    }
    
    function index() {
        $dados = array('OPERACAO'=>'L');
        $data = array(
            'titulo'=>'<h1> Jornal <i class="fa fa-angle-right"></i> Lista de Notícias</h1>',
            'listar'=>$this->jornal->execultar_sp_news($dados)
        );

        $this->load->view('jornal/news',$data);
    }
    
    function cadastrar_news(){
        $acao = base64_decode($this->input->get_post('token'));
        switch($acao){
            case "cadastrar": // INSERIR DADOS NO BANCO
               $data = array(
                   'titulo'=>'<h3> Jornal <i class="fa fa-angle-double-right"></i> Cadastrar News </h3>',
                   'subtitulo'=>'Cadastrar uma nova informação',
                   'acao'=>$acao,
                   'autor'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                   'nm_autor'=>$this->session->userdata('SCL_SSS_USU_NOME'),
                   'bt_cor'=>'success',
                   'bt_acao'=>'Inserir',
                   'lista_categoria'=>$this->jornal->lista_categoria_caderno()->result(),
                   'autores'=>$this->jornal->lista_autores()
               );
            break;
       
            case "editar": // INSERIR DADOS NO BANCO
                $paramentro = array('OPERACAO'=>'C','CD_NEWS'=> md5_decrypt($this->input->get('id'), 123));
                $data = array(
                   'titulo'=>'<h3> Jornal <i class="fa fa-angle-double-right"></i> Cadastrar News </h3>',
                   'subtitulo'=>'Editar dados',
                   'acao'=>$acao,
                   'bt_cor'=>'warning',
                   'bt_acao'=>'Editar',
                   'lista_categoria'=>$this->jornal->lista_categoria_caderno()->result(),
                   'autores'=>$this->jornal->lista_autores(),
                   'dados'=>  $this->jornal->execultar_sp_news($paramentro)
                );
                $this->thumbs($data['dados'][0]['THUMB'],175,175);
                $t = explode(".",$data['dados'][0]['THUMB']);
                $data['thumb'] = $t[0]."_thumb.".$t[1];
                $data['autor'] = $data['dados'][0]['CD_AUTOR'];
                $data['nm_autor'] = $data['dados'][0]['AUTOR'];
                $data['capa'] = $data['dados'][0]['IMG_CAPA'];
           break;
       
       case "excluir": 
                $paramentro = array('OPERACAO'=>'C','CD_NEWS'=> md5_decrypt($this->input->get('id'), 123));
                $data = array(
                   'titulo'=>'<h3> Jornal <i class="fa fa-angle-double-right"></i> Cadastrar News </h3>',
                   'subtitulo'=>'Tem certeza que deseja excluir registro?',
                   'acao'=>$acao,
                   'bt_cor'=>'danger',
                   'bt_acao'=>'excluir',
                   'lista_categoria'=>$this->jornal->lista_categoria_caderno()->result(),
                   'autores'=>$this->jornal->lista_autores(),
                   'dados'=>  $this->jornal->execultar_sp_news($paramentro)
                );
                $data['autor'] = $data['dados'][0]['CD_AUTOR'];
                $data['nm_autor'] = $data['dados'][0]['AUTOR'];
                $data['capa'] = $data['dados'][0]['IMG_CAPA'];
                $data['thumb'] = $data['dados'][0]['THUMB'];
           break;
        }
        $this->load->view('jornal/cadastro_news',$data);
         
    }
    
    function registrar_info(){ 
        $acao = base64_decode($this->input->get_post('acao'));
        switch($acao){
            case "cadastrar": // INSERIR DADOS NO BANCO
                $data = array('titulo'=>'<h1> Jornal <i class="fa fa-angle-right"></i> Cadastrar News </h1>',
                              'subtitulo'=>'Cadastrar uma nova informação',
                              'acao'=> $_REQUEST['acao'],
                              'bt_cor'=> $_REQUEST['bt_cor'],
                              'bt_acao' => $_REQUEST['bt_acao'],
                              'autor'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                              'nm_autor'=>$this->session->userdata('SCL_SSS_USU_NOME'),
                              'lista_categoria'=>$this->jornal->lista_categoria_caderno()->result(),
                              'autores'=>$this->jornal->lista_autores());
                $this->form_validation->set_rules('categoria', 'CATEGORIA', 'required');
                $this->form_validation->set_rules('autor', 'AUTOR', 'required');
                $this->form_validation->set_rules('data', 'DATA DO EVENTO', 'required');
                $this->form_validation->set_rules('titulo', 'TITULO', 'required');
                $this->form_validation->set_rules('resumo', 'RESUMO', 'required');
                $this->form_validation->set_rules('descricao', 'DESCRIÇÃO DA INFORMAÇÃO', 'required');
                if($this->form_validation->run() == FALSE) {
                    $this->load->view('jornal/cadastro_news',$data);
                }else{
                    $capa = $this->enviar_anexo('capa');
                    $thumb = $this->enviar_anexo('thumb');
                    $this->thumbs($thumb,225,136);
                    $dados = array(
                        'OPERACAO'=>'I',
                        'CD_CATEGORIA'=>$this->input->get_post('categoria'),
                        'CD_AUTOR'=>$this->input->get_post('autor'),
                        'TITULO'=>$this->input->get_post('titulo'),
                        'RESUMO'=>$this->input->get_post('resumo'),
                        'IMG_CAPA'=>$capa,
                        'DESCRICAO'=>$this->input->get_post('descricao'),
                        'THUMB'=>$thumb,
                        'DT_EVENTO'=>$this->input->get_post('data'),
                        'PUBLICADO' => ($this->input->get_post('publicado')? 1:0)
                    ); 
                    $retorno = $this->jornal->execultar_sp_news($dados);
                    if($retorno){
                        set_msg('msgok','Regsitro inserido com secesso','sucesso');
                    }else{
                        set_msg('msgerro','Erro ao inserir o registro.','erro');
                    }
                    redirect(base_url('jornal/news/cadastrar_news?token='.  base64_encode('cadastrar')), 'refresh');
                }
            break;  
            case "editar":
                $capa = $this->enviar_anexo('capa');
                $thumb = $this->enviar_anexo('thumb');
                $this->thumbs($thumb,225,136);
                 $dados = array(
                        'OPERACAO'=>'U',
                        'CD_NEWS'=>$this->input->get_post('codigo'),
                        'CD_CATEGORIA'=>$this->input->get_post('categoria'),
                        'CD_AUTOR'=>$this->input->get_post('autor'),
                        'TITULO'=>$this->input->get_post('titulo'),
                        'RESUMO'=>$this->input->get_post('resumo'),
                        'IMG_CAPA'=>$capa,
                        'DESCRICAO'=>$this->input->get_post('descricao'),
                        'THUMB'=>$thumb,
                        'DT_EVENTO'=>$this->input->get_post('data')
                    ); 
                    $retorno = $this->jornal->execultar_sp_news($dados);
                    if($retorno){
                        set_msg('msgok','Regsitro editado com secesso','sucesso');
                    }else{
                        set_msg('msgerro','Erro ao editarr o registro.','erro');
                    }
                    redirect(base_url('jornal/news/'), 'refresh');
            break;
            
            case "excluir":
                 $dados = array(
                        'OPERACAO'=>'E',
                        'CD_NEWS'=>$this->input->get_post('codigo'),
                    ); 
                    $retorno = $this->jornal->execultar_sp_news($dados);
                    if($retorno){
                        set_msg('msgok','Regsitro excluido com secesso','sucesso');
                    }else{
                        set_msg('msgerro','Erro ao excluir o registro.','erro');
                    }
                    redirect(base_url('jornal/news/'), 'refresh');
            break; 
        }
    }
    
    
}