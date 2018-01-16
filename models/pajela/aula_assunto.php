<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aula_Assunto_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Adicionar o conteúdo do livro para uma determianda aula.
     * 
     * @param int $aula
     * @param int $assunto
     * @return array
     */
    public function adicionar($aula, $assunto) {
        $params = array(
            'CD_CL_AULA' => $aula,
            'CD_AULA_ASSUNTO' => $assunto,
        );

        return $this->db->insert("BD_PAJELA.PJ_CL_AULA_ASSUNTO", $params);
    }

}
