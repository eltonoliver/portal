<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ocorrencia_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function ocorrencia($dado) { 
        /*
         * TIPO DE OPERACAO
         * I - INSERIR | D - DELETAR |  
         */
        $cursor = '';
        $params = array(
                  array('name' => ':P_OPERACAO', 'value' => $dado['operacao']),
                  array('name' => ':P_CD_ALUNO', 'value' => $dado['aluno']),
                  array('name' => ':P_CD_USUARIO', 'value' => $dado['usuario']),
                  array('name' => ':P_TEXTO_OCORRENCIA', 'value' => $dado['texto']),
                  array('name' => ':P_DT_OCORRENCIA', 'value' => $dado['data']),
                  array('name' => ':P_NR_ORDEM', 'value' => $dado['ordem']),
                  array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR));
        return $this->db->sp_seculo('BD_PORTAL', 'AES_OCORRENCIA_DISCIPLINAR', $params);
    }
    
    function gabarito_provas($dado){
        $cursor = '';
        $params = array(
                  array('name' => ':P_OPERACAO', 'value' => $dado['operacao']),
                  array('name' => ':P_CD_ALUNO', 'value' => $dado['aluno']),
                  array('name' => ':P_BIMESTRE', 'value' => $dado['bimestre']),
                  array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR));
        
        return $this->db->sp_seculo('BD_ACADEMICO', 'AVAL_RELATORIO_PROVA_ALUNO', $params);
    }
}
