<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Matricula_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Lista as disciplinas do aluno de um determinado período.
     * 
     * @param string $matricula
     * @param string $periodo
     * @return array
     */
    public function listaDisciplinas($matricula, $periodo) {
        $this->db->distinct();
        $this->db->select("MAT.CD_TURMA,
           MAT.TIPO,
           NM_PROFESSOR,
           DIS.CD_DISCIPLINA,
           NM_DISCIPLINA,
           NM_MINI,
           NM_DISC_RED"
        );
        $this->db->from("BD_SICA.MATRICULA MAT");
        $this->db->join("BD_SICA.CL_ALU_DISC AD", "MAT.CD_ALUNO = AD.CD_ALUNO "
                . "AND MAT.PERIODO = AD.PERIODO "
                . "AND MAT.CD_TURMA = AD.CD_TURMA"
        );
        $this->db->join("BD_SICA.CL_TURMA_PROFESSORES TPR", "MAT.CD_TURMA = TPR.CD_TURMA "
                . "AND TPR.PERIODO = MAT.PERIODO"
        );
        $this->db->join("BD_RH.PNT_VW_COL_HORARIO_ATUAL VHA", "VHA.CD_DISCIPLINA = AD.CD_DISCIPLINA "
                . "AND VHA.PERIODO = MAT.PERIODO "
                . "AND VHA.CD_TURMA = MAT.CD_TURMA "
                . "AND VHA.CD_PROFESSOR = TPR.CD_PROFESSOR "
                . "AND (VHA.SUBTURMA = AD.SUBTURMA OR AD.SUBTURMA IS NULL)"
        );
        $this->db->join("BD_SICA.T_PROFESSOR PRF", "PRF.CD_PROFESSOR = TPR.CD_PROFESSOR");
        $this->db->join("BD_SICA.CL_DISCIPLINA DIS", "DIS.CD_DISCIPLINA = TPR.CD_DISCIPLINA");
        $this->db->where("MAT.CD_ALUNO", $matricula);
        $this->db->where("TPR.PERIODO", $periodo);
        $this->db->where("TIPO = 'N' AND COMPOSTO = 0 AND TPR.CD_PROFESSOR <> 32");
        $this->db->order_by("NM_DISCIPLINA, MAT.CD_TURMA ASC");

        $query = $this->db->get();
        return $query->result_array();
    }

}
