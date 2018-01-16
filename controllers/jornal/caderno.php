<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Caderno extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('jornal/jornal_model','jornal', TRUE);       
        $this->load->library(array('form_validation','session','tracert','email','upload'));      
        $this->load->helper(array('url','form','html','directory','file','funcoes'));
    }
    
    function index() {
        $data = array(
            'titulo'=>'<h1> Jornal <i class="fa fa-angle-right"></i> Lista de Cadernos</h1>',
            'listar'=>$this->jornal->lista_caderno()->result()
        );
        
        $this->load->view('jornal/caderno',$data);
    }
    
    function cadastro_caderno(){
        $acao = base64_decode($this->input->get_post('token'));
         switch($acao){
             case "cadastrar": // INSERIR DADOS NO BANCO
                $data = array(
                    'titulo'=>'<h3> Jornal <i class="fa fa-angle-double-right"></i> Adicionar Caderno </h3>',
                    'subtitulo'=>'Cadastrar novo caderno',
                    'acao'=>$acao,
                    'autor'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                    'nm_autor'=>$this->session->userdata('SCL_SSS_USU_NOME'),
                    'bt_cor'=>'success',
                    'bt_acao'=>'Inserir'
                );
            break;
            case "editar":
                $data = array(
                    'titulo'=>'<h3> Jornal <i class="fa fa-angle-double-right"></i> Editar Caderno</h3>',
                    'subtitulo'=>'Editar Caderno',
                    'acao'=>$acao,
                    'autor'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                    'nm_autor'=>$this->session->userdata('SCL_SSS_USU_NOME'),
                    'bt_cor'=>'warning',
                    'bt_acao'=>'Editar',
                    'dados'=> $this->jornal->consulta_caderno(md5_decrypt($this->input->get('id'), 123))->result()
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
                    'dados'=> $this->jornal->consulta_caderno(md5_decrypt($this->input->get('id'), 123))->result()
                );
            break;
         }
        $this->load->view('jornal/cadastro_caderno',$data);
    }
    
    function registar_infor(){
        $acao = base64_decode($this->input->get_post('acao'));

         switch($acao){
             case "cadastrar": // INSERIR DADOS NO BANCO
                $data = array('titulo'=>'<h1> Jornal <i class="fa fa-angle-right"></i> Lista de Cadernos</h1>',
                              'acao'=> $_REQUEST['acao'],
                              'bt_cor'=> $_REQUEST['bt_cor'],
                              'bt_acao' => $_REQUEST['bt_acao']);
                $this->form_validation->set_rules('caderno', 'CADERNO', 'required');
                if($this->form_validation->run() == FALSE) {
                    $this->load->view('jornal/cadastro_caderno',$data);
                }else{
                    $dados = array(
                        'DESCRICAO'=>  $this->input->post('caderno'),
                        'USER_CADASTRO'=>$this->session->userdata('SCL_SSS_USU_CODIGO')
                    );
                    $retorno = $this->jornal->inserir_caderno($dados);
                    if($retorno){
                        set_msg('msgok','Regsitro inserido com secesso','sucesso');
                    }else{
                        set_msg('msgerro','Erro ao inserir o registro.','erro');
                    }
                    redirect(base_url('jornal/caderno/cadastro_caderno?token='.  base64_encode('cadastrar')), 'refresh');
                }
            break;
            
            case "editar":
               # print_r($_POST); exit;
                $data = array('titulo'=>'<h1> Jornal <i class="fa fa-angle-right"></i> Lista de Cadernos</h1>',
                              'acao'=> $_REQUEST['acao'],
                              'bt_cor'=> $_REQUEST['bt_cor'],
                              'bt_acao' => $_REQUEST['bt_acao'],
                              'dados'=> $this->jornal->consulta_caderno($this->input->post('codigo'))->result()
                            );
                $this->form_validation->set_rules('caderno', 'CADERNO', 'required');
                if($this->form_validation->run() == FALSE) {
                    $this->load->view('jornal/cadastro_caderno',$data);
                }else{
                    $dados = array(
                        'DESCRICAO'=>  $this->input->post('caderno'),
                        'CD_CADERNO'=>$this->input->post('codigo')
                    );
                    $retorno = $this->jornal->editar_caderno($dados);
                    if($retorno){
                        set_msg('msgok','Regsitro alterado com secesso','sucesso');
                    }else{
                        set_msg('msgerro','Erro ao alterar o registro.','erro');
                    }
                    redirect(base_url('jornal/caderno'), 'refresh');
                }
            break;
            
            case "excluir":
                $dados = array(
                    'USER_EXCLUSAO'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                    'CD_CADERNO'=>$this->input->post('codigo')
                );
                $retorno = $this->jornal->excluir_caderno($dados);
                if($retorno){
                    set_msg('msgok','Regsitro excluido com secesso','sucesso');
                }else{
                    set_msg('msgerro','Erro ao excluir o registro.','erro');
                }
                redirect(base_url('jornal/caderno'), 'refresh');
            break;
         }
    }
    
    
}