<div class="table-responsive">
    <table class="table table-bordered table-hover" id="gridview">
        <thead>
            <tr class="panel-heading">
                <th class="sorting text-center">Tempo</th>
                <th class="sorting text-center">Disciplina</th>
                <th class="sorting text-center">Série</th>
                <th class="sorting text-center">Turma</th>
                <th class="sorting text-center">Horário</th>                                                
                <th class="sorting_disabled text-center" style="width:10%" aria-label="">Ação</th>
            </tr>
        </thead>    

        <tbody>
            <?php foreach ($aulas as $row) : ?>
                <tr>
                    <td class="text-center" style="vertical-align: middle">
                        <?= $row['TEMPO_AULA'] ?>º TEMPO 
                    </td>

                    <td class="text-center" <?= $rowspan ?> style="vertical-align: middle">
                        <?= $row['NM_DISCIPLINA'] ?>
                    </td>

                    <td class="text-center" <?= $rowspan ?> style="vertical-align: middle">
                        <?= $row['ORDEM_SERIE'] . "º" ?>
                    </td>

                    <td class="text-center" <?= $rowspan ?> style="vertical-align: middle">
                        <?php
                        if ($row['SUBTURMA'] == '') {
                            echo $row['CD_TURMA'];
                        } else {
                            echo $row['CD_TURMA'] . " - " . $row['SUBTURMA'];
                        }
                        ?>
                    </td>

                    <td class="text-center" <?= $rowspan ?> style="vertical-align: middle">
                        <?= $row['HR_TEMPO_INICIO'] . " - " . $row['HR_TEMPO_FIM'] ?>
                    </td>                                                            

                    <td class="text-center" <?= $rowspan ?> style="vertical-align: middle">
                        <a href="<?= site_url("professor/diario/modal_conteudo?aula=" . $row['CD_CL_AULA'] . "&data=" . $dataPendencia) ?>" data-toggle="modal" data-target="#modal_conteudo_<?= $row['CD_CL_AULA'] ?>" class="btn btn-primary">
                            <i class="fa fa-book fa-lg"></i> Lançar Conteúdo
                        </a>

                        <div class="modal fade" id="modal_conteudo_<?= $row['CD_CL_AULA'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"> 
                            <div class="modal-dialog modal-lg   ">
                                <div class="modal-content">
                                    <?= modal_load ?>
                                </div>
                            </div>
                        </div>
                    </td>                        
                </tr>
            <?php endforeach; ?>
        </tbody>        
    </table> 
</div>