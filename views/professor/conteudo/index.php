<?php $this->load->view('layout/header'); ?>
<div id="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-info">
                <div class="panel-heading text-center">
                    <label class="text-center">Filtros</label>
                </div>
                <div class="panel-body">
                    <form onsubmit="return false;" class="form-horizontal form-bordered" method="post" action="#">
                        <div class="row">
                            <div class="col-md-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input name="periodo" type="text" class="form-control" id="daterange">
                                </div>
                            </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <div class="col-md-9">
                                        <div class="input-group">
                                            <select id="turma" name="turma" class="form-control" size="10">
                                                <option value="0">Selecione uma Turma</option>
                                                <?php foreach ($grade as $g) {?>
                                                <option value="<?=$g['CD_TURMA']?>">Curso: <?=$g['NM_CURSO']?> - Turma: <?=$g['CD_TURMA']?> - Turno: <?=$g['TURNO']?> - Disciplina: <?=$g['NM_DISCIPLINA']?> </option>
                                                <?php } ?>
                                            </select> 
                                            <span class="input-group-btn">
                                                <button class="btn btn-warning" type="button">Filtrar</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= SCL_JS ?>bootstrap-datepicker.min.js"></script> 
<script src="<?= SCL_JS ?>daterangepicker.min.js"></script> 
<script src="<?= SCL_JS ?>moment.min.js"></script>
<script>
    $(document).ready(function() {
        $('#daterange').daterangepicker({
            format: 'DD/MM/YYYY'
        });
    });
</script>    
<?php $this->load->view('layout/footer'); ?>