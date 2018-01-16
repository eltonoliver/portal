<div id="retorno"></div>

<div class="col-lg-12">
        <div class="hpanel">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a data-toggle="tab" href="#tab-1" aria-expanded="true"> 
                        <i class="fa fa-users"></i> Acompanhamento
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tab-2" aria-expanded="false">
                        <i class="fa fa-list-ol"></i> Ranking
                    </a>
                </li>
                <li class="">
                    <a data-toggle="tab" href="#tab-3" aria-expanded="false">
                        <i class="fa fa-clock-o"></i> Tempo por Questão
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <? foreach($listar as $l) { 
                            
                        ?>
                            <div class="col-sm-4 no-padding">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr class="active">
                                            <td style="width:50px" width="50px" valign="middle">
                                                <div class="media social-profile clearfix">
                                                <a class="pull-left">
                                                    <img width="60px" src="https://www.seculomanaus.com.br/portal/restrito/foto?codigo=<?=$l['aluno']['CD_ALUNO']?>" alt="profile-picture">
                                                </a>
                                                <div class="media-body">
                                                    <h5><?=$l['aluno']['TITULO']?></h5>
                                                    <small class="text-muted"><?=$l['aluno']['CD_ALUNO'].' - '.$l['aluno']['NM_ALUNO']?></small>
                                                    <div class="progress m-t-xs full progress-striped active">
                                                        <div style="width: 100%" 
                                                            aria-valuemax="100" 
                                                            aria-valuemin="0" 
                                                            aria-valuenow="50" 
                                                            role="progressbar" 
                                                            class="progress-bar progress-bar-danger progress-small">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="active">
                                            <td align="center">
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>
                                                                DISCIPLINA
                                                            </td>
                                                            <td align="center">NOTA</td>
                                                            <td align="center">ACERTO(s)</td>
                                                            <td align="center">ERRO(s)</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <? foreach ($disciplinas as $d) { 
                                                            $nota = '0.0';
                                                            $acertos = 0;
                                                            $erros = 0;
                                                               
                                                            foreach ($l[$d['CD_DISCIPLINA']]['respostas'] as $resp){
                                                                $nota = $resp['NOTA'];
                                                                $acertos = $resp['NR_ACERTO'];
                                                                $erros = $resp['NR_ERRO'];
                                                                   
                                                            ?>
                                                               
                                                       <?   } ?>
                                                            <tr class="<?=((($nota < 5))? 'bg-danger' : (($nota >= 7)? 'bg-success' : 'bg-warning'))?>">
                                                                <td><?=$d['NM_DISCIPLINA']?></td>
                                                                <td width="5%" align="center"><?=$nota?></td>
                                                                <td width="5%" align="center"><?=$acertos?></td>
                                                                <td width="5%" align="center"><?=$erros?></td>
                                                            </tr>
                                                        
                                                        <? } ?>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <? }  ?>
                    </div>
                </div>
                    
                 <div id="tab-2" class="tab-pane">
                    <div class="panel-body">
                        <table class="table table-hover">
                            <tr class="panel-footer">
                                <td><strong>ALUNO</strong></td>
                                <td><strong>DISCIPLINA</strong></td>
                                <td align="center"><strong>ACERTO(s)</strong></td>
                                <td align="center"><strong>ERRO(s)</strong></td>
                                <td align="center"><strong>NOTA</strong></td>
                            </tr>
                            <? foreach ($ranking as $r) { 
                                $nota = number_format($r['NOTA'],0,'.','');
                                ?>
                                <tr class="<?=(($nota < 5)? 'bg-danger' : (($nota >= 7)? 'bg-success' : 'bg-warning'))?>">
                                    <td><?=$r['CD_ALUNO'].' - '.$r['NM_ALUNO']?></td>
                                    <td><?=$r['CD_DISCIPLINA'].' - '.$r['NM_DISCIPLINA']?></td>
                                    <td width="5%" align="center">
                                        <?=$r['NR_ACERTO']?>
                                    </td>
                                    <td width="5%" align="center">
                                        <?=$r['NR_ERRO']?>
                                    </td>
                                    <td width="5%" align="center">
                                        <?=number_format($r['NOTA'],1,'.','')?>
                                    </td>
                                </tr>
                            <? }  ?>
                         </table>
                    </div>
                </div>
                    
                <div id="tab-3" class="tab-pane">
                    <div class="panel-body">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <?
                            foreach ($disciplinas as $d) { 
                                $disciplina = $d['NM_DISCIPLINA'];
                            ?>
                                <div class="panel panel-default">
                                   <div class="panel-heading" role="tab" id="heading<?= $d['CD_DISCIPLINA']?>">
                                     <h4 class="panel-title">
                                       <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $d['CD_DISCIPLINA']?>" aria-expanded="false" aria-controls="collapse<?= $d['CD_DISCIPLINA']?>">
                                         <?= $disciplina?>
                                       </a>
                                     </h4>
                                   </div>
                                   <div id="collapse<?= $d['CD_DISCIPLINA']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?= $d['CD_DISCIPLINA']?>">
                                       <div class="panel-body">
                                            <table class="table table-hover">
                                                <tr class="panel-footer">
                                                    <td><strong>ALUNO</strong></td>
                                                    <td align="center"><strong>QUESTÃO</strong></td>
                                                    <td align="center"><strong>TEMPO</strong></td>
                                                    
                                                </tr>
                                                <? 
                                                $cont = 0;
                                                foreach ($listarResp[$d['CD_DISCIPLINA']] as $rd) { 
                                                    $cont++;
                                                    $tamanho = $rd['QUESTAO']->size();
                                                    $texto = str_replace('&quot;', '', $rd['QUESTAO']->read($tamanho));
                                                    $texto = substr($texto, 0, 700);
                                               ?>
                                                    <tr class="bg-white">
                                                        <td><?=$rd['CD_ALUNO'].' - '.$rd['NM_ALUNO']?></td>
                                                        <td width="10%" align="center">
                                                            <button onclick='swal("<?=$rd['POSICAO']?>ª QUESTÃO","<?=  strip_tags($texto.'[...]')?>","")' class="btn btn-default"><?=$rd['POSICAO']?>ª</button>
                                                            </td>
                                                        <td width="10%" align="center">
                                                            <?=$rd['NR_TEMPO_RESPOSTA']?>
                                                        </td>
                                                    </tr>
                                                    
                                                   
                                                <? }  ?>
                                            </table>
                                       </div>
                                   </div>
                                </div>
                            <? } ?>
                        </div>
                    </div>
                </div>      
            </div>
        </div> 
    </div>