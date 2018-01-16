<?php $this->load->view('layout/header'); ?>

<div id="content">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel-group accordion-professor-opcoes">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#accordion4" data-parent=".accordion-professor-opcoes" data-toggle="collapse">
                                <i class="fa fa-users"></i> Calendário de Provas <i class="fa fa-angle-down pull-right"></i>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse" id="accordion4">
                        <div class="panel-body"> 
                            <div id="taskId" class="task-list">
                                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview4" name="gridview4">
                                    <thead>
                                        <tr>
                                            <th>Publicado em:</th>
                                            <th style="display: none"></th>
                                            <th>Titulo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($noticias as $n) {
                                            if ($n['CD_TIPO'] == 7) {
                                                ?>
                                                <tr>
                                                    <td><?= $n['DT_PUBLICACAO'] ?></td>
                                                    <td style="display: none"><?= $n['ID_NOTICIA'] ?></td>
                                                    <td style="font-size:11px; text-transform:uppercase">
                                                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/portal/application/upload/noticia/<?= $n['CHAMADA'] ?>" target="_blank"><?= substr($n['TITULO'], 0, 80) ?>...</a></td> 
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>  
                        </div> 
                    </div>
                </div>

                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#accordion1" data-parent=".accordion-professor-opcoes" data-toggle="collapse">
                                <i class="fa fa-users"></i> Reuniões <i class="fa fa-angle-down pull-right"></i>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse" id="accordion1">
                        <div class="panel-body"> 
                            <div id="taskId" class="task-list">
                                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview" name="gridview">
                                    <thead>
                                        <tr>
                                            <th>Publicado em:</th>
                                            <th style="display: none"></th>
                                            <th>Titulo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($noticias as $n) {
                                            if ($n['CD_TIPO'] == 4) {
                                                ?>
                                                <tr>
                                                    <td><?= $n['DT_PUBLICACAO'] ?></td>
                                                    <td style="display: none"><?= $n['ID_NOTICIA'] ?></td>
                                                    <td style="font-size:11px; text-transform:uppercase">
                                                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/portal/application/upload/noticia/<?= $n['CHAMADA'] ?>" target="_blank"><?= substr($n['TITULO'], 0, 80) ?>...</a></td> 
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>  
                        </div> 
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#accordion2" data-parent=".accordion-professor-opcoes" data-toggle="collapse">
                                <i class="fa fa-book"></i> Avisos & Notícias <i class="fa fa-angle-down pull-right"></i>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse" id="accordion2">
                        <div class="panel-body"> 
                            <div id="taskId" class="task-list">
                                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview2" name="gridview2">
                                    <thead>
                                        <tr>
                                            <th>Publicado em:</th>
                                            <th style="display: none"></th>
                                            <th>Titulo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($noticias as $n) {
                                            if ($n['CD_TIPO'] == 1) {
                                                ?>
                                                <tr>
                                                    <td><?= $n['DT_PUBLICACAO'] ?></td>
                                                    <td style="display: none"><?= $n['ID_NOTICIA'] ?></td>
                                                    <td style="font-size:11px; text-transform:uppercase">
                                                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/portal/application/upload/noticia/<?= $n['CHAMADA'] ?>" target="_blank"><?= substr($n['TITULO'], 0, 60) ?>...</a></td> 
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>  
                        </div> 
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#accordion3" data-parent=".accordion-professor-opcoes" data-toggle="collapse">
                                <i class="fa fa-coffee"></i> Cardápio <i class="fa fa-angle-down pull-right"></i>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse" id="accordion3">
                        <div class="panel-body"> 
                            <div id="taskId" class="task-list">
                                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview3" name="gridview3">
                                    <thead>
                                        <tr>
                                            <th>Publicado em:</th>
                                            <th style="display: none"></th>
                                            <th>Titulo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($noticias as $n) {
                                            if ($n['CD_TIPO'] == 2) {
                                                ?>
                                                <tr>
                                                    <td><?= $n['DT_PUBLICACAO'] ?></td>
                                                    <td style="display: none"><?= $n['ID_NOTICIA'] ?></td>
                                                    <td style="font-size:11px; text-transform:uppercase">
                                                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/portal/application/upload/noticia/<?= $n['CHAMADA'] ?>" target="_blank"><?= substr($n['TITULO'], 0, 80) ?>...</a></td> 
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>  
                        </div> 
                    </div>

                    <div class="panel-collapse collapse" id="accordion3">
                        <div class="panel-body"> 
                            <div id="taskId" class="task-list">
                                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview3" name="gridview3">
                                    <thead>
                                        <tr>
                                            <th>Publicado em:</th>
                                            <th style="display: none"></th>
                                            <th>Titulo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($noticias as $n) {
                                            if ($n['CD_TIPO'] == 2) {
                                                ?>
                                                <tr>
                                                    <td><?= $n['DT_PUBLICACAO'] ?></td>
                                                    <td style="display: none"><?= $n['ID_NOTICIA'] ?></td>
                                                    <td style="font-size:11px; text-transform:uppercase">
                                                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/portal/application/upload/noticia/<?= $n['CHAMADA'] ?>" target="_blank"><?= substr($n['TITULO'], 0, 80) ?>...</a></td> 
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>  
                        </div> 
                    </div>
                </div>
            </div>
        </div> 

        <div class="col-sm-6">
            <div class="panel-group accordion-professor-opcoes"> 

                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#accordion5" data-parent=".accordion-professor-opcoes" data-toggle="collapse">
                                <i class="fa fa-list"></i> Simulado <i class="fa fa-angle-down pull-right"></i>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse" id="accordion5">
                        <div class="panel-body"> 
                            <div id="taskId" class="task-list">
                                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview3" name="gridview3">
                                    <thead>
                                        <tr>
                                            <th>Publicado em:</th>
                                            <th style="display: none"></th>
                                            <th>Titulo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($noticias as $n) {
                                            if ($n['CD_TIPO'] == 3) {
                                                ?>
                                                <tr>
                                                    <td><?= $n['DT_PUBLICACAO'] ?></td>
                                                    <td style="display: none"><?= $n['ID_NOTICIA'] ?></td>
                                                    <td style="font-size:11px; text-transform:uppercase">
                                                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/portal/application/upload/noticia/<?= $n['CHAMADA'] ?>" target="_blank"><?= substr($n['TITULO'], 0, 80) ?>...</a></td> 
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>  
                        </div> 
                    </div>

                    <div class="panel-collapse collapse" id="accordion5">
                        <div class="panel-body"> 
                            <div id="taskId" class="task-list">
                                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview3" name="gridview3">
                                    <thead>
                                        <tr>
                                            <th>Publicado em:</th>
                                            <th style="display: none"></th>
                                            <th>Titulo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($noticias as $n) {
                                            if ($n['CD_TIPO'] == 2) {
                                                ?>
                                                <tr>
                                                    <td><?= $n['DT_PUBLICACAO'] ?></td>
                                                    <td style="display: none"><?= $n['ID_NOTICIA'] ?></td>
                                                    <td style="font-size:11px; text-transform:uppercase">
                                                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/portal/application/upload/noticia/<?= $n['CHAMADA'] ?>" target="_blank"><?= substr($n['TITULO'], 0, 80) ?>...</a></td> 
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>  
                        </div> 
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#accordion6" data-parent=".accordion-professor-opcoes" data-toggle="collapse">
                                <i class="fa fa-list"></i> Passeios / Visitas Técnicas <i class="fa fa-angle-down pull-right"></i>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse" id="accordion6">
                        <div class="panel-body"> 
                            <div id="taskId" class="task-list">
                                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview3" name="gridview3">
                                    <thead>
                                        <tr>
                                            <th>Publicado em:</th>
                                            <th style="display: none"></th>
                                            <th>Titulo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($noticias as $n) {
                                            if ($n['CD_TIPO'] == 5) {
                                                ?>
                                                <tr>
                                                    <td><?= $n['DT_PUBLICACAO'] ?></td>
                                                    <td style="display: none"><?= $n['ID_NOTICIA'] ?></td>
                                                    <td style="font-size:11px; text-transform:uppercase">
                                                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/portal/application/upload/noticia/<?= $n['CHAMADA'] ?>" target="_blank"><?= substr($n['TITULO'], 0, 80) ?>...</a></td> 
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>  
                        </div> 
                    </div>

                    <div class="panel-collapse collapse" id="accordion5">
                        <div class="panel-body"> 
                            <div id="taskId" class="task-list">
                                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview3" name="gridview3">
                                    <thead>
                                        <tr>
                                            <th>Publicado em:</th>
                                            <th style="display: none"></th>
                                            <th>Titulo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($noticias as $n) {
                                            if ($n['CD_TIPO'] == 2) {
                                                ?>
                                                <tr>
                                                    <td><?= $n['DT_PUBLICACAO'] ?></td>
                                                    <td style="display: none"><?= $n['ID_NOTICIA'] ?></td>
                                                    <td style="font-size:11px; text-transform:uppercase">
                                                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/portal/application/upload/noticia/<?= $n['CHAMADA'] ?>" target="_blank"><?= substr($n['TITULO'], 0, 80) ?>...</a></td> 
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>  
                        </div> 
                    </div>
                </div>

                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#accordion7" data-parent=".accordion-professor-opcoes" data-toggle="collapse">
                                <i class="fa fa-list"></i> Sábado Letivo <i class="fa fa-angle-down pull-right"></i>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse" id="accordion7">
                        <div class="panel-body"> 
                            <div id="taskId" class="task-list">
                                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview3" name="gridview3">
                                    <thead>
                                        <tr>
                                            <th>Publicado em:</th>
                                            <th style="display: none"></th>
                                            <th>Titulo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($noticias as $n) {
                                            if ($n['CD_TIPO'] == 6) {
                                                ?>
                                                <tr>
                                                    <td><?= $n['DT_PUBLICACAO'] ?></td>
                                                    <td style="display: none"><?= $n['ID_NOTICIA'] ?></td>
                                                    <td style="font-size:11px; text-transform:uppercase">
                                                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/portal/application/upload/noticia/<?= $n['CHAMADA'] ?>" target="_blank"><?= substr($n['TITULO'], 0, 80) ?>...</a></td> 
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>  
                        </div> 
                    </div>

                    <div class="panel-collapse collapse" id="accordion5">
                        <div class="panel-body"> 
                            <div id="taskId" class="task-list">
                                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview3" name="gridview3">
                                    <thead>
                                        <tr>
                                            <th>Publicado em:</th>
                                            <th style="display: none"></th>
                                            <th>Titulo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($noticias as $n) {
                                            if ($n['CD_TIPO'] == 2) {
                                                ?>
                                                <tr>
                                                    <td><?= $n['DT_PUBLICACAO'] ?></td>
                                                    <td style="display: none"><?= $n['ID_NOTICIA'] ?></td>
                                                    <td style="font-size:11px; text-transform:uppercase">
                                                        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/portal/application/upload/noticia/<?= $n['CHAMADA'] ?>" target="_blank"><?= substr($n['TITULO'], 0, 80) ?>...</a></td> 
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>  
                        </div> 
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div id="accordion-3" class="panel-group">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#accordion3-2" data-parent=".accordion-professor-opcoes" data-toggle="collapse">
                                Horário de Aula <i class="fa fa-angle-down pull-right"></i>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse in" id="accordion3-2">
                        <div class="panel-body" style="padding: 0px;"> 
                            <div id="taskId" class="task-list">                                
                                <table class="table table-hover table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" colspan="7">
                                                MANHÃ
                                            </th>
                                        </tr>

                                        <tr>
                                            <th class="text-center" style="width: 10%">Tempo</th>
                                            <th class="text-center" style="width: 15%">Segunda</th>
                                            <th class="text-center" style="width: 15%">Terça</th>
                                            <th class="text-center" style="width: 15%">Quarta</th>
                                            <th class="text-center" style="width: 15%">Quinta</th>
                                            <th class="text-center" style="width: 15%">Sexta</th>
                                            <th class="text-center" style="width: 15%">Sábado</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($horario as $row): ?>
                                            <?php if ($row['TURNO'] == 'Manha'): ?>
                                                <tr>
                                                    <td class="text-center"><?= $row['TEMPO'] ?></td>
                                                    <td class="text-center"><?= $row['SEGUNDA'] ?></td>
                                                    <td class="text-center"><?= $row['TERCA'] ?></td>
                                                    <td class="text-center"><?= $row['QUARTA'] ?></td>
                                                    <td class="text-center"><?= $row['QUINTA'] ?></td>
                                                    <td class="text-center"><?= $row['SEXTA'] ?></td>
                                                    <td class="text-center"><?= $row['SABADO'] ?></td>                                            
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>                                    
                                </table>


                                <table class="table table-hover table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center" colspan="7">
                                                TARDE
                                            </th>
                                        </tr>

                                        <tr>
                                            <th class="text-center" style="width: 10%">Tempo</th>
                                            <th class="text-center" style="width: 15%">Segunda</th>
                                            <th class="text-center" style="width: 15%">Terça</th>
                                            <th class="text-center" style="width: 15%">Quarta</th>
                                            <th class="text-center" style="width: 15%">Quinta</th>
                                            <th class="text-center" style="width: 15%">Sexta</th>
                                            <th class="text-center" style="width: 15%">Sábado</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($horario as $row): ?>
                                            <?php if ($row['TURNO'] == 'Tarde'): ?>
                                                <tr>
                                                    <td class="text-center"><?= $row['TEMPO'] ?></td>
                                                    <td class="text-center"><?= $row['SEGUNDA'] ?></td>
                                                    <td class="text-center"><?= $row['TERCA'] ?></td>
                                                    <td class="text-center"><?= $row['QUARTA'] ?></td>
                                                    <td class="text-center"><?= $row['QUINTA'] ?></td>
                                                    <td class="text-center"><?= $row['SEXTA'] ?></td>
                                                    <td class="text-center"><?= $row['SABADO'] ?></td>                                            
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>                                    
                                </table>
                            </div>  
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view("inicio/modal-aviso") ?>

<script>

    $('#gridview').dataTable({
        "sPaginationType": "full_numbers",
        "oLanguage": {
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "sLengthMenu": "Mostrar por página _MENU_ ",
            "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
            "sInfoEmpty": "Registro não encontrado",
            "sZeroRecords": "Não há registro",
        },
        "aaSorting": [[0, "desc"]],
    });
    $('#gridview_wrapper .dataTables_filter input').attr('placeholder', 'Procurar...');
</script>
<?php $this->load->view('layout/footer'); ?>


