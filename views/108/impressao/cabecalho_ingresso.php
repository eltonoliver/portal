<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
    </head>
    <body>
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="5" >
            <? if($prova[0]['CD_TIPO_PROVA'] == 5){ ?>
            <tr>
                <td height="100" width="80%" align="left" style="font-family: 'Arial Narrow'; font-size: 12px">
                    Curso: <?= $prova[0]['NM_CURSO_RED'] ?><br/>
                    Série: <?= $prova[0]['ORDEM_SERIE'].(($prova[0]['NM_CURSO'] == 3) ? 'º ANO' : 'ª SÉRIE')?><br/>
                    Candidato(a): <?= $aluno[0]['NM_ALUNO'] ?><br/>
                    Data: <?=date('d/m/Y',strtotime(implode("-",array_reverse(explode("/", $prova[0]['DT_PROVA'] ))))); ?><br/>
                </td>
                <td width="100px">
                </td>
            </tr>
            <tr>
                <td height="10" width="80%" align="left" style="font-family: 'Arial Narrow'; font-size: 12px">
                    Assinatura do(a) Candidato(a): __________________________________________________________________________
                </td>
                <td width="10px" align="center" style="font-family: 'Arial Narrow'; font-size: 10px">
                    <?= $prova[0]['NUM_PROVA'] ?>
                </td>
            </tr>
            <? }elseif($prova[0]['CD_TIPO_PROVA'] == 1 && $prova[0]['CD_CURSO'] == 3 && $prova[0]['ORDEM_SERIE'] == 3){ ?>
            <tr>
                <td height="100" width="80%" align="left" style="font-family: 'Arial Narrow'; font-size: 12px">
                    Curso: <?=$prova[0]['NM_CURSO_RED']?><br/>
                    Matrícula: <?=$aluno[0]['CD_ALUNO']?><br/>
                    Aluno(a): <?=$aluno[0]['NM_ALUNO']?><br/>
                    Prova: <?=$prova[0]['NUM_PROVA']?><br/>
                    Data: <?=(($prova[0]['DT_PROVA'] != '')? date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$prova[0]['DT_PROVA']))))):'')?><br/>
                </td>
                <td width="100px" style="border:1px solid #000">
                     <? $img = $aluno[0]['CD_ALUNO'].$prova[0]['NUM_PROVA'] ?>
                    <img id="img" style="margin:0 auto;" height="100" src="<?= base_url('108/impressao/qrcode/' . $img . '') ?>" /><br/>
                </td>
              </tr>
            <? } ?>
        </table>

        <br/>
        <br/><br/>
        <table width="100%" align="center" cellpadding="1" cellspacing="0" style="border: 1px solid #000">
            <tr>
                <td height="20" align="center">
                    <?=strtoupper($prova[0]['TITULO'].'<BR/>'.$prova[0]['DISCIPLINAS'])?>
                </td>
            </tr>
        </table>
        <br/>
        <br/>
        <table width="100%" align="center" cellpadding="1" cellspacing="5" style="border: 1px solid #000">
            <tr>
                <td height="20" align="left" style="font-family: 'Arial Narrow'">
                    <h3>Leia atentamente as instruções seguintes:</h3>
                    <br/><br/>
                </td>
            </tr>
            <tr>
                <td height="20" align="left" style="font-family: 'Arial Narrow'; font-size: 12px; text-align: justify;">
                    <? if($prova[0]['CD_TIPO_PROVA'] == 5){ ?>
                        <ol style="list-style-type:decimal; text-align: justify">
                            <li> Sua prova é um  documento, sendo assim, não serão aceitos desenhos, símbolos ou outros não pertinentes as questões da avaliação.</li>
                            <li> Esta avaliação consta de  80 (oitenta) questões objetivas, sendo 20 (vinte) questões por disciplina valendo 0,5 (zero virgula cinco) cada.</li>
                            <li> Assine sua avaliação no campo acima, antes de iniciar a resolução das questões.</li>
                            <li> Só serão aceitas as questões objetivas respondidas com caneta esferográfica azul ou preta;</li>
                            <li> A Avaliação é elaborada de acordo com o tempo estimado para a realização da mesma, o(a) candidato(a)  terá 2 hs (duas horas) para resolver as questões e marcar o cartão resposta.</li>
                            <li> O(a) candidato(a) será avisado quando faltar 15 min (quinze minutos) para o término do tempo e NÃO SERÁ CEDIDO TEMPO EXTRA para preenchimento de gabarito ou resolução de questões.</li>
                            <li> Nas questões de múltipla escolha, assinale apenas uma alternativa , preenchendo totalmente o espaço  correspondente à alternativa correta   (  ).</li>
                            <li> As questões objetivas serão computadas exclusivamente pelo gabarito (cartão resposta) e não pelo caderno de provas.</li>
                            <li> Questões objetivas rasuradas ou com mais de uma alternativa marcada serão anuladas.</li>
                            <li> O enunciado das questões, assim como suas alternativas, poderão ter continuidade na página seguinte. Leia com atenção.</li>
                        </ol>
                    <? }elseif($prova[0]['CD_TIPO_PROVA'] == 1 && $prova[0]['CD_CURSO'] == 3 && $prova[0]['ORDEM_SERIE'] == 3){ ?>
                               1. Assine sua avaliação no campo acima, antes de iniciar a resolução das questões;<br><br>
                           
                               2.  Esta avaliação consta de  80 (oitenta) questões objetivas, sendo 20 (vinte) questões por disciplina valendo 0,5 (zero virgula cinco) cada, sendo computada separadamente para cada disciplina.
                               Assim, o valor máximo para cada disciplina é de 10 (dez) pontos.<br><br>
                           
                               3. Sua prova é um documento, sendo assim, não serão aceitos desenhos, símbolos ou outros não pertinentes as questões da avaliação. <br><br>
                           
                               4. Só serão aceitas as questões objetivas respondidas com caneta esferográfica azul ou preta; <br><br>
                           
                               5. O tempo para resolução da avaliação será determinado pelo aplicador, o aluno será avisado quando faltar 15 minutos para o término e NÃO SERÁ CEDIDO TEMPO EXTRA para preenchimento de gabarito; <br><br>
                           
                              6.  Utilize o verso das folhas para rascunho, quando for o caso; <br><br>
                           
                              7.  É PROIBIDO: pedir material emprestado, usar líquido corretor, calculadora ou qualquer meio eletrônico de comunicação;<br><br>
                           
                              8.  PORTAR (mesmo que não consulte) ou USAR meios ilícitos (cola) são considerados TRANSGRESSÕES GRAVES. Neste caso, o aluno será retirado de sala, terá sua avaliação recolhida e responderá às sanções regulamentares previstas;<br><br>
                           
                              9.  Nas questões de múltipla escolha, assinale apenas uma alternativa, preenchendo totalmente o espaço correspondente à alternativa correta; 
                              <img src="<?=base_url('assets/images/quadrado-preto.jpg')?>" width="15px" height="15px" /><br><br>
                           
                              10.  Questões objetivas rasuradas ou com mais de uma alternativa marcada serão anuladas e computadas exclusivamente pelo gabarito (cartão resposta) e não pelo caderno de provas. <br><br>
                            
                              11.  O enunciado das questões, assim como suas alternativas, poderá ter continuidade na página seguinte.<br><br>
                              
                              12.  Após o recebimento da prova o (a) aluno (a) se julgar conveniente poderá no prazo de 48h requerer a revisão da sua avaliação na secretaria da escola.<br><br>
                    <? } ?>
                    </div>
                </td>
            </tr>
        </table>

        <? // exit();?>