<script type="text/javascript" src="<?= SCL_JS ?>bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="<?= SCL_CSS ?>bootstrap-multiselect.css" type="text/css" />
<script>
    function limitaTextarea(valor) {
        quantidade = 134;
        total = valor.length;

        if (total <= quantidade) {
            resto = quantidade - total;
            document.getElementById('contador').innerHTML = resto;
        } else {
            document.getElementById('mensagem').value = valor.substr(0, quantidade);
        }
    };
</script>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header btn-info">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><i class="fa fa-phone-square"></i> Enviar SMS </h4>
        </div>
        <?php 

           // print_r($lista_curso);
           
         ?>
        <div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                <form  action="javascript: void(0)" method="post" enctype="multipart/form-data" id="frmfiltro" name="frmfiltro" >
                    <table class="table no-padding">
                        <tr>
                            <td style="width:20%">CURSO</td>
                            <td style="width:20%">SÉRIE</td>
                            <td style="width:20%">TURMA</td>
                        </tr>
                        <tr>
                            <td>
                                <select name="curso" id="curso" class="form-control col-xs-2">
                                    <option value=""></option>
                                    <? 
                                     
                                      foreach ($lista_curso as $item) { ?>
                                        <option value="<?= $item->CD_CURSO ?>">
                                            <?= $item->NM_CURSO_RED ?>
                                            <?= $item->NM_CURSO_RED ?>
                                        </option>
                                    <? } ?>
                                </select>
                                
                                
                            </td>
                            <td>
                                <select name="serie" id="serie" class="form-control col-xs-2">
                                    <option value=""></option>
                                </select>
                            </td>
                            <td>
                                <select name="turma" id="turma" class="form-control col-xs-2">
                                    <option value=""></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <button type="button" id="lAluno" style="border-bottom: 1px solid #fff" class="btn btn-info btn-xs"><i class="fa fa-user icon-only"></i> Alunos</button>
                                <button type="button" id="lResFin" style="border-bottom: 1px solid #fff" class="btn btn-info btn-xs"><i class="fa fa-users icon-only"></i> Responsável Financeiro</button>
                                <button type="button" id="lResAcad" style="border-bottom: 1px solid #fff" class="btn btn-info btn-xs"><i class="fa fa-users icon-only"></i> Responsável Acadêmico</button>
                            </td>
                        </tr>
                    </table>
                    &zwnj;
                </form>
            </div>
        </div>

        <div class="col-md-12">
            <div id="grdA" class="row"></div>
        </div>
    </div>
</div>
 
        
        
        <form  name="frmDvDestinatario" id="frmDvDestinatario" target="_blank" action="<?=SCL_RAIZ?>sms/enviando" method="post" >
            <div class="modal-body" id="frmmodal">
                <div class="input-group"> 
                    <span class="input-group-addon"> <i class="icon-group bigger-110"></i> Destinatário </span>
                    <select name="celular[]" id="celular" class="multiselect dropdown-toggle form-control col-sm-5" required multiple="multiple"> 
                        <? //print_r($listar); 
                      #  foreach ($listar as $r) {
                            ?>
<!--                            <option value="<?= $r['CPF_RESPONSAVEL'].':'.$r['TEL_RESPONSAVEL'].':'.$r['CD_ALUNO'] ?>"><?= $r['NM_ALUNO'] ?> | <?= $r['NM_RESPONSAVEL'] ?></option>-->
                         <? #} ?>
                    </select>
                </div> 

                <div class="input-group" style="padding:10px 0px"> 
                    <span class="input-group-addon"> <i class="icon-group bigger-110"></i> Tipo </span>
                    <select name="tipo" id="tipo" class="form-control col-sm-5" required> 
                        <option value=""></option>
                        <option value="COMUNICADO"> COMUNICADO </option>
                        <option value="COBRANÇA"> COBRANÇA FINANCEIRA</option>
                        <option value="DOCUMENTO"> COBRANÇA DE DOCUMENTOS</option>
                        <option value="REUNIÃO"> REUNIÃO ESCOLAR</option>
                        <option value="COORDENAÇÃO"> REUNIÃO COORDENAÇÃO</option>
                        <option value="PSICOLOGA"> REUNIÃO PSICOLOGA</option>
                        <option value="ORIENTAÇÃO"> REUNIÃO ORIENTAÇÃO</option>
                    </select>
                </div> 

                <div class="input-group"> 
                    <span class="input-group-addon"> <i class="icon-group bigger-110"></i> Mensagem </span>
                    <textarea onkeyup="limitaTextarea(this.value)" required name="mensagem" id="mensagem" class="form-control col-sm-5" ></textarea>
                </div> 
                <div class="input-group"> 
                    <label class="label label-warning pull-right right">Campo (caracteres restantes: <span id="contador">134</span>)</label>
                </div> 
                <div id="resultado"></div>
            </div>
            <input name="usuario" value="seculomanaus" type="hidden" />
            <input name="senha" value="20022014" type="hidden" />
            <input name="metodo" value="envio" type="hidden" />
            <div class="modal-footer">
                <button class="btn btn-default pull-left" data-dismiss="modal" id="frmarquivo_btn"><i class="fa fa-refresh"></i> Fechar </button>
                <input class="btn btn-success pull-right" type="submit" name="btnDvDestinatario" id="btnDvDestinatario" value="Enviar" >
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        //carraga o numero de celular dos alunos
        $("#lAluno").click(function() {
          //  alert("Curso:"+$("select[name=curso]").val()+" Série: "+$("select[name=serie]").val()+" Turma: "+$("select[name=turma]").val());
            $("select[id=celular]").html('Aguardando alunos...');
                    $.post("<?= SCL_RAIZ ?>sms/lista_alunos", {
                        curso: $("select[name=curso]").val(),
                        serie: $("select[name=serie]").val(),
                        turma: $("select[name=turma]").val()
                    },
                    function(valor) {
                      
                        $("select[id=celular]").html(valor);
                        $('#celular').multiselect('destroy');
                            $('#celular').multiselect({
                                enableFiltering: true,
                                includeSelectAllOption: true
                            });
                        
                    });
            
        });
    });
    
    $(document).ready(function() {
        //carraga o numero de celular dos alunos
        $("#lResFin").click(function() {
            $("select[id=celular]").html('Aguardando alunos...');
                    $.post("<?= SCL_RAIZ ?>sms/lista_responsavel_financeiro", {
                        curso: $("select[name=curso]").val(),
                        serie: $("select[name=serie]").val(),
                        turma: $("select[name=turma]").val()
                    },
                    function(valor) {
                        $("select[id=celular]").html(valor);
                        $('#celular').multiselect('destroy');
                            $('#celular').multiselect({
                                enableFiltering: true,
                                includeSelectAllOption: true
                            });
                        
                    });
            
        });
    });
    
    $(document).ready(function() {
        //carraga o numero de celular dos alunos
        $("#lResAcad").click(function() {
            $("select[id=celular]").html('Aguardando alunos...');
                    $.post("<?= SCL_RAIZ ?>sms/lista_responsavel", {
                        curso: $("select[name=curso]").val(),
                        serie: $("select[name=serie]").val(),
                        turma: $("select[name=turma]").val()
                    },
                    function(valor) {
                        $("select[id=celular]").html(valor);
                        $('#celular').multiselect('destroy');
                            $('#celular').multiselect({
                                enableFiltering: true,
                                includeSelectAllOption: true
                            });
                        
                    });
            
        });
    });
    

//    $(document).ready(function() {
//        $("#lTurma").click(function() {
//            $("#grd").html('<div class="modal-dialog">.<?= modal_load ?>.</div>');
//            $.post("<?= SCL_RAIZ ?>coordenador/professor/notas_turma", {
//                turma: $("select[name=turma]").val()
//            },
//            function(valor) {
//                $("#grd").html(valor);
//            })
//        })
//    });

    $(document).ready(function() {
        $("#lProfessor").click(function() {
            $("#grd").html('<div class="modal-dialog">.<?= modal_load ?>.</div>');
            $.post("<?= SCL_RAIZ ?>coordenador/professor/listar_professor", {
                turma: $("select[name=turma]").val()
            },
            function(valor) {
                $("#grd").html(valor);
            })
        })
    });


    $(document).ready(function() {
        /*
         Função executada ao mudar o campo select do curso, ao mudar é enviado o id do curso para
         o controller colegio e é recebido pelo método curso_série, que faz o tratamento
        */
        $("select[name=curso]").change(function() {
            $("select[id=serie]").html('Aguardando série');         
            $.post("<?= SCL_RAIZ ?>colegio/colegio/curso_serie", {
                curso: $(this).val()},
            function(valor) {
                $("select[id=serie]").html(valor);
            })
        })
        $("select[name=serie]").change(function() {
            $("select[id=turma]").html('Aguardando turma...');

            $.post("<?= SCL_RAIZ ?>colegio/colegio/serie_turma", {
                curso: $("select[name=curso]").val(),
                serie: $(this).val(),
            },
                    function(valor) {
                        $("select[id=turma]").html(valor);
                    })
        })

        //ajax que retorna os alunos da turma
     /*   $("select[name=turma]").change(
                function() {
                    $("select[id=aluno]").html('Aguardando alunos...');
                    $.post("<?= SCL_RAIZ ?>sms/teste", {
                        curso: $("select[name=curso]").val(),
                        serie: $("select[name=serie]").val(),
                        turma: $(this).val()
                    },
                    function() {

                    });
                });*/
                
                
        jQuery('#form').submit(function() {
            var dados = jQuery(this).serialize();
            jQuery.ajax({
                type: "POST",
                url: "<?= SCL_RAIZ ?>coordenador/ocorrencia/adicionar",
                data: dados,
                success: function(data)
                {
                    $(".dataTables_wrapper").html('Carregando dados');
                    setTimeout(function() {
                        $(".dataTables_wrapper").load("<?= SCL_RAIZ ?>coordenador/ocorrencia/tabela", {})
                    }, 100);
                }
            });
            $('#frmnovo').modal('hide');
            return false;
        });
    });
</script>


<script>

    $('[data-toggle="frmDESTINATARIO"]').on('click',
            function(e) {
                $('#frmDESTINATARIO').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade" id="frmDESTINATARIO"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );

//    $(document).ready(function() {
//        $('#celular').multiselect({
//            enableFiltering: true,
//            includeSelectAllOption: true
//        });
//    });
    
    
    jQuery(document).ready(function() {
        jQuery('#frmDvDestinatario').submit(function() {
            var dados = jQuery(this).serialize();

            jQuery.ajax({
                type: "POST",
                url: "<?=SCL_RAIZ?>sms/enviando",
                data: dados,
                success: function(data)
                {
                    $("#frmmodal").html(data);
                }
            });
            return false;
        });
    });

</script>
<? exit(); ?>

