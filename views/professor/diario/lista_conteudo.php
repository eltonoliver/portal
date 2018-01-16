
<div class="modal-header btn-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" >Lista Conteúdo Ministrado / Tarefa para casa</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-12">
            <table id="gridview<?= $this->input->get('id') ?>" class="table table-striped table-bordered table-hover dataTable">
                <thead>
                    <tr>
                        <th width="10%">Data</th>
                        <th width="4%" class="text-center">Tempo</th>
                        <th width="45%">Conteúdo</th>
                        <th width="45%">Tarefa Casa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($conteudos as $row) { ?>
                        <tr class="">
                            <td width="10%"><?= date('d/m/Y', strtotime($row->DT_AULA)) ?></td>
                            <td width="5%" class="text-center"><?= $row->TEMPO_AULA ?>º</td>
                            <td width="45%"><?= $row->CONTEUDO ?></td>
                            <td width="45%"><?= $row->TAREFA_CASA ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>    
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
</div>  
<script>
    $('#gridview<?= $this->input->get('id') ?>').dataTable({
    "sPaginationType": "full_numbers",
            "bRetrieve": true,
            "order": {
            {1: "desc"},
            }
    });
</script>      
<?php
exit;
