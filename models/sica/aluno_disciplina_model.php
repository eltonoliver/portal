<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aluno_Disciplina_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Lista todos os alunos da turma e disciplina. Os alunos serão retornados
     * caso a turma seja regular ou mista.
     * 
     * @param string $turma
     * @param int $disciplina
     * @param string $periodo
     */
    public function listaAlunos($turma, $disciplina, $periodo) {
        $mista = false;
        if (strpos($turma, "+") !== FALSE) {
            $mista = true;
        }

        $this->db->select("AL.CD_ALUNO, AL.NM_ALUNO");
        $this->db->from("BD_SICA.ALUNO AL");
        $this->db->join("BD_SICA.CL_ALU_DISC AD", "AD.CD_ALUNO = AL.CD_ALUNO");

        $this->db->where_in("AL.STATUS", array(1, 2));
        $this->db->where("AD.PERIODO", $periodo);

        if ($mista) {
            $this->db->join("BD_SICA.CL_ALU_DISC_TURMA_MISTA TM", "AD.PERIODO = TM.PERIODO "
                    . "AND AD.CD_ALU_DISC = TM.CD_ALU_DISC"
            );

            $this->db->where("TM.CD_TURMA_MISTA", $turma);
            $this->db->where("TM.CD_DISCIPLINA", $disciplina);
        } else {
            $this->db->where("AD.CD_TURMA", $turma);
            $this->db->where("AD.CD_DISCIPLINA", $disciplina);
        }

        $this->db->order_by("AL.NM_ALUNO");

        $query = $this->db->get();
        return $query->result_array();
    }

    public function listaAlunosTurma($turma, $periodo) {
        
        $this->db->distinct();
        $this->db->select("AL.CD_ALUNO, AL.NM_ALUNO");
        $this->db->from("BD_SICA.ALUNO AL");
        $this->db->join("BD_SICA.CL_ALU_DISC AD", "AD.CD_ALUNO = AL.CD_ALUNO");

        $this->db->where_in("AL.STATUS", array(1, 2));
        $this->db->where("AD.PERIODO", $periodo);

        $this->db->where("AD.CD_TURMA", $turma);
        
        $this->db->order_by("AL.NM_ALUNO");

        $query = $this->db->get();
        return $query->result_array();
    }    
    
}
