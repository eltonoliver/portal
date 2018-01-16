<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aluno extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('colegio/colegio_model', 'colegio', TRUE);
        $this->load->model('secretaria/secretaria_model', 'secretaria', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file', 'funcoes'));
        $this->load->library(array('form_validation', 'session', 'email', 'pagination'));
    }

    function ficha_tabela() {
        $data = array(
            'listar' => $this->secretaria->documento($data = array('operacao'=>'BA', 'nome'=>$this->input->post('nome')))
            );
        $this->load->view('/secretaria/aluno/listar_ficha', $data);
    }
    
    function ficha() {
        $data = array(
           'aluno' => $this->colegio->sp_curso_serie_turma_aluno($data = array('operacao'=>'ALUNO', 'aluno'=>$this->input->get('aluno'))),
           'responsavel' => $this->colegio->sp_curso_serie_turma_aluno($data = array('operacao'=>'RES', 'aluno'=>$this->input->get('aluno')))
        );
        $this->load->view('/secretaria/aluno/ficha', $data);
    }
}