<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    /* Library Prova_lib
     * Autor:  Silvio de Souza
     * Email:  silvio.souza@seculomanaus.com.br
     * Data:   29/04/2016
     */

class Gabarito_lib {
    
    public $numero_prova;
    public $prova_pai;
    public $respostas;
           
    function correcao() {

        // ATUALIZA O GABARITO DAS PROVAS
        $obj = &get_instance();
        $obj->load->model('sica/aes_prova_model', 'prova', TRUE);
        $obj->load->model('sica/aes_prova_questao_model', 'questao_prova', TRUE);
        
        // PEGA A PROVA E SUAS VERSÕES
        $provas = $obj->prova->listar_provas($this->prova_pai);
        // LOOP PARA PEGAR O GABARITO DA QUESTAO
        
        $gabarito = array();
        foreach($provas as $pv){
           $questoes = $obj->questao_prova->gabarito($pv['CD_PROVA']);
           $resposta = '';
           foreach($questoes as $res){
                if($res['FLG_ANULADA'] == 'S'){
                    $resposta = $resposta.'*';
                }elseif($res['FLG_CANCELADA'] == 'S'){
                    $resposta = $resposta.'#';
                }elseif($res['RESPOSTA_CERTA'] != ''){
                    switch($res['RESPOSTA_CERTA']){
                        case 1: $r = 'A'; break;
                        case 2: $r = 'B'; break;
                        case 3: $r = 'C'; break;
                        case 4: $r = 'D'; break;
                        case 5: $r = 'E'; break;
                    }
                    $resposta = $resposta.$r;                    
                }else{
                    $resposta = $resposta.'-';
                }
           }
           $gabarito[$pv['CD_PROVA']]['prova'] = $pv['CD_PROVA'];
           $gabarito[$pv['CD_PROVA']]['respostas'] = $resposta;
        }

        foreach($gabarito as $gab){
            $parm = array(
                   'prova' => $gab['prova'],
                'gabarito' => $gab['respostas']
            );
            //print_r($parm);
            $obj->prova->resposta($parm);
        }
        return($res);
    }
    
    function cartao_resposta() {
        // RETORNA A RELAÇÃO DE ALUNOS DA PROVA
        $obj = & get_instance();
        $obj->load->model('108/prova_model', 'banco', TRUE);
        
        $p = array(
         'operacao' => 'L', 
           'prova' => $this->numero_prova
        );
        $gabarito = $obj->banco->prova_detalhe($p);
        $table = '<table class="table table-hover">';
        $table .= '<thead>';
        $table .= '<tr>';
        $table .= '<th width="12.5%">#</th>';
        $table .= '<th width="12.5%" class="text-left">A</th>';
        $table .= '<th width="12.5%" class="text-left">B</th>';
        $table .= '<th width="12.5%" class="text-left">C</th>';
        $table .= '<th width="12.5%" class="text-left">D</th>';
        $table .= '<th width="12.5%" class="text-left">E</th>';
        $table .= '<th width="12.5%" class="text-left">AN</th>';
        $table .= '<th width="12.5%" class="text-left">CA</th>';
        $table .= '</tr>';
        $table .= '</thead>';
        $table .= '<tbody>';
        foreach($gabarito as $g){
            $table .= '<tr>';
            $table .= '<td>'.$g['POSICAO'].'</td>';
            $table .= '<td class="text-center"><div class="radio radio-success no-padding no-margins">
                        <input type="radio" readonly="readonly" '.(($g['RESPOSTA_CERTA']== 1)? 'checked="checked"': '').'>
                        <label class="no-margins no-padding"></label>
                        </div></td>';
            $table .= '<td class="text-center"><div class="radio radio-success no-padding no-margins">
                        <input type="radio" readonly="readonly" '.(($g['RESPOSTA_CERTA']== 2)? 'checked="checked"': '').'>
                        <label class="no-margins no-padding"></label>
                        </div></td>';
            $table .= '<td class="text-center"><div class="radio radio-success no-padding no-margins">
                        <input type="radio" readonly="readonly" '.(($g['RESPOSTA_CERTA']== 3)? 'checked="checked"': '').'>
                        <label class="no-margins no-padding"></label>
                        </div></td>';
            $table .= '<td class="text-center"><div class="radio radio-success no-padding no-margins">
                        <input type="radio" readonly="readonly" '.(($g['RESPOSTA_CERTA']== 4)? 'checked="checked"': '').'>
                        <label class="no-margins no-padding"></label>
                        </div></td>';
            $table .= '<td class="text-center"><div class="radio radio-success no-padding no-margins">
                        <input type="radio" readonly="readonly" '.(($g['RESPOSTA_CERTA']== 5)? 'checked="checked"': '').'>
                        <label class="no-margins no-padding"></label>
                        </div></td>';
            $table .= '<td class="text-center"><div class="radio radio-success no-padding no-margins">
                        <input type="radio" readonly="readonly" '.(($g['FLG_ANULADA'] == 'S')? 'checked="checked"': '').'>
                        <label class="no-margins no-padding"></label>
                        </div></td>';
            $table .= '<td class="text-center"><div class="radio radio-success no-padding no-margins">
                        <input type="radio" readonly="readonly" '.(($g['FLG_CANCELADA'] == 'S')? 'checked="checked"': '').'>
                        <label class="no-margins no-padding"></label>
                        </div></td>';
            $table .= '</tr>';
            $table .= '</tbody>';
        }
        $table .= '</table>';        
        
        return($table);

    }

}

?>