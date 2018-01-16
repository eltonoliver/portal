<? $this->load->view('layout/header'); ?>

<div id="content">
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-3"></div>
    <a href="<?=base_url()?>coordenador/faltas/alunos_faltosos" class="col-xs-12 col-sm-6 col-md-3">
      <div class="stat-block stat-warning">
        <div class="icon"><b class="icon-cover"></b><i class="fa fa-list-alt"></i></div>
        <div class="details">
          <div class="number">Alunos </div>
          <div class="description">Faltosos</div>
        </div>
      </div>
    </a>
      
    <a href="<?=base_url()?>coordenador/faltas/por_turma" class="col-xs-12 col-sm-6 col-md-3">
      <div class="stat-block stat-info">
        <div class="icon"><b class="icon-cover"></b><i class="fa fa-bar-chart-o"></i></div>
        <div class="details">
          <div class="number">Faltas</div>
          <div class="description">por Turma e dia</div>
        </div>
      </div>
    </a>
    <div class="col-xs-12 col-sm-6 col-md-3"></div>  
      
  </div>
</div>
<? $this->load->view('layout/footer'); ?>
