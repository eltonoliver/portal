<? $this->load->view('home/header'); ?>
<script src="<?= base_url('libs/tinymce/tinymce.min.js') ?>"></script>

<script type="text/javascript">
    $(document).ready(function () {
        //disparar mensagens de aviso
        var tipo = "<?= $tipo ?>";
        var mensagem = "<?= $mensagem ?>";
        if (tipo !== "" && mensagem !== "") {
            swal({
                title: "Mensagem",
                text: mensagem,
                type: tipo,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ok",
                closeOnConfirm: true
            });
        }
    });
</script>

<div class="content animate-panel">    
    <div class="row projects">
        <div class="hpanel hgreen">

            <form id="formulario" action="<?= base_url("108/questoes/frmQuestaoSalvar") ?>" method="post">                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Curso</label>
                                <select name="FTCurso" id="FTCurso" class="form-control lista-pesquisavel" >
                                    <option value=""></option>
                                    <? foreach ($cursos as $row) { ?>
                                        <option <?= set_value("FTCurso", $questao->CD_CURSO) == $row['CD_CURSO'] ? 'selected="selected"' : '' ?> value="<?= $row['CD_CURSO'] ?>">
                                            <?= $row['NM_CURSO_RED'] ?>
                                        </option>
                                    <? } ?>
                                </select>
                            </div>
                        </div>                          

                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Série</label>
                                <select name="FTSerie" id="FTSerie" class="form-control lista-pesquisavel" >
                                </select>
                            </div>
                        </div>                             

                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Disciplina</label>
                                <select name="FTDisciplina" id="FTDisciplina" class="form-control lista-pesquisavel" >
                                </select>
                            </div>
                        </div>                             

                        <div class="col-xs-3">
                            <div class="form-group">
                                <label>Professor</label>
                                <select name="FTProfessor" id="FTProfessor" class="form-control lista-pesquisavel" >
                                </select>
                            </div>
                        </div>                             
                    </div>
                </div>

                <div class="panel-body">
                    <div class="col-xs-4 border-right">
                        <div class="form-group">
                            <label>Tema</label>
                            <select name="FTTema" id="FTTema" class="form-control lista-pesquisavel" >
                            </select>    
                        </div>

                        <div class="form-group">
                            <label>Conteúdo</label>
                            <select name="FTConteudo" id="FTConteudo" class="form-control lista-pesquisavel" >
                            </select>    
                        </div>

                        <div class="form-group">
                            <label>Tipo de Questão</label>
                            <select name="FTTipoQuestao" id="FTTipoQuestao" class="form-control lista-pesquisavel" >
                                <option></option>
                                <option value="D" <?= $questao->FLG_TIPO == 'D' ? 'selected="selected"' : '' ?>>DISCURSIVA</option>
                                <option value="O" <?= $questao->FLG_TIPO == 'O' ? 'selected="selected"' : '' ?>>OBJETIVA</option>
                            </select>
                        </div>                        

                        <div class="form-group">
                            <label>Dificuldade</label>
                            <select name="FTNivel" id="FTNivel" class="form-control lista-pesquisavel" >
                                <option></option>
                                <option <?= $questao->NR_DIFICULDADE == 1 ? 'selected="selected"' : '' ?> value="1">FÁCIL</option>
                                <option <?= $questao->NR_DIFICULDADE == 2 ? 'selected="selected"' : '' ?> value="2">MÉDIA</option>
                                <option <?= $questao->NR_DIFICULDADE == 3 ? 'selected="selected"' : '' ?> value="3">DIFÍCIL</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-8 border-left">
                        <div class="form-group">
                            <label>Questão</label>
                            <textarea spellcheck="true" name="avalQuestao" id="avalQuestao" class="form-control BLCQuestao" rows="10">
                                <?= set_value('avalQuestao', isset($questao->DC_QUESTAO) ? $questao->DC_QUESTAO->read($questao->DC_QUESTAO->size()) : ''); ?>
                            </textarea>
                        </div>                                                                       

                        <div id="campos-objetiva" class="form-group" style="<?= !empty($alternativas) ? "" : "display: none" ?>">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="text-center col-xs-1">Opção Correta</th>
                                        <th class="col-xs-11" style="vertical-align: middle">Alternativas</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php for ($i = 1; $i < 6; $i++): ?>
                                        <?php
                                        $alternativa = null;

                                        if (isset($alternativas)) {
                                            $alternativa = $alternativas[$i - 1];
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-center bg-light-soft" style="vertical-align: middle">
                                                <input type="radio" name="avalCorreta" id="avalCorreta" value="<?= $i ?>" <?= !empty($alternativa) !== null && $alternativa->FLG_CORRETA == true ? "checked" : "" ?>>
                                            </td>

                                            <td>
                                                <textarea spellcheck="true" name="avalQuestaoOpcao<?= $i ?>" id="avalQuestaoOpcao<?= $i ?>" class="form-control BLCQuestao" rows="5">
                                                    <?= set_value("avalQuestaoOpcao" . $i, !empty($alternativa) ? $alternativa->DC_OPCAO->read($alternativa->DC_OPCAO->size()) : ''); ?>
                                                </textarea>
                                            </td>
                                        </tr>                                        
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>                        
                    </div>

                    <input type="hidden" id="FTCodQuestao" name="FTCodQuestao" value="<?= $questao->CD_QUESTAO ?>" />
                    <input type="hidden" id="operacao" name="operacao" value="<?= $operacao ?>" />
                    <input type="hidden" id="modoSalvar" name="modoSalvar"
                </div>                                
            </form>
        </div>

        <div class="panel-footer">
            <a class="btn btn-danger" type="button" href="<?= base_url('108/questoes') ?>"><i class="fa fa-backward"></i> Voltar</a>
            <button class="btn btn-success btnSalvarDados pull-right" type="button" onclick="confirmar()"><i class="fa fa-save"></i> Salvar</button>
        </div>
    </div>    

    <div id="modal-previsualizar" class="modal fade in">        
    </div>
</div>

<script type="text/javascript">
    function validar() {
        //preencher valores das areas de texto
        tinymce.triggerSave();
        var campos = "";
        var curso = $('#FTCurso').val();
        var serie = $('#FTSerie').val();
        var disciplina = $('#FTDisciplina').val();
        var professor = $('#FTProfessor').val();
        var tema = $('#FTTema').val();
        var conteudo = $('#FTConteudo').val();
        var tipo = $('#FTTipoQuestao').val();
        var dificuldade = $('#FTNivel').val();
        var questao = $('#avalQuestao').val();
        var alternativa1 = $('#avalQuestaoOpcao1').val();
        var alternativa2 = $('#avalQuestaoOpcao2').val();
        var alternativa3 = $('#avalQuestaoOpcao3').val();
        var alternativa4 = $('#avalQuestaoOpcao4').val();
        var alternativa5 = $('#avalQuestaoOpcao5').val();
        var correta = $('input[name=avalCorreta]:checked').val();
        var validacao = true;
        //checa se cada campo foi preenchido                
        if (curso === "" || curso === null) {
            campos += "Curso, ";
        }

        if (serie === "" || serie === null) {
            campos += "Série, ";
        }

        if (disciplina === "" || disciplina === null) {
            campos += "Disciplina, ";
        }

        if (professor === "" || professor === null) {
            campos += "Professor, ";
        }

        if (tema === "" || tema === null) {
            campos += "Tema, ";
        }

        if (conteudo === "" || conteudo === null) {
            campos += "Conteúdo, ";
        }

        if (tipo === "" || tipo === null) {
            campos += "Tipo de Questão, ";
        }

        if (dificuldade === "" || dificuldade === null) {
            campos += "Dificuldade, ";
        }

        if (questao === "" || questao === null) {
            campos += "Questão, ";
        }

        if (tipo === 'O') {
            if (alternativa1 === "" || alternativa1 === null) {
                campos += "Alternativa 1, ";
            }
            if (alternativa2 === "" || alternativa2 === null) {
                campos += "Alternativa 2, ";
            }
            if (alternativa3 === "" || alternativa3 === null) {
                campos += "Alternativa 3, ";
            }
            if (alternativa4 === "" || alternativa4 === null) {
                campos += "Alternativa 4, ";
            }
            if (alternativa5 === "" || alternativa5 === null) {
                campos += "Alternativa 5, ";
            }
            if (correta === "" || correta === null || correta === undefined) {
                campos += "Opção Correta, ";
            }
        }
        campos = campos.substring(0, campos.lastIndexOf(','));
        if (campos !== "") {
            validacao = false;
            swal({
                title: "AVISO",
                text: "Por favor, preencha os seguintes campos do formulário:\n\n" + campos,
                type: "warning",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ok",
                closeOnConfirm: true});
        }

        return validacao;
    }

    //função que ao clicar em salvar valida e exibe pre-visualização.
    function confirmar() {
        if (validar()) {
            $("#modal-previsualizar").modal("show");
            $("#modal-previsualizar").html('<?= LOAD ?>');
            tinymce.triggerSave();
            var dados = $("#formulario").serialize();
            $.ajax({
                url: "<?= site_url("108/questoes/modalPrevisualizar") ?>",
                method: "post",
                data: dados,
                success: function (data) {
                    $("#modal-previsualizar").html(data);
                }
            });
        }
    }

    //irá enviar o formulário
    function salvar(modo) {
        //modo pode ser Z para form de cadastro zerado
        //modo pode ser P para form de cadastro com dados de turma e disciplina preenchido
        $("#modoSalvar").val(modo);
        $("#formulario").submit();
    }

    //ocultar ou exibir as alternativas
    $("#FTTipoQuestao").change(function () {
        $("#campos-objetiva").hide();
        if ($("#FTTipoQuestao").val() === 'O') {
            $("#campos-objetiva").show();
        }
    });
    $("select[id=FTCurso]").change(function () {
        $("select[id=FTSerie]").html('');
        $("select[id=FTSerie]").select2('val', "");
        $("select[id=FTDisciplina]").html('');
        $("select[id=FTDisciplina]").select2('val', "");
        $("select[id=FTProfessor]").html('');
        $("select[id=FTProfessor]").select2('val', "");
        $("select[id=FTTema]").html('');
        $("select[id=FTTema]").select2('val', "");
        $("select[id=FTConteudo]").html('');
        $("select[id=FTConteudo]").select2('val', "");
        $.post("<?= base_url('comum/combobox/serie') ?>", {
            curso: $(this).val()
        },
        function (valor) {
            $("select[id=FTSerie]").html(valor);
        });
    });
    $("select[id=FTSerie]").change(function () {
        $("select[id=FTDisciplina]").html('');
        $("select[id=FTDisciplina]").select2('val', "");
        $("select[id=FTProfessor]").html('');
        $("select[id=FTProfessor]").select2('val', "");
        $("select[id=FTTema]").html('');
        $("select[id=FTTema]").select2('val', "");
        $("select[id=FTConteudo]").html('');
        $("select[id=FTConteudo]").select2('val', "");
        $.post("<?= base_url('comum/combobox/disciplina') ?>", {
            curso: $("select[id=FTCurso]").val(),
            serie: $("select[id=FTSerie]").val()
        },
        function (valor) {
            $("select[id=FTDisciplina]").html(valor);
        });
    });
    $("select[id=FTDisciplina]").change(function () {
        $("select[id=FTProfessor]").html('');
        $("select[id=FTProfessor]").select2('val', "");
        $("select[id=FTTema]").html('');
        $("select[id=FTTema]").select2('val', "");
        $("select[id=FTConteudo]").html('');
        $("select[id=FTConteudo]").select2('val', "");
        $.post("<?= base_url('comum/combobox/professor') ?>", {
            curso: $("select[id=FTCurso]").val(),
            disciplina: $("select[id=FTDisciplina]").val(),
        },
                function (valor) {
                    $("select[id=FTProfessor]").html(valor);
                });
        $.post("<?= base_url('comum/combobox/tema') ?>", {
            curso: $("select[id=FTCurso]").val(),
            serie: $("select[id=FTSerie]").val(),
            disciplina: $("select[id=FTDisciplina]").val()
        },
        function (valor) {
            $("select[id=FTTema]").html(valor);
        });
    });
    $("select[id=FTTema]").change(function () {
        $("select[id=FTConteudo]").html('');
        $("select[id=FTConteudo]").select2('val', "");
        $.post("<?= base_url('comum/combobox/tema_conteudo') ?>", {
            tema: $("select[id=FTTema]").val()
        }, function (valor) {
            $("select[id=FTConteudo]").html(valor);
        });
    });
</script> 

<script type="text/javascript">
    tinymce.init({
        mode: "textareas",
        language: "pt_BR",
        editor_selector: "BLCQuestao",
        relative_urls: false,
        remove_script_host: false,
        document_base_url: "<?= site_url() ?>",
        plugins: [
            "tiny_mce_wiris advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        menubar: false,
        toolbar: [
            'bold italic underline strikethrough | subscript superscript | bullist numlist'
        ],
        paste_data_images: true,
        paste_convert_word_fake_lists: false,
        images_upload_url: "<?= site_url("108/upload/do_upload") ?>",
        images_upload_base_path: "<?= site_url("upload/imagem_questao/") ?>",
        init_instance_callback: function (editor) {
            editor.on('PastePreProcess', function (e) {
                $.ajax({
                    url: "<?= site_url("108/questoes/limparTags") ?>",
                    method: "post",
                    data: {
                        descricao: e.content
                    },
                    dataType: "text",
                    success: function (response) {
                        tinymce.activeEditor.insertContent(response);
                    }
                });
                e.content = "";
            });

            editor.on('ObjectResized', function (e) {
                $(e.target).attr("width", e.width);
                $(e.target).attr("height", e.height);
            });
        }
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        var curso = <?= !isset($questao->CD_CURSO) ? 0 : $questao->CD_CURSO ?>;
        var serie = <?= !isset($questao->ORDEM_SERIE) ? 0 : $questao->ORDEM_SERIE ?>;
        var disciplina = <?= !isset($questao->CD_DISCIPLINA) ? 0 : $questao->CD_DISCIPLINA ?>;
        var professor = <?= !isset($questao->CD_PROFESSOR) ? 0 : $questao->CD_PROFESSOR ?>;
        var tema = <?= !isset($conteudo->CD_TEMA) ? 0 : $conteudo->CD_TEMA ?>;
        var conteudo = <?= !isset($conteudo->CD_CONTEUDO) ? 0 : $conteudo->CD_CONTEUDO ?>;
        $(".lista-pesquisavel").select2();
        //popular serie
        $.post("<?= base_url('comum/combobox/serie') ?>", {
            curso: curso,
            selecionado: serie
        },
        function (valor) {
            $("select[id=FTSerie]").html(valor);
            $("select[id=FTSerie]").select2("val", serie);
        });
        //popular disciplina
        $.post("<?= base_url('comum/combobox/disciplina') ?>", {
            curso: curso,
            serie: serie,
            selecionado: disciplina
        },
        function (valor) {
            $("select[id=FTDisciplina]").html(valor);
            $("select[id=FTDisciplina]").select2("val", disciplina);
        });
        //popular Professor
        $.post("<?= base_url('comum/combobox/professor') ?>", {
            curso: curso,
            disciplina: disciplina,
            selecionado: professor
        },
        function (valor) {
            $("select[id=FTProfessor]").html(valor);
            $("select[id=FTProfessor]").select2("val", professor);
        });
        //popular Tema
        $.post("<?= base_url('comum/combobox/tema') ?>", {
            curso: curso,
            serie: serie,
            disciplina: disciplina,
            selecionado: tema
        },
        function (valor) {
            $("select[id=FTTema]").html(valor);
            $("select[id=FTTema]").select2("val", tema);
        });
        //popular Conteúdo
        $.post("<?= base_url('comum/combobox/tema_conteudo') ?>", {
            tema: tema,
            selecionado: conteudo
        },
        function (valor) {
            $("select[id=FTConteudo]").html(valor);
            $("select[id=FTConteudo]").select2("val", conteudo);
        });
        $(".lista-pesquisavel").select2();
    });
</script> 

<? $this->load->view('home/footer'); ?>