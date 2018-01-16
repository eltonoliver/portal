<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plano_Ensino_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Adiciona o registro de Plano de Ensino.
     * 
     * @return boolean Description
     */
    public function adicionar($params) {
        return $this->db->insert("BD_SICA.CL_PLANO_ENSINO", $params);
    }

}
