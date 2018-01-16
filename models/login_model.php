<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function acesso($parametro) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_USUARIO', 'value' => $parametro['usuario']),
            array('name' => ':P_SENHA', 'value' => $parametro['senha']),
            array('name' => ':P_SENHA_ALTERADA', 'value' => $parametro['nova_senha']),
            array('name' => ':P_PESSOA', 'value' => $parametro['pessoa']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        //print_r($params);
        return $this->db->sp_seculo('BD_PORTAL', 'AES_PORTAL_ACESSO', $params);
    }

}



