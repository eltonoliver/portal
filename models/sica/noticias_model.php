<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Noticias_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Consulta uma determinada noticia pelo seu codigo.
     * 
     * @param integer $codigo
     * @return array
     */
    public function consultar($codigo) {
        $this->db->from('BD_SICA.NOTICIAS');
        $this->db->where('ID_NOTICIA', $codigo);
        $query = $this->db->get();
        return $query->row_array();
    }

}
