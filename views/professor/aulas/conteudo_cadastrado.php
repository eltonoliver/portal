<?php $this->load->view('layout/header'); ?>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
function excluir(id,url){
    decisao = confirm("Tem certeza que deseja excluir o resgistro?\n"+
                       "o Proceso não tem volta e apagará todos os slides cadastrados");
    if (decisao){
        var url="<?=SCL_RAIZ?>professor/excluir_conteudo/"+id+"/"+url;
        window.location.href=url;
    } 
}
</SCRIPT>

<div id="content">
    <div class="row">
        <div class="col-xs-12">
             <?php 
                    echo get_msg('msgok'); 
                    echo get_msg('msgerro'); 
                ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Lista de conteúdo: <?=$disciplina->NM_DISCIPLINA?></h3>
                    <div class="panel-toolbar">
                        <div class="btn-group">
                            <a href="<?=SCL_RAIZ?>professor/aulas/index" class="btn btn-warning">Voltar</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-sorting table-striped table-hover datatable" width="100%" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th style="width: 3%">ID</th>
                                <th style="width: 40%">Titulo</th>
                                <th style="width: 40%">Informações</th>
                                <th class="text-center" style="width: 17%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  foreach ($conteudo as $c) { ?>
                            <tr>
                                <td><?=$c['CD_CONTEUDO'] ?></td>
                                <td><?=$c['TITULO'] ?></td>
                                <td><?=$c['NM_DISCIPLINA'] ?> - <?=$c['NM_CURSO'] ?> - <?=$c['NM_SERIE'] ?></td>
                                <td class="text-center">
                                    <button onclick="excluir(<?=$c['CD_CONTEUDO'] ?>,<?=$this->uri->segment(3)?>)" class="btn btn-danger"  type="button" data-original-title="Excluir Conteúdo" data-placement="top" data-toggle="tooltip"><i class="fa fa-trash-o"></i></button>
                                    <a data-toggle="modal" href="#lista_slide<?=$c['CD_CONTEUDO']?>" class="btn btn-info"  type="button" data-original-title="Visualizar Slides" data-placement="top" data-toggle="tooltip"><i class="fa fa-search"></i></a>
                                    
                                </td>
                            </tr>
                            <!--MOSTRA A LISTA DE SLIDES CADASTRADO-->
                            <div class="modal fade" id="lista_slide<?=$c['CD_CONTEUDO']?>" data-backdrop="static" data-keyboard="false" data-remote="<?=SCL_RAIZ?>professor/slide/lista_slide/<?=$c['CD_CONTEUDO']?>">
                                <div class="modal-dialog" style="width:50%">
                                    <div class="modal-content"><?=modal_load?>  
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
          
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('layout/footer'); ?>
