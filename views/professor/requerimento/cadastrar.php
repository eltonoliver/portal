<?php $this->load->view('layout/header'); ?>
<!--<link href="<?= SCL_CSS ?>bootstrap-select.min.css" rel="stylesheet" type="text/css">
<link href="<?= SCL_CSS ?>style.css?v=1.0" rel="stylesheet">
<script src="<?= SCL_JS ?>script.js"></script>   -->

<script type="text/javascript">
    function filtrar() {
        $("#form_pesq").submit(function () {
            $('div[id=tabela_listar]').html('<div class="progress progress-striped progress-striped active"><div class="progress-bar progress-bar-warning" style="width: 100%;">Carregando Dados</div></div>');
            $.post("<?= SCL_RAIZ ?>professor/requerimento/lista_aluno", $("#form_pesq").serialize()) //Serialize looks good name=textInNameInput&&telefon=textInPhoneInput---etc
                    .done(function (data) {
                        if (data != null) {
                            $('div[id=tabela_listar]').html(data);
                        } else {
                            $('div[id=tabela_listar]').html("<div class='text-danger'>Não retornou nada da pesquisa</div>");
                        }
                    });
            return false;
        })
    }

</script>


<div id="content">
    <div class="row">

        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <form id="form_pesq" name="form_pesq" method="post">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <a href="<?= SCL_RAIZ ?>professor/requerimento/index" class="btn btn-info btn-sm"><i class="icon-plus"></i> Voltar</a>
                    </div>
                    
                    <div class="widget-main">  
                        
                        <div class="col-lg-6">
                            <p class="text-primary">Tipo de Requerimento.</p>
                            <select id="tipo" name="tipo" class="form-control" required="">
                                <option value="">SELECIONE O TIPO DE REQUERIMENTO</option>
                                <?php
                                foreach ($tipo as $t) {
                                    echo '<option value="' . $t['CD_TIPO_REQ'] . '">' . strtoupper($t['NM_TIPO_REQ']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
<!--                        <div class="col-lg-6">
                            <p class="text-primary">Estrutura de Notas</p>
                            <select id="estrutura" name="estrutura" class="form-control" required="">

                            </select>
                        </div> -->
                        

                        <div class="col-lg-6">
                            <p class="text-primary">Bimestre</p>
                            <select name="bimentre" id="bimentre" class="form-control col-xs-2" required="">
<!--                                    <option value=""></option>-->
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <p class="text-primary">Minhas Turmas.</p>
                            <select id="turma" name="turma" class="form-control" required="">
                                <option value="">SELECIONE UMA TURMA</option>
                                <?php
                                foreach ($turmas as $tu) {
                                    echo '<option value="'.$tu['CD_TURMA'].';'.$tu['CD_DISCIPLINA'].';'.$tu['CD_CURSO'].';'.$tu['TURNO'].';'.$tu['CD_ESTRUTURA'].'">'.strtoupper($tu['NM_DISCIPLINA']).' - '.$tu['CD_TURMA'].' - '.$tu['NM_CURSO'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        
                        <div class="col-lg-6">
                            <p class="text-primary">Tipo de Nota</p>
                            <select name="tipo_nota" id="tipo_nota" class="form-control col-xs-2" required="">
<!--                                    <option value=""></option>-->
                                </select>
                        </div>

                    </div>
                    <div class="col-lg-6 text-danger" id="obs_tipo"></div>
                    <div class="modal-footer"><br>
                        <button type="submit" onclick="filtrar();" id="filtro" class="btn btn-success">Filtrar</button>
                    </div>
                </div>
            </form>
            <div class="col-xs-12">
                <div class="panel">
                    <div id="tabela_listar"> <?php echo $this->session->flashdata('sucesso'); ?> </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script> 
$(document).ready(function() {
    $("#estrutura").change(function() { 
        $("#bimestre").html('Aguardando Bimentre...');
        $.post("<?= SCL_RAIZ ?>professor/requerimento/bimentre", {
            estrutura: $(this).val()},
        function(valor) { 
            $("#bimentre").html(valor);
        })
    });
    
    $("#bimentre").change(function() { 
        $("#tipo_nota").html('Aguardando Tipo Nota...');
        $.post("<?= SCL_RAIZ ?>professor/requerimento/tiponota", {
            tipo: $(this).val()},
        function(valor) { 
            $("#tipo_nota").html(valor);
        })
    });
    
    $("#turma").change(function() { 
        $("#bimentre").html('Aguardando esturutura Nota...');
        $.post("<?= SCL_RAIZ ?>professor/requerimento/estuturanota", {
            est: $(this).val()},
        function(valor) { 
            $("#bimentre").html(valor);
        })
    });
    
    $("#tipo").change(function() { 
        $("#obs_tipo").html('Carregando...');
        $.post("<?= SCL_RAIZ ?>professor/requerimento/obs_tipo", {
            tipo: $(this).val()},
        function(valor) { 
            $("#obs_tipo").html(" <p class='text-primary'>Descrição</p>"+valor);
        })
    });

});
</script>
<?php $this->load->view('layout/footer'); ?>