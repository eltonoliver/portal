<div class="modal-dialog modal-lg">    
    <div class="modal-content">        
        <div class="color-line"></div>

        <div class="modal-header" style="padding: 20px 30px">
            <?php if (!empty($titulo)): ?>
                <h4 class="modal-title text-center"><?= $titulo ?></h4>            
            <?php endif; ?>
        </div>

        <div class="modal-body" style="height: 350px; overflow-y: auto">
            <?php if (!empty($conteudo)): ?>
                <div class="form-group">
                    <fieldset>
                        <legend>Assunto</legend>

                        <?php if (empty($conteudo)): ?>
                            <strong>Nenhum tema e conteúdo foram informados.</strong>
                        <?php else: ?>
                            <strong><?= $conteudo->DC_TEMA ?></strong>
                            <ul>
                                <li><?= strip_tags($conteudo->DC_CONTEUDO->read($conteudo->DC_CONTEUDO->size())) ?></li>
                            </ul>
                        <?php endif; ?>
                    </fieldset>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <fieldset>
                    <legend>
                        Questão <?= $operacao != "I" ? ":: " . $questao->CD_QUESTAO : "" ?>
                    </legend>

                    <?= $descricao ?>                    
                </fieldset>
            </div>            
        </div>

        <div class="modal-footer">
            <?php if ($operacao == "I"): ?>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>

                <button type="button" class="btn btn-success pull-right" onclick="salvar('P')">
                    <i class="fa fa-save"></i> Salvar e Nova Preenchida
                </button>

                <button type="button" class="btn btn-danger pull-right" onclick="salvar('Z')">
                    <i class="fa fa-save"></i> Salvar e Nova em Branco
                </button>                    
            <?php elseif ($operacao == "E"): ?>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                    Cancelar
                </button>

                <button type="submit" class="btn btn-success pull-right" onclick="salvar('')">
                    <i class="fa fa-save"></i> <?= LBL_BTN_SALVAR ?>
                </button>
            <?php elseif ($operacao == "D"): ?>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">
                    Cancelar
                </button>

                <button type="button" class="btn btn-danger pull-right" id="btnConfirmarExclusao">
                    <i class="fa fa-trash"></i> <?= LBL_BTN_EXCLUIR ?>
                </button>
            <?php else: ?>
                <small class="pull-left" style="text-align: left">
                    <p><strong>Cadastrada por: </strong><?= $questao->CADASTROU ?></p>
                    <p><strong>Data: </strong><?= date('d/m/Y', strtotime($questao->CADASTROU_EM)) ?></p>
                </small>

                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if ($operacao == "D"): ?>
    <script type="text/javascript">
        $('#btnConfirmarExclusao').click(function () {
            swal({
                title: "Importante",
                text: "Deseja realmente excluir essa questão do banco?",
                type: "warning",
                confirmButtonText: "Sim",
                cancelButtonText: "Não",
                closeOnCancel: true,
                closeOnConfirm: false,
                showCancelButton: true,
                showLoaderOnConfirm: true
            },
            function () {
                window.location = "<?= site_url("108/questoes/frmQuestaoDeletar/" . $questao->CD_QUESTAO) ?>";
            });
        });
    </script>
<?php endif; ?>