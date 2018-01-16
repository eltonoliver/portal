<? $this->load->view('layout/header'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <form  action="javascript: void(0)" method="post" enctype="multipart/form-data" id="frmfiltro" name="frmfiltro" >
                    <table class="table no-padding">
                        <tr>
                            <td style="width:20%">CURSO</td>
                            <td style="width:20%">SÉRIE</td>
                            <td style="width:20%">TURMA</td>
                            <td style="width:20%">DATA</td>
                        </tr>
                        <tr>
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
                             <td>
                                <div class="input-group">
                                    <input type="text" id="data" name="data" class="form-control" placeholder="99/99/9999" />
                                    <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                                </div>
                            </td>
                        </tr>
                    </table>
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
        
        $("select[name=curso]").change(function() {
            $("select[id=serie]").html('Aguardando série');
            $.post("<?= SCL_RAIZ ?>colegio/colegio/curso_serie", {
                curso: $(this).val()},
            function(valor) {
                $("select[id=serie]").html(valor);
            })
        });
        
        $("#lTurma").click(function() {
            $("#grd").html('<div class="modal-dialog">.<?= modal_load ?>.</div>');
            $.post("<?= SCL_RAIZ ?>coordenador/professor/notas_turma", {
                turma: $("select[name=turma]").val()
            },
            function(valor) {
                $("#grd").html(valor);
            })
        });
        
        $("select[name=serie]").change(function() {
            $("select[id=turma]").html('Aguardando turma...');
            $.post("<?= SCL_RAIZ ?>colegio/colegio/serie_turma", {
                curso: $("select[name=curso]").val(),
                serie: $(this).val(),
            },function(valor) {
                $("select[id=turma]").html(valor);
            })
        });
    });
    
    jQuery(function($) {
	$('#data').datepicker().on('changeDate', function(ev){
            $('#data').datepicker('hide');
            
            var dados = $("#frmfiltro").serialize();
            jQuery.ajax({
                type: "POST",
                url: "<?= SCL_RAIZ ?>coordenador/faltas/filtro",
                data: dados,
                success: function(data)
                {
                    $("#grd").html(data);
                }
            });
            return false;
            
	 });
    });
</script>
<? $this->load->view('layout/footer'); ?>
