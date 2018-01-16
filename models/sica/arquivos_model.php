<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Arquivos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Lista todo os arquivos de apoio da turma e disciplina do ano corrente.
     * 
     * @param string $turma
     * @param int $discipina     
     * @return array
     */
    public function listar($turma, $discipina) {
        $this->db->from("BD_SICA.ARQUIVOSP ASP");
        $this->db->join("BD_SICA.T_PROFESSOR PRF", "PRF.CD_PROFESSOR = ASP.CD_PROFESSOR");
        $this->db->where("CD_DISCIPLINA", $discipina);
        $this->db->where("CD_TURMA", $turma);
        $this->db->where("EXTRACT(YEAR FROM DATA) = EXTRACT(YEAR FROM SYSDATE)");
        $this->db->order_by("DATA DESC");

        $query = $this->db->get();
        return $query->result_array();
    }

}
