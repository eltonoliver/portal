<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // LISTAR DE MODALIDADE
    function modalidade($periodo) {
        $cursor = '';

        $params = array(
            array('name' => ':P_PERIODO', 'value' => $periodo),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->sp_seculo('BD_PORTAL', 'AES_QTD_ALUNOS_MODALIDADE', $params);
    }

    // LISTAR DE ALUNOS
    function aluno_modalidade($periodo) {
        $cursor = '';
        $params = array(
            array('name' => ':P_PERIODO', 'value' => $periodo),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->sp_seculo('BD_PORTAL', 'AES_LST_ALUNOS_MODALIDADE', $params);
    }

    // LISTAR DE FATURAMENTO RESUMIDO MENSAL
    function faturamento_resumido() {
        $cursor = '';
        $params = array(
            array('name' => ':P_PERIODO', 'value' => '2014/1'),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->sp_seculo('BD_PORTAL', 'AES_FATURAMENTO_RESUMO', $params);
    }

    // LISTAR DE BOLSAS
    function bolsa() {
        $cursor = '';
        $params = array(
            array('name' => ':P_PERIODO', 'value' => $this->session->userdata('SCL_SSS_USU_PERIODO')),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->sp_seculo('BD_PORTAL', 'AES_BOLSAS_RESUMO', $params);
    }
    
    // LISTAR DE BOLSISTAS
    function bolsistas() {
        $cursor = '';
        $params = array(
            array('name' => ':P_PERIODO', 'value' => $this->session->userdata('SCL_SSS_USU_PERIODO')),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->sp_seculo('BD_PORTAL', 'AES_BOLSAS_BOLSISTAS', $params);
    }

    // LISTAR DE INADIPLENCIA
    function inadiplencia() {
        $cursor = '';
        $params = array(
            array('name' => ':P_PERIODO', 'value' => '2014/1'),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->sp_seculo('BD_PORTAL', 'AES_INADIMPLENCIA_RESUMO', $params);
    }
    
    // LISTAR DE INADIPLENCIA
    function inadiplencia_aluno($ref) {
        $cursor = '';
        $params = array(
            array('name' => ':P_PERIODO', 'value' => '2014/1'),
            array('name' => ':p_MES_REFERENCIA', 'value' => $ref),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->sp_seculo('BD_PORTAL', 'AES_INADIMPLENCIA_ALUNOS', $params);
    }

}