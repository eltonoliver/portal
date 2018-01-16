<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Diario_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function sp_diario($parametro) {
        //   print_r($parametro);
        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':CD_PROFESSOR', 'value' => $parametro['cd_professor']),
            array('name' => ':DIA', 'value' => $parametro['dia']),
            array('name' => ':CD_CL_AULA', 'value' => $parametro['cl_aula']),
            array('name' => ':CD_DISCIPLINA', 'value' => $parametro['cd_disciplina']),
            array('name' => ':CD_CURSO', 'value' => $parametro['cd_curso']),
            array('name' => ':CD_TURMA', 'value' => $parametro['cd_turma']),
            array('name' => ':SUBTURMA', 'value' => $parametro['subturma']),
            array('name' => ':CD_ALUNO', 'value' => $parametro['cd_aluno']),
            array('name' => ':PRESENCA', 'value' => $parametro['frequencia']),
            array('name' => ':CD_PLANO', 'value' => $parametro['cd_plano']),
            array('name' => ':CONTEUDO', 'value' => $parametro['conteudo']),
            array('name' => ':TAREFA', 'value' => $parametro['tarefa']),
            array('name' => ':DATA', 'value' => $parametro['data']),
            array('name' => ':ORDEM_SERIE', 'value' => $parametro['serie']),
            array('name' => ':OPCAO', 'value' => $parametro['opcao']),
            array('name' => ':P_HR_ABERTURA', 'value' => $parametro['hr_abertura']),
            array('name' => ':P_HR_FECHAMENTO', 'value' => $parametro['hr_fechamento']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->sp_seculo('BD_PORTAL', 'AES_DIARIO_ONLINE', $params);
    }

    public function sp_notas($parametro) {
        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':CD_DISCIPLINA', 'value' => $parametro['cd_disciplina']),
            array('name' => ':PERIODO', 'value' => $parametro['periodo']),
            array('name' => ':CD_PROFESSOR', 'value' => $parametro['cd_professor']),
            array('name' => ':CD_TURMA', 'value' => $parametro['cd_turma']),
            array('name' => ':CD_CURSO', 'value' => $parametro['cd_curso']),
            array('name' => ':NUM_NOTA', 'value' => $parametro['num_nota']),
            array('name' => ':CD_ESTRUTURA', 'value' => $parametro['cd_estrutura']),
            array('name' => ':BIMESTRE', 'value' => $parametro['bimestre']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_DIARIO_NOTAS', $params);
    }

    public function checa_notas(){

      // 
    }

  
    public function texto_data_lancamento($parametro){
        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $parametro['operacao']),    
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PORTAL', 'AES_DIARIO_NOTAS', $params);
        
        
    }

      /*Exibe data de inicio e fim de lancamento*/
    public function texto_data_lancamento_query(){

       $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');

       $dados = $this->db->query('
            SELECT  \'Lançamento liberado para iniciar em: \'  || TO_CHAR(dt_inicio_lan_notas,\'DD/MM/YYYY\') as
                     txt_dt_inicio_lan_notas FROM (
                     SELECT B.dt_inicio_lan_notas FROM BD_PAJELA.PJ_CL_BIMESTRE B
                     WHERE periodo =\''.$periodo.'\'
                     AND TRUNC(dt_inicio_lan_notas) >= TRUNC(SYSDATE)
                     AND  NOT EXISTS(SELECT 1 FROM BD_PAJELA.PJ_CL_BIMESTRE X  WHERE X.periodo = B.periodo AND TRUNC(SYSDATE) BETWEEN X.DT_INICIO_LAN_NOTAS AND X.DT_FIM_LAN_NOTAS)
                     ORDER BY B.bimestre
                     ) WHERE ROWNUM <= 1

                     union all

                     SELECT  \'Lançamento encerra em: \'  || to_char(DT_FIM_LAN_NOTAS,\'DD/MM/YYYY\') as txt_dt_inicio_lan_notas 
                  FROM (
                       SELECT B.DT_FIM_LAN_NOTAS FROM BD_PAJELA.PJ_CL_BIMESTRE B
                       WHERE periodo =\''.$periodo.'\'              
                       AND TRUNC(SYSDATE) BETWEEN b.DT_INICIO_LAN_NOTAS AND b.DT_FIM_LAN_NOTAS
                       ORDER BY B.bimestre
                       ) WHERE ROWNUM <= 1


          ');

       return $dados;

    }

    /*
      Model retorna valores 1 e 0 - 1 Habilita botão e 0 desabilita
      Tela : Lançar Conteúdo de Prova
    */
    public function desabilita_botao(){

        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        return $this->db->query('

                 SELECT 1 FROM BD_PAJELA.PJ_CL_BIMESTRE B
                 WHERE B.periodo =\''.$periodo.'\'
                 AND TRUNC(SYSDATE) BETWEEN B.DT_INICIO_LAN_NOTAS AND B.DT_FIM_LAN_NOTAS
          ');

    }

  

    public function sp_notas_registro($p) {
        $cursor = '';
        $params = array(
            array('name' => ':P_PERIODO', 'value' => $this->session->userdata('SCL_SSS_USU_PERIODO')),
            array('name' => ':P_CD_TURMA', 'value' => $p['turma']),
            array('name' => ':p_CD_ALUNO', 'value' => $p['aluno']),
            array('name' => ':P_NOTA', 'value' => $p['nota'])
        );
        return $this->db->sp_seculo('BD_SICA', 'REGISTRANOTA', $params);
    }

    // INSERINDO O PLANO DE ENSINO NO BANCO 
    function confirmar_nota($aluno, $numero_nota, $nota, $turma) {
        $sql_aluno = "SELECT * FROM bd_sica.cl_alu_nota WHERE CD_ALU_DISC = " . $aluno . " AND NUM_NOTA = " . $numero_nota . "";
        $consulta = $this->db->query($sql_aluno)->num_rows();
        if ($consulta == 0) {
            if ($nota != '') {
            $sql = "INSERT INTO bd_sica.cl_alu_nota(CD_ALU_DISC,NUM_NOTA,NOTA)VALUES(
								" . $aluno . ",
								" . $numero_nota . ",
								" . $nota . ")";
            $query = $this->db->query($sql);
            if ($query == true) {
                $this->sp_notas_registro($p = array('aluno' => $aluno, 'turma' => $turma, 'nota' => $numero_nota));
                return true;
            } else {
                return false;
            }
          }
        } else {
            if ($nota != '') {
                $sql = "UPDATE bd_sica.cl_alu_nota SET NOTA = " . $nota . " WHERE CD_ALU_DISC = " . $aluno . " AND NUM_NOTA = " . $numero_nota . "";
                $query = $this->db->query($sql);
                if ($query == true) {
                    $this->sp_notas_registro($p = array('aluno' => $aluno, 'turma' => $turma, 'nota' => $numero_nota));
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    function ins_nota_dissertativa($param) {
        $sql = "UPDATE BD_SICA.AVAL_PROVA_ALUNO
                   SET TOTAL_PONTOS_DISSERTATIVAS = " . $param['nota'] . " 
                 WHERE CD_PROVA = " . $param['cd_prova'] . " 
                   AND CD_ALUNO = '" . $param['cd_aluno'] . "'";
        $this->db->query($sql);
    }
    
    function ins_nota_discursiva($param){
        
        $sql = "UPDATE BD_SICA.AVAL_PROVA_ALUNO_DISC 
                   SET NR_NOTA_DISCURSIVA = " . $param['nota'] . " 
                 WHERE CD_PROVA = " . $param['cd_prova'] . "
                   AND CD_DISCIPLINA = '".$param['cd_disciplina']."'
                   AND CD_ALUNO = '" . $param['cd_aluno'] . "'";
        $this->db->query($sql);


        /*$sql = "UPDATE BD_SICA.AVAL_PROVA_ALUNO_DISC 
                   SET NR_NOTA_DISCURSIVA = " . $param['nota'] . " 
                 WHERE CD_PROVA = " . $param['cd_prova'] . "
                 
                   AND CD_ALUNO = '" . $param['cd_aluno'] . "'";
        $this->db->query($sql);*/


    }

    function get_cd_aula($dados) {
        $sql = " SELECT CD_CL_AULA FROM BD_PAJELA.PJ_CL_AULA
                    WHERE PERIODO = '" . $dados['periodo'] . "'
                      AND CD_TURMA = '" . $dados['cd_turma'] . "'
                      AND CD_DISCIPLINA = " . $dados['cd_disciplina'] . "
                      AND TO_DATE(DT_AULA) = TO_DATE('" . $dados['data'] . "', 'DD/MM/YYYY')
                      AND TEMPO_AULA = " . $dados['tempo'] . "  ";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    //retorna as notas objetivas da prova
    function notas_objetivas($dados) {
         $sql = "SELECT  * 
                  FROM BD_SICA.VW_AVAL_PROVA_ALUNO_DISC
                 WHERE PERIODO = '" . $dados['periodo'] . "'
                   AND CD_TURMA = '" . $dados['cd_turma'] . "'
                   AND NUM_NOTA = " . $dados['numero_nota'] . "
                   AND CD_DISCIPLINA = " . $dados['cd_disciplina'] . "
                   AND NVL(LIB_NOTA,0) = 1
                       AND NR_NOTA > 0
                ORDER BY NM_ALUNO";
        return $this->db->query($sql)->result();
    }

    //analisar o porque nao estar funcionado com a SP
    function listar_aluno($parametro) {

        $sql = "SELECT ALD.PERIODO,
       AL.CD_CURSO,
       AL.ORDEM_SERIE,
       PV.CD_ESTRUTURA,
       AL.CD_ALUNO, 
       AL.NM_ALUNO, 
       ALD.CD_ALU_DISC,
       ALD.CD_DISCIPLINA,
       ALD.CD_TURMA,
       ALD.SUBTURMA,
       PV.NUM_NOTA,
       PV.CD_PROVA,
       PV.TOTAL_PONTOS,       
       PV.TOTAL_PONTOS_DISSERTATIVAS AS NOTA_DISSERTATIVA,
       (SELECT NOTA FROM BD_SICA.CL_ALU_NOTA WHERE CD_ALU_DISC = ALD.CD_ALU_DISC AND NUM_NOTA = " . $parametro['numero_nota'] . " ) NOTA,
       AL.TIPO,
       AL.STATUS
  FROM BD_SICA.CL_ALU_DISC ALD
  JOIN BD_SICA.ALUNO AL ON ALD.CD_ALUNO = AL.CD_ALUNO
  LEFT JOIN ( SELECT PA.CD_PROVA,
                     PA.CD_ALUNO,
                      P.PERIODO,
                      P.CD_ESTRUTURA,
                      A.TURMA_ATUAL AS CD_TURMA,
                      P.CD_CURSO,
                      P.NUM_NOTA,
                      PD.CD_DISCIPLINA,
                      TOTAL_PONTOS_DISSERTATIVAS,
                      PA.TOTAL_PONTOS
                 FROM BD_SICA.AVAL_PROVA_ALUNO PA 
                 JOIN BD_SICA.AVAL_PROVA P ON P.CD_PROVA = PA.CD_PROVA
                 JOIN BD_SICA.AVAL_PROVA_DISC PD ON P.CD_PROVA = PD.CD_PROVA AND PD.TIPO_QUESTAO = 'O'
                 JOIN BD_SICA.ALUNO A ON A.CD_ALUNO = PA.CD_ALUNO
                 ) PV ON  PV.PERIODO = ALD.PERIODO  
                    AND PV.CD_TURMA = ALD.CD_TURMA
                    AND PV.CD_CURSO = AL.CD_CURSO 
                    AND PV.NUM_NOTA = " . $parametro['numero_nota'] . "
                    AND PV.CD_DISCIPLINA = ALD.CD_DISCIPLINA
                    AND PV.CD_ALUNO = AL.CD_ALUNO
                 WHERE ALD.PERIODO = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
                   AND ALD.CD_TURMA = '" . $parametro['cd_turma'] . "'
                   AND ALD.CD_DISCIPLINA = " . $parametro['cd_disciplina'] . "
                   AND AL.CD_CURSO = " . $parametro['cd_curso'] . "
    --               AND al.status = 1
                ORDER BY AL.NM_ALUNO";
        // echo $sql;
        /* $sqlA = "SELECT ald.cd_alu_disc, 
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
          WHERE pla.cd_professor = " . $parametro['cd_professor'] . "
          AND pla.cd_disciplina =  ald.cd_disciplina
          AND pla.cd_curso =  alu.cd_curso
          AND pla.periodo =  ald.periodo) AS plano,
          ald.cd_situacao,
          ace.flg_passagem,
          nota.NOTA,
          nota.NUM_NOTA,
          TESTE.TOTAL_PONTOS_DISSERTATIVAS AS NOTA_DISSERTATIVA,
          TESTE.CD_PROVA
          FROM bd_sica.cl_alu_disc ald
          JOIN bd_sica.aluno alu ON ald.cd_aluno = alu.cd_aluno
          LEFT JOIN bd_catraca.ct_acesso ace ON ald.cd_aluno = ace.cd_usuario AND ace.flg_passagem = 'E'
          AND TO_CHAR(ace.dt_hr_acesso,'DD/MM/YYYY') = '" . date('d/m/Y') . "'
          LEFT JOIN bd_sica.cl_alu_nota nota ON nota.cd_alu_disc = ald.cd_alu_disc
          AND nota.NUM_NOTA = " . $parametro['numero_nota'] . "
          LEFT JOIN (
          SELECT PA.CD_PROVA,PA.CD_ALUNO,P.PERIODO,A.TURMA_ATUAL AS CD_TURMA,P.CD_CURSO,P.NUM_NOTA,
          PD.CD_DISCIPLINA,TOTAL_PONTOS_DISSERTATIVAS
          FROM BD_SICA.AVAL_PROVA_ALUNO PA
          INNER JOIN BD_SICA.AVAL_PROVA P
          ON P.CD_PROVA = PA.CD_PROVA
          INNER JOIN BD_SICA.AVAL_PROVA_DISC PD
          ON P.CD_PROVA = PD.CD_PROVA AND PD.TIPO_QUESTAO = 'D'
          INNER JOIN BD_SICA.AVAL_TIPO_PROVA TP
          ON TP.CD_TIPO_PROVA = P.CD_TIPO_PROVA
          INNER JOIN BD_SICA.ALUNO A
          ON A.CD_ALUNO = PA.CD_ALUNO
          INNER JOIN BD_SICA.CURSOS C
          ON P.CD_CURSO = C.CD_CURSO
          LEFT JOIN BD_SICA.MATRICULA M
          ON A.CD_ALUNO = M.CD_ALUNO AND M.TIPO = 'N' AND M.PERIODO = P.PERIODO
          LEFT JOIN BD_SICA.SERIES S
          ON A.ORDEM_SERIE = S.ORDEM_SERIE AND A.CD_CURSO = S.CD_CURSO
          ) TESTE ON  TESTE.PERIODO = ald.PERIODO
          AND TESTE.CD_TURMA = ald.cd_turma
          AND TESTE.CD_CURSO = alu.CD_CURSO
          AND TESTE.NUM_NOTA = nota.NUM_NOTA
          AND TESTE.CD_DISCIPLINA = ald.cd_disciplina
          AND TESTE.cd_aluno = alu.CD_ALUNO
          WHERE ald.periodo = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
          AND ald.cd_turma = '" . $parametro['cd_turma'] . "'
          AND ald.cd_disciplina = '" . $parametro['cd_disciplina'] . "'
          AND alu.cd_curso = '" . $parametro['cd_curso'] . "'
          AND alu.tipo = 'C'
          AND alu.status = 1
          ORDER BY alu.nm_aluno ASC"; */

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            /* pega os alunos da turma mista */
            $sql = "SELECT alux.cd_alu_disc,  alu.cd_aluno,alu.nm_aluno, alux.periodo, mix.cd_turma_mista as cd_turma, 
                                        alux.cd_disciplina,alux.faltas_1b,alux.faltas_2b, alux.faltas_3b,  alux.faltas_4b, 
                                        (SELECT cd_plano FROM bd_sica.cl_plano_ensino pla 
                                                WHERE pla.cd_professor = " . $parametro['cd_professor'] . "  
                                                AND pla.cd_disciplina = alux.cd_disciplina 
                                                AND pla.cd_curso = alu.cd_curso 
                                                AND pla.periodo = alux.periodo
                                                AND rownum = 1) AS plano,
                                        alux.cd_situacao,ace.flg_passagem,nota.NOTA, nota.NUM_NOTA                                     
                                      FROM bd_sica.cl_alu_disc_turma_mista mix
                                        JOIN bd_sica.cl_disciplina dix ON mix.cd_disciplina = dix.cd_disciplina
                                        JOIN bd_sica.cl_alu_disc alux ON alux.cd_alu_disc = mix.cd_alu_disc
                                        LEFT JOIN bd_sica.cl_alu_nota nota ON nota.cd_alu_disc = alux.cd_alu_disc 
                                              AND nota.NUM_NOTA = " . $parametro['numero_nota'] . " 
                                        LEFT JOIN bd_catraca.ct_acesso ace ON alux.cd_aluno = ace.cd_usuario 
                                            AND ace.flg_passagem = 'E' 
                                            AND TO_CHAR(ace.dt_hr_acesso,'DD/MM/YYYY') = '" . date('d/m/Y') . "'      
                                            JOIN bd_sica.aluno alu ON alu.cd_aluno = alux.cd_aluno 
                                           WHERE alux.periodo = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
                                                     AND mix.cd_turma_mista = '" . $parametro['cd_turma'] . "'
                                             AND alu.tipo = 'C' 
                                             AND alu.status = 1";
            if ($parametro['todos'] == 'N') {

                $sql .= "AND  EXISTS(
                                                    SELECT A.CD_ALUNO FROM BD_SICA.CL_TURMA_DETALHES TD
                                                        INNER JOIN BD_SICA.ALUNO A ON TD.CD_TURMA = A.TURMA_ATUAL
                                                         WHERE TD.PERIODO = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
                                                             AND CD_ESTRUTURA = " . $parametro['estrutura'] . "
                                                             AND A.CD_ALUNO = ALUX.CD_ALUNO
                                                 )";
            }
            $sql .= "ORDER BY alu.nm_aluno ASC";

            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
        }
    }

    function inserir_nota_arquivo($dados) {
        $sql = "INSERT INTO BD_SICA.CL_ALU_NOTA_ANEXO(CD_ALU_DISC,NUM_NOTA,DS_ANEXO,CD_PROFESSOR,DT_ANEXO)
                VALUES(" . $dados['CD_ALU_DISC'] . "," . $dados['NUM_NOTA'] . ",'" . $dados['DS_ANEXO'] . "'," . $dados['CD_PROFESSOR'] . ",SYSDATE)";

        return $this->db->query($sql);
    }

    function lista_arquivo($cd_alu_disc, $num_nota) {
        $sql = "SELECT ID, DS_ANEXO, DT_ANEXO FROM BD_SICA.CL_ALU_NOTA_ANEXO WHERE CD_ALU_DISC = " . $cd_alu_disc . " AND NUM_NOTA = " . $num_nota;
        return $this->db->query($sql);
    }

    function deletar_arquivo($codigo) {
        $img = "SELECT CD_ALU_DISC,DS_ANEXO FROM BD_SICA.CL_ALU_NOTA_ANEXO WHERE ID = " . $codigo;
        $delimg = $this->db->query($img)->result();
        $sql = "DELETE FROM BD_SICA.CL_ALU_NOTA_ANEXO WHERE ID = " . $codigo;
        $query = $this->db->query($sql);
        if ($query == TRUE) {
            $PathImg = $_SERVER['DOCUMENT_ROOT'] . '/portal/application/upload/nota/' . $delimg[0]->CD_ALU_DISC . "/" . $delimg[0]->DS_ANEXO;
            unlink($PathImg);
            return TRUE;
        } else {
            return false;
        }
    }

    function lista_conteudo_aula($dados) {
        $sql = "SELECT DT_AULA, CD_CL_AULA, PERIODO, CONTEUDO, TAREFA_CASA, CD_TURMA, TEMPO_AULA
                FROM BD_PAJELA.PJ_CL_AULA
              WHERE CD_TURMA = '" . $dados['cd_turma'] . "'
                    AND CD_PROFESSOR = " . $dados['cd_professor'] . "
                    AND PERIODO = '" . $this->session->userdata('SCL_SSS_USU_PERIODO') . "'
                    AND CD_DISCIPLINA = " . $dados['disc'] . "
                    AND (CONTEUDO IS NOT NULL OR TAREFA_CASA IS NOT NULL)    
                ORDER BY DT_AULA DESC";

        //  echo $sql;
        return $this->db->query($sql);
    }

    /**
     * Verifica se o professor lançou o conteudo ministrado
     * 
     * @param int $aula Codigo da aula
     * 
     * @return TRUE caso tenha lançado o conteudo ministrado. FALSE caso 
     * contrário.
     */
    function hasConteudoLancado($aula) {
        $paramsConteudoEscrito = array(
            'operacao' => 'LCT',
            'cl_aula' => $aula,
        );

        $conteudo = $this->diario->sp_diario($paramsConteudoEscrito);
        return !empty($conteudo[0]['CONTEUDO']);
    }

    /**
     * Procedure para salvar o conteudo de prova e listar quais conteudos
     * foram lançados.
     * 
     * Operações:
     * 
     * I - Insere um novo conteudo
     * E - Editar um existente
     * L - Listar todos os existentes
     */
    function aes_prova_agendamento($dados) {
        $cursor = "";
        $params = array(
            array("name" => ":P_OPERACAO", "value" => $dados['operacao']),
            array("name" => ":P_ID_PROVA_CONTEUDO", "value" => $dados['codigo_prova']),
            array("name" => ":P_PERIODO", "value" => $dados['periodo']),
            array("name" => ":P_BIMESTRE", "value" => $dados['bimestre']),
            array("name" => ":P_CD_TIPO_NOTA", "value" => $dados['tipo_nota']),
            array("name" => ":P_CD_DISCIPLINA", "value" => $dados['disciplina']),
            array("name" => ":P_DT_PROVA", "value" => $dados['data_prova']),
            array("name" => ":P_DT_INICIO", "value" => $dados['data_inicio']),
            array("name" => ":P_DT_FIM", "value" => $dados['data_fim']),
            array("name" => ":P_FL_WEB", "value" => $dados['flag']),
            array("name" => ":P_CD_TURMA", "value" => $dados['turma']),
            array("name" => ":P_CONTEUDO", "value" => $dados['conteudo']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->procedure("BD_ACADEMICO", "AES_PROVA_AGENDAMENTO", $params);
    }

    /**
     * Executa uma procedure para retornar o horário do professor.
     * SP: bd_rh.sp_col_relat_horario_professor
     * @param array $dados Os parametros para executar a procedure.
     * 
     */
    function horario($dados) {
        $cursor = "";
        $params = array(
            array("name" => ":P_CD_PROFESSOR", "value" => $dados["cd_professor"]),
            array("name" => ":P_DT_INICIO", "value" => $dados["dt_inicio"]),
            array("name" => ":P_DT_FIM", "value" => $dados["dt_fim"]),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->procedure('BD_RH', "SP_COL_RELAT_HORARIO_PROFESSOR", $params);
    }

}
