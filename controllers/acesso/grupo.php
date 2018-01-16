<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grupo extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('desenvolvimento/acesso_model', 'acesso', TRUE);
        $this->load->model('administrativo/administrativo_model', 'admin', TRUE);

        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library(array('form_validation', 'session'));
    }

    function index() {

        $data = array(
            'titulo' => '<h3> Controle de Acesso <i class="fa fa-angle-right"></i> Grupo de Acesso </h3>',
            'navegacao' => 'Controle de Acesso > Grupo de Acesso',
            'listar' => $this->acesso->grupo(array('operacao'=>'L')),
        );
        $this->load->view('acesso/grupo/index', $data);
    }

    function tabela_programa() {
        if($this->input->get_post('codigo') > 0){
        $data = array(
                      'listar' => $this->acesso->grupo(array('operacao'=>'FG', 'codigo'=>$this->input->get_post('codigo'))),
                      'programa' => $this->acesso->programa(array('operacao'=>'L')),
                      );
        $this->load->view('acesso/grupo/tabela_programa', $data);
        }else{
            echo '<div class="col-sm-12 well center"><i class="fa fa-info-circle fa-1x"></i> Selecione um grupo para filtrar seus programas </div>';
        }
    }
    
    
    function tabela_usuario() {
        
        if($this->input->get_post('codigo') > 0){
        $data = array(
                      'usuario' => $this->acesso->grupo(array('operacao'=>'UG', 'codigo'=>$this->input->get_post('codigo'))),
                      'listar' => $this->acesso->usuario(array('operacao'=>'L')),
                     );
        $this->load->view('acesso/grupo/tabela_usuario', $data);
        }else{
            echo '<div class="col-sm-12 well center"><i class="fa fa-info-circle fa-1x danger"></i> Selecione um grupo para filtrar seus usuários</div>';
        }
    }
    
    function view() {
        
        if($this->input->get_post('tipo') != 'adicionar'){
            $filtro = $this->acesso->programa(array('operacao'=>'F', 'codigo'=>$this->input->get_post('codigo')));
        }else{
            $filtro = '';
        }

        $data = array(
            'titulo' => $this->input->get_post('tipo'),
            'sistema' => $this->acesso->sistema(array('operacao'=>'L')),
            'filtro' => $filtro
        );
        $this->load->view('acesso/grupo/view', $data);
    }
    
    function manter() {
        
        $parametro = array('operacao'=>$this->input->get_post('operacao'),
                           'codigo'=>$this->input->get_post('codigo'),
                           'nome'=>$this->input->get_post('nome'),
                           'sistema'=>$this->input->get_post('tsistema'),
                           'formulario'=>$this->input->get_post('formulario'),
                           'observacao'=>$this->input->get_post('observacao'),
                           'classe'=>$this->input->get_post('classe'),
                           );
        $retorno = $this->acesso->programa($parametro);
        if($retorno == 0){
            echo "Erro ao ".$this->input->get_post('tipo')." Cadastro";
        }else{
            echo "".$this->input->get_post('tipo')." realizado";
        }
        
    }    
    
    function permissao() {
        
        $parametro = array('operacao'=>$this->input->get_post('operacao'),
                           'codigo'=>$this->input->get_post('codigo'),
                           'programa'=>$this->input->get_post('programa'),
                           'incluir'=>(($this->input->get_post('incluir') ? '0' : true) ? 0 : 1),
                           'alterar'=>(($this->input->get_post('alterar') ? '0' : true) ? 0 : 1),
                           'exclur'=>(($this->input->get_post('excluir') ? '0' : true) ? 0 : 1),
                           'imprimir'=>(($this->input->get_post('imprimir') ? '0' : true) ? 0 : 1),
                           'especial1'=>(($this->input->get_post('especial1') ? '0' : true) ? 0 : 1),
                           'especial2'=>(($this->input->get_post('especial2') ? '0' : true) ? 0 : 1),
                           );
        
        print_r($parametro);
        $retorno = $this->acesso->grupo($parametro);
        
        if($retorno == 0){
            echo "Erro ao Cadastro";
        }else{
            echo " realizado";
        }
        
    }

}