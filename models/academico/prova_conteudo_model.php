<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_Conteudo_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Lista todas as provas agendadas para uma determinada turma, bimestre,
     * periodo e disciplina;
     * 
     * @param array $params Array na seguinte estrutura:
     * array(
     *  'CD_TURMA' => value,
     *  'CD_DISCIPLINA' => value,
     *  'PERIODO' => value
     * )
     * @return array 
     */
    public function listaProvasDisciplina($params) {
        $this->db->from('BD_ACADEMICO.AES_PROVA_CONTEUDO PC');
        $this->db->join("BD_SICA.CL_TIPO_NOTA TN", "TN.CD_TIPO_NOTA = PC.CD_TIPO_NOTA");
        $this->db->where($params);
        $this->db->order_by('BIMESTRE, DT_PROVA');
        $query = $this->db->get();
        return $query->result_array();
    }

}
