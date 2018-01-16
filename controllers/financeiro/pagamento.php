<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pagamento extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('financeiro/mensalidade_model', 'mensalidade', TRUE);
        $this->load->model('financeiro/pagamento_model', 'pagamento', TRUE);
        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library(array('form_validation', 'session', 'logger', 'cielo'));
    }

    function index() {

        $this->session->unset_userdata('FRM_FORMA_PAGAMENTO');
        $this->session->unset_userdata('FRM_BANDEIRA');
        $this->session->unset_userdata('FRM_PRODUTO');
        $this->session->unset_userdata('FRM_TOTAL');

        $data = array(
            'titulo' => '<h1> Financeiro <i class="fa fa-angle-right"></i> Pagamento Online </h1>',
            'navegacao' => 'Financeiro > Mensalidade',
            'boleto' => $this->mensalidade->listar_boletos($parametro = array('operacao' => 'LBM',
                'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'))),
        );
        $this->load->view('financeiro/pagamento/index', $data);
    }

    function validacao() {

        $data = array(
            'titulo' => '<h1> <i class="fa fa-money"></i> Financeiro <i class="fa fa-angle-right"></i> Mensalidade  <i class="fa fa-angle-right"></i> Pagamento Online</h1>',
            'navegacao' => 'Financeiro > Mensalidade > Pagamento Online',
        );

        foreach ($this->input->post('produto') as $row) {
            $real = $row;
            $row = base64_decode($row);
            //echo $row;
            $l = explode(':', $row);
            $total = $total + $l[5];
        };

        $this->session->set_userdata('FRM_FORMA_PAGAMENTO', $this->input->post('formaPagamento'));
        $this->session->set_userdata('FRM_BANDEIRA', $this->input->post('codigoBandeira'));
        $this->session->set_userdata('FRM_PRODUTO', $this->input->post('produto'));
        $this->session->set_userdata('FRM_TOTAL', $total);

        $data['boleto'] = $this->mensalidade->listar_boletos($parametro = array('operacao' => 'LBM', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO')));
        $this->load->view('financeiro/pagamento/validacao', $data);
    }

    function pagamento_online() {

        $codigo = $this->pagamento->transacao($params = array('operacao' => 'MAX'));
        $codigo = $codigo[0]['CD_PAGAMENTO'] + 1;
        
        foreach ($this->session->userdata('FRM_PRODUTO') as $item) {
            $row = base64_decode($item);
            $r = explode(':', $row);

            $at = array(
                'operacao' => 'I',
                'codigo' => $codigo,
                'autenticacao' => '',
                'aluno' => $r[0],
                'produto' => $r[1],
                'mes' => $r[2],
                'parcela' => $r[3],
                'ordem' => $r[4],
                'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
                'bandeira' => $this->cielo->bandeira($this->session->userdata('FRM_BANDEIRA')),
                'tipo' => $this->cielo->tPagamento($this->session->userdata('FRM_FORMA_PAGAMENTO')),
                'qtd' => 1,
                'status' => 'ABERTA',
                'bolsa' => $r['8'],
                'multa' => $r['10'],
                'juros' => $r['11'],
                'desconto' => $r['9'],
                'recebido' => $r['5'],
            );
            $op = $this->pagamento->transacao($at);
        }

        $data = array(
            'codigo' => $codigo
        );
        $this->load->view('financeiro/pagamento/cielo', $data);
    }

    function retorno() {

        $data = array(
            'titulo' => '<h1> <i class="fa fa-money"></i> Financeiro <i class="fa fa-angle-right"></i> Mensalidade  <i class="fa fa-angle-right"></i> Pagamento Online</h1>',
            'navegacao' => 'Financeiro > Pagamento > Retorno de Transação',
        );
        
        if (($this->session->userdata('transacao'))) {
            
            $this->load->view('financeiro/pagamento/urls');
            // Resgata último pedido feito da SESSION
            $ultimoPedido = $this->session->userdata('transacao')->count();
            $ultimoPedido -= 1;
            $Pedido = new Cielo();

            $Pedido->FromString($this->session->userdata('transacao')->offsetGet($ultimoPedido));
            // Consulta situação da transação
            $objResposta = $Pedido->RequisicaoConsulta();
            // Atualiza status

            $Pedido->status = $objResposta->status;
            if ($Pedido->status == '4' || $Pedido->status == '6')
                $finalizacao = true;
            else
                $finalizacao = false;
            // Atualiza Pedido da SESSION
            $StrPedido = $Pedido->ToString();
            $this->session->userdata('transacao')->offsetSet($ultimoPedido, $StrPedido);

            $codigo = strval($Pedido->dadosPedidoNumero);
            $tid = strval($Pedido->tid);
            //htmlentities($objResposta->asXML());
            
            $data['dadosPedidoNumero'] = $Pedido->dadosPedidoNumero; // PEGA O CODIGO DO PEDIDO
            $data['tid'] = $Pedido->tid;                             // PEGA O NUMERO DA TRANSAÇÃO DO PEDIDO CIELO
            $data['finalizacao'] = $finalizacao ? "sim" : "não";     // PEGA O STATUS DE FECHAMENTO DA TRANSAÇÃO
            $data['status'] = $Pedido->getStatus();                  // PEGA O STATUS DA TRANSAÇÃO CIELO


            if ($Pedido->getStatus() == 'Autorizada') {
                $at = array(
                    'operacao' => 'UPD',
                    'codigo' => $codigo,
                    'autenticacao' => $tid,
                    'status' => 'AUTORIZADO'
                );
                //print_r($at);
                $op = $this->pagamento->transacao($at);

                
                foreach ($this->session->userdata('FRM_PRODUTO') as $item) {
                    $row = base64_decode($item);
                    $r = explode(':', $row);
                    $params = array(
                        'operacao' => 'LANCAR',
                        'codigo' => $codigo,
                        'autenticacao' => $tid,
                        'aluno' => $r[0],
                        'produto' => $r[1],
                        'mes' => $r[2],
                        'parcela' => $r[3],
                        'ordem' => $r[4],
                        'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
                        'cartao' => $this->cielo->bandeira($this->session->userdata('FRM_BANDEIRA')),
                        'tipo' => $this->cielo->tPagamento($this->session->userdata('FRM_FORMA_PAGAMENTO')),
                        'status' => 'AUTORIZADO',
                        'recebido' => $r['5'],
                        'historico' => "Pagto. ONLINE com Cartão (" .strtoupper($this->session->userdata('FRM_BANDEIRA')) .'/'. $this->cielo->tPagamento($this->session->userdata('FRM_FORMA_PAGAMENTO')). ") || (" . $r[7] .'-'. $r[2]. ") do Aluno(a) " . $r[6] ."",
                    );
                    //PRINT_R($params);
                    $this->pagamento->lancar_pagamento($params);
                }
            } else {
                $at = array(
                    'operacao' => 'UPD',
                    'codigo' => $codigo,
                    'autenticacao' => $tid,
                    'status' => 'CANCELADO'
                );
                $op = $this->pagamento->transacao($at);
            }
        } else {

            echo 'Erro de sessão | Entre em contato com o Administrador do Sistema | 92 3211-0191';

            echo $ultimoPedido = $this->session->userdata('transacao')->count();
            echo $ultimoPedido -= 1;
        }
        

      $this->load->view('financeiro/pagamento/retorno', $data);
    }

}