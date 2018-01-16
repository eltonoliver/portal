<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Aulas_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function sp_slide($parametro) { #print_r($parametro);
        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':CD_SLIDE', 'value' => $parametro['cd_slide']),
            array('name' => ':CD_DISCIPLINA', 'value' => $parametro['cd_disciplina']),
            array('name' => ':CD_PROFESSOR', 'value' => $parametro['cd_professor']),
            array('name' => ':TITULO', 'value' => $parametro['titulo']),
            array('name' => ':CONTEUDO', 'value' => $parametro['texto']),
            array('name' => ':PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':CD_USUARIO', 'value' => $parametro['cd_usuario']),
            array('name' => ':CD_CURSO', 'value' => $parametro['cd_curso']),
            array('name' => ':CD_SERIE', 'value' => $parametro['cd_serie']),
            array('name' => ':CD_CONTEUDO', 'value' => $parametro['cd_conteudo']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_SLIDE', $params);
    }
    
    function lista_disciplina($parametro) { #print_r($parametro);
        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':CD_SLIDE', 'value' => NULL),
            array('name' => ':CD_DISCIPLINA', 'value' => NULL),
            array('name' => ':CD_PROFESSOR', 'value' => $parametro['cd_professor']),
            array('name' => ':TITULO', 'value' => NULL),
            array('name' => ':CONTEUDO', 'value' => NULL),
            array('name' => ':PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':CD_USUARIO', 'value' => NULL),
            array('name' => ':CD_CURSO', 'value' => NULL),
            array('name' => ':CD_SERIE', 'value' => NULL),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_SLIDE', $params);
    }
    
    function inserir_slide($parametro){
        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':CD_SLIDE', 'value' => NULL),
            array('name' => ':CD_DISCIPLINA', 'value' => $parametro['cd_disciplina']),
            array('name' => ':CD_PROFESSOR', 'value' => $parametro['cd_professor']),
            array('name' => ':TITULO', 'value' => $parametro['titulo']),
            array('name' => ':CONTEUDO', 'value' => $parametro['texto']),
            array('name' => ':PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':CD_USUARIO', 'value' => NULL),
            array('name' => ':CD_CURSO', 'value' => NULL),
            array('name' => ':CD_SERIE', 'value' => NULL),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_SLIDE', $params);
    }
    
    function get_disciplina($id){  echo $id;
        $this->db->where('CD_DISCIPLINA',$id);
        return $this->db->get('BD_SICA.CL_DISCIPLINA');
    }
    
    function lista_slide_cadastrado($parametro){ 
        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':CD_SLIDE', 'value' => NULL),
            array('name' => ':CD_DISCIPLINA', 'value' => $parametro['cd_disciplina']),
            array('name' => ':CD_PROFESSOR', 'value' => $parametro['cd_professor']),
            array('name' => ':TITULO', 'value' => NULL),
            array('name' => ':CONTEUDO', 'value' => NULL),
            array('name' => ':PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':CD_USUARIO', 'value' => NULL),
            array('name' => ':CD_CURSO', 'value' => NULL),
            array('name' => ':CD_SERIE', 'value' => NULL),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_SLIDE', $params);
    }
    
    function sp_curso_serie_turma_aluno($dado){
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
            $cursor = '';

            $params = array(
                    array('name'=>':P_OPERACAO', 'value'=>$dado['operacao']),
                    array('name'=>':P_CD_ALUNO', 'value'=>$dado['aluno']),
                    array('name'=>':P_CD_CURSO', 'value'=>$dado['curso']),
                    array('name'=>':P_ORDEM_SERIE', 'value'=>$dado['serie']),
                    array('name'=>':P_CD_TURMA', 'value'=>$dado['turma']),
                    array('name'=>':P_PERIODO', 'value'=>$periodo),
                    array('name'=>':P_CURSOR', 'value'=>$cursor, 'type'=>OCI_B_CURSOR)
                    );

        return $this->db->sp_seculo('BD_PORTAL','SP_CL_CURSO_SERIE_TURMA_ALUNO',$params);		
	
    }
    
    function inserir_conteudo($parametro){ //print_r($parametro);exit;
        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':CD_SLIDE', 'value' => NULL),
            array('name' => ':CD_DISCIPLINA', 'value' => $parametro['cd_disciplina']),
            array('name' => ':CD_PROFESSOR', 'value' => NULL),
            array('name' => ':TITULO', 'value' => $parametro['titulo']),
            array('name' => ':CONTEUDO', 'value' => NULL),
            array('name' => ':PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':CD_USUARIO', 'value' => $parametro['cd_usuario']),
            array('name' => ':CD_CURSO', 'value' => $parametro['cd_curso']),
            array('name' => ':CD_SERIE', 'value' => $parametro['cd_serie']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_SLIDE', $params);
    }
    
    function lista_conteudo($parametro){ 
        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':CD_SLIDE', 'value' => NULL),
            array('name' => ':CD_DISCIPLINA', 'value' => NULL),
            array('name' => ':CD_PROFESSOR', 'value' => NULL),
            array('name' => ':TITULO', 'value' => NULL),
            array('name' => ':CONTEUDO', 'value' => NULL),
            array('name' => ':PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':CD_USUARIO', 'value' => NULL),
            array('name' => ':CD_CURSO', 'value' => NULL),
            array('name' => ':CD_SERIE', 'value' => NULL),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_SLIDE', $params);
    }

}
