<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class Permissao_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
    // RELAÇÃO DE ALUNOS SOB A RESPONSABILIDADE DE UMA PESSOA
    function responsavel_aluno() {
		$query = $this->db->query("SELECT CD_ALUNO,NM_ALUNO FROM bd_sica.aluno WHERE RES_CPF = '".$this->session->userdata('SCL_SSS_USU_ID')."' ORDER BY NM_ALUNO ASC");	
		if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // RELAÇÃO DE ALUNOS SOB A RESPONSABILIDADE DE UMA PESSOA
    function permissao_sistema() {
		$query = $this->db->query("SELECT * FROM bd_sica.upermissoes perm, bd_sica.programas prog
                                           WHERE perm.cd_programa = prog.cd_programa
                                             AND perm.cd_usuario = ".$this->session->userdata('SCL_SSS_USU_CODIGO')."
				             AND prog.sistema in  (87,108)
                                             and prog.cd_programa <> 2760
				        ORDER BY NM_PROGRAMA ASC");	
		if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
	
    // RELAÇÃO DE ALUNOS SOB A RESPONSABILIDADE DE UM COLABORADOR
    function pesquisar_alunos($parametro) {		
		
		$query = $this->db->query("SELECT * FROM bd_sica.t_curso_user cus
  									JOIN bd_sica.aluno alu On cus.cd_curso = alu.cd_curso
  									JOIN bd_sica.matricula mat ON alu.cd_aluno = mat.cd_aluno
  									JOIN bd_sica.cl_aluno_info inf ON alu.cd_aluno = inf.cd_aluno
  									JOIN bd_sica.cursos cur ON alu.cd_curso = cur.cd_curso AND cus.cd_curso = cur.cd_curso
  									JOIN bd_sica.series ser ON alu.cd_curso = ser.cd_curso AND alu.ordem_serie = ser.ordem_serie
								   WHERE mat.periodo = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'
   									AND cus.cd_usuario = ".$parametro['usuario']."
   									AND alu.nm_aluno LIKE(UPPER('".$parametro['aluno']."%'))
 							   ORDER BY alu.nm_aluno ASC");	
		if($query->num_rows() > 0) {
	    	$alunos = $query->result();
			$listar =  '<div class="col-sm-12">
				             <div class="widget-box" style="opacity: 1; z-index: 0;">
    						<div class="widget-header header-color-blue">
								<h5 class="bigger lighter"> <i class="icon-group"></i> Alunos Encontrados '.$query->num_rows().'</h5>
    						</div>
    						<div class="widget-body">
      							<div class="widget-main no-padding">
			
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered table-hover dataTable">
 									<thead>
									<tr>
    									<td width="8%" align="center"><strong>MATRÍCULA</strong></td>
    									<td><strong>ALUNO</strong></td>
    									<td><strong>CURSO</strong></td>
    									<td width="5%" align="center"><strong>SÉRIE</strong></td>
    									<td width="5%" align="center"><strong>TURMA</strong></td>
										<td width="10%" align="center"></td>
  									</tr>
									<thead>
									<tbody>';
			foreach($alunos as $row){	
				//if($row->ALU_SEXO == 'F'){ $cor = 'pink'; }else{ $cor = 'blue'; }
					$listar .=  '<tr>
    								<td align="center">'.$row->CD_ALUNO.'</td>
    								<td>'.$row->NM_ALUNO.'</td>
    								<td>'.$row->NM_CURSO.'</td>
    								<td align="center">'.$row->NM_SERIE.'</td>
    								<td align="center">'.$row->CD_TURMA.'</td>
									<td align="center">
									<form action="'.SCL_RAIZ.'/medico/enfermaria/prontuario" method="post" name="'.$row->CD_ALUNO.'" id="'.$row->CD_ALUNO.'">
									<input type="hidden" name="aluno" id="aluno" value="'.$row->CD_ALUNO.'"/>
									<button class="btn btn-xs btn-purple">
									<i class="icon-medkit bigger-110"></i>Prontuário
									</button>
									</form>
									</td>
  								</tr>';
			}
			$listar .= '</tbody>';
			$listar .= '<tfoot></tfoot></table></div></div></div></div>';
			
           return ($listar);
        } else {
			$listar = 'Nenhum aluno encontrado!';
            return ($listar);
        }
    }
	
}


