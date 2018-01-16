<?php $this->load->view('layout/header');
?>

<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msg');
            ?>


            <div class="panel panel-info">
                <div class="panel-heading">

                    <h1><?= $det[0]['CD_ALUNO'] ?> - <?= $det[0]['NM_ALUNO'] ?> <a href="<?= base_url() ?>ocorrencias/psicologico" class="btn btn-warning" ><i class="fa fa-arrow-left"></i> Voltar</a>   </h1>
                </div>
                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview" >
                    <thead>
                        <tr>
                            <th class="sorting">ID</th>
                            <th class="sorting">Data</th>
                            <th class="sorting">Descrição</th>
                            <th class="sorting text-center" style="width: 13%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
#print_r($grade);
                        foreach ($det as $row) {
                            ?>
                            <tr class="text-success">
                                <td><?= $row['CD_OCORRENCIA'] ?></td>
                                <td><?= formata_data($row['DATA'], 'br') ?></td>
                                <td><?= strip_tags(substr($row['DESCRICAO'], 0, 135)) ?> ...</td>
                                <td class="sorting text-center">

                                    <a class="btn btn-xs btn-info" href="#" data-toggle="modal" data-target="#upload"> <i class="fa fa-upload"></i></a>
                                    <a class="btn btn-xs btn-warning" href="<?= SCL_RAIZ ?>ocorrencias/psicologico/editar?cd=<?=$row['CD_OCORRENCIA']?>"><i class="fa fa-edit"></i></a> 
                                    <a class="btn btn-xs btn-danger" href="<?= SCL_RAIZ ?>ocorrencias/psicologico/imprimir?cd=<?=$row['CD_OCORRENCIA']?>" target="_blank"><i class="fa fa-print"></i></a> 

                                    <div class="modal fade" id="upload" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                         data-remote="<?= SCL_RAIZ ?>ocorrencias/psicologico/upload_arq/<?= $row['CD_OCORRENCIA'] ?>/<?= base64_decode($this->input->get('cd')) ?>"> 
                                        <div class="modal-dialog" style="width: 50%;">
                                            <div class="modal-content">
                                                <?= modal_load ?>
                                            </div>
                                        </div>
                                    </div> 
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>               
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