<div class="modal-header btn-info">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 class="modal-title">CONTEÚDO LANÇADO</h3>
</div>


<div class="modal-body" style="overflow-y: auto; height: 350px;">
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th class="text-center col-xs-2">Data</th>
                <th class="text-center col-xs-2">Tempo</th>
                <th class="text-center col-xs-4">Conteúdo</th>
                <th class="text-center col-xs-4">Tarefa</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($aulas as $row): ?>
                <tr>
                    <td class="text-center"><?= date('d/m/Y', strtotime($row['DT_AULA'])) ?></td>
                    <td class="text-center"><?= $row['TEMPO_AULA'] ?></td>
                    <td class="text-justify"><?= $row['CONTEUDO'] ?></td>
                    <td class="text-center"><?= $row['TAREFA_CASA'] ?></td>                    
                </tr>
            <?php endforeach; ?>
        </tbody>        
    </table>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Fechar</button>    
</div>

<?php exit(); ?>