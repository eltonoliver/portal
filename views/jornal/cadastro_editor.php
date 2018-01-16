<?php $this->load->view('layout/header'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $("select[name=curso]").change(function() {
            $("select[id=serie]").html('Aguardando série');
            $.post("<?= SCL_RAIZ ?>colegio/colegio/curso_serie", {
                curso: $(this).val()},
            function(valor) {
                $("#retorno").html(valor);
            })
        })
        $("select[name=serie]").change(function() {
            $("select[id=turma]").html('Aguardando turma...');
            $.post("<?= SCL_RAIZ ?>colegio/colegio/serie_turma", {
                serie: $(this).val()},
            function(valor) {
                $("select[id=turma]").html(valor);
            })
        })


    })
</script>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <a href="<?= SCL_RAIZ ?>jornal/editores" id="voltar" class="btn btn-info" type="button">Voltar</a>
                </div>
                <div class="panel-body">
                    <ul id="myTab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#home" data-toggle="tab">
                                <h4> Pesquisar Turmas </h4>
                            </a>
                        </li>
                        <li>
                            <a href="#profile" data-toggle="tab">
                                <h4> Pesquisar Colaborador </h4>
                            </a>
                        </li>
                    </ul>
                    <br>
                    <div class="tab-content">
                        <div class="tab-pane in active" id="home">
                            <div class="row">
                                <form class="form-horizontal form-bordered" method="post" id="frmPesquisar" name="frmPesquisar">   
                                    <div class="col-xs-3">
                                        <select name="curso" id="curso" class="form-control">
                                            <option selected="selected" value="">Selecione o Curso</option>
                                            <?php foreach ($curso as $item) { ?>
                                                <option value="<?= $item['CD_CURSO'] ?>"><?= $item['NM_CURSO'] ?></option>
                                            <?php } ?>               
                                        </select>
                                    </div>

                                    <div class="col-xs-3">
                                        <div id="retorno">Selecione o curso ao lado</div>
                                    </div>

                                    <div class="col-xs-3"> 
                                        <button id="btn_pesquisar"  name="btn_pesquisar" class="btn btn-success" type="button">Pesquisar</button>
                                    </div> 
                                </form>

                            </div>
                        </div>

                        <div class="tab-pane" id="profile">
                            <div class="tabbable">
                                <div class="tab-content no-border no-padding"> 
                                    <div class="table-responsive">
                                        <form method="post" id="frmConfirmar" name="frmConfirmar" action="<?= SCL_RAIZ ?>jornal/editores/confirmar_editor">
                                            <table width="100%" border="0" cellspacing="0"  cellpadding="0" class="table table-striped table-bordered table-hover" id="data-table" aria-describedby="data-table_info">
                                                <thead>
                                                <th class="center" width="2%">Selecione</th>
                                                <th  width="60%">Nome</th>
                                                <th  width="20%">Tipo</th>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($funcionario as $f) { ?>
                                                        <tr>
                                                            <td class="center"><input type="checkbox" name="selecionado[]" value="<?= $f->CD_USUARIO ?>"/></td>
                                                            <td><?= $f->NM_USUARIO ?></td>
                                                            <td><?= $f->FUNCAO ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <input type="submit" id="btn_pesquisar"  name="btn_pesquisar" class="btn btn-success" value="Confirmar"/>
                                            <input type="hidden" name="tipo" value="Colaborador"/>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div id="load"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    $('#data-table').dataTable({
        "sPaginationType": "full_numbers"
    });
</script>
<script type="text/javascript">
    $(document).ready(function() { 
        $("#btn_pesquisar").click(function() { 
            $("#load").html('<?= modal_load ?>');
            $.post("<?= SCL_RAIZ ?>jornal/editores/lista_alunos", {
                curso: $("#curso").val(),
                serie: $("#serie").val()
            },
            function(valor) {
                $("#load").html(valor);
            })
        })


    })
</script>
<?php $this->load->view('layout/footer'); ?>