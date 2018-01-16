<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_professor_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->table = "BD_SICA.AVAL_PROVA";
        $this->view = "BD_ACADEMICO.VW_AVAL_PROVA";
    }

}
