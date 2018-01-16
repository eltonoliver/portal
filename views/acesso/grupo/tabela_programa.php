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

<!--div class="col-xs-3">
    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">Adicionar Programa ao Grupo</h3>
        </div>
        <div class="panel-body">
            <form action="<?= SCL_RAIZ ?>/acesso/grupo/permissao" class="no-padding" method="post" enctype="multipart/form-data" id="frmadicionar" name="frmadicionar" >
                <input name="operacao" type="hidden" class="form-control" value="AP">
                <label for="programa">Programa</label>
                <select name="programa" id="programa" class="form-control">
                    <option value=""></option>
<? foreach ($programa as $item) { ?>
                                    <option value="<?= $item['CD_PROGRAMA'] ?>">
    <?= $item['CD_PROGRAMA'] . ' - ' . $item['NM_PROGRAMA'] ?>
                                    </option>
<? } ?>
                </select>
                <br />
                <br />
                <input type="checkbox" id="incluir" name="incluir" value="1" />&nbsp;
                <label for="incluir">Incluir</label>
                (<i class="fa fa-plus"></i>)
                <br />
                <input type="checkbox" id="excluir" name="alterar" value="1" />&nbsp;
                <label for="alterar">Alterar</label>
                (<i class="fa fa-edit"></i>)
                <br />

                <input type="checkbox" id="excluir" name="excluir" value="1" />&nbsp;
                <label for="excluir">Excluir</label>
                (<i class="fa fa-trash-o"></i>)
                <br />

                <input type="checkbox" id="imprimir" name="imprimir" value="1" />&nbsp;
                <label for="imprimir">Imprimir</label>
                (<i class="fa fa-print"></i>)
                <br />

                <input type="checkbox" id="especial1" name="especial1" value="1" />&nbsp;
                <label for="especial1">Especial I</label>
                (<i class="fa fa-print"></i>)
                <br />

                <input type="checkbox" id="especial2" name="especial2" value="1" />&nbsp;
                <label for="especial2">Especial II</label>
                (<i class="fa fa-print"></i>)

                
                <br />
                <br />
                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar</button>
                <br />
                <br /><div id="alertAdd"></div>
                <br />
                <br />
            </form>
        </div>
    </div>
</div-->




<div class="col-xs-12" >
    <div class="panel panel-warning">
        <div class="panel-heading">
            <h3 class="panel-title">Lista de Programas do Grupo</h3>
        </div>
        <div class="panel-body">


            <form action="<?= SCL_RAIZ ?>/acesso/grupo/permissao" class="no-padding" method="post" enctype="multipart/form-data" id="frmadicionar" name="frmadicionar" >

                <table class="table">
                    <thead>
                        <tr class="well">
                            <td>Programa</td>
                            <td style="width:5%">( <i class="fa fa-plus"></i> )</td>
                            <td style="width:5%">( <i class="fa fa-edit"></i> )</td>
                            <td style="width:5%">( <i class="fa fa-trash-o"></i> )</td>
                            <td style="width:5%">( <i class="fa fa-print"></i> )</td>
                            <td style="width:5%">( <i class="fa fa-asterisk">1</i> )</td>
                            <td style="width:5%">( <i class="fa fa-asterisk">2</i> )</td>
                            <td style="width:5%"></td>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="well success" style="font-size:10px">
                            <td colspan="8">
                                <label for="alterar">Incluir</label>
                                (<i class="fa fa-plus"></i>)
                                |
                                <label for="alterar">Alterar</label>
                                (<i class="fa fa-edit"></i>)
                                |
                                <label for="excluir">Excluir</label>
                                (<i class="fa fa-trash-o"></i>)
                                |
                                <label for="imprimir">Imprimir</label>
                                (<i class="fa fa-print"></i>)
                                |
                                <label for="especial1">Especial I</label>
                                (<i class="fa fa-print"></i>)
                                |
                                <label for="especial2">Especial II</label>
                                (<i class="fa fa-asterisk"></i>)
                                |
                                <label for="especial2">Especial II</label>
                                (<i class="fa fa-asterisk"></i>)
                            </td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>
                                <select name="programa" id="programa" class="form-control">
                                    <option value=""></option>
                                    <? foreach ($programa as $item) { ?>
                                        <option value="<?= $item['CD_PROGRAMA'] ?>">
                                            <?= $item['CD_PROGRAMA'] . ' - ' . $item['NM_PROGRAMA'] ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </td>
                            <td align="center" valign="middle"><input type="checkbox" id="incluir" name="incluir" value="1" /></td>
                            <td><input type="checkbox" id="incluir" name="incluir" value="1" /></td>
                            <td><input type="checkbox" id="incluir" name="alterar" value="1" /></td>
                            <td><input type="checkbox" id="incluir" name="excluir" value="1" /></td>
                            <td><input type="checkbox" id="incluir" name="especial1" value="1" /></td>
                            <td><input type="checkbox" id="incluir" name="especial2" value="1" /></td>
                            <td><button type="submit" class="btn btn-success"><i class="fa fa-plus"></i> Adicionar</button></td>
                        </tr>
                    </tbody>
                </table>
                <div id="alertAdd"></div>
            </form>







            <table border="1" id="gridTabela" class="table table-striped table-bordered table-responsive table-hover" width="100%">
                <thead class="well">
                    <tr style="font-size:12px">
                        <th width="5%">Cód.</th>
                        <th>Programa</th>
                        <th width="5%" align="center">Incluir</th>
                        <th width="5%" align="center">Alterar</th>
                        <th width="5%" align="center">Excluir</th>
                        <th width="5%" align="center">Imiprir</th>
                        <th width="5%" align="center">Esp.I</th>
                        <th width="5%" align="center">Esp.II</th>
                        <th width="5%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?
                    foreach ($listar as $row) {
                        $id = $row['CD_GRUPO'] . $row['CD_PROGRAMA'];
                        ?>
                    <form name="frm<?= $id ?>">
                        <tr style="font-size:12px">

                            <td height="10px"><?= $row['CD_PROGRAMA'] ?></td>
                            <td><?= $row['NM_PROGRAMA'] ?>
                                <input name="operacao" type="hidden" class="form-control" value="EP">
                                <input name="grupo" type="hidden" class="form-control" value="<?= $row['CD_GRUPO'] ?>">
                                <input name="programa" type="hidden" class="form-control" value="<?= $row['CD_PROGRAMA'] ?>">
                            </td>
                            <td align="center" class="<?
                            if ($row['INCLUIR'] == 0)
                                echo 'danger';
                            else
                                echo 'success';
                            ?>">

                                <input <? if ($row['INCLUIR'] == 1) echo 'checked'; ?> type="checkbox" id="<?= $id . 'incluir' ?>" name="<?= $id . 'incluir' ?>" value="1" >

                            </td>
                            <td align="center" class="<?
                            if ($row['ALTERAR'] == 0)
                                echo 'danger';
                            else
                                echo 'success';
                            ?>">
                                <input <? if ($row['ALTERAR'] == 1) echo 'checked'; ?> type="checkbox" id="<?= $id . 'alteraralterar' ?>" name="<?= $id . 'alterar' ?>" value="1" >
                            </td>
                            <td align="center" class="<?
                            if ($row['EXCLUIR'] == 0)
                                echo 'danger';
                            else
                                echo 'success';
                            ?>">
                                <input <? if ($row['EXCLUIR'] == 1) echo 'checked'; ?> type="checkbox" id="<?= $id . 'excluir' ?>" name="<?= $id . 'excluir' ?>" value="1" >
                            </td>
                            <td align="center" class="<?
                            if ($row['IMPRIMIR'] == 0)
                                echo 'danger';
                            else
                                echo 'success';
                            ?>">
                                <input <? if ($row['IMPRIMIR'] == 1) echo 'checked'; ?> type="checkbox" id="<?= $id . 'imprimir' ?>" name="<?= $id . 'imprimir' ?>" value="1" >
                            </td>
                            <td align="center" class="<?
                            if ($row['ESPECIAL1'] == 0)
                                echo 'danger';
                            else
                                echo 'success';
                            ?>">
                                <input <? if ($row['ESPECIAL1'] == 1) echo 'checked'; ?> type="checkbox" id="<?= $id . 'especial1' ?>" name="<?= $id . 'especial1' ?>" value="1" >
                            </td>
                            <td align="center" class="<?
                            if ($row['ESPECIAL2'] == 0)
                                echo 'danger';
                            else
                                echo 'success';
                            ?>">

                                <input <? if ($row['ESPECIAL2'] == 1) echo 'checked'; ?> type="checkbox" id="<?= $id . 'especial2' ?>" name="<?= $id . 'especial2' ?>" value="1" >
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
    $('#gridTabela').dataTable({
        "sPaginationType": "full_numbers"
    });

    jQuery(function($) {
        $("#programa").chosen();

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