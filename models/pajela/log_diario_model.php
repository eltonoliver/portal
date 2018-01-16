<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log_Diario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Registra o horário da tentativa de abrir e fechar aula
     * 
     * @param int $aula
     * @param string $hostName
     * @param string $ip
     * @param string $operacao
     */
    public function registrar($aula, $hostName, $ip, $operacao) {
        $params = array(
            "CD_CL_AULA" => $aula,
            "FLG_EVENTO" => $operacao,
            "HOST_NAME" => $hostName,
            "IP" => $ip
        );

        return $this->db->insert("BD_PAJELA.PJ_CL_AULA_LOG_TENTATIVA", $params);
    }

}
