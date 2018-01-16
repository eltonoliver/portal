<script type="text/javascript">
    //apenas mostra a mensagem do sweet alert
    function mostrarMensagem(titulo, mensagem, tipo) {
        swal({
            title: titulo,
            text: mensagem,
            type: tipo,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ok",
            closeOnConfirm: true
        });
    }

    //validar os campos e exibe mensagem caso necessário
    function validarConteudo() {
        var mensagem = "";
        if ($("#Descricao").val() == "") {
            $("#Descricao").focus();
            mensagem = "Preencha o campo Conteúdo";
        }

        if (mensagem != "") {
            mostrarMensagem("Aviso", mensagem, "warning");
            return false;
        }

        return true;
    }

    // ENVIA O FORMULÁRIO COM OS DADOS
    jQuery('#btnNovoConteudo').click(function () {
        if (validarConteudo()) {
            $("#resConteudo").html('<?= LOAD ?>');

            $.post("<?= base_url('108/conteudo/frmManterConteudo') ?>", {
                codigo: $("#Codigo").val(),
                tema: $('#Tema').val(),
                descricao: $("#Descricao").val(),
                operacao: $("#Operacao").val()
            },
            function (data) {
                $("#resConteudo").html("");

                if (data['success']) {
                    atualizar(<?= $tema->CD_TEMA ?>);
                    mostrarMensagem("Mensagem", data['mensagem'], "success");

                    if (data['operacao'] == "I") {
                        $("#Descricao").val("");
                    } else if (data['operacao'] == "D") {
                        $('#frmModalConteudo').modal('hide');
                    }
                } else {
                    mostrarMensagem("Mensagem", data['mensagem'], "error");
                }
            }, "json");
        }
    });
</script>

<div class="modal-dialog modal-lg">    
    <div class="color-line"></div>

    <div class="modal-content border">        
        <div class="modal-header">
            <h4><?= $titulo ?></h4>
        </div>

        <div class="modal-body">
            <fieldset>
                <legend>DADOS DO TEMA</legend>

                <div class="row">
                    <div class="col-xs-4 form-group">
                        <label>Curso</label>
                        <input disabled class="form-control" value="<?= $tema->NM_CURSO ?>"> 
                    </div>

                    <div class="col-xs-4 form-group">
                        <label>Série</label>
                        <input disabled class="form-control" value="<?= $tema->NM_SERIE ?>"> 
                    </div>

                    <div class="col-xs-4 form-group">
                        <label>Disciplina</label>
                        <input disabled class="form-control" value="<?= $tema->NM_DISCIPLINA ?>"> 
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 form-group">
                        <label>Tema</label>
                        <input disabled class="form-control" value="<?= $tema->DC_TEMA ?>"> 
                    </div>                
                </div>
            </fieldset>

            <fieldset>
                <legend>CONTEÚDO</legend>

                <div class="row">
                    <div class="col-xs-12 form-group">
                        <input class="form-control" type="text" name="Descricao" id="Descricao" 
                               value="<?= $descricao ?>"
                               <?= $operacao == "D" ? "disabled" : "" ?>>
                    </div>
                </div>

                <input type="hidden" name="Codigo" id="Codigo" value="<?= $conteudo->CD_CONTEUDO ?>">
                <input type="hidden" name="Tema" id="Tema" value="<?= $tema->CD_TEMA ?>">
                <input type="hidden" name="Operacao" id="Operacao"value="<?= $operacao ?>">
            </fieldset>
        </div>

        <div class="modal-footer">
            <div id="resConteudo">
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn <?= $operacao == "D" ? "btn-danger" : "btn-success" ?> pull-right" id="btnNovoConteudo">
                <i class="fa <?= $operacao == "D" ? "fa-trash" : "fa-check" ?>"></i> <?= $operacao == "D" ? "DELETAR" : "SALVAR" ?>      
            </button>

            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        </div>
    </div>
</div>