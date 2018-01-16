<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Administrativo_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function tabela($dado) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $dado['operacao']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_ADMINISTRATIVO', $params);
    }

}
/*Dia 11/06 nas festa junina do século, só será permitida a entrada no estacionamento com o cartào de transito livre.*/
