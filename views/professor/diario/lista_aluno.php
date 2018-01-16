
    <div class="modal-header btn-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" >Lista de Aulos</h4>
    </div>
    <div class="modal-body"> 
        
        <table id="gridview" class="table table-striped table-bordered table-hover dataTable">
            <thead>
              <tr>
                <th width="10%">Matrícula</th>
                <th>Aluno</th>
              </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="4"><div class="text-left"><strong>Total de <?php print_r(count($alunos))?> Alunos </strong></div></td>
                </tr>
            </tfoot>
            <tbody>
                <?php  if(count($alunos) > 0){ foreach($alunos as $row){ ?>
                <tr class="<?php  if($row['FLG_PRESENTE'] == 'N') echo 'text-danger"';?>">
                  <td><?=$row['CD_ALUNO']?></td>
                  <td><?=$row['NM_ALUNO']?></td>
                  
                </tr>
                
                <?php } } ?>
              </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
        <?php if($this->input->get('f')==1){ ?>
        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Confirmar</button>
        <?php } ?>
    </div>  
<?php exit; ?>