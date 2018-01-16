<?php $this->load->view('layout/header'); ?>
<script type="text/javascript">
function buscar_serie(){ 
      var curso = $('#curso').val();  //codigo do estado escolhido
      //se encontrou o estado
      if(curso){
        $("div[id=serie]").html('<div class="progress progress-striped active"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="50" style="width:100%"> Carregando Dados</div></div>');
        var url = '<?=SCL_RAIZ?>professor/aulas/curso_serie?curso='+curso;  //caminho do arquivo php que irá buscar as cidades no BD
        $.get(url, function(valor) { 
          $("div[id=serie]").html(valor);
        });
      }
    }
</script>        
<div id="content">
    <div class="row">
        <div class="col-xs-12"><?=validation_errors();?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Cadastrar Novo Conteúdo : <?=$disciplina->NM_DISCIPLINA?></h3>
                    <div class="panel-toolbar">
                        <div class="btn-group">
                            <button onclick="history.go(-1)" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" type="button">Voltar</button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="space-12"></div>
                    <form id="cadastrar" name="cadastrar" class="form-bordered" method="post" action="<?=SCL_RAIZ?>professor/aulas/cadastrar_conteudo/<?=$this->uri->segment(4)?>">
                            <input type="hidden" value="1" name="acao"/>
                            <div class="form-group">
                                <label for="example-nf-email">Curso</label>
                                <select id="curso" name="curso" class="form-control" size="1" onchange="buscar_serie()">
                                    <option value="">Selecione o Curso</option>
                                    <?php foreach ($curso as $c) { ?>
                                    <option value="<?=$c['CD_CURSO']?>">  <?=$c['NM_CURSO']?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <div id="serie"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="example-nf-email">Titulo do Conteúdo</label>
                                <input type="text"  class="form-control" name="titulo" id="titulo">
                            </div>
                            

                            <div class="form-group form-actions">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-user"></i> Cadastrar</button>
                                <button class="btn btn-warning" type="reset" onclick="history.go(-1)"><i class="fa fa-repeat"></i> Cancelar</button></div>
                        </form>
                    
                </div>
          
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('layout/footer'); ?>
