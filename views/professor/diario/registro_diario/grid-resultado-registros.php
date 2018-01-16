<div class="panel panel-primary">    
    <table class="table table-bordered table-hover" id="grid-semestre">
        <thead>
            <tr class="panel-heading">
                <th class="text-center" width="10%">Nº REGISTRO</th>
                <th class="text-center" width="20%">NOME</th>
                <th class="text-center" width="40%">DESCRIÇÃO DO REGISTRO</th>
                <th class="text-center" width="10%">DATA</th>
                <th class="text-center" width="10%">PERIODO</th>
                <th class="text-center" width="10%">AÇÕES</th>
            </tr>
        </thead>

        <tbody class="panel-body">
            <?php
            if(sizeof($registros)>0){
                foreach ($registros as $row) {  
                   $dis = ""; 
                   if ($row['STATUS'] == 0){
                       $dis = 'disabled="disabled"';
                   }
                $texto = substr($row['DS_REGISTRO'], 0, 100)."[...]";  
            ?>
                    <tr class="">
                        <td class="text-center"><?= $row['CD_REGISTRO']?></td>
                        <td class="text-justify"><?= $row['NM_ALUNO'] ?></td>
                        <td class="text-justify"><?= $texto ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($row['DT_REGISTRO'])) ?></td>
                        <td class="text-center"><?= $row['PERIODO'] ?></td>
                        <td class="text-center">
                            <button <?=$dis?> id class="btn btn-default" type="button" title="Alterar" data-toggle="modal" data-target="#alterar<?= $row['CD_REGISTRO']; ?>">
                                <i class="fa fa-pencil"></i>
                            </button>
                       
                            <button id class="btn btn-default" type="button" title="Visualizar" data-toggle="modal" data-target="#visualizar<?= $row['CD_REGISTRO']; ?>">
                                <i class="fa fa-search"></i>
                            </button>
                           
                        </td>
                    </tr>
                    
                    <!--modal Editar Registro-->
                    <div class="modal fade" id="alterar<?= $row['CD_REGISTRO']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                         data-remote="<?= SCL_RAIZ ?>professor/registro_diario/editar?id=<?= $row['CD_REGISTRO']; ?>"> 
                        <div class="modal-dialog" style="width: 60%;">
                            <div class="modal-content">
                                <?= modal_load ?>
                             </div>
                        </div>
                    </div>
                    <!--modal Visualizar Registro-->
                    
                    <!--modal Visualizar Registro-->
                    <div class="modal fade" id="visualizar<?= $row['CD_REGISTRO']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                         data-remote="<?= SCL_RAIZ ?>professor/registro_diario/visualizar?id=<?= $row['CD_REGISTRO']; ?>"> 
                        <div class="modal-dialog" style="width: 60%;">
                            <div class="modal-content">
                                <?= modal_load ?>
                             </div>
                        </div>
                    </div>
                    <!--modal Visualizar Registro-->
            <?php
                }
            }else{
            ?>        
                <tr class="">
                    <td class="text-center" colspan="6"><label>Sem registro</label></td>
                </tr>   
                
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

<?php exit(); ?>