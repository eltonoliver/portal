<div class="modal-header btn-danger alert-dismissable">
    <h4 class="modal-title" >Detalhes do Requerimento</h4>
</div>

    <div class="widget-main">
        <br>
        <div class="row">
            <div class="col-md-1"></div>
<div class="col-md-10">
        <table width="100%" class="table table-striped table-bordered table-hover datatable" id="gridview" name="gridview">
            <tbody>
                <tr>
                    <td width="10%">Matrícula</td>
                    <td width="30%">Nome</td>
                    <td width="5%">Período</td>
                    <td width="20%">Disciplina</td>
                    <td width="5%">Turno</td>
                    <td width="40%">Bimestre / Tipo</td>
                </tr>
                <?php foreach ($lista as $l) {?>
                <tr>
                    <td ><?=$l['CD_ALUNO']?></td>
                    <td><?=$l['NM_ALUNO']?></td>
                    <td><?=$l['PERIODO']?></td>
                    <td><?=$l['NM_DISCIPLINA']?></td>
                    <td><?php if($l['TURNO'] == "M") echo "Manhã"; else "Tarde";?></td>
                    <td><?=$l['BIMESTRE']?>º Bimentre | <?=$l['DC_TIPO_NOTA']?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
            <div class="col-md-1"></div>
                </div>
            </div>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-rotate-left"></i> Fechar</button>
    </div>


<?php exit; ?>