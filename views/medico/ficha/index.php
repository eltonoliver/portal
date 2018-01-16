<?php $this->load->view('layout/header'); ?>

<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Pesquisar Aluno</h3>
                    <div class="panel-toolbar">
                        <div class="btn-group">
                            <input type="text" class="form-control" name="CIfrmaluno" placeholder="Buscar Aluno"/>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-warning" id="frmbtnAluno"><i class="fa fa-filter"></i></button>
                        </div>
                    </div>
                </div>
                <div class="panel-body" id="gridbusca">
                   
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#frmbtnAluno").click(function() {
            $("#gridbusca").html('<?=modal_load?>');
            $.post("<?= SCL_RAIZ ?>secretaria/aluno/ficha_tabela", {
                nome: $("input[name=CIfrmaluno]").val()
            },
            function(valor) {
                $("#gridbusca").html(valor);
            })
        })
    });
</script>
<?php $this->load->view('layout/footer'); ?>
