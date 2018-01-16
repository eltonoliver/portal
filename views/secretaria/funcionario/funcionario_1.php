<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
    </head>
    <body>


         <table border="1" cellpadding="1" cellspacing="1">
            <tr>
                <td>CÓDIGO DE BARRAS</td>
                <td>FUNCIONARIO</td>
                <td>FUNÇÃO</td>
                <td>RG</td>
                <td>CPF</td>
                <td>CTPS</td>
                <td>VIA</td>
                <td>ADMISSAO</td>
            </tr>


            <?
            foreach ($pessoa as $p) {
                $s = $this->funcionario->Funcionario($s = array('codigo' => $p->CD_FUNCIONARIO));
                if ($s[0]['FOTO'] != '') {
                    ?>
                    <tr>
                        <td><?= $s[0]['CHAPA_COM_DV'].$s[0]['VIA'] ?></td>
                        <td><?= $p->NM_FUNCIONARIO ?></td>
                        <td><?= $s[0]['NM_FUNCAO'] ?></td>
                        <td><?= $s[0]['RG'] ?></td>
                        <td><?= $s[0]['CPF'] ?></td>
                        <td> <?= $s[0]['CTPS'] ?></td>
                        <td> <?= $s[0]['VIA'] ?></td>
                        <td><?= date('d/m/Y', strtotime($s[0]['DT_ADMISSAO'])) ?></td>
                    </tr>
                <?
                }
            }
            ?>
        </table>
    </body>
</html>
<? exit(); ?>