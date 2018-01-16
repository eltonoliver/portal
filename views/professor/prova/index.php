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
                            <th class="sorting_disabled text-center">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($turmas as $t) { ?>
                            <tr>
                                <td class="text-center"><?= $t['CD_TURMA'] ?></td>
                                <td class="text-center"><?= $t['NM_DISCIPLINA'] ?></td>
                                <td class="text-right">
                                    <?php
                                    $string = strstr($t['CD_TURMA'], '+');
                                        if ($string == '+') {
                                        ?>
                                        <a data-toggle="modal" 
                                           class="btn btn-warning" 
                                           href="#view<?= str_replace("+", "", $t['CD_DISCIPLINA'] . $t['CD_TURMA']); ?>"
                                           ></a>
                                    <?php } else { ?>
                                         <a class="btn btn-success"
                                           href="<?=base_url('professor/provas/frmTurma?p='.base64_encode(json_encode($t)).'')?>"
                                        >
                                            <i class="fa fa-users"></i>
                                            Provas
                                        </a>
                                    <?php } ?>
                                </td>                                                            
                            </tr>
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