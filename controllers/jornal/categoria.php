<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Categoria extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('jornal/jornal_model','jornal', TRUE);       
        $this->load->library(array('form_validation','session','tracert','email','upload'));
        $this->load->helper(array('url','form','html','directory','file','funcoes'));
    }
    
    function index() {
        $data = array(
            'titulo'=>'<h1> Jornal <i class="fa fa-angle-double-right"></i> Lista de Categorias</h1>',
            'listar'=>$this->jornal->lista_categoria()
        );
        $this->load->view('jornal/categoria',$data);
    }
    
    function cadastro_categoria() {
        $acao = base64_decode($this->input->get_post('token'));
        switch($acao){
             case "cadastrar": // INSERIR DADOS NO BANCO
                $data = array(
                    'titulo'=>'<h3> Jornal <i class="fa fa-angle-double-right"></i> Adicionar Categoria </h3>',
                    'subtitulo'=>'Cadastrar nova categoria',
                    'acao'=>$acao,
                    'autor'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                    'nm_autor'=>$this->session->userdata('SCL_SSS_USU_NOME'),
                    'bt_cor'=>'success',
                    'bt_acao'=>'Inserir',
                    'lista_caderno'=>$this->jornal->lista_caderno()->result()
                );
            break;
        
            case "editar": // INSERIR DADOS NO BANCO
                $data = array(
                    'titulo'=>'<h3> Jornal <i class="fa fa-angle-double-right"></i> Adicionar Categoria </h3>',
                    'subtitulo'=>'Editar categoria',
                    'acao'=>$acao,
                    'autor'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                    'nm_autor'=>$this->session->userdata('SCL_SSS_USU_NOME'),
                    'bt_cor'=>'warning',
                    'bt_acao'=>'Editar',
                    'lista_caderno'=>$this->jornal->lista_caderno()->result(),
                    'dados'=> $this->jornal->pesquisar_categoria(md5_decrypt($this->input->get('id'), 123))->result()
                );
            break;
            
            case "excluir":
                $data = array(
                    'titulo'=>'<h3> Jornal <i class="fa fa-angle-double-right"></i> Excluir Caderno</h3>',
                    'subtitulo'=>'Tem certeza que deseja excluir o registro?',
                    'acao'=>$acao,
                    'autor'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                    'nm_autor'=>$this->session->userdata('SCL_SSS_USU_NOME'),
                    'bt_cor'=>'danger',
                    'bt_acao'=>'Excluir',
                    'dados'=> $this->jornal->pesquisar_categoria(md5_decrypt($this->input->get('id'), 123))->result()
                );
            break;
        }
        
        /*
        switch($this->input->get_post('acao')){
            case 1: // INSERIR DADOS NO BANCO
                $data = array(
                    'titulo'=>'<h3> Jornal <i class="fa fa-angle-double-right"></i> Adicionar Categoria </h3>',
                    'acao'=>$this->input->get_post('acao'),
                    'bt_cor'=>'success',
                    'bt_acao'=>'Inserir'
                );
            break;
            case 2: // EDITAR DADOS NO BANCO
                $pesquisar = $this->jornal->pesquisar_categoria($this->input->get_post('codigo'));
                foreach($pesquisar as $row){
                    $data['codigo'] = $row->CD_CATEGORIA;
                    $data['categoria'] = $row->DC_CATEGORIA;
                    $data['tipo'] = $row->TIPO;
                    $data['titulo'] = '<h3> Colégio <i class="icon-double-angle-right"></i> Editar Notícia </h3>';
                    $data['acao'] = $this->input->get_post('acao');
                    $data['bt_cor'] = 'warning';
                    $data['bt_acao'] = 'Editar';
                }
            break;
            case 3: //EXCLUIR DADOS DO BANCO
                $pesquisar = $this->jornal->pesquisar_categoria($this->input->get_post('codigo'));
                    foreach($pesquisar as $row){
                        $data['codigo'] = $row->CD_CATEGORIA;
                        $data['categoria'] = $row->DC_CATEGORIA;
                        $data['tipo'] = $row->TIPO;
                        $data['titulo'] = '<h3> Colégio <i class="icon-double-angle-right"></i> Excluir Categoria </h3>';
                        $data['acao'] = $this->input->get_post('acao');
                        $data['bt_cor'] = 'danger';
                        $data['bt_acao'] = 'Deletar';
                    }
            break;
			
        }
         */
        $this->load->view('jornal/cadastro_categoria',$data);
    }
    
    function registar_infor(){
        $acao = base64_decode($this->input->get_post('acao'));
         switch($acao){
             case "cadastrar": // INSERIR DADOS NO BANCO
                $this->form_validation->set_rules('categoria', 'CATEGORIA', 'required');
                $this->form_validation->set_rules('caderno', 'CADERNO', 'required');
                
                if($this->form_validation->run() == FALSE) {
                    $data = array(
                        'titulo'=> '<h4> Jornal <i class="icon-double-angle-right"></i> Cadastro de Categorias</h4>',
                        'subtitulo'=>'Cadastrar nova categoria',
                        'categoria'=> $this->input->get_post('categoria'),
                        'tipo'=> $this->input->get_post('tipo'),
                        'acao'=> $_REQUEST['acao'],
                        'bt_cor'=> $_REQUEST['bt_cor'],
                        'bt_acao'=>$_REQUEST['bt_acao'],
                        'lista_caderno'=>$this->jornal->lista_caderno()->result()
                    );
                    $this->load->view('jornal/cadastro_categoria',$data);
                }else{
                    $parametro = array('TIPO' => $this->input->get_post('tipo'),
                                       'CATEGORIA'=>$this->input->get_post('categoria'),
                                       'CD_CADERNO'=>$this->input->get_post('caderno'));
                    
                    $sucesso = $this->jornal->inserir_categoria($parametro);
                    if($sucesso){
                        set_msg('msgok','Regsitro inserido com secesso','sucesso');
                    }else{
                        set_msg('msgerro','Erro ao inserir o registro.','erro');
                    }
                    redirect(base_url('jornal/categoria/cadastro_categoria?token='.  base64_encode('cadastrar')), 'refresh');
                }
            break;
            
            case "editar":
                $data = array('titulo'=>'<h1> Jornal <i class="fa fa-angle-right"></i> Lista de Cadernos</h1>',
                              'acao'=> $_REQUEST['acao'],
                              'bt_cor'=> $_REQUEST['bt_cor'],
                              'bt_acao' => $_REQUEST['bt_acao'],
                              'dados'=> $this->jornal->pesquisar_categoria($this->input->post('codigo'))->result(),
                              'lista_caderno'=>$this->jornal->lista_caderno()->result()
                            );
                $this->form_validation->set_rules('categoria', 'CATEGORIA', 'required');
                $this->form_validation->set_rules('caderno', 'CADERNO', 'required');
                if($this->form_validation->run() == FALSE) {
                    $this->load->view('jornal/cadastro_categoria',$data);
                }else{
                    $parametro = array('CODIGO'=>$this->input->get_post('codigo'),
                                       'TIPO' => $this->input->get_post('tipo'),
                                       'CATEGORIA'=>$this->input->get_post('categoria'),
                                       'CD_CADERNO'=>$this->input->get_post('caderno'));
                    $sucesso = $this->jornal->editar_categoria($parametro);
                    if($sucesso){
                        set_msg('msgok','Registro alterado com secesso','sucesso');
                    }else{
                        set_msg('msgerro','Erro ao alterar o registro.','erro');
                    }
                    redirect(base_url('jornal/categoria'), 'refresh');
                }
            break;
            
            case "excluir":
                $dados = array(
                    'CD_CATEGORIA'=>$this->input->post('codigo')
                );
                $retorno = $this->jornal->deletar_categoria($dados);
                if($retorno){
                    set_msg('msgok','Registro excluido com secesso','sucesso');
                }else{
                    set_msg('msgerro','Erro ao excluir o registro.','erro');
                }
                redirect(base_url('jornal/categoria'), 'refresh');
            break;
         }
    }    
    
    
//    function registar_infor() {
//        
//        
//        /*
//        $acao = base64_decode($this->input->get_post('acao'));
//        $this->form_validation->set_rules('categoria', 'CATEGORIA', 'required');
//        $this->form_validation->set_rules('tipo', 'TIPO', 'required');
//        $this->form_validation->set_rules('caderno', 'CADERNO', 'required');
//        if($this->form_validation->run() == FALSE) {
//            $data = array(
//                    'titulo'=> '<h4> Jornal <i class="icon-double-angle-right"></i> Cadastro de Categorias</h4>',
//                    'subtitulo'=>'Cadastrar nova categoria',
//                    'categoria'=> $this->input->get_post('categoria'),
//                    'tipo'=> $this->input->get_post('tipo'),
//                    'acao'=> $_REQUEST['acao'],
//                    'bt_cor'=> $_REQUEST['bt_cor'],
//                    'bt_acao'=>$_REQUEST['bt_acao'],
//                    'lista_caderno'=>$this->jornal->lista_caderno()->result()
//                    );
//            $this->load->view('jornal/cadastro_categoria',$data);
//        }else{
//            switch($acao){
//                case "cadastrar": // INSERIR DADOS NO BANCO
//                    $parametro = array(
//                                        'TIPO' => $this->input->get_post('tipo'),
//                                        'CATEGORIA'=>$this->input->get_post('categoria'),
//                                        'CD_CADERNO'=>$this->input->get_post('caderno'));
//                    $sucesso = $this->jornal->inserir_categoria($parametro);
//                    if($sucesso == TRUE){
//                        set_msg('msgok','Registro inserido com secesso.','sucesso');
//                    }else{
//                        set_msg('megerro','Erro ao inserir o registro.','erro');
//                    }
//                    redirect(base_url('jornal/categoria/cadastro_categoria?token='.base64_encode('cadastrar')), 'refresh');
//                break;
//                case 2: // EDITA DADOS NO BANCO
//                    $parametro = array('tipo' => $this->input->get_post('tipo'),
//                                       'categoria'=>$this->input->get_post('categoria'),
//                                       'codigo'=>$this->input->get_post('codigo'));
//                    
//                    $sucesso = $this->jornal->editar_categoria($parametro);
//                    if($sucesso == TRUE){
//                        set_msg('msgok','Categoria editada com secesso.','sucesso');
//                    }else{
//                        set_msg('megerro','Erro ao editar a categoria.','erro');
//                    }
//                    redirect(base_url('index.php/jornal/categoria/'), 'refresh');
//                break;
//                case 3: // EXCLUSAO DADOS NO BANCO
//                    $codigo = $this->input->get_post('codigo');
//                    $sucesso = $this->jornal->deletar_categoria($codigo);
//                    if($sucesso == TRUE){
//                        set_msg('msgok','Categoria excluida com secesso.','sucesso');
//                    }else{
//                        set_msg('megerro','Erro ao excluir a categoria.','erro');
//                    }
//                    redirect(base_url('index.php/jornal/categoria/'), 'refresh');
//                break;	 
//            }
//         } */
//    }
}