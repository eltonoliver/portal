<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends CI_Controller {

    function __construct() {
        parent::__construct();
        
        $this->load->model('desenvolvimento/acesso_model', 'acesso', TRUE);
        $this->load->model('administrativo/administrativo_model', 'admin', TRUE);

        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library(array('form_validation', 'session'));
    }

    function index() {

        $data = array(
            'titulo' => '<h1> Controle de Acesso <i class="fa fa-angle-right"></i> Usuários </h1>',
            'navegacao' => 'Controle de Acesso > Usuários',
            'listar' => $this->acesso->usuario(array('operacao'=>'L')),
        );
        $this->load->view('acesso/usuario/index', $data);
    }
    
    function modalNovoUsuario() {

        $data = array(
            'titulo' => '<h1> Controle de Acesso <i class="fa fa-angle-right"></i> Usuários </h1>',
            'navegacao' => 'Controle de Acesso > Usuários',
            'mantenedora' => $this->admin->tabela(array('operacao'=>'LMANT'))
        );
        $this->load->view('acesso/usuario/frmNovo', $data);
    }
    
    function desbloquear() {
        
        $data = array(
            'titulo' => '<h1> Controle de Acesso <i class="fa fa-angle-right"></i> Desbloquar Usuário </h1>',
            'navegacao' => 'Controle de Acesso > Usuários',
            'mantenedora' => $this->admin->tabela(array('operacao'=>'LMANT'))
        );
        $this->load->view('acesso/usuario/frmDesbloquear', $data);
    }

}