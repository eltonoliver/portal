<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Refeitorio_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function consulta_cupom($parametro) {
        $sql = "SELECT V.ID_VENDA, 
                       VP.NR_ORDEM, 
                       V.DT_VENDA, 
                       VP.CD_MATERIAL,
                       EM.NM_MATERIAL,
                       VP.QUANTIDADE, 
                       VP.PRECO_UNITARIO, 
                       VP.VL_TOTAL, 
                       VP.VL_DESCONTO,
                       EM.CD_UNIDADE_MEDIDA, 
                       EM.CD_MATERIAL_BAIXA, 
                       UM.SIGLA,
                       (SELECT CD_UNIDADE_MEDIDA FROM BD_FINANCEIRO.EST_MATERIAL M WHERE M.CD_MATERIAL = EM.CD_MATERIAL_BAIXA) AS UNI_MEDIDA_BX
                   FROM BD_PDV.VENDAS V
             INNER JOIN BD_PDV.VENDAS_PRODUTOS VP ON VP.ID_VENDA = V.ID_VENDA
             INNER JOIN BD_FINANCEIRO.EST_MATERIAL EM ON EM.CD_MATERIAL = VP.CD_MATERIAL
             INNER JOIN BD_FINANCEIRO.EST_UNIDADE_MEDIDA UM ON UM.CD_UNIDADE_MEDIDA = VP.CD_UNIDADE_MEDIDA
             WHERE V.ID_VENDA =".$parametro['cupom']." 
               AND NVL(VP.CANCELADO, 'N') = 'N' 
           ORDER BY VP.NR_ORDEM";
        return $this->db->query($sql);
    }
    
    function dadoa_cupom_venda($parametro) {
        $sql = "SELECT DISTINCT VR.VLR_RECEBIDO, FR.DC_FORMA_RECEBIMENTO
             FROM BD_PDV.VENDAS V
             INNER JOIN BD_PDV.VENDAS_PRODUTOS VP ON VP.ID_VENDA = V.ID_VENDA
             INNER JOIN BD_FINANCEIRO.EST_MATERIAL EM ON EM.CD_MATERIAL = VP.CD_MATERIAL
             INNER JOIN BD_PDV.VENDAS_RECEBIMENTOS VR ON VR.ID_VENDA = V.ID_VENDA
             INNER JOIN BD_PDV.T_FORMAS_RECEBIMENTO FR ON FR.ID_FORMA_RECEBIMENTO = VR.ID_FORMA_RECEBIMENTO
             WHERE V.ID_VENDA = ".$parametro['cupom']."";
        return $this->db->query($sql);
    }
    
    function consulta_produtos($dados){
        $sql = " SELECT *
                    FROM (
                    SELECT DISTINCT
                           M.CD_MATERIAL AS ID_PRODUTO,
                           M.CD_MATERIAL AS CD_PRODUTO,
                           M.ABREVIATURA AS DC_PRODUTO,
                           'UN' AS SIGLA_UNIDADE,
                           M.CD_NATUREZA AS ID_CATEGORIA,
                           N.NM_NATUREZA AS DC_CATEGORIA,
                           M.PRECO_ALUNO,
                           M.PRECO_FUNCIONARIO,
                           M.PRECO_EXTERNO,
                           M.NM_MATERIAL AS DC_PRODUTO_CMP,
                           M.CTRL_ESTOQUE,
                           M.CD_UNIDADE_MEDIDA,
                           NVL(CASE WHEN NVL(M.CD_MATERIAL_BAIXA,0) = 0
                                THEN (SELECT NVL(MA.QTDE_ESTOQUE,0)
                                        FROM BD_FINANCEIRO.EST_MATERIAL_ALMOXARIFADO MA
                                       WHERE MA.CD_MATERIAL = M.CD_MATERIAL
                                         AND MA.CD_UNIDADE_MEDIDA = M.CD_UNIDADE_MEDIDA
                                         AND MA.CD_ALMOXARIFADO   = ".$dados['cd_almoxarifado'].")
                                ELSE (SELECT NVL(MA1.QTDE_ESTOQUE,0)
                                        FROM BD_FINANCEIRO.EST_MATERIAL_ALMOXARIFADO MA1
                                       WHERE MA1.CD_MATERIAL = M.CD_MATERIAL_BAIXA
                                         AND MA1.CD_UNIDADE_MEDIDA = (SELECT M1.CD_UNIDADE_MEDIDA
                                                                        FROM BD_FINANCEIRO.EST_MATERIAL M1
                                                                       WHERE M1.CD_MATERIAL = M.CD_MATERIAL_BAIXA)
                                         AND MA1.CD_ALMOXARIFADO   = ".$dados['cd_almoxarifado'].") END,0) AS QTD_ESTOQUE,

                           'S' AS LIB_MOVESTOQUE,
                           M.CD_MATERIAL_BAIXA,
                           CASE WHEN NVL(M.CD_MATERIAL_BAIXA,0) <> 0
                                THEN (SELECT M1.CD_UNIDADE_MEDIDA
                                        FROM BD_FINANCEIRO.EST_MATERIAL M1
                                       WHERE M1.CD_MATERIAL = M.CD_MATERIAL_BAIXA)
                                ELSE 0 END AS CD_UNIDADE_MEDIDA_BAIXA
                      FROM BD_PDV.TERMINAIS_PRODUTOS                    TP
                           INNER JOIN BD_FINANCEIRO.EST_NATUREZA  N ON N.CD_NATUREZA = TP.CD_NATUREZA
                           INNER JOIN BD_FINANCEIRO.EST_MATERIAL  M ON M.CD_NATUREZA = N.CD_NATUREZA
                     WHERE TP.ID_TERMINAL IN (SELECT ID_TERMINAL FROM BD_PDV.TERMINAIS WHERE CD_ALMOXARIFADO = ".$dados['cd_almoxarifado'].")
                       AND M.FLG_ATIVO = 'S'
                       AND M.FLG_VENDA = 'S'
                       AND M.PRECO_EXTERNO = ".$dados['preco']."
                     UNION
                    SELECT DISTINCT
                           M.CD_MATERIAL AS ID_PRODUTO,
                           M.CD_MATERIAL AS CD_PRODUTO,
                           M.ABREVIATURA AS DC_PRODUTO,
                           'UN' AS SIGLA_UNIDADE,
                           M.CD_NATUREZA AS ID_CATEGORIA,
                           N.NM_NATUREZA AS DC_CATEGORIA,
                           M.PRECO_ALUNO,
                           M.PRECO_FUNCIONARIO,
                           M.PRECO_EXTERNO,
                           M.NM_MATERIAL AS DC_PRODUTO_CMP,
                           M.CTRL_ESTOQUE,
                           M.CD_UNIDADE_MEDIDA,
                           NVL(CASE WHEN NVL(M.CD_MATERIAL_BAIXA,0) = 0
                                THEN (SELECT NVL(MA.QTDE_ESTOQUE,0)
                                        FROM BD_FINANCEIRO.EST_MATERIAL_ALMOXARIFADO MA
                                       WHERE MA.CD_MATERIAL = M.CD_MATERIAL
                                         AND MA.CD_UNIDADE_MEDIDA = M.CD_UNIDADE_MEDIDA
                                         AND MA.CD_ALMOXARIFADO   = ".$dados['cd_almoxarifado'].")
                                ELSE (SELECT NVL(MA1.QTDE_ESTOQUE,0)
                                        FROM BD_FINANCEIRO.EST_MATERIAL_ALMOXARIFADO MA1
                                       WHERE MA1.CD_MATERIAL = M.CD_MATERIAL_BAIXA
                                         AND MA1.CD_UNIDADE_MEDIDA = (SELECT M1.CD_UNIDADE_MEDIDA
                                                                        FROM BD_FINANCEIRO.EST_MATERIAL M1
                                                                       WHERE M1.CD_MATERIAL = M.CD_MATERIAL_BAIXA)
                                         AND MA1.CD_ALMOXARIFADO   = ".$dados['cd_almoxarifado'].") END,0) AS QTD_ESTOQUE,
                           'S' AS LIB_MOVESTOQUE,
                           M.CD_MATERIAL_BAIXA,
                           CASE WHEN NVL(M.CD_MATERIAL_BAIXA,0) <> 0
                                THEN (SELECT M1.CD_UNIDADE_MEDIDA
                                        FROM BD_FINANCEIRO.EST_MATERIAL M1
                                       WHERE M1.CD_MATERIAL = M.CD_MATERIAL_BAIXA)
                                ELSE 0 END AS CD_UNIDADE_MEDIDA_BAIXA

                      FROM BD_PDV.TERMINAIS_PRODUTOS      TP
                           INNER JOIN BD_FINANCEIRO.EST_MATERIAL  M ON M.CD_MATERIAL = TP.CD_MATERIAL
                           INNER JOIN BD_FINANCEIRO.EST_NATUREZA  N ON N.CD_NATUREZA =  M.CD_NATUREZA

                     WHERE TP.ID_TERMINAL IN (SELECT ID_TERMINAL FROM BD_PDV.TERMINAIS WHERE CD_ALMOXARIFADO = ".$dados['cd_almoxarifado'].")
                       AND M.FLG_ATIVO = 'S'
                       AND M.FLG_VENDA = 'S'
                       AND M.PRECO_EXTERNO = ".$dados['preco'].") WHERE QTD_ESTOQUE > 0 ORDER BY DC_PRODUTO";
        
        return $this->db->query($sql);
    }
    
    function sp_baixa_estorno_cantina($dado){
        $cursor = '';
        $params = array(
                array('name'=>':P_OPCAO_ATUALIZACAO',   'value'=>$dado['opcao']),
                array('name'=>':P_CD_ALMOXARIFADO',     'value'=>$dado['cd_almoxarifado']),
                array('name'=>':P_CD_MATERIAL',         'value'=>$dado['cd_material']),
                array('name'=>':P_QUANTIDADE',          'value'=>$dado['qtde']),
                array('name'=>':P_CD_UNIDADE_MEDIDA',   'value'=>$dado['unidade_medida']),
                array('name'=>':P_CD_DOCUMENTO',        'value'=>$dado['cd_ducumento']),
                array('name'=>':P_NRO_DOCUMENTO',       'value'=>$dado['nro_documento']),
                array('name'=>':P_CD_TIPO_TRANSACAO',   'value'=>$dado['tipo_transacao']),
                array('name'=>':P_CURSOR',              'value'=>$cursor,                   'type'=>OCI_B_CURSOR)
                );

        return $this->db->sp_seculo('BD_PDV','SP_PDV_ATUALIZA_ESTOQUE_WEB',$params);		
	
    }
    
    function inserir_historico($dados){
        $sql = "INSERT INTO BD_PDV.VENDAS_PRODUTOS_TROCAS(ID_VENDA,CD_MATERIAL_ORIGEM ,CD_MATERIAL_TROCA,CD_UNIDADE_MEDIDA_TROCA,QTDE_TROCA,NR_ORDEM)
                                              VALUES(".$dados['id_venda'].",".$dados['material_origem'].",".$dados['material_toca']."
                                                ,".$dados['uni_medida_troca'].",".$dados['qtde_troca'].", ".$dados['nr_ordem']." )";
        
        return $this->db->query($sql);
    }

}
