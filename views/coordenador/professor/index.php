<? $this->load->view('layout/header'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <form  action="javascript: void(0)" method="post" enctype="multipart/form-data" id="frmfiltro" name="frmfiltro" >
                    <table class="table no-padding">
                        <tr>
                            <td style="width:5%">BIMESTRE</td>
                            <td style="width:20%">CURSO</td>
                            <td style="width:20%">SÉRIE</td>
                            <td style="width:20%">TURMA</td>
                        </tr>
                        <tr>
                            <td>
                                <select name="bimestre" id="curso" class="form-control col-xs-2">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </td>
                            <td>
                                <select name="curso" id="curso" class="form-control col-xs-2">
                                    <option value=""></option>
                                    <? foreach ($curso as $item) { ?>
                                        <option value="<?= $item['CD_CURSO'] ?>">
                                            <?= $item['NM_CURSO'] ?>
                                            <?= $item->NM_CURSO ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </td>
                            <td>
                                <select name="serie" id="serie" class="form-control col-xs-2">
                                    <option value=""></option>
                                </select>
                            </td>
                            <td>
                                <select name="turma" id="turma" class="form-control col-xs-2">
                                    <option value=""></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <button type="submit" id="lTurma" style="border-bottom: 1px solid #fff" class="btn btn-info btn-xs"><i class="fa fa-list icon-only"></i> Alunos</button>
                                <button type="submit" id="lProfessor" style="border-bottom: 1px solid #fff" class="btn btn-info btn-xs"><i class="fa fa-users icon-only"></i> Professores</button>
                            </td>
                        </tr>
                    </table>
                    &zwnj;
                </form>
            </div>
        </div>

        <div class="col-md-12">
            <div id="grd" class="row"></div>
        </div>
    </div>
</div>
<script>


    $(document).ready(function() {
        $("#lTurma").click(function() {
            $("#grd").html('<div class="modal-dialog">.<?= modal_load ?>.</div>');
            $.post("<?= SCL_RAIZ ?>coordenador/professor/notas_turma", {
                turma: $("select[name=turma]").val()
            },
            function(valor) {
                $("#grd").html(valor);
            })
        })
    });

    $(document).ready(function() {
        $("#lProfessor").click(function() {
            $("#grd").html('<div class="modal-dialog">.<?= modal_load ?>.</div>');
            $.post("<?= SCL_RAIZ ?>coordenador/professor/listar_professor", {
                turma: $("select[name=turma]").val()
            },
            function(valor) {
                $("#grd").html(valor);
            })
        })
    });

    $(document).ready(function() {
        $("select[name=curso]").change(function() {
            $("select[id=serie]").html('Aguardando série');
            $.post("<?= SCL_RAIZ ?>colegio/colegio/curso_serie", {
                curso: $(this).val()},
            function(valor) {
                $("select[id=serie]").html(valor);
            })
        })
        $("select[name=serie]").change(function() {
            $("select[id=turma]").html('Aguardando turma...');
            $.post("<?= SCL_RAIZ ?>colegio/colegio/serie_turma", {
                curso: $("select[name=curso]").val(),
                serie: $(this).val(),
            },
                    function(valor) {
                        $("select[id=turma]").html(valor);
                    })
        })


        $("select[name=turma]").change(
                function() {
                    $("select[id=aluno]").html('Aguardando alunos...');
                    $.post("<?= SCL_RAIZ ?>colegio/colegio/turma_aluno", {
                        curso: $("select[name=curso]").val(),
                        serie: $("select[name=serie]").val(),
                        turma: $(this).val()
                    },
                    function(valor) {
                        $("select[id=aluno]").html(valor);
                    })
                });
        jQuery('#form').submit(function() {
            var dados = jQuery(this).serialize();
            jQuery.ajax({
                type: "POST",
                url: "<?= SCL_RAIZ ?>coordenador/ocorrencia/adicionar",
                data: dados,
                success: function(data)
                {
                    $(".dataTables_wrapper").html('Carregando dados');
                    setTimeout(function() {
                        $(".dataTables_wrapper").load("<?= SCL_RAIZ ?>coordenador/ocorrencia/tabela", {})
                    }, 100);
                }
            });
            $('#frmnovo').modal('hide');
            return false;
        });
    });
</script>
<? $this->load->view('layout/footer'); ?>
