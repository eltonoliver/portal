<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Livro_Assunto_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Retorna o conteúdo cadastrado do livro de um determinado curso, serie e 
     * disciplina e se está associado ou não a uma aula.
     * 
     * @param int $curso
     * @param int $serie
     * @param int $disciplina
     * @return array
     */
    public function listar($curso, $serie, $disciplina) {
        $this->db->distinct();
        $this->db->select("LV.ID_LIVRO,
            LV.LIVRO_TITULO,
            LA.ID_LIVRO_ASSUNTO,
            LA.ID_ESTRUTURA,
            LA.DC_ASSUNTO,
            (
                SELECT CA.CD_CL_AULA 
                FROM BD_PAJELA.PJ_CL_AULA_ASSUNTO CA 
                WHERE CA.ID_LIVRO_ASSUNTO = LA.ID_LIVRO_ASSUNTO 
                AND ROWNUM = 1
            ) AS  CD_CL_AULA"
        );
        $this->db->from("BD_PAJELA.LIVRO_ASSUNTO LA");
        $this->db->join("BD_PAJELA.LIVRO LV", "LV.ID_LIVRO = LA.ID_LIVRO");
        $this->db->where("LV.CD_CURSO", $curso);
        $this->db->where("LV.CD_SERIE", $serie);
        $this->db->where("LV.CD_DISCIPLINA", $disciplina);
        $this->db->order_by("LA.ID_ESTRUTURA");

        $query = $this->db->get();
        return $query->result_array();
    }

}
