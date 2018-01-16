<div class="modal-dialog" style="width:90%">
    <div class="modal-content">
        <div class="modal-body">         
            <div class="row">
                <div class="col-sm-3">
                    <div class="panel panel-blue">
                        <div class="panel-heading">
                            <h3 class="panel-title"> PROVA E VERSÕES</h3>
                        </div>
                        <script type="text/javascript">
                            function btnPesquisarProvaPdf(id) {
                               $("#ifrProva").attr("src", "<?=base_url('108/impressao/index/?id=')?>"+id+"");
                            };
                            
                            function btnConfirmaDespacho() {
                                $("#frmValidar").html('<?= LOAD ?>');
                                $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/prova_espaco/frmManterQuestaoProva') ?>", {
                                    txtPQOperacao: $("#PQOperacao").val(),
                                    txtPQProva: $("#PQProva").val(),
                                    txtPQPosicao: $("#PQPosicao").val(),
                                    txtPQValor: $("#PQEspaco").val(),
                                },
                                function(data) {
                                    btnPesquisarProvaPdf($("#PQProva").val());
                                   $("#frmValidar").html(data);
                                   
                                });
                            };
                        </script>
                        <div class="panel-footer">
                            <label>PROVA</label>
                            <input type="hidden" id="PQOperacao" value="OE">
                            <select id="PQProva" name="PQProva" class="form-control" onchange="btnPesquisarProvaPdf(this.value)">
                                <option></option>
                                <? foreach($listar as $vs){ ?>
                                    <option value="<?=$vs['CD_PROVA']?>"><?=$vs['CD_PROVA'].' - '.$vs['TIPO_VERSAO']?></option>
                                <? } ?>
                            </select>
                            <label>POSIÇÃO DA QUESTÃO</label>
                            <input id="PQPosicao" name="PQPosicao" class="form-control" type="number" VALUE="20" min="0" max="60">
                            <!--select class="form-control">
                                <option></option>
                            </select-->
                            <label>Nº DE ESPAÇOS</label>
                            <input id="PQEspaco" name="PQEspaco" class="form-control" type="number" min="0" max="60">
                            <hr />
                            <button class="form-control" onclick="btnConfirmaDespacho()">
                                <i class="fa fa-save"></i> Salvar
                            </button>
                            <div id="frmValidar"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"> CORRIGIR ESPAÇOS DAS PROVAS</h3>
                        </div>
                        <div class="panel-footer">
                            <iframe href="" id="ifrProva" width="100%" height="450px" frameborder="0" ></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">  Fechar</button>
        </div>
    </div>
</div>