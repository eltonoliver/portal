<div class="row">
    <div class="section-light col-lg-12 col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Ocorências Disciplinares</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table rt cf " id="rt1">
                            <thead class="cf">
                                <tr>                                    
                                    <th class="well" style="font-size:11px">DATA</th>
                                    <th class="well" style="font-size:11px">MOTIVO</th>
                                    <th class="well" style="font-size:11px"></th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <? 
                                print_r($ocorrencia);
                                foreach ($ocorrencia as $item) { ?>
                                    <tr>
                                        <td style="font-size:11px"><?= $item['NM_DISCIPLINA'] ?></td>
                                        <td style="font-size:11px"><?= $item['CD_TURMA'] ?></td>
                                    </tr>
                                <? } ?>
                            </tbody>
                        </table>
                        <div class="panel-footer">
                              
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<? exit(); ?>