<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cobranca_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function devedores($parametro) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_CD_PAGAMENTO', 'value' => $parametro['codigo']),
            array('name' => ':P_AUTENTICACAO', 'value' => $parametro['autenticacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $parametro['aluno']),
            array('name' => ':P_CD_PRODUTO', 'value' => $parametro['produto']),
            array('name' => ':P_MES_REFERENCIA', 'value' => $parametro['mes']),
            array('name' => ':P_NUM_PARCELA', 'value' => $parametro['parcela']),
            array('name' => ':P_NR_ORDEM', 'value' => $parametro['ordem']),
            array('name' => ':P_CPF_RESPONSAVEL', 'value' => $parametro['responsavel']),
            array('name' => ':P_NM_BANDEIRA', 'value' => $parametro['bandeira']),
            array('name' => ':P_TP_TRANSACAO', 'value' => $parametro['tipo']), 
            array('name' => ':P_QTD_PARCELA', 'value' => $parametro['qtd']), 
            array('name' => ':P_STATUS', 'value' => $parametro['status']), 
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        
        return $this->db->sp_seculo('BD_PORTAL','AES_PAGAMENTO_ONLINE', $params);
    }

}
