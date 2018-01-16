<table width="90%" align="center" style="font-size: 12px">
                <tr>
                    <td><?=$listar[0]['TITULO'].' - '.$listar[0]['DISCIPLINAS']?></td>
                </tr>
            </table>
            
            
            
            <hr>
            <table width="90%" align="center" style="font-size: 11px">
                
                <?
                $aluno = '';
                foreach($listar as $l){
                
                if($aluno != $l['CD_ALUNO']){
                ?>
                <tr>
                    <td height="20">
                        
                    </td>
                </tr>
                <tr>
                    <td colspan="7" style="border-bottom: 1px solid #000">
                       <strong><?=$l['CD_ALUNO'].' - '.$l['NM_ALUNO']?></strong>
                    </td>
                </tr>
                <tr class="font-bold panel-footer">
                    <td style="border-bottom: 1px solid #000"><strong>DISCIPLINA</strong></td>
                    <td style="border-bottom: 1px solid #000" align="center"><strong>VERSÃO</strong></td>
                    <td style="border-bottom: 1px solid #000" align="center"><strong>ACERTOS</strong></td>
                    <td style="border-bottom: 1px solid #000" align="center"><strong>ERROS</strong></td>
                    <td style="border-bottom: 1px solid #000" align="center"><strong>VL QUESTÃO</strong></td>
                    <td style="border-bottom: 1px solid #000" align="center"><strong>OBJETIVA</strong></td>
                </tr>
                <? } ?>
                <tr>
                    <td height="20" style="border-bottom: 1px solid #000"><?=$l['CD_DISCIPLINA'].' - '.$l['NM_DISCIPLINA']?></td>
                    <td style="border-bottom: 1px solid #000" align="center"><?=$l['CD_PROVA']?></td>
                    <td style="border-bottom: 1px solid #000" align="center"><?=$l['NR_ACERTO']?></td>
                    <td style="border-bottom: 1px solid #000" align="center"><?=$l['NR_ERRO']?></td>
                    <td style="border-bottom: 1px solid #000" align="center"><?='x'.number_format($l['VL_QUESTAO'],4,'.','')?></td>
                    <td style="border-bottom: 1px solid #000" align="center"><?=(($l['NR_NOTA'] == '')? '-' : number_format($l['NR_NOTA'],1,'.',''))?></td>
                </tr>
                <? 
                $aluno = $l['CD_ALUNO'];
                } 
                ?>
            </table>