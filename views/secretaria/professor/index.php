<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Untitled Document</title>
    </head>
    <body>


        <table>
            <?
            foreach ($professor as $p) {


                $s = $this->funcionario->Professor($s = array('codigo' => $p->CD_PROFESSOR));
                if ($s[0]['FOTO'] != '') {
                    ?>
                    <tr>
                        <td rowspan="2">

                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2">
                            <img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $s[0]['CD_PESSOA'] ?>" style="height:220px" class="media-object">
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            NOME: <?= $p->NM_PROFESSOR ?><br />
                            FUNCAOS: PROFESSOR(A)<br />
                            RG: <?= $s[0]['RG'] ?><br />
                            CPF: <?= $s[0]['CPF'] ?><br />
                            CTPS: <?= $s[0]['CTPS'] ?><br />
                            ADMISSAO: <?= date('d/m/Y', strtotime($s[0]['DT_ADMISSAO'])) ?><br />
                        </td>
                    </tr>
    <? }
} ?>
        </table>
    </body>
</html>
<? exit(); ?>