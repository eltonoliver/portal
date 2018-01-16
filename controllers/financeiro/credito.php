<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Credito extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('responsavel_model', 'responsavel', TRUE);
        $this->load->model('financeiro/pagamento_model', 'pagar', TRUE);
        $this->load->model('secretaria/secretaria_model', 'secretaria', TRUE);
        $this->load->model('financeiro/cantina_model', 'cantina', TRUE);
        $this->load->model('refeitorio/refeitorio_model','refeitorio',TRUE);

        $this->load->helper(array('form', 'url', 'html','funcoes'));
        $this->load->library(array('form_validation', 'session', 'logger', 'cielo', 'boletos'));
    }

    function index() {
        $this->session->unset_userdata('CES_CIELO_ALUNO');
        $this->session->unset_userdata('CES_CIELO_FORMA');
        $this->session->unset_userdata('CES_CIELO_BANDEIRA');
        $this->session->unset_userdata('CES_CIELO_TOTAL');

        $data = array(
            'titulo' => '<h1> Financeiro <i class="fa fa-angle-right"></i> Crédito para Aluno</h1>',
            'aluno' => $this->responsavel->acompanhamento(array('operacao' => 'L', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'))),
            'comprovante' => $this->pagar->transacao(array('operacao' => 'COMPROVANTE', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'))),
        );
        $this->load->view('financeiro/credito/index', $data);
    }    

    function extrato() {

        if(base64_decode($this->input->post('acao')) == 'extrato'){
            $r = array('aluno' => $this->input->post('cd_aluno'),
                       'dt_inicio'=> date('d-M-Y',strtotime(implode("-",array_reverse(explode("/",$this->input->post('dt_ini')))))),
                       'dt_final'=> date('d-M-Y',strtotime(implode("-",array_reverse(explode("/",$this->input->post('dt_fim'))))))
                );
            
            $data = array(
                'titulo' => '<h1> Financeiro <i class="fa fa-angle-right"></i> Extrato de Consumo dos Créditos</h1>',
                'aluno' => $r['aluno'],
                'periodo'=>$this->input->post('dt_ini')." a ".$this->input->post('dt_fim'),
                'limite'=>  $this->input->post('limite'),
                'almoco'=>  $this->input->post('almoco'),
                'extrato' => $this->pagar->extrato_credito($r)
            );
          //  print_r($data['extrato']);exit;
            $this->load->view('financeiro/credito/tela_extrato', $data);
            
        }else{
            $data = array(
                'titulo' => '<h1> Financeiro <i class="fa fa-angle-right"></i> Extrato de Consumo dos Créditos</h1>',
                'aluno' => base64_decode($this->input->get('token')),
            );

            $this->load->view('financeiro/credito/extrato', $data);
        }
    }
    
    
    function detalhe_extrato(){
        $paramentro = array('cupom' => $this->input->get_post('cupom'));
        $data = array('cupom' => $this->refeitorio->consulta_cupom($paramentro)->result(),
                      'detalhes'=>$this->refeitorio->dadoa_cupom_venda($paramentro)->result());
        $this->load->view('financeiro/credito/detalhe_doc', $data);
    }
    
    function extrato_tabela() {
        
        $data = array(
            'titulo' => '<h1> Financeiro <i class="fa fa-angle-right"></i> Crédito para Aluno</h1>',
            'aluno' => base64_decode($this->input->get('token')),
            'extrato' => $this->pagar->credito($r = array('operacao' => 'COMPRAS', 'aluno' => base64_decode($this->input->get('token'))))
        );
        $this->load->view('financeiro/credito/extrato', $data);
    }
    
    function historico() {

        $para1 = array('operacao' => 'ALUNO',
            'aluno' => base64_decode($this->input->get_post('token'))
        );

        $data = array(
            'aluno' => $this->secretaria->aluno_turma($para1),
            'extrato' => $this->pagar->credito($r = array('operacao' => 'HISTORICO', 'aluno' => base64_decode($this->input->get('token'))))
        );
        $html = $this->load->view('financeiro/credito/impressao_historico', $data, true);
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $mpdf->SetHTMLHeader($this->load->view('impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', 10, // margin_left
                10, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                0); // margin footer 
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->SetHTMLFooter($this->load->view('impressao/footer', $data, true));
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    function cardapio() {

        $data = array(
            'titulo' => '<h1> Financeiro <i class="fa fa-angle-right"></i> Crédito para Aluno</h1>',
            'aluno' => $this->input->get('token'),
            'produtos' => $this->cantina->pdv($d = array('terminal' => 1)),
            'js' => $this->input->get('js'), // limite diario do aluno
        );
        $this->load->view('financeiro/credito/cardapio', $data);
    }
    
    // Patricia Pack Pinheiro
    // Direito Digital
    
    
    function limite() {

        $data = array(
            'titulo' => '<h1> Financeiro <i class="fa fa-angle-right"></i> Crédito para Aluno</h1>',
            'aluno' => $this->responsavel->acompanhamento(array('operacao' => 'FA', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'), 'aluno' => base64_decode($this->input->get('token')))),
            'produtos' => $this->cantina->pdv($d = array('terminal' => 1)),
            'js' => $this->input->get('js'), // limite diario do aluno
        );
        $this->load->view('financeiro/credito/limite', $data);
    }
    
    function atualizar_limite() {
        
        if($this->input->post('novo') == $this->input->post('antigo')){
            echo "Limite mantido";
        }else{
            
            $dados = array(
                'operacao' => 'ATUALIZAR',
                   'aluno' => $this->input->post('aluno'),
                  'antigo' => str_replace(',','.',$this->input->post('antigo')),
                    'novo' => str_replace(',','.',$this->input->post('novo')),
             'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
                 'maquina' => 'ZEND SERVER'
            );
            $this->cantina->limite($dados);
            
            $data = array(
                'operacao' => 'LOG',
                   'aluno' => $this->input->post('aluno'),
                  'antigo' => str_replace(',','.',$this->input->post('antigo')),
                    'novo' => str_replace(',','.',$this->input->post('novo')),
             'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
                 'maquina' => 'ZEND SERVER'
            );
           
            $this->cantina->limite($data);
            echo "Limite alterado!!"; 
        }
        
        
    }

    function grdpedido() {

        $dados = array(
            'produtos' => $this->cantina->pdv($d = array('terminal' => 1)),
            'selecao' => $this->input->post('produto'),
            'limite' => base64_decode($this->input->post('token')),
            'aluno' => base64_decode($this->input->post('aluno'))
        );
        $total = 0;
        foreach ($this->input->post('produto') as $s) {
            $p = explode(':', $s);
            $total = $total + ($p[1] * $p[2]);
        }

        if ($total <= base64_decode($this->input->post('token'))) {
            $this->load->view('financeiro/credito/pedido', $dados);
        } else {
            echo '<div style="position: fixed; bottom:0px; z-index:99999; float:right; right:16px; width:18%" id="grdpedido" class="well">
                  <h1>Este aluno excedeu o limite diário. </h1></div>';
        }
    }

    function pedido() {
        // PEGA OS DADOS DO CAIXA ABERTO PARA A WEB
        $rscaixa = $this->cantina->venda($r = array('operacao' => 'DADOS'));
        $caixa = $rscaixa[0]['ID_CAIXA'];
        $operador = $rscaixa[0]['ID_OPERADOR'];
        $movimento = $rscaixa[0]['ID_MOVIMENTO'];

        if (empty($caixa) || empty($operador) || empty($movimento)) {
            echo "Ocorreu um erro em nosso sistema, se esse erro persistir entre em contato conosco, 3211-0196";
        } else {
  
            // Caso haja um caixa aberto para a WEB
            // O Sistema irá pegar os dados de caixa, operador e movimento
            // Totalizará o pedido
            foreach ($this->input->post('produto') as $s) {
                $p = explode(':', $s);
                $subtotal = $subtotal + ($p[1] * $p[2]);
            }

            // Parametros para fazer a venda
            // ***************************************************************** VENDA
            $parametro = array('operacao' => 'VENDA',
                'aluno' => base64_decode($this->input->post('aluno')),
                'total' => $subtotal,
                'caixa' => $caixa,
                'operador' => $operador,
                'status' => 4);
            $this->cantina->venda($parametro);

            // Pega o numero da venda que foi feito para o aluno 
            // ********************************************************** PEGA A VENDA
            $params = array(
                'operacao' => 'ULTIMO',
                'aluno' => base64_decode($this->input->post('aluno')),
                'status' => 4
            );
            $venda = $this->cantina->venda($params);

            // Pega todos os itens da 
            // ************************************************ PEGA OS ITEMS DA VENDA
            $venda = $venda[0]['CODIGO'];
            $ordem = 0;
            echo "<h4>Pedido Nº ".$venda."</h4>";
            foreach ($this->input->post('produto') as $s) {
                $ordem = $ordem + 1;
                $p = explode(':', $s);
                $t = $p[1] * $p[2];

                $parametro = array(
                    'operacao' => 'PRODUTO',
                    'venda' => $venda,
                    'produto' => $p[0],
                    'quantidade' => $p[1],
                    'ordem' => $ordem,
                    'preco' => $p[2],
                    'valor' => $t,
                );
                $item = $this->cantina->venda($parametro);
            }
            $produto = "";
            
        }
    }

    function comprovante() {
        
        $data = array(
            'compra' => $this->pagar->transacao($r = array('operacao' => 'AUTENTICACAO', 'codigo' => base64_decode($this->input->get('token')))),
        );
        $html = $this->load->view('financeiro/credito/comprovante', $data, true);
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $mpdf->SetHTMLHeader($this->load->view('impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', 
                0, // margin_left
                0, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                0); // margin footer 
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->SetHTMLFooter($this->load->view('impressao/footer', $data, true));
        $mpdf->WriteHTML($html);
        $mpdf->Output(''.base64_decode($this->input->get('validation')).'.pdf','D');
    }
    
    function impressao_extrato() {
        
        $para1 = array('operacao' => 'ALUNO',
            'aluno' => base64_decode($this->input->get_post('token'))
        );

        $data = array(
            'aluno' => $this->secretaria->aluno_turma($para1),
            'extrato' => $this->pagar->credito($r = array('operacao' => 'COMPRAS', 'aluno' => base64_decode($this->input->get('token')))),
        );
        $html = $this->load->view('financeiro/credito/impressao_extrato', $data, true);
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $mpdf->SetHTMLHeader($this->load->view('impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', 10, // margin_left
                10, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                0); // margin footer 
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->SetHTMLFooter($this->load->view('impressao/footer', $data, true));
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
    
    function compra_almoco_credito(){
        $cd_aluno = base64_decode($this->input->get('token'));
        $mod = array('operacao'=>'MOD','cd_aluno'=>$cd_aluno);
        $modalidade = $this->pagar->credito_almoco($mod);
        
        $desc = array('operacao'=>'DESCONTO','cd_aluno'=>$cd_aluno,'tipo_refeicao'=>$modalidade[0]['MODALIDADE']);
        $desconto = $this->pagar->credito_almoco($desc);
        
        $data = array('tipo_refeicao'=>$modalidade[0]['MODALIDADE'],
                      'dados'=>$desconto);
        $this->load->view('financeiro/credito/comprar_almoco',$data);
    }
    
    function finalizar_compra_almoco(){
        $total = explode('.', $this->input->post('subtotal'));
       
        $paramentro = array('operacao'=>'FINALIZAR',
                            'quantidade'=>$this->input->post('qtde_almoco'),
                            'vl_total'=>number_format($total[0], 2, '.', ','),
                            'vl_unitario'=>$this->input->post('VL_UNITARIO'),
                            'cd_usuario'=>$this->input->post('CD_ALUNO'),
                            'cd_material_almoco'=>$this->input->post('CD_MATERIAL'));
       // print_r($paramentro);exit;
        $final = $this->pagar->credito_almoco($paramentro);
       // echo count($final);exit;
        if(count($final)== 2){
            set_msg('msg','Comprar efetuada com sucesso','sucesso');
        }else{
            set_msg('msg','Erro ao efetuar a compra','erro');
        }
        redirect(base_url().'inicio/','refresh');
        
    }

}