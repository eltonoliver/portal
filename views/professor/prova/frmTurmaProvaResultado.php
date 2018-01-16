<legend> 
    RESULTADOS DOS ALUNOS
    
    <a target="_blank" class="btn btn-danger pull-right" href="https://www.seculomanaus.com.br/academico/108/prova_gabarito/relatorio_opcao/?id=<?=base64_encode($row->CD_PROVA)?>">
        <i class="fa fa-print"></i> PROVA CORRIGIDA
    </a>
</legend>
<small> <?=$row->TITULO?> </small>

<div class="col-sm-12">
    <table class='table table-hover'>
        <tbody>
            <? 
            foreach ($listar as $l) {
            ?>
            <tr style="font-size:12px">
                <td><?= $l->CD_ALUNO ?></td>
                <td class='border-right'><?= $l->NM_ALUNO ?></td>

                <td align='center' class="<?= (($l->LANCADA >= 7) ? 'text-info' : 'text-danger') ?>" ><strong><?= (($l->LANCADA != '') ? number_format($l->LANCADA, 1, '.', '') : '-') ?></strong></td>
            </tr>
            <? } ?>
        </tbody>
    </table>
</div>
<? exit;?>