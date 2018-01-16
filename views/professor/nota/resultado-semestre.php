<?php $this->load->view("layout/header"); ?>

<div id="content">
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-4">
            <div class="form-group">
                <label>TURMA</label>
                <select id="turma" name="turma" class="form-control">
                    <option value="">Selecione uma turma</option>

                    <?php foreach ($turmas as $row): ?>
                        <option value="<?= $row['CD_TURMA'] ?>"><?= $row['CD_TURMA'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>DISCIPLINA</label>
                <select id="disciplina" name="disciplina" class="form-control">
                    <option value="">Selecione primeiro uma turma</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">                
            <div class="form-group" style="padding-top: 27px;">                                        
                <button id="visualizar" class="btn btn-primary"><i class="fa fa-search"></i> Ver</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div id="container-grid">
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#turma").change(function () {
        $("#disciplina").html("");

        $.ajax({
            url: "<?= site_url("comum/combobox/listaDisciplinaRegular") ?>",
            method: "post",
            data: {
                turma: $("#turma").val()
            },
            success: function (data, status) {
                $("#disciplina").html(data);
            }
        });
    });

    $("#visualizar").click(function () {
        $("#container-grid").html('<?= LOAD_BAR ?>');

        $.ajax({
            url: "<?= site_url("professor/nota/gridResultadoSemestre") ?>",
            method: "post",
            data: {
                turma: $("#turma").val(),
                disciplina: $("#disciplina").val()
            },
            success: function (data, status) {
                $("#container-grid").html(data);
            }

        });
    });
</script>

<?php $this->load->view("layout/footer"); ?>