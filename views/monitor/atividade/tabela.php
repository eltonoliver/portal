<div class="col-sm-12">
    <h3><i class="fa fa-clock-o"></i> Relação de Atividades Extras da Turma: <?= $this->input->post('turma') ?></h3>
    <table class="table table-striped table-sorting table-hover table-bordered">
        <thead>
            <tr>
                <td align="left"><strong> <?= $s['CD_ALUNO'] . ' - ' . $s['NM_ALUNO'] ?></strong></td>
                <td align="center" style="font-size:10px;" with="10%">
                    SEGUNDA
                </td>
                <td align="center" style="font-size:10px;" with="10%">
                    TERÇA
                </td>
                <td align="center" style="font-size:10px;" with="10%">
                    QUARTA
                </td>
                <td align="center" style="font-size:10px;" with="10%">
                    QUINTA
                </td>
                <td align="center" style="font-size:10px;" with="10%">
                    SEXTA
                </td>
                <td align="center" style="font-size:10px;" with="10%">
                    SÁBADO
                </td>
            </tr>
        </thead>
        <body>
            <?
            foreach ($aluno as $s) {
                $tempo = $this->secretaria->atividade(array('aluno' => $s['CD_ALUNO'], 'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO')));

                if ($tempo != 1) {
                    ?>
                <tr>
                    <td align="left" align="center" valign="middle" rowspan="<?= count($tempo) ?>"><strong> <?= $s['CD_ALUNO'] . ' - ' . $s['NM_ALUNO'] ?></strong></td>
                    <? foreach ($tempo as $r) {
                        ?>


                        <td align="center" style="font-size:10px;">
                            <? $tem = explode('<br />', trim(nl2br($r['SEGUNDA'])));
                            echo $tem[1];
                            ?>
                        </td>
                        <td align="center" style="font-size:10px;">
                            <? $tem = explode('<br />', trim(nl2br($r['TERCA'])));
                            echo $tem[1];
                            ?>
                        </td>
                        <td align="center" style="font-size:10px;">
            <? $tem = explode('<br />', trim(nl2br($r['QUARTA'])));
            echo $tem[1];
            ?>
                        </td>
                        <td align="center" style="font-size:10px;">
                            <? $tem = explode('<br />', trim(nl2br($r['QUINTA'])));
                            echo $tem[1];
                            ?>
                        </td>
                        <td align="center" style="font-size:10px;">
                            <? $tem = explode('<br />', trim(nl2br($r['SEXTA'])));
                            echo $tem[1];
                            ?>
                        </td>
                        <td align="center" style="font-size:10px;">
                    <? $tem = explode('<br />', trim(nl2br($r['SABADO'])));
                    echo $tem[1];
                    ?>
                        </td>
                    </tr>


            <?
        }
    }
}
?>
        </body>
    </table>
</div>
<? exit(); ?>

