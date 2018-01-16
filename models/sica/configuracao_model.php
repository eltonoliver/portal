<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Configuracao_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Obtem os dados de configuração do portal
     * 
     * @return array
     */
    public function parametros() {        
        $this->db->from("BD_SICA.CONFIGURACAO");

        $query = $this->db->get();
        return $query->row_array();
    }

}
