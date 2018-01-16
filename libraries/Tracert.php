<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tracert {

    function validar_url($url) {
        $obj = & get_instance();

        $obj->load->model('seguranca/permissao_model', 'permissao', TRUE);
        $permissao = $obj->permissao->permissao_sistema();
        //-------------- 
        $i = 0;
        $retorno = FALSE;
        foreach ($permissao as $row) {
            $item = explode('/', $row->FORMULARIO);
            $url_sistema = $item[0] . '/' . $item[1] . '/';
            if ($url_sistema == $url) {
                $retorno = TRUE;
                return TRUE;
            } else {
                $retorno = FALSE;
            }
        }
        if ($retorno == FALSE) {
            redirect(base_url(), 'refresh');
        }
    }

}

$obj = & get_instance();
$obj->load->helper('url');
$seguranca = new tracert();
$seguranca->validar_url($obj->uri->slash_segment(1) . $obj->uri->slash_segment(2));
?>