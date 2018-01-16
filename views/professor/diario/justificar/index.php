<? $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
    <form action="javascript: void(0)" method="post" enctype="multipart/form-data" id="frmfiltro" name="frmfiltro" >

        <div class="col-xs-2">
            <label>Turmas: </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-group"></i>
                </span>
                <select name="turma" id="turma" class="form-control">
                    <option value=""></option>
                    <? foreach ($turma as $item) { ?>
                        <option value="<?= $item['CD_TURMA'] ?>">
                            <?= $item['CD_TURMA'] ?></option>
                    <? } ?>
                </select>
            </div>

        </div>
        <div class="col-xs-3">
            <label>Disciplinas: </label>
            <div class="input-group">

                <span class="input-group-addon">
                    <i class="fa fa-list"></i>
                </span>
                <select name="disciplina" id="disciplina" class="form-control">
                </select>
            </div>

        </div>

        <div class="col-xs-3">
            <label>Data: </label>
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
                <input name="data" id="datepicker" class="form-control"  />
            </div>

        </div>
        <div class="col-xs-3">
            <br/>
            <button type="submit" id="lJustificar" style="border-bottom: 1px solid #fff" class="btn btn-info btn-sm">
                <i class="fa fa-list icon-only"></i> Listar Frequência
            </button>
        </div>
        &zwj;
    </form>
    &zwnj;
    </div><br/>
    <div class="row">
        <div id="tabela"></div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#datepicker').datepicker({
            format: "dd/mm/yyyy"
        });
    
        $("select[name=turma]").change(function() {
            $("select[name=disciplina]").html('<option>Carregando dados ...</option>');
            $.post("<?= SCL_RAIZ ?>professor/diario/combobox_disciplina_turma", {
                turma: $("select[name=turma]").val()
            },
            function(valor) {
                $("select[name=disciplina]").html(valor);
            })
        })
        
        $("#lJustificar").click(function() {
            $("#tabela").html('Carregando dados');
            $.post("<?= SCL_RAIZ ?>professor/diario/justificar_falta_tabela", {
                turma: $("select[name=turma]").val(),
                disciplina: $("select[name=disciplina]").val(),
                data: $("input[name=data]").val(),
            },
            function(valor) {
                $("#tabela").html(valor);
            })
        })
    });

   


</script>
<? $this->load->view('layout/footer'); ?>
