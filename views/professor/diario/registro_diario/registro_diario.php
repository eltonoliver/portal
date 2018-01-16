<?php $this->load->view("layout/header"); ?>


<?php echo $this->session->flashdata('msgRegistro'); ?>

<div id="content">
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-4">
            <div>
                <label>TURMA</label>
                <select id="turma" name="turma" class="form-control" >
                    <option value="" selected>Selecione uma turma</option>

                    <?php foreach ($turmas as $row): ?>
                        <option value="<?= $row['CD_TURMA'] ?>"><?= $row['CD_TURMA'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div>
                <label>ALUNO</label>
                <select id="aluno" name="aluno" class="form-control">
                    <option value="">Selecione primeiro uma turma</option>
                </select>
            </div>
        </div>

        <div class="col-md-2">                
            <div class="form-group" style="padding-top: 27px;">                                        
                <button id="pesquisar" class="btn btn-primary"><i class="fa fa-search"></i> Pesquisar</button>
            </div>
        </div> 
        
        <div class="col-md-2">                
            <div class="form-group" style="padding-top: 27px;">
                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#cadastrar"><i class="fa fa-plus"></i> Novo Registro</a>
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

<!--modal Novo Registro-->
<div class="modal fade" id="cadastrar" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
     data-remote="<?= SCL_RAIZ ?>professor/registro_diario/cadastrar"> 
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <?= modal_load ?>
         </div>
    </div>
</div>
<!--modal Novo Registro-->


<script type="text/javascript">
    $("#turma").change(function () {
        $("#aluno").html("");

        $.ajax({
            url: "<?= site_url("comum/combobox/listaAlunosTurma") ?>",
            method: "post",
            data: {
                turma: $("#turma").val()
            },
            success: function (data, status) {
                $("#aluno").html(data);
            }
        });  
        
    });

    $("#pesquisar").click(function () {
        $("#container-grid").html('<?= LOAD_BAR ?>');

        $.ajax({
            url: "<?= site_url("professor/registro_diario/gridResultadoRegistro") ?>",
            method: "post",
            data: {
                turma: $("#turma").val(),
                aluno: $("#aluno").val()
            },
            success: function (data, status) {
                $("#container-grid").html(data);
            }
           
           
        });
        
    });
</script>

<?php $this->load->view("layout/footer"); ?>