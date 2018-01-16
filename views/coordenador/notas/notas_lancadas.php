<?php $this->load->view('layout/header'); ?>
<script type="text/javascript">
$(document).ready(function(){
    $("select[name=curso]").change(function(){
    $("#monta_serie").html('Aguardando série');
    $.post("<?=SCL_RAIZ?>colegio/colegio/curso_serie",{
                      curso:$(this).val()},
    function(valor){
        $("#monta_serie").html(valor);
        })
    })
	
})
</script>
<div id="content">
    <div class="row">
        
        <div class="col-xs-12">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <div class="panel-body">
                        <form onsubmit="return false;" class="form-horizontal form-bordered" method="post" action="#">
                            <div class="form-group">
                                
                                <div class="col-md-4">
                                    
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">
                                                <i class="fa fa-users"></i> Curso
                                            </button>
                                        </span>
                                        
                                        <select name="curso" id="curso" class="form-control">
                                            <option value="0">Selecione o Cursos</option>
                                            <?php foreach($curso as $item) { ?>
                                                <option value="<?=$item['CD_CURSO']?>"><?=$item['NM_CURSO']?></option>
                                            <?php } ?>  
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">
                                                <i class="fa fa-users"></i> Série
                                            </button>
                                        </span>
                                        <div name="monta_serie" id="monta_serie"></div>
                                        <span class="input-group-btn">
                                        <button id="btn_pesquisar"  name="btn_pesquisar" class="btn btn-info" type="button">Pesquisar</button>
                                        </span>
                                    </div>
                                    
                                </div>
                            </div>    
                        </form>
                    </div>
                </div>
            </div>
                
        </div>
        <div class="col-xs-12">
            <div id="load"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#btn_pesquisar").click(function() { 
            $("#load").html('<?=modal_load ?>');
            $.post("<?=SCL_RAIZ ?>coordenador/nota/pesquisar_turmas", {
                curso: $("#curso").val(),
                serie: $("#cd_serie").val()
            },
            function(valor) {
                $("#load").html(valor);
            })
        })

  
})
</script>
<?php $this->load->view('layout/footer'); ?>