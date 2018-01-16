<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ocorrencias_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function sp_ocorrencias($dado){ //print_r($dado);//exit;
        $cursor = '';
        $params = array(
                array('name'=>':P_OPERACAO',            'value'=>$dado['operacao']),
                array('name'=>':P_CD_OCORRENCIA',       'value'=>$dado['cd_ocorrencia']),
                array('name'=>':P_CD_ALUNO',            'value'=>$dado['cd_aluno']),
                array('name'=>':P_DATA',                'value'=>$dado['data']),
                array('name'=>':P_TIPO',                'value'=>$dado['tipo']),
                array('name'=>':P_ARQUIVO',             'value'=>$dado['arquivo']),                
                array('name'=>':P_NOME',                'value'=>$dado['nome']), 
                array('name'=>':P_DESCRICAO',           'value'=>$dado['descricao']), 
                array('name'=>':P_CD_PARENTESCO',       'value'=>$dado['cd_parentesco']), 
                array('name'=>':P_ASSUNTO',             'value'=>$dado['assunto']),
                array('name'=>':CD_USUARIO',            'value'=>$this->session->userdata('SCL_SSS_USU_CODIGO')),
                array('name'=>':P_CURSOR',              'value'=>$cursor,'type'=>OCI_B_CURSOR)
                );
//print_r($params);exit;
        return $this->db->sp_seculo('BD_SICA','SP_OCORRENCIAS',$params);		
	    
    }
    
}