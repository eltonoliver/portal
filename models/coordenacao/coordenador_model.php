<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coordenador_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function sp_curso_serie_turma_aluno($dado) {
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $cursor = '';

        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $dado['operacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $dado['aluno']),
            array('name' => ':P_CD_CURSO', 'value' => $dado['curso']),
            array('name' => ':P_ORDEM_SERIE', 'value' => $dado['serie']),
            array('name' => ':P_CD_TURMA', 'value' => $dado['turma']),
            array('name' => ':P_PERIODO', 'value' => $periodo),
            array('name' => ':P_CD_DISCIPLINA', 'value' => $dado['disciplina']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->sp_seculo('BD_PORTAL', 'SP_CL_CURSO_SERIE_TURMA_ALUNO', $params);
    }

    function aluno($dado) {
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $cursor = '';

        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $dado['operacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $dado['aluno']),
            array('name' => ':P_DATA', 'value' => $this->input->oracle_data($dado['data'])),
            array('name' => ':P_CD_TURMA', 'value' => $dado['turma']),
            array('name' => ':P_PERIODO', 'value' => $periodo),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_COORD_ALUNO', $params);
    }

    /**
     * Operações:
     * 
     * TR - Lista todas as turmas regulares do professor.
     */
    public function professor($dados) {
        $cursor = "";
        $params = array(
            array("name" => ":P_OPERACAO", "value" => $dados['operacao']),
            array("name" => ":P_CD_PROFESSOR", "value" => $dados['cd_professor']),
            array("name" => ":P_CD_TURMA", "value" => $dados['cd_turma']),
            array("name" => ":P_CD_DISCIPLINA", "value" => $dados['cd_disciplina']),
            array("name" => ":P_ORDEM_SERIE", "value" => $dados['ordem_serie']),
            array("name" => ":P_CD_CURSO", "value" => $dados['cd_curso']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->procedure("BD_PORTAL", "AES_PROFESSOR", $params);
    }

}
