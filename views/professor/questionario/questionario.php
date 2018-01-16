<?php $this->load->view('layout/header'); ?>
<script type="text/javascript">
    function getValor(valor, id) {
        idstatus = $(id).attr("id");
        $("#status" + idstatus + "").html("<option value='0'>Carregando... </option>");
        setTimeout(function() {
            $("#status" + idstatus + "").load("<?= SCL_RAIZ ?>professor/infantil/questionario_resposta", {
                bimestre: $("input[name=bimestre]").val(),
                aluno: $("input[name=aluno]").val(),
                questionario: $("input[name=questionario]").val(),
                resposta: valor,
            })
        }, 500)
    }
    ;
</script>

<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="well">
                <div class="media">
                    <a class="pull-left">
                        <img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $aluno?>" class="media-object">
                    </a>
                    <div class="media-body">
                        <h5 class="media-heading">
                            <span class="welcome">Aluno(a)</span><br/>
                            <span><?= $nome?></span>
                        </h5>
                    </div>
                </div>

            </div>
            <div class="widget-body">
                <?
                $div = array();
                
                foreach ($listar as $row) {
                    $div[] = $row['CD_DIVISAO'] . ' - ' . $row['DC_DIVISAO'];
                }
                $divisao = array_keys(array_flip($div));
                ?>
                <form method="post" enctype="multipart/form-data" id="frmquestionario">
                    <input type="hidden" id="questionario" name="questionario" value="<?= $questionario ?>">
                    <input type="hidden" id="aluno" name="aluno" value="<?= $aluno ?>">
                    <input type="hidden" id="bimestre" name="bimestre" value="<?= $bimestre ?>">

                    <div class="row">
                        <div class="col-md-2">
                            <ul class="nav nav-pills nav-stacked">
<? foreach ($divisao as $d) { ?>
                                    <li class="list-success">
                                        <a href="#<?= str_replace(' ', '', $d) ?>" data-toggle="pill" style="font-size:11px"><?= $d ?></a>
                                    </li>
<? } ?>
                            </ul>
                        </div>
                        <div class="col-md-10">
                            <div class="tab-content">
<? foreach ($divisao as $d) { ?>
                                    <div class="tab-pane" id="<?= str_replace(' ', '', $d) ?>">
                                        <div class="">
                                            <h4><?= $d ?></h4>
                                            <table class="table table-hover " style="background:#FFF">
                                                <thead>
                                                    <tr>
                                                        <td>Pergunta</td>
                                                        <td width="15%">4º Bimestre</td>
                                                        <td width="5%">#</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?
                                                    foreach ($listar as $r) {
                                                        
                                                        if (str_replace(' ', '', $d) == str_replace(' ', '', $r['CD_DIVISAO'] . '-' . $r['DC_DIVISAO'])) {
                                                            ?>
                                                            <tr>
                                                                <td style="font-size:10px"><?= $r['DC_PERGUNTA'] ?></td>
                                                                <td style="font-size:10px">
                                                                    <select class="form-control" onchange="getValor(this.value, this)" name="<?= $r['CD_PERGUNTA'] ?>" id="<?= $r['CD_PERGUNTA'] ?>" >
                                                                        <option></option>
                                                                        <? foreach ($resposta as $res) { ?>
                                                                        <option <?=(($res['CD_RESPOSTA_PADRAO'] == $r['CD_RESPOSTA'])? 'selected="selected"': '')?>  value="<?= $r['CD_PERGUNTA'] . ':' . $res['CD_RESPOSTA_PADRAO'] ?>"><?= $res['DC_RESPOSTA_PADRAO'] ?></option>
                                                                        <? } ?>
                                                                    </select>
                                                                </td>
                                                                <td width="5%"><div id="status<?= $r['CD_PERGUNTA'] ?>"></div></td>
                                                            </tr>
                                                            <?
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <? } ?>
                            </div>
                        </div>
                    </div>



                </form>
            </div>

            <div class="modal-footer">
                <a href="<?= SCL_RAIZ ?>impressao/questionario?token=<?= base64_encode($aluno)?>&qs=<?=$questionario?>" class="btn btn-info" target="_blank"><i class="fa fa-print"></i> Imprimir</a>
                <a class="btn btn-danger" href="<?=SCL_RAIZ?>professor/infantil/listar_turma?turma=<?=$turma?>"><i class="fa fa-rotate-left"></i> Fechar</a>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('layout/footer'); ?>