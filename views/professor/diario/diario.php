<? 
 $this->load->view('layout/header'); 
 $this->load->view('layout/menu'); 
?>

<div class="page-content">
  <div class="page-header">
    <?=$titulo?>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive">
        <div id="sample-table-2_wrapper" class="dataTables_wrapper" role="grid">
          <table id="gridview" class="table table-striped table-bordered table-hover dataTable" aria-describedby="sample-table-2_info">
            <thead>
              <tr>
                <th class="sorting">Período</th>
                <th class="sorting">Turma</th>
                <th class="sorting">Disciplina</th>
                <th class="sorting"><i class="icon-time"></i>Tempo</th>
                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 171px;" aria-label=""></th>
              </tr>
            </thead>
            <tbody>
              <? 
		if(count($grade) > 0){
			  foreach($grade as $row){
		?>
              <tr class="text-success">
                <td><?=$row->PERIODO?></td>
                <td><?=$row->NM_DISCIPLINA?></td>
                <td><?=$row->CD_TURMA?></td>
                <td><?=$row->TEMPO_AULA?></td>
                <td></td>
              </tr>
              <div id="aceite<?=$row->CD_TURMA.$row->CD_DISCIPLINA.$row->CD_CURSO.$row->CD_PLANO?>" class="modal" data-remote="<?=SCL_RAIZ?>/professor/plano/modal<?="?plano=".$row->CD_PLANO."&turma=".$row->CD_TURMA."&disciplina=".$row->CD_DISCIPLINA."&curso=".$row->CD_CURSO."&turno=".$row->TURNO."&tempo=".$row->TEMPO_AULA."&periodo=".$row->PERIODO?>">
              <?=modal_load?>
              </div>
              <? } } ?>
            </tbody>
            <tfoot>
              <tr role="row">
                <th colspan="6">&nbsp;</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<? $this->load->view('layout/footer'); ?>
