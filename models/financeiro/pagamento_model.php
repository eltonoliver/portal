<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pagamento_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function transacao($r) {
        
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',        'value' => $r['operacao']),
            array('name' => ':P_CD_PAGAMENTO',    'value' => $r['codigo']),
            array('name' => ':P_AUTENTICACAO',    'value' => $r['autenticacao']),
            array('name' => ':P_CD_ALUNO',        'value' => $r['aluno']),
            array('name' => ':P_CD_PRODUTO',      'value' => $r['produto']),
            array('name' => ':P_MES_REFERENCIA',  'value' => $r['mes']),
            array('name' => ':P_NUM_PARCELA',     'value' => $r['parcela']),
            array('name' => ':P_NR_ORDEM',        'value' => $r['ordem']),
            array('name' => ':P_CPF_RESPONSAVEL', 'value' => $r['responsavel']),
            array('name' => ':P_NM_BANDEIRA',     'value' => $r['bandeira']),
            array('name' => ':P_TP_TRANSACAO',    'value' => $r['tipo']),
            array('name' => ':P_VL_TOTAL',        'value' => $r['recebido']),
            array('name' => ':P_FL_STATUS',       'value' => $r['status']),
            array('name' => ':P_VL_BOLSA',        'value' => $r['bolsa']),
            array('name' => ':P_VL_RECEBIDO',     'value' => $r['recebido']),
            array('name' => ':P_VL_JUROS',        'value' => $r['juros']),
            array('name' => ':P_VL_MULTA',        'value' => $r['multa']),
            array('name' => ':P_VL_DESCONTOS',    'value' => $r['desconto']),
            array('name' => ':P_ID_ORDEM',        'value' => $r['id_ordem']),
            array('name' => ':P_CD_BOLETO',       'value' => $r['cd_boleto']),
            array('name' => ':P_CURSOR',          'value' => $cursor, 'type' => OCI_B_CURSOR)
        );

        return $this->db->sp_seculo('BD_PORTAL', 'AES_PAGAMENTO_ONLINE', $params);

    }

    function lancar_pagamento($r) {
        //*
        //configurar (BD_SICA.BANCO, BD_SICA.BANCO_CONTA, BD_SICA.CONTA EM PRODUÇÃO)
        //*//
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $r['operacao']),
            array('name' => ':P_CD_PAGAMENTO', 'value' => $r['codigo']),
            array('name' => ':P_AUTENTICACAO', 'value' => $r['autenticacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $r['aluno']),
            array('name' => ':P_CD_PRODUTO', 'value' => $r['produto']),
            array('name' => ':P_MES_REFERENCIA', 'value' => $r['mes']),
            array('name' => ':P_NUM_PARCELA', 'value' => $r['parcela']),
            array('name' => ':P_NR_ORDEM', 'value' => $r['ordem']),
            array('name' => ':P_CPF_RESPONSAVEL', 'value' => $r['responsavel']),
            array('name' => ':P_CD_CARTAO', 'value' => $r['cartao']),
            array('name' => ':P_TP_TRANSACAO', 'value' => $r['tipo']),
            array('name' => ':P_VL_RECEBIDO', 'value' => $r['recebido']),
            array('name' => ':P_HISTORICO', 'value' => $r['historico']),
            // 11 - BOLETOS :: 
            // 12 - COMPRA DE CRÉDITO ONLINE 
            // Verificar em BD_SICA.CONFIGURACAO_CONTA
            array('name' => ':P_CONFIG_CONTA', 'value' => 12),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        //print_r($params);
        return $this->db->sp_seculo('BD_PORTAL', 'AES_FIN_LANCAMENTO', $params);
    }

    function credito($params) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $params['operacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $params['aluno']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PDV', 'MOVTO_CREDITO', $params);
    }

    function comprar_credito($params) {

        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $params['operacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $params['aluno']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PDV', 'MOVTO_CREDITO', $params);
    }
    
    function extrato_credito($dados){ #print_r($dados);
        $cursor = ''; 
        $params = array(
            array('name' => ':P_CD_ALUNO', 'value' => $dados['aluno']),
            array('name' => ':P_DT_INICIAL', 'value' => $dados['dt_inicio']),
            array('name' => ':P_DT_FINAL', 'value' => $dados['dt_final']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PDV', 'SP_EXTRATO_CREDITO_ALUNO', $params);
    }
    
    function credito_almoco($dados){ #print_r($dados);
        $cursor = ''; 
        $params = array(
            array('name' => ':P_OPERACAO', 'value' => $dados['operacao']),
            array('name' => ':P_CD_ALUNO', 'value' => $dados['cd_aluno']),
            array('name' => ':P_TIPO_REFEICAO', 'value' => $dados['tipo_refeicao']),
            array('name' => ':P_ID_CAIXA', 'value' => $dados['id_caixa']),
            array('name' => ':P_QUANTIDADE', 'value' => $dados['quantidade']),
            array('name' => ':P_PRECO_UNITARIO', 'value' => $dados['vl_unitario']),
            array('name' => ':P_VL_TOTAL', 'value' => $dados['vl_total']),
            array('name' => ':P_CD_USUARIO', 'value' => $dados['cd_usuario']),
            array('name' => ':P_CD_MATERIAL_ALMOCO', 'value' => $dados['cd_material_almoco']),
            array('name' => ':P_ID_VENDA', 'value' => $dados['id_venda']),
            array('name' => ':P_RETORNO', 'value' => $dados['retorno']),
            array('name' => ':P_CURSOR', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );      
        return $this->db->sp_seculo('BD_PDV', 'VENDA_ALMOCO_VIA_CREDITO_WEB', $params);
    }
    
    /**
     * Realiza o pagamento de boletos com crédito do aluno
     * 
     * @param array $dados
     */
    function boleto_credito_aluno($dados) {
        $params = array(
            array('name' => ':P_CD_EVENTO', 'value' => $dados['evento']),
            array('name' => ':P_CD_BOLETO', 'value' => $dados['boleto']),
            array('name' => ':P_CD_ALUNO', 'value' => $dados['aluno']),
            array('name' => ':P_NR_CPF', 'value' => $dados['responsavel']),
            array('name' => ':P_RESULTADO', 'value' => $dados['resultado'], 'type' => RNT),
            //array('name' => ':P_CURSOR', 'value' => "", 'type' => RNT)
        );      
        return $this->db->sp_seculo('BD_SICA', 'AES_PAGTO_BOLETOS_CRED_ALUNO', $params);
    }

}
