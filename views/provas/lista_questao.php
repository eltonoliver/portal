<?php $this->load->view('layout/header'); ?>
<script>
function visualizar(id){
    var url = "https://www.seculomanaus.com.br/seculo/prova?id=" + id;
   // window.location.href = url;
   window.open(url);
}    
</script>    
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">

                    <a data-toggle="modal" data-target="#questao" class="btn btn-default" href="#"><i class="fa fa-refresh"></i> Nova Questão</a>
                    <div class="modal fade" id="questao" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                         data-remote="<?= SCL_RAIZ . "provas/questoes/selecionar_curso_serie" ?>" > 
                        <div class="modal-dialog" style="width: 60%;">
                            <div class="modal-content">
                                <?= modal_load ?>
                            </div>
                        </div>
                    </div>
                    <a data-toggle="modal" data-target="#view" class="btn btn-default" href="#"><i class="fa fa-book"></i> Visualizar Provas</a>
                    <div class="modal fade" id="view" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"> 
                        <div class="modal-dialog" style="width: 60%;">
                            <div class="modal-content">
                                <div class="modal-content">
                                    <div class="modal-header btn-success">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4><i class="fa fa-file"></i> Selecione a Prova</h4>
                                    </div>

                                    <div class="panel-body">   

                                        <div class="row">
                                            <div class="col-xs-12">

                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label text-info" for="disc">Prova</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control input-sm" name="prova" id="prova" required onchange="visualizar(this.value)">
                                                            <option value="" class="text-muted">Selecione a Prova</option>
                                                            <?php foreach ($provas as $p) { ?>
                                                                <option value="<?=$p['CD_PROVA'] ?>">
                                                                    <?= $p['TITULO'] ?> - <?= $p['DT_PROVA'] ?> - <?= $p['NM_CURSO'] ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div> 

                                    <div class="modal-footer">
                                        <button class="btn btn-danger pull-left" data-dismiss="modal" id="frmarquivo_btn" ><i class="fa fa-refresh"></i> Fechar </button>
<!--                                        <a href="<?=SCL_RAIZ?>provas/visualizar/prova?id=<?=base64_encode($p->CD_PROVA)?>" target="_blank" class="btn btn-default right" href="#"><i class="fa fa-book"></i> Visualizar Prova</a>-->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                <table border="1" id="gridTabela" class="table table-striped table-bordered table-responsive table-hover">
                    <thead class="well">
                        <tr>
                            <th width="10%">ID</th>
                            <th width="50%">Descricao</th>
                            <th width="30%">Titulo</th>
                            <th width="5%" class="text-center">Posição</th>
                            <th width="10%">Visualizar</th>
                            <th width="10%">Tipo</th>
                            <th class="text-center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php  foreach ($listar as $row) { ?>
                            <tr style="font-size:14px">
                                <td><?= $row['CD_QUESTAO'] ?></td>
                                <td>
                                <?php
                                $text = substr($row['DC_QUESTAO'], 0, 100);
                                    //echo substr($row->DC_QUESTAO, 0, 100); 
                                echo strip_tags($text);
                                echo "\n";
                                ?>...
                                </td>
                                <td><?= $row['TITULO'] ?></td>
                                <td><?= $row['POSICAO'] ?></td>
                                <td>
                                    <a data-toggle="modal" class="btn btn-xs btn-info" href="#view<?= $row['CD_QUESTAO'] ?>"><i class="icon-paperclip"></i> Ver questão</a>

                                    <div class="modal fade" id="view<?=$row['CD_QUESTAO']?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"> 
                                        <div class="modal-dialog" style="width: 30%;">
                                            <div class="modal-content">
                                                <div class="modal-header btn-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" >Visualização da Questão</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <h4>Pergunta:</h4>
                                                    <p class="text-info"><?= $row['DC_QUESTAO'] ?></p>
                                                    <div class="divider">--------------------------------------------</div>

<!--                                                    <h4>Resposta:</h4>
                                                    <p class="text-danger"><strong>
                                                        <?php
                                             //           echo $row['FLG_RESPOSTA_CORRETA'];
                                                        ?>
                                                        </strong></p>-->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><?= $row['TIPO'] ?></td>
                                <td>
                                    <?php if($row['CD_STATUS'] == 1){ ?>
                                    <a class="btn btn-warning" href="<?= SCL_RAIZ ?>provas/questoes/editar_questoes?token=q&id=<?= $row['CD_QUESTAO'] ?>" data-toggle="modal">
                                        <i class="fa fa-edit"></i> 
                                    </a>
                                    <?php } ?>
                                </td>
                            </tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#gridTabela').dataTable({
        "sPaginationType": "full_numbers",
        "oLanguage": {
            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "sLengthMenu": "Mostrar _MENU_ por página  ",
            "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
            "sInfoEmpty": "Registro não encontrado",
            "sZeroRecords": "Não há registro",
        },
        "aaSorting": [[0, "desc"]],
        "bStateSave": true
    });

    $('[data-toggle="frmModal"]').on('click',
            function (e) {
                $('#frmModal').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade" id="frmModal"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
</script>
<?php $this->load->view('layout/footer'); ?>





