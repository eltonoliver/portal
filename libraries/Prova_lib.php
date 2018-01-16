<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* Library Prova_lib
 * Autor: Silvio de Souza
 * Email: silvio.souza@seculomanaus.com.br
 * Data: 08/04/2015
 * Atualizada : 17/02/2016
 * 
 * Retorna:
 * ----------------------------------------
 * 
 */

class Prova_lib {

    public $prova;
   private $prova_nova;
    public $tipo;
    public $disciplina;
    public $selecao;
    public $questoes = array();
    public $qtdprovas;

    function formata_texto_sem_richtext($texto) {
        
        
        $DOM = new DOMDocument;
        
        
        $texto_pronto = str_replace('<div style="text-align: center;">', '',$texto);
        $texto_pronto = str_replace('<div>', '',$texto_pronto);
        $texto_pronto = str_replace('https', 'http',$texto_pronto);
        $texto_pronto = str_replace('<p>', '',$texto_pronto);
        $texto_pronto = str_replace('</p>', '',$texto_pronto);
        $texto_pronto = str_replace('</div>', '<br/>',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_0"', '',$texto_pronto);
        
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_0"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_1"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_2"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_3"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_4"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_5"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_6"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_7"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_8"', '',$texto_pronto);
        
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_0"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_1"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_2"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_3"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_4"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_5"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_6"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_7"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_8"', '',$texto_pronto);
        $texto_pronto = str_replace('<span style="white-space: nowrap;">', '',$texto_pronto);        
        
        //$texto_pronto = preg_replace('/(<span class="mathquill-embedded-latex".+?)style=".+?"(>.+?)/i', "$1$2", $texto_pronto);
        $texto_pronto = str_replace('<div style="text-align: left;">', '<br/>',$texto_pronto);
        
        $texto_pronto = str_replace('<br/><br/><br/>', '<br/>',$texto_pronto);
        $texto_pronto = str_replace('https://www.seculomanaus.com.br/academico/', base_url(),$texto_pronto);
        $texto_pronto = str_replace('http://www.seculomanaus.com.br/academico/', base_url(),$texto_pronto);
        $texto_pronto = str_replace('<span style="display: none; line-height: 0px;">¿</span>', '',$texto_pronto);
        $texto_pronto = str_replace('<span style="display: none;">¿</span>', '',$texto_pronto);
        $texto_pronto = str_replace('¿', '<label class="label label-danger">¿</label>',$texto);
        $texto_pronto = str_replace('<label class="label label-danger">¿</label>', '',$texto_pronto);
        
        //$texto_pronto = strip_tags($texto_pronto, '<img><br/><br><sub><sup>');
        return($texto_pronto);
    }
    
    function formata_texto_com_richtext($texto) {
        
        
        $DOM = new DOMDocument;
        
        $texto_pronto = str_replace('<div style="text-align: center;">', '',$texto);
        $texto_pronto = str_replace('<div>', '',$texto_pronto);
        $texto_pronto = str_replace('https', 'http',$texto_pronto);
        $texto_pronto = str_replace('</div>', '<br/>',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_0"', '',$texto_pronto);
        
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_0"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_1"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_2"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_3"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_4"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_5"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_6"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_7"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_8"', '',$texto_pronto);
        
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_0"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_1"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_2"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_3"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_4"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_5"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_6"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_7"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_8"', '',$texto_pronto);
        
        $texto_pronto = str_replace('font-size: 12px', '',$texto_pronto);
        $texto_pronto = str_replace('font-size: 13px', '',$texto_pronto);
        $texto_pronto = str_replace('font-size: 14px', '',$texto_pronto);
        $texto_pronto = str_replace('font-size: 15px', '',$texto_pronto);
        $texto_pronto = str_replace('font-size: 16px', '',$texto_pronto);
        $texto_pronto = str_replace('font-size: 17px', '',$texto_pronto);
        $texto_pronto = str_replace('font-size: 18px', '',$texto_pronto);
        
        $texto_pronto = str_replace('line-height: 1.42857', '',$texto_pronto);
        
        $texto_pronto = preg_replace('/(<span class="mathquill-embedded-latex".+?)style=".+?"(>.+?)/i', "$1$2", $texto_pronto);
        $texto_pronto = str_replace('<div style="text-align: left;">', '<br/>',$texto_pronto);
        
        $texto_pronto = str_replace('<br/><br/><br/>', '<br/>',$texto_pronto);
        
        //$texto_pronto = str_replace('<br/><br/>', '<br/>',$texto_pronto);
        $texto_pronto = str_replace('<span style="display: none; line-height: 0px;">¿</span>', '',$texto_pronto);
        $texto_pronto = str_replace('<span style="display: none;">¿</span>', '',$texto_pronto);
        $texto_pronto = str_replace('<label class="label label-danger">¿</label>', '',$texto_pronto);
        
        //$texto_pronto = str_replace('<span style="font-size: 16px; line-height: 1.42857143;">','',$texto_pronto);        
        $texto_pronto = preg_replace('/(<table)class=".+?"(>.+?)/i', "$1$2", $texto_pronto);
        
        $pos = strpos($texto_pronto,"mathquill-embedded-latex");
        
        if($pos == TRUE){
            $dom = new DOMDocument();
            @$dom->loadHTML($texto_pronto);

            $xpath = new DOMXPath($dom);
            $classname = "mathquill-embedded-latex";
            $nodes = $xpath->query("//*[@class='" . $classname . "']");

            foreach ($nodes as $node) {
                 $formula[] = $node->nodeValue;
            }

            //print_r($formula);exit;
            $texto_pronto = str_replace(''.$formula[0].'', '',$texto_pronto);
            $texto_pronto = str_replace('<span class="mathquill-embedded-latex" >', '<img src="http://latex.codecogs.com/gif.latex?'.$formula[0].'"/>',$texto_pronto);
        }
        
        // TRATA OS SUBLINHADOS (UNDERLINE)
        $pos = strpos($texto_pronto, "text-decoration:underline");
        for($ia = 0;$ia<=7;$ia++){
            if ($pos == TRUE) {
                preg_match_all('/<span style="text-decoration:underline;">(.+?)<\/span>/sm', $texto_pronto, $conteudo);
                $texto_pronto = str_replace($conteudo[0][0],'<span style="border-bottom: 2px solid;">'.$conteudo[1][0].'</span>',$texto_pronto);
            }
        }
        
        // TRATA OS TACHADOS E TRANSFORMAM EM FONTES
        $pos = strpos($texto_pronto, "text-decoration:line-through");        
        for($ia = 0;$ia<=3;$ia++){
            if ($pos == TRUE) {
                preg_match_all('/<span style="text-decoration:line-through;">(.+?)<\/span>/sm', $texto_pronto, $conteudo);
                $texto_pronto = str_replace($conteudo[0][0],'<table style="width:100%"><tr><td style="text-align: right; color: #0075b0; font-size:8px; "> Fonte: '.$conteudo[1][0].'</td></tr></table><strong>',$texto_pronto);
            }
        }
        
        $pos = strpos($texto_pronto, "text-decoration: line-through");
        for($ia = 0;$ia<=3;$ia++){
            if ($pos == TRUE) {
                preg_match_all('/<span style="line-height: 22.8571px; white-space: normal; text-decoration: line-through;">(.+?)<\/span>/sm', $texto_pronto, $conteudo);
                $texto_pronto = str_replace($conteudo[0][0],'<table style="width:100%"><tr><td style="text-align: right; color: #0075b0; font-size:8px; "> Fonte: '.$conteudo[1][0].'</td></tr></table><strong>',$texto_pronto);
            }
        }
        
        $pos = strpos($texto_pronto, "text-decoration: line-through");
        for($ia = 0;$ia<=3;$ia++){
            if ($pos == TRUE) {
                preg_match_all('/<span style="white-space: normal; line-height: 22.8571px; text-decoration: line-through;">(.+?)<\/span>/sm', $texto_pronto, $conteudo);
                $texto_pronto = str_replace($conteudo[0][0],'<table style="width:100%"><tr><td style="text-align: right; color: #0075b0; font-size:8px; "> Fonte: '.$conteudo[1][0].'</td></tr></table><strong>',$texto_pronto);
            }
        }
        
        //tratamento de tachado com o editor tinymce
        $pos = strpos($texto_pronto, "text-decoration: line-through;");
        for($ia = 0;$ia<=3;$ia++){
            if ($pos == TRUE) {
                preg_match_all('/<span style="text-decoration: line-through;">(.+?)<\/span>/sm', $texto_pronto, $conteudo);
                $texto_pronto = str_replace($conteudo[0][0],'<table style="width:100%"><tr><td style="text-align: right; color: #0075b0; font-size:8px; "> Fonte: '.$conteudo[1][0].'</td></tr></table><strong>',$texto_pronto);
            }
        }
        $texto_pronto = str_replace('https://www.seculomanaus.com.br/academico/', base_url(),$texto_pronto);
        $texto_pronto = str_replace('http://www.seculomanaus.com.br/academico/', base_url(),$texto_pronto);
        $texto_pronto = strip_tags($texto_pronto, '<img><br/><br><sub><sup><em><table><tr><td><th><span><i><strong><ul><li><ol>');
        return($texto_pronto);
    }
    
    function formata_texto_com_richtext_alternativa($texto) {
        
        
        $DOM = new DOMDocument;
        
        $texto_pronto = str_replace('<div style="text-align: center;">', '',$texto);
        $texto_pronto = str_replace('<div>', '',$texto_pronto);
        $texto_pronto = str_replace('</div>', '<br/>',$texto_pronto);
        $texto_pronto = str_replace('https', 'http',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_0"', '',$texto_pronto);
        
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_0"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_1"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_2"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_3"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_4"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_5"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_6"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_7"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_start_8"', '',$texto_pronto);
        
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_0"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_1"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_2"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_3"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_4"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_5"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_6"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_7"', '',$texto_pronto);
        $texto_pronto = str_replace(' id="_baidu_bookmark_end_8"', '',$texto_pronto);
        
        $texto_pronto = preg_replace('/(<span class="mathquill-embedded-latex".+?)style=".+?"(>.+?)/i', "$1$2", $texto_pronto);
        
        $texto_pronto = str_replace('<div style="text-align: left;">', '<br/>',$texto_pronto);
        $texto_pronto = str_replace('<br/><br/><br/>', '<br/>',$texto_pronto);
        //$texto_pronto = str_replace('<br/><br/>', '<br/>',$texto_pronto);
        $texto_pronto = str_replace('<span style="display: none; line-height: 0px;">¿</span>', '',$texto_pronto);
        $texto_pronto = str_replace('<span style="display: none;">¿</span>', '',$texto_pronto);
         $texto_pronto = str_replace('<span style="font-size: 16px; line-height: 1.42857143;">','',$texto_pronto);
        $texto_pronto = str_replace('<label class="label label-danger">¿</label>', '',$texto_pronto);        
        
        $pos = strpos($texto_pronto,"mathquill-embedded-latex");
        
        if($pos == TRUE){
            $dom = new DOMDocument();
            @$dom->loadHTML($texto_pronto);

            $xpath = new DOMXPath($dom);
            $classname = "mathquill-embedded-latex";
            $nodes = $xpath->query("//*[@class='" . $classname . "']");

            foreach ($nodes as $node) {
                 $formula[] = $node->nodeValue;
            }

            //print_r($formula);exit;
            $texto_pronto = str_replace(''.$formula[0].'', '',$texto_pronto);
            $texto_pronto = str_replace('<span class="mathquill-embedded-latex" >', '<img src="http://latex.codecogs.com/gif.latex?'.$formula[0].'"/>',$texto_pronto);
        }
        
        // TRATA OS SUBLINHADOS (UNDERLINE)
        $pos = strpos($texto_pronto, "text-decoration:underline");
        for($ia = 0;$ia<=7;$ia++){
            if ($pos == TRUE) {
                preg_match_all('/<span style="text-decoration:underline;">(.+?)<\/span>/sm', $texto_pronto, $conteudo);
                $texto_pronto = str_replace($conteudo[0][0],'<span style="border-bottom: thin solid;">'.$conteudo[1][0].'</span>',$texto_pronto);
            }
        }
        
        // TRANSFORMA TEXTO TACHADO EM FONTE
        $pos = strpos($texto_pronto, "text-decoration: line-through;");
        for($ia = 0;$ia<=3;$ia++){
            if ($pos == TRUE) {
                preg_match_all('/<span style="text-decoration: line-through;">(.+?)<\/span>/sm', $texto_pronto, $conteudo);
                $texto_pronto = str_replace($conteudo[0][0],'</td></tr><tr><td colspan="2" style="text-align: right"><span style="color: #0075b0; font-size:8px;">Fonte: '.$conteudo[1][0].'</span><br>',$texto_pronto);
            }
        }
        
        $texto_pronto = str_replace('https://www.seculomanaus.com.br/academico/', base_url(),$texto_pronto);
        $texto_pronto = str_replace('http://www.seculomanaus.com.br/academico/', base_url(),$texto_pronto);
        
        $texto_pronto = strip_tags($texto_pronto, '<img><br/><br><sub><sup><em><table><tr><td><th><span><i><ol><ul><li>');
        return($texto_pronto);
    }

    function posicao() {
        $obj = & get_instance();
        $obj->load->model('banco/prova_model', 'banco', TRUE);


        // CONSULTA NO BANCO AS DISCIPLINAS DAS QUESTÕES
        // E SUAS POSIÇÕES INICIAIS E FINAIS
        $p = array(
            'operacao' => 'F',
            'prova' => $this->prova,
            'tipo' => $this->tipo,
            'disciplina' => $this->disciplina,
        );
        //print_r($p);
        $r = $obj->banco->prova_disciplina($p);


        // CONSULTA AS QUESTÕES DA PROVA PARA FILTRAR
        // E VERIFICAR A POSIÇÃO EM QUE ELA SE ENCONTRA

        $j = array(
            'operacao' => 'FK',
            'prova' => $this->prova,
        );
        $q = $obj->banco->prova_questao($j);



        // FAZ UM ARRAY COM AS POSIÇÕES
        // ARRAY COM A LISTA DE POSIÇÕES DAS QUESTÕES 
        // QUES ESTÃO INSERIDAS NO SISTEMA
        foreach ($q as $f) {
            $posicao[$f['POSICAO']] = $f['POSICAO'];
        }

        $string = '<option></option>';
        for ($i = $r[0]['POSICAO_INICIAL']; $i <= $r[0]['POSICAO_FINAL']; $i++) {

            // VERIFICA SE HÁ ALGUMA SELEÇÃO
            if ($this->selecao == $i) {
                $s = 'selected="selected"';
            } else {
                $s = '';
            }

            if ($posicao[$i] == $i) {
                $k = 'disabled';
            } else {
                $k = '';
            }
            //print_r($QP);
            $string .= '<option value="' . $i . '" ' . $s . ' ' . $k . '>' . $i . '</option>';
        }

        return($string);
    }

    function mix_opcoes($pa) {
        
        $obj = & get_instance();
        $obj->load->model('banco/prova_model', 'banco', TRUE);
        $opcoes = array(1, 2, 3, 4);

        if (is_array($opcoes)) {
            $keys = array_keys($opcoes); 
            $temp = $opcoes;
            $array = NULL;
            shuffle($temp);
            $topico = array_keys(array_flip($temp));

            foreach ($topico as $k => $it) {
                $p = array('operacao' => 'IO',
                              'prova' => $this->prova_nova, 
                            'questao' => $pa['questao'],
                              'opcao' => $it,
                            'posicao' => ($keys[$k]+1)
                    );
                $obj->banco->prova_espelho($p);
            }
            $e = array('operacao' => 'IO',
                              'prova' => $this->prova_nova, 
                            'questao' => $pa['questao'],
                              'opcao' => 5,
                            'posicao' => 5
            );
            $obj->banco->prova_espelho($e);
            return;
        }
        return false;
    }

    function mix_questoes($prova) {
        $obj = & get_instance();
        $obj->load->model('banco/prova_model', 'banco', TRUE);
        
        if (is_array($this->questoes)) {
            $keys = array_keys($this->questoes);
            $temp = $this->questoes;
            $array = NULL;
            shuffle($temp); // Array shuffle
            
            $topico = array_keys(array_flip($temp));
            
            foreach ($topico as $k => $item) {
                $p = array('operacao' => 'EP',
                              'prova' => $prova, 
                            'questao' => $item,
                            'posicao' => ($keys[$k]+1)
                    );
                $obj->banco->prova_espelho($p);
                
                $ps = array('prova' => $this->prova_nova, 
                          'questao' => $item
                    );
                $this->mix_opcoes($ps);
            }
            return;
        }
        return false;
    }
    
    function gerar_espelho() {
        $obj = & get_instance();
        $obj->load->model('banco/prova_model', 'banco', TRUE);
        
        $versao = ($this->qtdprovas - 1);

        for ($i = 1; $i <= $versao; $i++) {
            // INSERI A PROVA ESPELHO E GUARDA O CD_PROVA NOVO
            $this->prova_nova = $obj->banco->prova_espelho(array('operacao' => 'G','prova' => $this->prova));

            // PEGA O ARRAY COM AS QUESTÕES DA 
            $questao = $obj->banco->prova_questao(array('operacao' => 'FK','prova' => $this->prova_nova));

            echo 'PROVA ESPELHO Nº '.$this->prova_nova.' CRIADA COM SUCESSO ! <br/>';
            // EMBARALHAR AS QUESTÕES
            foreach($questao as $q){
                if($q['FLG_TIPO'] == 'O'){
                    $this->questoes[] = $q['CD_QUESTAO'];
                }
            }
            $this->mix_questoes($this->prova_nova);
        }
        return('Provas espelhos geradas!');
    }
    
    function resposta($p) {
        
        switch($p){
            case 1: 
                $r = 'A';
            break;
            case 2: 
                $r = 'B';
            break;
            case 3: 
                $r = 'C';
            break;
            case 4: 
                $r = 'D';
            break;
            case 5: 
                $r = 'E';
            case 6: // QUESTAO CANCELADA
                $r = '*';
            break;
        }
        return($r);
    }
    
    function prova_status($p) {

        switch($p){
            case 0: 
                $r = '<small class="label label-default">Finalizada</small>';
            break;
            case 1: 
                $r = '<small class="label label-primary">Elaboração</small>';
            break;
            case 2: 
                $r = '<small class="label label-info">Versões / Alunos</small>';
            break;
            case 3: 
                $r = '<small class="label label-danger">Cancelada</small>';
            break;
            case 4: 
                $r = '<small class="label label-danger">Reprografia / Produção</small>';
            break;
            case 5: 
                $r = '<small class="label label-info">Reprografia / Boneca</small>';
            case 6: 
                $r = '<small class="label label-info">Reprografia / Boneca</small>';
            break;
            case 7: 
                $r = '<small class="label label-info">Reprografia / Boneca</small>';
            break;
            case 8: 
                $r = '<small class="label label-info">Reprografia / Boneca</small>';
            break;
        }
        return($r);
    }
    
    
    
    function aluno_associar() {
        $obj = & get_instance();
        $obj->load->model('banco/prova_model', 'banco', TRUE);

        // Verifica a prova e suas versões
        $prova = $obj->banco->banco_prova(array('operacao'=>'FPV','prova'=>$this->prova));
        // Verifica os alunos que estão inscritos na prova
        $aluno = $obj->banco->prova_alunos(array('operacao'=>'LA','prova'=>$this->prova));
        
        // SEPARA APENAS OS CÓDIGOS DE PROVAS
        $idProva = array();
        $altProva = array();
        foreach($prova as $p){
            $idProva[] = $p['CD_PROVA'];
        }

        // SEPARA APENAS OS CÓDIGOS DE ALUNOS
        $idAluno = array();        
        foreach($aluno as $a){
            $idAluno[] = $a['CD_ALUNO'];
        }
        
        // Caso o numero de alunos seja igual ao numero de provas
        if(count($idAluno) ==  count($idProva)){
            shuffle($idProva);
            for ($i = 0; $i < count($idAluno); $i++) {
                $a = array(
                    'operacao' => 'UPD',
                    'prova' => $this->prova, 
                    'aluno' => $idAluno[$i],
                    'versao' => $idProva[$i]
                );
                //print_r($a);
                // ATUALIZA A INSCRIÇÃO DO ALUNO E SUA PROVA
                $alocar = $obj->banco->prova_aluno_inscritos($a);
            }
            return 'Alunos associados com sucesso!';
            
        }

        // CASO O NUMERO DE PROVA SEJA MENOR QUE O NUMERO DE ALUNOS
        elseif(count($idAluno) >  count($idProva)){

            // verifica o numero de alunos por prova
            $al = (int) (count($idAluno)/ count($idProva));
            
            // verifica o resto dos alunos depois da divisão
            $resto = (count($idAluno) % count($idProva));

            // contador para numero de alunos;
            $contador = ($al*count($idProva));

            // contador para numero de provas
            $cont = 1;
            $key = 0;
            
            for ($i = 0; $i < $contador; $i++) {
                $a = array(
                    'operacao' => 'UPD',
                    'prova' => $this->prova, 
                    'aluno' => $idAluno[$i],
                    'versao' => (($idProva[$key] != '' )? $idProva[$key] : $this->prova),
                    'id_versao' => $key,
                    'id_aluno' => $i,
                );
                //print_r($a);
                $alocar = $obj->banco->prova_aluno_inscritos($a);
                if($cont == $al){
                    $cont = 1;
                    $key = $key +1;
                }else
                    $cont = $cont+1;
            }

            // CADO HAJA RESTO NO MOD DOS ALUNOS / PROVAS
            if($resto > 0){
                $cont = 0;
                for ($j = 0; $j < $resto; $j++) {
                    $a = array(
                        'operacao' => 'UPD',
                        'prova' => $this->prova, 
                        'aluno' => $idAluno[$j],
                        'versao' => (($idProva[$cont] != '' )? $idProva[$cont] : $this->prova),
                        'id_versao' => $cont,
                        'id_aluno' => $j,
                    );
                    //print_r($a);
                    $alocar = $obj->banco->prova_aluno_inscritos($a);
                    if($cont == $resto) 
                        $cont = 0;
                    else
                        $cont = $cont+1;
                }
            }
            return 'Alunos associados com sucesso!';
        }else{
            return 'Número de Provas Diferente de quantidade de alunos.';
        }
    }
}

?>