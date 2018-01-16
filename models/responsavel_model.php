<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Responsavel_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function aes_cl_alu_proxima_serie($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_CD_ALUNO', 'value' => $p['aluno']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_SICA','AES_CL_ALU_PROXIMA_SERIE', $params);
    }
    
    function rematricula($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',      'value' => $p['operacao']),
            array('name' => ':P_PERIODO_ATUAL', 'value' => $p['periodo']),
            array('name' => ':P_CD_ALUNO',      'value' => $p['aluno']),
            array('name' => ':P_RES_CPF',       'value' => $p['responsavel']),
            array('name' => ':P_ACEITO',        'value' => $p['aceito']),
            array('name' => ':P_CURSOR',        'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL','AES_ALUNO_REMATRICULA', $params);
    }

    function acompanhamento($parametro) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_CPF_RESPONSAVEL', 'value' => $parametro['responsavel']),
            array('name' => ':P_CD_ALUNO', 'value' => $parametro['aluno']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL','AES_RESPONSAVEL_ALUNO', $params);
    }
    
    function aluno($parametro) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_CPF_RESPONSAVEL', 'value' => $parametro['responsavel']),
            array('name' => ':P_CD_ALUNO', 'value' => $parametro['aluno']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL','AES_RESPONSAVEL_ALUNO', $params);
    }

}
