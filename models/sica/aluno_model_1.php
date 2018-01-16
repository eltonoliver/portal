<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aluno_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Consulta os dados do aluno conforme a matricula informada.
     * 
     * @param int $matricula
     * @return array
     */
    public function consultar($matricula) {
        $this->db->from("BD_SICA.ALUNO");
        $this->db->where("CD_ALUNO", $matricula);

        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * Retorna as provas realizadas pelo aluno do bimestre corrente.
     * As provas são P1 e P2 de cada disciplina.
     * 
     * @param string $matricula     
     * @param int $bimestre
     * @return array 
     */
    public function listaGabaritosProvas($matricula, $bimestre) {
        $this->db->distinct();
        $this->db->select("QTDE_QUESTOES,
                           NUM_PROVA, BIMESTRE,
                           NM_MINI,
                           DISCIPLINAS,
                           GABARITO,
                           RESPOSTAS,
                           T_OBJETIVO,
                           BD_ACADEMICO.AVAL_PROVA_MAIOR_NOTA(CD_PROVA_ORIGINAL) MAIOR_NOTA,
                           BD_ACADEMICO.AVAL_PROVA_MENOR_NOTA(CD_PROVA_ORIGINAL) MENOR_NOTA
                           "
        );
        $this->db->from("BD_ACADEMICO.VW_ALUNO_PROVAS_TODOS");
        $this->db->where("CD_ALUNO", $matricula);
        $this->db->where("BIMESTRE", $bimestre);
        $this->db->where_in("NM_MINI", array("P1", "P2"));
        $this->db->order_by("DISCIPLINAS, NM_MINI");

        $query = $this->db->get();
        //echo $this->db->last_query();
        return $query->result_array();
    }

    /**
     * Lista todas as ocorrencias registradas para o aluno.
     * 
     * @param int $matricula     
     * @return array
     */
    public function listaOcorrencias($matricula) {
        $this->db->select("OCO.TEXTO_OCORRENCIA AS DC_OCORRENCIA, OCO.DT_OCORRENCIA");
        $this->db->from("BD_SICA.CL_OCORRENCIAS_DISCIPLINARES OCO");
        $this->db->join("BD_SICA.ALUNO ALU", "OCO.CD_ALUNO = ALU.CD_ALUNO");
        $this->db->join("BD_SICA.USUARIOS USU", "OCO.CD_USUARIO_CADASTRAMENTO = USU.CD_USUARIO");
        $this->db->where("ALU.CD_ALUNO", $matricula);
        $this->db->order_by("OCO.DT_OCORRENCIA DESC");
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Lista todos os gabaritos das provas online (via sistema) realizadas pelo 
     * aluno.
     * 
     * @param int $matricula 
     * @param int $bimestre
     * @return array 
     */
    public function listaGabaritosProvasOnline($matricula, $bimestre) {
        $this->db->select("AP.CD_PROVA,
                AP.NUM_PROVA,
                AP.TITULO,
                AP.BIMESTRE,
                AP.CHAMADA,
                AP.CD_TIPO_NOTA,
                TP.DC_TIPO_NOTA,
                TP.NM_MINI,    
                (BD_SICA.F_AVAL_PROVA_DISCIPLINAS(AP.CD_PROVA)) AS DISCIPLINAS,
                APAQ.POSICAO,
                APAQ.CORRETA,
                APAQ.RESPOSTA,
                APAQ.NR_TEMPO_RESPOSTA", false
        );
        $this->db->from("BD_SICA.AVAL_PROVA AP");
        $this->db->join("BD_SICA.CL_TIPO_NOTA TP", "TP.CD_TIPO_NOTA = AP.CD_TIPO_NOTA");
        $this->db->join("BD_SICA.AVAL_PROVA_INSCRITOS API", "AP.CD_PROVA = API.CD_PROVA_VERSAO");
        $this->db->join("BD_SICA.AVAL_PROVA_ALUNO_QUESTAO APAQ", "APAQ.CD_PROVA = API.CD_PROVA_VERSAO "
                . "AND APAQ.CD_ALUNO = API.CD_ALUNO"
        );
        $this->db->where("AP.PERIODO = (SELECT CL_PERIODO_ATUAL FROM BD_SICA.CONFIGURACAO)");
        $this->db->where_in("TP.NM_MINI", array("P1", "P2"));
        $this->db->where_in("AP.CHAMADA", array(1, 2));
        $this->db->where("AP.FLG_WEB", 1);
        $this->db->where("API.FEZ_PROVA", 1);
        $this->db->where("API.CD_ALUNO", $matricula);
        $this->db->where("BIMESTRE", $bimestre);
        $this->db->order_by("AP.CD_PROVA, AP.TITULO, APAQ.POSICAO");
        
        $query = $this->db->get();        
        return $query->result_array();
    }

}
