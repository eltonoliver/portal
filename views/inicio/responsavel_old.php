<?php $this->load->view('layout/header'); ?>

<link rel="stylesheet" type="text/css" media="screen" href="<?= SCL_CSS ?>bootstrap-datapicker.css">
<script type="text/javascript" src="<?= SCL_JS ?>bootstrap-datepicker.min.js"></script> 
<script type="text/javascript">
    function enviar() {
        jQuery(document).ready(function() {
            var dados = jQuery("#frmpedido").serialize();
            jQuery.ajax({
                type: "POST",
                url: "<?= SCL_RAIZ ?>financeiro/credito/pedido",
                data: dados,
                success: function(data)
                {
                    $('#libera').modal('hide');
                    $('#frmCredito').modal('hide');
                    $('#pedido').modal('show');
                    $("#res_pedido").html(data);
                }
            });
            return false;
        });
    }
    ;
</script>

<script type="text/javascript">
    function fechar(id) {
        jQuery(document).ready(function() {
            $('#' + id).modal('hide');
        });
    }
    ;

    function atualizar() {
        jQuery(document).ready(function() {
            var dados = $("form").serialize();
            jQuery.ajax({
                type: "POST",
                url: "<?= SCL_RAIZ ?>financeiro/credito/grdpedido",
                data: dados,
                success: function(data) {
                    $("#grdpedido").html(data);
                }
            });
            return false;
        });
    }
    ;

    function mostrar(produto) {
        var display  = document.getElementById('produto' + produto).style.display;
        if (display == "none") {
            document.getElementById('produto' + produto).style.display = '';
            document.getElementById('txt' + produto).style.display = 'none';
            document.getElementById('produto' + produto).removeAttribute("disabled");
            atualizar()
        } else {
            document.getElementById('produto' + produto).style.display = 'none';
            document.getElementById('txt' + produto).style.display = '';
            document.getElementById('produto' + produto).setAttribute("disabled", "disabled");
            atualizar();
        }
    }
    ;
</script>


<?php

function cifra($campo, $valor) {
    if ($campo == 0) {
        switch ($valor) {
            case 'AT': $tipo = '<label>Aceitação Total</label>';
                break;
            case 'AP': $tipo = '<label>Aceitação Parcial</label>';
                break;
            case 'RP': $tipo = '<label>Repetiu</label>';
                break;
            case 'RJ': $tipo = '<label>Rejeição</label>';
                break;
            default: $tipo = '<dd style="font-size:10px">Não Informado</dd>';
                break;
        }
        return($tipo);
    } elseif ($campo == 1) {
        switch ($valor) {
            case 'TQ': $tipo = 'Tranquilo';
                break;
            case 'AG': $tipo = 'Agitado';
                break;
            case 'ND': $tipo = 'Não Dormiu';
                break;
            default: $tipo = '<dd style="font-size:10px">Não Informado</dd>';
                break;
        }
        return($tipo);
    } elseif ($campo == 2) {
        switch ($valor) {
            case 'NO': $tipo = 'Normal';
                break;
            case 'NE': $tipo = 'Não evacuou';
                break;
            default: $tipo = '<dd style="font-size:10px">Não Informado</dd>';
                break;
        }
        return($tipo);
    }
}
?>

<div id="content">
    <div class="alert alert-success"> <em>Sua senha de acesso ao Cólegio é: </em><strong><?= $this->session->userdata('SCL_SSS_USU_PASS') ?></strong> Essa senha é para acesso as catracas e cancelas do Colégio.</div>
    <?php echo get_msg('msg'); ?>
    
    
    <? if($rematricula[0]['NM_ALUNO'] != '' ){ ?>
    
<!--    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <div class="input-group col-sm-8">
                            RENOVAÇÃO DE MATRÍCULA
                        </div>
                    </h4>
                </div>
                <div class="panel-body" id="painel">
                    <ul class="list-group">
                        <? foreach($rematricula as $r){ ?>
                        <li class="list-group-item">
                            <? if($r['ACEITO'] == NULL){ 
                                echo '<a href="'.base_url('acompanhamento/rematricula/'.$r['CD_ALUNO'].'').'" class="btn btn-danger" data-toggle="frmCredito">Renovar</a>';
                             }else{ 
                                echo '<span class="badge badge-success">Solicitação de Renovação Realizada!</span>';
                                echo '<a href="'.base_url('acompanhamento/impSolicitacaoRematricula/'.$r['CD_ALUNO'].'').'" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</a>';
                             } ?>
                            <a><?=$r['NM_ALUNO']?></a>
                        </li>
                        <? } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>-->
    <hr />
    
    <? } ?>
    
    <div class="row">

        <?php foreach ($aluno as $r) { ?>
            <div class="col-md-4">                
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h6 class="panel-title"><span style="font-size:14px"><i class="fa fa-user"></i>  <?= $r['NM_ALUNO'] ?></span></h6>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-3 thumbnail avatar center">
                            <img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $r['CD_ALUNO'] ?>" class="media-object">
                        </div>
                        <div class="col-xs-9">
                            <ul class="nav nav-pills nav-stacked">
                                <li class="list-warning">
                                    Crédito (R$):<br />
                                    <strong style="font-size:20px">
                                        <?= number_format(str_replace(',', '.', $r['VL_SALDO']), 2, ',', '.') ?>
                                    </strong>
                                </li>

                                <li class="list-info">
                                    Limite Diário: <br /> 
                                    <strong style="font-size:20px" class="">
                                        <div class="bootstrap-filestyle input-group">
                                            <?= number_format($r['VL_LIMITE'], 2, ',', '.') ?>
                                            <a href="<?= SCL_RAIZ ?>financeiro/credito/limite?token=<?= base64_encode($r['CD_ALUNO']) ?>" class="btn btn-success btn-xs" data-toggle="frmCredito" data-target="#frmCredito">
                                                <i class="fa fa-edit"></i>  Alterar
                                            </a>
                                        </div>
                                    </strong>
                                </li>

                                <li class="list-primary">
                                    Saldo Almoço(s): <br />
                                    <strong style="font-size:20px" class="">
                                        <div class="bootstrap-filestyle input-group">
                                            <?php
                                            if ($r['FLG_ALMOCO_LIBERADO'] <> 1) {
                                                echo $r['SALDO_ALMOCO'];
                                            } else {
                                                echo "ISENTO";
                                            }
                                            ?>
                                        </div>
                                    </strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <a href="<?= SCL_RAIZ ?>financeiro/credito/comprar?token=<?= base64_encode($r['CD_ALUNO']) ?>" class="btn btn-success" data-toggle="frmCredito" data-target="#frmCredito"><i class="fa fa-credit-card"></i> Crédito </a>
                        <a href="<?= SCL_RAIZ ?>financeiro/credito/extrato?token=<?= base64_encode($r['CD_ALUNO']) ?>&limite=<?= base64_encode($r['VL_LIMITE']) ?>&al=<?= base64_encode($r['SALDO_ALMOCO']) ?>" class="btn btn-danger" ><i class="fa fa-list"></i> Extrato </a>
                        <?php if ($r['FLG_ALMOCO_LIBERADO'] <> 1) { ?>
            <!--                        <a href="<?= SCL_RAIZ ?>financeiro/credito/historico?token=<?= base64_encode($r['CD_ALUNO']) ?>" class="btn btn-info" target="_blanc"><i class="fa fa-list"></i> Histórico </a>-->
                            <a href="<?= SCL_RAIZ ?>financeiro/credito/compra_almoco_credito?token=<?= base64_encode($r['CD_ALUNO']) ?>&saldo=<?= base64_encode($r['VL_SALDO']) ?>" class="btn btn-warning" data-toggle="frmCredito" data-target="#frmCredito"><i class="fa fa-credit-card"></i> Almoço </a>
                        <?php } ?>
                        <a style="display:none" href="<?= SCL_RAIZ ?>financeiro/credito/cardapio?token=<?= base64_encode($r['CD_ALUNO']) ?>&js=<?= base64_encode($r['VL_LIMITE']) ?>" class="btn btn-info" data-toggle="frmCredito" data-target="#frmCredito"><i class="fa fa-cutlery"></i> Comprar </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>



    <div class="row">

        <?php
        foreach ($aluno as $row) {
            if ($row['CD_CURSO'] == 1) {
                $paramento = array(
                    'operacao' => 'LR',
                    'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                    'cd_aluno' => $row['CD_ALUNO'],
                    'dia' => date('d/m/Y'),
                );
                $diario = $this->infantil->sp_infantil($paramento);
                ?>
                <div class="col-sm-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <div class="media col-sm-2">
                                    <img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $row['CD_ALUNO'] ?>" class="media-object">
                                </div>
                                <div class="input-group col-sm-8"> 
                                    Acompanhamento Diário : <br/><?= $row['NM_ALUNO'] ?><br>
                                </div>

                            </h4>
                        </div>
                        <div class="panel-body" id="painel">
                            <ul class="nav nav-pills nav-stacked col-sm-6">
                                <li class="list-info"><a><i class="fa fa-coffee fa-2x pull-left"></i> COLAÇÃO<br><?= cifra(0, $diario[0]['COLACAO']); ?></a></li>
                                <li class="list-primary"><a><i class="fa fa-cutlery fa-2x pull-left"></i> ALMOÇO<br>  <?= cifra(0, $diario[0]['ALMOCO']); ?> </a></li>
                                <li class="list-warning"><a><i class="fa fa-flag fa-2x pull-left"></i> LANCHE<br> <?= cifra(0, $diario[0]['LANCHE']); ?> </a></li>
                            </ul>
                            <ul class="nav nav-pills nav-stacked col-sm-6">
                                <li class="list-danger"><a><i class="fa fa-cloud fa-2x pull-left"></i> SONO / DESCANSO<br> <?= cifra(1, $diario[0]['SONO']) ?> </a></li>
                                <li class="list-default"><a><i class="fa fa-male fa-2x pull-left"></i> EVACUAÇÃO<br> <?= cifra(2, $diario[0]['EVACUACAO']) ?> </a></li>
                                <li class="list-default"><a><i class="fa fa-clock-o fa-2x pull-left"></i> <strong><?= date('d/m/Y') ?></strong> <br> </a></li>
                            </ul>
                        </div>
                        <div class="panel-footer">
                            <form name="frmdata" id="frmdata">
                                <div class="input-group col-sm-4 pull-right"> 
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>   
                                    <input name="dtacom" type="text" class="form-control" id="dtacom" value="<?= date('d/m/Y'); ?>"> 
                                    <input name="aluno" type="hidden" class="form-control" id="aluno" value="<?= $row['CD_ALUNO'] ?>"> 
                                    <span class="input-group-addon btn btn-info" id="btnfrmdata">
                                        <i class="fa fa-caret-right"></i>
                                    </span>                                  
                                </div>
                                Selecione a data do acompanhamento:
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <div class="col-sm-6">
            <div class="panel-group">

                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#accordion4" data-parent="#accordion-4" data-toggle="collapse">
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
                            <a href="#accordion1" data-parent="#accordion-3" data-toggle="collapse">
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
                            <a href="#accordion2" data-parent="#accordion-3" data-toggle="collapse">
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
                            <a href="#accordion3" data-parent="#accordion-3" data-toggle="collapse">
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

            <div class="panel panel-success">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#accordion5" data-parent="#accordion-5" data-toggle="collapse">
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
                        <a href="#accordion6" data-parent="#accordion-6" data-toggle="collapse">
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
                        <a href="#accordion7" data-parent="#accordion-7" data-toggle="collapse">
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
        
        
        <div class="col-sm-6">
            <div class="panel-group">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#accordion3-1" data-parent="#accordion-3" data-toggle="collapse">
                                Calendário Escolar <?=date('Y')?> <i class="fa fa-angle-down pull-right"></i>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse in" id="accordion3-1">
                        <div class="panel-body"> 
                            <div id="taskId" class="task-list">
                                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview" name="gridview3">
                                    <thead>
                                        <tr>
                                            <th style="display: none"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td><a href="http://www.seculomanaus.com.br/portal/application/upload/noticia/Calend%C3%A1rio_Escolar_2016.pdf" target="_blank">Calendário Escolar <?=date('Y')?></a></td></tr>
                                        
                                    </tbody>
                                </table>
                            </div>  
                        </div> 
                    </div>
                </div>
            </div>
        </div> 
        
        
        <div class="col-sm-6">
            <div class="panel-group">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#accordion3-1" data-parent="#accordion-3" data-toggle="collapse">
                                Lista de Materias e Manuais <i class="fa fa-angle-down pull-right"></i>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse in" id="accordion3-1">
                        <div class="panel-body"> 
                            <div id="taskId" class="task-list">
                                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview" name="gridview2">
                                    <caption>Lista de Materiais</caption>
                                    <thead>
                                        <tr>
                                            <th style="display: none"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/01_-_Maternal_20163.pdf" target="_blank">Maternal - Creche - 02 Anos</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/02_-_Infantil_I_20163.pdf" target="_blank">Infantil I - Creche - 03 Anos</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/03_-_Infantil_II_20162.pdf" target="_blank">Infantil II - Creche - 04 Anos</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/04_-_Infantil_III_20164.pdf" target="_blank">Infantil III - Creche - 05 Anos</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/05_-_1_ANO__20162.pdf" target="_blank">1º Ano Ensino Fundamental I</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/06_-_2_ANO__20162.pdf" target="_blank">2º Ano Ensino Fundamental I</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/07_-_3_ANO__20163.pdf" target="_blank">3º Ano Ensino Fundamental I</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/08_-_4_ANO__20162.pdf" target="_blank">4º Ano Ensino Fundamental I</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/09_-_5_ANO__20162.pdf" target="_blank">5º Ano Ensino Fundamental I</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/10_-_6_ANO__20162.pdf" target="_blank">6º Ano Ensino Fundamental II</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/11_-_7_ANO__20162.pdf" target="_blank">7º Ano Ensino Fundamental II</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/12_-_8_ANO__20164.pdf" target="_blank">8º Ano Ensino Fundamental II</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/13_-_9_ANO__20163.pdf" target="_blank">9º Ano Ensino Fundamental II</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/14_-_1_ANO_MEDIO__20163.pdf" target="_blank">1º Ano Ensino Médio</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/15_-_2_ANO_MEDIO__20163.pdf" target="_blank">2º Ano Ensino Médio</a></td></tr>
                                        <tr><td><a href="http://seculomanaus.com.br/portal/application/upload/noticia/16_-_3_ANO_MEDIO__20164.pdf" target="_blank">3º Ano Ensino Médio</a></td></tr>
                                    </tbody>
                                </table>

<!--                                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview" name="gridview">
                                    <caption>Manuais</caption>
                                    <thead>
                                        <tr>
                                            <th style="display: none"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><td><a href="<?= SCL_UPLOAD ?>/informativo/manual_educacao_infantil_revisado.pdf" target="_blank">Manual do Aluno - Infantil</a></td></tr>
                                        <tr><td><a href="<?= SCL_UPLOAD ?>/informativo/manual_do_aluno_fund_medio.pdf" target="_blank">Manual do aluno Ensino Fundamental e Ensino Médio</a></td></tr>
                                        <tr><td><a href="<?= SCL_UPLOAD ?>/informativo/carta_de_renovacao_de_matricula_2015.doc" target="_blank">Carta de Renovação de Matrícula</a></td></tr>
                                    </tbody>
                                </table>-->
                            </div>  
                        </div> 
                    </div>
                </div>
            </div>
        </div> 
    </div>

    <script type="text/javascript">
        $(function() {
            $('#dtacom').datepicker({
                language: 'pt-BR',
                format: 'dd/mm/yyyy',
            })
        });

        $(document).ready(function() {
            $("#btnfrmdata").click(function() {
                $("#painel").html('<div class="col-sm-12 well center">Carregando dados ...</div>');
                $.post("<?= SCL_RAIZ ?>inicio/tabela_infantil", {
                    aluno: $("input[name=aluno]").val(),
                    dia: $("input[name=dtacom]").val(),
                },
                        function(valor) {
                            $("#painel").html(valor);
                        })
            })
        });


        $('#gridview').dataTable({
            "sPaginationType": "full_numbers",
            "aaSorting": [[1, 'desc']],
            "oLanguage": {
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "sLengthMenu": "Mostrar por página _MENU_ ",
                "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
                "sInfoEmpty": "Registro não encontrado",
                "sZeroRecords": "Não há registro",
            }
        });
        $('#gridview_wrapper .dataTables_filter input').attr('placeholder', 'Procurar...');

        $('#gridview2').dataTable({
            "sPaginationType": "full_numbers",
            "oLanguage": {
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "sLengthMenu": "Mostrar por página _MENU_ ",
                "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
                "sInfoEmpty": "Registro não encontrado",
                "sZeroRecords": "Não há registro",
            },
            "aaSorting": [[1, "desc"]],
        });
        $('#gridview2_wrapper .dataTables_filter input').attr('placeholder', 'Procurar...');

        $('#gridview3').dataTable({
            "sPaginationType": "full_numbers",
            "oLanguage": {
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "sLengthMenu": "Mostrar por página _MENU_ ",
                "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
                "sInfoEmpty": "Registro não encontrado",
                "sZeroRecords": "Não há registro",
            },
            "aaSorting": [[1, "desc"]],
        });
        $('#gridview3_wrapper .dataTables_filter input').attr('placeholder', 'Procurar...');


        $('[data-toggle="frmCredito"]').on('click',
                function(e) {
                    $('#frmCredito').remove();
                    e.preventDefault();
                    var $this = $(this)
                            , $remote = $this.data('remote') || $this.attr('href')
                            , $modal = $('<div class="modal fade" id="frmCredito"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
                    $('body').append($modal);
                    $modal.modal({backdrop: 'static', keyboard: false});
                    $modal.load($remote);
                }
        );
    </script>
<?php $this->load->view('layout/footer'); ?>
