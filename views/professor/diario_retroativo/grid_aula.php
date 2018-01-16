<div class="table-responsive">
    <table class="table table-bordered table-hover" id="gridview">
        <thead>
            <tr class="panel-heading">
                <th class="sorting text-center">Tempo</th>
                <th class="sorting text-center">Disciplina</th>
                <th class="sorting text-center">Série</th>
                <th class="sorting text-center">Turma</th>
                <th class="sorting text-center">Horário</th>                
                <th class="sorting text-center"><i class="fa fa-clock-o"></i> Início</th>
                <th class="sorting text-center"><i class="fa fa-clock-o"></i> Término</th>
                <th class="sorting text-center">Realizou Chamada</th>
                <th class="sorting text-center">Lançou Conteúdo</th>
                <th class="sorting text-center">Ações</th>                
            </tr>
        </thead>    

        <tbody>
            <?php foreach ($aulas as $row) : ?>
                <tr>
                    <td class="text-center" style="vertical-align: middle">
                        <?= $row['TEMPO_AULA'] ?>º TEMPO 
                    </td>

                    <td class="text-center"  style="vertical-align: middle">
                        <?= $row['NM_DISCIPLINA'] ?>
                    </td>

                    <td class="text-center"  style="vertical-align: middle">
                        <?= $row['CD_SERIE'] . "º" ?>
                    </td>

                    <td class="text-center"  style="vertical-align: middle">
                        <?php
                        if ($row['SUBTURMA'] == '') {
                            echo $row['CD_TURMA'];
                        } else {
                            echo $row['CD_TURMA'] . " - " . $row['SUBTURMA'];
                        }
                        ?>
                    </td>

                    <td class="text-center"  style="vertical-align: middle">
                        <?= $row['HR_TEMPO_INICIO'] . ' - ' . $row['HR_TEMPO_FIM'] ?>
                    </td>                    

                    <td class="text-center"  style="vertical-align: middle">
                        <?= $row['HR_ABERTURA'] ?>
                    </td>

                    <td class="text-center"  style="vertical-align: middle">
                        <?= $row['HR_FECHAMENTO'] ?>                            
                    </td>                    

                    <td class="text-center"  style="vertical-align: middle">
                        <?php
                        if ($row['REQUER_CHAMADA'] === 'N') {
                            echo "-";
                        } else if ($row['REALIZOU_CHAMADA'] === "N") {
                            echo "<span class='text-danger'><strong>NÃO</strong></span>";
                        } else {
                            echo "SIM";
                        }
                        ?>
                    </td>

                    <td class="text-center"  style="vertical-align: middle">
                        <?php
                        if ($row['CONTEUDO'] == null && $row['OUTRAS'] == 0) {
                            echo "<span class='text-danger'><strong>NÃO</strong></span>";
                        } else {
                            echo "SIM";
                        }
                        ?>
                    </td>

                    <td class="text-center"  style="vertical-align: middle">
                        <?php if ($row['HR_ABERTURA'] == ""): ?>
                            <a class="btn btn-primary" href="<?= site_url("professor/diario_retroativo/abrir?aula=" . $row['CD_CL_AULA'] . "&data=" . $dataPendencia . "&curso=" . $row['CD_CURSO'] . "&disc=" . $row['CD_DISCIPLINA']) ?>">
                                Abrir Aula                        
                            </a>
                        <?php else : ?>
                            <a href="<?= site_url("professor/diario_retroativo/modal_frequencia?aula=" . $row['CD_CL_AULA'] . "&data=" . $dataPendencia) ?>" data-toggle="modal" data-target="#modal_frequencia_<?= $row['CD_CL_AULA'] ?>">
                                <i class="fa fa-users fa-lg"></i>
                            </a>

                            <!-- Modal para chamada dos alunos -->
                            <div class="modal fade" id="modal_frequencia_<?= $row['CD_CL_AULA'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"> 
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    </div>
                                </div>
                            </div>

                            &nbsp;&nbsp;
                            <a href="<?= site_url("professor/diario_retroativo/modal_conteudo?aula=" . $row['CD_CL_AULA'] . "&data=" . $dataPendencia) ?>" data-toggle="modal" data-target="#modal_conteudo_<?= $row['CD_CL_AULA'] ?>">
                                <i class="fa fa-book fa-lg"></i>
                            </a>

                            <!-- Modal para lançamento de conteúdo da aula -->            
                            <div class="modal fade" id="modal_conteudo_<?= $row['CD_CL_AULA'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"> 
                                <div class="modal-dialog modal-lg   ">
                                    <div class="modal-content">
                                        <?= modal_load ?>
                                    </div>
                                </div>
                            </div>

                            &nbsp;&nbsp;                                
                            <a href="<?= site_url("professor/diario_retroativo/fechar?aula=" . $row['CD_CL_AULA'] . "&data=" . $dataPendencia) ?>" >
                                <i class="fa fa-close fa-lg"></i>
                            </a>
                        <?php endif; ?>
                    </td>                     
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="10">
                    <i class="fa fa-users"></i> - Realizar chamada |
                    <i class="fa fa-book"></i> - Lançar Conteúdo Ministrado |
                    <i class="fa fa-times"></i> - Fechar Aula |
                    <i class="fa fa-list"></i> - Lista de Alunos da Turma |
                    <i class="fa fa-bookmark"></i> Conteúdo Lançado
                </th>
            </tr>
        </tfoot>
    </table> 
</div>