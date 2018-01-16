<? $this->load->view('layout/header'); ?>
    <div id="content">
        <div class="row">
            
            <?
            $gateway = new Cielo();
            $params = array(
                'aluno' => $this->session->userdata('CES_CIELO_ALUNO'),
                'bandeira' => $this->session->userdata('CES_CIELO_BANDEIRA'),
                'forma' => $this->session->userdata('CES_CIELO_FORMA'),
                'total' => $this->session->userdata('CES_CIELO_TOTAL'),
            );
            $retorno = $gateway->RetornoCompra($params);
            ?>
            
            <div class="col-md-4">

                <a class="col-xs-12" href="<?= base_url() ?>financeiro/boleto">
                    <div class="stat-block stat-primary">
                        <div class="icon">
                            <b class="icon-cover"></b>
                            <i class="fa fa-barcode"></i>
                        </div>
                        <div class="details">
                            <div class="number">Boletos</div>
                            <div class="description">Ver todos</div>
                        </div>
                    </div>
                </a>

                <a class="col-xs-12" href="<?= base_url() ?>financeiro/boleto">
                    <div class="stat-block stat-info">
                        <div class="icon">
                            <b class="icon-cover"></b>
                            <i class="fa fa-credit-card"></i>
                        </div>
                        <div class="details">
                            <div class="number">Pagamento</div>
                            <div class="description">Online</div>
                        </div>
                    </div>
                </a>

                <a class="col-xs-12" href="<?= base_url() ?>financeiro/boleto">
                    <div class="stat-block stat-warning">
                        <div class="icon">
                            <b class="icon-cover"></b>
                            <i class="fa fa-shopping-cart"></i>
                        </div>
                        <div class="details">
                                <div class="number">Cantina</div>
                                <div class="description">Comprar</div>
                        </div>
                    </div>
                </a>
                
            </div>
        </div>
    </div>
    <? 
        $this->load->view('layout/footer'); 
    
    ?>