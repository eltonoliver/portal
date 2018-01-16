<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mensagem_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Retorna a lista de alunos da turma
     * 
     * @param string $turma
     */
    function aluno($turma) {
        return $this->grupo_listar($turma, "ALU");
    }

    function mensagem($parametro) {
        /*
         * TIPO DE OPERACAO
         *  
         * I - INSERIR
         * D - DELETAR
         * LME (LISTAR MENSAGENS ENTRADA
         * LMS (LISTAR MENSAGENS SAIDA
         * CMNL (CONTAR MENSAGENS NÃO LIDAS
         * F (FILTRAR MENSAGEM)
         * 
         */
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':P_USUARIO', 'value' => $parametro['usuario']),
            array('name' => ':P_ID_MENSAGEM', 'value' => $parametro['mensagem']),
            array('name' => ':P_ASSUNTO', 'value' => $parametro['assunto']),
            array('name' => ':P_DE', 'value' => $parametro['de']),
            array('name' => ':P_CONTEUDO', 'value' => $parametro['conteudo']),
            array('name' => ':P_ANEXO', 'value' => $parametro['anexo']),
            array('name' => ':P_SPAM', 'value' => $parametro['span']),
            array('name' => ':P_ID_PAI', 'value' => $parametro['idpai']),
            array('name' => ':P_ID', 'value' => ''),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_MENSAGEM', $params);
    }

    // ENVIA A MENSAGEM PARA SEUS DESTINATÁRIOS
    function enviar($params) {
        $sql = "INSERT INTO BD_SICA.MSG (SUBJECT,DE,CONTENT,TRASH,ANEXO,SPAM
                                        )VALUES('" . $params['assunto'] . "',
                                      '" . $params['de'] . "',
                                      '" . $params['conteudo'] . "',
                                        0,
                                      '" . $params['anexo'] . "',
                                       " . $params['spam'] . ")";
        $query = $this->db->query($sql);


        if ($query) {
            $codigo = $this->db->query("SELECT MAX(ID) as codigo FROM BD_SICA.MSG WHERE DE = '" . $params['de'] . "'")->row();

            if (!empty($params['idmsg'])) {
                $idpai = $codigo->CODIGO;
                $sql = "update bd_sica.msg set id_pai = " . $idpai . " where id = " . $params['idmsg'];
                $query = $this->db->query($sql);
            }

            if ($query) {
                $idmsg = $codigo->CODIGO;
                for ($i = 0; $i < count($params['destino']); $i++) {

                    $query = $this->db->query("INSERT INTO BD_SICA.DE_PARA ( 
                                                      IDMSG,
                                                      PARA,
                                                      STATUS,
                                                      TRASH,
                                                      FILTRADO
                                              )VALUES( 
                                                      " . $idmsg . ",
                                                      '" . $params['destino'][$i] . "',
                                                      'N',
                                                      '0',
                                                      '0')");
                }

                if ($this->session->userdata('SCL_SSS_USU_TIPO') == 20) {
                    $query = $this->db->query("INSERT INTO BD_SICA.DE_PARA ( 
                                                      IDMSG,
                                                      PARA,
                                                      STATUS,
                                                      TRASH,
                                                      FILTRADO
                                              )VALUES( 
                                                      " . $idmsg . ",
                                                      '5504',
                                                      'N',
                                                      '0',
                                                      '0')");
                }

                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Marca a mensagem como lida.
     * 
     * @param interger $id Codigo da mensagem
     * @return boolean
     */
    function marcar_lida($id) {
        $sql = "update bd_sica.de_para set status = 'S' where id = " . $id;
        return $this->db->query($sql);
    }

    // ENVIA A MENSAGEM RÃ�PIDA
    function enviar_rapida($remetente, $para, $assunto, $mensagem, $spam, $anexo, $pai) {

        $sql = "INSERT INTO BD_SICA.MSG ( 
		                                       SUBJECT,DE,CONTENT,TRASH,ANEXO,SPAM
						              )VALUES('" . $assunto . "',
                                              '" . $remetente . "',
                                              '" . $mensagem . "',
                                                0,
                                              '" . $anexo . "',
                                               " . $spam . "
                                                 )";
        $query = $this->db->query($sql);

        if ($query == TRUE) {
            $codigo = $this->db->query("SELECT MAX(ID) as codigo FROM BD_SICA.MSG WHERE DE = '" . $remetente . "'")->result();

            foreach ($codigo as $l) {
                $idmsg = $l->CODIGO;
            }
            $query = $this->db->query("INSERT INTO BD_SICA.DE_PARA ( IDMSG,PARA,STATUS,TRASH,FILTRADO
									   )VALUES( " . $idmsg . ",'" . $para . "','N','0','0')");
            return true;
        } else {
            return false;
        }
    }

    // JOGANDO A MENSAGEM PARA A LIXEIRA
    // TIPO = 0 - MENSAGENS ENVIADAS
    // TIPO = 1 - MENSAGENS RECEBIDAS
    function deletar($codigo, $tipo) {

        if ($tipo = 0) {
            $sql = "UPDATE BD_SICA.msg SET TRASH=1 WHERE ID IN(" . $codigo . ")";
            $query = $this->db->query($sql);
        } elseif ($tipo = 1) {
            $sql = "UPDATE BD_SICA.de_para SET TRASH=1 WHERE IDMSG IN(" . $codigo . ")";
            $query = $this->db->query($sql);
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // VERIFICA OS EMAILS DE ENTRADA
    function visualizar_mensagem($codigo) {
        $query = $this->db->query("SELECT ID,
       									  SUBJECT, 
       									  DE, 
       									  DATA, 
       									  CONTENT, 
       									  ANEXO,
										  TRASH,
										  SPAM,
										  ID_PAI,
       									  (SELECT nm_aluno FROM bd_sica.aluno WHERE TO_CHAR(cd_aluno) = MEN.DE) as aluno,
       									  (SELECT nm_professor FROM bd_sica.t_professor WHERE TO_CHAR(cd_professor) = MEN.DE) as professor,
       									  (SELECT nm_usuario FROM bd_sica.usuarios WHERE TO_CHAR(cd_usuario) = MEN.DE) as colaborador,
       									  (SELECT DISTINCT nm_responsavel FROM bd_sica.aluno_responsaveis WHERE cpf_responsavel = MEN.DE) as responsavel  
  									  FROM BD_SICA.msg MEN
 									 WHERE ID = '" . $codigo . "'");
        if ($query->num_rows() == 1) {

            $this->db->query("UPDATE BD_SICA.de_para SET STATUS = 'S' WHERE IDMSG = " . $codigo . "");

            return $query->result();
        } else {
            return false;
        }
    }

    // VERIFICA OS EMAILS DE ENTRADA
    function visualizar_pessoa($codigo) {
        $sql = "SELECT ID,
       									  IDMSG,
       									  PARA,
       									  STATUS,
       									  TRASH,
       									  FILTRADO,
       									  (SELECT nm_aluno FROM bd_sica.aluno WHERE TO_CHAR(cd_aluno) = DEST.PARA) as aluno ,
       									  (SELECT nm_professor FROM bd_sica.t_professor WHERE TO_CHAR(cd_professor) = DEST.PARA) as professor,
       									  (SELECT nm_usuario FROM bd_sica.usuarios WHERE TO_CHAR(cd_usuario) = DEST.PARA) as colaborador,
       									  (SELECT DISTINCT nm_responsavel FROM bd_sica.aluno_responsaveis WHERE cpf_responsavel = DEST.PARA AND ROWNUM = 1) as responsavel 
									 FROM BD_SICA.de_para DEST WHERE IDMSG = '" . $codigo . "'";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // VERIFICA OS EMAILS DE SAÃ�DA
    function mensagem_restrita($tipo) {

        $query = $this->db->query("SELECT ID, 
		                          SUBJECT, 
					  DE, 
					  TO_CHAR(DATA,'DD/MM/YYYY HH:MM:SS') as DATA, 
					  CONTENT, 
					  TRASH, 
					  ANEXO, 
					  SPAM, 
					  ID_PAI,
					  (SELECT COUNT(*) FROM BD_SICA.DE_PARA WHERE MEN.ID = IDMSG) AS pessoa
				     FROM BD_SICA.msg MEN 
				    WHERE SPAM = 1 ORDER BY ID DESC");

        if ($query->num_rows() > 0) {
            if ($tipo == 1) {
                // ENVIA A LISTA
                return $query->result();
            } elseif ($tipo == 2) {
                // ENVIA TOTAL DE LINHAS
                return $query->num_rows();
            } else {
                return false;
            }
        }
    }

    /**
     * Obtem a lista de professores para envio de mensagens.
     * 
     * @return string Retorna todos os professor dentro de tags options.
     */
    function professor() {
        $this->db->select("U.CD_USUARIO, P.NM_PROFESSOR");
        $this->db->from("BD_SICA.T_PROFESSOR P");
        $this->db->join("BD_SICA.USUARIOS U", "P.CD_PROFESSOR = U.CD_PROFESSOR");
        $this->db->where("U.ATIVO = 1");
        $this->db->where("P.CD_PROFESSOR <> 32");
        $this->db->order_by("P.NM_PROFESSOR");

        if ($this->session->userdata('SCL_SSS_USU_TIPO') == 20) {
            $this->db->where("CD_PROFESSOR <>", $this->session->userdata('SCL_SSS_USU_CODIGO'));
        }

        $query = $this->db->get();
        $result = $query->result();

        $contato = "";
        foreach ($result as $row) {
            $contato .= '<option value="' . $row->CD_USUARIO . '"> ' . $row->NM_PROFESSOR . '</option>';
        }

        return $contato;
    }

    // RELAÃ‡ÃƒO DE PROFESSORES PARA MENSAGEM
    function meus_professores($turma) {

        $query = $this->db->query("SELECT DISTINCT tur.cd_professor, nm_professor, telefone, email
  									 FROM bd_sica.cl_turma_professores tur
  									 JOIN bd_rh.vw_professor prf ON prf.cd_professor = tur.cd_professor
 									WHERE tur.cd_professor <> 32
   									  AND tur.cd_professor <> 34
   									  AND tur.cd_turma = '" . $turma . "' 
								 ORDER BY NM_PROFESSOR ASC");

        if ($query->num_rows() > 0) {
            $res = $query->result();
            $contato = '';
            foreach ($res as $rco) {
                $contato .= '<option value="' . $rco->CD_PROFESSOR . '"> ' . $rco->NM_PROFESSOR . '</option>';
            }
            return ($contato);
        } else {
            return false;
        }
    }

    // RELAÃ‡ÃƒO DE RESPONSÃ�VEIS PARA MENSAGEM
    function responsavel() {

        $query = $this->db->query("SELECT distinct cur.cd_curso, 
                                          NM_CURSO, 
                                          ser.ordem_serie
  				     FROM bd_sica.cursos cur,
       					  bd_sica.series ser,
       					  bd_sica.t_curso_user usr
 			   	   WHERE ser.cd_curso = cur.cd_curso
   				     AND cur.cd_curso = usr.cd_curso
   				     AND cur.cd_curso <> 19
			   	     AND usr.cd_usuario = " . $this->session->userdata('SCL_SSS_USU_CODIGO') . "
			        ORDER BY NM_CURSO DESC"); 

        if ($query->num_rows() > 0) {
            $resp = $query->result();
            $contato = '';

            foreach ($resp as $l) {

                $sql = $this->db->query("SELECT distinct 
                                                RES_CPF, 
                                                NM_RESPONSAVEL, 
                                                tur.CD_TURMA
                                           FROM bd_sica.aluno alu, 
                                                //bd_sica.matricula mat,
						//bd_sica.turma tur
                                          WHERE alu.tipo = 'C'
                                            AND alu.status IN(1,2)
                                            //AND mat.cd_aluno = alu.cd_aluno
					   // AND mat.cd_turma = tur.cd_turma
                                            AND alu.cd_curso = " . $l->CD_CURSO . "
					   // AND mat.periodo = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
                                       ORDER BY  NM_RESPONSAVEL DESC");
                $consulta = $sql->result();
                $contato .= '<optgroup id="optgroup" label="<i class=icon-double-angle-left></i> ' . $l->NM_CURSO . ' (' . $sql->num_rows() . ') <i class=icon-double-angle-right></i>">';
                foreach ($consulta as $rco) {
                    $contato .= '<option value="' . $rco->RES_CPF . '"><i class=icon-user></i> ' . $rco->CD_TURMA . ' - ' . $rco->NM_RESPONSAVEL . '</option>';
                }
                $contato .= '</optgroup>';
            }
            return ($contato);
        } else {
            return ('');
        }
    }

    // RELAÃ‡ÃƒO DE COLABORADORES PARA MENSAGEM
    function colaborador_curso() {
        if ($this->session->userdata('SCL_SSS_USU_TIPO') == 40)
            $comp = " AND usr.cd_usuario <> " . $this->session->userdata('SCL_SSS_USU_CODIGO') . "";
        else
            $comp = '';

        $query = $this->db->query("SELECT DISTINCT usr.cd_usuario,login, nm_usuario, funcao, cd_funcionario, email  
  									 FROM bd_sica.t_curso_user usr
  									 JOIN bd_sica.usuarios usu ON usu.cd_usuario = usr.cd_usuario
 									WHERE usr.internet = 'S' 
									  AND ativo = 1
									  " . $comp . "
									ORDER BY nm_usuario ASC");

        if ($query->num_rows() > 0) {
            $res = $query->result();
            $linha = '';
            foreach ($res as $r) {

                $nome = str_replace('DE', '', $r->NM_USUARIO);

                $nome = explode(' ', $nome);

                $linha .= '<option value="' . $r->CD_USUARIO . '">' . $nome[0] . ' ' . $nome[1] . ' - ' . $r->FUNCAO . '</option>';
            }
            return ($linha);
        } else {
            return false;
        }
    }

    // RELAÃ‡ÃƒO DE TURMAS
    function grupo_turma($tipo) {
        if ($this->session->userdata('SCL_SSS_USU_TIPO') == 40)
            $comp = " AND usr.cd_usuario = " . $this->session->userdata('SCL_SSS_USU_CODIGO') . "";
        else
            $comp = '';

        $query = $this->db->query("SELECT DISTINCT mat.cd_turma, nm_curso FROM bd_sica.t_curso_user usr
         							 JOIN bd_sica.aluno alu ON alu.cd_curso = usr.cd_curso
         						     JOIN bd_sica.matricula mat ON alu.cd_aluno = mat.cd_aluno
         							 JOIN bd_sica.cursos cur ON cur.cd_curso = usr.cd_curso
        							WHERE alu.tipo = 'C'
          							  AND alu.status IN(1,2)
									  " . $comp . "  
          							  AND mat.tipo = 'N'
        						 ORDER BY cd_turma ASC");

        if ($query->num_rows() > 0) {
            $res = $query->result();
            $linha = '';
            foreach ($res as $r) {
                $linha .= '<option value="' . $tipo . ':' . $r->CD_TURMA . '">' . $r->CD_TURMA . ' - ' . $r->NM_CURSO . '</option>';
            }
            return ($linha);
        } else {
            return false;
        }
    }

    // RELAÃ‡ÃƒO DE TURMAS
    function grupo_turma_professor($turma) {

        $query = $this->db->query("SELECT DISTINCT CD_TURMA
  									 FROM bd_sica.cl_turma_professores tur
                                     JOIN bd_rh.vw_professor prf ON prf.cd_professor = tur.cd_professor
                                    WHERE tur.cd_professor = " . $turma . "
        						 ORDER BY cd_turma ASC");

        if ($query->num_rows() > 0) {
            $res = $query->result();
            $linha = '';
            foreach ($res as $r) {
                $linha .= '<option value="' . $r->CD_TURMA . '">' . $r->CD_TURMA . '</option>';
            }
            return ($linha);
        } else {
            return false;
        }
    }

    // RELAÃ‡ÃƒO DE TURMAS
    function grupo_listar($turma, $tipo) {

        if ($tipo == 'ALU') {
            $sql = "SELECT DISTINCT alu.cd_aluno, alu.nm_aluno, alu.alu_email, alu_tel_cel
									  FROM bd_sica.t_curso_user usr
         							  JOIN bd_sica.aluno alu ON alu.cd_curso = usr.cd_curso
         							  JOIN bd_sica.matricula mat ON alu.cd_aluno = mat.cd_aluno
          						     WHERE alu.tipo = 'C' 
            						   AND alu.status IN(1,2)     
                                       AND mat.tipo = 'N' 
									   AND mat.cd_turma = '" . $turma . "'
									   AND mat.periodo = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
          						  ORDER BY nm_aluno ASC";
        } elseif ($tipo == 'RES') {
            $sql = "SELECT DISTINCT res_cpf, nm_responsavel, alu.res_email, res_tel_cel
									  FROM bd_sica.t_curso_user usr
         							  JOIN bd_sica.aluno alu ON alu.cd_curso = usr.cd_curso
         							  JOIN bd_sica.matricula mat ON alu.cd_aluno = mat.cd_aluno
          						     WHERE alu.tipo = 'C' 
            						   AND alu.status IN(1,2)
                                       AND mat.tipo = 'N' 
									   AND mat.cd_turma = '" . $turma . "'
									   AND mat.periodo = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
          						  ORDER BY nm_responsavel ASC";
        }


        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $res = $query->result();
            $linha = '';
            if ($tipo == 'ALU') {
                foreach ($res as $r) {
                    $linha .= '<option value="' . $r->CD_ALUNO . '">' . $r->NM_ALUNO . '</option>';
                }
                return ($linha);
            } elseif ($tipo == 'RES') {
                foreach ($res as $r) {
                    $linha .= '<option value="' . $r->RES_CPF . '">' . $r->NM_RESPONSAVEL . '</option>';
                }
                return ($linha);
            }
        } else {
            return false;
        }
    }

// RELAÃ‡ÃƒO DE COLABORADORES PARA MENSAGEM
    function grupo($tipo) {

        switch ($tipo) {
            // DESTINATÃ�RIOS PARA O ALUNO
            case 10:
                $linha = '<option value=""></option>';
                $linha .= '<option value="1" class="alert alert-block alert-info">MINHA TURMA</option>';
                $linha .= '<option value="5" class="alert alert-block alert-info">MEUS PROFESSORES</option>';
                $linha .= '<option value="3" class="alert alert-block alert-info">COLABORADORES</option>';
                return ($linha);
                break;
            // DESTINATÃ�RIOS PARA O PROFESSOR
            case 30:
                //VISUAL DO COLABORADOR
                $linha = '<option value=""></option>';
                $linha .= '<option value="2" class="alert alert-block alert-info">PROFESSORES</option>';
                $linha .= '<option value="3" class="alert alert-block alert-info">COLABORADORES</option>';
                $linha .= '<option value="6" class="alert alert-block alert-info">TURMAS</option>';
                $linha .= '<optgroup label="ALUNOS" class="alert alert-block alert-success">';
                $linha .= $this->mensagem->grupo_turma_professor($this->session->userdata('SCL_SSS_USU_CODIGO'));
                $linha .= '</optgroup>';
                return ($linha);
                break;
            // DESTINATÃ�RIOS PARA O RESPONSAVEL
            case 20:
                //VISUAL DO COLABORADOR
                $linha = '<option value=""></option>';
                $linha .= '<option value="3">Colaboradores</option>';
                return ($linha);

                break;
            case 40: // DESTINATÃ�RIOS PARA O COLABORADOR
                //VISUAL DO COLABORADOR
                $linha = '<option value=""></option>';
                $linha .= '<option value="3" class="alert alert-block alert-info">COLABORADORES</option>';

                if ($this->session->userdata('SCL_SSS_USU_ID') <> 'WJR') {
                    $linha .= '<option value="2" class="alert alert-block alert-info">PROFESSORES</option>';
                    $linha .= '<option value="4" class="alert alert-block alert-info">TURMAS - ALUNOS</option>';
                    $linha .= '<option value="7" class="alert alert-block alert-info">TURMAS - RESPONSÁVEIS</option>';
                    $linha .= '<optgroup label="ALUNOS" class="alert alert-block alert-success">';
                    $linha .= $this->mensagem->grupo_turma('ALU');
                    $linha .= '</optgroup>';
                    $linha .= '<optgroup label="RESPONSAVEIS" class="alert alert-block alert-warning">';
                    $linha .= $this->mensagem->grupo_turma('RES');
                    $linha .= '</optgroup>';
                }
                return ($linha);
                break;
        }
    }

}
