<?php $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <?php
            echo get_msg('msgok');
            echo get_msg('msgerro');
            ?>
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <a href="<?= SCL_RAIZ ?>professor/requerimento/novo" class="btn btn-info"><i class="icon-plus"></i> Novo Requerimento</a>
                </div>
                <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview" name="gridview">
                    <thead>
                        <tr>
                            <th class="sorting">REQUERIMENTO</th>
                            <th class="sorting">DATA</th>
                            <th class="sorting"> STATUS</th>
                            <th class="sorting text-center" style="width: 20%">TIPO SOLICITAÇÃO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(isset($requerimento[0]['CD_REQUERIMENTO'])){
                            foreach ($requerimento as $row) { 
                                switch ($row['FLG_DEFERIDO']) {
                                    case "": $cor='info';  break;
                                    case 1: $cor='success';  break;
                                    case 2: $cor='danger';  break;
                                    default:
                                        break;
                                } 
                                ?>
                                <tr class="<?=$cor?>">
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#detalhe<?= $row['NUM_REQUERIMENTO'] ?>"><?= $row['NUM_REQUERIMENTO'] ?></a>
                                        <div class="modal fade" id="detalhe<?= $row['NUM_REQUERIMENTO'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                            data-remote="<?= SCL_RAIZ ?>professor/requerimento/detalhes?id=<?= $row['CD_REQUERIMENTO'] ?>"> 
                                           <div class="modal-dialog" style="width: 80%;">
                                               <div class="modal-content">
                                                   <?= modal_load ?>
                                               </div>
                                           </div>
                                       </div>
                                    </td>
                                    <td><?= date("d/m/Y", strtotime($row['DT_REQ'])); ?></td>
                                    <td><?= $row['DC_STATUS'] ?></td>
                                    <td class="sorting text-center"><?= $row['NM_TIPO_REQ'] ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan='6'>
                                <span class="btn btn-info">No aguardo</span>
                                <span class="btn btn-success">Deferido</span>
                                <span class="btn btn-danger">Indeferido</span>
                            </td>
                        </tr>
                    </tfoot>
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