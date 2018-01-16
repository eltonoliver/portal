<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class T_periodos_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
        
    
    function listar() {
        $this->db->order_by('ORDEM', 'DESC');
        $query = $this->db->get('BD_SICA.T_PERIODOS')->result_array();
        return $query;
    }
    

}
