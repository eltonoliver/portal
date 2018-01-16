<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sms_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function sms($parametro) { //print_r($parametro);
        /*
         * TIPO DE OPERACAO
         * I - INSERIR
         * L - LISTAR MENSAGENS ENVIADAS
         */
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_CD_SMS', 'value' => $parametro['codigo']),
            array('name' => ':P_CD_AUTENTICACAO', 'value' => $parametro['autenticacao']),
            array('name' => ':P_NR_TELEFONE', 'value' => $parametro['telefone']),
            array('name' => ':P_DS_MENSAGEM', 'value' => $parametro['mensagem']),
            array('name' => ':P_CD_DESTINATARIO', 'value' => $parametro['destinatario']),
            array('name' => ':P_TIPO', 'value' => $parametro['tipo']),
            array('name' => ':P_CD_USUARIO', 'value' => $parametro['usuario']),
            array('name' => ':P_CD_ALUNO', 'value' => $parametro['aluno']),
            array('name' => ':P_CD_CURSO', 'value' => $parametro['cd_curso']),
            array('name' => ':P_SERIE', 'value' => $parametro['serie']),
            array('name' => ':P_CD_TURMA', 'value' => $parametro['cd_turma']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_SMS', $params);
    }
}
