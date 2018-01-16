<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
    </head>    
    <body>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="5" >
  <tr>
    <td height="100" width="80%" align="left" style="font-family: 'Arial Narrow'; font-size: 12px">
        Curso: <?=$prova[0]['NM_CURSO_RED']?><br/>
        Matrícula: <?=$aluno[0]['CD_ALUNO']?><br/>
        Aluno(a): <?=$aluno[0]['NM_ALUNO']?><br/>
        Sala: <?=$aluno[0]['SALA']?><br/>
        Data: <?=(($prova[0]['DT_PROVA'] != '')? date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$prova[0]['DT_PROVA']))))):'')?><br/>
        Professor(a): <?=$prova[0]['NM_PROFESSOR']?><br/>
    </td>
    <td width="100px" style="border:1px solid #000">
        <? $img = $aluno[0]['CD_ALUNO'].$prova[0]['NUM_PROVA'] ?>
        <img id="img" style="margin:0 auto;" height="100" src="<?=base_url('108/impressao/qrcode/'.$img.'')?>" /><br/>
    </td>
    </tr>
    <tr>
    <td height="10" width="80%" align="left" style="font-family: 'Arial Narrow'; font-size: 12px">
        Assinatura do(a) Aluno(a): __________________________________________________________________________
    </td>
    <td width="10px" align="center" style="font-family: 'Arial Narrow'; font-size: 10px">
        <?=$aluno[0]['NUM_PROVA'] ?>
    </td>
  </tr>
</table>
    <h3 ALIGN="center" style="font-family: 'Arial Narrow'; font-size: 14px;" >Caderno de Prova Discursiva</h3>


    <table width="100%" align="center" cellpadding="1" cellspacing="0" style="border: 1px solid #000">
            <tr>
                <td height="20" align="center">
                    <?=strtoupper($prova[0]['TITULO'].'<BR/>'.$prova[0]['DISCIPLINAS'])?>
                </td>
            </tr>
        </table>
    <table width="100%" align="center" cellpadding="1" cellspacing="5" style="border: 0px solid #000">
  <tr>
    <td height="20" align="left" style="font-family: 'Arial Narrow'; font-size: 13px; display: none">
    
     <div style="display:none; text-align: justify">
        1.	Qualquer falha na impressão, de página ou falta de folhas deve ser apresentado à PROFESSORA que a solucionará;<br/>
        2.	Preencha o cabeçalho acima, antes de iniciar a resolução da avaliação;<br/>
        3.	Utilize o verso das folhas de rascunho, quando for o caso;<br/>
        4.	É PROIBIDO: pedir material emprestado, o uso de líquido corretor, o uso de calculadora e o uso de qualquer meio eletrônico de comunicação;<br/>
        5.	PORTAR (mesmo que não consulte) ou USAR meios ilícitos (cola) são considerados TRANSGRESSÕES GRAVES. Neste caso, o aluno será retirado de sala, terá sua avaliação recolhida e responderá às sanções regulamentares previstas;<br/>
        6.	Só será aceita as questões objetivas e discursivas respondidas com caneta esferográfica azul ou preta;<br/>
        7.	Nas questões de múltipla escolha, assinale apenas uma alternativa, preenchendo totalmente o espaço correspondente à alternativa correta;<br/>
        8.	As questões objetivas serão computadas exclusivamente pelo gabarito e não pelo caderno de provas.<br/>
        9.	Questões objetivas rasuradas ou com mais de uma alternativa marcada serão anuladas;<br/>
        10.	As questões discursivas deverão ser respondidas com letra legível e sem rasura. Em caso de erro, colocara as palavras erradas entre parênteses e fazer sobre elas um único risco, ex:  (retificação) <br/>
        11.	As avaliações são elaboradas de acordo com o tempo estimado para a realização das mesmas, o aluno será avisado quando faltar 15 min para o término do tempo e NÃO SERÁ SEDIDO TEMPO EXTRA para preenchimento de gabarito ou resolução de questões;<br/>
        12.	Sua prova é um documento, sendo assim, não serão aceitos desenhos, símbolos ou outros não pertinentes ás questões da avaliação. <br/>
        13.	Esta avaliação consta de vinte (20) questões objetivas, valendo (0,3) cada e quatro (4) questões discursivas, valendo (1,0) cada, podendo estas últimas serem subdivididas e cada subdivisão receber pontuação proporcional. <br/>
       </div>
    </td>
  </tr>
</table>

<?  //exit();?>