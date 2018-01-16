<? 

$this->load->view('financeiro/pagamento/urls'); 

if (!isset($_SESSION["pedidos"])) {
    $_SESSION["pedidos"] = new ArrayObject();
}

$Pedido = new Cielo();

$Pedido->formaPagamentoBandeira = $this->session->userdata('FRM_BANDEIRA');
$Pedido->formaPagamentoProduto = $this->session->userdata('FRM_FORMA_PAGAMENTO');
$Pedido->formaPagamentoParcelas = 1;

$Pedido->dadosEcNumero = SECULO_CIELO;
$Pedido->dadosEcChave = SECULO_CHAVE_CIELO;

$Pedido->capturar = true;
$Pedido->autorizar = 1;

$Pedido->dadosPedidoNumero = $codigo;

$total = number_format($this->session->userdata('FRM_TOTAL'),2,'','');
$Pedido->dadosPedidoValor = $total;

$Pedido->urlRetorno = ReturnURL('h');

// ENVIA REQUISIÇÃO SITE CIELO
$objResposta = $Pedido->RequisicaoTransacao(false);

$Pedido->tid = $objResposta->tid;
$Pedido->pan = $objResposta->pan;
$Pedido->status = $objResposta->status;

$urlAutenticacao = "url-autenticacao";
$Pedido->urlAutenticacao = $objResposta->$urlAutenticacao;

// Serializa Pedido e guarda na SESSION
$StrPedido = $Pedido->ToString();

$_SESSION["pedidos"]->append($StrPedido);
$Pedido->urlAutenticacao;
$this->session->set_userdata('transacao', $_SESSION["pedidos"]);
//print_r($_SESSION);
echo '<script type="text/javascript"> window.location.href = "' . $Pedido->urlAutenticacao . '" </script>';
//echo $this->session->userdata('FRM_TOTAL');

exit();

?>