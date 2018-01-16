<?php $this->load->view('layout/header'); ?>
<script>
    function excluir(livro, estrutura) {
        var url = "<?= SCL_RAIZ ?>professor/livro/conf_assunto?acao=excluir&livro=" + livro + "&estrutura=" + estrutura;
        window.location.href = url;
    }
</script>


<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    Cadastre o conteúdo de acordo com a Frente do Livro - <a href="<? base_url() ?>index" class="btn btn-default">Voltar</a>
                </div>
                <div class="panel-body">
                    <?php # echo get_msg('msg');?>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Frente A</a></li>
                        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Frente B</a></li>
                        <li role="presentation"><a href="#frentec" aria-controls="profile" role="tab" data-toggle="tab">Frente C</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="home">


                            <div class="divider">&nbsp;</div>
                            <table width="100%" class="table table-striped table-bordered table-hover datatable" id="frenteA" >
                                <thead>
                                    <tr>
                                        <th class="sorting">CÓDIGO</th>
                                        <th class="sorting">TEXTO</th>
                                        <th class="sorting text-center" style="width: 13%">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    foreach ($frenteA as $row) {
                                        ?>
                                        <tr>
                                            <td style="width: 10%"><?= $row['COD']; ?></td>
                                            <td <?php if((strlen($row['COD']) == 3) or (strlen($row['COD']) == 4)){?> style="font-weight: bold" <? } ?>><?= $row['DC_ASSUNTO'] ?></td>
                                            <td class="sorting text-center">
                                                <a href="#" data-toggle="modal" data-target="#cadastrarA<?= $row['ID_LIVRO_ASSUNTO'] ?>"><i class="fa fa-plus-circle"></i> &nbsp;&nbsp;</a>
                                                
                                                <a href="#" data-toggle="modal" data-target="#editarA<?= $row['ID_LIVRO_ASSUNTO'] ?>"><i class="fa fa-edit text-warning"></i> &nbsp;&nbsp;</a>
                                                

                                                <?php if (($row['DC_ASSUNTO'] != 'FRENTE A') && ($row['DC_ASSUNTO'] != 'FRENTE 1')) { ?>
                                                    <a href="#" data-toggle="modal" data-target="#excluirA<?= $row['ID_LIVRO_ASSUNTO'] ?>"><i class="fa fa-trash-o text-danger"></i> &nbsp;&nbsp;</a>
                                                <?php } ?>

                                                <div class="modal inmodal" id="excluirA<?= $row['ID_LIVRO_ASSUNTO'] ?>" tabindex="-1" role="dialog"  aria-hidden="true"> 
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <i class="fa fa-remove modal-icon"></i>
                                                                <h4 class="modal-title">Excluir Registro</h4>
                                                                <small>Esse preocesso não poderá ser desfeito</small>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Tem certeza que deseja excluir o registro?</strong></p>
                                                                <h5><?= $row['DC_ASSUNTO'] ?></h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                                                                <button type="button" class="btn btn-danger" onClick="excluir(<?= $row['ID_LIVRO'] ?>, '<?= $row['ID_ESTRUTURA'] ?>')">excluir</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="cadastrarA<?= $row['ID_LIVRO_ASSUNTO'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                                     data-remote="<?= SCL_RAIZ ?>professor/livro/cadastrar_assunto?id=<?= $row['ID_LIVRO'] ?>&est=<?= $row['ID_ESTRUTURA'] ?>&id_assunto=<?= $row['ID_LIVRO_ASSUNTO'] ?>&acao=novo"> 
                                                    <div class="modal-dialog" style="width: 80%;">
                                                        <div class="modal-content">
                                                            <?= modal_load ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="editarA<?= $row['ID_LIVRO_ASSUNTO'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                                     data-remote="<?= SCL_RAIZ ?>professor/livro/cadastrar_assunto?id=<?= $row['ID_LIVRO'] ?>&est=<?= $row['ID_ESTRUTURA'] ?>&id_assunto=<?= $row['ID_LIVRO_ASSUNTO'] ?>&acao=editar"> 
                                                    <div class="modal-dialog" style="width: 80%;">
                                                        <div class="modal-content">
                                                            <?= modal_load ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>

                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="profile">
                            <div class="divider">&nbsp;</div>
                            <table width="100%" class="table table-striped table-bordered table-hover datatable" id="frenteB" >
                                <thead>
                                    <tr>
                                        <th class="sorting">CÓDIGO</th>
                                        <th class="sorting">TEXTO</th>
                                        <th class="sorting text-center" style="width: 13%">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($frenteB as $rowB) {
                                        ?>
                                        <tr class="">
                                            <td style="width: 10%" style="font-weight: bold"><?php echo substr_replace($rowB['ID_ESTRUTURA'], '', -1); ?></td>
                                            <td <?php if((strlen($row['COD']) == 3) or (strlen($row['COD']) == 4)){?> style="font-weight: bold" <? } ?>><?= $rowB['DC_ASSUNTO'] ?></td>
                                            <td class="sorting text-center">
                                                <a href="#" data-toggle="modal" data-target="#cadastrarB<?= $rowB['ID_LIVRO_ASSUNTO'] ?>"><i class="fa fa-plus-circle"></i> &nbsp;&nbsp;</a>
                                                <?php #if ($rowB['DC_ASSUNTO'] != 'FRENTE B') { ?>
                                                    <a href="#" data-toggle="modal" data-target="#editarB<?= $rowB['ID_LIVRO_ASSUNTO'] ?>"><i class="fa fa-edit text-warning"></i> &nbsp;&nbsp;</a>
                                                <?php #} ?>
                                                <?php if (($rowB['DC_ASSUNTO'] != 'FRENTE B') && ($rowB['DC_ASSUNTO'] != 'FRENTE 2')) { ?>
                                                    <a href="#" data-toggle="modal" data-target="#excluirB<?= $rowB['ID_LIVRO_ASSUNTO'] ?>"><i class="fa fa-trash-o text-danger"></i> &nbsp;&nbsp;</a>
                                                <?php } ?>

                                                <div class="modal inmodal" id="excluirB<?= $rowB['ID_LIVRO_ASSUNTO'] ?>" tabindex="-1" role="dialog"  aria-hidden="true"> 
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <i class="fa fa-remove modal-icon"></i>
                                                                <h4 class="modal-title">Excluir Registro</h4>
                                                                <small>Esse preocesso não poderá ser desfeito</small>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Tem certeza que deseja excluir o registro?</strong></p>
                                                                <h5><?= $rowB['DC_ASSUNTO'] ?></h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                                                                <button type="button" class="btn btn-danger" onClick="excluir(<?= $rowB['ID_LIVRO'] ?>, '<?= $rowB['ID_ESTRUTURA'] ?>')">excluir</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!--                                                    modal enviar arquivo-->
                                                <div class="modal fade" id="cadastrarB<?= $rowB['ID_LIVRO_ASSUNTO'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                                     data-remote="<?= SCL_RAIZ ?>professor/livro/cadastrar_assunto?id=<?= $rowB['ID_LIVRO'] ?>&est=<?= $rowB['ID_ESTRUTURA'] ?>&id_assunto=<?= $rowB['ID_LIVRO_ASSUNTO'] ?>&acao=novo"> 
                                                    <div class="modal-dialog" style="width: 80%;">
                                                        <div class="modal-content">
                                                            <?= modal_load ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="editarB<?= $rowB['ID_LIVRO_ASSUNTO'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                                     data-remote="<?= SCL_RAIZ ?>professor/livro/cadastrar_assunto?id=<?= $rowB['ID_LIVRO'] ?>&est=<?= $rowB['ID_ESTRUTURA'] ?>&id_assunto=<?= $rowB['ID_LIVRO_ASSUNTO'] ?>&acao=editar"> 
                                                    <div class="modal-dialog" style="width: 80%;">
                                                        <div class="modal-content">
                                                            <?= modal_load ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--                                                    modal enviar arquivo-->
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>


                        </div>
                        <!--frente c-->
                        <div role="tabpanel" class="tab-pane" id="frentec">
                            <div class="divider">&nbsp;</div>
                            <table width="100%" class="table table-striped table-bordered table-hover datatable" id="frenteC" >
                                <thead>
                                    <tr>
                                        <th class="sorting">CÓDIGO</th>
                                        <th class="sorting">TEXTO</th>
                                        <th class="sorting text-center" style="width: 13%">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($frenteC as $rowC) {
                                        ?>
                                        <tr class="">
                                            <td  style="width: 10%"><?php echo substr_replace($rowC['ID_ESTRUTURA'], '', -1); ?></td>
                                            <td <?php if((strlen($row['COD']) == 3) or (strlen($row['COD']) == 4)){?> style="font-weight: bold" <? } ?>><?= $rowC['DC_ASSUNTO'] ?></td>
                                            <td class="sorting text-center">
                                                <a href="#" data-toggle="modal" data-target="#cadastrarC<?= $rowC['ID_LIVRO_ASSUNTO'] ?>"><i class="fa fa-plus-circle"></i> &nbsp;&nbsp;</a>
                                                <?php #if ($rowC['DC_ASSUNTO'] != 'FRENTE C') { ?>
                                                    <a href="#" data-toggle="modal" data-target="#editarC<?= $rowC['ID_LIVRO_ASSUNTO'] ?>"><i class="fa fa-edit text-warning"></i> &nbsp;&nbsp;</a>
                                                <?php #} ?>
                                                <?php if (($rowC['DC_ASSUNTO'] != 'FRENTE C') && ($rowC['DC_ASSUNTO'] != 'FRENTE 3')) { ?>
                                                    <a href="#" data-toggle="modal" data-target="#excluirC<?= $rowC['ID_LIVRO_ASSUNTO'] ?>"><i class="fa fa-trash-o text-danger"></i> &nbsp;&nbsp;</a>
                                                <?php } ?>

                                                <div class="modal inmodal" id="excluirC<?= $rowC['ID_LIVRO_ASSUNTO'] ?>" tabindex="-1" role="dialog"  aria-hidden="true"> 
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                <i class="fa fa-remove modal-icon"></i>
                                                                <h4 class="modal-title">Excluir Registro</h4>
                                                                <small>Esse preocesso não poderá ser desfeito</small>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Tem certeza que deseja excluir o registro?</strong></p>
                                                                <h5><?= $rowC['DC_ASSUNTO'] ?></h5>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
                                                                <button type="button" class="btn btn-danger" onClick="excluir(<?= $rowC['ID_LIVRO'] ?>, '<?= $rowC['ID_ESTRUTURA'] ?>')">excluir</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!--                                                    modal enviar arquivo-->
                                                <div class="modal fade" id="cadastrarC<?= $rowC['ID_LIVRO_ASSUNTO'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                                     data-remote="<?= SCL_RAIZ ?>professor/livro/cadastrar_assunto?id=<?= $rowC['ID_LIVRO'] ?>&est=<?= $rowC['ID_ESTRUTURA'] ?>&id_assunto=<?= $rowC['ID_LIVRO_ASSUNTO'] ?>&acao=novo"> 
                                                    <div class="modal-dialog" style="width: 80%;">
                                                        <div class="modal-content">
                                                            <?= modal_load ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="editarC<?= $rowC['ID_LIVRO_ASSUNTO'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                                     data-remote="<?= SCL_RAIZ ?>professor/livro/cadastrar_assunto?id=<?= $rowC['ID_LIVRO'] ?>&est=<?= $rowC['ID_ESTRUTURA'] ?>&id_assunto=<?= $rowC['ID_LIVRO_ASSUNTO'] ?>&acao=editar"> 
                                                    <div class="modal-dialog" style="width: 80%;">
                                                        <div class="modal-content">
                                                            <?= modal_load ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--                                                    modal enviar arquivo-->
                                            </td>
                                        </tr>

                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>



            </div>
        </div>
    </div>
</div>
<script>
    $('#frenteA').dataTable({
        "sPaginationType": "full_numbers",
        "bSort": false,
        "iDisplayLength": 100
    });

    $('#frenteB').dataTable({
        "sPaginationType": "full_numbers",
        "bSort": false,
        "iDisplayLength": 100
    });
    
    $('#frenteC').dataTable({
        "sPaginationType": "full_numbers",
        "bSort": false,
        "iDisplayLength": 100
    });
</script>
<script>
    $('#myTabs a').click(function (e) {
        e.preventDefault()
        $(this).tab('show')
    });
</script>

<script>

    $(function () {
        $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
        $('.tree li.parent_li > span').on('click', function (e) {
            var children = $(this).parent('li.parent_li').find(' > ul > li');
            if (children.is(":visible")) {
                children.hide('fast');
                $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
            } else {
                children.show('fast');
                $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
            }
            e.stopPropagation();
        });
    });
</script>    
<? $this->load->view('layout/footer'); ?>