<?php
$this->load->view('layout/header');
?>
<div id="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel col-lg-12">
                <?php echo get_msg('msgok'); ?>
                <label>Data da Aula</label>
                <br />
                <select id="lista" class="form-control col-md-6">
                    <?php 
                    foreach ($rechamadas as $d) {
                        if ($d['FLG_AUTORIZACAO'] == 'S') {
                            $liberado = "";
                            $cor = 'class="text-success"';
                        } else {
                            $liberado = "";
                            $cor = 'class="text-success"';
                        }
                        echo '<option '.$cor.'value="'.$d['CD_TURMA'].';'.$d['CD_DISCIPLINA'].';'.$d['CD_CURSO'].';'.$d['DT_AULA'].';'.$d['TEMPO_AULA'].'"'. $liberado.'>Turma: '.$d['CD_TURMA'].' - Dia: '.$d['DT_AULA'].' - Curso: '.$d['NM_CURSO_RED'].' - '.$d['TEMPO_AULA'].'° Tempo</option>';
                    }
                    ?>
                </select>    
            </div>
        </div>
        <div class="col-xs-12">
            <div id="load"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {        
        $("#lista").change(function() {
            $("#load").html('<?=modal_load?>');
            $.post("<?= SCL_RAIZ ?>professor/diario/lista_alunos", {
                parametro: $("#lista").val()
            },
            function(valor) {
                $("#load").html(valor);
            })
        })

      
    })
</script>
<!--
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <div class="tabbable">
                <div class="tab-content no-border no-padding">
                    <div class="tab-pane in active">
                        <div class="message-container">
                            <div class="message-list-container">

                                <div>
                                    <label for="form-field-select-3">Data da Aula</label>
                                    <br />
                                    <select id="lista" class="form-control width-50 chosen-select" data-placeholder="Choose a Country...">
                                        <option value="">&nbsp;</option>
                                        <?php
                                        
                                        foreach ($dia as $d) {
                                            if ($d->FLG_AUTORIZACAO == 'N') {
                                                $liberado = "disabled='disabled'";
                                                $cor = 'class="text-danger"';
                                            } else {
                                                $liberado = "";
                                                $cor = 'class="text-success"';
                                            }
                                            echo '<option '.$cor.'value="'.$d->CD_TURMA.';'.$d->CD_DISCIPLINA.';'.$d->CD_CURSO.';'.$d->DT_AULA.'"'. $liberado.'>Turma: '.$d->CD_TURMA.' - Dia: '.$d->DT_AULA.' - Curos: '.$d->NM_CURSO_RED.'</option>';
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="col-xs-12">
                        <div id="load"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
</script>
<script src="<?=SCL_JS?>chosen.jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".chosen-select").chosen(); //habilita o selectbox
        
        $("#lista").change(function() {
            $("#load").html('<?=modal_load?>');
            $.post("<?= SCL_RAIZ ?>/professor/diario/lista_alunos", {
                parametro: $("#lista").val()
            },
            function(valor) {
                $("#load").html(valor);
            })
        })

      
    })
</script>-->
<?php
$this->load->view('layout/footer');
?>