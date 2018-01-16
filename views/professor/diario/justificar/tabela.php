<? print_r($chamada)?>
<?php if(count($ch_realizada[0]) > 0){ ?>
    <div class="modal-header btn-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" >Lista de Chamada</h4>
    </div>
    <form action="<?=SCL_RAIZ?>professor/diario/editar_frequencia" method="post" enctype="multipart/form-data" id="frmfrequencia" >
    <div class="modal-body"> 
        <input name="aula" type="hidden" id="aula" value="<?=$aula?>" />
        <input name="turma" type="hidden" id="turma" value="<?=$this->uri->segment(4)?>" />
        <input name="disciplina" type="hidden" id="disciplina" value="<?=$this->uri->segment(5)?>" />
        <input name="curso" type="hidden" id="curso" value="<?=$this->uri->segment(6)?>" />
        <table id="gridview" class="table table-striped table-bordered table-hover dataTable">
            <thead>
              <tr>
                <th width="10%">Matrícula</th>
                <th>Aluno</th>
                <th colspan="2">Frequência</th>
              </tr>
            </thead>
            <tbody>
                <?php  if(count($grade) > 0){ foreach($grade as $row){ ?>
                <tr class="<?php // if(empty($row->FLG_PASSAGEM)) echo 'red"';?>">
                  <td><?=$row['CD_ALUNO']?></td>
                  <td><?=$row['NM_ALUNO']?></td>
                  <td width="10%">
                    <div class="radio-inline">
                      <label>
                        <input name="<?=$row['CD_ALUNO']?>" type="radio" value="<?=$row['CD_ALUNO'].':S'?>" <?php if($row['FLG_PRESENTE'] == 'S') echo 'checked="checked"'; ?> >
                        <span class="lbl"> SIM</span> </label>
                    </div>
                  </td>
                  <td width="10%">
                      <div class="radio-inline">
                      <label>
                        <input name="<?=$row['CD_ALUNO']?>" type="radio" value="<?=$row['CD_ALUNO'].':n'?>" <?php if($row['FLG_PRESENTE'] == 'n') echo 'checked="checked"'; ?> >
                        <span class="lbl"> NÃO</span> </label>
                    </div>
                  </td>
                </tr>
                <?php } } ?>
              </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Confirmar</button>
    </div>
</form>

<?php }else{ ?>
<div class="modal-header btn-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" >Lista de Chamada</h4>
</div>
<form action="<?=SCL_RAIZ?>professor/diario/confirmar_frequencia" method="post" enctype="multipart/form-data" id="frmfrequencia" >
    <div class="modal-body"> 
        <input name="aula" type="hidden" id="aula" value="<?=$aula?>" />
        <input name="turma" type="hidden" id="turma" value="<?=$this->uri->segment(4)?>" />
        <input name="disciplina" type="hidden" id="disciplina" value="<?=$this->uri->segment(5)?>" />
        <input name="curso" type="hidden" id="curso" value="<?=$this->uri->segment(6)?>" />
        <table id="gridview" class="table table-striped table-bordered table-hover dataTable">
            <thead>
              <tr>
                <th width="10%">Matrícula</th>
                <th>Aluno</th>
                <th colspan="2">Frequência</th>
              </tr>
            </thead>
            <tbody>
                <?php  if(count($grade) > 0){ foreach($grade as $row){ ?>
                <tr class="<?php // if(empty($row->FLG_PASSAGEM)) echo 'red"';?>">
                  <td><?=$row['CD_ALUNO']?></td>
                  <td><?=$row['NM_ALUNO']?></td>
                  <td width="10%">
                    <div class="radio-inline">
                      <label>
                        <input name="<?=$row['CD_ALUNO']?>" type="radio" value="<?=$row['CD_ALUNO'].':S'?>" <?php if(empty($row['FLG_PASSAGEM'])) echo 'checked="checked"'; //if($row->FLG_PASSAGEM == 'E') echo 'checked="checked"';?> >
                        <span class="lbl"> SIM</span> </label>
                    </div>
                  </td>
                  <td width="10%">
                      <div class="radio-inline">
                      <label>
                        <input name="<?=$row['CD_ALUNO']?>" type="radio" value="<?=$row['CD_ALUNO'].':n'?>" checked="checked" <?php #if(empty($row['FLG_PASSAGEM'])) echo 'checked="checked"'; //if($row->FLG_PASSAGEM == 'E') echo 'checked="checked"';?> >
                        <span class="lbl"> NÃO</span> </label>
                      </div>
                  </td>
                </tr>
                <?php } } ?>
              </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Cancelar</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Confirmar</button>
    </div>
</form>
<?php } ?>    
<?php exit; ?>