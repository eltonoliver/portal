<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Responsavel_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Lista todos os alunos sobre responsabilidade do responsável informado 
     * para um determinado periodo.
     * 
     * @param string $responsavel
     * @param string $periodo
     * @return array 
     */
    public function listarAlunos($responsavel) {
        $this->db->select("AL.*, "
                . "AINF.*, "
                . "DECODE(AINF.CD_MODALIDADE, 1, 'PARCIAL', 2, 'INTEGRAL') AS MODALIDADE", false);
        $this->db->from("BD_SICA.ALU_RESPONSAVEL A");
        $this->db->join("BD_SICA.RESPONSAVEL R", "A.ID_RESPONSAVEL = R.ID_RESPONSAVEL");
        $this->db->join("BD_SICA.ALUNO AL", "AL.CD_ALUNO = A.CD_ALUNO");
        $this->db->join("BD_SICA.CL_ALUNO_INFO AINF", "AINF.CD_ALUNO = A.CD_ALUNO");
        $this->db->where("R.CPF_RESPONSAVEL", $responsavel);
        $this->db->where("A.ACESSO_WEB = 'S'");
        $this->db->where("BD_CONTROLE.F_VALIDA_USUARIO_ALUNO(AL.CD_ALUNO) = 'S'");
        $this->db->order_by("AL.NM_ALUNO ASC");

        $query = $this->db->get();
        return $query->result_array();
    }

    /*     * ************************** PROCEDURES ****************************** */

    function aes_cl_alu_proxima_serie($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_CD_ALUNO', 'value' => $p['aluno']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_SICA', 'AES_CL_ALU_PROXIMA_SERIE', $params);
    }

    function rematricula($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $p['operacao']),
            array('name' => ':P_PERIODO_ATUAL', 'value' => $p['periodo']),
            array('name' => ':P_CD_ALUNO', 'value' => $p['aluno']),
            array('name' => ':P_RES_CPF', 'value' => $p['responsavel']),
            array('name' => ':P_ACEITO', 'value' => $p['aceito']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_ALUNO_REMATRICULA', $params);
    }

    function acompanhamento($parametro) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_CPF_RESPONSAVEL', 'value' => $parametro['responsavel']),
            array('name' => ':P_CD_ALUNO', 'value' => $parametro['aluno']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_RESPONSAVEL_ALUNO', $params);
    }

    function aluno($parametro) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_CPF_RESPONSAVEL', 'value' => $parametro['responsavel']),
            array('name' => ':P_CD_ALUNO', 'value' => $parametro['aluno']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_RESPONSAVEL_ALUNO', $params);
    }

}
