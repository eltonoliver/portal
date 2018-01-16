<? $this->load->view('layout/header'); ?>
<script src="<?= SCL_JS ?>jquery.dataTables.min.js"></script> 
<script src="<?= SCL_JS ?>jquery.dataTables.bootstrap.js"></script> 
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <form class="panel-title" action="javascript: void(0)" method="post" enctype="multipart/form-data" id="frmfiltro" name="frmfiltro" >
                        <label> Informe o Grupo </label>
                        <div class="input-group col-xs-12">
                            <select name="codigo" id="codigo" class="form-control">
                                <option value=""></option>
                                <? foreach ($listar as $item) { ?>
                                    <option value="<?= $item['CD_GRUPO'] ?>">
                                        <?= $item['DC_GRUPO'] ?>
                                        (
                                        <?= $item['PROGRAMA'] ?>
                                        )</option>
                                <? } ?>
                            </select>
                        </div>
                        <br />
                        <div class="right">
                            <button type="submit" id="lPrograma" style="border-bottom: 1px solid #fff" class="btn btn-info btn-sm"><i class="fa fa-list icon-only"></i>Listar Programas</button>
                            <button type="submit" id="lUsuario" style="border-bottom: 1px solid #fff" class="btn btn-info btn-sm"><i class="fa fa-users icon-only"></i>Listar Usuários</button>
                            <button type="text" style="border-bottom: 1px solid #fff" data-toggle="modal" data-target="#mdlAdicionar" name="btnNusuario" class="btn btn-success btn-sm"> <i class="fa fa-list"></i> Novo Grupo</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="grd" class="row"></div>
        </div>
    </div>
</div>

<!-- /.main-content -->
<div class="modal fade" id="mdlAdicionar" data-backdrop="static" data-keyboard="false" data-remote="<?= SCL_RAIZ ?>acesso/grupo/view?tipo=adicionar">
    <div class="modal-dialog">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script>
    $('#listar').dataTable({
        "sPaginationType": "full_numbers"
    });

    $(document).ready(function() {
        $("#lPrograma").click(function() {
            $("#grd").html('<div class="col-sm-12 well center">Carregando dados ...</div>');
            $.post("<?= SCL_RAIZ ?>acesso/grupo/tabela_programa", {
                codigo: $("select[name=codigo]").val()
            },
            function(valor) {
                $("#grd").html(valor);
            })
        })
    });
    
    $(document).ready(function() {
        $("#lUsuario").click(function() {
            $("#grd").html('<div class="col-sm-12 well center">Carregando dados ...</div>');
            $.post("<?= SCL_RAIZ ?>acesso/grupo/tabela_usuario", {
                codigo: $("select[name=codigo]").val()
            },
            function(valor) {
                $("#grd").html(valor);
            })
        })
    });



    jQuery(function($) {
        $("#grupo").chosen();

    });
</script>
<? $this->load->view('layout/footer'); ?>
