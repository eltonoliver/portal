<table width="100%" border="1" class="table table-striped table-bordered table-hover dataTable" id="listar_filtro">
    <table width="100%" border="1" class="table table-striped table-bordered table-hover dataTable" id="listar">
        <thead>
            <tr>
                <td colspan="7"><button class="btn btn-info btn-sm" data-toggle="modal" href="#frmnovo"> Nova Ocorrência <i class="icon-plus align-top bigger-60 icon-on-right"></i> </button></td>
            </tr>
            <tr>
                <td width="2%" align="center">Nº</td>
                <td width="10%">MATRÍCULA</td>
                <td width="25%">ALUNO</td>
                <td width="10%">DATA</td>
                <td width="8%">STATUS</td>
                <td width="8%"></td>
            </tr>
        </thead>
        <tbody>
            <? foreach ($listar as $row) { ?>
                <tr class="<? if ($row->ATIVO == 'A') echo 'orange'; ?>" style="cursor:hand">
                    <td align="center"><?= $row['NR_ORDEM'] ?></td>
                    <td><?= $row['CD_ALUNO'] ?></td>
                    <td><?= $row['NM_ALUNO'] ?></td>
                    <td><?= $row['DT_OCORRENCIA'] //date('d/m/Y', strtotime($row['DT_OCORRENCIA'])) ?></td>
                    <td id="resposta<?= $row['CD_ALUNO'] . $row['NR_ORDEM'] ?>"> 
                    <iframe frameborder="0" width="100px" height="50px" src="http://ww2.iagentesms.com.br/webservices/http.php?metodo=consulta&usuario=seculomanaus&senha=20022014&codigosms=<?= $row['CD_ALUNO'] . $row['NR_ORDEM'] ?>"></iframe>
                    </td>
                    <td>
                        <div class="action-buttons"> 
                            <a class="orange" data-toggle="modal" href="#com<?= $ro['CD_ALUNO'] . $row['NR_ORDEM'] ?>"> <i class="fa fa-comments bigger-130"></i> </a>  
                            <a class="red" data-toggle="modal" href="#del<?= $row['CD_ALUNO'] . $row['NR_ORDEM'] ?>"> <i class="fa fa-trash-o bigger-130"></i> </a> 
                        </div>
                    </td>
                </tr>
            <? } ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7"></td>
            </tr>
        </tfoot>
    </table>
    <? foreach ($listar as $row) { ?>
        <div class="modal fade" id="view<?= $row->CD_ALUNO . $row->NR_ORDEM ?>" data-remote="<?= SCL_RAIZ ?>/coordenador/ocorrencia/view">
            <?= modal_load ?>
        </div>
        <div class="modal fade" id="edit<?= $row->CD_ALUNO . $row->NR_ORDEM ?>">
            <?= modal_load ?>
        </div>
        <div class="modal fade" id="com<?= $row->CD_ALUNO . $row->NR_ORDEM ?>" data-remote="<?= SCL_RAIZ ?>/coordenador/ocorrencia/comunicado?aluno=<?= $row->CD_ALUNO . '&ordem=' . $row->NR_ORDEM ?>">
            <?= modal_load ?>
        </div>
        <div class="modal fade" id="del<?= $row->CD_ALUNO . $row->NR_ORDEM ?>">
            <div class="modal-dialog">
                <form action="<?= SCL_RAIZ ?>/coordenador/ocorrencia/deletar" method="post" class="form-horizontal" enctype="multipart/form-data" id="form<?= $row->CD_ALUNO . $row->NR_ORDEM ?>" name="form<?= $row->CD_ALUNO . $row->NR_ORDEM ?>">
                    <div class="modal-content">
                        <div class="modal-header btn-danger">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 class="modal-title">Deletar Ocorrência</h3>
                        </div>
                        <div class="modal-body">
                            <div class="box-content">
                                <label class="control-label"><strong>Você deseja realmente deletar essa ocorrência?</strong></label>
                                <input name="aluno<?= $row->CD_ALUNO . $row->NR_ORDEM ?>" id="aluno<?= $row->CD_ALUNO . $row->NR_ORDEM ?>" type="hidden" value="<?= $row->CD_ALUNO ?>"/>
                                <input name="ordem<?= $row->CD_ALUNO . $row->NR_ORDEM ?>" id="ordem<?= $row->CD_ALUNO . $row->NR_ORDEM ?>" type="hidden" value="<?= $row->NR_ORDEM ?>"/>
                                <input name="codigo" id="codigo" type="hidden" value="<?= $row->CD_ALUNO . $row->NR_ORDEM ?>"/>
                                <?
                                if ($row->NR_REGISTRO == 0) {
                                    echo '<input name="operacao' . $row->CD_ALUNO . $row->NR_ORDEM . '" id="operacao' . $row->CD_ALUNO . $row->NR_ORDEM . '" type="hidden" value="D"/>';
                                    $OPERACAO = 'D';
                                } else {
                                    $OPERACAO = 'C';
                                    echo '<input name="operacao' . $row->CD_ALUNO . $row->NR_ORDEM . '" id="operacao' . $row->CD_ALUNO . $row->NR_ORDEM . '" type="hidden" value="C"/>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="modal-footer"> 
                            <a href="<?= SCL_RAIZ ?>/coordenador/ocorrencia" id="<?= $row->CD_ALUNO . $row->NR_ORDEM ?>" class="btn btn-default" onclick="getDelete(<?= $OPERACAO . ',' . $row->CD_ALUNO . ',' . $row->NR_ORDEM ?>, this)" ><i class="elusive icon-ban"></i> Não</a>
                            <a class="btn btn-primary" onclick="getDelete('<?= $OPERACAO ?>',<?= $row->CD_ALUNO ?>,<?= $row->NR_ORDEM ?>, this)" id="<?= $row->CD_ALUNO . $row->NR_ORDEM ?>" >
                                <i class="fa fa-pencil"></i> SIM </a>
                        </div>
                    </div>
                </form>
                <!-- /.modal-content --> 
            </div>
        </div>
    <? } ?>
    <script src="<?= SCL_JS ?>jquery.dataTables.min.js"></script> 
    <script src="<?= SCL_JS ?>jquery.dataTables.bootstrap.js"></script> 
    <script>
                            $('#listar').dataTable({
                                "sPaginationType": "full_numbers",
                                "aaSorting": [[3, "desc"]],
                            });
    </script>
    <? exit(); ?>