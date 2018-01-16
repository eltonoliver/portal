<div class="panel panel-danger">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-pills nav-justified" style="background-color: #e6e6e6">
                    <li class="active"><a href="#registro" data-toggle="pill">Registros</a></li>
                    <li><a href="#advertencia" data-toggle="pill">Advertências</a></li>
                    <li><a href="#suspensao" data-toggle="pill">Suspensões</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tab-content" style="margin-top: 30px;">

                    <div class="tab-pane active" id="registro">
                        <?php if (count($registros) === 0): ?>
                            <p>Não existem registros para esta opção.</p>
                        <?php else: ?>
                            <table class="table table-striped table-hover table-bordered" id="tabela-registros">
                                <thead>
                                    <tr>
                                        <th class="text-center">DATA</th>
                                        <th class="text-center">TIPO DE REGISTRO</th>                            
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
                                                <?= mb_strtoupper($row['NM_TIPO_REGISTRO'], "UTF-8"); ?>
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

                    <div class="tab-pane" id="advertencia">
                        <?php if (count($advertencias) === 0): ?>
                            <p>Não existem registros para esta opção.</p>
                        <?php else: ?>
                            <table class="table table-striped table-hover table-bordered" id="tabela-advertencias">
                                <thead>
                                    <tr>
                                        <th class="text-center">DATA</th>
                                        <th class="text-center">TIPO DE ADVERTÊNCIA</th>                            
                                        <th class="text-center">MOTIVO</th>                            
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($advertencias as $row): ?>
                                        <tr>
                                            <td class="text-center">
                                                <?= date("d/m/Y", strtotime($row['DT_ADVERTENCIA'])) ?>
                                            </td>

                                            <td class="text-center">
                                                <?php
                                                $tipo = "";

                                                switch ($row['FLG_TIPO']) {
                                                    case "P":
                                                        $tipo = "PEDAGÓGICO";
                                                        break;
                                                    case "D":
                                                        $tipo = "DISCIPLINAR";
                                                        break;
                                                    default:
                                                        $tipo = "";
                                                }
                                                ?>                                                
                                                <?= mb_strtoupper($tipo, "UTF-8") ?>
                                            </td>

                                            <td class="text-justify" style="padding: 5px;">
                                                <?= mb_strtoupper($row['MOTIVO'], "UTF-8"); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?> 
                    </div>

                    <div class="tab-pane" id="suspensao">
                        <?php if (count($suspensoes) === 0): ?>
                            <p>Não existem registros para esta opção.</p>
                        <?php else: ?>
                            <table class="table table-hover table-striped table-bordered" data-filter="#filter" id="tabela-suspensoes">
                                <thead>
                                    <tr>
                                        <th class="text-center">PERÍODO</th>                                    
                                        <th class="text-center">QTDE DIAS</th>
                                        <th class="text-center">MOTIVO</th>
                                    </tr>
                                </thead>

                                <tbody>                    
                                    <?php foreach ($suspensoes as $row) : ?>
                                        <tr>                                
                                            <td class="text-center">
                                                <?= date('d/m/Y', strtotime($row['DT_INICIO'])) . " à " . date("d/m/Y", strtotime($row['DT_FIM'])); ?>
                                            </td>

                                            <td class="text-center">
                                                <?= $row['DIAS']; ?>
                                            </td>

                                            <td class="text-justify" style="padding: 5px;">
                                                <?= mb_strtoupper($row['MOTIVO'], "UTF-8"); ?>
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
    $('#tabela-registros').dataTable({
        sPaginationType: "full_numbers",
        aaSorting: []
    });

    $('.tabela-advertencias').dataTable({
        bFilter: false,
        sPaginationType: "full_numbers",
        aaSorting: []
    });

    $('#tabela-suspensoes').dataTable({
        bFilter: false,
        sPaginationType: "full_numbers",
        aaSorting: []
    });
</script>

<?php exit(); ?>