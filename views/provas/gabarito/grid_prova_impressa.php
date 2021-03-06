<div class="row">
      
    
    <div class="col-md-12">
        <?php if (count($provas) == 0): ?>
            <p>Sem gabaritos para o bimestre informado.</p>
        <?php else: ?>
            <?php
            foreach ($provas as $p) :
                $total = (($p['QTDE_QUESTOES'] == 24) ? $p['QTDE_QUESTOES'] - 4 : $p['QTDE_QUESTOES']);
                ?>

                <table class="table table-bordered table-striped table-hover ">
                    <thead>
                        <tr>
                            <th class="text-center" style="background-color: #adadb8" colspan="<?= $total + 1 ?>">
                                <?= $p['NUM_PROVA'] . ' - ' . $p['BIMESTRE'] . 'º BIMESTRE - (' . $p['NM_MINI'] . ') - ' . $p['DISCIPLINAS'] ?>
                            </th>
                        </tr>
                    </thead>

                    <tbody>                        
                        <?php
                        //indica quantas colunas para resposta do gabarito 
                        //vai ter na tabela
                        $colunas = 20;
                        for ($j = 0; $j < $total; $j = $j + $colunas) {
                            $pagina = $j + $colunas;

                            if ($total < $colunas) {
                                $pagina = $total;
                            }
                            ?>
                            <tr>
                                <td>QUESTÕES.</td>
                                
                                <!--
                                <?php
                                for ($i = $j; $i < $pagina; $i++) {
                                    ?>
                                    <td align="center"><?= $i + 1 ?></td>
                                <?php } ?>
                                -->    
                                   
                                <?php
                                for ($i = $j; $i < $pagina; $i++) {
                                    if (($p['CD_PROVA_ORIGINAL'] == 7655) && (substr($p['GABARITO'], $i, 1) == '#')){ 
                                        ?>                                    
                                   <!-- <td align="center"></td> -->
                                    <?} else {?>
                                    <td align="center"><?= $i + 1 ?></td>
                                                                        
                                <?php }} ?>                                
                                
                                    
                            </tr>

                            <tr>
                                <td>GABARITO</td>
                                
                               <!--  observação, o CD_PROVA_ORIGINAL'] == 7655 foi para liberar prova de gabarito incorreto. 
                                <?php
                                for ($i = $j; $i < $pagina; $i++) {                                    
                                        ?>
                                    <td align="center"><?= substr($p['GABARITO'], $i, 1) ?></td>                                                                        
                                <?php } ?>
                                 -->                     
                                    
                                
                                <?php
                                for ($i = $j; $i < $pagina; $i++) {
                                    if (($p['CD_PROVA_ORIGINAL'] == 7655) && (substr($p['GABARITO'], $i, 1) == '#')){ 
                                        ?>                                    
                                    <!-- <td align="center"></td> -->
                                    <?} else {?>
                                    <td align="center"><?= substr($p['GABARITO'], $i, 1) ?></td>
                                                                        
                                <?php }} ?>
                                    
                                
                                    
                            </tr>

                            <tr>
                                <td>RESPOSTAS</td>
                                                                
                                <!--
                                <?php
                                for ($i = $j; $i < $pagina; $i++) {
                                    ?>
                                    <td align="center" style="background:<?= ((substr($p['GABARITO'], $i, 1) == substr($p['RESPOSTAS'], $i, 1) ? '#77cd4c' : '#ff6666')) ?>"><?= substr($p['RESPOSTAS'], $i, 1) ?></td>
                                <?php } ?>
                                    -->
                                    
                                    
                               <?php
                                for ($i = $j; $i < $pagina; $i++) {
                                    if (($p['CD_PROVA_ORIGINAL'] == 7655) && (substr($p['GABARITO'], $i, 1) == '#')){ 
                                        ?>                                    
                                    <!-- <td align="center"></td> -->
                                    <?} else {?>
                                    <td align="center" style="background:<?= ((substr($p['GABARITO'], $i, 1) == substr($p['RESPOSTAS'], $i, 1) ? '#77cd4c' : '#ff6666')) ?>"><?= substr($p['RESPOSTAS'], $i, 1) ?></td>
                                                                        
                                <?php }} ?>                                    
                                    
                                    
                            </tr>

                        <?php } ?>
                    </tbody>    
                </table>
            <?php endforeach; ?>            

            <div class="panel-footer">
                <fieldset>
                    <legend>Legenda</legend>
                    <div><span style="background-color: #77cd4c">&nbsp;&nbsp;&nbsp;&nbsp;</span> Acertou a questão.</div>
                    <div><span style="background-color: #ff6666">&nbsp;&nbsp;&nbsp;&nbsp;</span> Errou a questão.</div>
                    <div>( * ) Questão anulada.</div>
                    <div>( # ) Questão cancelada.</div>               
                    <div>( Z ) Questão não marcada.</div>               
                </fieldset>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php exit(); ?>