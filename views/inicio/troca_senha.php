<?php $this->load->view('layout/header'); ?>
<style>
    #form_acao label.error { width: auto; display: inline;  color: #FF0000; font-weight: bold;}
    .block {display: block;}
    form.cmxform label.error {display: none;}
</style>
<link rel="stylesheet" href="<?= SCL_JS ?>/jquery-validation/demo/css/screen.css">
<script src="<?= SCL_JS ?>/jquery-validation/dist/jquery.validate.js"></script>

<script>
function valida_senha(senha){
    $("#resposta").html('<div class="progress progress-striped active"><div class="progress-bar progress-bar-warning" style="width: 100%;"></div></div>');
    $.post("<?= SCL_RAIZ ?>inicio/valida_senha", {
        senha: senha
    },
    function(valor) { 
        if(valor == 0){
            $("#resposta").html('<div class="alert alert-danger alert-dark"><button class="close" data-dismiss="alert" type="button">×</button><strong>Erro!</strong> Senha Inválida.</div>');
        }else{
            $("#resposta").html('<a class="label label-success" href="#">ok</a>');
        }
    });
}
</script>
<script>
    $().ready(function () {
        $("#form_senha").validate({
            rules: {
                'senha_atual': {required: true},
                'nova_senha': {required: true, minlength: 5},
                'conf_senha': {required: true, equalTo: "#nova_senha",minlength: 6}
            },
            messages: {
                senha_atual: {required: 'Informe sua senha atual'},
                nova_senha: {required: 'Informe a nova senha', minlength:'A senha deve conter no mínimo 6 caracteres'},
                conf_senha: {required: 'Confirme sua senha', equalTo: 'Senha não conferi', minlength:'A senha deve conter no mínimo 6 caracteres'}
            }
        });
    });
</script>
<div id="content">
    <div class="row">
        <div class="col-sm-12">
            <p class="help-block" id="resposta1"></p>
            <form  class="form-horizontal form-bordered" method="post" action="#" name="form_senha" id="form_senha">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Informe seus Dados</h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="senha_atual" class="col-md-3 control-label">Senha Atual</label>
                            <div class="col-md-9">
                                <input type="password" required="" placeholder="Senha Atual.." class="form-control" name="senha_atual" id="senha_atual" onblur="valida_senha(this.value)">
                                <p class="help-block" id="resposta"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nova_senha" class="col-md-3 control-label">Nova Senha</label>
                            <div class="col-md-9">
                                <input type="password" placeholder="Nova Senha.." class="form-control" name="nova_senha" id="nova_senha">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="conf_senha" class="col-md-3 control-label">Confirmar Senha</label>
                            <div class="col-md-9">
                                <input type="password" placeholder="Confirmar Senha.." class="form-control" name="conf_senha" id="conf_senha">
                            </div>
                        </div>


                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-success" >Alterar</button>
                        <a class="btn btn-default" href="<?= SCL_RAIZ ?>inicio/">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>            
    </div>

</div>

<script>
    $(document).ready(function () {
        $("#form_senha").submit(function (e) {
            e.preventDefault(); // <-- important
            if ($("#form_senha").valid()) {
                var dados = jQuery(this).serialize();
                jQuery.ajax({
                    type: "POST",
                    url: "<?= SCL_RAIZ ?>inicio/conf_troca",
                    data: dados,
                    success: function (data){
                        if(data==1){
                            $("#resposta1").html('<div class="alert alert-success alert-dismissable">Senha alterada com sucesso</div>');
                            document.getElementById("form_senha").reset();
                        }else{
                            $("#resposta1").html('<div class="alert alert-danger alert-dismissable">Erro ao alterar a senha</div>');
                        }
                    }
                });
            return false;
            }
        });

    });
</script>
<?php $this->load->view('layout/footer'); ?>


