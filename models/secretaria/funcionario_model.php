<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Funcionario_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function lProfessor() {

        $query = $this->db->query("SELECT * FROM BD_SICA.T_PROFESSOR ORDER BY NM_PROFESSOR ASC");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function lFuncionario() {

        $query = $this->db->query("SELECT * FROM BD_SICA.VW_FUNCIONARIO");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    function Funcionario($parametro) {

        $cursor = '';
        $params = array(
            array('name' => ':P_CD_FUNCIONARIO', 'value' => $parametro['codigo']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_RH', 'SP_CRACHA_FUNCIONARIO', $params);
    }
    
    function Professor($parametro) {

        $cursor = '';
        $params = array(
            array('name' => ':P_CD_PROFESSOR', 'value' => $parametro['codigo']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_RH', 'SP_CRACHA_PROFESSOR', $params);
    }

}
/*Dia 11/06 nas festa junina do século, só será permitida a entrada no estacionamento com o cartào de transito livre.*/
