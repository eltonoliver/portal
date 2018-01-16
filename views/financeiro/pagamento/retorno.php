<? $this->load->view('layout/header'); ?>
    <div id="content">
        <div class="row">
            <div class="col-md-8 center">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <label>Pedido Finalizado ::  <?php echo date("d/m/Y H:i:s T Y") ?></label>
                    </div>
                    <div class="panel-body" id="conteudo" style="min-height:250px">
                        <ul class="list-group tasks">
                            <li class="list-group-item item-warning">
                                <i class="fa fa-list"></i> Numero do Pedido: <label><?=$dadosPedidoNumero ?></label>
                            </li>
                            <li class="list-group-item item-warning">
                                <i class="fa fa-list-ol"></i> Finalizado: <label><?=$finalizacao;?></label>
                            </li>
                            <li class="list-group-item item-warning">
                                <i class="fa fa-exchange"></i> Transação: <label><?=$tid; ?></label>
                            </li>
                            <li class="list-group-item item-warning">
                                <i class="fa fa-credit-card"></i> Status transação: <label><?=$status; ?></label>
                            </li>
                        </ul>
                    </div>
                </div>
                
            </div>
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
    <? $this->load->view('layout/footer'); ?>