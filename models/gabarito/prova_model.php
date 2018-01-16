<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
        
    function banco_prova($p) {
        $cursor = '';
        $params = array(
                  array('name' => ':P_OPERACAO',                'value' => $p['operacao']   ),
                  array('name' => ':P_CD_PROVA',                'value' => $p['prova']     ),
                  array('name' => ':P_NUM_PROVA',               'value' => $p['num_prova']  ),
                  array('name' => ':P_CHAMADA',                 'value' => $p['chamada']    ),
                  array('name' => ':P_PERIODO',                 'value' => $p['periodo']    ),
                  array('name' => ':P_CD_CURSO',                'value' => $p['curso']      ),
                  
                  array('name' => ':P_DT_PROVA',                'value' => $p['data_prova'] ),
                  
                  array('name' => ':P_QTDE_QUESTOES',           'value' => $p['avalQtdeObj']),
                  array('name' => ':P_VALOR_QUESTAO',           'value' => str_replace(',','.',$p['avalVlQuestaoObj'] )),
                  array('name' => ':P_FLG_PEND_PROCESSAMENTO',  'value' => $p['flg_pend']   ),
                  array('name' => ':P_FLG_WEB',                 'value' => $p['flg_web']    ),
                  array('name' => ':P_TITULO',                  'value' => $p['titulo']     ),

                  array('name' => ':P_CD_USUARIO',              'value' => $this->session->userdata('SGP_CODIGO') ),
                  array('name' => ':P_CD_ESTRUTURA',            'value' => $p['estrutura']  ),
                  array('name' => ':P_BIMESTRE',                'value' => $p['bimestre']   ),
                  array('name' => ':P_CD_TIPO_NOTA',            'value' => $p['tipo_nota']  ),
                  array('name' => ':P_NUM_NOTA',                'value' => $p['num_nota']   ),
                  array('name' => ':P_NOTA_MAXIMA',             'value' => str_replace(',','.',$p['avalTTPontoObj'])),

                
       

                  array('name' => ':P_CD_TIPO_PROVA',           'value' => $p['tipo_prova'] ),
                  array('name' => ':P_CD_PROFESSOR',            'value' => $p['professor']  ),
                  array('name' => ':P_CD_STATUS',               'value' => $p['status']     ),
                  array('name' => ':P_CD_PROVA_PAI',            'value' => $p['pai']        ),
                  array('name' => ':P_ORDEM_SERIE',             'value' => $p['serie']      ),
                  array('name' => ':P_CD_DISCIPLINA',           'value' => $p['disciplina'] ),

                  array('name' => ':P_QTDE_DISSERTATIVA',           'value' => $p['avalQtdeDis'] ),
                  array('name' => ':P_VALOR_QUESTAO_DISSERTATIVA',  'value' => str_replace(',','.',$p['avalVlQuestaoDis'] )),
                  array('name' => ':P_NOTA_DISSERTATIVA',           'value' => str_replace(',','.',$p['avalTTPontoDis'] )),
                  
                  array('name' => ':P_HR_INICIO',               'value' => $p['hora_inicio'] ),
                  array('name' => ':P_HR_FIM',                  'value' => $p['hora_fim'] ),
                  array('name' => ':P_FL_FORMATO',              'value' => $p['avalFormato'] ),
            
                  array('name' => ':v_RETORNO',                 'value' => 0,         'type' => OCI_B_ROWID),
                  array('name' => ':P_CURSOR',                  'value' => $cursor,   'type' => OCI_B_CURSOR)
        );
        //print_r($params);
        return $this->db->procedure('BD_ACADEMICO','AVAL_MANTER_PROVA',$params);
    }

    function prova_online($p) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',      'value' => $p['operacao']),
            array('name' => ':P_CD_PROVA',      'value' => $p['prova']),
            array('name' => ':P_CD_ALUNO',      'value' => $p['aluno']),
            array('name' => ':v_RETORNO',       'value' => 0, 'type' => OCI_B_ROWID),
            array('name' => ':P_CURSOR',        'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_PROVA_ONLINE',$params);
    }
    
    function prova_disciplina($p) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',                'value' => $p['operacao']),
            array('name' => ':P_CD_PROVA',                'value' => $p['prova']),
            array('name' => ':P_CD_DISCIPLINA',           'value' => $p['disciplina']),
            array('name' => ':P_POSICAO_INICIAL',         'value' => $p['inicio']),
            array('name' => ':P_POSICAO_FINAL',           'value' => $p['fim']),
            array('name' => ':P_PESO',                    'value' => $p['peso']),
            array('name' => ':P_TIPO_QUESTAO',            'value' => $p['tipo']),
            array('name' => ':P_VL_QUESTAO',              'value' => $p['valor']),
            array('name' => ':P_CD_PROFESSOR_CORRECAO',   'value' => $p['professor']),
            array('name' => ':P_CURSOR',                  'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_MANTER_PROVA_DISC',$params);
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
    
    function prova_despacho($p) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',           'value' => $p['operacao']),
            array('name' => ':P_CD_PROVA',           'value' => $p['prova']),
            array('name' => ':P_FLG_TIPO_DESPACHO',  'value' => $p['flag']),
            array('name' => ':P_DC_MOTIVO',          'value' => $p['motivo']),
            array('name' => ':P_CD_USUARIO',         'value' => $this->session->userdata('SGP_CODIGO')),
            array('name' => ':P_DC_COMPLEMENTO',     'value' => $p['complemento']),
            array('name' => ':P_CD_STATUS',          'value' => $p['status']),
            array('name' => ':P_CURSOR',             'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        //print_r($params);
        return $this->db->procedure('BD_ACADEMICO','AVAL_MANTER_DESPACHO',$params);
    }

    function prova_espelho($p) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',     'value' => $p['operacao']),
            array('name' => ':P_CD_PROVA',     'value' => $p['prova']),
            array('name' => ':P_CD_QUESTAO',   'value' => $p['questao']),
            array('name' => ':P_CD_OPCAO',     'value' => $p['opcao']),
            array('name' => ':P_POSICAO',      'value' => $p['posicao']),
            array('name' => ':v_CD_PROVA',     'value' => '', 'type' => OCI_B_ROWID),
            array('name' => ':P_CURSOR',       'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_PROVA_ESPELHO',$params);
    }
    
    function prova_inscritos($p) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',         'value' => $p['operacao']),
            array('name' => ':P_CD_PROVA',         'value' => $p['prova']),            
            array('name' => ':P_CD_USUARIO',       'value' => $this->session->userdata('SGP_CODIGO')),
            array('name' => ':P_CD_ALUNO',         'value' => $p['aluno']),
            array('name' => ':P_CD_CURSO',         'value' => $p['curso']),
            array('name' => ':P_ORDEM_SERIE',      'value' => $p['serie']),
            array('name' => ':P_CD_PROVA_VERSAO',  'value' => $p['versao']),
            array('name' => ':P_NR_FILA',          'value' => $p['fila']),
            array('name' => ':P_NR_POSICAO_FILA',  'value' => $p['posicao']),
            array('name' => ':P_CURSOR',           'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_PROVA_INSCRITOS',$params);
        
    }
    
    function prova_aluno_inscritos($p) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',         'value' => $p['operacao']),
            array('name' => ':P_CD_PROVA',         'value' => $p['prova']),            
            array('name' => ':P_CD_USUARIO',       'value' => $this->session->userdata('SGP_CODIGO')),
            array('name' => ':P_CD_ALUNO',         'value' => $p['aluno']),
            array('name' => ':P_CD_PROVA_VERSAO',  'value' => $p['versao']),
            array('name' => ':P_CURSOR',           'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        //print_r($params);
        return $this->db->procedure('BD_ACADEMICO','AVAL_INSCRITOS',$params);
        
    }
    
    
    function prova_inscritos_alinhamento($p) {
        $cursor = '';
        $params = array(
            array('name' => ':P_CD_PROVA',         'value' => $p['prova']),
            array('name' => ':P_CD_CURSO',         'value' => $p['curso']),
            array('name' => ':P_ORDEM_SERIE',      'value' => $p['serie']),
            array('name' => ':P_CD_USUARIO',       'value' => $this->session->userdata('SGP_CODIGO')),
            array('name' => ':v_RETORNO',          'value' => '',      'type' => OCI_B_ROWID),
            array('name' => ':P_CURSOR',           'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        
        return $this->db->procedure('BD_ACADEMICO','AVAL_INSCRITO_ALINHAMENTO',$params);
        
    }
    
    function prova_alunos($p) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',         'value' => $p['operacao']),
            array('name' => ':P_CD_PROVA',         'value' => $p['prova']),            
            array('name' => ':P_CD_USUARIO',       'value' => $this->session->userdata('SGP_CODIGO')),
            array('name' => ':P_CD_ALUNO',         'value' => $p['aluno']),
            array('name' => ':P_CD_PROVA_VERSAO',  'value' => $p['versao']),
            array('name' => ':P_NR_FILA',          'value' => $p['fila']),
            array('name' => ':P_NR_POSICAO_FILA',  'value' => $p['posicao']),
            array('name' => ':v_RETORNO',          'value' => '',               'type' => OCI_B_ROWID),
            array('name' => ':P_CURSOR',           'value' => $cursor,          'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_PROVA_ALUNO',$params);
    }
    
    function prova_detalhe($p) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',     'value' => $p['operacao'] ),
            array('name' => ':P_CD_PROVA',     'value' => $p['prova']    ),
            array('name' => ':P_NUM_PROVA',    'value' => $p['numero']    ),
            array('name' => ':P_CD_QUESTAO',   'value' => $p['questao']  ),
            array('name' => ':P_CD_OPCAO',     'value' => $p['opcao']    ),
            array('name' => ':P_RESPOSTAS',    'value' => $p['respostas']    ),
            array('name' => ':P_CURSOR',       'value' => $cursor,  'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_PROVA_DETALHES',$params);
    }
    
    function aval_prova_cancenlamento($p) {
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',            'value' => $p['operacao']     ),
            array('name' => ':P_CD_CANCELAMENTO',     'value' => $p['codigo']       ),
            array('name' => ':P_CD_PROVA',            'value' => $p['prova']        ),
            array('name' => ':P_CD_MOTIVO',           'value' => $p['motivo']       ),
            array('name' => ':P_CD_SOLICITANTE',      'value' => $this->session->userdata('SGP_CODIGO')),
            array('name' => ':P_CD_APROVACAO',        'value' => $p['aprovador']    ),
            array('name' => ':P_NR_PROVAS_IMPRESSAS', 'value' => $p['nr_provas']    ),
            array('name' => ':P_NR_CARTAO_RESPOSTAS', 'value' => $p['nr_cartao']    ),
            array('name' => ':v_RETORNO',             'value' => '',      'type' => OCI_B_ROWID),
            array('name' => ':P_CURSOR',              'value' => $cursor,  'type' => OCI_B_CURSOR)
        );
        return $this->db->procedure('BD_ACADEMICO','AVAL_PROVA_CANCELAMENTO',$params);
    }
    
    function relTema($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $p['operacao']),
            array('name' => ':P_CD_CURSO', 'value' => $p['curso']),
            array('name' => ':P_ORDEM_SERIE', 'value' => $p['serie']),
            array('name' => ':P_CD_DISCIPLINA', 'value' => $p['disciplina']),
            array('name' => ':P_CD_PROVA', 'value' => $p['prova']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        $sql = $this->db->procedure('BD_ACADEMICO','AVAL_DETALHES',$params);
        return($sql);
    }
    
    function CartaoResposta($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $p['operacao']),
            array('name' => ':P_CD_PROVA', 'value' => $p['prova']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        $sql = $this->db->procedure('BD_ACADEMICO','AVAL_CARTAO_RESPOSTA',$params);
        return($sql);
    }
    
    function relatorios($p) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $p['operacao']),
            array('name' => ':P_CD_CURSO', 'value' => $p['curso']),
            array('name' => ':P_ORDEM_SERIE', 'value' => $p['serie']),
            array('name' => ':P_CD_DISCIPLINA', 'value' => $p['disciplina']),
            array('name' => ':P_BIMESTRE', 'value' => $p['bimestre']),
            array('name' => ':P_CHAMADA', 'value' => $p['chamada']),
            array('name' => ':P_PERIODO', 'value' => $p['periodo']),
            array('name' => ':P_CD_PROVA', 'value' => $p['prova']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        $sql = $this->db->procedure('BD_ACADEMICO','AVAL_REL_PROVAS',$params);
        return($sql);
    }
    
    function cabecalho($p) {

        $cursor = '';
        $params = array(
            array('name' => ':p_CD_PROVA', 'value' => $p['prova']), 
            array('name' => ':p_CD_ALUNO', 'value' => $p['aluno']),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        $res = $this->db->procedure('BD_SICA', 'SP_AVAL_PROVA_CABECALHO', $params);
        //print_r($params);exit;
        //print_r($res);exit;
        if(count($res) == 0){
           return FALSE;
        }else{
           return($res);
        }        
    }
    
    function excluirVersoes($prova) {

        $params = array(
            array('name' => ':p_CD_PROVA', 'value' => $prova)          
        );
        $res = $this->db->procedure('BD_ACADEMICO', 'SP_AVAL_CANCELA_VERSOES', $params);
        print_r($params);
        //print_r($res);
        
        if(count($res) == 0){
           return FALSE;
        }else{
           return($res);
        }    
    }
    
}



