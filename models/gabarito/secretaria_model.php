<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Secretaria_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function tempos($parametro) {

        $cursor = '';
        $params = array(
            array('name' => ':P_CD_ALUNO', 'value' => $parametro['aluno']),
            array('name' => ':P_PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':P_DT_INICIO', 'value' => ''),
            array('name' => ':P_DT_FIM', 'value' => ''),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_RH', 'SP_COL_RELAT_HORARIO_ALUNO', $params);
    }
    
    function atividade($parametro) {

        $cursor = '';
        $params = array(
            array('name' => ':P_CD_ALUNO', 'value' => $parametro['aluno']),
            array('name' => ':P_PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':P_DT_INICIO', 'value' => ''),
            array('name' => ':P_DT_FIM', 'value' => ''),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_RH', 'SP_COL_RELAT_HORARIO_ATIVIDADE', $params);
    }

    function aluno($dado) {

        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $dado['operacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $dado['aluno']),
            array('name' => ':P_CD_TURMA', 'value' => $dado['turma']),
            array('name' => ':P_PERIODO', 'value' => $periodo),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->procedure('BD_PORTAL', 'AES_ALUNO_MATRICULADO', $params);
    }
    
    function boletim($dado) {

        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $cursor = '';
        $params = array(
            array('name' => ':P_CD_ALUNO', 'value' => $dado['aluno']),
            array('name' => ':P_PERIODO', 'value' => $periodo),
            array('name' => ':P_CD_CURSO', 'value' => $dado['curso']),
            array('name' => ':P_ORDEM_SERIE', 'value' => $dado['serie']),
            array('name' => ':P_CD_TURMA', 'value' => $dado['turma']),
            array('name' => ':P_TIPO_DEMONSTRATIVO', 'value' => $dado['tipo']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_SICA', 'AES_BOLETIM_COLEGIO', $params);
    }
    
    function plano_ensino($dado) {
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $dado['operacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $dado['aluno']),
            array('name' => ':P_DT_INICIO', 'value' => $dado['dt_inicio']),
            array('name' => ':P_DT_FIM', 'value' => $dado['dt_fim']),
            array('name' => ':P_CD_DISCIPLINA', 'value' => $dado['disciplina']),
            array('name' => ':P_CD_TURMA', 'value' => $dado['turma']),
            array('name' => ':P_PERIODO', 'value' => $periodo),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_PORTAL', 'AES_PLANO_ENSINO', $params);
    }
    
    function aluno_turma($dado) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $dado['operacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $dado['aluno']),
            array('name' => ':P_CD_CURSO', 'value' => $dado['curso']),
            array('name' => ':P_ORDEM_SERIE', 'value' => $dado['ordem']),
            array('name' => ':P_CD_TURMA', 'value' => $dado['turma']),
            array('name' => ':P_PERIODO', 'value' => $periodo),
            array('name' => ':P_CD_DISCIPLINA', 'value' => $dado['disciplina']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        
        return $this->db->procedure('BD_PORTAL', 'SP_CL_CURSO_SERIE_TURMA_ALUNO', $params);
    }
    
    function responsavel($dado) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $dado['operacao']),
            array('name' => ':P_CPF_RESPONSAVEL', 'value' => $dado['cpf']),
            array('name' => ':P_CD_ALUNO', 'value' => $dado['aluno']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_PORTAL', 'AES_RESPONSAVEL_ALUNO', $params);
    }
    
    
    function objeto($dado) {

        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $cursor = '';
        $params = array(
            array('name' => ':p_CD_ALUNO', 'value' => $dado['codigo']),
            array('name' => ':p_PERIODO', 'value' => $periodo),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_SICA', 'AES_OBJETOS_DISPONIVEIS', $params);
    }
    
    function declaracao($dado) {
        
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $cursor = '';
        $retorno = '';


        $params = array(
            array('name' => ':p_CD_ALUNO', 'value' => $dado['codigo']),
            array('name' => ':p_PERIODO', 'value' => $periodo),
            array('name' => ':p_CD_DOCUMENTO', 'value' => $dado['documento']),
            array('name' => ':p_ANEXO', 'value' => $dado['anexo']),
            array('name' => ':p_AUTENTICACAO', 'value' => $dado['autenticador']),
            array('name' => ':p_MSG_RETORNO', 'value' => $retorno),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->procedure('BD_SICA', 'AES_DOCUMENTO', $params);
    }
    
    function documento($dado) {
        
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $dado['operacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $dado['aluno']),
            array('name' => ':P_NM_ALUNO', 'value' => $dado['nome']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->procedure('BD_PORTAL', 'AES_SECRETARIA', $params);
    }
    
    function pajela($dado) {
        
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $dado['operacao']),
            array('name' => ':P_CD_TURMA', 'value' => $dado['turma']),
            array('name' => ':P_CD_ALUNO', 'value' => $dado['aluno']),
            array('name' => ':P_BIMESTRE', 'value' => $dado['bimestre']),
            array('name' => ':P_NUM_NOTA', 'value' => $dado['num_nota']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->procedure('BD_PORTAL', 'AES_PAJELA', $params);
    }
    
}
