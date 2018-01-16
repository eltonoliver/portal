<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tipo_Nota_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Retorna o registro do tipo de nota informado por parametro
     * 
     * @param int $codigo Codigo do tipo de nota
     * @return array 
     */
    public function consultar($codigo) {
        $this->db->from('BD_SICA.CL_TIPO_NOTA');
        $this->db->where('CD_TIPO_NOTA', $codigo);
        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * Lista os tipos de notas para lancamento de conteúdo de prova das turmas
     * mista.
     * 
     * @param string $turma
     * @param string $periodo
     * @return array
     */
    public function listaNotasConteudoMista($turma, $periodo) {
        $this->db->distinct();
        $this->db->select("TN.CD_TIPO_NOTA, TN.DC_TIPO_NOTA, TN.NM_MINI, EN.BIMESTRE, EN.NUM_NOTA");
        $this->db->from("BD_SICA.CL_TIPO_NOTA TN");

        $this->db->join("BD_SICA.CL_ESTRUT_NOTAS EN", "EN.CD_TIPO_NOTA = TN.CD_TIPO_NOTA");
        $this->db->join("BD_SICA.CL_ESTRUT ES", "EN.CD_ESTRUTURA = ES.CD_ESTRUTURA");
        $this->db->join("BD_PAJELA.PJ_CL_BIMESTRE B", "B.BIMESTRE = EN.BIMESTRE AND B.PERIODO = ES.PERIODO");
        $this->db->join("BD_SICA.CL_ALU_DISC_TURMA_MISTA TM", "TM.PERIODO = ES.PERIODO");
        $this->db->join("BD_SICA.CL_ALU_DISC AD", "AD.CD_ALU_DISC = TM.CD_ALU_DISC AND AD.PERIODO = TM.PERIODO");
        $this->db->join("BD_SICA.CL_TURMA_DETALHES TD", "TD.CD_TURMA = AD.CD_TURMA AND TD.PERIODO = AD.PERIODO");

        $this->db->where("TM.CD_TURMA_MISTA", $turma);
        $this->db->where("TM.PERIODO", $periodo);
        $this->db->where("EN.CALCULADA = 0");
        $this->db->where("TRUNC(SYSDATE) BETWEEN B.DT_INICIO and B.DT_FIM");

        $this->db->order_by("EN.NUM_NOTA");

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Lista os tipos de nota para lançamento de conteudo de prova de turmas
     * não mistas.
     * 
     * @param string $turma
     * @param string $periodo
     * @return array
     */
    public function listaNotasConteudoNormal($turma, $periodo) {
        $this->db->distinct();
        $this->db->select("EN.CD_ESTRUTURA, EN.NUM_NOTA, EN.CD_TIPO_NOTA, "
                . "EN.BIMESTRE, TN.DC_TIPO_NOTA, TN.NM_MINI");
        $this->db->from("BD_SICA.CL_TIPO_NOTA TN");

        $this->db->join("BD_SICA.CL_ESTRUT_NOTAS EN", "EN.CD_TIPO_NOTA = TN.CD_TIPO_NOTA");
        $this->db->join("BD_SICA.CL_ESTRUT ES", "EN.CD_ESTRUTURA = ES.CD_ESTRUTURA");
        $this->db->join("BD_PAJELA.PJ_CL_BIMESTRE B", "B.BIMESTRE = EN.BIMESTRE AND B.PERIODO = ES.PERIODO");
        $this->db->join("BD_SICA.CL_TURMA_DETALHES TD", "TD.PERIODO = ES.PERIODO AND TD.CD_ESTRUTURA = ES.CD_ESTRUTURA");

        $this->db->where("TD.CD_TURMA", $turma);
        $this->db->where("ES.PERIODO", $periodo);
        $this->db->where("EN.CALCULADA = 0");
        $this->db->where("TRUNC(SYSDATE) BETWEEN B.DT_INICIO AND B.DT_FIM");

        $this->db->order_by("EN.NUM_NOTA");

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Lista todas as notas para lançamento.
     * 
     * @param string $turma
     * @param string $periodo
     * @param boolean $mista TRUE quando a turma for mista. FALSE turma normal.
     * @return array 
     */
    public function listaNotasLancamento($turma, $periodo, $mista = false) {
        $this->db->distinct();
        $this->db->select("TN.CD_TIPO_NOTA, TN.DC_TIPO_NOTA, TN.NM_MINI, EN.BIMESTRE, EN.NUM_NOTA");
        $this->db->from("BD_SICA.CL_TIPO_NOTA TN");

        $this->db->join("BD_SICA.CL_ESTRUT_NOTAS EN", "EN.CD_TIPO_NOTA = TN.CD_TIPO_NOTA");
        $this->db->join("BD_SICA.CL_ESTRUT ES", "EN.CD_ESTRUTURA = ES.CD_ESTRUTURA");
        $this->db->join("BD_PAJELA.PJ_CL_BIMESTRE B", "B.BIMESTRE = EN.BIMESTRE AND B.PERIODO = ES.PERIODO");

        /**
         * caso turma mista obtem os detalhes das turmas que a compoem para 
         * obter a estrutura. A estrutura das turmas são iguais;
         */
        if ($mista) {
            $this->db->join("BD_SICA.CL_ALU_DISC_TURMA_MISTA TM", "TM.PERIODO = ES.PERIODO");
            $this->db->join("BD_SICA.CL_ALU_DISC AD", "AD.CD_ALU_DISC = TM.CD_ALU_DISC AND AD.PERIODO = TM.PERIODO");
            $this->db->join("BD_SICA.CL_TURMA_DETALHES TD", "TD.CD_TURMA = AD.CD_TURMA AND TD.PERIODO = AD.PERIODO");
            $this->db->where("TM.CD_TURMA_MISTA", $turma);
        } else {
            $this->db->join("BD_SICA.CL_TURMA_DETALHES TD", "TD.PERIODO = ES.PERIODO AND TD.CD_ESTRUTURA = ES.CD_ESTRUTURA");
            $this->db->where("TD.CD_TURMA", $turma);
        }

        $this->db->where("ES.PERIODO", $periodo);
        $this->db->where("EN.CALCULADA = 0");
        $this->db->where("TRUNC(SYSDATE) BETWEEN B.DT_INICIO_LAN_NOTAS and B.DT_FIM_LAN_NOTAS");

        $this->db->order_by("EN.NUM_NOTA");

        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * Lista uma relação de notas de uma disciplina de todos os bimestres que 
     * o aluno cursou.
     * 
     * @param int $aluno
     * @param int $disciplina
     * @param int $tipoNota
     */
    public function listaNotasComparativa($aluno, $disciplina) {
        $this->db->distinct();
        $this->db->select("EN.BIMESTRE, N.NOTA, TN.NM_MINI");
        $this->db->from("BD_SICA.CL_TIPO_NOTA TN");
        $this->db->join("BD_SICA.CL_ESTRUT_NOTAS EN", "EN.CD_TIPO_NOTA = TN.CD_TIPO_NOTA");
        $this->db->join("BD_SICA.CL_TURMA_DETALHES DET", "DET.CD_ESTRUTURA = EN.CD_ESTRUTURA");
        $this->db->join("BD_SICA.TURMA TUR", "TUR.PERIODO = DET.PERIODO "
                . "AND TUR.CD_TURMA = DET.CD_TURMA");
        $this->db->join("BD_SICA.CL_ALU_DISC AD", "AD.PERIODO = DET.PERIODO "
                . "AND AD.CD_TURMA = DET.CD_TURMA");
        $this->db->join("BD_SICA.ALUNO AL", "AD.CD_ALUNO = AL.CD_ALUNO "
                . "AND AL.STATUS IN (1, 2, 4) "
                . "AND AL.TIPO = 'C'");
        $this->db->join("BD_SICA.CL_DISCIPLINA D", "D.CD_DISCIPLINA=AD.CD_DISCIPLINA");
        $this->db->join("BD_SICA.CL_ALU_NOTA N", "N.CD_ALU_DISC = AD.CD_ALU_DISC "
                . "AND N.NUM_NOTA = EN.NUM_NOTA");
//        $this->db->join("BD_SICA.CL_GRADE_DISCIPLINAS GD", "GD.CD_CURSO = TUR.CD_CURSO "
//                . "AND GD.ORDEM_SERIE = TUR.CD_SERIE "
//                . "AND GD.CURRICULO = DET.CURRICULO "
//                . "AND GD.CD_DISCIPLINA = AD.CD_DISCIPLINA");

        $this->db->where("DET.PERIODO = (SELECT CL_PERIODO_ATUAL FROM BD_SICA.CONFIGURACAO)");
        $this->db->where("EN.INTERNET = 'S'");
        $this->db->where("N.NUM_NOTA IN (1, 9, 17, 23, 3, 11, 19, 25)");
        $this->db->where("AL.CD_ALUNO", $aluno);
        $this->db->where("AD.CD_DISCIPLINA", $disciplina);
        $this->db->order_by("EN.BIMESTRE");

        $query = $this->db->get();
        return $query->result_array();
    }

}
