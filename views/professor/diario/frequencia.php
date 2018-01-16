<?php if (!empty($mensagem)): ?>
    <div class="modal-header alert-dismissable btn-warning">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Importante</h4>
    </div>   

    <div class="modal-body">
        <p><?= $mensagem ?></p>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">
            <i class="fa fa-check"></i> Ok
        </button>
    </div>
    <?php exit(); ?>

<?php endif; ?>

<?php if (count($ch_realizada[0]) > 0) { ?>
    <div class="modal-header btn-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" >Lista de Chamada</h4>
    </div>
    <form action="<?= SCL_RAIZ ?>professor/diario/editar_frequencia" method="post" enctype="multipart/form-data" id="frmfrequencia" >
        <div class="modal-body"> 
            <input name="aula" type="hidden" id="aula" value="<?= $this->input->get('aula') ?>" />
            <input name="turma" type="hidden" id="turma" value="<?= $this->input->get('turma') ?>" />
            <input name="disciplina" type="hidden" id="disciplina" value="<?= $this->input->get('disc') ?>" />
            <input name="curso" type="hidden" id="curso" value="<?= $this->input->get('curso') ?>" />
            <input name="subturma" type="hidden" id="subturma" value="<?= $this->input->get('subturma') ?>" />        
            <input name="data-pendencia" type="hidden" value="<?= $this->input->get_post("data-pendencia") ?>">
            <input name="opcao" type="hidden" value="<?= $this->input->get_post("opcao") ?>">

            <table id="gridview" class="table table-striped table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th width="10%">Matrícula</th>
                        <th>Aluno</th>
                        <?php if ($this->input->get('f') == 1) { ?>
                            <th colspan="2">Frequência</th>
                        <?php } ?>
                    </tr>
                </thead>
                <?php if (!isset($grade['retorno']) & !isset($grade['cursor'])) : ?>
                    <tfoot>
                        <tr>
                            <td colspan="4"><div class="text-left"><strong>Total de <?php print_r(count($grade)) ?> Alunos </strong></div></td>
                        </tr>
                    </tfoot>
                <?php endif; ?>
                <tbody>
                    <?php
                    if (count($grade) > 0) {
                        if (!isset($grade['retorno']) & !isset($grade['cursor'])) {
                            foreach ($grade as $row) {
                                ?>
                                <tr class="<?php if ($row['FLG_PRESENTE'] == 'N') echo 'text-danger"'; ?>">
                                    <td><?= $row['CD_ALUNO'] ?></td>
                                    <td><?= $row['NM_ALUNO'] ?></td>
                                    <?php if ($this->input->get('f') == 1) { ?>
                                        <td width="10%">
                                            <div class="radio-inline">
                                                <label>
                                                    <input name="<?= $row['CD_ALUNO'] ?>" type="radio" value="<?= $row['CD_ALUNO'] . ':S' ?>" <?php if ($row['FLG_PRESENTE'] == 'S') echo 'checked="checked"'; ?>>
                                                    <span class="lbl"> SIM</span> </label>
                                            </div>
                                        </td>
                                        <td width="10%">
                                            <div class="radio-inline">
                                                <label>
                                                    <input name="<?= $row['CD_ALUNO'] ?>" type="radio" value="<?= $row['CD_ALUNO'] . ':N' ?>" <?php
                                                    if ($row['FLG_PRESENTE'] == 'N') {
                                                        echo 'checked="checked"';
                                                    }
                                                    ?> >
                                                    <span class="lbl"> NÃO</span> </label>
                                            </div>
                                        </td>
                                    <?php } ?>
                                </tr>

                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="3">Sem alunos nesta disciplina.</td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
            <?php if ($this->input->get('f') == 1) { ?>
                <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Confirmar</button>
            <?php } ?>
        </div>
    </form>

<?php } else { ?>
    <div class="modal-header btn-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" >Lista de Chamada</h4>
    </div>
    <form action="<?= SCL_RAIZ ?>professor/diario/confirmar_frequencia" method="post" enctype="multipart/form-data" id="frmfrequencia" >
        <div class="modal-body"> 
            <input name="aula" type="hidden" id="aula" value="<?= $this->input->get('aula') ?>" />
            <input name="turma" type="hidden" id="turma" value="<?= $this->input->get('turma') ?>" />
            <input name="disciplina" type="hidden" id="disciplina" value="<?= $this->input->get('disc') ?>" />
            <input name="curso" type="hidden" id="curso" value="<?= $this->input->get('curso') ?>" />
            <input name="subturma" type="hidden" id="subturma" value="<?= $this->input->get('subturma') ?>" />
            <input name="data-pendencia" type="hidden" value="<?= $this->input->get_post("data-pendencia") ?>">
            <input name="opcao" type="hidden" value="<?= $this->input->get_post("opcao") ?>">

            <table id="gridview" class="table table-striped table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th width="10%">Matrícula</th>
                        <th>Aluno</th>
                        <?php if ($this->input->get('f') == 1) { ?>
                            <th colspan="2">Frequência</th>
                        <?php } ?>
                    </tr>
                </thead>
                <?php if (!isset($grade['retorno']) & !isset($grade['cursor'])) : ?>
                    <tfoot>
                        <tr>
                            <td colspan="4"><div class="text-left"><strong>Total de <?php print_r(count($grade)) ?> Alunos </strong></div></td>
                        </tr>
                    </tfoot>
                <?php endif; ?>
                <tbody>
                    <?php
                    if (count($grade) > 0) {
                        if (!isset($grade['retorno']) & !isset($grade['cursor'])) {
                            foreach ($grade as $row) {
                                ?>
                                <tr class="<?php if ($row['FLG_PASSAGEM'] == 'N') echo 'text-danger"'; ?>">
                                    <td><?= $row['CD_ALUNO'] ?></td>
                                    <td><?= $row['NM_ALUNO'] ?></td>
                                    <?php if ($this->input->get('f') == 1) { ?>
                                        <td width="10%">
                                            <div class="radio-inline">
                                                <label>
                                                    <input name="<?= $row['CD_ALUNO'] ?>" type="radio" value="<?= $row['CD_ALUNO'] . ':S' ?>" <?php if ($row['FLG_PASSAGEM'] == 'S') echo 'checked="checked"'; //if($row->FLG_PASSAGEM == 'E') echo 'checked="checked"';                     ?> >
                                                    <span class="lbl"> SIM</span> </label>
                                            </div>
                                        </td>
                                        <td width="10%">
                                            <div class="radio-inline">
                                                <label>
                                                    <input name="<?= $row['CD_ALUNO'] ?>" type="radio" value="<?= $row['CD_ALUNO'] . ':N' ?>"  <?php if ($row['FLG_PASSAGEM'] == 'N') echo 'checked="checked"'; //if($row->FLG_PASSAGEM == 'E') echo 'checked="checked"';                     ?> >
                                                    <span class="lbl"> NÃO</span> </label>
                                            </div>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="3">Sem alunos nesta disciplina.</td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
            <?php if ($this->input->get('f') == 1) { ?>
                <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Confirmar</button>
            <?php } ?>
        </div>
    </form>
<?php } ?>    
<?php exit; ?>