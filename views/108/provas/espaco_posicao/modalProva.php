<div class="modal-dialog" style="width:90%">
    <script type="text/javascript">
        function pdf(prova) {
            $("#ifrProva").attr("src", "<?= base_url('108/impressao/index/?id=') ?>" + prova);
        }

        function questoes(prova, valorAntigo) {
            if (prova !== "") {
                $("#QPQuestao").html("");
                $("#QPPosicaoNova").html("");
                $("#QPPosicaoAntiga").html("");
                $("#QPEspaco").val(0);

                $.ajax({
                    url: "<?= site_url('108/prova_espaco_posicao/questoes') ?>",
                    method: "post",
                    data: {
                        prova: prova
                    },
                    success: function (response) {
                        $("#QPEspaco").val(0);
                        $("#QPQuestao").html(response);
                        $("#QPPosicaoNova").html(response);
                        $("#QPPosicaoAntiga").html(response);

                        $("#QPEspaco").val(valorAntigo['qtdEspaco']);
                        $("#QPQuestao").val(valorAntigo['questaoEspaco']);
                    }
                });
            }
        }

        $("#QPProva").change(function () {
            pdf($(this).val());
            questoes($(this).val());
        });

        $("#btn-trocar").click(function () {
            $("#frmValidar").html('<?= LOAD ?>');
            $.post("<?= base_url($this->session->userdata('SGP_SISTEMA') . '/prova_espaco_posicao/formManter') ?>", {
                prova: $("#QPProva").val(),
                posicaoAntiga: $("#QPPosicaoAntiga").val(),
                posicaoNova: $("#QPPosicaoNova").val(),
                questao: $("#QPQuestao").val(),
                espaco: $("#QPEspaco").val()
            },
            function (data) {
                $("#frmValidar").html(data['mensagem']);

                if (data['success']) {
                    pdf($("#QPProva").val());
                    questoes($("#QPProva").val(), data);
                }
            }, 'json');
        });
    </script>

    <div class="modal-content">        
        <div class="modal-body">         
            <div class="row">
                <div class="col-sm-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"> PROVA E VERSÕES</h3>
                        </div>

                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-xs-12 form-group">                                
                                    <label>PROVA</label>                            
                                    <select id="QPProva" name="prova" class="form-control">
                                        <option></option>
                                        <? foreach ($versoes as $vs) { ?>
                                            <option value="<?= $vs['CD_PROVA'] ?>"><?= $vs['CD_PROVA'] . ' - ' . $vs['TIPO_VERSAO'] ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-xs-12"><label>ADICIONAR ESPAÇO</label></div>

                                <div class="col-xs-7">
                                    <select id="QPQuestao" name="questao" class="form-control">
                                        <option value=""></option>
                                    </select>
                                </div>

                                <div class="col-xs-5">
                                    <input type="number" min="0" id="QPEspaco" name="espaco" class="form-control">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-xs-12">
                                    <label>TROCAR POSIÇÃO QUESTÃO</label>                            
                                </div>

                                <div class="col-xs-5">
                                    <select id="QPPosicaoAntiga" name="posicaoAntiga" class="form-control">
                                        <option value=""></option>
                                    </select>
                                </div>

                                <div class="col-xs-2 text-center">
                                    <i class="fa fa-exchange fa-lg"></i>                                
                                </div>

                                <div class="col-xs-5">
                                    <select id="QPPosicaoNova" name="posicaoNova" class="form-control">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>

                            <hr/>

                            <button id="btn-trocar" class="form-control">
                                <i class="fa fa-save"></i> Salvar
                            </button>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div id="frmValidar">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-9">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <h3 class="panel-title">ADICIONAR ESPAÇOS E ALTERAR POSIÇÃO DAS QUESTÕES NA PROVA</h3>
                        </div>

                        <div class="panel-footer">
                            <iframe href="" id="ifrProva" width="100%" height="450px" frameborder="0" >                                
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
    </div>
</div>