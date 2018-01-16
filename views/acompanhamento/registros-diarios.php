<div class="panel panel-danger">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content" style="margin-top: 30px;">

                    <div class="tab-pane active" id="registro_diario">
                        <?php if (count($registros) === 0): ?>
                            <p>Não existem registros para esta opção.</p>
                        <?php else: ?>
                            <table class="table table-striped table-hover table-bordered" id="tabela-registros-diarios">
                                <thead>
                                    <tr>
                                        <th class="text-center">DATA</th>
                                        <th class="text-center">PROFESSOR</th>                            
                                        <th class="text-center">DESCRIÇÃO</th>                            
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($registros as $row): ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= date("d/m/Y", strtotime($row['DT_REGISTRO'])) ?>
                                            </td>

                                            <td class="text-center">
                                                <?= mb_strtoupper($row['PROFESSOR'], "UTF-8"); ?>
                                            </td>

                                            <td class="text-justify" style="padding: 5px;">
                                                <?= mb_strtoupper($row['DS_REGISTRO'], "UTF-8"); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('#tabela-registros-diarios').dataTable({
        sPaginationType: "full_numbers",
        aaSorting: []
    });

</script>

<?php exit(); ?>