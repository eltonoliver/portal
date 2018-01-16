<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class Livro_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
	
	
    
    function sp_livro($parametro){ 
        $cursor = '';
        $params = array(
            array('name' => ':P_OPERACAO',          'value' => $parametro['operacao']),
            array('name' => ':P_ID_LIVRO',          'value' => $parametro['id_livro']),
            array('name' => ':P_LIVRO_TITULO',      'value' => $parametro['titulo']),
            array('name' => ':P_AUTOR',             'value' => $parametro['autor']),
            array('name' => ':P_ANO_EDICAO',        'value' => $parametro['ano_edicao']),
            array('name' => ':P_EDITORA',           'value' => $parametro['editora']),
            array('name' => ':P_OBSERVACAO',        'value' => $parametro['observacao']),
            array('name' => ':P_CODIGO_REFERENCIA', 'value' => $parametro['cod_referencia']),
            array('name' => ':P_DT_CADASTRO',       'value' => $parametro['dt_cadastro']),
            array('name' => ':P_CD_USUARIO_CAD',    'value' => $parametro['cd_usuario']),
            array('name' => ':P_ATIVO',             'value' => $parametro['ativo']),
            array('name' => ':P_CD_DISCIPLINA',     'value' => $parametro['cd_disciplina']),
            array('name' => ':P_CD_CURSO',          'value' => $parametro['cd_curso']),
            array('name' => ':P_CD_SERIE',          'value' => $parametro['ordem_serie']),
            array('name' => ':P_IMAGEM_CAPA',       'value' => $parametro['capa']),
            array('name' => ':P_QTDE',              'value' => $parametro['qtde']),
            array('name' => ':P_TIPO',              'value' => $parametro['tipo']),
            array('name' => ':P_BIMESTRE',          'value' => $parametro['bimestre']),
            array('name' => ':P_ID_LIVRO_ASSUNTO',  'value' => $parametro['id_assunto']),
            array('name' => ':P_ESTRUTURA',         'value' => $parametro['estrutura']),
            array('name' => ':P_INS_UPD',           'value' => $parametro['ins_upd']),
            array('name' => ':P_CURSOS',            'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        return $this->db->sp_seculo('BD_PAJELA', 'SP_LIVRO', $params);
    }
           
	
}

// End of file professor_model.php
// Location: ./application/models/professor_model.php