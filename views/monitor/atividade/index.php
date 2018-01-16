<? $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <form class="panel-title" action="<?= SCL_RAIZ ?>monitor/atividade/imprimir" method="post" enctype="multipart/form-data" id="frmfiltro" name="frmfiltro" target='_blank' >
                        <div class="col-sm-3"> 
                            <div class="input-group"> 
                                <span class="input-group-addon"><i class="fa fa-group"></i> Curso </span>
                                <select name="curso" id="curso" class="form-control">
                                    <option value=""></option>
                                    <? foreach ($curso as $item) { ?>
                                        <option value="<?= $item['CD_CURSO'] ?>">
                                            <?= $item['NM_CURSO'] ?>
                                            <?= $item->NM_CURSO ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3"> 
                            <div class="input-group"> 
                                <span class="input-group-addon"><i class="fa fa-group"></i> Série </span>
                                <select name="serie" id="serie" class="form-control">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3"> 
                            <div class="input-group"> 
                                <span class="input-group-addon"><i class="fa fa-group"></i> Turma </span>
                                <select name="turma" id="turma" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="right">
                            <button class="btn btn-sucess" type="submit"> <i class="fa fa-print bigger-130"> Imprimir</i> </button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="grd" class="row"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("select[name=curso]").change(function() {
            $("select[id=serie]").html('Aguardando série...');
            $.post("<?= SCL_RAIZ ?>colegio/colegio/curso_serie", {
                curso: $(this).val()},
            function(valor) {
                $("select[id=serie]").html(valor);
            })
        });
        
        $("select[name=serie]").change(function() {
            $("select[name=turma]").html('Aguardando turma...');
            $.post("<?= SCL_RAIZ ?>colegio/colegio/serie_turma", {
                curso: $("select[name=curso]").val(),
                serie: $(this).val()},
            function(valor) {
                $("select[id=turma]").html(valor);
            })
        });

        $("select[name=turma]").change(
                function() {
                    $("div[id=grd]").html('<?=modal_load?>');
                    $.post("<?= SCL_RAIZ ?>monitor/atividade/tabela", {
                        curso: $("select[name=curso]").val(),
                        serie: $("select[name=serie]").val(),
                        turma: $(this).val()
                    },
                    function(valor) {
                        $("div[id=grd]").html(valor);
                    })
                });
    });

</script>
<? $this->load->view('layout/footer'); ?>