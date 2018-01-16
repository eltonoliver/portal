<?php $this->load->view('layout/header'); ?>

<div id="content">
    <div class="row" style="margin-bottom: 20px">
        <div class="col-sm-4">
            <div class="page-header media">
                <div class=" media">
                    <a class="pull-left">
                        <img src="<?= "https://www.seculomanaus.com.br/academico/usuarios/foto?codigo=" . $aluno['CD_ALUNO'] ?>" class="media-object">
                    </a>
                    <div class="media-body">
                        <h5 class="media-heading">
                            <div>
                                <span class="welcome"><?= $aluno['NM_ALUNO'] ?></span>
                            </div>

                            <div>
                                <span>Matrícula: <?= $aluno['CD_ALUNO'] ?></span>    
                            </div>

                            <div>
                                <span>Turma: <?= $aluno['TURMA_ATUAL']; ?></span>
                            </div>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-group panel-group-acompanhamento">
        <div class="panel panel-info">                    
            <a class="ajax" href="#agenda" data-url="<?= site_url("acompanhamento/agenda") . "?token=" . $token ?>" data-parent=".panel-group-acompanhamento" data-toggle="collapse">
                <div class="panel-heading">                    
                    <h4 class="panel-title">
                        <i class="fa fa-calendar"></i> Agenda <i class="fa fa-angle-down pull-right"></i>
                    </h4>                    
                </div>                
            </a>

            <div class="panel-collapse collapse" id="agenda">
                <div style="display: none" id="loading" class="text-center">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </div>

                <div class="panel-body">
                </div>
            </div>
        </div>

        <div class="panel panel-primary">                    
            <a class="ajax" href="#tempos" data-url="<?= site_url("acompanhamento/tempos") . "?token=" . $token ?>" data-parent=".panel-group-acompanhamento" data-toggle="collapse">
                <div class="panel-heading">                    
                    <h4 class="panel-title">
                        <i class="fa fa-clock-o "></i> Tempos de Aula <i class="fa fa-angle-down pull-right"></i>
                    </h4>                    
                </div>                
            </a>

            <div class="panel-collapse collapse" id="tempos">
                <div style="display: none" id="loading" class="text-center">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </div>

                <div class="panel-body">
                </div>
            </div>
        </div>

        <?php if ($aluno['CD_CURSO'] != 1) { ?>
            <div class="panel panel-success">                    
                <a class="ajax" href="#demonstrativo" data-url="<?= site_url("acompanhamento/demonstrativo") . "?token=" . $token ?>" data-parent=".panel-group-acompanhamento" data-toggle="collapse">
                    <div class="panel-heading">                        
                        <h4 class="panel-title">
                            <i class="fa fa-bar-chart "></i> Demonstrativo de Notas <i class="fa fa-angle-down pull-right"></i>
                        </h4>                        
                    </div>                
                </a>

                <div class="panel-collapse collapse" id="demonstrativo">
                    <div style="display: none" id="loading" class="text-center">
                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                        <span class="sr-only">Loading...</span>
                    </div>

                    <div class="panel-body">
                    </div>
                </div>
            </div>            
        <?php } else { ?>
            <div class="panel panel-success">                    
                <a href="<?= site_url("impressao/questionario") . "?token=" . $token ?>" data-parent=".panel-group-acompanhamento" target="_blank">
                    <div class="panel-heading">                        
                        <h4 class="panel-title">
                            <i class="fa fa-edit "></i> Acompanhamento Infantil
                        </h4>                        
                    </div>                
                </a>                
            </div>            
        <?php } ?>

        <div class="panel panel-warning">                    
            <a class="ajax" href="#disciplina" data-url="<?= site_url("acompanhamento/disciplina") . "?token=" . $token ?>" data-parent=".panel-group-acompanhamento" data-toggle="collapse">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <i class="fa fa-book"></i> Disciplinas<i class="fa fa-angle-down pull-right"></i>
                    </h4>
                </div>                
            </a>

            <div class="panel-collapse collapse" id="disciplina">
                <div style="display: none" id="loading" class="text-center">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="panel-body">
                </div>
            </div>
        </div>

        <div class="panel panel-danger">                    
            <a class="ajax" href="#registros-pedagogicos" data-url="<?= site_url("acompanhamento/registrosPedagogicos") . "?token=" . $token ?>" data-parent=".panel-group-acompanhamento" data-toggle="collapse">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <i class="fa fa-exclamation-circle"></i> Registros Pedagógicos<i class="fa fa-angle-down pull-right"></i>
                    </h4>
                </div>                
            </a>

            <div class="panel-collapse collapse" id="registros-pedagogicos">
                <div style="display: none" id="loading" class="text-center">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </div>

                <div class="panel-body">
                </div>
            </div>
        </div>

        <div class="panel panel-info">                    
            <a class="ajax" href="#registros-diarios" data-url="<?= site_url("acompanhamento/registrosDiarios") . "?token=" . $token ?>" data-parent=".panel-group-acompanhamento" data-toggle="collapse">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <i class="fa fa-exclamation-triangle"></i> Registros Diários<i class="fa fa-angle-down pull-right"></i>
                    </h4>
                </div>                
            </a>

            <div class="panel-collapse collapse" id="registros-diarios">
                <div style="display: none" id="loading" class="text-center">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </div>

                <div class="panel-body">
                </div>
            </div>
        </div>

        <?php if ($aluno['CD_CURSO'] == 3 || $aluno['CD_CURSO'] == 33) { ?>
            <div class="panel panel-primary">                    
                <a href="#gabarito" data-parent=".panel-group-acompanhamento" data-toggle="collapse">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="fa fa-check-square"></i> Gabaritos Provas<i class="fa fa-angle-down pull-right"></i>
                        </h4>
                    </div>                
                </a>

                <div class="panel-collapse collapse" id="gabarito">
                    <div style="display: none" id="loading" class="text-center">
                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                        <span class="sr-only">Loading...</span>
                    </div>

                    <div class="panel-body">
                        <?=
                        $this->load->view("acompanhamento/gabarito", array(
                            "aluno" => $aluno,
                            "token" => $token,
                                ), true);
                        ?>
                    </div>
                </div>
            </div>

            <div class="panel panel-primary">                    
                <a href="#gabarito-online" data-parent=".panel-group-acompanhamento" data-toggle="collapse">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="fa fa-check-square"></i> Gabaritos Provas Online<i class="fa fa-angle-down pull-right"></i>
                        </h4>
                    </div>                
                </a>

                <div class="panel-collapse collapse" id="gabarito-online">
                    <div style="display: none" id="loading" class="text-center">
                        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                        <span class="sr-only">Loading...</span>
                    </div>

                    <div class="panel-body">
                        <?=
                        $this->load->view("acompanhamento/gabarito-prova-online", array(
                            "aluno" => $aluno,
                            "token" => $token
                                ), true);
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script type="text/javascript">
    $(".ajax").click(function (event) {
        //evitar a barra de rolagem
        event.preventDefault();

        var url = $(this).attr("data-url");
        var container = $(this).attr("href");
        var conteudoContainer = $(container).find(".panel-body").text().trim();

        if (conteudoContainer === "") {
            $(container).find("#loading").show();

            $.ajax({
                url: url,
                method: "post",
                success: function (data, status) {
                    $(container).find("#loading").hide();
                    $(container).find(".panel-body").html(data);
                }
            });
        }
    });
</script>
<?php $this->load->view('layout/footer'); ?>