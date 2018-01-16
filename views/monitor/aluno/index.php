<? $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <form class="panel-title" action="javascript: void(0)" method="post" enctype="multipart/form-data" id="frmfiltro" name="frmfiltro" >
                        <label> Informe o Nome do Aluno </label>
                        <select name="codigo" id="codigo" class="form-control">
                            <option value=""></option>
                            <? foreach ($aluno as $item) { ?>
                                <option value="<?= $item['CD_ALUNO'] ?>"><?= $item['NM_ALUNO'] ?></option>
                            <? } ?>
                        </select>
                        <br />
                        <div class="right">
                            <button type="submit" id="lAula" style="border-bottom: 1px solid #fff" class="btn btn-info btn-sm"><i class="fa fa-list icon-only"></i>Listar Aulas</button>
                            <button type="submit" id="lAtividade" style="border-bottom: 1px solid #fff" class="btn btn-info btn-sm"><i class="fa fa-users icon-only"></i>Listar Atividades Extras</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="grd" class="row"></div>
        </div>
    </div>
</div>


<script>
    jQuery(function($) {
        $("#codigo").chosen();
    });

    $(document).ready(function() {
        $("#lAula").click(function() {
            $("#grd").html('<div class="col-sm-12 well center">Carregando dados ...</div>');
            $.post("<?= SCL_RAIZ ?>monitor/aluno/tempo", {
                codigo: $("select[name=codigo]").val(),
                tipo: 0
            },
            function(valor) {
                $("#grd").html(valor);
            })
        })
    });

    $(document).ready(function() {
        $("#lAtividade").click(function() {
            $("#grd").html('<div class="col-sm-12 well center">Carregando dados ...</div>');
            $.post("<?= SCL_RAIZ ?>monitor/aluno/tempo", {
                codigo: $("select[name=codigo]").val(),
                tipo: 1
            },
            function(valor) {
                $("#grd").html(valor);
            })
        })
    });
</script>
<? $this->load->view('layout/footer'); ?>
