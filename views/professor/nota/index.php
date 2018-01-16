<?php $this->load->view('layout/header'); ?>

<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php echo get_msg('msgok'); ?>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h1 class="panel-title text-center">Lista de disciplinas</h1>
                </div>
                <table width="100%" class="table table-bordered table-hover" id="gridview" aria-describedby="sample-table-2_info">
                    <thead>
                        <tr class="panel-heading"> 
                            <th class="sorting text-center">Turma</th>
                            <th class="sorting text-center">Disciplina</th>
                            <th class="sorting_disabled text-center">Visualizar Nota</th>                            
                            <th class="sorting_disabled text-center">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($turmas as $t) { ?>
                            <tr>
                                <td class="text-center"><?= $t['CD_TURMA'] ?></td>
                                <td class="text-center"><?= $t['NM_DISCIPLINA'] ?></td>
                                <td class="text-center">
                                    <?php
                                    foreach ($t['notas'] as $tipo):
                                        $mista = "N";
                                        $turma = $t['CD_TURMA'];
                                        if (strpos($turma, '+') !== FALSE) {
                                            $turma = str_replace("+", "", $turma);
                                            $mista = "S";
                                        }

                                        $id = "nota" . $turma . $t['CD_DISCIPLINA'] . $tipo['NUM_NOTA'] . $tipo['BIMESTRE'];
                                        ?>                                        

                                        <a href="#<?= $id ?>" class="btn btn-info" data-toggle="modal">
                                            <?= $tipo['BIMESTRE'] . "º - " . $tipo['NM_MINI'] ?>
                                        </a>

                                        <div id="<?= $id ?>" class="modal fade" 
                                             data-remote="<?=
                                             site_url("professor/nota/consultar") . "?disciplina=" . $t['CD_DISCIPLINA'] . "&turma=" . $turma
                                             . "&curso=" . $t['CD_CURSO'] . "&numero=" . $tipo['NUM_NOTA'] . "&bimestre=" . $tipo['BIMESTRE']
                                             . "&nota=" . $tipo['NM_MINI'] . "&mista=" . $mista
                                             ?>" 
                                             role="dialog"
                                             aria-hidden="true">                                            
                                            <div class="modal-dialog" style="width: 50%">
                                                <div class="modal-content">
                                                    <?= modal_load ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </td>

                                <td class="text-center">
                                    <?php
                                    $string = strstr($t['CD_TURMA'], '+');
                                    if ($string == '+') {
                                        ?>

                                        <a data-toggle="modal" class="btn btn-warning" href="#view<?= str_replace("+", "", $t['CD_DISCIPLINA'] . $t['CD_TURMA']); ?>">
                                            <i class="fa fa-users"></i>
                                            Lançar notas</a>
                                        <!--modal-->

                                        <div class="modal fade" id="view<?= str_replace("+", "", $t['CD_DISCIPLINA'] . $t['CD_TURMA']); ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                             data-remote="<?= SCL_RAIZ ?>professor/nota/estrutura_nota_mista?dados=<?= urlencode(serialize($t)) ?>"> 
                                            <div class="modal-dialog" style="width: 50%;">
                                                <div class="modal-content">
                                                    <?= modal_load ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <button id class="btn btn-success" type="button" data-toggle="modal" data-target="#tipo_nota<?= str_replace("+", "", $t['CD_DISCIPLINA'] . $t['CD_TURMA']); ?>">
                                            <i class="fa fa-users"></i>
                                            Lançar notas
                                        </button>
                                    <?php } ?>
                                </td>                                                            
                            </tr>
                            <!--modal carrega as estrutura de notas normal-->
                        <form action="<?= SCL_RAIZ ?>professor/nota/lancamento" method="post" id="frmnota" >
                            <div class="modal fade" id="tipo_nota<?= str_replace("+", "", $t['CD_DISCIPLINA'] . $t['CD_TURMA']); ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"> 
                                <div class="modal-dialog" style="width: 50%;">
                                    <div class="modal-content">
                                        <div class="modal-header btn-warning alert-dismissable">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" >Selecione o tipo de nota a ser lançada</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    Turma: <label> <?= $t['CD_TURMA'] ?></label>
                                                    <input name="curso" type="hidden" id="curso" value="<?= $t['CD_CURSO'] ?>" />
                                                    <input name="disciplina" type="hidden" id="disciplina" value="<?= $t['CD_DISCIPLINA'] ?>" />
                                                    <input name="txtdisciplina" type="hidden" id="txtdisciplina" value="<?= $t['NM_DISCIPLINA'] ?>" />
                                                    <input name="turma" type="hidden" id="turma" value="<?= $t['CD_TURMA'] ?>" />
                                                </div>
                                                <div class="col-lg-8">
                                                    Disciplina: <label> <?= $t['NM_DISCIPLINA'] ?></label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <?php
                                                    $tipo_nota = array('operacao' => 'LN',
                                                        'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                                                        'cd_turma' => $t['CD_TURMA']);
                                                    $listar_tipo_nota = $this->diario->sp_notas($tipo_nota);
                                                    ?>

                                                    <?php if (count($listar_tipo_nota[0]) == 0) { ?>
                                                        <label>Fora do Prazo de lançamento de notas</label> 
                                                    <?php } else { ?>
                                                        <label>Tipo de nota</label> 

                                                        <select name="numero_nota" id="numero_nota" style="width:98%">
                                                            <?php
                                                            if (count($listar_tipo_nota[0]) > 0) {
                                                                foreach ($listar_tipo_nota as $l) {
                                                                    ?>
                                                                    <option value="<?= $l['NUM_NOTA'] ?>">
                                                                        <?= $l['DC_TIPO_NOTA'] ?> (<?= $l['NM_MINI'] ?>) - <?= $l['BIMESTRE'] ?> º Bimestre
                                                                    </option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
                                            <?php if (count($listar_tipo_nota[0]) != 0) { ?>
                                                <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Lançar Notas</button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--fim modal carrega as estrutura de notas normal-->

                    <?php } ?>
                    </tbody>
                </table>  

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('[data-toggle="frmModal"]').on('click',
            function (e) {
                $('#frmModal').remove();
                e.preventDefault();
                var $this = $(this)
                        , $remote = $this.data('remote') || $this.attr('href')
                        , $modal = $('<div class="modal fade" id="frmModal"  tabindex="-1" role="dialog" ><div class="modal-dialog"><div class="modal-content"></div></div></div>');
                $('body').append($modal);
                $modal.modal({backdrop: 'static', keyboard: false});
                $modal.load($remote);
            }
    );
</script>

<?php $this->load->view('layout/footer'); ?>