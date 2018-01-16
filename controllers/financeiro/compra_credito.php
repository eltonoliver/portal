<?php 
if ( ! defined('BASEPATH')) 
    exit('No direct script access allowed');


// Controller para compra de crédito feito pelo portal

class Compra_credito extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        
        $this->load->model('financeiro/pagamento_model', 'pagamento', TRUE);
        $this->load->model('responsavel_model', 'responsavel', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'transacao_lib', 'table'));
    }
    function index(){

        $listar = $this->responsavel->acompanhamento(array('operacao' => 'L', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO')));

        $template = array(
            'table_open' => '<table class="table" style="font-size:11px">'
        );
        $this->table->set_template($template);

        foreach($listar as $l){
            $this->table->add_row(
            array('',
                array('data' => $l['CD_ALUNO'].' - '.$l['NM_ALUNO'], 'width' => '70%'),
                form_input(array('name' => 'credito[]['.$l['CD_ALUNO'].']', 
                                'class' => 'form-control aluno', 
                                 'type' => 'number', 
                                  'min' => '0', 
                                'style' => 'text-align: right')),
                ',00'
            ));
        }
        $alunos = $this->table->generate($rows);
        
        $data = array(
            'alunos' => $alunos,
        );
        $this->load->view('financeiro/compra_credito/index', $data);
    }

    function finalizar_transacao($param){

        if ($param['status'] === true) {
            $at = array(
                'operacao' => 'UPD',
                'codigo' => $param['codigo'],
                'autenticacao' => $param['tid'],
                'status' => 'AUTORIZADO'
            );
            //print_r($at);
            $this->pagamento->transacao($at);

            // ABRE A UMA NOVA TRANSAÇÃO COM A CLASS CIELO
            /*$Pedido = new Transacao_lib();  

            foreach ($param['alunos'] as $item) {

                $params = array(
                    'operacao' => 'CREDITO',
                    'codigo' => $param['codigo'],
                    'autenticacao' => $param['tid'],
                    'aluno' => $item['cd_aluno'],
                    'produto' => '',
                    'mes' => '',
                    'parcela' => '',
                    'ordem' => '',
                    'responsavel' => $param['cpf'],
                    'cartao' => $Pedido->bandeira($param['bandeira']),
                    'tipo' => $Pedido->tPagamento($param['tipo']),
                    'status' => 'AUTORIZADO',
                    'recebido' => $item['vl_credito'],
                    'historico' => "Pagto. ONLINE com Cartão (" .strtoupper($param['bandeira']) .' / '. $Pedido->tPagamento($param['tipo']). " TRANSAÇÃO Nº ".$param['codigo']." ) para Crédito do Aluno(a) " . $item['nm_aluno'] ." - VIA PORTAL",
                    'conta' => 12,
                );
                $this->pagamento->lancar_pagamento($params);                
            }*/
        } else {
            $at = array(
                'operacao' => 'UPD',
                'codigo' => $param['codigo'],
                'autenticacao' => $param['tid'],
                'status' => 'CANCELADO'
            );
            $this->pagamento->transacao($at);
        }
    }

    function transacao(){
        
        // ABRE A UMA NOVA TRANSAÇÃO COM A CLASS CIELO
        $Pedido = new Transacao_lib();  
        
        // ABRE A PROXIMA TRANSAÇÃO 
        $codigo = $this->pagamento->transacao($params = array('operacao' => 'MAX'));
        $codigo = $codigo[0]['CD_PAGAMENTO'] + 1;
        
        // INICIA O CONTADOR DA ORDEM DE TRANSAÇÃO
        $ordem = 0;
        $alunos = array();
        foreach ($this->input->post('credito') as $key =>$item) {
            $chave = key($item);
            $l = $this->responsavel->acompanhamento(array('operacao' => 'FA', 'aluno' => $chave ));
                    
            if($item[$chave] > 0){
                $alunos[] = array(
                    'cd_aluno' => $chave,
                    'nm_aluno' => $l[0]['NM_ALUNO'],
                    'vl_credito' => $item[$chave],
                );
            }
        }

        // INSERE A TRANSACAO NO BANCO
        foreach ($alunos as $item) {
            $at = array(
                'operacao' => 'I',
                  'codigo' => $codigo,
            'autenticacao' => '',
                   'aluno' => $item['cd_aluno'],
                 'produto' => '',
                     'mes' => '',
                 'parcela' => '',
                   'ordem' => '',
             'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
                'bandeira' => $Pedido->bandeira($this->input->post('Bandeira')),
                    'tipo' => $Pedido->tPagamento($this->input->post('FormaPagamento')),
                     'qtd' => 1,
                  'status' => 'ABERTA',
                   'bolsa' => 0,
                   'multa' => 0,
                   'juros' => 0,
                'desconto' => 0,
                'recebido' => $item['vl_credito'],
                'id_ordem' => $ordem,
            );
            $rs = $this->pagamento->transacao($at);
            $ordem = $ordem+1;
        }

        $validade = explode('/',$this->input->post('Vencimento'));

	// Lê dados do $_POST
	$Pedido->formaPagamentoBandeira = $this->input->post('Bandeira');
	$Pedido->formaPagamentoProduto  = $this->input->post('FormaPagamento');
        $Pedido->dadosPortadorNome      = $this->input->post('Nome');
	$Pedido->dadosPortadorNumero    = str_replace(' ','', $this->input->post('Cartao'));
	$Pedido->dadosPortadorVal       = $validade[1].$validade[0];
        $Pedido->dadosPortadorCodSeg    = $this->input->post('Cvc');

	// Verifica se Código de Segurança foi informado e ajusta o indicador corretamente
        if ($this->input->post('Cvc') == null || $this->input->post('Cvc') == ""){
            $Pedido->dadosPortadorInd = "0";
	}else if ($this->input->post('Bandeira') == "mastercard"){
            $Pedido->dadosPortadorInd = "1";
	}else {
            $Pedido->dadosPortadorInd = "1";
	}

        // 
	$Pedido->dadosPedidoNumero = $codigo; //rand(1000000, 9999999);
	$Pedido->dadosPedidoValor = str_replace('.','',$this->input->post('Total'));
        $Pedido->urlRetorno = $Pedido->ReturnURL();
        
        
        if($this->input->post('FormaPagamento') == 'A'){
            // TRANSAÇÃO VIA CARTÃO DE DÉBITO
            $objResposta = $Pedido->RequisicaoTransacao(true);
	}else{
            // AUTORIZAÇÃO DIRETA 
            $objResposta = $Pedido->RequisicaoTid();
            $Pedido->tid = $objResposta->tid;
            $Pedido->pan = $objResposta->pan;
            $Pedido->status = $objResposta->status;
            $objResposta = $Pedido->RequisicaoAutorizacaoPortador();
	}

        // 
	$Pedido->tid = $objResposta->tid;
	$Pedido->pan = $objResposta->pan;
	$Pedido->status = $objResposta->status;
	
        // 
	$urlAutenticacao = "url-autenticacao";
	$Pedido->urlAutenticacao = $objResposta->$urlAutenticacao;
	
	// Serializa Pedido e guarda na SESSION
	$StrPedido = $Pedido->ToString();
        
        $_SESSION["pedidos"] = new ArrayObject();
        $_SESSION["transacao"] = new ArrayObject();
        
	$_SESSION["pedidos"]->append($StrPedido);
        
        

        // AUTORIZAÇÃO DIRETA
        $ultimoPedido = $_SESSION["pedidos"]->count();
        $ultimoPedido -= 1;

        $Pedido->FromString($_SESSION["pedidos"]->offsetGet($ultimoPedido));

        // Consulta situação da transação
        $objResposta = $Pedido->RequisicaoConsulta();

        // Atualiza status
        $Pedido->status = $objResposta->status;
        if($Pedido->status == '4' || $Pedido->status == '6')
            $finalizacao = true;
        else
            $finalizacao = false;

        // Atualiza Pedido da SESSION
        $StrPedido = $Pedido->ToString();

        //$_SESSION["pedidos"] = new ArrayObject();
        $_SESSION["pedidos"]->offsetSet($ultimoPedido, $StrPedido);

        // LANÇAMENTO NO CONTAS A RECEBER
        $param = array(
            'codigo'   => $codigo,
            'alunos'   => $alunos,
            'tid'      => ''.$Pedido->tid.'',
            'status'   => $finalizacao,
            'cpf'      => $this->session->userdata('SCL_SSS_USU_CODIGO'),
            'tipo'     => $this->input->post('FormaPagamento'),
            'bandeira' => $this->input->post('Bandeira'),
        );
        $this->finalizar_transacao($param);
        // RETORNO PARA O APP
        $data = array(
            'pededo ' => $Pedido->dadosPedidoNumero,
            'transacao' => $Pedido->tid,
            'status' => $Pedido->getStatus(),
            'idstatus' => $Pedido->status
        );
        $this->load->view('financeiro/compra_credito/frmRetorno', $data);
        
    }

}