<?php $this->load->view('layout/header'); ?>

<div id="content">
    <?php $this->load->view("acompanhamento/header-acompanhamento"); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary"  id="conteudo_tabela">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Ocorrências
                    </h3>
                </div>

                <div class="panel-body">
                    <table class="table table-bordered table-hover table-striped rt cf " id="rt1">
                        <thead>
                            <tr>                                    
                                <th class="well text-center" style="font-size:11px">DATA</th>
                                <th class="well" style="font-size:11px">MOTIVO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lista as $item) { ?>
                                <tr>
                                    <td class="text-center" style="font-size:11px; width: 100px"><?= date('d/m/Y', strtotime($item['DT_OCORRENCIA'])) ?></td>
                                    <td style="font-size:11px"><?= $item['DC_OCORRENCIA']->load() ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Área que vai atualizar :final   -->
    </div>
</div>

<?php $this->load->view('layout/footer'); ?>
<?php exit; ?>