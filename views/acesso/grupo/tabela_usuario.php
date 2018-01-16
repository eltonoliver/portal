<script type="text/javascript">
    function getValor(id) {
        alert($("select[name=" + id + "incluir]").val());
        setTimeout(function() {
            $("#frm" + id + "").load("<?= SCL_RAIZ ?>/grupo/permissao", {
                bimestre: $("input[name=bimestre]").val(),
                aluno: $("input[name=aluno]").val(),
                questionario: $("input[name=questionario]").val(),
                resposta: valor,
            })
        }, 500)
    }
    ;
</script>




<div class="col-xs-12">
    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">Lista de Usuários deste Grupo</h3>
        </div>
        <div class="panel-body">
            <div>
                <form action="<?= SCL_RAIZ ?>/acesso/grupo/permissao" class="no-padding well well-small" method="post" enctype="multipart/form-data" id="frmadicionar" name="frmadicionar" >
                    <input name="operacao" type="hidden" class="form-control" value="AP">
                    <label for="programa">Adiciona usuário</label>
                    <div class="input-group col-xs-12">
                        <select name="usuario" id="usuario" class="form-control">
                            <option value=""></option>
                            <? foreach ($listar as $item) { ?>
                                <option value="<?= $item['CD_USUARIO'] ?>">
                                    <?= $item['CD_USUARIO'] . ' - ' . $item['NM_USUARIO'] ?>
                                </option>
                            <? } ?>
                        </select>
                        <span class="input-group-addon">
                            <button type="submit" class="btn btn-success btn-xs no-padding"><i class="fa fa-filter icon-plus"></i> Adicionar</button>
                        </span>
                    </div>
                </form>

                <table border="1" id="gridTabelaUsuario" class="table table-striped table-bordered table-responsive table-hover" width="100%">
                    <thead class="well">
                        <tr style="font-size:12px">
                            <th width="5%">Cód.</th>
                            <th>Programa</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        foreach ($usuario as $row) {
                            ?>
                            <tr style="font-size:12px">

                                <td height="10px"><?= $row['CD_USUARIO'] ?></td>
                                <td><?= $row['NM_USUARIO'] ?>
                                    <input name="operacao" type="hidden" class="form-control" value="EP">
                                    <input name="grupo" type="hidden" class="form-control" value="<?= $row['CD_GRUPO'] ?>">
                                    <input name="programa" type="hidden" class="form-control" value="<?= $row['CD_PROGRAMA'] ?>">
                                </td>
                                <td>

                                    <a class="btn btn-xs btn-danger" href="#" data-toggle="modal" data-target="#mdlDeletar<?= $row['CD_PROGRAMA'] ?>">
                                        <i class="fa fa-trash-o"> Deletar</i>
                                    </a>

                                    <!-- /.main-content -->
                                    <div class="modal fade" id="mdlDeletar<?= $row['CD_PROGRAMA'] ?>" data-backdrop="static" data-keyboard="false" data-remote="<?= SCL_RAIZ ?>acesso/programa/view?tipo=deletar&codigo=<?= $row['CD_PROGRAMA'] ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            </div><!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                </td>
                            </tr> 
                            </form>

                        <? } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>





    <script src="<?= SCL_JS ?>jquery.dataTables.min.js"></script> 
    <script src="<?= SCL_JS ?>jquery.dataTables.bootstrap.js"></script> 
    <script>

        $('#gridTabelaUsuario').dataTable({
            "sPaginationType": "full_numbers"
        });
        jQuery(function($) {
            $("#usuario").chosen();

        });
        jQuery(document).ready(function() {
            jQuery('#frmadicionar').submit(function() {
                var dados = jQuery(this).serialize();

                jQuery.ajax({
                    type: "POST",
                    url: "<?= SCL_RAIZ ?>acesso/grupo/permissao",
                    data: dados,
                    success: function(data)
                    {
                        $("#alertAdd").html(data);

                        jQuery.ajax({
                            type: "POST",
                            url: "<?= SCL_RAIZ ?>acesso/grupo/tabela?grupo=" +<?= $row['CD_GRUPO'] ?>,
                            data: dados,
                            success: function(data)
                            {
                                $("#grd").html(data);
                            }
                        });
                        return false;
                    }
                });
                return false;
            });
        });
    </script>
    <? exit(); ?>