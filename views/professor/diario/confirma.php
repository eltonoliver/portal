<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header" data-target="#modal-step-contents">
     <h5 class="bigger lighter"> <i class="icon-table"></i> INICIO DE AULA </h5>
    </div>
    <form action="<?=SCL_RAIZ?>/professor/diario/modal" method="post" name="frmfrequencia" id="frmfrequencia">
    <div class="center">
        <div class="col-xs-12">
          <div class="widget-box">
            <div class="widget-header header-color-blue">
              <h5 class="bigger lighter"> <i class="icon-table"></i> INICIO DE AULA </h5>
            </div>
            <div class="widget-body">
              <div class="widget-main no-padding">
                <table class="table table-striped table-bordered table-hover">
                  <thead class="thin-border-bottom">
                    <tr>
                      <th>Turma</th>
                      <th>Disciplina </th>
                      <th>Data</th>
                      <th>Início</th>
                    </tr>
                  </thead>
                  <input name="turno_tempo" type="hidden" id="turno_tempo" value="<?=$turno.$tempo?>" />
                  <input name="tempo_aula" type="hidden" id="tempo_aula" value="<?=$tempo?>" />
                  <input name="turno" type="hidden" id="turno" value="<?=$turno?>" />
                  <input name="turma" type="hidden" id="turma" value="<?=$turma?>" />
                  <input name="horario" type="hidden" id="horario" value="1" />
                  <input name="periodo" type="hidden" id="periodo" value="<?=$periodo?>" />
                  <input name="disciplina" type="hidden" id="disciplina" value="<?=$disciplina?>" />
                  <input name="dt_chamada" type="hidden" id="dt_chamada" value="<?=date('d/m/Y')?>" />
                  <input name="hr_aberto" type="hidden" id="hr_aberto" value="<?=date('H:m:s')?>" />
                  <input name="opcao" type="hidden" id="opcao" value="1" />
                  
                  <tbody>
                    <tr>
                      <td><?=$turma?></td>
                      <td><?=$disciplina?></td>
                      <td><?=date('d/m/Y')?></td>
                      <td><?=date('H:m:s')?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      </form>
    <div class="modal-footer">
      <button class="btn btn-success btn-sm btn-next" onclick="document.forms['frmfrequencia'].submit();" href="javascript:void(0)"> Iniciar Aula <i class="icon-arrow-right icon-on-right"></i> </button>
      <button class="btn btn-danger btn-sm pull-left" data-dismiss="modal"> <i class="icon-remove"></i> Cancelar </button>
    </div>
  </div>
</div>
<? exit;?>
