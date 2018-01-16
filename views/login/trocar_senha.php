<?php $this->load->view('layout/header'); ?>

<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            get_msg('msgok');
            get_msg('msgerro');
            erros_validacao();
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Fomulário - Trocar Senha</h3>
                </div>
                <div class="panel-body">
                    <form class="form-bordered" name="form_senha" id="form_senha" method="post" action="<?=SCL_RAIZ?>inicio/trocar_senha">
                        <input type="hidden" name="acao" value="1">
                        <div class="form-group">
                            <label for="senha_atual">Senha Atual</label>
                            <input type="password" placeholder="Informe sua senha atual..." class="form-control" name="senha_atual" id="senha_atual" value="">
                        </div>
                        <div class="form-group">
                            <label for="nova_senha">Nova Senha</label>
                            <input type="password" placeholder="Informe sua nova senha..." class="form-control" name="nova_senha" id="nova_senha" value="">
                        </div>
                        <div class="form-group">
                            <label for="repetir_senha">Repetir Nova Senha</label>
                            <input type="password" placeholder="Repita a senha..." class="form-control" name="repetir_senha" id="repetir_senha" value="">
                        </div>
                        <div class="form-group form-actions">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-key"></i> Trocar Senha
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('layout/footer'); ?>