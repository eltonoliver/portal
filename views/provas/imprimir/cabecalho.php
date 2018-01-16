<!DOCTYPE html>
<html class="no-js" lang="en">
<head>

</head>
<body>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="5" >
  <tr>
    <td height="80" width="80%" align="left" style="font-family: 'Arial Narrow'; font-size: 12px">
        Curso: <?=$aluno[0]['NM_CURSO']?><br/>
        Matrícula: <?=$aluno[0]['CD_ALUNO']?><br/>
        Aluno(a): <?=$aluno[0]['NM_ALUNO']?><br/>
        Prova: <?=$aluno[0]['NUM_PROVA']?><br/>
        Data: <?=date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$aluno[0]['DT_PROVA'])))))?><br/>
        Professor(a): <?=$aluno[0]['NM_PROFESSOR']?><br/><br/>
        Assinatura do(a) Aluno(a): _______________________________________________________________________
    </td>
    <td width="140px" style="border:1px solid #000">
        
    </td>
  </tr>
</table>
    <br/>
    <table width="100%" align="center" cellpadding="1" cellspacing="0" style="border: 1px solid #000">
  <tr>
    <td height="20" align="center">
        <?=$aluno[0]['TITULO']?>
    </td>
  </tr>
</table><br/>
    <table width="100%" align="center" cellpadding="1" cellspacing="5" style="border: 1px solid #000">
  <tr>
    <td height="20" align="left" style="font-family: 'Arial Narrow'; font-size: 13px">
     
        1.	Sua prova é um documento, sendo assim, não serão aceitos desenhos, símbolos ou outros não pertinentes as questões da avaliação;<br/>
        2.	Esta avaliação consta de vinte (20) questões objetivas, valendo (0,3) cada e quatro (4) questões discursivas, valendo (1,0) cada, podendo estas últimas serem subdivididas e cada subdivisão receber pontuação proporcional;<br/>
        3.	Assine sua prova no cabeçalho acima, antes de iniciar a resolução da avaliação;<br/>
        4.	Só serão aceitas as questões objetivas e discursivas respondidas com caneta esferográfica azul ou preta;<br/>
        5.	As avaliações são elaboradas de acordo com o tempo estimado para a realização das mesmas, o aluno será avisado quando faltar 15 min para o término do tempo e <strong>NÃO SERÁ CEDIDO TEMPO EXTRA</strong> para preenchimento de gabarito ou resolução de questões;<br/>
        6.	Utilize o verso das folhas para rascunho, quando for o caso;<br/>
        7.	<strong>É PROIBIDO</strong>: pedir material emprestado, o uso de líquido corretor, calculadora e o uso de qualquer meio eletrônico de comunicação;<br/>
        8.	<strong>PORTAR (mesmo que não consulte)</strong> ou <strong>USAR</strong> meios ilícitos (cola) são considerados <strong>TRANSGRESSÕES GRAVES</strong>. Neste caso, o aluno será retirado de sala, terá sua avaliação recolhida e responderá às sanções regulamentares previstas.<br/>
        9.	Nas questões de múltipla escolha, assinale apenas uma alternativa, preenchendo totalmente o espaço correspondente à alternativa correta no gabarito; <img src="<?=SCL_IMG?>cartao_resposta.png" /><br/>
        10.	As questões objetivas serão computadas exclusivamente pelo gabarito (cartão resposta) e não pelo caderno de provas<br/>
        11.	Questões objetivas rasuradas ou com mais de uma alternativa marcada serão anuladas;<br/>
        12.	As questões discursivas deverão ser respondidas com letra legível e sem rasura. Em caso de erro, fará um único risco, ex:  <strike>retificação</strike>. <br/>
        13.	Após o recebimento da prova o (a) aluno (a) se julgar conveniente poderá no prazo de 48h requerer a revisão da sua avaliação na secretária da escola. <br/>
        14.     O enunciado das questões, assim como suas alternativas, poderão ter continuidade na página seguinte do caderno de provas. Leia com atenção.
       
    </td>
  </tr>
</table>

</body>
</html>