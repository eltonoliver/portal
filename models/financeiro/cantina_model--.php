<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cantina_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function pdv($parametro) {
        $cursor = '';
        $params = array(
            array('name' => ':P_ID_TERMINAL', 'value' => $parametro['terminal']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PDV', 'GET_PRODUTOS_TERMINAL', $params);
    }
    
    //usuario seculoweb = 5327
    
    function venda($parametro) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_ID_VENDA', 'value' => $parametro['venda']),
            array('name' => ':P_ID_TERMINAL', 'value' => 1),
            array('name' => ':P_ID_PRODUTO', 'value' => $parametro['produto']),
            array('name' => ':P_NR_ORDEM', 'value' => $parametro['ordem']),
            array('name' => ':P_QUANTIDADE', 'value' => $parametro['quantidade']),
            array('name' => ':P_PRECO_UNITARIO', 'value' => $parametro['preco']),
            array('name' => ':P_VL_UNIDADE', 'value' => $parametro['valor']),
            array('name' => ':P_ID_CAIXA',  'value' => $parametro['caixa']),
            array('name' => ':P_CD_ALUNO', 'value' => $parametro['aluno']),
            array('name' => ':P_VL_TOTAL', 'value' => $parametro['total']),
            array('name' => ':P_ID_STATUS', 'value' => $parametro['status']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        //print_r($params);
        return $this->db->sp_seculo('BD_PDV', 'AUTO_ATENDIMENTO', $params);
    }
    
    function limite($parametro) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $parametro['aluno']),
            array('name' => ':P_LIMITE_ANTIGO',  'value' => $parametro['antigo']),
            array('name' => ':P_LIMITE_NOVO', 'value' => $parametro['novo']),
            array('name' => ':P_ID_RESPONSAVEL', 'value' => $parametro['responsavel']),
            array('name' => ':P_NM_MAQUINA', 'value' => $parametro['maquina']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        //print_r($params);
        return $this->db->sp_seculo('BD_PDV', 'CREDITO_ALUNO', $params);
    }

}
