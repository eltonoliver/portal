<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aes_prova_questao_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function gabarito($p) {
        $this->db->where('CD_PROVA', $p);
        $query = $this->db->get('BD_ACADEMICO.VW_PROVA_GABARITO')->result_array();
        return $query;
    }
    
    function listar($p) {        
        $query = $this->db->get('BD_SICA.AVAL_PROVA_QUESTOES');
        return $query;
    }
    
    function adicionar($p) { 
        $data = array(
            'CD_PERGUNTA' => $p['pergunta'] ,
            'CD_QUEST'    => $p['questionario'] ,
            'CD_RESPOSTA' => $p['resposta'],
            'CD_ALUNO'    => ''.$p['aluno'].'',
            'PERIODO'     => '2016/1',
            'BIMESTRE'    => $p['bimestre']
        );
        $r = $this->db->insert('BD_SICA.AVAL_PROVA_QUESTOES', $data);
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }
    
    function editar($p) { 
        $data = array(
            'CD_PERGUNTA' => $p['pergunta'] ,
            'CD_QUEST'    => $p['questionario'] ,
            'CD_RESPOSTA' => $p['resposta'],
            'CD_ALUNO'    => ''.$p['aluno'].'',
            'PERIODO'     => '2016/1',
            'BIMESTRE'    => $p['bimestre']
        );
        $this->db->where('CD_QUESTAO', $p['questao']);
        $this->db->where('CD_OPCAO', $p['opcao']);
        $r = $this->db->update('BD_SICA.AVAL_PROVA_QUESTOES', $data); 
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }
    
    
    
    function deletar($p) {
        
        // QUANDO A OS REGISTROS POSSUEM DEPENDENCIA
        // DEVE-SE INFORMA NO ARRAY DE TABELAS
        // PARA QUE SEJAM APAGADAS DO BANCO EM TODAS AS TABELAS        
        $tabela = array('BD_SICA.AVAL_PROVA_QUESTOES');
        // PASSA O CODIGO DO REGISTRO QUE SERÁ APAGADO
        $this->db->where('CD_QUESTAO', $p['questao']);
        $this->db->where('CD_OPCAO', $p['opcao']);
        $this->db->delete($tabela);
        
        /**************** ADICIONAR LOGS *****************/
        $sql = $this->db->last_query();
        $co = new Weblogs_lib();
        $co->sql = $sql;
        $co->url();
        /**************** ADICIONAR LOGS *****************/
    }
    
    function limpa_flags($p) {
        
        $this->db->select('CD_PROVA, CD_PROVA_PAI');
        $this->db->where('CD_PROVA', $p['prova']);
        $row = $this->db->get('BD_SICA.AVAL_PROVA')->row();

        $original = (($row->CD_PROVA_PAI == '')? $row->CD_PROVA : $row->CD_PROVA_PAI);
        
        $this->db->select('CD_PROVA');
        $this->db->or_where('CD_PROVA', $original);
        $this->db->or_where('CD_PROVA_PAI', $original);
        $provas = $this->db->get('BD_SICA.AVAL_PROVA')->result_array();
        
        foreach($provas as $prova){
            $data = array(
                'FLG_ANULADA' => 'N',
              'FLG_CANCELADA' => 'N',
            );
            $this->db->where('CD_QUESTAO', $p['questao']);
            $this->db->where('CD_PROVA', $prova['CD_PROVA']);
            $this->db->update('BD_SICA.AVAL_PROVA_QUESTOES', $data);
            
            /**************** ADICIONAR LOGS *****************/
            $sql = $this->db->last_query();
            $co = new Weblogs_lib();
            $co->sql = $sql;
            $co->url();
            /**************** ADICIONAR LOGS *****************/
        }
    }
    
    function cancelar($p) {
        
        $this->db->select('CD_PROVA, CD_PROVA_PAI');
        $this->db->where('CD_PROVA', $p['prova']);
        $row = $this->db->get('BD_SICA.AVAL_PROVA')->row();

        $original = (($row->CD_PROVA_PAI == '')? $row->CD_PROVA : $row->CD_PROVA_PAI);
        
        $this->db->select('CD_PROVA');
        $this->db->or_where('CD_PROVA', $original);
        $this->db->or_where('CD_PROVA_PAI', $original);
        $provas = $this->db->get('BD_SICA.AVAL_PROVA')->result_array();
        
        foreach($provas as $prova){
            $data = array(
              'FLG_CANCELADA' => 'S',
            );
            $this->db->where('CD_QUESTAO', $p['questao']);
            $this->db->where('CD_PROVA', $prova['CD_PROVA']);
            $this->db->update('BD_SICA.AVAL_PROVA_QUESTOES', $data);
            
            /**************** ADICIONAR LOGS *****************/
            $sql = $this->db->last_query();
            $co = new Weblogs_lib();
            $co->sql = $sql;
            $co->url();
            /**************** ADICIONAR LOGS *****************/
        }
    }
    
    function anular($p) {
       $this->db->select('CD_PROVA, CD_PROVA_PAI');
        $this->db->where('CD_PROVA', $p['prova']);
        $row = $this->db->get('BD_SICA.AVAL_PROVA')->row();

        $original = (($row->CD_PROVA_PAI == '')? $row->CD_PROVA : $row->CD_PROVA_PAI);
        
        $this->db->select('CD_PROVA');
        $this->db->or_where('CD_PROVA', $original);
        $this->db->or_where('CD_PROVA_PAI', $original);
        $provas = $this->db->get('BD_SICA.AVAL_PROVA')->result_array();
        
        foreach($provas as $prova){
            $data = array(
                'FLG_ANULADA' => 'S',
            );
            $this->db->where('CD_QUESTAO', $p['questao']);
            $this->db->where('CD_PROVA', $prova['CD_PROVA']);
            $this->db->update('BD_SICA.AVAL_PROVA_QUESTOES', $data);
            
            /**************** ADICIONAR LOGS *****************/
            $sql = $this->db->last_query();
            $co = new Weblogs_lib();
            $co->sql = $sql;
            $co->url();
            /**************** ADICIONAR LOGS *****************/
        }
    }

}
