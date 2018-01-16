<div class="modal-header btn-info">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><i class="fa fa-user"></i> Novo Usuário</h3>
</div>

<div class="modal-body">
    <div class="tab-pane well" id="pill-terceiro" style="margin: 20px 0;">
        <form action="<?= SCL_RAIZ ?>acesso/usuario/desbloquear" method="post" class="form-horizontal" enctype="multipart/form-data" id="frmadicionar" name="frmadicionar" >
            <div class="col-xs-12">
                <button type="submit" value="Submit" class="btn btn-primary" id="frmarquivo_btn" ><i class="fa fa-plus"></i> Cadastrar </button>
            </div>
            &DownBreve;
        </form>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-danger" data-dismiss="modal" id="frmarquivo_btn" ><i class="fa fa-refresh"></i> Fechar </button>
</div>

<? exit(); ?>