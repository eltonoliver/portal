<div class="modal-dialog modal-lg">
    <div class="color-line"></div>

    <div class="modal-content">
        <form id="formulario-registro" action="<?= site_url($this->session->userdata('SGP_SISTEMA') . '/prova/frmManterProvas') ?>" method="post">
            <div class="modal-header" style="padding: 15px">
                <h5 class="modal-title text-right">DETALHES DA PROVA</h5>
            </div>

            <div class="modal-body">             
                <div class="row">
                    <div class="form-group col-xs-4">
                        <label>TIPO DE PROVA</label>
                        <input class="form-control" disabled="" value="<?= $calendario->DC_TIPO_PROVA ?>">
                    </div>

                    <div class="form-group col-xs-4">
                        <label>CURSO</label>
                        <input class="form-control" disabled="" value="<?= $calendario->NM_CURSO_RED ?>">                        
                    </div>                    

                    <div class="form-group col-xs-4">
                        <label>SÉRIE</label>
                        <input class="form-control" disabled="" value="<?= $calendario->NM_SERIE ?>">                        
                    </div>                                        
                </div>

                <div class="row">
                    <div class="form-group col-xs-4">
                        <label>TURMA</label>
                        <input class="form-control" disabled="" value="<?= $calendario->CD_TURMA ?>">                        
                    </div>

                    <div class="form-group col-xs-4">
                        <label>DISCIPLINA</label>
                        <?php if ($calendario->CD_DISCIPLINA == 0): ?>
                            <input class="form-control" disabled="" value="<?= $calendario->OBSERVACAO ?>">
                        <?php else: ?>
                            <input class="form-control" disabled="" value="<?= $calendario->NM_DISCIPLINA ?>">                            
                        <?php endif; ?>
                    </div>                    

                    <div class="form-group col-xs-4">
                        <label>BIMESTRE</label>
                        <input class="form-control" disabled="" value="<?= $calendario->BIMESTRE . "º BIMESTRE" ?>">                        
                    </div>                                        
                </div>

                <div class="row">
                    <div class="form-group col-xs-4">
                        <label>NOTA</label>
                        <input class="form-control" disabled="" value="<?= $calendario->DC_TIPO_NOTA ?>">                        
                    </div>

                    <div class="form-group col-xs-4">
                        <label>CHAMADA</label>
                        <input class="form-control" disabled="" value="<?= $calendario->NR_CHAMADA . "º CHAMADA" ?>">
                    </div>

                    <div class="form-group col-xs-4">
                        <label>DATA DA PROVA</label>
                        <input class="form-control" disabled="" value="<?= date('d/m/Y', strtotime($calendario->DT_PROVA)) ?>">
                    </div>                    
                </div>

                <div class="row">
                    <div class="form-group col-xs-4">
                        <label>NÚMERO PROVA</label>
                        <input value="<?= $calendario->NUM_PROVA ?>" class="form-control" disabled="">
                    </div>

                    <div class="form-group col-xs-8">
                        <label>TÍTULO PROVA</label>
                        <input value="<?= $calendario->TITULO ?>" class="form-control" disabled="">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    <i class="fa fa-times"></i> Fechar
                </button>

                <?php if ($calendario->CD_PROVA == null): ?>                    
                    <input name="txtOperacao" type="hidden" value="I"/>
                    <input name="avalCalendario" type="hidden" value="<?= $calendario->CD_CALENDARIO ?>"/>
                    <input name="avalBimestre" type="hidden" value="<?= $calendario->BIMESTRE ?>"/>
                    <input name="avalChamada" type="hidden" value="<?= $calendario->NR_CHAMADA ?>"/>
                    <input name="avalCurso" type="hidden" value="<?= $calendario->CD_CURSO ?>"/>
                    <input name="avalDataProva" type="hidden" value="<?= date('Y-m-d', strtotime($calendario->DT_PROVA)) ?>"/>
                    <input name="avalDisciplina" type="hidden" value="<?= $calendario->CD_DISCIPLINA ?>"/>
                    <input name="avalTipoNota" type="hidden" value="<?= $calendario->CD_TIPO_NOTA ?>"/>
                    <input name="avalNumNota" type="hidden" value="<?= $calendario->NUM_NOTA ?>"/>
                    <input name="avalSerie" type="hidden" value="<?= $calendario->ORDEM_SERIE ?>"/>
                    <input name="avalTipoProva" type="hidden" value="<?= $calendario->CD_TIPO_PROVA ?>"/>
                    <input name="avalTurma" type="hidden" value="<?= $calendario->CD_TURMA ?>"/>
                    <input name="avalEstrutura" type="hidden" value="<?= $estrutura->CD_ESTRUTURA ?>">
                    <input name="avalTitulo" type="hidden" value="<?=
                    $calendario->DC_TIPO_PROVA . " - "
                    . $calendario->NM_CURSO_RED . " - "
                    . ($calendario->CD_CURSO == 3 ? $calendario->ORDEM_SERIE.'º ANO' : $calendario->ORDEM_SERIE.'ª SÉRIE') . " - "
                    . $calendario->BIMESTRE . "º Bimestre - " . $calendario->NR_CHAMADA
                    . "ª Chamada - " . $calendario->NM_MINI
                    ?>">

                    <button type="submit" class="btn btn-info">
                        <i class="fa fa-plus"></i> <?= LBL_BTN_ADICIONAR ?>
                    </button>
                <?php else: ?>
                    <a class="btn btn-primary" href="<?= site_url($this->session->userdata('SGP_SISTEMA') . '/prova/frmNovaProvaConfiguracao/' . $calendario->CD_PROVA) ?>">
                        <i class="fa fa-search-plus"></i> Detalhes
                    </a>                    
                <?php endif; ?>
            </div>
        </form>        
    </div>            
</div>