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
                <th class="sorting_disabled text-center" style="width:10%" aria-label="">Alunos</th>
                <th class="sorting_disabled text-center" style="width:10%" aria-label="">Ações</th>
            </tr>
        </thead>    

        <tbody>
            <?php foreach ($aulas as $row) : ?>
                <tr>
                    <td class="text-center" style="vertical-align: middle">
                        <?= $row['TEMPO_AULA'] ?>º TEMPO 
                    </td>

                    <?php
                    if (($row['GEMINADO'] && $row['QTDE_GEMINADO'] > 0) || !$row['GEMINADO']):
                        $rowspan = $row['QTDE_GEMINADO'] > 0 ? "rowspan='" . ($row['QTDE_GEMINADO']) . "'" : "";
                        ?>
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
                            <?= $row['HR_TEMPO_INICIO'] ?> - 
                            <?= $row['ULTIMO_GEMINADO'] !== null ? $row['ULTIMO_GEMINADO']['HR_TEMPO_FIM'] : $row['HR_TEMPO_FIM'] ?>
                        </td>                    

                        <td class="text-center" <?= $rowspan ?> style="vertical-align: middle">
                            <?= $row['HR_ABERTURA'] ?>
                        </td>

                        <td class="text-center" <?= $rowspan ?> style="vertical-align: middle">
                            <?= $row['ULTIMO_GEMINADO'] !== null ? $row['ULTIMO_GEMINADO']['HR_FECHAMENTO'] : $row['HR_FECHAMENTO'] ?>                            
                        </td>

                        <td class="text-center" <?= $rowspan ?> style="vertical-align: middle">
                            <a href="<?= site_url("professor/diario/modal_lista_aluno?aula=" . $row['CD_CL_AULA']) ?>" data-toggle="modal" data-target="#modal_lista_aluno_<?= $row['CD_CL_AULA'] ?>">
                                <i class="fa fa-list fa-lg"></i>
                            </a>

                            <!-- Modal lista de alunos-->                            
                            <div class="modal fade" id="modal_lista_aluno_<?= $row['CD_CL_AULA'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"> 
                                <div class="modal-dialog" style="width: 40%;">
                                    <div class="modal-content">
                                    </div>
                                </div>
                            </div>

                            &nbsp;&nbsp;
                            <a href="<?= site_url("professor/diario/modal_lista_conteudo?aula=" . $row['CD_CL_AULA']) ?>" data-toggle="modal" data-target="#modal_lista_conteudo_<?= $row['CD_CL_AULA'] ?>">
                                <i class="fa fa-bookmark fa-lg"></i>
                            </a>

                            <!--modal lista conteudo ministrado e tarefa para casa-->
                            <div class="modal fade" id="modal_lista_conteudo_<?= $row['CD_CL_AULA'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"> 
                                <div class="modal-dialog" style="width: 70%;">
                                    <div class="modal-content">
                                    </div>
                                </div>
                            </div>
                            <!--modal lista conteudo ministrado e tarefa para casa-->
                        </td>

                        <td class="text-center" <?= $rowspan ?> style="vertical-align: middle">
                            <?php if ($row['HR_ABERTURA'] == ""): ?>
                                <a class="btn btn-primary" href="<?= site_url("professor/diario/abrir_aula?aula=" . $row['CD_CL_AULA']) ?>">
                                    Abrir Aula                        
                                </a>
                            <?php elseif (($row['ULTIMO_GEMINADO'] === null && $row['HR_FECHAMENTO'] == "") || $row['ULTIMO_GEMINADO'] !== null && $row['ULTIMO_GEMINADO']['HR_FECHAMENTO'] == "") : ?>
                                <a href="<?= site_url("professor/diario/modal_frequencia?aula=" . $row['CD_CL_AULA']) ?>" data-toggle="modal" data-target="#modal_frequencia_<?= $row['CD_CL_AULA'] ?>">
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
                                <a href="<?= site_url("professor/diario/modal_conteudo?aula=" . $row['CD_CL_AULA']) ?>" data-toggle="modal" data-target="#modal_conteudo_<?= $row['CD_CL_AULA'] ?>">
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
                                <a href="<?= site_url("professor/diario/fechar_aula?aula=" . $row['CD_CL_AULA']) ?>" >
                                    <i class="fa fa-close fa-lg"></i>
                                </a>
                            <?php endif; ?>
                        </td>                        
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="9">
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