<div style="padding: 15px 20px">
    <table width="100%" border="1" cellpadding="5" cellspacing="0" style="border-color: black; border-collapse: collapse">
        <thead>
            <tr style="background-color:#D6D6D6;">
                <th>CURSO</th>
                <th>SÉRIE</th>
                <th>DISCIPLINA</th>
                <th>TEMA</th>
                <th>CONTEUDO</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $i = 0;
            foreach ($temas as $row) {
                $i++;
                ?>
                <tr style="background-color: <?= $i % 2 === 0 ? "#EFEFEF" : "white" ?>">
                    <td style="text-align: center">
                        <?= $row->NM_CURSO ?>
                    </td>

                    <td style="text-align: center">
                        <?= $row->NM_SERIE ?>
                    </td>

                    <td style="text-align: center">
                        <?= $row->NM_DISCIPLINA ?>
                    </td>

                    <td style="width: 30%; text-align: justify">
                        <?= $row->DC_TEMA ?>
                    </td>

                    <td style="width: 30%; text-align: justify">
                        <?= strip_tags($row->DC_CONTEUDO !== null ? $row->DC_CONTEUDO->read($row->DC_CONTEUDO->size()) : "") ?>
                    </td>
                </tr>
            <? } ?>
        </tbody>        
    </table>
</div>