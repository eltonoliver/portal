<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Conteudo_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function sp_coonteudo($parametro) { #print_r($parametro);exit;
        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':CD_PROFESSOR', 'value' => $parametro['cd_professor']),
            array('name' => ':PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_PROFESSOR_CONTEUDO', $params);
    }
    
    function lista_turmas($parametro){
        $sql = "SELECT DISTINCT PRF.PERIODO,PRF.CD_TURMA,PRF.CD_DISCIPLINA,PRF.CD_PROFESSOR,DIS.NM_DISCIPLINA,
                TUR.CD_TURMA,
                CASE WHEN TUR.TURNO = 'M' THEN 'MANHÃ'
                     WHEN TUR.TURNO = 'T' THEN 'TARDE'
                ELSE 'TURNO INDEFINIDO' END AS TURNO,
                     CUR.NM_CURSO
            FROM BD_SICA.CL_TURMA_PROFESSORES PRF
            JOIN BD_SICA.CL_DISCIPLINA DIS ON PRF.CD_DISCIPLINA = DIS.CD_DISCIPLINA
            JOIN BD_SICA.TURMA TUR ON TUR.CD_TURMA = PRF.CD_TURMA AND TUR.PERIODO = PRF.PERIODO
            JOIN BD_SICA.CURSOS CUR ON CUR.CD_CURSO = TUR.CD_CURSO
            LEFT JOIN BD_SICA.CL_PLANO_ENSINO PLEN ON PLEN.CD_PROFESSOR = PRF.CD_PROFESSOR
                       AND PLEN.PERIODO = PRF.PERIODO
                       AND PLEN.CD_DISCIPLINA = PRF.CD_DISCIPLINA
            WHERE  PRF.CD_PROFESSOR = ".$parametro['cd_professor']." AND TUR.PERIODO = '".$parametro['periodo']."'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        }else{
            return false;
        }
    }
    

}
