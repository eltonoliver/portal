<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Correcao_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    
    
    function visualiza_prova($cd_prova){
        $sql = "SELECT PQ.POSICAO, DBMS_LOB.SUBSTR(Q.DC_QUESTAO,4000,1) DC_QUESTAO, P.TITULO FROM BD_ACADEMICO.AVAl_QUESTAO Q
                    INNER JOIN BD_SICA.AVAL_PROVA_QUESTOES PQ ON PQ.CD_QUESTAO = Q.CD_QUESTAO
                    INNER JOIN BD_SICA.AVAL_PROVA P ON P.CD_PROVA = PQ.CD_PROVA
                  WHERE P.CD_PROVA = ".$cd_prova."
                  ORDER BY PQ.POSICAO";
      //  echo $sql;
        return $this->db->query($sql);
    }
    
    function lista_questoes($cd_prova){
        $sql = "SELECT Q.CD_QUESTAO,DBMS_LOB.SUBSTR(Q.DC_QUESTAO,4000,1)DC_QUESTAO,Q.NR_DIFICULDADE,
                    P.POSICAO,P.VALOR,
                    CASE WHEN Q.FLG_TIPO = 'O' THEN 'OBJETIVA'
                        WHEN Q.FLG_TIPO = 'D' THEN 'DISCURSSIVA'
                    END TIPO, Q.CD_USU_CADASTRO,
                    DBMS_LOB.SUBSTR(Q.DC_RESPOSTAS,4000,1) DC_RESPOSTAS,P.CD_PROVA,AP.TITULO, Q.FLG_RESPOSTA_CORRETA          
               FROM BD_ACADEMICO.AVAL_QUESTAO Q
                 LEFT JOIN BD_SICA.AVAL_PROVA_QUESTOES P ON P.CD_QUESTAO = Q.CD_QUESTAO
                 LEFT JOIN BD_SICA.AVAL_PROVA AP ON AP.CD_PROVA = P.CD_PROVA
         WHERE P.CD_PROVA = ".$cd_prova." ORDER BY P.POSICAO ASC";  

        return $this->db->query($sql);
    }
    
    function dados_prova($cd_prova){
        $sql = "SELECT * FROM BD_SICA.AVAL_PROVA WHERE CD_PROVA = ".$cd_prova;
        return $this->db->query($sql);
    }
    
    function cabecalho($p) { 
        $cursor = '';
        $params = array(
            array('name' => ':p_CD_PROVA', 'value' => $p['prova']), 
            array('name' => ':p_CD_ALUNO', 'value' => $p['aluno']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        $res = $this->db->procedure('BD_SICA', 'SP_AVAL_PROVA_CABECALHO', $params);
        //print_r($params);exit;
        //print_r($res);exit;
        if(count($res) == 0){
           return FALSE;
        }else{
           return($res);
        }
        
    }

    function questoes($p) { 
        $cursor = '';
        $params = array(
            array('name' => ':p_CD_PROVA', 'value' => $p['prova']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        $res = $this->db->procedure('BD_SICA', 'SP_AVAL_PROVA_QUESTOES', $params);
        
        if(count($res) == 0){
           return FALSE;
        }else{
           return($res);
        }
                
    }
    
    function grava_gabarito(){
        $cursor = '';
        $params = array(
            array('name' => ':p_CD_PROVA', 'value' => $p['prova']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        $res = $this->db->procedure('BD_SICA', 'AVAL_ATUALIZA_GABARITO', $params);
        
        if(count($res) == 0){
           return FALSE;
        }else{
           return($res);
        }
    }

}
