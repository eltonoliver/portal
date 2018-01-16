<?php $this->load->view('layout/header'); ?>

<div id="content">
    <div class="row">        
        <div class="form-group">
            <div class="col-xs-4">
                <label>Data da aula pendente:</label>
                <select name="data-pendencia" id="data-pendencia">
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

    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('success');
            echo get_msg('error');
            ?>

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1 class="panel-title text-center">AULAS PARA LANÇAR CONTEÚDO</h1>
                </div>

                <?= $this->load->view("professor/diario/grid_conteudo_retroativo", array("aulas" => $aulas)) ?>
            </div>
        </div>
    </div>  
</div>

<script type="text/javascript">
    $("#data-pendencia").change(function () {
        var data = $("#data-pendencia").val();
        window.location.href = "<?= site_url("professor/diario/conteudo_retroativo") . '?data=' ?>" + data;
    });
</script>

<?php $this->load->view('layout/footer'); ?>