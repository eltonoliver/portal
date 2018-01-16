<div class="modal-header btn-info">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><i class="fa fa-user"></i> Novo Usuário</h3>
</div>

<div class="modal-body">
    <ul class="nav nav-pills no-padding">
        <li class="active"><a href="#pill-normal" data-toggle="pill">Usuário Normal</a></li>
        <li class=""><a href="#pill-terceiro" data-toggle="pill">Usuário Tercerizado</a></li>
        <li class=""><a href="#pill-generico" data-toggle="pill">Usuário Genérico</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active well" id="pill-normal" style="margin: 20px 0;">
            <form action="<?= SCL_RAIZ ?>acesso/usuario/cadastrar" method="post" class="form-horizontal" enctype="multipart/form-data" id="frmadicionar" name="frmadicionar" >
                <div class="col-xs-8">
                    <label>Mantenedora</label>
                    <select id="mantenedora" name="mantenedora" class="form-control">
                        <option> ---- </option>
                        <? foreach ($mantenedora as $r) { ?>
                            <option value="<?= $r['CD_MANTENEDORA'] ?>"><?= $r['NM_REDUZIDO_MAN'] ?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="col-xs-4">
                    <label>Tipo </label>
                    <select id="tipo" name="tipo" class="form-control">
                        <option> ---- </option>
                        <option value="0"> FUNCIONÁRIO </option>
                        <option value="1">PROFESSOR</option>
                    </select>
                </div>

                <div class="col-xs-12">
                    <label>Pessoa </label>
                    <select id="pessoa" name="pessoa" class="form-control">
                        <option> ---- </option>
                        <option value="0"> FUNCIONÁRIO </option>
                        <option value="1">PROFESSOR</option>
                    </select>
                </div>
                <div class="col-xs-6">
                    <label>Login </label>
                    <input id="login" value="" name="login" class="form-control" type="text" />
                </div>
                <div class="col-xs-6">
                    <label>Senha </label>
                    <input id="senha" value="" name="senha" class="form-control" type="password"/>
                </div>

                <div class="col-xs-12">
                    <label>Email </label>
                    <input id="email" value="" name="email" class="form-control" type="email"/>
                </div>

                <div class="col-xs-12">
                    <label>Observação </label>
                    <textarea id="obs" value="" name="obs" class="form-control" ></textarea>
                </div>


                <div class="col-xs-12">
                    <br />
                    <input id="chapa" value="" name="chapa" type="hidden"/>
                    <input id="funcao" value="" name="funcao" type="hidden"/>
                    <input id="chapa" value="" name="chapa" type="hidden"/>

                    <button type="submit" value="Submit" class="btn btn-primary" id="frmarquivo_btn" ><i class="fa fa-plus"></i> Cadastrar </button>
                </div>
                &DownBreve;

            </form>
        </div>
        <div class="tab-pane well" id="pill-terceiro" style="margin: 20px 0;">
            <form action="<?= SCL_RAIZ ?>acesso/usuario/cadastrar" method="post" class="form-horizontal" enctype="multipart/form-data" id="frmadicionar" name="frmadicionar" >
                <div class="col-xs-4">
                    <label>CPF </label>
                    <input id="cpf" value="" name="cpf" class="form-control" type="text"/>
                </div>
                <div class="col-xs-8">
                    <label>Empresa </label>
                    <input id="empresa" value="" name="empresa" class="form-control" type="text"/>
                </div>

                <div class="col-xs-12">
                    <label>Nome </label>
                    <input id="nome" value="" name="nome" class="form-control" type="text" />
                </div>

                <div class="col-xs-12">
                    <label>Função/Cargo </label>
                    <input id="funcao" value="" name="funcao" class="form-control" type="text" />
                </div>

                <div class="col-xs-4">
                    <label>Data Cadastro </label>
                    <div class="input-group">
                        <input type="text" id="data" name="data" class="form-control" value="<?= date('d/m/Y'); ?>" readonly>
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>

                <div class="col-xs-4">
                    <label>Data Expiração </label>
                    <div class="input-group">
                        <input type="text" id="expiracao" name="expiracao" class="form-control">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                </div>

                <div class="col-xs-4">
                    <label>Nº JOB </label>
                    <input id="login" value="" name="login" class="form-control" type="text" />
                </div>


                <div class="col-xs-6">
                    <label>Login </label>
                    <input id="login" value="" name="login" class="form-control" type="text" />
                </div>

                <div class="col-xs-6">
                    <label>Senha </label>
                    <input id="senha" value="" name="senha" class="form-control" type="password" />
                </div>

                <div class="col-xs-12">
                    <label>Observação </label>
                    <textarea id="obs" value="" name="obs" class="form-control" ><?= $this->input->senha(); ?></textarea>
                </div>


                <div class="col-xs-12">
                    <br />

                    <button type="submit" value="Submit" class="btn btn-primary" id="frmarquivo_btn" ><i class="fa fa-plus"></i> Cadastrar </button>
                </div>
                &DownBreve;

            </form>
        </div>
        <div class="tab-pane" id="pill-generico">
            <div class="well" style="margin: 20px 0;">
                <h4>Message Content</h4>
                <p>Aenean lacinia bibendum nulla sed consectetur.</p>
            </div>
        </div>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-danger" data-dismiss="modal" id="frmarquivo_btn" ><i class="fa fa-refresh"></i> Fechar </button>
</div>
<? exit(); ?>