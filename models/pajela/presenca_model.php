<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Presenca_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('pajela/aula_model', 'aula', true);
    }

    /**
     * Verifica se para uma determinada aula foi realizada a chamada.
     * 
     * @param int $aula
     * @return boolean TRUE quando foi realizada chamada. FALSE caso contrário.
     */
    public function hasChamadaRealizada($aula) {
        $this->db->from("BD_PAJELA.PJ_CL_PRESENCA");
        $this->db->where("CD_CL_AULA", $aula);
        $result = $this->db->count_all_results() > 0;
        return $result;
    }

    /**
     * Exibe a lista de frequência dos alunos de turma normais.
     * 
     * @param int $aula
     * @return array
     */
    public function listaFrequenciaNormal($aula) {
        $this->db->select("AU.CD_CL_AULA, 
            AL.CD_ALUNO, 
            AL.NM_ALUNO, 
            NVL(PR.FLG_PRESENTE, BD_PAJELA.F_PASSOU_PELA_CATRACA(P_CD_USUARIO => AL.CD_ALUNO, P_DT_BASE=> AU.DT_AULA, P_CD_UNIDADE=>NULL)) FLG_PRESENTE"
                , false
        );
        $this->db->from("BD_PAJELA.PJ_CL_AULA AU");
        $this->db->join("BD_SICA.CL_ALU_DISC AD", "AU.PERIODO = AD.PERIODO "
                . "AND AU.CD_DISCIPLINA = AD.CD_DISCIPLINA "
                . "AND AU.CD_TURMA = AD.CD_TURMA");
        $this->db->join("BD_SICA.ALUNO AL", "AD.CD_ALUNO = AL.CD_ALUNO");
        $this->db->join("BD_PAJELA.PJ_CL_PRESENCA PR", "PR.CD_CL_AULA = AU.CD_CL_AULA "
                . "AND PR.CD_ALUNO = AL.CD_ALUNO", "LEFT");
        $this->db->where("AU.CD_CL_AULA", $aula);
        $this->db->where_in("AL.STATUS", array(1, 2));
        $this->db->order_by("AL.NM_ALUNO");

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Exibe a lista de frequência dos alunos de turma mista.
     * 
     * @param int $aula
     * @return array
     */
    public function listaFrequenciaMista($aula) {
        $this->db->select("AU.CD_CL_AULA, 
            AL.CD_ALUNO, 
            AL.NM_ALUNO, 
            NVL(PR.FLG_PRESENTE, BD_PAJELA.F_PASSOU_PELA_CATRACA(P_CD_USUARIO => AL.CD_ALUNO, P_DT_BASE=> AU.DT_AULA, P_CD_UNIDADE=>NULL)) FLG_PRESENTE"
                , false
        );
        $this->db->from("BD_PAJELA.PJ_CL_AULA AU");
        $this->db->join("BD_SICA.CL_ALU_DISC_TURMA_MISTA ADTM", "ADTM.CD_DISCIPLINA = AU.CD_DISCIPLINA "
                . "AND ADTM.CD_TURMA_MISTA = AU.CD_TURMA "
                . "AND ADTM.PERIODO = AU.PERIODO");
        $this->db->join("BD_SICA.CL_ALU_DISC AD", "AD.CD_ALU_DISC = ADTM.CD_ALU_DISC");
        $this->db->join("BD_SICA.ALUNO AL", "AD.CD_ALUNO = AL.CD_ALUNO");
        $this->db->join("BD_PAJELA.PJ_CL_PRESENCA PR", "PR.CD_CL_AULA = AU.CD_CL_AULA "
                . "AND PR.CD_ALUNO = AL.CD_ALUNO", "LEFT");
        $this->db->where("AU.CD_CL_AULA", $aula);
        $this->db->where_in("AL.STATUS", array(1, 2));
        $this->db->order_by("AL.NM_ALUNO");

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Adiciona um registro de frequencia dos alunos informados por parametros.
     * Se a aula informada tiver tempos geminados será registrada a frequência 
     * em todas as aulas.
     * 
     * @param int $aula
     * @param array $alunos Vetor com chaves e valores no seguinte formato:      
     * array(
     *      array(
     *          'CD_ALUNO' => <int>
     *          'FLG_PRESENTE' => <string>
     *      )
     * )
     * @param boolean $checkGeminado
     */
    public function adicionar($aula, $alunos, $checkGeminado = true) {
        $geminados = $this->aula->listaAulasGeminada($aula);

        //verificar quantas aulas possuiram chamada
        $aulas = array();
        if (count($geminados) > 0 && $checkGeminado) {
            foreach ($geminados as $row) {
                $aulas[] = $row['CD_CL_AULA'];
            }
        } else {
            $aulas[] = $aula;
        }

        //montar os valores do SQL
        $params = array();
        foreach ($alunos as $aluno) {
            foreach ($aulas as $aula) {
                $aux = array(
                    'CD_CL_AULA' => $aula,
                    'CD_ALUNO' => $aluno['CD_ALUNO'],
                    'FLG_PRESENTE' => $aluno['FLG_PRESENTE']
                );
                $params[] = $aux;
            }
        }

        return $this->db->insert_batch("BD_PAJELA.PJ_CL_PRESENCA", $params) !== false;
    }

    /**
     * Atualiza a frequencia dos alunos informados. Se a aula informada tiver
     * tempos geminados, todas aulas serão atualizadas.
     * 
     * @param int $aula
     * @param array $alunos Vetor com chaves e valores no seguinte formato:
     * array(
     *      'CD_ALUNO' => <int>
     *      'FLG_PRESENTE' => <string>
     * )
     * @param boolean $checkGeminado
     */
    public function editar($aula, $alunos, $checkGeminado = true) {
        $geminados = $this->aula->listaAulasGeminada($aula);

        //verificar quantas aulas possuiram chamada
        $aulas = array();
        if (count($geminados) > 0 && $checkGeminado) {
            foreach ($geminados as $row) {
                $aulas[] = $row['CD_CL_AULA'];
            }
        } else {
            $aulas[] = $aula;
        }

        $this->db->trans_start();
        //atualizar os valores
        foreach ($alunos as $aluno) {
            foreach ($aulas as $aula) {
                $this->db->where(array(
                    'CD_CL_AULA' => $aula,
                    'CD_ALUNO' => $aluno['CD_ALUNO']
                ));

                $this->db->update("BD_PAJELA.PJ_CL_PRESENCA", array(
                    'FLG_PRESENTE' => $aluno['FLG_PRESENTE']
                ));
            }
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

}
