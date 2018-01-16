<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bimestre_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Obtem o número do bimestre corrente.
     * 
     * @return int
     */
    public function getBimestreCorrente() {
        $this->db->select("BIMESTRE");
        $this->db->from("BD_PAJELA.PJ_CL_BIMESTRE");
        $this->db->where("TRUNC(SYSDATE) BETWEEN DT_INICIO AND DT_FIM");

        $query = $this->db->get();
        $row = $query->row();        
        
        return isset($row->BIMESTRE) ? $row->BIMESTRE : null;
    }

}
