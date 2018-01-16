<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mensalidade_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function listar_boletos($parametro) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_CPF_RESPONSAVEL', 'value' => $parametro['responsavel']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL','AES_FIN_BOLETO', $params);
    }

    function imprimir($parametro) {

        $cursor = '';
        $params = array(
            array('name' => ':CD_ALUNO', 'value' => $parametro['aluno']),
            array('name' => ':CD_PRODUTO', 'value' => $parametro['produto']),
            array('name' => ':MES_REFERENCIA', 'value' => $parametro['referencia']),
            array('name' => ':NUM_PARCELA', 'value' => $parametro['parcela']),
            array('name' => ':NR_ORDEM', 'value' => $parametro['ordem']),
            array('name' => ':FLG_SICANET', 'value' => 0),
            array('name' => ':FLG_WEBSLIM', 'value' => 0),
            array('name' => ':FLG_SICA', 'value' => 1),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        
        $this->db->query("UPDATE BD_SICA.boletos
			     SET DT_IMPRESSAO = SYSDATE
		           WHERE CD_ALUNO = '".$parametro['aluno']."'
                           AND CD_PRODUTO = ".$parametro['produto']."
			   AND MES_REFERENCIA = '".$parametro['referencia']."'
			   AND NUM_PARCELA = ".$parametro['parcela']."
			   AND NR_ORDEM = ".$parametro['ordem']."");
        
        
        
        return $this->db->sp_seculo('BD_SICA', 'FIN_IMPRESSAO_BOLETO_INFO', $params);
    }
    
    function imprimir_protesto($parametro) {

        $cursor = '';
        $params = array(
            array('name' => ':CD_PROTESTO', 'value' => $parametro['protesto']),
            array('name' => ':FLG_SICANET', 'value' => 0),
            array('name' => ':FLG_WEBSLIM', 'value' => 0),
            array('name' => ':FLG_SICA', 'value' => 1),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_SICA', 'FIN_IMPRESSAO_PROTESTO_INFO', $params);
    }

}
