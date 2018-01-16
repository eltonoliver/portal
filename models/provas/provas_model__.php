<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Provas_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function sp_provas($dado){ print_r($dado);//exit;
        $cursor = '';
        $params = array(
                array('name'=>':P_OPERACAO',        'value'=>$dado['operacao']),
                array('name'=>':P_CD_GRUPO',        'value'=>$dado['cd_grupo']),
                array('name'=>':P_DC_GRUPO',        'value'=>$dado['dc_grupo']),
                array('name'=>':P_FL_ATIVO',        'value'=>$dado['ativo']),
                array('name'=>':P_CD_USU_CADASTRO', 'value'=>$dado['cd_usuario']),
                array('name'=>':P_CURSOR',          'value'=>$cursor,'type'=>OCI_B_CURSOR)
                );

        return $this->db->sp_seculo('BD_ACADEMICO','AVAL_MANTER_GRUPO',$params);		
	
    
    }
    
    function sp_subgrupo($dado){ print_r($dado);//exit;
        $cursor = '';
        $params = array(
                array('name'=>':P_OPERACAO',        'value'=>$dado['operacao']),
                array('name'=>':P_CD_GRUPO',        'value'=>$dado['cd_grupo']),
                array('name'=>':P_CD_SUBGRUPO',        'value'=>$dado['cd_subgrupo']),
                array('name'=>':P_DC_SUBGRUPO',        'value'=>$dado['subgrupo']),
                array('name'=>':P_CURSOR',          'value'=>$cursor,'type'=>OCI_B_CURSOR)
                );
        return $this->db->sp_seculo('BD_ACADEMICO','AVAL_MANTER_SUBGRUPO',$params);		
    }
    
    function sp_questao($dado){
        $cursor = '';
        $params = array(
                        array('name'=>':P_OPERACAO',            'value'=>$dado['operacao']),
                        array('name'=>':P_CD_QUESTAO',          'value'=>$dado['cd_questao']),
                        array('name'=>':P_FLG_TIPO',            'value'=>$dado['tipo']),
                        array('name'=>':P_DC_QUESTAO',          'value'=>$dado['descricao']),
                        array('name'=>':P_CD_DISCIPLINA',       'value'=>$dado['cd_disciplina']),
                        array('name'=>':P_CD_USU_APROVACAO',    'value'=>$dado['usu_aprova']),
                        array('name'=>':P_CD_USU_CADASTRO',     'value'=>$dado['usu_cadastra']),
                        array('name'=>':P_NR_DIFICULDADE',      'value'=>$dado['dificuldade']),
                        array('name'=>':P_IMG',                 'value'=>$dado['img'],'type'=>OCI_B_BLOB),
                        array('name'=>':P_CURSOR',              'value'=>$cursor,'type'=>OCI_B_CURSOR)
                );
        
        return $this->db->sp_seculo('BD_ACADEMICO','AVAL_MANTER_QUESTAO',$params);		
    }
    
    function cadastrar_grupo($dado){
        $sql = " INSERT INTO BD_ACADEMICO.AVAL_GRUPO(
                DC_GRUPO,
                CD_USU_CADASTRO
      ) VALUES (
                UPPER('".$dado['dc_grupo']."'),
                ".$dado['cd_usuario']."
                )";

    return $this->db->query($sql);

    }
    
    function cadastrar_subgrupo($dado){
        $sql = "INSERT INTO BD_ACADEMICO.AVAL_SUBGRUPO(
                CD_GRUPO,
                DC_SUBGRUPO
        ) VALUES (
                ".$dado['cd_grupo'].",
                UPPER('".$dado['subgrupo']."'))";
        //echo $sql;exit;
        return $this->db->query($sql);
    }
    
    function lista_disciplina(){
        $sql = "SELECT DISTINCT D.CD_DISCIPLINA, D.NM_DISCIPLINA
                FROM BD_SICA.CL_DISCIPLINA D
                INNER JOIN BD_SICA.CL_GRADE_DISCIPLINAS GD
                    ON D.CD_DISCIPLINA = GD.CD_DISCIPLINA
                WHERE D.COMPOSTO = 0
                  AND GD.CD_CURSO <> 19
                ORDER BY D.NM_DISCIPLINA";
        return $this->db->query($sql);
    }
    
    function cadastrar_questao($dados){ //print_r($dados);//exit;
        $sql = "INSERT INTO BD_ACADEMICO.AVAL_QUESTAO(
                FLG_TIPO,
                DC_QUESTAO,
                CD_DISCIPLINA,
                CD_USU_APROVACAO,
                DT_APROVACAO,
                CD_USU_CADASTRO,
                NR_DIFICULDADE
      ) VALUES (
                '".$dados['tipo']."',
                '".$dados['descricao']."',
                ".$dados['cd_disciplina'].",
                ".$dados['cd_usuario'].",
                SYSDATE,
                ".$dados['cd_usuario'].",
                1)";
  //      echo $sql;exit;
        return $this->db->query($sql);
    }
    
    function ultima_questao(){
        $sql = "select MAX(CD_QUESTAO)AS CD from BD_ACADEMICO.AVAL_QUESTAO";
        return $this->db->query($sql);
    }
    
    function cadastrar_item($dados){
        $sql = "INSERT INTO BD_ACADEMICO.AVAL_QUESTAO_OPCAO (CD_QUESTAO,CD_OPCAO,DC_OPCAO,CD_USU_CADASTRO,DT_CADASTRO)
                VALUES(".$dados['cd_questao'].",".$dados['cd_opcao'].",'".$dados['item']."',".$dados['cd_usuario'].",SYSDATE)";
     
         return $this->db->query($sql);
    }
    
function carrega_sub_grupo(){
    $sql = "SELECT * FROM BD_ACADEMICO.AVAL_SUBGRUPO";
    return $this->db->query($sql);
}
    
    
    

}
