<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Turma_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Consulta o registro da turma no periodo letivo informado
     * 
     * @param string $turma
     * @param string $periodo
     * 
     * @return array
     */
    public function consultar($turma, $periodo) {
        $this->db->from("BD_SICA.TURMA");
        $this->db->where("CD_TURMA", $turma);
        $this->db->where("PERIODO", $periodo);

        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * Retorna todas as disciplinas associadas a turma informada.
     * 
     * @param string $turma
     * @return array
     */
    public function listaDisciplinas($turma) {
        $this->db->select("DI.CD_DISCIPLINA, DI.NM_DISCIPLINA");
        $this->db->from("BD_SICA.CL_TURMA_DISCIPLINAS TD");
        $this->db->join("BD_SICA.CL_DISCIPLINA DI", "DI.CD_DISCIPLINA = TD.CD_DISCIPLINA");
        $this->db->where("TD.PERIODO = (SELECT CL_PERIODO_ATUAL FROM BD_SICA.CONFIGURACAO)");
        $this->db->where("TD.CD_TURMA", $turma);
        $this->db->order_by("DI.NM_DISCIPLINA");

        $query = $this->db->get();
        return $query->result_array();
    }

}
