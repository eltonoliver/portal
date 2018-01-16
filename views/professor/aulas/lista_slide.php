<div class="modal-header btn-info">
    <h3><i class="fa fa-list-alt"></i> Slides Cadastrados</h3>
</div>


<div class="modal-body">
    <div class="row">
        <div class="message-container">
            <div id="id-message-list-navbar" class="message-navbar clearfix">
                <div class="message-bar">
                    <div class="message-infobar">
                        <table class="table table-striped table-bordered table-delete">
                            <thead class="text-info">
                                <th colspan="3">Disciplina: <?=$disciplina->NM_DISCIPLINA?></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Período</td>
                                    <td>Titulo Slide</td>
                                    <td>Ações</td>
                                </tr>
                                <?php foreach ($lista as $l) { ?>
                                <tr>
                                    <td><?=$l['PERIODO']?></td>
                                    <td><?=$l['TITULO']?></td>
                                    <td>acoes</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<div class="modal-footer">
    <button class="btn btn-danger" data-dismiss="modal" id="frmarquivo_btn" ><i class="fa fa-pencil"></i> Fechar </button>
</div>


<?php exit();?>