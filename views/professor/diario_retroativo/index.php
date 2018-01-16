<?php $this->load->view('layout/header'); ?>

<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('success');
            echo get_msg('error');
            ?>

            <?php if ($block): ?>
                <div class="row">
                    <div class="col-xs-6">
                        <p class="text-justify">
                            O período de lançamento retroativo encerrou.
                        </p>
                    </div>
                </div>
            <?php else: ?>
                <div class="row">        
                    <div class="form-group">
                        <div class="col-xs-4">
                            <label>Data da aula pendente:</label>
                            <select name="data" id="data">
                                <option></option>
                                <?php foreach ($datas as $data) : ?>
                                    <option value="<?= date('d/m/Y', strtotime($data['DT_AULA'])) ?>" <?= date('d/m/Y', strtotime($data['DT_AULA'])) == $dataPendencia ? "selected" : "" ?>>
                                        <?= date('d/m/Y', strtotime($data['DT_AULA'])) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="panel panel-info">                
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">MATUTINO</h3>
                    </div>

                    <?=
                    $this->load->view("professor/diario_retroativo/grid_aula", array(
                        'aulas' => $manha,
                            ), true);
                    ?>
                </div>

                <div class="panel panel-warning">                
                    <div class="panel-heading">
                        <h1 class="panel-title text-center">VESPERTINO</h1>
                    </div>

                    <?=
                    $this->load->view("professor/diario_retroativo/grid_aula", array(
                        'aulas' => $tarde,
                            ), true);
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#data").change(function () {
        var data = $("#data").val();
        window.location.href = "<?= site_url("professor/diario_retroativo/index") . '?data=' ?>" + data;
    });
</script>

<?php $this->load->view('layout/footer'); ?>