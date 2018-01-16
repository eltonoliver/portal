<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mensagem_Sms_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Lista todas os sms cadastrados na data da pesquisa. Caso seja informada
     * uma data a listagem será da data informada.
     * 
     * @param string $dataEnvio Data no formato dd/mm/yyyy
     * @return array 
     */
    public function listar($dataEnvio = null) {
        $this->db->select("CD_SMS,
                SMS.CD_AUTENTICACAO,
                SMS.NR_TELEFONE,
                SMS.DS_MENSAGEM,
                SMS.TIPO,
                SMS.DT_ENVIO,
                SMS.CD_USUARIO,
                SMS.CD_DESTINATARIO,
           nvl((
                 SELECT alu.NM_ALUNO
                 FROM BD_SICA.aluno alu
                 WHERE cd_aluno = SMS.CD_DESTINATARIO
           ), nvl((
                    SELECT usu.NM_USUARIO
                    FROM BD_SICA.usuarios usu
                    WHERE TO_CHAR(cd_usuario) = SMS.CD_DESTINATARIO
           ), (
                SELECT DISTINCT res.NM_RESPONSAVEL
                FROM BD_SICA.RESPONSAVEL res
                WHERE CPF_RESPONSAVEL = SMS.CD_DESTINATARIO
           ))) AS DESTINATARIO,
           ALU.NM_ALUNO,
           ALU.CD_ALUNO");
        $this->db->from("BD_SICA.SMS SMS");
        $this->db->join("BD_SICA.ALUNO ALU", "ALU.CD_ALUNO = SMS.CD_ALUNO", "LEFT");

        if ($dataEnvio === null) {
            $dataEnvio = date('d/m/Y');
        }

        $this->db->where("to_date(SMS.DT_ENVIO) = to_date('$dataEnvio', 'DD/MM/YYYY')");
        $this->db->order_by('SMS.DT_ENVIO DESC');        

        $query = $this->db->get();
        return $query->result_array();
    }

}
