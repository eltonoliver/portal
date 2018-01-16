<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Boleto extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("sica/responsavel_model", "responsavel", true);
        $this->load->model("financeiro/pagamento_model", "pagamento", true);

        $this->load->model('financeiro/mensalidade_model', 'mensalidade', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'funcoes'));
        $this->load->library(array('form_validation', 'session', 'logger', 'cielo', 'boletos', 'codigobarras'));
    }

    function index() {
        $data = array(
            'titulo' => '<h1> Financeiro <i class="fa fa-angle-right"></i> Mensalidade</h1>',
            'mensalidade' => $this->mensalidade->listar_boletos($parametro = array('operacao' => 'LBM', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'))),
            'protesto' => $this->mensalidade->listar_boletos($parametro = array('operacao' => 'LBP', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO')))
        );

        $this->load->view('financeiro/mensalidade/index', $data);
    }

    function protesto() {

        $data = array(
            'titulo' => '<h1> Financeiro <i class="fa fa-angle-right"></i> Títulos Protestados</h1>',
            'boleto' => $this->mensalidade->listar_boletos($parametro = array('operacao' => 'LBP', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO')))
        );
        $this->load->view('financeiro/mensalidade/protesto', $data);
    }

    function barras() {
        $barras = $this->input->get('barras');
        new CodigoBarras($barras, 0, 'boleto.gif', 450, 60, false);
    }

    function imprimir() {

        $parametro = array(
            'aluno' => $this->input->get_post('aluno'),
            'produto' => $this->input->get_post('produto'),
            'referencia' => $this->input->get_post('mes'),
            'parcela' => $this->input->get_post('parcela'),
            'ordem' => $this->input->get_post('ordem'),
            'protesto' => $this->input->get_post('protesto'),
        );

        if ($this->input->get_post('protesto')) {
            $data['boleto'] = $this->mensalidade->imprimir_protesto($parametro); //BOLETO PROTESTADO
        } else {
            $data['boleto'] = $this->mensalidade->imprimir($parametro); // BOLETO NÃO PROTESTADO
        }

        //     print_r($data['boleto']);
        //    exit;
        if ($data['boleto'][0]['DT_VENCIMENTO'] != NULL) {

            $dados = new boletos(); // CRIA UMA NOVA INSTANCIA DA BIBLIOTECA "BOLETOS"
            $dados->dias_de_prazo_para_pagamento = 5;
            $dados->taxa_boleto = 0;
            $dados->vencimento = formata_data($data['boleto'][0]['DT_VENCIMENTO'], 'br'); //date('d/m/Y', strtotime($data['boleto'][0]['DT_VENCIMENTO']));
            $dados->valor_cobrado = ($data['boleto'][0]['VALOR_BOLETO']); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal

            $dados->nosso_numero = $data['boleto'][0]['NOSSO_NUMERO'];  // Nosso numero - REGRA: Máximo de 8 caracteres!

            $item = explode('/', $data['boleto'][0]['MES_REFERENCIA']);

            $dados->numero_documento = $data['boleto'][0]['CD_ALUNO'] . $item[1] . $item[0]; // Num do pedido ou nosso numero

            $dados->data_documento = $data['boleto'][0]['DT_VENCIMENTO']; // Data de emissão do Boleto
            $dados->data_processamento = $data['boleto'][0]['DT_VENCIMENTO']; // Data de processamento do boleto (opcional)
            $dados->valor_boleto = number_format($data['boleto'][0]['VALOR_BOLETO'], 2, ',', '');  // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
            ///*********************************************** DADOS DO RESPONSAVEL FINANCEIRO
            $dados->sacado = $data['boleto'][0]['NM_RESPONSAVEL'];
            $dados->sacado_cpf = ' - CPF: ' . $data['boleto'][0]['RES_CPF'];

            ///*********************************************** INFORMACOES PARA O CLIENTE
            $dados->instrucoes = $data['boleto'][0]['INSTR01'] . '<br/>' .
                    $data['boleto'][0]['INSTR02'] . '<br/>' .
                    $data['boleto'][0]['INSTR03'] . '<br/>' .
                    $data['boleto'][0]['INSTR04'] . '<br/>' .
                    $data['boleto'][0]['INSTR05'] . '<br/>' .
                    $data['boleto'][0]['INSTR06'] . '<br/>' .
                    $data['boleto'][0]['MSG01'] . '<br/>' .
                    $data['boleto'][0]['MSG02'] . '<br/>' .
                    $data['boleto'][0]['MSG03'];

            ///*********************************************** DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
            $dados->quantidade = "";
            $dados->valor_unitario = "";
            $dados->aceite = "N";
            $dados->especie = "R$";
            $dados->especie_doc = "ME";

            ///*********************************************** DADOS DA SUA CONTA
            $dados->codigo_banco = str_pad($data['boleto'][0]['CD_BANCO'], 3, "0", STR_PAD_LEFT);
            $dados->agencia = $data['boleto'][0]['AGENCIA']; // Num da agencia, sem digito
            $dados->agencia_digito = $data['boleto'][0]['AGENCIA_DIGITO']; // Digitos da Conta
            $dados->conta = $data['boleto'][0]['CONTA']; // Num da conta, sem digito
            $dados->conta_dv = $data['boleto'][0]['CONTA_DIGITO'];  // Digito do Num da conta
            $dados->carteira = $data['boleto'][0]['CARTEIRA'];  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

            $dados->cpf_cnpj = $data['boleto'][0]['CGC_MANTENEDORA'];
            $dados->endereco = $data['boleto'][0]['ENDERECO'] . ', ' . $data['boleto'][0]['BAIRRO'];
            $dados->cidade_uf = $data['boleto'][0]['CIDADE'] . '/' . $data['boleto'][0]['UF'];
            $dados->cedente = $data['boleto'][0]['NM_MANTENEDORA'];

            $data['boleto'] = $dados->montar_boleto($data['boleto'][0]['CD_BANCO']);

            $html = $this->load->view('financeiro/mensalidade/boleto', $data, true);
            include_once APPPATH . '/third_party/mpdf/mpdf.php';
            $mpdf = new mPDF('', // mode - default ''
                    '', // format - A4, for example, default ''
                    0, // font size - default 0
                    '', // default font family
                    1, // margin_left
                    1, // margin right
                    5, // margin top
                    5, // margin bottom
                    0, // margin header
                    0, // margin footer
                    'L' // L - landscape, P - portrait
            );
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
            echo "Boleto não pode ser impresso";
        }
    }

    function boleto_vencido() {
        $parametro = array(
            'aluno' => $this->input->get_post('aluno'),
            'produto' => $this->input->get_post('produto'),
            'referencia' => $this->input->get_post('mes'),
            'parcela' => $this->input->get_post('parcela'),
            'ordem' => $this->input->get_post('ordem'),
            'protesto' => $this->input->get_post('protesto'),
        );

        if ($this->input->get_post('protesto')) {
            $data['boleto'] = $this->mensalidade->imprimir_protesto($parametro); //BOLETO PROTESTADO
        } else {
            $data['boleto'] = $this->mensalidade->imprimir($parametro); // BOLETO NÃO PROTESTADO
        }
        //  print_r($data['boleto']);exit;

        if ($data['boleto'][0]['DT_VENCIMENTO'] != NULL) {

            $dados = new boletos(); // CRIA UMA NOVA INSTANCIA DA BIBLIOTECA "BOLETOS"
            $dados->dias_de_prazo_para_pagamento = 5;
            $dados->taxa_boleto = 0;
            $dados->vencimento = formata_data($data['boleto'][0]['DT_VENCIMENTO'], 'br'); //date('d/m/Y', strtotime($data['boleto'][0]['DT_VENCIMENTO']));
            $dados->valor_cobrado = ($data['boleto'][0]['VALOR_BOLETO']); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal

            $dados->nosso_numero = $data['boleto'][0]['NOSSO_NUMERO'];  // Nosso numero - REGRA: Máximo de 8 caracteres!

            $item = explode('/', $data['boleto'][0]['MES_REFERENCIA']);

            $dados->numero_documento = $data['boleto'][0]['CD_ALUNO'] . $item[1] . $item[0]; // Num do pedido ou nosso numero

            $dados->data_documento = $data['boleto'][0]['DT_VENCIMENTO']; // Data de emissão do Boleto
            $dados->data_processamento = $data['boleto'][0]['DT_VENCIMENTO']; // Data de processamento do boleto (opcional)
            $dados->valor_boleto = number_format($data['boleto'][0]['VALOR_BOLETO'], 2, ',', '');  // Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
            ///*********************************************** DADOS DO RESPONSAVEL FINANCEIRO
            $dados->sacado = $data['boleto'][0]['NM_RESPONSAVEL'];
            $dados->sacado_cpf = ' - CPF: ' . $data['boleto'][0]['RES_CPF'];

            ///*********************************************** INFORMACOES PARA O CLIENTE
            $dados->instrucoes = $data['boleto'][0]['INSTR01'] . '<br/>' .
                    $data['boleto'][0]['INSTR02'] . '<br/>' .
                    $data['boleto'][0]['INSTR03'] . '<br/>' .
                    $data['boleto'][0]['INSTR04'] . '<br/>' .
                    $data['boleto'][0]['INSTR05'] . '<br/>' .
                    $data['boleto'][0]['INSTR06'] . '<br/>' .
                    $data['boleto'][0]['MSG01'] . '<br/>' .
                    $data['boleto'][0]['MSG02'] . '<br/>' .
                    $data['boleto'][0]['MSG03'];

            ///*********************************************** DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
            $dados->quantidade = "";
            $dados->valor_unitario = "";
            $dados->aceite = "N";
            $dados->especie = "R$";
            $dados->especie_doc = "ME";

            ///*********************************************** DADOS DA SUA CONTA
            $dados->codigo_banco = str_pad($data['boleto'][0]['CD_BANCO'], 3, "0", STR_PAD_LEFT);
            $dados->agencia = $data['boleto'][0]['AGENCIA']; // Num da agencia, sem digito
            $dados->agencia_digito = $data['boleto'][0]['AGENCIA_DIGITO']; // Digitos da Conta
            $dados->conta = $data['boleto'][0]['CONTA']; // Num da conta, sem digito
            $dados->conta_dv = $data['boleto'][0]['CONTA_DIGITO'];  // Digito do Num da conta
            $dados->carteira = $data['boleto'][0]['CARTEIRA'];  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

            $dados->cpf_cnpj = $data['boleto'][0]['CGC_MANTENEDORA'];
            $dados->endereco = $data['boleto'][0]['ENDERECO'] . ', ' . $data['boleto'][0]['BAIRRO'];
            $dados->cidade_uf = $data['boleto'][0]['CIDADE'] . '/' . $data['boleto'][0]['UF'];
            $dados->cedente = $data['boleto'][0]['NM_MANTENEDORA'];

            $data['boleto'] = $dados->montar_boleto($data['boleto'][0]['CD_BANCO']);

            $this->load->view('financeiro/mensalidade/boleto_vencido', $data);
        }
    }

    /**
     * Exibe modal com os créditos dos alunos do responsável disponíveis para 
     * realizar pagamento do boleto.
     * 
     * @param string $boleto Código do boleto (CD_BOLETO) em base64
     */
    public function lista_credito_aluno() {
        $boleto = $this->input->get("boleto");

        $responsavel = $this->session->userdata('SCL_SSS_USU_CODIGO');

        $alunos = $this->responsavel->listarAlunos($responsavel);

        $data = array(
            "boleto" => $boleto,
            "alunos" => $alunos
        );

        $this->load->view("financeiro/mensalidade/credito_aluno", $data);
    }

    /**
     * Efetua o pagamento do boleto com o crédito do aluno.
     * 
     * @param string $boleto Código do boleto (CD_BOLETO) em base64
     * @param string $aluno Matricula do aluno em base64
     */
    public function pagar_credito_aluno() {
        $boleto = base64_decode($this->input->post('boleto'));
        $aluno = base64_decode($this->input->post('aluno'));

        $params = array(
            "boleto" => $boleto,
            "aluno" => $aluno,
            "responsavel" => $this->session->userdata('SCL_SSS_USU_CODIGO')
        );

        $result = $this->pagamento->boleto_credito_aluno($params);
        switch ($result['retorno']) {
            case 0 :
                $mensagem = "Ocorreu um erro ao realizar o pagamento.";
                $tipo = "erro";
                break;
            case 1 :
                $mensagem = "Pagamento realizado com sucesso.";
                $tipo = "sucesso";
                break;
            case 2 :
                $mensagem = "Não existe saldo suficiente para realizar o pagamento.";
                $tipo = "warning";
                break;
            case 3 :
                $mensagem = "O boleto já encontra-se pago.";
                $tipo = "warning";
                break;
        }

        set_msg("mensagem", $mensagem, $tipo);
        
        echo json_encode(array(
            "url" => site_url("financeiro/boleto/index")
        ));
    }

}
