<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Controle_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function weblog($p) {
        
        $sessao = $this->session->userdata;
        $params = array(
                  array('name' => ':P_OPERACAO',   'value' => 'L'                       ),
                  array('name' => ':P_CD_USUARIO', 'value' => $this->session->userdata('SCL_SSS_USU_CODIGO') ),
                  array('name' => ':P_PROGRAMA',   'value' => $p['programa']            ),
                  array('name' => ':P_IP',         'value' => $sessao['ip_address']     ),
                  array('name' => ':P_DISPOSITIVO','value' => $sessao['user_agent']     ),
                  array('name' => ':P_SISTEMA',    'value' => NULL           ),
                  array('name' => ':P_CURSOR',     'value' => $p, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_PORTAL','AES_WEBLOG',$params);
    }

}

