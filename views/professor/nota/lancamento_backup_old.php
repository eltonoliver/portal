<?php $this->load->view('layout/header'); ?>

<script type="text/javascript">

    /* Máscaras ER */
    function mascara(o, f) {
        v_obj = o;
        v_fun = f;
        setTimeout("execmascara()", 1);
    }
    function execmascara() {
        v_obj.value = v_fun(v_obj.value)
    }
    function mvalor(v) {
        v = v.replace(/\D/g, "");//Remove tudo o que não é dígito
        v = v.replace(/(\d)(\d{1})$/, "$1.$2");//coloca a virgula antes dos 2 últimos dígitos
        return v;
    }


    function calculaNota(campo) {
        var obj = $('#cObj_' + campo + '').val();
        var disc = $('#cDisc_' + campo + '').val();

        var tNota = parseFloat(disc) + parseFloat(obj);
        if (tNota > 10) {
            alert('Valor da nota inválida');

            document.getElementById('cDisc_' + campo + '').value = "";
            document.getElementById('nota_' + campo + '').value = "";
            document.frmEnviaDados.cDisc_ + campo.focus();
        } else {
            document.getElementById('nota_' + campo + '').value = parseFloat(tNota.toFixed(2));
        }
    }

</script>

<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msg');

            $lista_navegadores = array('MSIE', 'Firefox', 'Chrome', 'Safari');
            $navegador_usado = $_SERVER['HTTP_USER_AGENT'];
            foreach ($lista_navegadores as $valor_verificar) {
                if (strrpos($navegador_usado, $valor_verificar)) {
                    $navegador = $valor_verificar;
                }
            }
            if ($navegador == 'Fiprefox') {
                echo "<h2 class='alert alert-danger'>Por favor utilize o navegador Firefox, em caso de dúviida entre em contato com o suporte.</h2>";
            } else {
                ?>

                <div class="panel panel-warning">                    

                    <?php
                    $disc = array(86,87,88, 6, 29, 25, 7, 89, 104, 117, 118, 119, 132, 150, 230, 268, 360, 362, 84, 90, 22, 58, 96, 318, 94, 37, 5, 85, 274, 508, 504, 506, 502);
                    $sim = in_array($disciplina, $disc);

                    if (($curso == 2) or ( $sim == true) or ( $numero_nota == 31) or ( $numero_nota == 26)) {
                        ?>
                        <!--LANCAMENTO DE NOTAS ENSINO FUNDAMENTAL I E AS DISCIPLINA DE INGLES-->

                        <form action="<?= SCL_RAIZ ?>professor/nota/lancar_nota" method="post" id="frmvalidar" name="frmvalidar" enctype="multipart/form-data">
                            <input name="disciplina" type="hidden" id="disciplina" value="<?= $disciplina ?>" />
                            <input name="turma" type="hidden" id="turma" value="<?= $turma ?>" />
                            <input name="tipo" type="hidden" id="tipo" value="<?= $numero_nota ?>" />
                            <input name="num_nota" type="hidden" id="num_nota" value="<?= $numero_nota ?>" />
                            <input name="curso" type="hidden" id="curso" value="<?= $curso ?>" />
                            <input name="sim" type="hidden" id="curso" value="<?= $sim ?>" />
                            <div class="panel">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-lg-3">Turma: <label><?= $this->input->post('turma') ?></label></div>
                                                <div class="col-lg-3">Disciplina: <label><?= $this->input->post('txtdisciplina') ?></label></div>
                                                <div class="col-lg-6">
                                                    <select name="numero_nota" id="numero_nota" style="width: 80%" disabled="disabled" >
                                                        <?php
                                                        if (count($listar_tipo_nota) > 0) {
                                                            foreach ($listar_tipo_nota as $l) {
                                                                ?> 
                                                                <option value="<?= $l['NUM_NOTA'] ?>" <?php
                                                                if ($numero_nota == $l['NUM_NOTA']) {
                                                                    echo 'selected="selected"';
                                                                }
                                                                ?>><?= $l['DC_TIPO_NOTA'] ?> (<?= $l['BIMESTRE'] ?> º Bimestre)</option>
                                                                        <?php
                                                                    }
                                                                } # } 
                                                                ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <table width="100%" class="table table-bordered table-hover" id="gridview" aria-describedby="sample-table-2_info">
                                <thead>
                                    <tr class="panel-heading">                            
                                        <th class="sorting">Matrícula</th>
                                        <th class="sorting">Aluno</th>
                                        <th class="sorting_disabled text-center" style="width:15%" aria-label="">Nota</th>
                                        <th class="sorting_disabled text-center" style="width:15%" aria-label="">Comprovante</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count($listar_aluno) > 0) {
                                        foreach ($listar_aluno as $row) {
                                            
                                            
                                            ?>
                                            <tr>
                                                <td valign="middle">
                                            <?= $row->CD_ALUNO ?></td>
                                                <td valign="middle"><?= $row->NM_ALUNO ?><?= $row->CD_PROVA ?></td>
                                                <td align="center">
                                                    <?php
                                                    $sel = '';
                                                    if ($_POST['nota_' . $row->CD_ALU_DISC])
                                                        $valor = $_POST['nota_' . $row->CD_ALU_DISC];
                                                    elseif ($row->NOTA > 0) {
                                                        $valor = $row->NOTA;
                                                        echo $valor;
                                                    } elseif ($row->NOTA == '0') {
                                                        $valor = $row->NOTA;
                                                        echo $valor;
                                                    } else {
                                                        $valor = '';

                                                        echo '<input name="nota_' . $row->CD_ALU_DISC . '" placeholder="00.0" type="number" id="nota_' . $row->CD_ALU_DISC . '" place size="3" max="10" min="0.1" step=".1" onkeydown="mascara( this, mvalor );" />';
                                                    }
                                                    ?>
                                                    <input name="CD_ALU_DISC" type="hidden" value="<?= $row->CD_ALU_DISC ?>" >
                                                </td>
                                                <td>
                                                    <a class="btn btn-success btn-small" href="#upload-<?= $row->CD_ALU_DISC ?>" data-toggle="modal" tabindex="-1">
                                                        <i class="fa fa-file-o"></i>
                                                        Adicionar Arquivo
                                                    </a>

                                                    <div id="upload-<?= $row->CD_ALU_DISC ?>"                                                         
                                                         class="modal fade" 
                                                         tabindex="-1" 
                                                         data-remote="<?= site_url("professor/nota/add_arquivo") . "?cd_alu_disc=" . $row->CD_ALU_DISC . "&num_nota=" . $numero_nota ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <?= modal_load ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>  
                            <input name="aluno_<?= $row->CD_ALU_DISC ?>" type="hidden" value="<?= $row->CD_ALU_DISC ?>" >
                        </form> 
                    <?php } else { ?>
                        <!--lancamento de notas ENSINO FUNDAMENTAL II E MEDIO -->

                        <form action="<?= SCL_RAIZ ?>professor/nota/lancar_nota" method="post" id="frmvalidar" name="frmvalidar" enctype="multipart/form-data">
                            <input name="disciplina" type="hidden" id="disciplina" value="<?= $disciplina ?>" />
                            <input name="turma" type="hidden" id="turma" value="<?= $turma ?>" />
                            <input name="tipo" type="hidden" id="tipo" value="<?= $numero_nota ?>" />
                            <input name="curso" type="hidden" id="curso" value="<?= $curso ?>" />
                            <input name="estrutura" type="hidden" id="estrutura" value="<?= $listar_aluno[5]->CD_ESTRUTURA ?>" />
        <!--                            <input name="cd_prova" type="hidden" id="cd_prova" value="<?= $notas_obj[0]->CD_PROVA ?>" />-->
                            <input type="hidden" name="num_nota" value="<?= $num_nota ?>"/>
                            <div class="panel">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-lg-3">Turma: <label><?= $this->input->post('turma') ?></label></div>
                                                <div class="col-lg-3">Disciplina: <label><?= $this->input->post('txtdisciplina') ?></label></div>
                                                <div class="col-lg-6">
                                                    <select name="numero_nota" id="numero_nota" style="width: 80%" disabled="disabled" >
                                                        <?php
                                                        $codigoTipoNota = 0;
                                                        if (count($listar_tipo_nota) > 0) {
                                                            foreach ($listar_tipo_nota as $l) {
                                                                ?> 
                                                                <option value="<?= $l['NUM_NOTA'] ?>" <?php
                                                                if ($numero_nota == $l['NUM_NOTA']) {
                                                                    $codigoTipoNota = $l['CD_TIPO_NOTA'];
                                                                    echo 'selected="selected"';
                                                                }
                                                                ?>><?= $l['DC_TIPO_NOTA'] ?> (<?= $l['BIMESTRE'] ?> º Bimestre)</option>
                                                                        <?php
                                                                    }
                                                                } # } 
                                                                ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <table width="100%" class="table table-bordered table-hover" id="gridview" aria-describedby="sample-table-2_info">
                                <thead>
                                    <tr class="panel-heading">                            
                                        <th class="sorting">Matrícula</th>
                                        <th class="sorting">Aluno</th>
                                        <th class="sorting_disabled text-center" style="width:10%" aria-label="">Nota Objetiva</th>
                                        <th class="sorting_disabled text-center" style="width:10%" aria-label="">Nota Discursiva</th>
                                        <th class="sorting_disabled text-center" style="width:10%" aria-label="">Nota Geral</th>
                                        <th class="sorting_disabled text-center" style="width:10%" aria-label="">Comprovante</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (count($listar_aluno) > 0) {

                                        foreach ($listar_aluno as $row) {
                                            ?>

                                            <tr>
                                                <td valign="middle"><?= $row->CD_ALUNO ?></td>
                                                <td valign="middle"><?= $row->NM_ALUNO ?></td>
                                                <td align="center">
                                                    <?php
                                                    $discursiva = '';
                                                    foreach ($notas_obj as $v) {
                                                        if ($v->CD_ALUNO == $row->CD_ALUNO) {
                                                            echo number_format(str_replace(',', '.', $v->NR_NOTA), 1, '.', '');
                                                            $nao = true;
                                                            $row->CD_ALUNO = 'xxxxxx'
                                                            ?>

                                                            <input type="hidden" readonly="" name="nObj_<?= $row->CD_ALU_DISC ?>" id="cObj_<?= $row->CD_ALU_DISC ?>" value="<?= number_format(str_replace(',', '.', $v->NR_NOTA), 1, '.', ''); ?>" size="5" style="border: none;"/>
                                                            <input type="hidden" name="cd_aluno<?= $v->CD_ALUNO ?>" value="<?= $v->CD_ALUNO ?>"/>
                                                            <input type="hidden" name="cd_prova" value="<?= $v->CD_PROVA ?>"/>

                                                            <?php
                                                            $discursiva = $v->NR_NOTA_DISCURSIVA;
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td align="center">
                                                    <?php
                                                    
                                                    //caso aluno do ensino médio e terceiro ano sem lançamento de nota discursiva                                                    
                                                    if ($discursiva == '') {
                                                        echo "-";
                                                   } else {
                                                        $sel = '';
                                                        if ($_POST['nota_' . $row->CD_ALU_DISC])
                                                            $valor = $_POST['nota_' . $row->CD_ALU_DISC];
                                                        elseif ($discursiva > 0) {
                                                            $valor = $discursiva;
                                                            echo number_format(str_replace(',', '.', $valor), 1, '.', '');
                                                        } elseif (($discursiva == '0') or ( $discursiva != '')) {
                                                            $valor = $discursiva;
                                                            echo number_format(str_replace(',', '.', $valor), 1, '.', '');
                                                        } elseif ($nao == false) {
                                                            $valor = $discursiva;
                                                            echo number_format(str_replace(',', '.', $valor), 1, '.', '');
                                                        } else {
                                                            $valor = '';
                                                            ?>
                                                            <input name="disc_<?= $row->CD_ALU_DISC ?>" placeholder="00.0" type="number" step=".1" id="cDisc_<?= $row->CD_ALU_DISC ?>" place size="3" min="0.1" max="5" onchange="calculaNota(<?= $row->CD_ALU_DISC ?>);" onkeydown="mascara(this, mvalor);" />
                                                        <?php } ?>
                                                        <input name="CD_ALU_DISC" type="hidden" value="<?= $row->CD_ALU_DISC ?>" >   
                                                    <?php  } ?>
                                                </td>

                                                <td align="center">
                                                    <?php
                                                    
                                                    $sel = '';
                                                    if ($_POST['nota_' . $row->CD_ALU_DISC])
                                                        $valor = $_POST['nota_' . $row->CD_ALU_DISC];
                                                    elseif ($row->NOTA > 0) {
                                                        $valor = $row->NOTA;
                                                        //echo number_format(str_replace(',', '.', $valor), 1, '.', '');
                                                        echo '<input class="text-center" value="'.$row->NOTA.'" readonly="readonly" name="nota_' . $row->CD_ALU_DISC . '" placeholder="00.0" type="number" id="nota_' . $row->CD_ALU_DISC . '" place size="3" min="0.1" max="10" step=".1"/>';
                                                    } elseif ($row->NOTA == '0') {
                                                        $valor = $row->NOTA;
                                                        echo number_format(str_replace(',', '.', $valor), 1, '.', '');
                                                    } elseif ($codigoTipoNota == 34) {//Nota da MAIC
                                                        echo '<input name="nota_' . $row->CD_ALU_DISC . '" placeholder="00.0" type="number" id="nota_' . $row->CD_ALU_DISC . '" place size="3" min="0.1" max="10" step=".1"/>';
                                                    } else {
                                                        $valor = '';
                                                        echo '<input name="nota_' . $row->CD_ALU_DISC . '" placeholder="00.0" readonly="readonly" type="text" id="nota_' . $row->CD_ALU_DISC . '" place size="5" maxlength="5"   />';
                                                    }
                                                    ?>                                                    
                                                    <input name="CD_ALU_DISC" type="hidden" value="<?= $row->CD_ALU_DISC ?>" >
                                                </td>
                                                <td>
                                                    <a class="btn btn-success btn-small" href="#upload-<?= $row->CD_ALU_DISC ?>" data-toggle="modal" tabindex="-1">
                                                        <i class="fa fa-file-o"></i>
                                                        Adicionar Arquivo
                                                    </a>

                                                    <div id="upload-<?= $row->CD_ALU_DISC ?>"                                                         
                                                         class="modal fade" 
                                                         tabindex="-1" 
                                                         data-remote="<?= site_url("professor/nota/add_arquivo") . "?cd_alu_disc=" . $row->CD_ALU_DISC . "&num_nota=" . $numero_nota ?>">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <?= modal_load ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            $nao = false;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>  
                            <input name="aluno_<?= $row->CD_ALU_DISC ?>" type="hidden" value="<?= $row->CD_ALU_DISC ?>" >
                        </form>     
                    <?php } ?>

                    <div class="row-fluid wizard-actions">
                        <form action="<?= SCL_RAIZ ?>professor/nota/imprimir" method="post" name="imprimir" target="_blank">
                            <input name="disciplina" type="hidden" id="disciplina" value="<?= $disciplina ?>" />
                            <input name="txtdisciplina" type="hidden" id="txtdisciplina" value="<?= $txtdisciplina ?>" />
                            <input name="turma" type="hidden" id="turma" value="<?= $turma ?>" />
                            <input name="curso" type="hidden" id="curso" value="<?= $curso ?>" />
                            <input name="numero_nota" type="hidden" id="numero_nota" value="<?= $numero_nota ?>" />
                            <input name="estrutura" type="hidden" id="estrutura" value="<?= $estrutura ?>" />
                        </form>
                        <button class="btn btn-danger" onclick="window.location.href = '<?= SCL_RAIZ ?>professor/nota'">Cancelar</button>
                        <button class="btn btn-warning" onclick="document.forms['imprimir'].submit();" target="_blank">Imprimir</button>
                        <button class="btn btn-primary" id="btn-finalizar">
                            Finalizar
                        </button>

                        <div id="modal-confirma-nota" class="modal fade" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header btn-warning">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" style="font-weight: bold">Confirmar lançamento de Notas</h4>
                                    </div>

                                    <div class="modal-body">
                                        <p>Caro professor, antes de validar o lançamento de notas, confira a relação digitada e depois clique no botão "Validar".</p>

                                        <div id="tabela-confirma-nota">
                                            <div class="panel panel-primary">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <div class="pull-left">
                                            <button class="btn btn-success" id="btn-validar">Validar</button>    
                                        </div>

                                        <div class="pull-right">
                                            <button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    //preparar tabela para confirmar o lançamento
    $("#btn-finalizar").on("click", function () {
        $("#tabela-confirma-nota").children().remove();
        $("#gridview").clone().appendTo("#tabela-confirma-nota");

        //eliminar coluna de arquivo
        $("#tabela-confirma-nota table thead").find("tr th:last").remove();
        $("#tabela-confirma-nota table tbody").find("tr").each(function (linha) {
            $(this).find("td:last").remove();
            $(this).find("td").each(function (coluna) {
                var valor = $(this).find("input:not(input[type=hidden])").val();

                if (valor !== "") {
                    $(this).html(valor);
                } else if (valor === "") {
                    $(this).html("");
                }
            });
        });

        $("#modal-confirma-nota").modal("show");
    });

    //enviar o formulário para inserir as notas
    $("#btn-validar").on('click', function () {
        $("#frmvalidar").submit();
    });
</script>

<?php $this->load->view('layout/footer'); ?>