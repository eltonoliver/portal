<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Diario_Retroativo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //models sem procedure
        $this->load->model('pajela/aula_model', 'aula', true);
        $this->load->model('pajela/presenca_model', 'presenca', true);
        $this->load->model('pajela/livro_assunto_model', 'livro', true);
        $this->load->model('sica/configuracao_model', 'configuracao', true);
        $this->load->model("sica/turma_model", "turma", true);
        $this->load->model("sica/aluno_disciplina_model", "disciplina", true);
        $this->load->model("pajela/log_diario_model", "log", true);
        $this->load->model("sica/turma_professor_model", "turma_professor", true);

        //models com procedure        
        $this->load->model('professor/diario_model', 'diario', TRUE);
        $this->load->model('coordenacao/relatorio_model', 'conteudo', TRUE);
        $this->load->model('coordenacao/coordenador_model', 'coordenador', TRUE);
        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library(array('form_validation', 'session', 'table', 'seculo'));
    }

    public function index() {
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $professor = $this->session->userdata('SCL_SSS_USU_PCODIGO');
        $dataPendencia = $this->input->get('data');

        $aux = empty($dataPendencia) ? "" : "(" . $dataPendencia . ")";
        $titulo = '<h1> Diário de Classe <i class="fa fa-angle-double-right"></i> Lançamento Retroativo ' . $aux . '</h1>';
      
        //obter disciplinas e turmas do professor
        $disciplinas = array();
        $turmas = array();
        $lista = $this->turma_professor->listar($periodo, $professor);

       
        foreach ($lista as $row) {
            $disciplinas[] = $row['CD_DISCIPLINA'];
            $turmas[] = $row['CD_TURMA'];
        }
         

        //obter datas com pendencias e as aulas de uma determinada data
        $datas = $this->aula->listaDiasPendente($professor, $disciplinas, $turmas);
        $aulas = empty($dataPendencia) ? array() : $this->aula->listaAulasPendente($professor, $dataPendencia, $disciplinas, $turmas);

        //separar aulas de cada turno
        $manha = array();
        $tarde = array();
        foreach ($aulas as $row) {
            if ($row['TURNO'] == 'A') {
                $manha[] = $row;
            } elseif ($row['TURNO'] == 'B') {
                $tarde[] = $row;
            }
        }

        $data = array(
            "titulo" => $titulo,
            "dataPendencia" => $dataPendencia,
            "datas" => $datas,
            "manha" => $manha,
            "tarde" => $tarde
        );

        $this->load->view('professor/diario_retroativo/index', $data);
    }

    public function abrir() {
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $professor = $this->session->userdata('SCL_SSS_USU_PCODIGO');
        $disciplina = $this->input->get("disc");
        $curso = $this->input->get("curso");
        $aula = $this->input->get("aula");
        $dataPendencia = $this->input->get("data");

        $hostName = $_SERVER['REMOTE_HOST'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $this->log->registrar($aula, $hostName, $ip, "AR");

        if ($this->aula->abrirRetroativo($aula) === false) {
            set_msg('error', 'Erro ao abrir aula', 'erro');
        } else {
            $params = array(
                'CD_PROFESSOR' => $professor,
                'PERIODO' => $periodo,
                'CD_DISCIPLINA' => $disciplina,
                'CD_CURSO' => $curso
            );
            $this->plano->adicionar($params);

            set_msg('success', 'Aula aberta com sucesso', 'sucesso');
        }

        redirect("professor/diario_retroativo/index?data=" . $dataPendencia);
    }

    public function fechar() {
        $aula = $this->input->get("aula");
        $dataPendencia = $this->input->get_post("data");

        $hostName = $_SERVER['REMOTE_HOST'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $this->log->registrar($aula, $hostName, $ip, "FR");

        if ($this->aula->fecharRetroativo($aula) === false) {
            set_msg('error', 'Erro ao fechar aula', 'erro');
        } else {
            set_msg('success', 'Aula fechada com sucesso', 'sucesso');
        }

        redirect("professor/diario_retroativo/index?data=" . $dataPendencia);
    }

    public function modal_frequencia() {
        $codigo = $this->input->get("aula");
        $aula = $this->aula->consultar($codigo);

        //verificar o tipo de turma da frequência
        $turma = $this->turma->consultar($aula['CD_TURMA'], $aula['PERIODO']);

        //exibir alunos para frequência de acordo com o tipo da turma
        $alunos = array();
        if ($turma['TIPO'] == "+") {
            $alunos = $this->presenca->listaFrequenciaMista($aula['CD_CL_AULA']);
        } else {
            $alunos = $this->presenca->listaFrequenciaNormal($aula['CD_CL_AULA']);
        }

        $data = array(
            'titulo' => '<h1> Diário de Classe <i class="fa fa-angle-double-right"></i> Chamada</h1>',
            'aula' => $codigo,
            'alunos' => $alunos,
            'hasChamadaRealizada' => $this->presenca->hasChamadaRealizada($codigo),
            'hasAluno' => $this->aula->hasAluno($codigo),
            'dataPendencia' => $this->input->get("data")
        );

        $this->load->view('professor/diario_retroativo/modal_frequencia', $data);
    }

    public function modal_conteudo() {
        $codigo = $this->input->get_post('aula');
        $aula = $this->aula->consultar($codigo);
        $turma = $this->turma->consultar($aula['CD_TURMA'], $aula['PERIODO']);
        $assuntos = $this->livro->listar($turma['CD_CURSO'], $turma['CD_SERIE'], $aula['CD_DISCIPLINA']);

        $data = array(
            'aula' => $aula,
            'assuntos' => $assuntos,
            'dataPendencia' => $this->input->get("data")
        );

        $this->load->view('professor/diario_retroativo/modal_conteudo', $data);
    }

    public function salvar_frequencia() {
        $dataPendencia = $this->input->post("data");
        $codigo = $this->input->post("aula");
        $aula = $this->aula->consultar($codigo);

        //verificar o tipo de turma da frequência
        $turma = $this->turma->consultar($aula['CD_TURMA'], $aula['PERIODO']);

        //exibir alunos para frequência de acordo com o tipo da turma
        $alunos = array();
        if ($turma['TIPO'] == "+") {
            $alunos = $this->presenca->listaFrequenciaMista($aula['CD_CL_AULA']);
        } else {
            $alunos = $this->presenca->listaFrequenciaNormal($aula['CD_CL_AULA']);
        }

        //montar um vetor de alunos para salvar a frequencia
        $frequencia = array();
        foreach ($alunos as $row) {
            $aux = array(
                'CD_ALUNO' => $row['CD_ALUNO'],
                'FLG_PRESENTE' => $this->input->post($row['CD_ALUNO'])
            );

            $frequencia[] = $aux;
        }

        //verificar se vai adicionar a frequencia ou atualizar e verificar        
        $status = true;
        if ($this->presenca->hasChamadaRealizada($codigo)) {
            $status = $this->presenca->editar($codigo, $frequencia, false);
        } else {
            $status = $this->presenca->adicionar($codigo, $frequencia, false);
        }

        //verificar se registrou a frequencia normalmente
        if (!$status) {
            set_msg("error", "Ocorreu um erro ao registrar a frequência dos alunos.");
        } else {
            set_msg("success", "A frequência dos alunos foi registrada com sucesso.", "sucesso");
        }

        redirect("professor/diario_retroativo/index?data=" . $dataPendencia);
    }

    public function salvar_conteudo() {
        $data = $this->input->post("data");

        $aula = array(
            'CD_CL_AULA' => $this->input->post("aula"),
            'CONTEUDO' => $this->input->post("conteudo"),
            'TAREFA_CASA' => $this->input->post("tarefa")
        );

        $assuntos = $this->input->post("assunto");
        if ($this->aula->salvarConteudo($aula, $assuntos, false)) {
            set_msg("success", "O conteúdo ministrado na aula foi registrado com sucesso.", "sucesso");
        } else {
            set_msg("error", "Ocorreu um erro ao registrar o conteúdo ministrado na aula.");
        }

        redirect("professor/diario_retroativo/index?data=" . $data);
    }

}
