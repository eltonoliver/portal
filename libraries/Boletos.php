<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Boletos {

    // DADOS DO BOLETO PARA O SEU CLIENTE
    public $dias_de_prazo_para_pagamento = 5;
    public $taxa_boleto = 0;
    public $vencimento;
    public $valor_cobrado; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
    public $nosso_numero;  // Nosso numero - REGRA: Máximo de 8 caracteres!
    public $numero_documento; // Num do pedido ou nosso numero
    public $data_documento; // Data de emissão do Boleto
    public $data_processamento; // Data de processamento do boleto (opcional)
    public $valor_boleto;  // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
    // DADOS DO SEU CLIENTE
    public $sacado;
    public $sacado_cpf;
    public $endereco1;
    public $endereco2;
    // INFORMACOES PARA O CLIENTE
    public $instrucoes;
    // DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
    public $quantidade;
    public $valor_unitario;
    public $aceite = "N";
    public $especie = "R$";
    public $especie_doc = "ME";
    public $moeda = 9;
    // ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
    // DADOS DA SUA CONTA 
    public $codigo_banco;                 // CÓDIGO DO BANCO
    public $agencia;                      // Num da agencia, sem digito
    public $agencia_digito;               // Num da agencia  digito
    public $conta;                        // Num da conta, sem digito
    public $conta_dv;                     // Digito do Num da conta
    public $convenio;                     // Digito do Num da conta
    public $contrato;                     // Número do contrato
    public $validcao_carteira;            // Número da validacao da carteira
    public $formatacao_convenio = 7;      // Número formatacao do convenio
    public $formatacao_nosso_numero = 1;  // formatacao nosso numero
    // DADOS PERSONALIZADOS 
    public $carteira;                     // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157
    // SEUS DADOS
    public $cpf_cnpj;
    public $endereco;
    public $cidade_uf;
    public $cedente;

    function txtBanco() {

        switch ($this->codigo_banco) {
            case "001":
                $txt = '<div style="font-size:8.3px">ATÉ O VENCIMENTO PREFERENCIALMENTE NO BANCO DO BRASIL, APÓS, SOMENTE NO BANCO DO BRASIL</div>';
                break;
            case 341:
                $txt = 'ATÉ O VENCIMENTO, PREFERENCIALMENTE NO BANCO ITAU, APÓS, SOMENTE NO BANCO ITAU S/A';
                break;
        }
        return $txt;
    }

    function nossoNumero() {

        switch ($this->codigo_banco) {
            case "001":
                $nosso = $this->formata_numero(substr($this->nosso_numero, 0, 17), 10, 0);
                $digito = $this->formata_numero(substr($this->nosso_numero, 17, 1), 1, 0);
                $nossonumero = $nosso . '.' . $digito;
                break;
            case 341:
                $nosso = $this->formata_numero(substr($this->nosso_numero, 0, 8), 8, 0);
                $digito = $this->formata_numero(substr($this->nosso_numero, 8, 1), 1, 0);
                $nossonumero = $this->carteira . '/' . $nosso . '-' . $digito;
                break;
        }
        return $nossonumero;
    }

    function digitoVerificador_barra($numero) {
        $resto2 = $this->modulo_11($numero, 9, 1);
        $digito = 11 - $resto2;
        if ($digito == 0 || $digito == 1 || $digito == 10 || $digito == 11) {
            $dv = 1;
        } else {
            $dv = $digito;
        }
        return $dv;
    }

    function formata_numero($numero, $loop, $insert, $tipo = "geral") {
        if ($tipo == "geral") {
            $numero = str_replace(",", "", $numero);
            while (strlen($numero) < $loop) {
                $numero = $insert . $numero;
            }
        }
        if ($tipo == "valor") {
            $numero = str_replace(",", "", $numero);
            while (strlen($numero) < $loop) {
                $numero = $insert . $numero;
            }
        }
        if ($tipo == "convenio") {
            while (strlen($numero) < $loop) {
                $numero = $numero . $insert;
            }
        }
        return $numero;
    }

    function esquerda($entra, $comp) {
        return substr($entra, 0, $comp);
    }

    function direita($entra, $comp) {
        return substr($entra, strlen($entra) - $comp, $comp);
    }

    function fbarcode($valor) {

        $fino = 1;
        $largo = 3;
        $altura = 50;
        $barras_geral = "";

        $barcodes[0] = "00110";
        $barcodes[1] = "10001";
        $barcodes[2] = "01001";
        $barcodes[3] = "11000";
        $barcodes[4] = "00101";
        $barcodes[5] = "10100";
        $barcodes[6] = "01100";
        $barcodes[7] = "00011";
        $barcodes[8] = "10010";
        $barcodes[9] = "01010";

        for ($f1 = 9; $f1 >= 0; $f1--) {
            for ($f2 = 9; $f2 >= 0; $f2--) {
                $f = ($f1 * 10) + $f2;
                $texto = "";
                for ($i = 1; $i < 6; $i++) {
                    $texto .= substr($barcodes[$f1], ($i - 1), 1) . substr($barcodes[$f2], ($i - 1), 1);
                }
                $barcodes[$f] = $texto;
            }
        }


        //Desenho da barra
        //Guarda inicial
        $barras_geral .= '<img src="' . SCL_IMG . 'boleto/p.png" width="' . $fino . '" height="' . $altura . '" border="0" />';
        $barras_geral .= '<img src="' . SCL_IMG . 'boleto/b.png" width="' . $fino . '" height="' . $altura . '" border="0" />';
        $barras_geral .= '<img src=' . SCL_IMG . 'boleto/p.png" width="' . $fino . '" height="' . $altura . '" border="0" />';
        $barras_geral .= '<img src="' . SCL_IMG . 'boleto/b.png" width="' . $fino . '" height="' . $altura . '" border="0" />';



        $texto = $valor;
        if ((strlen($texto) % 2) <> 0) {
            $texto = "0" . $texto;
        }

        // Draw dos dados
        while (strlen($texto) > 0) {
            $i = round($this->esquerda($texto, 2));
            $texto = $this->direita($texto, strlen($texto) - 2);
            $f = $barcodes[$i];
            for ($i = 1; $i < 11; $i+=2) {
                if (substr($f, ($i - 1), 1) == "0") {
                    $f1 = $fino;
                } else {
                    $f1 = $largo;
                }

                $barras_geral .= '<img src="' . SCL_IMG . 'boleto/p.png" width="' . $f1 . '" height="' . $altura . '" border="0" />';

                if (substr($f, $i, 1) == "0") {
                    $f2 = $fino;
                } else {
                    $f2 = $largo;
                }
                $barras_geral .= '<img src="' . SCL_IMG . 'boleto/b.png" width="' . $f2 . '" height="' . $altura . '" border="0" />';
            }
        }

        // Draw guarda final
        $barras_geral .= '<img src="' . SCL_IMG . 'boleto/p.png" width="' . $largo . '" height="' . $altura . '" border="0" />';
        $barras_geral .= '<img src="' . SCL_IMG . 'boleto/b.png" width="' . $fino . '" height="' . $altura . '" border="0" />';
        $barras_geral .= '<img src="' . SCL_IMG . 'boleto/p.png" width="1"; height="' . $altura . '" border="0" />';

        return ($barras_geral);
    }

    function fator_vencimento() {
        $data = explode("/", $this->vencimento);
        $ano = $data[2];
        $mes = $data[1];
        $dia = $data[0];
        return(abs(($this->_dateToDays("1997", "10", "07")) - ($this->_dateToDays($ano, $mes, $dia))));
    }

    function _dateToDays($year, $month, $day) {
        $century = substr($year, 0, 2);
        $year = substr($year, 2, 2);
        if ($month > 2) {
            $month -= 3;
        } else {
            $month += 9;
            if ($year) {
                $year--;
            } else {
                $year = 99;
                $century--;
            }
        }
        return ( floor(( 146097 * $century) / 4) +
                floor(( 1461 * $year) / 4) +
                floor(( 153 * $month + 2) / 5) +
                $day + 1721119);
    }

    function modulo_10($num) {
        $numtotal10 = 0;
        $fator = 2;

        // Separacao dos numeros
        for ($i = strlen($num); $i > 0; $i--) {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num, $i - 1, 1);
            // Efetua multiplicacao do numero pelo (falor 10)
            $temp = $numeros[$i] * $fator;
            $temp0 = 0;
            foreach (preg_split('//', $temp, -1, PREG_SPLIT_NO_EMPTY) as $k => $v) {
                $temp0+=$v;
            }
            $parcial10[$i] = $temp0; //$numeros[$i] * $fator;
            // monta sequencia para soma dos digitos no (modulo 10)
            $numtotal10 += $parcial10[$i];
            if ($fator == 2) {
                $fator = 1;
            } else {
                $fator = 2; // intercala fator de multiplicacao (modulo 10)
            }
        }

        // várias linhas removidas, vide função original
        // Calculo do modulo 10
        $resto = $numtotal10 % 10;
        $digito = 10 - $resto;
        if ($resto == 0) {
            $digito = 0;
        }

        return $digito;
    }

    function modulo_11($num, $base = 9, $r = 0) {
        /**
         *   Função:
         *    Calculo do Modulo 11 para geracao do digito verificador 
         *    de boletos bancarios conforme documentos obtidos 
         *    da Febraban - www.febraban.org.br 
         *
         *   Entrada:
         *     $num: string numérica para a qual se deseja calcularo digito verificador;
         *     $base: valor maximo de multiplicacao [2-$base]
         *     $r: quando especificado um devolve somente o resto
         *
         *   Saída:
         *     Retorna o Digito verificador.
         *
         *   Observações:
         *     - Script desenvolvido sem nenhum reaproveitamento de código pré existente.
         *     - Assume-se que a verificação do formato das variáveis de entrada é feita antes da execução deste script.
         */
        $soma = 0;
        $fator = 2;

        /* Separacao dos numeros */
        for ($i = strlen($num); $i > 0; $i--) {
            // pega cada numero isoladamente
            $numeros[$i] = substr($num, $i - 1, 1);
            // Efetua multiplicacao do numero pelo falor
            $parcial[$i] = $numeros[$i] * $fator;
            // Soma dos digitos
            $soma += $parcial[$i];
            if ($fator == $base) {
                // restaura fator de multiplicacao para 2 
                $fator = 1;
            }
            $fator++;
        }

        /* Calculo do modulo 11 */
        if ($r == 0) {
            $soma *= 10;
            $digito = $soma % 11;

            if ($this->codigo_banco == 1) {
                //corrigido
                if ($digito == 10) {
                    $digito = "X";
                }
            } else {

                if ($digito == 10) {
                    $digito = 0;
                }
            }

            if (strlen($num) == "43" && $this->codigo_banco == 1) {
                //então estamos checando a linha digitável
                if ($digito == "0" or $digito == "X" or $digito > 9) {
                    $digito = 1;
                }
            }

            return $digito;
        } elseif ($r == 1) {
            $resto = $soma % 11;
            return $resto;
        }
    }

    // LINHA DIGITAL DO BANCO
    function monta_linha_digitavel() {
        $codigo = $this->codigo_barras();

        switch ($this->codigo_banco) {
            case "001":
                // Posição Conteúdo
                // 5        Digito verificador do Código de Barras
                // 6 a 19   Valor (12 inteiros e 2 decimais)
                // 20 a 44  Campo Livre definido por cada banco
                // 1. Campo - composto pelo código do banco, código da moéda, as cinco primeiras posições
                // do campo livre e DV (modulo10) deste campo
                $p1 = substr($codigo, 0, 4); // 1 a 3 - Número do banco // 4 - Código da Moeda - 9 para Real
                $p2 = substr($codigo, 19, 5);
                $p3 = $this->modulo_10("$p1$p2");
                $p4 = "$p1$p2$p3";
                $p5 = substr($p4, 0, 5);
                $p6 = substr($p4, 5);
                $campo1 = "$p5.$p6";

                // 2. Campo - composto pelas posiçoes 6 a 15 do campo livre
                // e livre e DV (modulo10) deste campo
                $p1 = substr($codigo, 24, 10);
                $p2 = $this->modulo_10($p1);
                $p3 = "$p1$p2";
                $p4 = substr($p3, 0, 5);
                $p5 = substr($p3, 5);
                $campo2 = "$p4.$p5";

                // 3. Campo composto pelas posicoes 16 a 25 do campo livre
                // e livre e DV (modulo10) deste campo
                $p1 = substr($codigo, 34, 10);
                $p2 = $this->modulo_10($p1);
                $p3 = "$p1$p2";
                $p4 = substr($p3, 0, 5);
                $p5 = substr($p3, 5);
                $campo3 = "$p4.$p5";

                // 4. Campo - digito verificador do codigo de barras
                $campo4 = substr($codigo, 4, 1);

                // 5. Campo composto pelo valor nominal pelo valor nominal do documento, sem
                // indicacao de zeros a esquerda e sem edicao (sem ponto e virgula). Quando se
                // tratar de valor zerado, a representacao deve ser 000 (tres zeros).
                $campo5 = substr($codigo, 5, 14);
                break;
            case 341:
                // campo 1
                $banco = substr($codigo, 0, 3);
                $moeda = substr($codigo, 3, 1);
                $ccc = substr($codigo, 19, 3);
                $ddnnum = substr($codigo, 22, 2);

                $dv1 = $this->modulo_10($banco . $moeda . $ccc . $ddnnum);
                // campo 2
                $resnnum = substr($codigo, 24, 6);
                $dac1 = substr($codigo, 30, 1); //modulo_10($agencia.$conta.$carteira.$nnum);
                $dddag = substr($codigo, 31, 3);
                $dv2 = $this->modulo_10($resnnum . $dac1 . $dddag);
                // campo 3
                $resag = substr($codigo, 34, 1);
                $contadac = substr($codigo, 35, 6); //substr($codigo,35,5).modulo_10(substr($codigo,35,5));
                $zeros = substr($codigo, 41, 3);
                $dv3 = $this->modulo_10($resag . $contadac . $zeros);
                // campo 4
                $dv4 = substr($codigo, 4, 1);
                // campo 5
                $fator = substr($codigo, 5, 4);
                $valor = substr($codigo, 9, 10);

                $campo1 = substr($banco . $moeda . $ccc . $ddnnum . $dv1, 0, 5) . '.' . substr($banco . $moeda . $ccc . $ddnnum . $dv1, 5, 5);
                $campo2 = substr($resnnum . $dac1 . $dddag . $dv2, 0, 5) . '.' . substr($resnnum . $dac1 . $dddag . $dv2, 5, 6);
                $campo3 = substr($resag . $contadac . $zeros . $dv3, 0, 5) . '.' . substr($resag . $contadac . $zeros . $dv3, 5, 6);
                $campo4 = $dv4;
                $campo5 = $fator . $valor;
                break;
        }

        return "$campo1 $campo2 $campo3 $campo4 $campo5";
    }

    function geraCodigoBanco() {
        $parte1 = substr($this->codigo_banco, 0, 3);
        $parte2 = $this->modulo_11($parte1);
        return $parte1 . "-" . $parte2;
    }

    function monta_agencia() {
        switch ($this->codigo_banco) {
            case 1:
                //$agencia = $this->agencia . "-" . $this->modulo_11($this->agencia) . " / " . $this->conta . "-" . $this->modulo_11($this->conta);
                $agencia = $this->agencia .'-'. $this->agencia_digito .' / ' . str_pad($this->conta , 5, "0", STR_PAD_LEFT) . '-'.$this->conta_dv;
                break;
            case 341:
                $agencia = $this->agencia . ' / ' . $this->conta . '-' . $this->conta_dv;
                break;
        }
        return $agencia;
    }

    function codigo_barras() {

        switch ($this->codigo_banco) {

            case 1:
                $codigo_barras = $this->codigo_banco .
                        $this->moeda .
                        $this->modulo_11($this->codigo_banco .
                                $this->moeda .
                                $this->fator_vencimento() .
                                $this->formata_numero($this->valor_boleto, 10, 0, "valor") .
                                "000000" .
                                $this->formata_numero(substr($this->nosso_numero, 0, 17), 17, 0) .
                                $this->carteira) .
                        $this->fator_vencimento() .
                        $this->formata_numero($this->valor_boleto, 10, 0, "valor") .
                        "000000" .
                        $this->formata_numero(substr($this->nosso_numero, 0, 17), 17, 0) .
                        $this->carteira;

                break;
            case 341:
                if ($this->carteira == 112) {
                    $conta = $this->conta_dv;
                }
                else
                    $conta = '';

                $codigo = $this->codigo_banco .
                        $this->moeda .
                        $this->fator_vencimento() .
                        $this->formata_numero($this->valor_boleto, 10, 0, "valor") .
                        $this->carteira .
                        substr($this->nosso_numero, 0, 8) .
                        $this->modulo_10(
                                $this->agencia .
                                $this->conta .
                                $conta .
                                $this->carteira .
                                substr($this->nosso_numero, 0, 8)
                        ) .
                        $this->agencia .
                        $this->conta .
                        $this->modulo_10($this->agencia . $this->conta) .
                        '000';
                $codigo_barras = substr($codigo, 0, 4) . $this->digitoVerificador_barra($codigo) . substr($codigo, 4, 43);
                break;
        }
        //echo $codigo_barras;exit;
        return ($codigo_barras);
    }

    public function montar_boleto() {

        $ci = & get_instance();


        //echo $this->codigo_barras();
        //echo '<br/>';
        //echo $this->monta_linha_digitavel();
        //exit;

        return $data = array(
            'cedente' => $this->cedente,
            'cedente_cnpj' => 'CNPJ:' . $this->cpf_cnpj,
            'cedente_endereco' => $this->endereco . $this->cidade_uf,
            'vencimento' => $this->vencimento,
            'linhaDigitavel' => $this->monta_linha_digitavel(),
            'valorBoleto' => $this->valor_boleto,
            'codigo_banco_com_dv' => $this->geraCodigoBanco(),
            'codigoBanco' => $this->codigo_banco,
            'codigoBarras' => $this->codigo_barras(),
            'agencia' => $this->monta_agencia(),
            // DADOS DO DOCUMENTO LADO ESQUERDO
            'data_doc' => date('d/m/Y'),
            'numero_doc' => $this->numero_documento,
            'aceite' => $this->aceite,
            'especie' => $this->especie,
            'dt_processamento' => date('d/m/Y'),
            'carteira' => $this->carteira,
            // DADOS DO DOCUMENTO LADO DIREITO
            'vencimento' => $this->vencimento,
            'nosso_numero' => $this->nossoNumero(),
            'valor_documento' => '',
            'desconto' => '',
            'outos_descontos' => '',
            'mora_multa' => '',
            'outras_multas' => '',
            'valor_cobrado' => $this->valor_boleto,
            // INSTRUÇÕES DO DOCUMENTO
            'instrucao' => $this->instrucoes,
            //MONTA O CÓDIGO DE BARRAS
            'barras' => $this->fbarcode($this->monta_linha_digitavel()),
            // DADOS DO SACADO
            'sacado' => $this->sacado,
            'sacado_cpf' => $this->sacado_cpf,
            'codigo_baixa' => $this->nossoNumero(),
            'txtbanco' => $this->txtBanco(),
        );
    }

}

?>