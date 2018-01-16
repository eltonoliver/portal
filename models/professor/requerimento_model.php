<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Requerimento_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function sp_requerimento_professor($parametro) { //print_r($parametro);//exit;
        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':CD_DISCIPLINA', 'value' => $parametro['cd_disciplina']),
            array('name' => ':CD_PROFESSOR', 'value' => $parametro['cd_professor']),
            array('name' => ':CD_ESTRUTURA', 'value' => $parametro['cd_estrutura']),
            array('name' => ':BIMESTRE', 'value' => $parametro['bimestre']), 
            array('name' => ':CD_TURMA', 'value' => $parametro['cd_turma']),
            array('name' => ':NUM_NOTA', 'value' => $parametro['num_nota']),
            array('name' => ':CD_ALUNO', 'value' => $parametro['cd_aluno']),
            array('name' => ':CD_TIPO_REQ', 'value' => $parametro['cd_tipo_req']),
            array('name' => ':OBSERVACAO', 'value' => $parametro['observacao']),
            array('name' => ':CD_CURSO', 'value' => $parametro['cd_curso']),
            array('name' => ':TIPO_NOTA', 'value' => $parametro['tipo_nota']),
            array('name' => ':TURNO', 'value' => $parametro['turno']),
            array('name' => ':CD_REQUERIMENTO', 'value' => $parametro['cd_requerimento']),
            array('name' => ':CD_REQ_MOTIVO', 'value' => $parametro['cd_req_motivo']),
            array('name' => ':CD_SOLICITANTE', 'value' => $parametro['cd_solicitante']),
            array('name' => ':P_NOVA_NOTA', 'value' => $parametro['nova_nota']),
            array('name' => ':CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_SICA', 'SP_REQUERIMENTO_PROFESSOR', $params);
    }

}    
