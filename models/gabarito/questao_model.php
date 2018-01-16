<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Questao_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function tema($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',        'value' => $p['operacao']),
            array('name' => ':P_CD_TEMA',         'value' => $p['codigo']),
            array('name' => ':P_CD_CURSO',        'value' => $p['curso']),
            array('name' => ':P_ORDEM_SERIE',     'value' => $p['serie']),
            array('name' => ':P_CD_DISCIPLINA',   'value' => $p['disciplina']),
            array('name' => ':P_DC_TEMA',         'value' => $p['descricao']),
            array('name' => ':P_FLG_ATIVO',       'value' => $p['ativo']),
            array('name' => ':P_CD_USU_CADASTRO', 'value' => $this->session->userdata('CES_CODIGO') ),
            array('name' => ':P_CURSOR',          'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_MANTER_TEMA', $params);
    }
    
    function conteudo($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $p['operacao']),
            array('name' => ':P_CD_TEMA', 'value' => $p['tema']),
            array('name' => ':P_CD_CONTEUDO', 'value' => $p['codigo']),
            array('name' => ':P_DC_CONTEUDO', 'value' => $p['descricao']),
            array('name' => ':P_CD_USUARIO', 'value' => $this->session->userdata('CES_CODIGO')),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_MANTER_CONTEUDO',$params);        
    }
    
    function questao($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',          'value' => $p['operacao']),
            array('name' => ':P_CD_QUESTAO',        'value' => $p['codigo']),
            array('name' => ':P_CD_CURSO',          'value' => $p['curso']),
            array('name' => ':P_ORDEM_SERIE',       'value' => $p['serie']),
            array('name' => ':P_FLG_TIPO',          'value' => $p['tipo']),
            array('name' => ':P_DC_QUESTAO',        'value' => $p['descricao']),
            array('name' => ':P_DC_QUESTAO_RODAPE', 'value' => $p['rodape']),
            array('name' => ':P_CD_DISCIPLINA',     'value' => $p['disciplina']),
            array('name' => ':P_CD_PROFESSOR',      'value' => $p['professor']),
            array('name' => ':P_CD_USUARIO',        'value' => $p['usuario']),
            array('name' => ':P_NR_DIFICULDADE',    'value' => $p['dificuldade']),
            array('name' => ':P_CD_TEMA',           'value' => $p['tema']),
            array('name' => ':v_RETORNO',           'value' => 0,               'type' => OCI_B_ROWID),
            array('name' => ':P_CURSOR',            'value' => $cursor,         'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_MANTER_QUESTAO', $params);
    }
    
    function questao_resposta($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',          'value' => $p['operacao']),
            array('name' => ':P_CD_QUESTAO',        'value' => $p['questao']),
            array('name' => ':P_CD_PROVA',          'value' => $p['prova']),
            array('name' => ':P_CD_OPCAO',          'value' => $p['opcao']),
            array('name' => ':P_DC_OPCAO',          'value' => $p['descricao']),
            array('name' => ':P_CD_USU_CADASTRO',   'value' => $p['usuario']),
            array('name' => ':P_CURSOR',            'value' => $cursor,         'type' => OCI_B_CURSOR)
        );
        
        return $this->db->procedure('BD_ACADEMICO','AVAL_MANTER_QUESTAO_OPCAO', $params);
    }
    
    function questao_conteudo($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',          'value' => $p['operacao']),
            array('name' => ':P_CD_QUESTAO',        'value' => $p['questao']),
            array('name' => ':P_CD_CONTEUDO',       'value' => $p['conteudo']),
            array('name' => ':P_CURSOR',            'value' => $cursor,         'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_MANTER_QUESTAO_CONTEUDO', $params);
    }
    
    

    function prova_questao($p) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',     'value' => $p['operacao']),
            array('name' => ':P_CD_PROVA',     'value' => $p['prova']),
            array('name' => ':P_CD_QUESTAO',   'value' => $p['questao']),
            array('name' => ':P_POSICAO',      'value' => $p['posicao']),
            array('name' => ':P_VALOR',        'value' => $p['valor']),
            array('name' => ':P_CD_DISCIPLINA','value' => $p['disciplina']),
            array('name' => ':P_FLG_ANULADA',  'value' => $p['anulada']),
            array('name' => ':P_CURSOR',       'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_MANTER_PROVA_QUESTAO',$params);
    }

}



