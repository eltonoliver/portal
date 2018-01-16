<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registro_Diario_model extends CI_Model {

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
        $this->db->select("R.*, U.NM_USUARIO AS PROFESSOR");
        $this->db->from("BD_ACADEMICO.VW_ORIENTACAO_REGISTRO R");
        $this->db->where("R.CD_ALUNO", $aluno);
        $this->db->where("R.PERIODO", $periodo);
        $this->db->where("R.OPCAO_REGISTRO", 0);
        $this->db->where("R.STATUS", 0);
        $this->db->where('R.FLG_ATIVO', 'S');
        $this->db->join('BD_SICA.USUARIOS U', 'R.CD_USUARIO = U.CD_USUARIO');
        $this->db->order_by("R.DT_REGISTRO DESC");

        $query = $this->db->get();
        return $query->result_array();
    }
}
