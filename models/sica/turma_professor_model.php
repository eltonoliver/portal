<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Turma_Professor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Lista todas as disciplinas e turmas regulares de um determinado professor.
     * 
     * @return array
     */
    public function listar($periodo, $professor) {

        $this->db->select("TP.CD_TURMA, TP.PERIODO, TP.CD_DISCIPLINA, TU.TIPO");
        $this->db->from("BD_SICA.CL_TURMA_PROFESSORES TP");
        $this->db->join("BD_SICA.TURMA TU", "TU.PERIODO = TP.PERIODO AND TP.CD_TURMA = TU.CD_TURMA");
        $this->db->where("TP.PERIODO", $periodo);
        $this->db->where("TP.CD_PROFESSOR", $professor);
        $this->db->where_in("TU.TIPO", array('N', '+','P','X'));

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Lista todas as turmas do professor no periodo informado que são de 
     * disciplinas regulares.
     * 
     * @param int $professor
     * @param string $periodo
     * @return array 
     */
    public function listaTurmasRegular($professor, $periodo) {
        $this->db->distinct();
        $this->db->select("TUR.CD_TURMA");
        $this->db->from("BD_SICA.CL_TURMA_PROFESSORES PRF");
        $this->db->join("BD_SICA.TURMA TUR", "TUR.CD_TURMA = PRF.CD_TURMA "
                . "AND TUR.PERIODO = PRF.PERIODO"
        );
        $this->db->join("BD_SICA.CURSOS CUR", "CUR.CD_CURSO = TUR.CD_CURSO");
        $this->db->where("PRF.CD_PROFESSOR", $professor);
        $this->db->where("TUR.PERIODO", $periodo);
        $this->db->where_in("TUR.TIPO", array("N", "+"));
        $this->db->order_by("TUR.CD_TURMA");

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Lista todas as disciplinas regulares que o professor ministra em uma 
     * determinada turma informada por parametro.
     * 
     * @param int $professor
     * @param string $turma
     * @param string $periodo
     */
    public function listaDisciplinasRegular($professor, $turma, $periodo) {
        $this->db->distinct();
        $this->db->select("PRF.CD_DISCIPLINA, DIS.NM_DISCIPLINA");
        $this->db->from("BD_SICA.CL_TURMA_PROFESSORES PRF");
        $this->db->join("BD_SICA.CL_DISCIPLINA DIS", "PRF.CD_DISCIPLINA = DIS.CD_DISCIPLINA");
        $this->db->join("BD_SICA.TURMA TUR", "TUR.CD_TURMA = PRF.CD_TURMA AND TUR.PERIODO = PRF.PERIODO");
        $this->db->join("BD_SICA.CURSOS CUR", "CUR.CD_CURSO = TUR.CD_CURSO");
        $this->db->where("PRF.CD_PROFESSOR", $professor);
        $this->db->where("TUR.PERIODO", $periodo);
        $this->db->where("PRF.CD_TURMA", $turma);
        $this->db->where_in("TUR.TIPO", array("N", "+"));
        $this->db->where("COMPOSTO = 0");
        $this->db->order_by("DIS.NM_DISCIPLINA");

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Lista todas as turmas do professor com disciplina regular.
     * 
     * @param int $professor
     * @param string $periodo     
     * @return array
     */
    public function listaTurmaDisciplinaRegular($professor, $periodo) {
        $this->db->distinct();
        $this->db->select("PRF.PERIODO, 
            PRF.CD_TURMA, 
            PRF.CD_DISCIPLINA, 
            PRF.CD_PROFESSOR, 
            DIS.NM_DISCIPLINA, 
            TUR.CD_TURMA, 
            TUR.CD_CURSO, 
            TUR.TURNO, 
            TUR.CD_SERIE,
            CUR.NM_CURSO"
        );
        $this->db->from("BD_SICA.CL_TURMA_PROFESSORES PRF");
        $this->db->join("BD_SICA.CL_DISCIPLINA DIS", "PRF.CD_DISCIPLINA = DIS.CD_DISCIPLINA");
        $this->db->join("BD_SICA.TURMA TUR", "TUR.CD_TURMA = PRF.CD_TURMA AND TUR.PERIODO = PRF.PERIODO");
        $this->db->join("BD_SICA.CURSOS CUR", "CUR.CD_CURSO = TUR.CD_CURSO");
        $this->db->where("PRF.CD_PROFESSOR", $professor);
        $this->db->where("TUR.PERIODO", $periodo);
        $this->db->where_in("TUR.TIPO", array("N", "+"));
        $this->db->where("COMPOSTO = 0");
        $this->db->order_by("DIS.NM_DISCIPLINA, TUR.CD_TURMA");

        $query = $this->db->get();
        return $query->result_array();
    }

    //Lista as turmas(combos) no modulo de Registros diarios - area do Professor  By:Mônica
    public function listaTurmasRegularDoDia($professor, $periodo) {
        $this->db->select("PJ.CD_TURMA, PJ.CD_PROFESSOR, PJ.DT_AULA, PJ.HR_TEMPO_INICIO, PJ.HR_TEMPO_FIM");
        $this->db->from("BD_PAJELA.PJ_CL_AULA PJ");
        $this->db->join("BD_SICA.TURMA TUR", "TUR.CD_TURMA = PJ.CD_TURMA");
        $this->db->where("PJ.CD_PROFESSOR", $professor);
        $this->db->where_in("TUR.TIPO", array("N", "X", "+"));
        $this->db->where("PJ.DT_AULA", date('d-M-Y'));
        //$this->db->where("PJ.HR_TEMPO_INICIO <= '" . date('H:i:s') . "' AND PJ.HR_TEMPO_FIM >= '" . date('H:i:s') . "'");
        $this->db->group_by("PJ.CD_TURMA, PJ.CD_PROFESSOR, PJ.DT_AULA, PJ.HR_TEMPO_INICIO, PJ.HR_TEMPO_FIM");
        $this->db->order_by("PJ.CD_TURMA");

        $query = $this->db->get();
        return $query->result_array();
    }

}
