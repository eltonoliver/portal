<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prova_gabarito extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("gabarito/aval_prova_aluno_questao_model", "provaAlunoQuestao", true);

        $this->load->model('gabarito/cadastro_model', 'cadastro', TRUE);
        $this->load->model('gabarito/prova_model', 'banco', TRUE);
        $this->load->model('gabarito/questao_model', 'questao', TRUE);

        $this->load->model('gabarito/questao_opcao_model', 'quest_opcao', TRUE);
        $this->load->model('gabarito/aes_prova_questao_model', 'prova_questao', TRUE);

        $this->load->model('gabarito/secretaria_model', 'secretaria', TRUE);
        $this->load->model('gabarito/colegio_model', 'colegio', TRUE);
        $this->load->model('gabarito/t_periodos_model', 'periodo', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'prova_lib', 'gabarito_lib'));
    }

    function index() {
        $data = array(
            'curso' => $this->secretaria->aluno_turma(array('operacao' => 'C')),
            'titulo' => 'GERENCIADOR DE AVALIAÇÕES',
            'SubTitulo' => 'GABARITO',
            'tipo_prova' => $this->banco->banco_prova(array('operacao' => 'TP')),
            'side_bar' => false,
            'periodo' => $this->periodo->listar(),
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/gabarito/index', $data);
    }

    /*
     * FUNÇÃO QUE MOSTRA O RESULTADO DA CONSULTA DA PAGINA INDEX DO BANCO DE PROVAS
     */

    function grdProva() {
        if ($this->input->post('filtro') == 0) {
            $p = array(
                'operacao' => (($this->input->post('tipo') == 2) ? 'FCN' : 'FCNA'), //'FCN',
                'tipo_prova' => $this->input->post('tipo'),
                'periodo' => $this->input->post('periodo'),
                'curso' => $this->input->post('curso'),
                'serie' => $this->input->post('serie'),
                'disciplina' => (($this->input->post('disciplina') == '') ? NULL : $this->input->post('disciplina')),
                'bimestre' => (($this->input->post('bimestre') == '') ? NULL : $this->input->post('bimestre')),
                'tipo_nota' => (($this->input->post('tipo_nota') == '') ? NULL : $this->input->post('tipo_nota')),
                'chamada' => (($this->input->post('chamada') == '') ? NULL : $this->input->post('chamada')),
            );
        } else {
            $p = array(
                'operacao' => 'CHECK',
                'num_prova' => $this->input->post('numProva'),
            );
        }

        $data = array(
            'resultado' => $this->banco->banco_prova($p),
        );

        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/gabarito/grdProva', $data);
    }

    function mdlViewGabarito($id) {

        $prova = $this->banco->banco_prova($p = array('operacao' => 'FC', 'prova' => $id));
        $versoes = $this->banco->banco_prova(array('operacao' => 'FPV', 'prova' => $id));
        $gabaritos = array();

        foreach ($versoes as $v) {
            $gabaritos[]['NUM_PROVA'] = 'VERSÃO - ' . $v['NUM_PROVA'];
            $gabaritos[]['TITULO'] = $v['TITULO'];
            $gabaritos[]['GABARITO'] = $this->banco->prova_detalhe(array('operacao' => 'L', 'prova' => $v['CD_PROVA']));
        }

        $data = array(
            'prova' => $prova,
            'gabarito' => $gabaritos
        );

        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/gabarito/mdlViewGabarito', $data);
    }

    function mdlGabaritarProvaSelecionarVersao($id) {

        $data = array(
            'versao' => $this->banco->banco_prova(array('operacao' => 'FPV', 'prova' => $id))
        );
        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/gabarito/mdlGabaritarProvaSelecionarVersao', $data);
    }

    function mdlGabaritarProva($cod) {

        // VERIFICA SE O PARAMETRO DE PAGINAÇÃO ESTA INICIALIZADO 
        // SENÃO ESTIVER INICIALIZA COM ZERO (0)
        if (!isset($cod))
            $cod = 1;

        // PEGA O CODIGO DA PROVA 
        $id = $this->input->post('avalProvaVersao');

        $prova = $this->banco->banco_prova(array('operacao' => 'VFC', 'prova' => $id));
        $questoes = $this->banco->prova_questao(array('operacao' => 'FK', 'prova' => $id));
        $questao = array();

        foreach ($questoes as $q) {

            if ($prova[0]['CD_PROVA_PAI'] == '') {
                // ALTERNATIVAS DA QUESTÃO
                $opcao = $this->questao->questao_resposta(array('operacao' => 'FK', 'questao' => $q['CD_QUESTAO']));
            } else {
                // ALTERNATIVAS DA QUESTÃO DE VERSÕES
                $opcao = $this->questao->questao_resposta(array('operacao' => 'FKV', 'questao' => $q['CD_QUESTAO'], 'prova' => $id));
            }

            $questao[] = array(
                'posicao' => $q['POSICAO'],
                'questao' => $q['CD_QUESTAO'],
                'descricao' => $q['DC_QUESTAO'],
                'valor' => $q['VALOR'],
                'anulada' => $q['FLG_ANULADA'],
                'cancelada' => $q['FLG_CANCELADA'],
                'opcao' => $opcao,
            );
        }

        $this->load->library('pagination');
        $config = array(
            'base_url' => base_url('108/prova_gabarito/mdlGabaritarProva/'),
            'total_rows' => $prova[0]['QTDE_QUESTOES'],
            'num_links' => $prova[0]['QTDE_QUESTOES'],
            'per_page' => 1,
            'use_page_numbers' => TRUE,
            'uri_segment' => 4
        );
        $this->pagination->initialize($config);

        $data = array(
            'prova' => $prova,
            'questoes' => $questao[$cod - 1],
            'link' => $this->pagination->create_links()
        );

        $this->load->view('' . $this->session->userdata('SGP_SISTEMA') . '/gabarito/mdlGabaritarProva', $data);
    }

    function frmManter() {

        $item = explode('-', $this->input->post('objeto'));

        $param = array(
            'prova' => $item[0],
            'questao' => $item[1],
            'opcao' => $item[2],
            'prova_pai' => $item[3],
        );
        // LIMPA AS RESPOSTAS DE 1 PARA 0
        $this->quest_opcao->limpa_resposta($param);

        //LIMPA OS CAMPOS DE FLG CASO HAJA ALGUM SIM VIRAM NÃO
        $this->prova_questao->limpa_flags($param);

        // VERIFICA A NOVA RSSPOSTA
        if ($item[2] == 'A') {
            // CASO A QUESTÃO ESTEJA SENDO ANULADA
            $this->prova_questao->anular($param);
        } elseif ($item[2] == 'C') {
            // CASO A QUESTÃO ESTEJA SENDO CANCELADA
            $this->prova_questao->cancelar($param);
        } else {
            // CASO A QUESTÃO TENHA UMA RESPOSTA DAS ALTERNATIVAS
            $this->quest_opcao->resposta($param);
        }

        $cartao = new gabarito_lib();
        $cartao->numero_prova = $item[0];
        $cartao->prova_pai = $item[3];
        echo $cartao->cartao_resposta();
        $cartao->correcao();
    }

    /*
     * IMPRESSAO DE PROVAS GABARITADAS
     * Versão de provas e gabaritos 
     */

    function avaliacao() {

        $new = new Prova_lib();

        $codigoProva = base64_decode($this->input->get_post('id'));
        $codigoAluno = base64_decode($this->input->get_post('aluno'));

        $params = array(
            'prova' => base64_decode($this->input->get_post('id')),
            'aluno' => base64_decode($this->input->get_post('aluno'))
        );

        if ($this->input->get_post('aluno') != '') {
            $aluno = $this->banco->cabecalho($params);
        }

        $prova_re = $this->banco->banco_prova(array('operacao' => 'VFC', 'prova' => base64_decode($this->input->get_post('id'))));

        if ($prova_re[0]['CD_TIPO_PROVA'] == 1 || $prova_re[0]['CD_TIPO_PROVA'] == 5) {
            redirect('108/impressao/simulado?id=' . $codigoProva . '&aluno=' . $codigoAluno . '', 'refresh');
        }

        $lista = $this->banco->prova_questao(array('operacao' => 'FK', 'prova' => base64_decode($this->input->get_post('id'))));
        $prova_atual = $this->banco->banco_prova(array('operacao' => 'FC', 'codigo' => base64_decode($this->input->get_post('id'))));

        $data = array(
            'aluno' => $aluno,
            'prova' => $prova_re,
            'listar' => $lista,
        );

        $objetiva .= '<div style="border-right:1px solid #999; padding: 0px 15px 0px 0px; margin:0px; min-height:100%; bottom:0px">';

        foreach ($data['listar'] as $row) {
            if ($row['FLG_TIPO'] == 'O') {

                // ENUNCIADO DA QUESTÃO
                $objetiva .= '<strong>' . $row['POSICAO'] . ') <br>'
                        . '<small style="color:#08C">Tema: ' . strip_tags($row['DC_TEMA']) . '<br>'
                        . 'Conteúdo: ' . strip_tags($row['DC_CONTEUDO']) . '<br></small>'
                        . '<small style="color:#08C">........................'
                        . '.........................................................................<br></small>'
                        . '' . $new->formata_texto_com_richtext($row['DC_QUESTAO']) . ''
                        . '</strong><br/>';

                // VRIFICA SE É UMA PROVA ORIGINAL OU UMA VERSÃO
                if ($prova_atual[0]['CD_PROVA_PAI'] == '') {
                    // ALTERNATIVAS DA QUESTÃO
                    $opcao = $this->cadastro->questao_resposta(array('operacao' => 'FK', 'questao' => $row['CD_QUESTAO']));
                } else {
                    // ALTERNATIVAS DA QUESTÃO DE VERSÕES
                    $opcao = $this->cadastro->questao_resposta(array('operacao' => 'FKV', 'questao' => $row['CD_QUESTAO'], 'prova' => $this->input->get_post('id')));
                }

                //$objetiva .= '<div style="font-family: Arial Narrow; font-size: 12px; text-align:justify">';

                $objetiva .= '<table style="margin-top:5px">';
                $objetiva .= '<tr><td valign="top" style="' . (($opcao[0]['FLG_CORRETA'] == 1) ? 'color: #08C; font-weight:bold' : '') . '">'
                        . 'A)</td><td style="text-align:justify; ' . (($opcao[0]['FLG_CORRETA'] == 1) ? 'color: #08C; font-weight:bold' : '') . '">'
                        . '' . $new->formata_texto_com_richtext_alternativa($opcao[0]['DC_OPCAO']) . ''
                        . '</td></tr>';
                $objetiva .= '<tr><td valign="top" style="' . (($opcao[1]['FLG_CORRETA'] == 1) ? 'color: #08C; font-weight:bold' : '') . '">'
                        . 'B)</td><td style="text-align:justify; ' . (($opcao[1]['FLG_CORRETA'] == 1) ? 'color: #08C; font-weight:bold' : '') . '">'
                        . '' . $new->formata_texto_com_richtext_alternativa($opcao[1]['DC_OPCAO']) . ''
                        . '</td></tr>';
                $objetiva .= '<tr><td valign="top" style="' . (($opcao[2]['FLG_CORRETA'] == 1) ? 'color: #08C; font-weight:bold' : '') . '">'
                        . 'C)</td><td style="text-align:justify; ' . (($opcao[2]['FLG_CORRETA'] == 1) ? 'color: #08C; font-weight:bold' : '') . '">'
                        . '' . $new->formata_texto_com_richtext_alternativa($opcao[2]['DC_OPCAO']) . ''
                        . '</td></tr>';
                $objetiva .= '<tr><td valign="top" style="' . (($opcao[3]['FLG_CORRETA'] == 1) ? 'color: #08C; font-weight:bold' : '') . '">'
                        . 'D)</td><td style="text-align:justify; ' . (($opcao[3]['FLG_CORRETA'] == 1) ? 'color: #08C; font-weight:bold' : '') . '">'
                        . '' . $new->formata_texto_com_richtext_alternativa($opcao[3]['DC_OPCAO']) . ''
                        . '</td></tr>';
                $objetiva .= '<tr><td valign="top" style="' . (($opcao[4]['FLG_CORRETA'] == 1) ? 'color: #08C; font-weight:bold' : '') . '">'
                        . 'E)</td><td style="text-align:justify; ' . (($opcao[4]['FLG_CORRETA'] == 1) ? 'color: #08C; font-weight:bold' : '') . '">'
                        . '' . $new->formata_texto_com_richtext_alternativa($opcao[4]['DC_OPCAO']) . ''
                        . '</td></tr>';


                $objetiva .= '</table>';
                if ($row['POSICAO'] != 20) {
                    $objetiva .= '<br/>';
                }

                if ($row['QTD_ESPACO'] > 0) {
                    for ($i = 0; $i <= $row['QTD_ESPACO']; $i++) {
                        $objetiva .= "<br/>";
                    }
                }
            }
        }


        $objetiva .= '</div>';
        //echo $objetiva;exit();

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('', 'A4', 9, 'Arial Narrow');

        $mpdf->debug = false;
        $mpdf->allow_output_buffering = false;

        $mpdf->list_indent_first_level = 0;
        $mpdf->max_colH_correction = 1.1;

        /* PÁGINA DE ROSTO :: INICIO */

        $mpdf->SetHTMLHeader($this->load->view('108/impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 10, // margin_left
                10, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                5); // margin footer        
        /* GERA O QRCODE */

        //$qr = $this->load->view('prova/qrcode', array('codigo'=>$data['listar'][0]['NUM_PROVA']), true);
        //$mpdf->WriteHTML($qr);
        /* GERA O CABEÇALHO DA PROVA */

        $cabeca = $this->load->view('108/impressao/cabecalho', $data, TRUE);
        $mpdf->WriteHTML($cabeca);

        /* INCLUI O RODAPÉ DA PROVA */
        $mpdf->SetHTMLFooter($this->load->view('108/impressao/footer', $data, true));
        /* PÁGINA DE ROSTO :: FINAL */

        $mpdf->SetHTMLHeader($this->load->view('108/impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 10, // margin_left
                10, // margin right
                30, // margin top
                29, // margin bottom
                0, // margin header
                5); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('108/impressao/footer', $data, true));

        $mpdf->SetDefaultBodyCSS('line-height', 1.5);
        $mpdf->SetDefaultBodyCSS('text-align', 'justify');
        $mpdf->SetColumns(2, 'J');

        $mpdf->WriteHTML($objetiva);
        //$mpdf->Output('PROVA_'.$this->input->get_post('id').'_'.$this->input->get_post('aluno').'.pdf','I');
        $mpdf->Output('PROVA_' . $this->input->get_post('id') . '_GABARITADA.pdf', 'I');
    }

    public function avaliacao_online() {
        $prova = base64_decode($this->input->get_post("prova"));
        $aluno = base64_decode($this->input->get_post("aluno"));

        $lib = new Prova_lib();

        //obter questoes, gabarito e alternativa que o aluno marcou        
        $dados = $this->provaAlunoQuestao->filtrar(array(
            array("campo" => 'CD_PROVA_VERSAO', "valor" => $prova),
            array("campo" => 'CD_ALUNO', "valor" => $aluno),
        ));

        //preparar vetor de questoes
        $questoes = array();
        foreach ($dados as $row) {
            //obter as opcoes da questao
            $aux = $this->provaAlunoQuestao->opcoes($row->CD_PROVA_VERSAO, $row->CD_QUESTAO);

            //formatar cada opcao
            $opcoes = array();
            $letra = "A";
            foreach ($aux as &$rowOpcao) {
                $opcoes[] = array(
                    'letra' => $letra,
                    'descricao' => $lib->formata_texto_com_richtext_alternativa($rowOpcao->DC_OPCAO->load())
                );

                $letra++;
            }

            //formatar cada questao e passar dados da prova
            $questoes[] = array(
                'titulo' => $row->TITULO,
                'disciplinas' => $row->DISCIPLINAS,
                'tema' => strip_tags($row->DC_TEMA),
                'conteudo' => strip_tags($row->DC_CONTEUDO->load()),
                'posicao' => $row->POSICAO,
                'questao' => $lib->formata_texto_com_richtext($row->DC_QUESTAO->load()),
                'opcoes' => $opcoes,
                'correta' => $row->CORRETA,
                'resposta' => $row->RESPOSTA,
                'tempo' => $row->NR_TEMPO_RESPOSTA,
                'anulada' => $row->FLG_ANULADA,
                'cancelada' => $row->FLG_CANCELADA
            );
        }

        $data = array(
            'questoes' => $questoes
        );

        //gerar PDF da prova
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('', 'A4', 9, 'Arial Narrow');

        $mpdf->SetHTMLHeader($this->load->view('108/impressao/header', null, true));
        $mpdf->SetHTMLFooter($this->load->view('108/impressao/footer', null, true));

        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 10, // margin_left
                10, // margin right
                30, // margin top
                29, // margin bottom
                0, // margin header
                5); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetDefaultBodyCSS('line-height', 1.5);
        $mpdf->SetDefaultBodyCSS('text-align', 'justify');
        $mpdf->WriteHTML($this->load->view("108/prova_gabarito/avaliacao_online", $data, true));

        $mpdf->Output('Prova Online.pdf', 'I');
    }
    
    
    
    
    function relatorio_opcao() {

        $new = new Prova_lib();

        $codigoProva = base64_decode($this->input->get_post('id'));
        $codigoAluno = base64_decode($this->input->get_post('aluno'));

        $params = array(
            'prova' => base64_decode($this->input->get_post('id')),
            'aluno' => base64_decode($this->input->get_post('aluno'))
        );

        if ($this->input->get_post('aluno') != '') {
            $aluno = $this->banco->cabecalho($params);
        }

        $prova_re = $this->banco->banco_prova(array('operacao' => 'VFC', 'prova' => base64_decode($this->input->get_post('id'))));

        if ($prova_re[0]['CD_TIPO_PROVA'] == 1 || $prova_re[0]['CD_TIPO_PROVA'] == 5) {
            redirect('108/impressao/simulado?id=' . $codigoProva . '&aluno=' . $codigoAluno . '', 'refresh');
        }

        $lista = $this->banco->prova_questao(array('operacao' => 'FK', 'prova' => base64_decode($this->input->get_post('id'))));
        $prova_atual = $this->banco->banco_prova(array('operacao' => 'FC', 'codigo' => base64_decode($this->input->get_post('id'))));

        $data = array(
            'aluno' => $aluno,
            'prova' => $prova_re,
            'listar' => $lista,
        );

        $objetiva .= '<div style="border-right:1px solid #999; padding: 0px 15px 0px 0px; margin:0px; min-height:100%; bottom:0px">';

        foreach ($data['listar'] as $row) {
            if ($row['FLG_TIPO'] == 'O') {

                // ENUNCIADO DA QUESTÃO
                $objetiva .= '<small style="color:#08C"><strong>' . $row['CD_QUESTAO'] . ') '
                        . 'Tema: ' . strip_tags($row['DC_TEMA']) . '<br>'
                        . 'Conteúdo: ' . strip_tags($row['DC_CONTEUDO']) . '<br></small>'
                        . '<small style="color:#08C">........................'
                        . '.........................................................................<br></small>'
                        . '' . $new->formata_texto_com_richtext($row['DC_QUESTAO']) . ''
                        . '</strong><br/>';

                // ALTERNATIVAS DA QUESTÃO
                
                $pprova = array(
                    array('campo' => 'CD_PROVA', 'valor' => $row['CD_PROVA']),
                    array('campo' => 'CD_QUESTAO', 'valor' => $row['CD_QUESTAO']),
                    
                );
                $opcao = $this->provaAlunoQuestao->auxiliar('BD_SICA.VW_PROVA_RESULTADO_OPCAO',$pprova);
                //$opcao = $this->provaAlunoQuestao->auxiliar(array('operacao' => 'FK', 'questao' => $row['CD_QUESTAO']));
               

                //$objetiva .= '<div style="font-family: Arial Narrow; font-size: 12px; text-align:justify">';

                $objetiva .= '<table style="margin-top:5px">';
                $objetiva .= '<tr><td valign="top" style="' . (($opcao[0]->CORRETA == 1) ? 'color: #228B22; font-weight:bold' : '') . '">'
                        . '('.$opcao[0]->QTD.') </td><td style="text-align:justify; ' . (($opcao[0]->CORRETA == 1) ? 'color: #228B22; font-weight:bold' : '') . '">'
                        . '' . $new->formata_texto_com_richtext_alternativa($opcao[0]->DC_OPCAO->load()) . ''
                        . '</td></tr>';
                $objetiva .= '<tr><td valign="top" style="' . (($opcao[1]->CORRETA == 2) ? 'color: #228B22; font-weight:bold' : '') . '">'
                        . '('.$opcao[1]->QTD.') </td><td style="text-align:justify; ' . (($opcao[1]->CORRETA == 2) ? 'color: #228B22; font-weight:bold' : '') . '">'
                        . '' . $new->formata_texto_com_richtext_alternativa($opcao[1]->DC_OPCAO->load()) . ''
                        . '</td></tr>';
                $objetiva .= '<tr><td valign="top" style="' . (($opcao[2]->CORRETA == 3) ? 'color: #228B22; font-weight:bold' : '') . '">'
                        . '('.$opcao[2]->QTD.') </td><td style="text-align:justify; ' . (($opcao[2]->CORRETA == 3) ? 'color: #228B22; font-weight:bold' : '') . '">'
                        . '' . $new->formata_texto_com_richtext_alternativa($opcao[2]->DC_OPCAO->load()) . ''
                        . '</td></tr>';
                $objetiva .= '<tr><td valign="top" style="' . (($opcao[3]->CORRETA == 4) ? 'color: #228B22; font-weight:bold' : '') . '">'
                        . '('.$opcao[3]->QTD.') </td><td style="text-align:justify; ' . (($opcao[3]->CORRETA == 4) ? 'color: #228B22; font-weight:bold' : '') . '">'
                        . '' . $new->formata_texto_com_richtext_alternativa($opcao[3]->DC_OPCAO->load()) . ''
                        . '</td></tr>';
                $objetiva .= '<tr><td valign="top" style="' . (($opcao[4]->CORRETA == 5) ? 'color: #228B22; font-weight:bold' : '') . '">'
                        . '('.$opcao[4]->QTD.') </td><td style="text-align:justify; ' . (($opcao[4]->CORRETA == 5) ? 'color: #228B22; font-weight:bold' : '') . '">'
                        . '' . $new->formata_texto_com_richtext_alternativa($opcao[4]->DC_OPCAO->load()) . ''
                        . '</td></tr>';


                $objetiva .= '</table>';
                if ($row['POSICAO'] != 20) {
                    $objetiva .= '<br/>';
                }

                if ($row['QTD_ESPACO'] > 0) {
                    for ($i = 0; $i <= $row['QTD_ESPACO']; $i++) {
                        $objetiva .= "<br/>";
                    }
                }
            }
        }


        $objetiva .= '</div>';
        //echo $objetiva;exit();

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF('', 'A4', 9, 'Arial Narrow');

        $mpdf->debug = false;
        $mpdf->allow_output_buffering = false;

        $mpdf->list_indent_first_level = 0;
        $mpdf->max_colH_correction = 1.1;

        /* PÁGINA DE ROSTO :: INICIO */

        $mpdf->SetHTMLHeader($this->load->view('108/impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 10, // margin_left
                10, // margin right
                30, // margin top
                30, // margin bottom
                0, // margin header
                5); // margin footer        
        /* GERA O QRCODE */

        //$qr = $this->load->view('prova/qrcode', array('codigo'=>$data['listar'][0]['NUM_PROVA']), true);
        //$mpdf->WriteHTML($qr);
        /* GERA O CABEÇALHO DA PROVA */

        $cabeca = $this->load->view('108/impressao/cabecalho', $data, TRUE);
        $mpdf->WriteHTML($cabeca);

        /* INCLUI O RODAPÉ DA PROVA */
        $mpdf->SetHTMLFooter($this->load->view('108/impressao/footer', $data, true));
        /* PÁGINA DE ROSTO :: FINAL */

        $mpdf->SetHTMLHeader($this->load->view('108/impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', '', '', '', 10, // margin_left
                10, // margin right
                30, // margin top
                29, // margin bottom
                0, // margin header
                5); // margin footer
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('108/impressao/footer', $data, true));

        $mpdf->SetDefaultBodyCSS('line-height', 1.5);
        $mpdf->SetDefaultBodyCSS('text-align', 'justify');
        $mpdf->SetColumns(2, 'J');

        $mpdf->WriteHTML($objetiva);
        //$mpdf->Output('PROVA_'.$this->input->get_post('id').'_'.$this->input->get_post('aluno').'.pdf','I');
        $mpdf->Output('PROVA_' . $this->input->get_post('id') . '_GABARITADA.pdf', 'I');
    }

}
