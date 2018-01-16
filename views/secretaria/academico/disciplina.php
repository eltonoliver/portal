<? $this->load->view('layout/header'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info"  id="conteudo_tabela">
            <div class="panel-heading">
                <h3 class="panel-title">Disciplina : 
                    <select name="disciplina" class="btn btn-default">
                        <option> --- </option>
                        <? foreach ($disciplina as $row) { 
                            if($row['NM_DISCIPLINA'] != 'ESTUDO DIRIGIDO'){
                            $turma = $row['CD_TURMA'];
                            ?>
                            <option value="<?= $row['CD_DISCIPLINA'] ?>"><?= $row['NM_DISCIPLINA'].' - '.$row['NM_PROFESSOR']?></option>
                        <? }} ?>
                    </select>
                </h3>
            </div>
            <div class="panel-body" id="tab_disc">
            </div>
        </div>
    </div>
    <!-- Área que vai atualizar :final   -->
</div>
<script>
    $(document).ready(function() {
        $("select[name=disciplina]").change(function() {
            $("div[id=tab_disc]").html('<?= modal_load ?>');
            $.post("<?= SCL_RAIZ ?>secretaria/academico/tabela_disc", {
                disciplina: $(this).val(),
                turma: $("input[name=turma]").val()},
            function(valor) {
                $("div[id=tab_disc]").html(valor);
            })
        });
    });
</script>
<? $this->load->view('layout/footer'); ?>