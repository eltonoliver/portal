<?php
$this->load->view('layout/header');

if ($this->input->get('cd')) {
    ?>
    <script>
        $(document).ready(function () {
            $('#myModal').modal('show');

            $('#closemodal').click(function () {
                //  $('#myModal').modal('hide');
                window.location.href = "<?= base_url() ?>ocorrencias/psicologico/";
            });

            $('#closemodalc').click(function () {
                //  $('#myModal').modal('hide');
                window.location.href = "<?= base_url() ?>ocorrencias/psicologico/";
            });
        });


    </script>
<?php } ?>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msg');
            ?>
            <div class="modal modal-alert modal-info fade in" id="myModal" tabindex="-1" role="dialog" style="display: none;">  
                <div class="modal-dialog" style="width:30%">
                    <div class="modal-content">
                        <div class="modal-header btn-danger">
                            <h1>Impressão</h1>
                        </div>
                        <div class="modal-body">
                            <p>Deseja Imprimir os dados da consulta?</p>

                        </div>
                        <div class="modal-footer">
<!--                                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>-->
                            <a id="closemodalc" class="btn btn-default" href="<?= SCL_RAIZ ?>ocorrencias/psicologico/"  ><i class="fa fa-rotate-left"></i> Cencelar</a>
                            <a id="closemodal" class="btn btn-success" href="<?= SCL_RAIZ ?>ocorrencias/psicologico/imprimir?cd=<?= $this->input->get('cd') ?>" target="_blank" ><i class="fa fa-check-circle"></i> Imprimir</a>
                        </div>
                    </div>
                </div>
            </div>  

            <div class="panel panel-warning">


                <div class="panel-heading">
                    

                    <div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Novo Acompanhamento &nbsp;&nbsp;&nbsp;&nbsp;<span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#" data-toggle="modal" data-target="#cadastrar"> Interno</a></li>
                            <li><a href="#">Externo</a></li>
                        </ul>
                    </div>
                </div>
                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview" >
                    <thead>
                        <tr>
                            <th class="sorting">Matricula</th>
                            <th class="sorting">Nome</th>
                            <th class="sorting">Curso</th>
                            <th class="sorting text-center" style="width: 13%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        #print_r($grade);
                        foreach ($lista as $row) {
                            ?>
                            <tr class="text-success">
                                <td><?= $row['CD_ALUNO'] ?></td>
                                <td><?= $row['NM_ALUNO'] ?></td>
                                <td><?= $row['NM_CURSO_RED'] ?></td>
                                <td class="sorting text-center">
                                    <a class="btn btn-xs btn-info" href="<?= SCL_RAIZ ?>ocorrencias/psicologico/detalhe?cd=<?= base64_encode($row['CD_ALUNO']) ?>"><i class="icon-arrow-left"></i> Detalhes</a> 
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
                <!--modal enviar arquivo-->
                <div class="modal fade" id="cadastrar" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                     data-remote="<?= SCL_RAIZ ?>ocorrencias/psicologico/cadastrar"> 
                    <div class="modal-dialog" style="width: 50%;">
                        <div class="modal-content">
                            <?= modal_load ?>
                        </div>
                    </div>
                </div>
                <!--modal enviar arquivo-->
            </div>
        </div>
    </div>
</div>
<script>
    $('#gridview').dataTable({
        "sPaginationType": "full_numbers"
    });
</script>
<?php $this->load->view('layout/footer'); ?>