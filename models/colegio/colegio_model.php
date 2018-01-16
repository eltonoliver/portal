<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class Colegio_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
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
                array('name'=>':P_CD_DISCIPLINA', 'value'=>$dado['disciplina']),
                array('name'=>':P_CURSOR', 'value'=>$cursor, 'type'=>OCI_B_CURSOR)
                );

        return $this->db->sp_seculo('BD_PORTAL','SP_CL_CURSO_SERIE_TURMA_ALUNO',$params);		
	
    }

	
	// RELAÇÃO DE COORDENADORES
    function contato() {
		$query = $this->db->query("SELECT * FROM bd_sica.produtos ORDER BY cd_produto ASC");
		if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
	
	// RELAÇÃO DE PRODUTOS
    function produto($produto) {
		$query = $this->db->query("SELECT * FROM bd_sica.produtos WHERE CD_PRODUTO IN(".$produto.") ORDER BY cd_produto ASC");
		if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
	
	// RELAÇÃO DE PLANO DE ENSINO
    function turma_professor($tipo,$professor,$disciplina) {
	
	if($tipo == 0){ // RELAÇÃO DE TURMAS PARA PROFESSOR
		$filtro = "prf.cd_professor = '".$professor."' AND tur.periodo = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'";
	}elseif($tipo == 1){ // ESCOLHA DE APENAS 1(UMA) DISCIPLINA
		$filtro = "prf.cd_professor = '".$professor."' AND dis.cd_disciplina = ".$this->input->post('disciplina')." AND tur.periodo = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'";
	}

		$query = $this->db->query("SELECT distinct 
    									  prf.periodo,
    									  prf.cd_turma,
    									  prf.cd_disciplina,
    									  prf.cd_professor,
    									  dis.nm_disciplina,
    									  tur.cd_turma,
    									  tur.cd_curso,
    									  tur.turno,
    									  cur.nm_curso
									 FROM bd_sica.cl_turma_professores prf
        							 JOIN bd_sica.cl_disciplina dis ON prf.cd_disciplina = dis.cd_disciplina
        							 JOIN bd_sica.turma tur ON tur.cd_turma = prf.cd_turma and tur.periodo = prf.periodo
        							 JOIN bd_sica.cursos cur ON cur.cd_curso = tur.cd_curso
        						LEFT JOIN bd_sica.cl_plano_ensino plen ON plen.cd_professor = prf.cd_professor  
                                                                      AND plen.periodo = prf.periodo 
                                                                      AND plen.cd_disciplina = prf.cd_disciplina
    							     WHERE ".$filtro." 
								  ORDER BY nm_disciplina ASC");
	
	

	if($tipo == 0){
			if($query->num_rows() > 0) {
				return $query->result();
       		 } else {
           	 	return false;
        	}
		}elseif($tipo == 1){
			if($query->num_rows() == 1) {
				return $query->result();
        	} else {
            	return false;
        	}
		}		
    }

	// RELAÇÃO ALUNO X  CATRACA X FREQUENCIA
    function frequencia($turma,$disciplina,$curso) {

		$query = $this->db->query("SELECT ald.cd_alu_disc, 
		                                  ald.cd_aluno, 
										  alu.nm_aluno, 
										  ald.periodo, 
										  ald.cd_turma,
										  ald.cd_disciplina, 
										  ald.faltas_1b, 
										  ald.faltas_2b, 
										  ald.faltas_3b, 
										  ald.faltas_4b,
										  (SELECT cd_plano 
		   									 FROM bd_sica.cl_plano_ensino pla 
		   								    WHERE pla.cd_professor = ".$this->session->userdata('SCL_SSS_USU_CODIGO')."
		     								  AND pla.cd_disciplina =  ald.cd_disciplina
			 								  AND pla.cd_curso =  alu.cd_curso
			 								  AND pla.periodo =  ald.periodo) AS plano,
										  ald.cd_situacao
									 FROM bd_sica.cl_alu_disc ald
									 JOIN bd_sica.aluno alu ON ald.cd_aluno = alu.cd_aluno
								WHERE ald.periodo = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'
								  AND ald.cd_turma = '".$turma."'
								  AND ald.cd_disciplina = '".$disciplina."'
								  AND alu.cd_curso = '".$curso."'
								  AND alu.tipo = 'C'
								  AND alu.status = 1
							     ORDER BY alu.nm_aluno ASC");

		if($query->num_rows() > 0) {
            return $query->result();
        } else { 
			
			/* pega os alunos da turma mista*/
			
			$query = $this->db->query(" SELECT alux.cd_alu_disc, 
          alu.cd_aluno, 
          alu.nm_aluno, 
          alux.periodo, 
          mix.cd_turma_mista as cd_turma, 
          alux.cd_disciplina, 
          alux.faltas_1b,
          alux.faltas_2b, 
          alux.faltas_3b, 
          alux.faltas_4b, 
          (SELECT cd_plano FROM bd_sica.cl_plano_ensino pla 
                           WHERE pla.cd_professor = 33 
                             AND pla.cd_disciplina = alux.cd_disciplina 
                             AND pla.cd_curso = alu.cd_curso 
                             AND pla.periodo = alux.periodo
                             AND rownum = 1) AS plano,
        alux.cd_situacao,
        ace.flg_passagem
        FROM bd_sica.cl_alu_disc_turma_mista mix
        JOIN bd_sica.cl_disciplina dix ON mix.cd_disciplina = dix.cd_disciplina
        JOIN bd_sica.cl_alu_disc alux ON alux.cd_alu_disc = mix.cd_alu_disc
        LEFT JOIN bd_catraca.ct_acesso ace ON alux.cd_aluno = ace.cd_usuario 
                                          AND ace.flg_passagem = 'E' 
                                          AND TO_CHAR(ace.dt_hr_acesso,'DD/MM/YYYY') = '".date('d/m/Y')."'      
         JOIN bd_sica.aluno alu ON alu.cd_aluno = alux.cd_aluno 
       WHERE alux.periodo = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'
								  AND mix.cd_turma_mista = '".$turma."'
          AND alu.tipo = 'C' 
          AND alu.status = 1
    ORDER BY alu.nm_aluno ASC");
						if($query->num_rows() > 0) {
            				return $query->result();
        				} else {
							return false;
						}
        }
    }
    function tempo_aula_dia($professor) { 
		
		$sql = "SELECT 
    				prf.periodo,
   					prf.cd_turma,
    				prf.cd_disciplina,
    				prf.cd_professor,
    				dis.nm_disciplina,
    				tur.cd_turma,
    				tur.cd_curso,
    				tur.turno,
    				cur.nm_curso,
    				hor.dia_semana,
    				hor.tempo_aula  
   		    FROM bd_sica.cl_turma_professores prf
        	JOIN bd_sica.cl_disciplina dis ON prf.cd_disciplina = dis.cd_disciplina
            JOIN bd_sica.turma tur ON tur.cd_turma = prf.cd_turma and tur.periodo = prf.periodo
            JOIN bd_sica.cursos cur ON cur.cd_curso = tur.cd_curso
            JOIN bd_sica.cl_turma_horario hor ON hor.cd_turma = prf.cd_turma 
                                              AND hor.cd_disciplina = prf.cd_disciplina 
                                              AND hor.cd_professor = ".$professor."
                                              AND hor.dia_semana = ".FL_DIA."
											  
	  WHERE prf.cd_professor = ".$professor."
      AND tur.periodo = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'
	  ORDER BY dis.nm_disciplina ASC";
		
		$query = $this->db->query($sql);	
		
		if($query->num_rows() > 0) {

            return $query->result();
        } else {
            return false;
        }		
    }
	
	function tempo_aula_extra($tipo,$parametro) {

	// GRADE CURRICULAR DO ALUNO
	// TIPO = 0 // VISUALIZAÇÃO DO ALUNO
	// TIPO = 1 // VISUALIZAÇÃO DO PROFESSOR
    // TIPO = 2 // VISUALIZAÇÃO DO RESPONSAVEL

	if($tipo == 0){
	    $select = "JOIN bd_sica.matricula mat ON mat.cd_turma = hor.cd_turma AND mat.periodo = hor.periodo";
		$where = "AND mat.cd_aluno = '".$parametro."'";
	}elseif($tipo == 1){
		$select = "";
	    $where = 'AND hor.cd_professor = '.$parametro.'';
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
                    (SELECT DESCRICAO FROM BD_SICA.cl_turma_detalhes s1, BD_SICA.t_sala s2 WHERE s1.cd_sala = s2.cd_sala AND s1.periodo = '2014/1' AND s1.cd_turma = hor.cd_turma) AS sala,
                    hor.tempo_aula
         from bd_rh.cl_turma_horario hor
         JOIN bd_sica.cursos cur ON hor.cd_curso = cur.cd_curso
         JOIN bd_sica.series ser ON hor.ordem_serie = ser.ordem_serie AND hor.cd_curso = ser.cd_curso
         JOIN bd_sica.cl_disciplina dis ON hor.cd_disciplina = dis.cd_disciplina
         JOIN bd_sica.t_professor prf ON hor.cd_professor = prf.cd_professor
         JOIN bd_sica.turma tur ON tur.cd_turma = hor.cd_turma AND tur.periodo = hor.periodo
		 ".$select."
         WHERE hor.cd_professor  <> 32
             AND tur.turno = 'T'
			 AND hor.dt_fim is null
             AND hor.periodo = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'
			 ".$where."
             ORDER BY TEMPO_AULA, DIA_SEMANA ASC");

		if($query->num_rows() > 0) {
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
			
			for($j=1;$j < 8; $j++){
				$table .= '<tr>';
				$table .= '<td align="center" width="16%"> '.$j.'º Tempo</td>';
				for($i=1;$i < 7; $i++){
					$table .= '<td align="center" valign="middle" style="font-size:10px">';
					foreach($sql as $item){

						if($item->DIA_SEMANA == $i &&  $item->TEMPO_AULA == $j){
							$table .= '<label class="label label-warning" ><strong>'.$item->NM_DISC_RED.'</strong></label><br/>';
							if($this->session->userdata('SCL_SSS_USU_TIPO') != 20) $table .= ''.$item->NM_PROFESSOR.'<br/>';
							$table .= ''.$item->CD_TURMA.'<br/>';
                                                        $table .= ''.$item->SALA.'<br/>';
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
	
	
	
    function tempo_aula($tipo,$parametro) { 

	// GRADE CURRICULAR DO ALUNO
	// TIPO = 0 // VISUALIZAÇÃO DO ALUNO
	// TIPO = 1 // VISUALIZAÇÃO DO PROFESSOR
    // TIPO = 2 // VISUALIZAÇÃO DO RESPONSAVEL

	if($tipo == 0){
	    $select = "JOIN bd_sica.matricula mat ON mat.cd_turma = hor.cd_turma AND mat.periodo = hor.periodo";
		$where = "AND mat.cd_aluno = '".$parametro."'";
		$mista = "AND alux.cd_aluno = '".$parametro."'";		
	}elseif($tipo == 1){
		$select = "";
	    $where = 'AND hor.cd_professor = '.$parametro.'';
		$mista = "AND alux.cd_turma = hor.cd_turma";
	}
		$sql = "SELECT hor.periodo,
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
                    (SELECT DESCRICAO FROM BD_SICA.cl_turma_detalhes s1, BD_SICA.t_sala s2 WHERE s1.cd_sala = s2.cd_sala AND s1.periodo = '2014/1' AND s1.cd_turma = hor.cd_turma) AS sala,
					(SELECT DISTINCT NM_DISC_RED  
					   FROM bd_sica.cl_alu_disc_turma_mista mix
          			   JOIN bd_sica.cl_disciplina dix ON mix.cd_disciplina = dix.cd_disciplina
          			   JOIN bd_sica.cl_alu_disc alux ON alux.cd_alu_disc = mix.cd_alu_disc
          			  WHERE mix.periodo = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'
            			AND alux.cd_disciplina = hor.cd_disciplina
            			".$mista.") AS mista,
					(SELECT DISTINCT CD_TURMA_MISTA  
					   FROM bd_sica.cl_alu_disc_turma_mista mix
          			   JOIN bd_sica.cl_disciplina dix ON mix.cd_disciplina = dix.cd_disciplina
          			   JOIN bd_sica.cl_alu_disc alux ON alux.cd_alu_disc = mix.cd_alu_disc
          			  WHERE mix.periodo = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'
            			AND alux.cd_disciplina = hor.cd_disciplina
            			".$mista.") AS mixturma,
                    hor.tempo_aula
         from bd_rh.cl_turma_horario hor
         JOIN bd_sica.cursos cur ON hor.cd_curso = cur.cd_curso
         JOIN bd_sica.series ser ON hor.ordem_serie = ser.ordem_serie AND hor.cd_curso = ser.cd_curso
         JOIN bd_sica.cl_disciplina dis ON hor.cd_disciplina = dis.cd_disciplina
         JOIN bd_sica.t_professor prf ON hor.cd_professor = prf.cd_professor
         JOIN bd_sica.turma tur ON tur.cd_turma = hor.cd_turma AND tur.periodo = hor.periodo
		 ".$select."
         WHERE hor.cd_professor  <> 32
             AND tur.turno = 'M'
			 AND hor.dt_fim is null
             AND hor.periodo = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'
			 ".$where."
             ORDER BY TEMPO_AULA, DIA_SEMANA ASC";
		
		$query = $this->db->query($sql);

		if($query->num_rows() > 0) {
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
			
			for($j=1;$j < 8; $j++){
				$table .= '<tr>';
				$table .= '<td align="center" width="16%"> '.$j.'º Tempo</td>';
				for($i=1;$i < 7; $i++){
					$table .= '<td align="center" valign="middle" style="font-size:10px">';
					foreach($sql as $item){

						if($item->DIA_SEMANA == $i &&  $item->TEMPO_AULA == $j){
							
							if($item->MISTA == ''){
								$table .= '<label class="label label-warning" ><strong>'.$item->NM_DISC_RED.'</strong></label><br/>';
							}else{
								$table .= '<label class="label label-warning" ><strong>'.$item->NM_DISC_RED.' - '.$item->MISTA.'</strong></label><br/>';
							}
							
							if($this->session->userdata('SCL_SSS_USU_TIPO') != 20) $table .= ''.$item->NM_PROFESSOR.'<br/>';
							if($item->MISTA == ''){
								$table .= ''.$item->CD_TURMA.'<br/>';
							}else{
								$table .= ''.$item->MIXTURMA.'<br/>';
							}
							
                            $table .= ''.$item->SALA.'<br/>';
						}
					}
				}
				$table .= '</td>';
				$table .= '</tr>';
			}
			$table .= '</table><br />';			
			$table .= $this->tempo_aula_extra($tipo,$parametro);			
			return $table;
        } else {
            return false;
        }		
    }
	
	function atividade_turma($parametro,$tipo) {
		// TIPO 0 = ALUNO
		// TIPO 1 = TURMA
		if($tipo == 0) {
			$complemento = " mat.cd_aluno = ".$parametro."";
		}elseif($tipo == 1) {
			$complemento = " des.cd_turma = ".$parametro."";
		}
		
		
		$sql = "SELECT des.cd_turma, 
                       to_char(conteudo) as conteudo, 
                       dt_lancamento,
					   to_char(dt_lancamento,'YYYY-MM-DD') as agenda,
                       EXTRACT(YEAR FROM dt_lancamento) AS ANO, 
                       EXTRACT(MONTH FROM dt_lancamento) AS MES, 
                       EXTRACT(DAY FROM dt_lancamento) AS DIA,
                       to_char(tarefa_casa) as tarefa,
                       pla.cd_professor,
                       nm_professor, 
                       nm_disciplina,
                       nm_mini
                  FROM bd_sica.cl_plano_desenvolvido des
                  JOIN bd_sica.cl_plano_ensino pla ON des.cd_plano = pla.cd_plano
                  JOIN bd_sica.t_professor prf ON prf.cd_professor = pla.cd_professor
                  JOIN bd_sica.cl_disciplina dis ON dis.cd_disciplina = pla.cd_disciplina
             LEFT JOIN bd_sica.matricula mat ON mat.cd_turma = des.cd_turma							  
	  			 WHERE ".$complemento."
				  AND mat.tipo = 'N'
      			  AND pla.periodo = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'
	  		 ORDER BY dt_lancamento ASC";

		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0) {
        	return $query->result();

        } else {

            return false;

        }		
    }
	
	
	function disciplina_turma($turma) {
		
		$sql = "SELECT cd_turma, nm_professor, dis.cd_disciplina, nm_disciplina, nm_mini, NM_DISC_RED FROM bd_sica.cl_turma_professores tpr
				  JOIN bd_sica.t_professor prf ON prf.cd_professor = tpr.cd_professor
                  JOIN bd_sica.cl_disciplina dis ON dis.cd_disciplina = tpr.cd_disciplina   							  
	  			 WHERE cd_turma = '".$turma."'
      			  AND tpr.periodo = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'
				  AND ROWNUM < 30
				  AND tpr.cd_professor <> 32
	  		 ORDER BY nm_disciplina ASC";
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0) {
        	return $query->result();
        } else {

            return false;

        }		
    }
	
	
	
	// RELAÇÃO ALUNO POR TURMA
    function turma_aluno($turma) {
		
		$sql = "SELECT alu.cd_aluno, 
		               alu.nm_aluno, 
					   mat.cd_turma, 
					   to_char(alu_inf_saude) as saude, 
					   alu_encam_medic as medico, 
					   NOTA_INICIAL_PORT, 
					   NOTA_INICIAL_MAT
		          FROM bd_sica.aluno alu, bd_sica.cl_aluno_info inf, bd_sica.matricula mat
			     WHERE alu.cd_aluno = inf.cd_aluno
  				   AND alu.cd_aluno = mat.cd_aluno
				   AND mat.periodo = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'
				   AND mat.cd_turma = '".$turma."'
			  ORDER BY alu.nm_aluno ASC";
		
		$query = $this->db->query($sql);

		if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
	
	
	// ACOMPANHAMENTO INFANTIL
    function acompanhamento_infantil($aluno) {

		$query = $this->db->query("SELECT TO_CHAR(dt_acompanhamento,'YYYY-MM-DD') AS data, colacao, almoco, lanche,sono, evacuacao 
		                             FROM bd_sica.cl_acompanhamento_infantil
								    WHERE cd_aluno = '".$aluno."'");

		if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
	
	// ACOMPANHAMENTO INFANTIL 14001136 - faltou tirar o desconto
    function nota_inicial($aluno,$por,$mat) {
		
		$query = $this->db->query("UPDATE bd_sica.cl_aluno_info 
		                              SET NOTA_INICIAL_PORT = '".$por."',
									      NOTA_INICIAL_MAT = '".$mat."'
									WHERE cd_aluno = '".$aluno."'");
		if($query == true) {
            return true;
        } else {
            return false;
        }
    }
	
	
	function disciplina_aluno($aluno) {
		$query = $this->db->query("SELECT cd_aluno, periodo, cd_turma, dis.cd_disciplina, dis.nm_disciplina FROM bd_sica.cl_alu_disc aludis
               						 JOIN bd_sica.cl_disciplina dis ON dis.cd_disciplina = aludis.cd_disciplina
      								WHERE cd_aluno = '".$aluno."' 
      								  AND periodo = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'
      							 ORDER BY nm_disciplina ASC");
		
		if($query->num_rows() > 0) {
        	return $query->result();
        } else {

            return false;

        }		
    }
	
}

// End of file login_model.php
// Location: ./application/models/login_model.php