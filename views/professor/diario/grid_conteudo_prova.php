<div class="col-lg-12">
    <div class="panel panel-primary">
        <table class='table table-hover table-striped table-bordered'>
            <thead>                
                <tr class="panel-heading">
                    <th class="text-center" colspan="3">LISTA DE CONTEÚDOS</th>
                </tr>

                <tr class="panel-heading">                                        
                    <th class='border-right text-center'>DATA AULA</th>                                
                    <th class='border-right text-center'>CONTEÚDO</th>                        
                    <th class='border-right text-center'>CONTEÚDO LIVRO</th>                                                
                </tr>
            </thead>

            <tbody>
                <?php foreach ($conteudos as $conteudo): ?>
                    <tr>                           
                        <td class="col-sm-2 text-center">
                            <?= date("d/m/Y", strtotime($conteudo['DT_AULA'])); ?>
                        </td>
                        
                        <td class="col-sm-5 text-justify" style="padding: 5px">
                            <?= $conteudo['CONTEUDO'] ?>
                        </td>
                        
                        <td class="col-sm-5 text-justify">
                            <ul>
                                <?php foreach ($conteudo["ASSUNTO_LIVRO"] as $row): ?>                                                                
                                    <li><?= $row['DC_ASSUNTO'] ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
if ($ajax) {
    exit();
}?>