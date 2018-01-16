<? $this->load->view('home/header'); ?>
<script type='text/javascript'>//<![CDATA[
 
$(window).load(function(){
    $(function(){
        $(".btn-toggle").click(function(e){
            e.preventDefault();
            el = $(this).data('element');
            $(el).toggle();
        });

    });
});//]]> 

</script>

<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-footer col-xs-12" id="BuscaAvancada" >
                <form role="form" class="form-inline">
                  
                    <div class="form-group col-xs-2">
                        CURSO<br/>
                        <select name="FTCurso" id="FTCurso" class="form-control m-b" style="width:200px">
                            <option value=""></option>
                            <? 
                            
                            foreach ($curso as $row) { ?>
                            <option value="<?= $row['CD_CURSO'] ?>"><?=$row['NM_CURSO_RED'] ?></option>
                            <? } ?>
                        </select>
                    </div> 
                    <div class="form-group col-xs-2">
                        SÉRIE<br/>
                        <select name="FTSerie" id="FTSerie" class="form-control m-b" style="width:200px">
                            <option value=""></option>
                        </select>
                    </div> 
                    <div class="form-group input-daterange col-xs-2">
                        DATA DE REALIZAÇÃO<br/>
                        <select name="FTData" id="FTData" class="form-control m-b" style="width:200px">
                            <option value=""></option>
                        </select>
                    </div>
                    
                    <div class="form-group col-xs-3">
                        Nº PROVA<br/>
                        <select name="FTProva" id="FTProva" class="form-control m-b" style="width:200px">
                            <option value=""></option>
                        </select>
                    </div>
         
                    <div class="input-group col-xs-2">
                        <br><br><br><br>
                        <span class="input-group-btn">
                            <button onclick="txtFiltrar()" type="button" id="" class="btn btn-labeled btn-info">
                                <span class="btn-label"><i class="fa fa-search"></i></span>
                                Filtrar
                            </button>
                        </span>
                    </div>
                </form>
            </div>
            
            
            <div class="panel-body table-responsive col-lg-12" id="tblFiltro">
                <small>Faça primeiro o filtro</small>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    var cursoEscolhido = 0;
    var serieEscolhida = 0;
    var filtroAtivo = 0;
    
    $("select[id=FTCurso]").change(function() {
        cursoEscolhido = $(this).val();
        filtroAtivo = 0;
        $("select[id=FTSerie]").html('<option>Carregando</option>');
        $.post("<?= base_url('/comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function(valor) {
            $("select[id=FTSerie]").html(valor);
        });
    });
    
    $("select[name=FTSerie]").change(function() {
            filtroAtivo = 0;
            serieEscolhida = $(this).val();
            $("select[id=FTData]").html('<option>Carregando</option>');
            $.post("<?=  base_url('/comum/combobox/data') ?>", {          
                curso: cursoEscolhido,
                serie: serieEscolhida
            },
            function(valor) {
                $("select[id=FTData]").html(valor);
            });  
    });
   
    
    $("select[name=FTData]").change(function() {
            filtroAtivo = 0;
            $("select[id=FTProva]").html('<option>Carregando</option>');
            $.post("<?=  base_url('/comum/combobox/prova') ?>", {
                curso: cursoEscolhido,
                serie: serieEscolhida,
                data: $(this).val()
            },
            function(valor) {
                $("select[id=FTProva]").html(valor);
            }); 
    });
    
    $("select[name=FTProva]").change(function() {
            filtroAtivo = 0;
    });

         
    //setInterval('atualiza()', 1000);

    function atualiza(){

       if (filtroAtivo==1){
            $.post("<?=  base_url('/108/prova_online/verificarRespondidas') ?>", {
                    prova: $("#FTProva").val()
            },
            function(valor) {
                if (valor != 0){
                    txtFiltrar();
                } 
           }); 
        }  
    }


    function txtFiltrar() {

        if (($("#FTCurso").val() !== '') && ($("#FTSerie").val() !== '') && ($("#FTData").val() !== '') && ($("#FTProva").val() !== '')){
            $("#tblFiltro").html('<?= LOAD ?>');
            $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_online/grdRegistro') ?>", {
                filtro: 0,
                prova: $("#FTProva").val()
            },
            function(valor) {
                $("#tblFiltro").html(valor);
                filtroAtivo = 1;
            });
        }else{
            swal("ATENÇÃO!","Selecione todas as opções de filtro para concluir a busca!","warning");
        }
    };

    function txtNumProvaFiltrar() {
        $("#tblFiltro").html('<?= LOAD ?>');
        $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_online/grdRegistro') ?>", {
            filtro: 1,
            numProva: $("#avalNumProva").val()
        },
        function(valor) {
            $("#tblFiltro").html(valor);
        });
    };
    
</script>
<? $this->load->view('home/footer'); ?>