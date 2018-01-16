<div style="text-align: center">
    <h4><?= $questoes[0]['titulo'] ?></h4>
    <h4><?= $questoes[0]['disciplinas'] ?></h4>
</div>

<?php foreach ($questoes as $row): ?>
    <div style="margin-bottom: 20px;">
        <hr>
        <div style="font-weight: bold;">
            <?= $row['posicao'] . "º QUESTÃO " . ($row['anulada'] == "S" ? "(ANULADA)" : ($row['cancelada'] == "S" ? "(CANCELADA)" : "")) ?>
        </div>
        <hr>

        <div style="float: left; width: 50%; border-right: thin solid black; padding-right: 20px">            
            <div style="margin-bottom: 10px">
                <table style="color: #08C; font-weight: bold; font-size: 10px">
                    <tr>
                        <td style="text-align: right">TEMA:</td> 
                        <td><?= $row['tema'] ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right">CONTEÚDO:</td> 
                        <td><?= $row['conteudo'] ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: right">CORRETA:</td> 
                        <td><?= $row['correta'] . ")" ?></td>
                    </tr>
                </table>            
            </div>

            <div style="font-weight: bold">
                <?= $row['questao'] ?>
            </div>
        </div>

        <div style="float: left; width: 35%; border-left: thin solid black; padding-left: 20px">        
            <table>
                <?php foreach ($row['opcoes'] as $opcao): ?>
                    <tr>
                        <td style="<?= $row['resposta'] == $opcao['letra'] ? "color: #cc5200; font-weight: bold;" : "" ?>">
                            <?= $opcao['letra'] . ") " ?>
                        </td>

                        <td style="<?= $row['resposta'] == $opcao['letra'] ? "color: #cc5200" : "" ?>">
                            <?= $opcao['descricao'] ?>
                        </td>
                    </tr>                
                <?php endforeach; ?>
            </table>
        </div>                
    </div>
<?php endforeach; ?>
