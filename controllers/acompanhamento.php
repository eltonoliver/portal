<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acompanhamento extends CI_Controller {

    function __construct() {
        parent::__construct();
        //models sem procedure
        $this->load->model('academico/prova_conteudo_model', 'prova', true);
        $this->load->model('academico/registro_pedagogico_model', 'registro');
        $this->load->model('academico/registro_diario_model', 'registro_diario');
        $this->load->model('pajela/aula_model', 'aula', true);
        $this->load->model('pajela/bimestre_model', 'bimestre', true);
        $this->load->model('pajela/livro_assunto_model', 'livro', true);
        $this->load->model('sica/aluno_model', 'aluno', true);
        $this->load->model('sica/responsavel_model', 'responsavel', true);
        $this->load->model('sica/arquivos_model', 'arquivo', true);
        $this->load->model('sica/matricula_model', 'matricula', true);
        $this->load->model('sica/tipo_nota_model', 'tipo_nota', true);
        $this->load->model('sica/turma_model', 'turma', true);

        //models com procedure        
        $this->load->model('professor/diario_model', 'diario', TRUE);
        $this->load->model('coordenacao/ocorrencia_model', 'ocorrencia', TRUE);
        $this->load->model('coordenacao/relatorio_model', 'relatorio', TRUE);
        $this->load->model('secretaria/secretaria_model', 'secretaria', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file'));
        $this->load->library(array('form_validation', 'session', 'email', 'upload', 'pagination'));
    }

    function index() {
        $data = array(
            'titulo' => '<h1> Acompanhamento de Aluno </h1>',
            'alunos' => $this->responsavel->listarAlunos($this->session->userdata('SCL_SSS_USU_CODIGO'))
        );

        $this->load->view('acompanhamento/index', $data);
    }

    function aluno() {
        $token = $this->input->get("token");
        $aluno = base64_decode($token);

        $data = array(
            'titulo' => '<h1> Acompanhamento de Aluno </h1>',
            'aluno' => $this->aluno->consultar($aluno),
            'token' => $token,
        );

        $this->load->view('acompanhamento/aluno', $data);
    }

    function tempos() {
        $token = $this->input->get("token");
        $aluno = base64_decode($token);

        $data = array(
            'titulo' => '<h1>  Acompanhamento de Aluno - Demonstrativo de Notas </h1>',
            'tempos' => $this->secretaria->tempos(array(
                'aluno' => $aluno,
                'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO')
            )),
        );
        $this->load->view('acompanhamento/tempos', $data);
    }

    function agenda() {
        $token = $this->input->get("token");
        $aluno = base64_decode($token);

        $data = array(
            'titulo' => '<h1> Acompanhamento de Aluno - Agenda</h1>',
            'aluno' => $this->aluno->consultar($aluno),
            'token' => $token
        );

        $this->load->view('acompanhamento/agenda', $data);
    }

    function boletim() {
        $token = $this->input->get("token");
        $aluno = base64_decode($token);

        $parametro = array(
            'aluno' => $aluno,
            'curso' => NULL,
            'serie' => NULL,
            'turma' => NULL,
            'tipo' => 1
        );
        $data['boletim'] = $this->secretaria->boletim($parametro);
        $data['aluno'] = $aluno;

        $this->load->view('acompanhamento/boletim', $data);
    }

    function demonstrativo() {
        $token = $this->input->get("token");
        $aluno = base64_decode($token);

        $dados = $this->aluno->consultar($aluno);
        $disciplinas = $this->turma->listaDisciplinas($dados['TURMA_ATUAL']);

        $parametro = array(
            'aluno' => $aluno,
            'curso' => NULL,
            'serie' => NULL,
            'turma' => NULL,
            'tipo' => 2
        );

        $data = array(
            'titulo' => '<h1>  Acompanhamento de Aluno - Demonstrativo de Notas </h1>',
            'token' => $token,
            'aluno' => $this->aluno->consultar($aluno),
            'bimestre' => $this->bimestre->getBimestreCorrente(),
            'boletim' => $this->secretaria->boletim($parametro),
            'disciplinas' => $disciplinas,
        );

        $this->load->view('acompanhamento/demonstrativo', $data);
    }

    function demonstrativoGraficoComparativo() {
        $token = $this->input->post("token");
        $disciplina = $this->input->post("disciplina");

        $aluno = base64_decode($token);
        $registros = $this->tipo_nota->listaNotasComparativa($aluno, $disciplina);

        $data = array(
            'registros' => $registros,
            'disciplina' => $disciplina
        );

        $this->load->view('acompanhamento/demonstrativo-grafico-comparativo', $data);
    }

    function disciplina() {
        $token = $this->input->get("token");
        $matricula = base64_decode($token);
        $periodo = $this->session->userdata("SCL_SSS_USU_PERIODO");

        $data = array('titulo' => '<h1>  A companhamento de Aluno - Demonstrativo de Notas </h1>',
            'token' => $token,
            'disciplinas' => $this->matricula->listaDisciplinas($matricula, $periodo),
            'aluno' => $this->aluno->consultar($matricula),
        );

        $this->load->view('acompanhamento/disciplina', $data);
    }

    function detalhesDisciplina() {
        $disciplina = $this->input->post("disciplina");
        $turma = $this->input->post("turma");
        $periodo = $this->session->userdata("SCL_SSS_USU_PERIODO");

        $conteudos = $this->aula->listaConteudo($disciplina, $turma, $periodo);
        $arquivos = $this->arquivo->listar($turma, $disciplina);
        $provas = $this->prova->listaProvasDisciplina(array(
            'CD_TURMA' => $turma,
            'CD_DISCIPLINA' => $disciplina,
            'PERIODO' => $periodo
        ));

        /**
         * Obter os conteúdos que foram lançados por data
         */
        foreach ($provas as &$row) {
            if (!empty($row['DT_INICIO']) && !empty($row['DT_FIM'])) {
                $params = array(
                    "DT_INICIO" => $row['DT_INICIO'],
                    "DT_FIM" => $row['DT_FIM'],
                    "PERIODO" => $row['PERIODO'],
                    "CD_DISCIPLINA" => $row['CD_DISCIPLINA'],
                    "CD_TURMA" => $row['CD_TURMA'],
                );

                $row['CONTEUDOS'] = $this->aula->listaConteudoPeriodo($params);
            }

            //obter a descrição do tipo de nota da prova            
            $row['DESCRICAO_NOTA'] = $row['BIMESTRE'] . "º Bimestre - " . $row['NM_MINI']
                    . " (" . date("d/m/Y", strtotime($row['DT_PROVA'])) . ")";
        }

        $data = array(
            'conteudos' => $conteudos,
            'arquivos' => $arquivos,
            'provas' => $provas,
        );

        $this->load->view('acompanhamento/detalhes-disciplina', $data);
    }

    function ocorrencia() {
        $data = array(
            'titulo' => '<h1> Acompanhamento de Aluno - Ocorrências </h1>',
            'alu' => $this->responsavel->acompanhamento(array('operacao' => 'FA', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'), 'aluno' => base64_decode($this->input->get('token')))),
            'disciplina' => $this->secretaria->aluno(array('operacao' => 'D', 'aluno' => base64_decode($this->input->get('token')))),
            'aluno' => $this->input->get_post('token'),
            'active' => 'ocorrencia'
        );
        $data['lista'] = $this->aluno->listaOcorrencias(base64_decode($this->input->get('token')));

        $this->load->view('acompanhamento/ocorrencia_aluno', $data);
    }

    function registrosPedagogicos() {
        $token = $this->input->get("token");
        $aluno = base64_decode($token);
        $periodo = $this->session->userdata("SCL_SSS_USU_PERIODO");

        $data = array(
            'registros' => $this->registro->listaRegistros($aluno, $periodo),
            'advertencias' => $this->registro->listaAdvertencias($aluno, $periodo),
            'suspensoes' => $this->registro->listaSuspensoes($aluno, $periodo)
        );

        $this->load->view("acompanhamento/registros-pedagogicos", $data);
    }

    function registrosDiarios() {
        $token = $this->input->get("token");
        $aluno = base64_decode($token);
        $periodo = $this->session->userdata("SCL_SSS_USU_PERIODO");

        $data = array(
            'registros' => $this->registro_diario->listaRegistros($aluno, $periodo)
        );

        $this->load->view("acompanhamento/registros-diarios", $data);
    }

    function gabarito() {
        $token = $this->input->post("token");
        $bimestre = $this->input->post("bimestre");
        $aluno = base64_decode($token);

        $data = array(
            'aluno' => $this->aluno->consultar($aluno),
            'provas' => $this->aluno->listaGabaritosProvas($aluno, $bimestre)
        );

        $this->load->view('acompanhamento/grid-gabarito-prova', $data);
    }

    function gabaritoProvaOnline() {
        $token = $this->input->post("token");
        $bimestre = $this->input->post("bimestre");
        $aluno = base64_decode($token);

        $aux = $this->aluno->listaGabaritosProvasOnline($aluno, $bimestre);

        //montar um vetor de provas em que um dos elementos é um vetor com todas
        //as resposta, gabarito e tempo de resolução
        $provas = array();
        $codigoProva = null;
        $i = -1;
        foreach ($aux as $row) {
            if ($codigoProva != $row['CD_PROVA']) {
                $i++;
                $codigoProva = $row['CD_PROVA'];
                $provas[$i] = $row;
            }

            if ($codigoProva == $row['CD_PROVA']) {
                $provas[$i]['QUESTOES'][] = array(
                    'POSICAO' => $row['POSICAO'],
                    'CORRETA' => $row['CORRETA'],
                    'RESPOSTA' => $row['RESPOSTA'],
                    'NR_TEMPO_RESPOSTA' => $row['NR_TEMPO_RESPOSTA']
                );
            }
        }

        $data = array(
            'aluno' => $this->aluno->consultar($aluno),
            'provas' => $provas,
        );

        $this->load->view('acompanhamento/grid-gabarito-prova-online', $data);
    }

    function rematricula($aluno) {

        $data = array(
            'rematricula' => $this->responsavel->rematricula(array('operacao' => 'F', 'aluno' => $aluno, 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO')))
        );

        $this->load->view('acompanhamento/rematricula', $data);
    }

    function SolicitacaoRematricula($aluno) {

        $data = array(
            'rematricula' => $this->responsavel->rematricula(array('operacao' => 'F', 'aluno' => $aluno, 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'))),
            'proxima' => $this->responsavel->aes_cl_alu_proxima_serie(array('aluno' => $aluno)
            )
        );

        $html = $this->load->view('acompanhamento/solicitacao-rematricula', $data);
    }

    function impSolicitacaoRematricula($aluno) {

        $data = array(
            'rematricula' => $this->responsavel->rematricula(array('operacao' => 'F', 'aluno' => $aluno, 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'))),
            'proxima' => $this->responsavel->aes_cl_alu_proxima_serie(array('aluno' => $aluno))
        );

        $html = $this->load->view('impressao/secretaria/rematricula', $data, true);

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $mpdf->SetHTMLHeader($this->load->view('impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', 2, // margin_left
                1, // margin right
                25, // margin top
                30, // margin bottom
                0, // margin header
                0); // margin footer 
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer', $data, true));
        $mpdf->WriteHTML($html);
        $mpdf->Output('renovacao_2017-' . $aluno . '.pdf', 'D');
    }

    function frmManterRematricula($id) {

        $params = array(
            'operacao'
            => 'I',
            'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
            'aluno' => $id
        );

        $this->responsavel->rematricula($params);
        echo '<div class="panel-footer">Renovação Realizada</div>';
    }

}
