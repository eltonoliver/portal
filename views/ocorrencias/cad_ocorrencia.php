<form name="frm_ocorrencias" id="frmOcorrencias" method="post" action="<?= base_url() ?>ocorrencias/psicologico/confirmar">
    <div class="modal-header btn-info ">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 class="modal-title">Nova Consulta</h3>
    </div>
    <div class="modal-body">
        <div class="col-12-sm">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="26%">
                        <div class="form-group">
                            <label class="control-label"><strong>Data da Consulta</strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-8"> 
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input name="data" type="text" class="form-control date-picker"  placeholder="Data da Consulta" id="data" size="20" data-date-format="dd/mm/yyyy" value="<?= date('d/m/Y') ?>">
                                </div>
                            </div>
                        </div>
                    </td>
                    <td width="40%">
                        <div class="form-group">
                            <label class="control-label"><strong>Curso </strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-10"> <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                    <select name="curso" id="curso" class="form-control" required="required">
                                        <option value="">Selecione o Curso</option>
                                        <? foreach ($curso as $item) { ?>
                                            <option value="<?= $item['CD_CURSO'] ?>">
                                                <?= $item['NM_CURSO'] ?>
                                                <?= $item->NM_CURSO ?>
                                            </option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td width="34%">
                        <div class="form-group">
                            <label class="control-label"><strong>Série</strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-10"> <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                    <select name="serie" id="serie" class="form-control" required="required">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
                <tr>                
                    <td>
                        <div class="form-group">
                            <label class="control-label"><strong>Turma</strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-8"> <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                    <select name="turma" id="turma" class="form-control" required="required">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td colspan="2">
                        <div class="form-group">
                            <label class="control-label"><strong>Alunos</strong></label>
                            <div class="controls row">
                                <div class="input-group col-sm-11"> <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                    <select name="aluno" id="aluno" class="form-control" required="required">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="modal-footer"> 
        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
        <button type="submit" value="Submit" class="btn btn-success" id="frmarquivo_btn" ><i class="fa fa-plus"></i> Continuar </button>
    </div>
</form>
<script>

    $(document).ready(function () {

        $("select[name=curso]").change(function () {
            $("select[id=serie]").html('Aguardando série');
            $.post("<?= SCL_RAIZ ?>colegio/colegio/curso_serie", {
                curso: $(this).val()},
            function (valor) {
                $("select[id=serie]").html(valor);
            })
        });

        $("#lTurma").click(function () {
            $("#grd").html('<div class="modal-dialog">.<?= modal_load ?>.</div>');
            $.post("<?= SCL_RAIZ ?>coordenador/professor/notas_turma", {
                turma: $("select[name=turma]").val()
            },
            function (valor) {
                $("#grd").html(valor);
            })
        });

        $("select[name=serie]").change(function () {
            $("select[id=turma]").html('Aguardando turma...');
            $.post("<?= SCL_RAIZ ?>colegio/colegio/serie_turma", {
                curso: $("select[name=curso]").val(),
                serie: $(this).val(),
            }, function (valor) {
                $("select[id=turma]").html(valor);
            })
        });
    });

    $("select[name=turma]").change(
            function () {
                $("select[id=aluno]").html('Aguardando alunos...');
                $.post("<?= SCL_RAIZ ?>colegio/colegio/turma_aluno", {
                    curso: $("select[name=curso]").val(),
                    serie: $("select[name=serie]").val(),
                    turma: $(this).val()
                },
                function (valor) {
                    $("select[id=aluno]").html(valor);
                })
            });

    jQuery(function ($) {
        $('#data').datepicker().on('changeDate', function (ev) {
            $('#data').datepicker('hide');

            var dados = $("#frmfiltro").serialize();
            jQuery.ajax({
                type: "POST",
                url: "<?= SCL_RAIZ ?>coordenador/faltas/filtro",
                data: dados,
                success: function (data)
                {
                    $("#grd").html(data);
                }
            });
            return false;

        });
    });
</script>


<?php exit; ?>