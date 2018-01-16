<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Questao_Opcao_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_ACADEMICO.AVAL_QUESTAO_OPCAO";
        $this->view = "BD_ACADEMICO.AVAL_QUESTAO_OPCAO";
    }

    /**
     * Retorna as alternativas de uma determinada questão objetiva
     * 
     * @param int $questao
     * @return array
     */
    function listarAlternativas($questao) {
        $this->db->select("
            CD_QUESTAO,
            CD_OPCAO,
            DC_OPCAO,  
            FLG_CORRETA"
        );
        $this->db->from("BD_ACADEMICO.AVAL_QUESTAO_OPCAO");
        $this->db->where("CD_QUESTAO", $questao);
        $this->db->order_by("CD_OPCAO");

        $query = $this->db->get();
        return $query->result();
    }

    function limpa_resposta($p) {
        $data = array(
            'FLG_CORRETA' => 0
        );
        $this->db->where('CD_QUESTAO', $p['questao']);
        $r = $this->db->update('BD_ACADEMICO.AVAL_QUESTAO_OPCAO', $data);
    }

    function resposta($p) {
        $data = array(
            'FLG_CORRETA' => 1
        );
        $this->db->where('CD_QUESTAO', $p['questao']);
        $this->db->where('CD_OPCAO', $p['opcao']);
        $this->db->update('BD_ACADEMICO.AVAL_QUESTAO_OPCAO', $data);
    }

    /**
     * 
     * @param array $params Vetor com os campos do banco e os seus valores
     * 
     * Note: A utilização da procedure ocorreu pelo fato do frame não conseguir
     * realizar o escape adequado nos campos do tipo clob da descrição da 
     * questão e alternativas. Ocorria erro ao inserir quando o usuário digitava
     * alguns caracteres especiais e aspas simples.
     */
    public function procedure_manter_questao_opcao($params) {
        $cursor = '';
        $parametros = array(
            array('name' => ':P_OPERACAO', 'value' => $params['operacao']),
            array('name' => ':P_CD_QUESTAO', 'value' => $params['CD_QUESTAO']),
            array('name' => ':P_CD_PROVA', 'value' => $params['CD_PROVA']),
            array('name' => ':P_CD_OPCAO', 'value' => $params['CD_OPCAO']),
            array('name' => ':P_DC_OPCAO', 'value' => $params['DC_OPCAO']),
            array('name' => ':P_CD_USU_CADASTRO', 'value' => $params['CD_USU_CADASTRO']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->procedure('BD_ACADEMICO', 'AVAL_MANTER_QUESTAO_OPCAO', $parametros);
    }

}
