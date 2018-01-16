<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Colegio_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function aes_colegio($dado){
        $cursor = '';
        $params = array(
                  array('name'=>':P_OPERACAO', 'value'=>$dado['operacao']),
                  array('name'=>':P_PERIODO', 'value'=>$dado['periodo']),
                  array('name'=>':P_CD_TURMA', 'value'=>$dado['turma']),
                  array('name'=>':P_CD_PROFESSOR', 'value'=>$dado['professor']),
                  array('name'=>':P_BIMESTRE', 'value'=>$dado['bimestre']),
                  array('name'=>':P_CD_ESTRUTURA', 'value'=>$dado['estrutura']),
                  array('name'=>':P_CD_CURSO', 'value'=>$dado['curso']),
                  array('name'=>':P_CURSOR', 'value'=>$cursor, 'type'=>OCI_B_CURSOR)
                  );
        return $this->db->procedure('BD_PORTAL','AES_COLEGIO',$params);
    }

}
