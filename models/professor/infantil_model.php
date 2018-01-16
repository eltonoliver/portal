<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Infantil_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function sp_infantil($parametro) { 
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_CD_PROFESSOR', 'value' => $parametro['cd_professor']),
            array('name' => ':P_PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':P_CD_TURMA', 'value' => $parametro['cd_turma']),
            array('name' => ':P_CD_ALUNO', 'value' => $parametro['cd_aluno']),
            array('name' => ':P_DATA', 'value' => $parametro['dia']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        
        return $this->db->sp_seculo('BD_PORTAL', 'AES_DIARIO_INFANTIL', $params);
    }
    
    
    function questonario($parametro) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $parametro['aluno']),
            array('name' => ':P_CD_PERGUNTA', 'value' => $parametro['pergunta']),
            array('name' => ':P_CD_QUEST', 'value' => $parametro['questionario']),
            array('name' => ':P_CD_RESPOSTA', 'value' => $parametro['resposta']),
            array('name' => ':P_PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':P_BIMESTRE', 'value' => $parametro['bimestre']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        //print_r($params);
        return $this->db->sp_seculo('BD_PORTAL', 'AES_QUESTIONARIO_INFANTIL', $params);
    }
    
    

    function diario_lancar($data) {
        $consulta = $this->db->query("SELECT * FROM bd_sica.cl_acompanhamento_infantil WHERE cd_aluno = '" . $data['aluno'] . "' AND dt_acompanhamento = trunc(sysdate)");
        if ($consulta->num_rows() == 0) {
            $sql = "INSERT INTO bd_sica.cl_acompanhamento_infantil( 
			                    cd_aluno,dt_acompanhamento, colacao,almoco,lanche,sono,evacuacao
						 )VALUES(
						  '" . $data['aluno'] . "',
						  to_date('" . date('d/m/Y') . "', 'DD/MM/YYYY'),
						  '" . $data['colacao'] . "',
						  '" . $data['almoco'] . "',
						  '" . $data['lanche'] . "',
						  '" . $data['descanso'] . "',
						  '" . $data['evacuacao'] . "'
						 )";
        } else {
            $sql = "UPDATE bd_sica.cl_acompanhamento_infantil 
			           SET colacao = '" . $data['colacao'] . "',
						   almoco = '" . $data['almoco'] . "',
						   lanche = '" . $data['lanche'] . "',
						   sono = '" . $data['descanso'] . "',
						   evacuacao = '" . $data['evacuacao'] . "'
					 WHERE cd_aluno = '" . $data['aluno'] . "' AND dt_acompanhamento = trunc(sysdate)";
        }
        $query = $this->db->query($sql);
        if ($query == true) {
            return true;
        } else {
            return false;
        }
    }

// MONTAR O QUESTIONARIO
    function montar_questionario_view($parametro) {
        // VERIFICAR QUAL O QUESTIONARIO QUE SERÁ MONTADO
        $query = $this->db->query("SELECT * FROM BD_QUEST.WEB_QUESTIONARIO WHERE CD_QUEST = " . $parametro['codigo'] . " AND ativo = 1");
        if ($query->num_rows() == 1) {
            $questionario = '<input type="hidden" id="questionario" name="questionario" value="' . $parametro['codigo'] . '">
			  <input type="hidden" id="aluno" name="aluno" value="' . $parametro['aluno'] . '">
			  <input type="hidden" id="bimestre" name="bimestre" value="' . $parametro['bimestre'] . '">';
            $divisao = $this->db->query("SELECT D.CD_DIVISAO, D.DC_DIVISAO FROM BD_QUEST.WEB_DIVISAO D
                                                WHERE EXISTS(SELECT 1
                                                                FROM BD_QUEST.WEB_PERGUNTA P
                                                             WHERE P.CD_QUEST = " . $parametro['codigo'] . "
                                                                 AND P.CD_DIVISAO = D.CD_DIVISAO)
                                                            ORDER BY D.CD_DIVISAO")->result();

            $questionario .= '<div class="form-group"><div id="accordion-2" class="panel-group">';
            foreach ($divisao as $div) {
                $questionario .= '  <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a href="#accordion2-' . $div->CD_DIVISAO . $parametro['bimestre'] . $parametro['aluno'] . '" data-parent="#accordion-2" data-toggle="collapse" class="collapsed"> 
                                                        ' . $div->DC_DIVISAO . ' <i class="fa fa-angle-down pull-right"></i>
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="panel-collapse collapse" id="accordion2-' . $div->CD_DIVISAO . $parametro['bimestre'] . $parametro['aluno'] . '" style="height: 0px;">
                                           <div class="panel-body"> 
                                              <table class="table table-striped table-bordered table-hover">
                                                 <thead class="thin-border-bottom">
                                                    <tr>
                                                                <th> Pergunta</th>
                                                                <th width="15%"> Bimestre</th>
                                                                <th width="10%"> Status</th>
                                                              </tr>
                                                            </thead>
                                                            <tbody>';
                $pergunta = $this->db->query("SELECT DISTINCT 
                                                     PER.CD_PERGUNTA, 
                                                     PER.DC_PERGUNTA, 
                                                     RES.CD_RESPOSTA,
                                                     PER.ORDEM
  					        FROM BD_QUEST.WEB_PERGUNTA PER
                                                JOIN BD_QUEST.WEB_DIVISAO DIS ON per.cd_divisao = DIS.cd_divisao
                                           LEFT JOIN BD_QUEST.WEB_RESULTADO RES ON per.cd_quest = RES.cd_quest
					                                       AND per.cd_pergunta = RES.cd_pergunta
								               AND RES.cd_aluno = '" . $parametro['aluno'] . "'
                                                                               AND RES.bimestre = '" . $parametro['bimestre'] . "'
                                               WHERE PER.CD_QUEST = " . $parametro['codigo'] . "
						 AND PER.CD_DIVISAO =  " . $div->CD_DIVISAO . "
					    ORDER BY PER.ORDEM DESC")->result();


                foreach ($pergunta as $per) {
                    $resposta = $this->db->query("SELECT DISTINCT CD_RESPOSTA, DC_RESPOSTA
  										  FROM BD_QUEST.WEB_RESPOSTA 
										 WHERE CD_QUEST = " . $parametro['codigo'] . "
										   AND CD_PERGUNTA =  " . $per->CD_PERGUNTA . "
										 ORDER BY CD_RESPOSTA DESC")->result();
                    
                    $questionario .= '<tr><td class="">' . $per->DC_PERGUNTA . '</td>';

                    $questionario .= '<td>';
                    $questionario .= '<select class="form-control" ';
                    $questionario .= 'onchange="getValor(this.value, this)"';
                    $questionario .= ' name="' . $per->CD_PERGUNTA . '" id="' . $per->CD_PERGUNTA . '" >';
                    $questionario .= '<option></option>';
                    foreach ($resposta as $res) {
                        $select = '';
                        if ($per->CD_RESPOSTA != NULL) {
                            if ($per->CD_RESPOSTA == $res->CD_RESPOSTA) {
                                $select = 'selected="selected"';
                            }
                        }

                        $questionario .= '<option ' . $select . ' value="' . $per->CD_PERGUNTA . ':' . $res->CD_RESPOSTA . '">' . $res->DC_RESPOSTA . '</option>';
                    }
                    $status = '';
                    if ($per->CD_RESPOSTA != NULL) {
                        $status = '<label class="label label-success"><i class="icon-ok">OK</i></label>';
                    }
                    $questionario .= '</select></td>
				                   <td class=""><div id="status' . $per->CD_PERGUNTA . '" >' . $status . '</td>
				                   </tr>';
                }
                $questionario .= '</tbody>
        </table>
                                                </div>
                                        </div>
                                    </div>
				';
            }
            $questionario .= '</div></div>';
            return ($questionario);
        } else {
            return "Questionário ainda não foi liberado";
        }
    }

    //DADOS DO QUESTIONARIO
    function dados_questionarios($paramentro) {
        
    }

    // MONTAR O QUESTIONARIO
    function resposta($parametro) {
        // VERIFICAR QUAL O QUESTIONARIO QUE SERÁ MONTADO
        $query = $this->db->query("SELECT * FROM BD_QUEST.WEB_RESULTADO 
		                            WHERE CD_QUEST = " . $parametro['questionario'] . " 
                                                    AND CD_ALUNO = " . $parametro['aluno'] . "
                                                    AND CD_PERGUNTA = " . $parametro['pergunta'] . "
                                                    AND PERIODO = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
                                                    AND BIMESTRE = " . $parametro['bimestre'] . "");
        if ($query->num_rows() == 0) {

            $insert = $this->db->query("INSERT INTO BD_QUEST.WEB_RESULTADO(
			                            	CD_PERGUNTA, 
                                                        CD_QUEST, 
                                                        CD_RESPOSTA, 
                                                        CD_ALUNO, 
                                                        DT_REGISTRO, 
                                                        PERIODO, 
                                                        BIMESTRE
                                                ) VALUES (
                                                        " . $parametro['pergunta'] . ",
                                                        " . $parametro['questionario'] . ",
                                                        " . $parametro['resposta'] . ",
                                                        '" . $parametro['aluno'] . "',
                                                        sysdate,
                                                        '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "',
                                                        " . $parametro['bimestre'] . ")");

            return '<label class="label label-success"><i class="icon-ok">Inserido</i></label>';
        } else {

            $query = $this->db->query("UPDATE BD_QUEST.WEB_RESULTADO
			                              SET CD_RESPOSTA = " . $parametro['resposta'] . " 
		                                WHERE CD_QUEST = " . $parametro['questionario'] . " 
                                                    AND CD_ALUNO = " . $parametro['aluno'] . "
                                                    AND CD_PERGUNTA = " . $parametro['pergunta'] . "
                                                    AND PERIODO = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
                                                    AND BIMESTRE = " . $parametro['bimestre'] . "");

            return '<label class="label label-warning"><i class="icon-ok">Atualizado</i></label>';
        }
    }

}
