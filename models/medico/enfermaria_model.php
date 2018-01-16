<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Enfermaria_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function sp_arquivo($parametro) { #print_r($parametro);exit;
        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':CD_PROFESSOR', 'value' => $parametro['cd_professor']),
            array('name' => ':ARQUIVO', 'value' => $parametro['arquivo']),
            array('name' => ':CD_DISCIPLINA', 'value' => $parametro['cd_disciplina']),
            array('name' => ':DESCRICAO', 'value' => $parametro['descricao']),
            array('name' => ':TAMANHO', 'value' => $parametro['tamanho']),
            array('name' => ':TURMA', 'value' => $parametro['cd_turma']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_PROFESSOR_ARQUIVO', $params);
    }
    
    function academico($p) { #print_r($parametro);exit;
        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $p['operacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $p['aluno']),
            array('name' => ':P_NM_ALUNO', 'value' => strtoupper($p['nome'])),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_SECRETARIA', $params);
    }
    

}
