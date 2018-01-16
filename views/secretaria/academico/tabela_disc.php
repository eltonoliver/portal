<ul class="nav nav-pills nav-justified">
    <li class="active">
        <a href="#conteudo" data-toggle="pill"><i class="fa fa-list"></i> Conteúdo Ministrado</a>
    </li>

    <li>
        <a href="#prova" data-toggle="pill"><i class="fa fa-list"></i> Conteúdo de Provas</a>
    </li>

    <li>
        <a href="#arquivo" data-toggle="pill"><i class="fa fa-download"></i> Arquivos de Apoio</a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="conteudo">
        <div class="well" style="margin: 20px 0">
            <table class="table table-hover table-striped table-bordered" data-filter="#filter" width="100%" id="TableDisc">
                <thead>
                    <tr>
                        <th class="text-center">AULA</th>
                        <th class="text-center" data-toggle="true">DATA</th>
                        <th class="text-center">DISCIPLINA</th>
                        <th class="text-center col-sm-3" data-hide="phone,tablet">CONTEÚDO</th>
                        <th class="text-center col-sm-3" data-hide="phone,tablet">ASSUNTO LIVRO</th>
                        <th class="text-center col-sm-2" data-hide="phone,tablet">SUGESTÃO DE ESTUDO</th>
                    </tr>
                </thead>

                <tbody>                                    
                    <?php foreach ($conteudos as $conteudo) : ?>                    
                        <tr>
                            <td class="text-center">
                                <strong> <?= $conteudo['CD_CL_AULA']; ?></strong>                                
                            </td>

                            <td class="text-center">
                                <?= date('d/m/Y', strtotime($conteudo['DT_AULA'])); ?>
                            </td>

                            <td class="text-center">
                                <?= $conteudo['NM_DISCIPLINA']; ?>
                            </td>

                            <td class="text-justify" style="padding: 5px">
                                <?= $conteudo['CONTEUDO'] ?>
                            </td>

                            <td class="text-justify" style="padding-right: 10px;">
                                <ul>
                                    <?php foreach ($conteudo["ASSUNTO_LIVRO"] as $row): ?>                                            
                                        <li><?= $row['DC_ASSUNTO'] ?></li>                                            
                                    <?php endforeach; ?>
                                </ul>
                            </td>

                            <td class="text-justify" style="padding: 5px">
                                <?= mb_substr(strtoupper(strtr($conteudo['TAREFA_CASA'], "áéíóúâêôãõàèìòùç", "ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ")), 0, 80, 'utf-8'); ?>
                            </td>
                        </tr>                    
                    <?php endforeach; ?>                      
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="4">
                            <div class="pagination pagination-centered"></div>
                        </td>
                    </tr>
                </tfoot>
            </table> 

        </div>
    </div>

    <div class="tab-pane" id="prova">
        <div class="well" style="margin: 20px 0">            
            <div class="panel-group" id="accordion-provas">
                <?php
                if (count($provas) == 0) {
                    echo "Não existem registros para esta opção.";
                }

                foreach ($provas as $prova):
                    $class = "";
                    switch ($prova['BIMESTRE']) {
                        case 1:
                            $class = "panel-danger";
                            break;
                        case 2:
                            $class = "panel-warning";
                            break;
                        case 3:
                            $class = "panel-info";
                            break;
                        case 4:
                            $class = "panel-success";
                            break;
                        default:
                            $class = "panel-info";
                            break;
                    }
                    ?>

                    <div class="panel <?= $class ?>">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a style="text-decoration: none" href="#<?= $prova['CD_DISCIPLINA'] . $prova['CD_TIPO_NOTA'] . $prova['BIMESTRE'] ?>" data-parent="#accordion-provas" data-toggle="collapse">
                                    <i class="fa fa-book"></i> <?= $prova['DESC_TIPO_NOTA'] ?><i class="fa fa-angle-down pull-right"></i>
                                </a>
                            </div>
                        </div>

                        <div class="panel-body collapse" id="<?= $prova['CD_DISCIPLINA'] . $prova['CD_TIPO_NOTA'] . $prova['BIMESTRE'] ?>">
                            <?php if (!empty($prova['CONTEUDO'])): ?>
                                <?= $prova['CONTEUDO'] ?>
                            <?php else: ?>
                                <table class='table table-bordered table-hover table-striped tabela-conteudo-provas'>
                                    <thead>
                                        <tr>
                                            <th class="text-center">AULA</th>
                                            <th class="text-center">DATA</th>
                                            <th class="text-center">CONTEÚDO</th>
                                            <th class="text-center">ASSUNTO LIVRO</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($prova['CONTEUDOS'] as $conteudo): ?>
                                            <tr>
                                                <td class="text-center col-sm-2"><?= $conteudo['CD_CL_AULA'] ?></td>
                                                <td class="text-center col-sm-2"><?= date("d/m/Y", strtotime($conteudo['DT_AULA'])) ?></td>
                                                <td class="text-justify col-sm-4" style="padding: 5px"><?= $conteudo['CONTEUDO'] ?></td>
                                                <td class="text-justify col-sm-4" style="padding-right: 10px">
                                                    <ul>
                                                        <?php foreach ($conteudo["ASSUNTO_LIVRO"] as $row): ?>                                                                
                                                            <li><?= $row['DC_ASSUNTO'] ?></li>                                                                
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>                        
                <?php endforeach; ?>
            </div>            
        </div>
    </div>

    <div class="tab-pane" id="arquivo">
        <div class="well" style="margin: 20px 0">
            <table class="table table-hover table-striped table-bordered" data-filter="#filter" width="100%" id="tabela-arquivos">
                <thead>
                    <tr>
                        <th class="text-center">DATA</th>
                        <th class="text-center">PROFESSOR</th>
                        <th class="text-center">DESCRIÇÃO</th>
                        <th class="text-center">ARQUIVO</th>
                    </tr>
                </thead>
                <tbody>                    
                    <?php foreach ($arquivos as $arquivo) : ?>
                        <tr>                                
                            <td class="text-center"><?= date('d/m/Y', strtotime($arquivo['DATA'])); ?></td>
                            <td class="text-center"><?= $arquivo['NM_PROFESSOR']; ?></td>
                            <td class="text-justify"><?= $arquivo['DESCRICAO']; ?></td>                                
                            <td class="text-center"> 
                                <a class="btn btn-info" href="<?= SCL_RAIZ . 'application/upload/professor/' . $arquivo['CD_PROFESSOR'] . '/' . $arquivo['ANEXO'] ?>" > <i class="fa fa-download"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>   
                </tbody>
            </table> 
        </div>
    </div>
</div>

<script src="<?= SCL_JS ?>jquery.dataTables.min.js"></script> 
<script src="<?= SCL_JS ?>jquery.dataTables.bootstrap.js"></script>
<script>
    $('#TableDisc').dataTable({
        "sPaginationType": "full_numbers",
        "aaSorting": [[0, "desc"]]
    });

    $('.tabela-conteudo-provas').dataTable({
        bFilter: false,
        "sPaginationType": "full_numbers"
    });

    $('#tabela-arquivos').dataTable({
        bFilter: false,
        "sPaginationType": "full_numbers",
        "aaSorting": []
    });
</script>
<?php exit(); ?>