<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registro_diario_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
          
    public function registroByID($cd_registro) {
        $this->db->select("AOR.*, AL.NM_ALUNO, M.CD_TURMA");
        $this->db->from("BD_ACADEMICO.AES_ORIENTACAO_REGISTRO AOR");      
        $this->db->join("BD_SICA.ALUNO AL", "AL.CD_ALUNO = AOR.CD_ALUNO");
        $this->db->join("BD_SICA.MATRICULA M", "AL.CD_ALUNO = M.CD_ALUNO AND M.PERIODO = AOR.PERIODO AND M.TIPO ='N'");
        
        $this->db->where("AOR.CD_REGISTRO", $cd_registro);      
        $query = $this->db->get();
        return $query->result_array();
  
    }    
    
    public function listaRegistrosDiarios($periodo, $aluno) {
        $this->db->select("AOR.*, AL.NM_ALUNO,ART.NM_TIPO_REGISTRO");
        $this->db->from("BD_ACADEMICO.AES_ORIENTACAO_REGISTRO AOR");
        
        $this->db->join("BD_SICA.ALUNO AL", "AL.CD_ALUNO = AOR.CD_ALUNO");
        $this->db->join("BD_ACADEMICO.AES_REGISTRO_TIPO ART", "ART.CD_TIPO_REGISTRO = AOR.CD_TIPO_REGISTRO");
        
        $this->db->where("AOR.CD_USUARIO", $this->session->userdata('SCL_SSS_USU_CODIGO'));
        $this->db->where("AOR.CD_ALUNO", $aluno);
        $this->db->where('AOR.FLG_ATIVO', 'S');
       // $this->db->where("AOR.OPCAO_REGISTRO", 1);
        $this->db->where_in("AL.STATUS", array(1, 2));
        $this->db->where("AOR.PERIODO", $periodo);
       
        $this->db->order_by("AOR.DT_REGISTRO");

        $query = $this->db->get();
       
        return $query->result_array();    
    }    
    
    public function cadastrarRegistro($p) {
        $data = array(
             'CD_ALUNO'         => $p['aluno'],
             'PERIODO'          => $p['periodo'],
             'CD_TIPO_REGISTRO' => 7,
             'DT_REGISTRO'      => date('d-M-Y'),
             'OPCAO_REGISTRO'   => 0,// Tipo registro diário
             'STATUS'           => 1,// Não liberado
             'FLG_SMS_AVISO'    => 'N',
             'DS_REGISTRO'      => $p['descricao'],
             'CD_USUARIO'       => $p['professor']
        );
        $res = $this->db->insert('BD_ACADEMICO.AES_ORIENTACAO_REGISTRO', $data); 
        if($res){
            return 'success';
        }else{
            return 'erro';
        }       
    }
    
    public function editarRegistro($p) {

        $data = array(
            'CD_ALUNO'         => $p['aluno'],
            'DS_REGISTRO'      => $p['descricao']
        );
        $this->db->where('CD_REGISTRO',$p['cd_registro']);
        $res = $this->db->update('BD_ACADEMICO.AES_ORIENTACAO_REGISTRO', $data);
        
         if($res){
            return 'success';
        }else{
            return 'erro';
        } 
    }
  
}
