<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registro_Pedagogico_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Lista todos os registros de ocorrências de um aluno em um determinado 
     * periodo.
     * 
     * @param string $aluno
     * @param string $periodo
     * @return array
     */
    public function listaRegistros($aluno, $periodo) {
        $this->db->from("BD_ACADEMICO.VW_ORIENTACAO_REGISTRO");
        $this->db->where("CD_ALUNO", $aluno);
        $this->db->where("PERIODO", $periodo);
        $this->db->where("OPCAO_REGISTRO", 1);
        $this->db->order_by("DT_REGISTRO DESC");

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Lista todos os registros de advertência de um aluno em um determinado 
     * periodo.
     * 
     * @param string $aluno
     * @param string $periodo
     * @return array
     */
    public function listaAdvertencias($aluno, $periodo) {
        $this->db->from("BD_SICA.VW_ALUNO_ADVERTENCIA");
        $this->db->where("CD_ALUNO", $aluno);
        $this->db->where("PERIODO", $periodo);
        $this->db->order_by("DT_ADVERTENCIA DESC");

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Lista todos os registros de suspensão de um aluno em um determinado 
     * periodo.
     * 
     * @param string $aluno
     * @param string $periodo
     * @return array
     */
    public function listaSuspensoes($aluno, $periodo) {
        $this->db->from("BD_SICA.VW_ALUNO_SUSPENSAO");
        $this->db->where("CD_ALUNO", $aluno);
        $this->db->where("PERIODO", $periodo);
        $this->db->order_by("DT_INICIO DESC");

        $query = $this->db->get();
        return $query->result_array();
    }

}
