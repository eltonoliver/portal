<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aluno_Nota_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("pajela/bimestre_model", "bimestre", true);
    }

    /**
     * Lista a média do semestre corrente. A média leva em conta as notas
     * P1, P2 e MAIC do primeiro e segundo bimestre de cada semestre.
     * 
     * @param string $turma
     * @param int $disciplina
     * @param string $periodo
     * @return array
     */
    public function listaMediaSemestre($turma, $disciplina, $periodo) {
        $bimestre = $this->bimestre->getBimestreCorrente();

        //definir qual é o primeiro e segundo bimestre do semestre corrente.
        $primeiroBimestre = 0;
        $segundoBimestre = 0;
        if ($bimestre <= 2) {
            $primeiroBimestre = 1;
            $segundoBimestre = 2;
        } else {
            $primeiroBimestre = 3;
            $segundoBimestre = 4;
        }

        //verificar se a turma é mista
        $mista = false;
        if (strpos($turma, "+") !== false) {
            $mista = true;
        }

        $this->db->select("AL.CD_ALUNO,
            AL.NM_ALUNO,        
            TO_CHAR(AVG(NVL(AN.NOTA, 0)), '99.99') MEDIA_SEMESTRE", false
        );
        $this->db->from("BD_SICA.CL_TIPO_NOTA TN");
        $this->db->join("BD_SICA.CL_ESTRUT_NOTAS EN", "EN.CD_TIPO_NOTA = TN.CD_TIPO_NOTA");
        $this->db->join("BD_SICA.CL_TURMA_DETALHES DET", "DET.CD_ESTRUTURA = EN.CD_ESTRUTURA");
        $this->db->join("BD_SICA.TURMA TUR", "TUR.PERIODO = DET.PERIODO "
                . "AND TUR.CD_TURMA = DET.CD_TURMA"
        );
        $this->db->join("BD_SICA.CL_ALU_DISC AD", "AD.PERIODO = DET.PERIODO "
                . "AND AD.CD_TURMA = DET.CD_TURMA"
        );

        //obter alunos da turma caso a turma informada seja mista.
        if ($mista) {
            $this->db->join("BD_SICA.CL_ALU_DISC_TURMA_MISTA TM", "TM.CD_ALU_DISC = AD.CD_ALU_DISC");
        }

        $this->db->join("BD_SICA.ALUNO AL", "AD.CD_ALUNO = AL.CD_ALUNO "
                . "AND AL.STATUS IN (1, 2) "
                . "AND AL.TIPO = 'C'"
        );
        $this->db->join("BD_SICA.CL_ALU_NOTA AN", "AN.CD_ALU_DISC = AD.CD_ALU_DISC "
                . "AND AN.NUM_NOTA = EN.NUM_NOTA", "LEFT"
        );
        $this->db->where("AD.PERIODO", $periodo);

        //filtrar apenas a turma informada
        if ($mista) {
            $this->db->where("TM.CD_TURMA_MISTA", $turma);
            $this->db->where("TM.CD_DISCIPLINA", $disciplina);
        } else {
            $this->db->where("AD.CD_TURMA", $turma);
            $this->db->where("AD.CD_DISCIPLINA", $disciplina);
        }

        $this->db->where_in("TN.NM_MINI", array("P1", "P2", "MAIC"));
        $this->db->where_in("EN.BIMESTRE", array($primeiroBimestre, $segundoBimestre));
        $this->db->group_by(array("AL.CD_ALUNO", "AL.NM_ALUNO"));
        $this->db->order_by("AL.NM_ALUNO");

        $query = $this->db->get();
        return $query->result_array();
    }

}
