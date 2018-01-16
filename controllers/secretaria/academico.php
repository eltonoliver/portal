<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Academico extends CI_Controller {

    function __construct() {
        parent::__construct();
        //models sem procedure
        $this->load->model('academico/prova_conteudo_model', 'prova', true);
        $this->load->model('pajela/aula_model', 'aula', true);
        $this->load->model('sica/tipo_nota_model', 'tipo_nota', true);
        $this->load->model('sica/arquivos_model', 'arquivo', true);

        //models com procedure
        $this->load->model('responsavel_model', 'responsavel', TRUE);
        $this->load->model('professor/diario_model', 'diario', TRUE);
        $this->load->model('coordenacao/ocorrencia_model', 'ocorrencia', TRUE);
        $this->load->model('coordenacao/relatorio_model', 'relatorio', TRUE);
        $this->load->model('secretaria/secretaria_model', 'secretaria', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file', 'funcoes'));
        $this->load->library(array('form_validation', 'session', 'email', 'upload', 'pagination'));
    }

    function index() {
        $data['titulo'] = 'Agenda de Aula';
        $this->load->view('/secretaria/academico/tempo_view', $data);
    }

    function agenda() {
        $data['titulo'] = 'Agenda de Aula';
        $this->load->view('/secretaria/academico/agenda', $data);
    }

    function agenda_lista() {
        $parametro = array(
            'operacao' => 'AC',
            'aluno' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
            'dt_inicio' => $this->input->get('inicio'),
            'dt_fim' => $this->input->get('fim')
        );
        $data = array(
            'conteudo' => $this->secretaria->plano_ensino($parametro),
            'titulo' => 'Agenda de Aula'
        );
        echo $this->load->view('/secretaria/academico/agenda_lista', $data);
    }

    function agenda_lista_responsavel() {
        $parametro = array(
            'operacao' => 'AC',
            'aluno' => base64_decode($this->input->get('token')),
            'dt_inicio' => $this->input->get('inicio'),
            'dt_fim' => $this->input->get('fim')
        );
        $data = array(
            'conteudo' => $this->secretaria->plano_ensino($parametro),
            'titulo' => 'Agenda de Aula'
        );
        echo $this->load->view('/secretaria/academico/agenda_lista', $data);
    }

    function tempo() {
        $data = array(
            'tempos' => $this->secretaria->tempos(array('aluno' => $this->session->userdata('SCL_SSS_USU_CODIGO'), 'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'))),
        );
        $this->load->view('/secretaria/academico/tempos', $data);
    }

    function boletim() {
        $parametro = array('aluno' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
            'curso' => NULL,
            'serie' => NULL,
            'turma' => NULL,
            'tipo' => 1
        );
        $data['boletim'] = $this->secretaria->boletim($parametro);
        $this->load->view('secretaria/academico/boletim', $data);
    }

    function demonstrativo() {
        $parametro = array('aluno' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
            'curso' => NULL,
            'serie' => NULL,
            'turma' => NULL,
            'tipo' => 2
        );
        $data['boletim'] = $this->secretaria->boletim($parametro);
        $data['aluno'] = $this->session->userdata('SCL_SSS_USU_CODIGO');

        $this->load->view('secretaria/academico/demonstrativo', $data);
    }

    function disciplina() {
        $parametro = array('aluno' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
            'curso' => NULL,
            'serie' => NULL,
            'turma' => NULL,
            'tipo' => 1
        );
        $data = array(
            'disciplina' => $this->secretaria->aluno(array('operacao' => 'D', 'aluno' => $this->session->userdata('SCL_SSS_USU_CODIGO'))),
            'titulo' => '<i class="fa fa-users"></i> Secretaria <i class="fa fa-angle-right"></i> Disciplinas'
        );

        $this->load->view('secretaria/academico/disciplina', $data);
    }

    function tabela_disc() {
        $disciplina = $this->input->get_post('disciplina');
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $turma = $this->session->userdata('SCL_SSS_USU_TURMA');

        $conteudos = $this->aula->listaConteudo($disciplina, $turma, $periodo);
        $arquivos = $this->arquivo->listar($turma, $disciplina);
        $provas = $this->prova->listaProvasDisciplina(array(
            'CD_TURMA' => $this->session->userdata('SCL_SSS_USU_TURMA'),
            'CD_DISCIPLINA' => $this->input->get_post("disciplina"),
            'PERIODO' => $this->session->userdata("SCL_SSS_USU_PERIODO")
        ));

        //obter as provas da disciplina e turma do aluno logado
        foreach ($provas as &$row) {
            if (!empty($row['DT_INICIO']) && !empty($row['DT_FIM'])) {
                $row['CONTEUDOS'] = $this->aula->listaConteudoPeriodo(array(
                    "DT_INICIO" => $row['DT_INICIO'],
                    "DT_FIM" => $row['DT_FIM'],
                    "PERIODO" => $row['PERIODO'],
                    "CD_DISCIPLINA" => $row['CD_DISCIPLINA'],
                    "CD_TURMA" => $row['CD_TURMA'],
                ));
            }

            //obter a descrição do tipo de nota da prova agendada            
            $tipo = $this->tipo_nota->consultar($provas[$i]['CD_TIPO_NOTA']);
            $row['DESC_TIPO_NOTA'] = $row['BIMESTRE'] . "º Bimestre" . " - "
                    . $tipo ['NM_MINI'] . " (" . date("d/m/Y", strtotime($row['DT_PROVA'])) . ")";
        }

        $data = array(
            'conteudos' => $conteudos,
            'arquivos' => $arquivos,
            'provas' => $provas,
        );

        $this->load->view('secretaria/academico/tabela_disc', $data);
    }

}
