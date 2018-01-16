<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Controle_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // RELAÇÃO DE ALUNOS SOB A RESPONSABILIDADE DE UMA PESSOA
    function acesso_catraca($dados) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $dados['operacao']),
            array('name' => ':P_DT_BASE', 'value' => $dados['data']),
            array('name' => ':P_TIPO_USUARIO', 'value' => $dados['tipo']),
            array('name' => ':P_FLG_PASSAGEM', 'value' => $dados['passe']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_CONTROLE', 'GET_PASSAGENS', $params);
    }

}

