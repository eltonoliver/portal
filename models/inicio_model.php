<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inicio_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function sp_dashboard($parametro) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_DASHBOARD', $params);
    }

    function tempo_aula($tipo, $parametro) {

        // GRADE CURRICULAR DO ALUNO
        // TIPO = 0 // VISUALIZAÇÃO DO ALUNO
        // TIPO = 1 // VISUALIZAÇÃO DO PROFESSOR
        // TIPO = 2 // VISUALIZAÇÃO DO RESPONSAVEL

        if ($tipo == 0) {
            $select = "JOIN bd_sica.matricula mat ON mat.cd_turma = hor.cd_turma AND mat.periodo = hor.periodo";
            $where = "AND mat.cd_aluno = '" . $parametro . "'";
            $mista = "AND alux.cd_aluno = '" . $parametro . "'";
        } elseif ($tipo == 1) {
            $select = "";
            $where = 'AND hor.cd_professor = ' . $parametro . '';
            $mista = "AND alux.cd_turma = hor.cd_turma";
        }
        $sql = "SELECT distinct hor.periodo,
                     hor.cd_turma,
                    hor.cd_disciplina,
                    hor.cd_professor,
                    prf.nm_professor,
                    dis.nm_disciplina,
                    dis.nm_disc_red,
                    tur.cd_turma,
                    tur.cd_curso,
                    tur.turno,
                    cur.nm_curso,
                    hor.dia_semana,
                    hor.turno_tempo,
                    (SELECT DESCRICAO FROM BD_SICA.cl_turma_detalhes s1, BD_SICA.t_sala s2 
                                           WHERE s1.cd_sala = s2.cd_sala 
                                             AND s1.periodo = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "' 
                                             AND s1.cd_turma = hor.cd_turma
                                             AND s2.descricao is not null) AS sala,
					(SELECT DISTINCT NM_DISC_RED  
					   FROM bd_sica.cl_alu_disc_turma_mista mix
          			   JOIN bd_sica.cl_disciplina dix ON mix.cd_disciplina = dix.cd_disciplina
          			   JOIN bd_sica.cl_alu_disc alux ON alux.cd_alu_disc = mix.cd_alu_disc
          			  WHERE mix.periodo = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
            			AND alux.cd_disciplina = hor.cd_disciplina
            			" . $mista . " AND ROWNUM = 1) AS mista,
					(SELECT DISTINCT CD_TURMA_MISTA  
					   FROM bd_sica.cl_alu_disc_turma_mista mix
          			   JOIN bd_sica.cl_disciplina dix ON mix.cd_disciplina = dix.cd_disciplina
          			   JOIN bd_sica.cl_alu_disc alux ON alux.cd_alu_disc = mix.cd_alu_disc
          			  WHERE mix.periodo = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
            			AND alux.cd_disciplina = hor.cd_disciplina
            			" . $mista . " AND ROWNUM = 1) AS mixturma,
                    hor.tempo_aula
         from bd_rh.cl_turma_horario hor
         JOIN bd_sica.cursos cur ON hor.cd_curso = cur.cd_curso
         JOIN bd_sica.series ser ON hor.ordem_serie = ser.ordem_serie AND hor.cd_curso = ser.cd_curso
         JOIN bd_sica.cl_disciplina dis ON hor.cd_disciplina = dis.cd_disciplina
         JOIN bd_sica.t_professor prf ON hor.cd_professor = prf.cd_professor
         JOIN bd_sica.turma tur ON tur.cd_turma = hor.cd_turma AND tur.periodo = hor.periodo
		 " . $select . "
         WHERE hor.cd_professor  <> 32
             AND tur.turno IN('M','T')
           --  AND tur.tipo in ('N','X','L','P')
	   --  AND hor.dt_fim is null
           AND  TRUNC(sysdate) BETWEEN hor.dt_inicio AND NVL(hor.dt_fim, sysdate)           
             AND hor.periodo = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
	     " . $where . "
             ORDER BY TEMPO_AULA, DIA_SEMANA ASC";
//echo $sql;
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $sql = $query->result();

            $table = '<table width="100%" border="1" cellspacing="1" cellpadding="1" class="table table-striped table-bordered table-hover dataTable">
          			   <thead>
					   <tr>
            				<td colspan="7" width="4%" align="center" valign="middle"><i class="icon-time"></i> Horários da Manhã </td>
          				</tr>
                         <tr>
            				<td width="4%" align="center" valign="middle"><i class="icon-time"></i></td>
            				<td width="16%" align="center" valign="middle"><strong>Segunda</strong></td>
            				<td width="16%" align="center" valign="middle"><strong>Terça</strong></td>
            				<td width="16%" align="center" valign="middle"><strong>Quarta</strong></td>
            				<td width="16%" align="center" valign="middle"><strong>Quinta</strong></td>
            				<td width="16%" align="center" valign="middle"><strong>Sexta</strong></td>
					<td width="16%" align="center" valign="middle"><strong>Sábado</strong></td>
          				</tr>
          			</thead>';

            for ($j = 1; $j < 8; $j++) {
                $table .= '<tr>';
                $table .= '<td align="center" width="16%"> ' . $j . 'º Tempo</td>';
                for ($i = 1; $i < 7; $i++) {
                    $table .= '<td align="center" valign="middle" style="font-size:10px">';
                    foreach ($sql as $item) {

                        if ($item->DIA_SEMANA == $i && $item->TEMPO_AULA == $j) {
                            if(substr($item->TURNO_TEMPO,0, 1) == 'A'){

                            if ($item->MISTA == '') {
                                $table .= '<label class="label label-warning" ><strong>' . $item->NM_DISC_RED . '</strong></label><br/>';
                            } else {
                                $table .= '<label class="label label-warning" ><strong>' . $item->NM_DISC_RED . ' - ' . $item->MISTA . '</strong></label><br/>';
                            }

                            if ($this->session->userdata('SCL_SSS_USU_TIPO') != 20)
                                $table .= '' . $item->NM_PROFESSOR . '<br/>';
                            if ($item->MISTA == '') {
                                $table .= '' . $item->CD_TURMA . '<br/>';
                            } else {
                                $table .= '' . $item->MIXTURMA . '<br/>';
                            }

                            $table .= '' . $item->SALA .  '<br/>';
                            }
                        }
                    }
                }
                $table .= '</td>';
                $table .= '</tr>';
            }
            $table .= '</table><br />';

            $table .= $this->tempo_aula_extra($tipo, $parametro);
            return $table;
        } else {
            return false;
        }
    }

    function tempo_aula_extra($tipo, $parametro) {

        // GRADE CURRICULAR DO ALUNO
        // TIPO = 0 // VISUALIZAÇÃO DO ALUNO
        // TIPO = 1 // VISUALIZAÇÃO DO PROFESSOR
        // TIPO = 2 // VISUALIZAÇÃO DO RESPONSAVEL

        if ($tipo == 0) {
            $select = "JOIN bd_sica.matricula mat ON mat.cd_turma = hor.cd_turma AND mat.periodo = hor.periodo";
            $where = "AND mat.cd_aluno = '" . $parametro . "'";
        } elseif ($tipo == 1) {
            $select = "";
            $where = 'AND hor.cd_professor = ' . $parametro . '';
        }

        $query = $this->db->query("select hor.periodo,
                     hor.cd_turma,
                    hor.cd_disciplina,
                    hor.cd_professor,
                    prf.nm_professor,
                    dis.nm_disciplina,
                    dis.nm_disc_red,
                    tur.cd_turma,
                    tur.cd_curso,
                    tur.turno,
                    cur.nm_curso,
                    hor.dia_semana,
                    hor.turno_tempo,
                    (SELECT DESCRICAO FROM BD_SICA.cl_turma_detalhes s1, BD_SICA.t_sala s2 WHERE s1.cd_sala = s2.cd_sala AND s1.periodo = '2014/1' AND s1.cd_turma = hor.cd_turma) AS sala,
                    hor.tempo_aula
         from bd_rh.cl_turma_horario hor
         JOIN bd_sica.cursos cur ON hor.cd_curso = cur.cd_curso
         JOIN bd_sica.series ser ON hor.ordem_serie = ser.ordem_serie AND hor.cd_curso = ser.cd_curso
         JOIN bd_sica.cl_disciplina dis ON hor.cd_disciplina = dis.cd_disciplina
         JOIN bd_sica.t_professor prf ON hor.cd_professor = prf.cd_professor
         JOIN bd_sica.turma tur ON tur.cd_turma = hor.cd_turma AND tur.periodo = hor.periodo
		 " . $select . "
         WHERE hor.cd_professor  <> 32
       --      AND tur.turno = 'T'
     --        AND tur.tipo in ('N','X','L')
			 AND hor.dt_fim is null
             AND hor.periodo = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
			 " . $where . "
             ORDER BY TEMPO_AULA, DIA_SEMANA ASC");

        if ($query->num_rows() > 0) {
            $sql = $query->result();

            $table = '<table width="100%" border="1" cellspacing="1" cellpadding="1" class="table table-striped table-bordered table-hover dataTable">
          			   <thead>
                         <tr>
            				<td colspan="7" width="4%" align="center" valign="middle"><i class="icon-time"></i> Horários da tarde </td>
          				</tr>
						 <tr>
            				<td width="4%" align="center" valign="middle"><i class="icon-time"></i></td>
            				<td width="16%" align="center" valign="middle"><strong>Segunda</strong></td>
            				<td width="16%" align="center" valign="middle"><strong>Terça</strong></td>
            				<td width="16%" align="center" valign="middle"><strong>Quarta</strong></td>
            				<td width="16%" align="center" valign="middle"><strong>Quinta</strong></td>
            				<td width="16%" align="center" valign="middle"><strong>Sexta</strong></td>
							<td width="16%" align="center" valign="middle"><strong>Sábado</strong></td>
          				</tr>
          			</thead>';

            for ($j = 1; $j < 8; $j++) {
                $table .= '<tr>';
                $table .= '<td align="center" width="16%"> ' . $j . 'º Tempo</td>';
                for ($i = 1; $i < 7; $i++) {
                    $table .= '<td align="center" valign="middle" style="font-size:10px">';
                    foreach ($sql as $item) {
                        if(substr($item->TURNO_TEMPO,0, 1) == 'B'){
                            if ($item->DIA_SEMANA == $i && $item->TEMPO_AULA == $j) {
                                $table .= '<label class="label label-warning" ><strong>' . $item->NM_DISC_RED . '</strong></label><br/>';
                                if ($this->session->userdata('SCL_SSS_USU_TIPO') != 20)
                                    $table .= '' . $item->NM_PROFESSOR . '<br/>';
                                $table .= '' . $item->CD_TURMA . '<br/>';
                                $table .= '' . $item->SALA . '<br/>';
                            }
                        }
                    }
                }
                $table .= '</td>';
                $table .= '</tr>';
            }
            $table .= '</table>';
            return $table;
        } else {
            return false;
        }
    }
    
    public function get_bySenha($dados){
        switch ($dados['tipo']) {
            case 10:
                 $sql = "SELECT CD_ALUNO FROM BD_SICA.ALUNO  WHERE ALU_SENHA = '".$dados['senha']."' AND CD_ALUNO = ".$dados['usuario'];
                break;
            case 20:
                 $sql = "SELECT CPF_RESPONSAVEL FROM BD_SICA.RESPONSAVEL  WHERE SENHA_RESPONSAVEL = '".$dados['senha']."' AND CPF_RESPONSAVEL = '".$dados['usuario']."'";
                break;
            case 30 && 40:
                 $sql = "SELECT CD_USUARIO FROM BD_SICA.USUARIOS  WHERE SENHA_INTERNET = '".$dados['senha']."' AND CD_USUARIO = ".$dados['usuario'];
                break;

            default:
                break;
        }
        return $this->db->query($sql);
    }

    
    public function alterar_senha($dados){
        switch ($dados['tipo']) {
            case 10:
                 $sql = "UPDATE BD_SICA.ALUNO SET ALU_SENHA = '".$dados['senha']."' WHERE  CD_ALUNO = ".$dados['usuario'];
                break;
            case 20:
                 $sql = "UPDATE BD_SICA.RESPONSAVEL SET SENHA_RESPONSAVEL = '".$dados['senha']."' WHERE CPF_RESPONSAVEL = '".$dados['usuario']."'";
                break;
            case 30 && 40:
                 $sql = "UPDATE BD_SICA.USUARIOS SET SENHA_INTERNET = '".$dados['senha']."' WHERE CD_USUARIO = ".$dados['usuario'];
                break;

            default:
                break;
        }
       # echo $sql;
        return $this->db->query($sql);
    }
    
}
