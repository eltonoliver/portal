<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Relatorio_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function conteudo_ministrado($dados) {
        $cursor = "";

        $params = array(                        
            array('name' => ':P_OPERACAO', 'value' => $dados['operacao']),
            array('name' => ':P_CD_DISCIPLINA', 'value' => $dados['disciplina']),
            array('name' => ':P_BIMESTRE', 'value' => $dados['bimestre']),
            array('name' => ':P_CD_TURMA', 'value' => $dados['turma']),
            array('name' => ':P_PERIODO', 'value' => $dados['periodo']),
            array('name' => ':P_CD_TIPO_NOTAPERIODO', 'value' => $dados['tipo_nota']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        
        return $this->db->procedure("BD_PORTAL", "AES_CONTEUDO_MINISTRADO", $params);
    }

    // EMISSÃO DE BOLETIM ***************************************************************************************************/
    function recuperacao($dados) {
        $sql = $this->db->query("SELECT DISTINCT A.CD_ALUNO, A.NM_ALUNO, A.ORDEM_SERIE, A.TURMA_ATUAL
FROM BD_SICA.ALUNO A
INNER JOIN BD_SICA.MATRICULA M
    ON A.CD_ALUNO = M.CD_ALUNO AND M.PERIODO = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
INNER JOIN BD_SICA.CL_TURMA_DETALHES TD
    ON TD.CD_TURMA = M.CD_TURMA AND TD.PERIODO = M.PERIODO
INNER JOIN BD_SICA.CL_ESTRUT EST
    ON EST.CD_ESTRUTURA = TD.CD_ESTRUTURA
INNER JOIN BD_SICA.CL_ALUNO_INFO AI
    ON A.CD_ALUNO = AI.CD_ALUNO
INNER JOIN BD_SICA.CURSOS C
    ON A.CD_CURSO = C.CD_CURSO
INNER JOIN BD_SICA.CL_ALU_DISC AD
    ON A.CD_ALUNO = AD.CD_ALUNO
INNER JOIN BD_SICA.CL_ALU_NOTA AN
    ON AD.CD_ALU_DISC = AN.CD_ALU_DISC
INNER JOIN BD_SICA.CL_DISCIPLINA D
    ON D.CD_DISCIPLINA = AD.CD_DISCIPLINA
WHERE AD.PERIODO = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
AND AN.NUM_NOTA = " . $dados['nota'] . " -- MBF (MEDIA FINAL BIMESTRAL DO 1º BIMESTRE)
AND AN.NOTA < EST.MEDIA_APROVEITAMENTO
AND A.STATUS = 1
AND A.TIPO = 'C'
AND M.TIPO = 'N'
AND C.CD_CURSO = " . $dados['curso'] . "
AND A.ORDEM_SERIE = " . $dados['serie'] . "
ORDER BY A.TURMA_ATUAL,  A.NM_ALUNO");


        if ($sql->num_rows() > 0) {
            $aluno = $sql->result();
            $html = '';

            foreach ($aluno as $alu) {


                $query = $this->db->query("SELECT A.CD_ALUNO, A.NM_ALUNO, A.ORDEM_SERIE, A.TURMA_ATUAL, 
        C.NM_CURSO_RED, 
       D.NM_DISCIPLINA, AN.NOTA, D.COMPOSTO
FROM BD_SICA.ALUNO A
INNER JOIN BD_SICA.MATRICULA M
    ON A.CD_ALUNO = M.CD_ALUNO AND M.PERIODO = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
INNER JOIN BD_SICA.CL_TURMA_DETALHES TD
    ON TD.CD_TURMA = M.CD_TURMA AND TD.PERIODO = M.PERIODO
INNER JOIN BD_SICA.CL_ESTRUT EST
    ON EST.CD_ESTRUTURA = TD.CD_ESTRUTURA
INNER JOIN BD_SICA.CL_ALUNO_INFO AI
    ON A.CD_ALUNO = AI.CD_ALUNO
INNER JOIN BD_SICA.CURSOS C
    ON A.CD_CURSO = C.CD_CURSO
INNER JOIN BD_SICA.CL_ALU_DISC AD
    ON A.CD_ALUNO = AD.CD_ALUNO
INNER JOIN BD_SICA.CL_ALU_NOTA AN
    ON AD.CD_ALU_DISC = AN.CD_ALU_DISC
INNER JOIN BD_SICA.CL_DISCIPLINA D
    ON D.CD_DISCIPLINA = AD.CD_DISCIPLINA
WHERE AD.PERIODO = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
AND AN.NUM_NOTA = " . $dados['nota'] . " -- MBF (MEDIA FINAL BIMESTRAL DO 1º BIMESTRE)
AND AN.NOTA < EST.MEDIA_APROVEITAMENTO
AND A.STATUS = 1
AND A.TIPO = 'C'
AND M.TIPO = 'N'
AND C.CD_CURSO = " . $dados['curso'] . "
AND A.ORDEM_SERIE = " . $dados['serie'] . "
AND A.CD_ALUNO = '" . $alu->CD_ALUNO . "'
ORDER BY C.NM_CURSO_RED, A.TURMA_ATUAL, C.NM_CURSO, D.NM_DISCIPLINA");
                $tdisc = $query->num_rows();
                $disc = $query->result();

                //if($query->num_rows() > 0) {
                $html .= '<div class="col-xs-12 col-sm-12 widget-container-span ui-sortable">
 									 <div class="widget-box">
    										<div class="widget-header header-color-blue">
      										<h5 class="bigger lighter"><i class="icon-user"></i>
												TURMA: <strong>' . $alu->TURMA_ATUAL . '</strong> | ALUNO:<strong> ' . $alu->CD_ALUNO . ' - ' . $alu->NM_ALUNO . '
											 </h5>
    									</div>
    									<div class="widget-body">
     								 <div class="widget-main no-padding">';

                $html .= '<table width="100%" class="table table-striped table-bordered table-hover">
          									<thead class="thin-border-bottom">
           										 <tr>
              										<th align="left">Discipilna </th>
              										<th width="10%" align="center">Nota </th>
            									</tr>
          									</thead>
          								<tbody>';
                foreach ($disc as $nt) {
                    if ($nt->COMPOSTO == 1)
                        $css = 'danger';
                    else
                        $css = '';

                    $html .= '<tr>
              								<td class="' . $css . '">' . $nt->NM_DISCIPLINA . '</td>
              								<td align="center" class="' . $css . '">' . $nt->NOTA . '</td>
            						</tr>';
                }
                $html .= '</tbody></table>';
                $html .= '</div></div></div></div>';
                //}
            }
            return ($html);
        }else {
            return "Não há aluno em recuperação";
        }
    }

    // EMISSÃO DE BOLETIM ***************************************************************************************************/
    function imprimir_recuperacao($dados) {
        $sql = $this->db->query("SELECT DISTINCT A.CD_ALUNO, A.NM_ALUNO, A.ORDEM_SERIE, A.TURMA_ATUAL
FROM BD_SICA.ALUNO A
INNER JOIN BD_SICA.MATRICULA M
    ON A.CD_ALUNO = M.CD_ALUNO AND M.PERIODO = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
INNER JOIN BD_SICA.CL_TURMA_DETALHES TD
    ON TD.CD_TURMA = M.CD_TURMA AND TD.PERIODO = M.PERIODO
INNER JOIN BD_SICA.CL_ESTRUT EST
    ON EST.CD_ESTRUTURA = TD.CD_ESTRUTURA
INNER JOIN BD_SICA.CL_ALUNO_INFO AI
    ON A.CD_ALUNO = AI.CD_ALUNO
INNER JOIN BD_SICA.CURSOS C
    ON A.CD_CURSO = C.CD_CURSO
INNER JOIN BD_SICA.CL_ALU_DISC AD
    ON A.CD_ALUNO = AD.CD_ALUNO
INNER JOIN BD_SICA.CL_ALU_NOTA AN
    ON AD.CD_ALU_DISC = AN.CD_ALU_DISC
INNER JOIN BD_SICA.CL_DISCIPLINA D
    ON D.CD_DISCIPLINA = AD.CD_DISCIPLINA
WHERE AD.PERIODO = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
AND AN.NUM_NOTA = " . $dados['nota'] . " -- MBF (MEDIA FINAL BIMESTRAL DO 1º BIMESTRE)
AND AN.NOTA < EST.MEDIA_APROVEITAMENTO
AND A.STATUS = 1
AND A.TIPO = 'C'
AND M.TIPO = 'N'
AND C.CD_CURSO = " . $dados['curso'] . "
AND A.ORDEM_SERIE = " . $dados['serie'] . "
ORDER BY A.TURMA_ATUAL,  A.NM_ALUNO");


        if ($sql->num_rows() > 0) {
            $aluno = $sql->result();
            $html = '';

            foreach ($aluno as $alu) {


                $query = $this->db->query("SELECT A.CD_ALUNO, A.NM_ALUNO, A.ORDEM_SERIE, A.TURMA_ATUAL, 
        C.NM_CURSO_RED, 
       D.NM_DISCIPLINA, AN.NOTA
FROM BD_SICA.ALUNO A
INNER JOIN BD_SICA.MATRICULA M
    ON A.CD_ALUNO = M.CD_ALUNO AND M.PERIODO = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
INNER JOIN BD_SICA.CL_TURMA_DETALHES TD
    ON TD.CD_TURMA = M.CD_TURMA AND TD.PERIODO = M.PERIODO
INNER JOIN BD_SICA.CL_ESTRUT EST
    ON EST.CD_ESTRUTURA = TD.CD_ESTRUTURA
INNER JOIN BD_SICA.CL_ALUNO_INFO AI
    ON A.CD_ALUNO = AI.CD_ALUNO
INNER JOIN BD_SICA.CURSOS C
    ON A.CD_CURSO = C.CD_CURSO
INNER JOIN BD_SICA.CL_ALU_DISC AD
    ON A.CD_ALUNO = AD.CD_ALUNO
INNER JOIN BD_SICA.CL_ALU_NOTA AN
    ON AD.CD_ALU_DISC = AN.CD_ALU_DISC
INNER JOIN BD_SICA.CL_DISCIPLINA D
    ON D.CD_DISCIPLINA = AD.CD_DISCIPLINA
WHERE AD.PERIODO = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
AND AN.NUM_NOTA = " . $dados['nota'] . " -- MBF (MEDIA FINAL BIMESTRAL DO 1º BIMESTRE)
AND AN.NOTA < EST.MEDIA_APROVEITAMENTO
AND A.STATUS = 1
AND A.TIPO = 'C'
AND M.TIPO = 'N'
AND C.CD_CURSO = " . $dados['curso'] . "
AND A.ORDEM_SERIE = " . $dados['serie'] . "
AND A.CD_ALUNO = '" . $alu->CD_ALUNO . "'
ORDER BY C.NM_CURSO_RED, A.TURMA_ATUAL, C.NM_CURSO, D.NM_DISCIPLINA");
                $tdisc = $query->num_rows();
                $disc = $query->result();

                //if($query->num_rows() > 0) {
                $html .= '<div class="col-xs-12 col-sm-12 widget-container-span ui-sortable">
 									 <div class="widget-box">
    										<div class="widget-header header-color-blue">
      										<h5 class="bigger lighter"><i class="icon-user"></i>
												
											 </h5>
    									</div>
    									<div class="widget-body">
     								 <div class="widget-main no-padding">';

                $html .= '<table width="100%" class="table"  style="border:1px solid #999" >
           								<tr>
              							 <th align="left" colspan="2" height="30">
											TURMA: <strong>' . $alu->TURMA_ATUAL . '</strong> | ALUNO:<strong> ' . $alu->CD_ALUNO . ' - ' . $alu->NM_ALUNO . '</th>
            							 </tr>
										 <tr>
              							 <th align="left" height="25">Discipilna </th>
              								<th width="10%" align="center">Nota </th>
            							</tr>';
                foreach ($disc as $nt) {
                    if ($nt->COMPOSTO == 1)
                        $css = 'danger';
                    else
                        $css = '';

                    $html .= '<tr class="' . $css . '" style="background:#999999" bgcolor="#999999">
              								<td height="20" style="border:1px solid #999">' . $nt->NM_DISCIPLINA . '</td>
              								<td align="center" style="border:1px solid #999">' . $nt->NOTA . '</td>
            						</tr>';
                }
                $html .= '</table>';
                $html .= '</div></div></div></div>';
                //}
            }
            return ($html);
        }else {
            return "Não há aluno em recuperação";
        }
    }

}
