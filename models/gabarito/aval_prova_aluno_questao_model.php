<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aval_Prova_Aluno_Questao_model extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->table = "BD_SICA.AVAL_PROVA_ALUNO_QUESTAO";
        $this->view = "BD_SICA.VW_AVAL_PROVA_ALUNO_QUESTAO";
    }

    /**
     * Retorna os dados quanto a posicao das alternativas na versão da prova
     * do aluno.
     * 
     * @param int $prova Código da versão de prova do aluno
     * @param int $questao Código da questão
     * 
     * @return object[]
     */
    public function opcoes($prova, $questao) {
        $this->db->select('QO.CD_QUESTAO,
                          QO.CD_OPCAO,
                          QO.DC_OPCAO,
                          QO.CD_USU_CADASTRO,
                          QO.DT_CADASTRO,
                          QO.TIPO,
                          QO.FLG_CORRETA,
                          PO.POSICAO');
        $this->db->from('BD_ACADEMICO.AVAL_QUESTAO_OPCAO QO');

        $this->db->join('BD_SICA.AVAL_PROVA_QUESTOES_OPCAO PO', 'QO.CD_QUESTAO = PO.CD_QUESTAO '
                . 'AND QO.CD_OPCAO = PO.CD_OPCAO '
                . 'AND PO.CD_PROVA = ' . $prova, 'left');

        $this->db->where('QO.CD_QUESTAO', $questao);

        $this->db->order_by('PO.POSICAO', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }

}
