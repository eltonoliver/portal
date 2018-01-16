<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Disciplina:</label>
            <select id="disciplina-turma" name="disciplina" class="form-control">
                <option value=""></option>

                <?php foreach ($disciplinas as $disciplina): ?>
                    <option class="<?= $disciplina['TIPO'] == 'X' ? 'label-info' : '' ?>" 
                            value="<?= $disciplina['CD_DISCIPLINA'] . ":" . $disciplina['CD_TURMA'] ?>">
                                <?= $disciplina['NM_DISCIPLINA'] ?>
                    </option>
                <?php endforeach; ?>
            </select>            
        </div>
    </div>    
</div>

<div class="row">
    <div class="col-md-12">
        <div id="detalhes-disciplina">            
        </div>        
    </div>
</div>

<script src="<?= SCL_JS ?>jquery.dataTables.min.js"></script> 
<script src="<?= SCL_JS ?>jquery.dataTables.bootstrap.js"></script>

<script type="text/javascript">
    $("#disciplina-turma").change(function () {
        $("#detalhes-disciplina").html('<?= LOAD_BAR ?>');

        var aux = $("#disciplina-turma").val();
        var turma = "";
        var disciplina = "";

        if (aux !== "") {
            aux = aux.split(":");

            disciplina = aux[0];
            turma = aux[1];

            $.ajax({
                url: "<?= site_url("acompanhamento/detalhesDisciplina") ?>",
                method: "post",
                data: {
                    turma: turma,
                    disciplina: disciplina
                },
                success: function (data, status) {
                    $("#detalhes-disciplina").html(data);
                }
            });
        } else {
            $("#detalhes-disciplina").html("");
        }
    });
</script>

<?php exit(); ?>