<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Diario extends CI_Controller {

    function __construct() {
        parent::__construct();
        //models sem procedure
        $this->load->model('pajela/aula_model', 'aula', true);
        $this->load->model('pajela/presenca_model', 'presenca', true);
        $this->load->model('pajela/livro_assunto_model', 'livro', true);
        $this->load->model('sica/configuracao_model', 'configuracao', true);
        $this->load->model("sica/turma_model", "turma", true);
        $this->load->model("sica/aluno_disciplina_model", "disciplina", true);
        $this->load->model("pajela/log_diario_model", "log", true);


        //models com procedure        
        $this->load->model('professor/diario_model', 'diario', TRUE);
        $this->load->model('coordenacao/relatorio_model', 'conteudo', TRUE);
        $this->load->model('coordenacao/coordenador_model', 'coordenador', TRUE);
        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library(array('form_validation', 'session', 'table', 'seculo'));
    }

    function index() {
        $professor = $this->session->userdata('SCL_SSS_USU_PCODIGO');
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $aulas = $this->aula->listaAulaDia($professor, $periodo);

        /* --  separando aulas de cada turno -- */
        $manha = array();
        $tarde = array();
        foreach ($aulas as &$row) {
            if ($row['TURNO'] == 'A') {
                $manha[] = &$row;
            } elseif ($row['TURNO'] == 'B') {
                $tarde[] = &$row;
            }
        }

        $data = array(
            "manha" => $manha,
            "tarde" => $tarde,
            "titulo" => '<h1> Diário de Classe <i class="fa fa-angle-double-right"></i> Diário Online</h1>'
        );

        //print_r($aulas);
        //exit();

        $this->load->view('professor/diario/index', $data);
    }

    function abrir_aula() {
        $parametros = $this->configuracao->parametros();
        $aula = $this->input->get("aula");

        $hostName = $_SERVER['REMOTE_HOST'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $this->log->registrar($aula, $hostName, $ip, "A");

        //validar horário de abertura da aula
        /*if (!$this->aula->validarHorario($aula)) {
            $inicio = $parametros['TOL_INI_ABERTURA'];
            $fim = $parametros['TOL_FIM_ABERTURA'];
            $mensagem = "Abertura de aulas somente com tolerância de ";
            $mensagem .= empty($inicio) ? "" : "$inicio minutos antes ";
            $mensagem .= empty($fim) ? "" : empty($inicio) ? "$fim minutos depois " : "e $fim minutos depois ";
            $mensagem .= "do horário.";

            set_msg('error', $mensagem);
            redirect(base_url('professor/diario'), 'refresh');
        }*/

        if ($this->aula->abrir($aula)) {
            $params = array(
                'CD_PROFESSOR' => $this->input->get_post('professor'),
                'PERIODO' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                'CD_DISCIPLINA' => $this->input->get_post('disc'),
                'CD_CURSO' => $this->input->get_post('curso')
            );
            $this->plano->adicionar($params);

            set_msg('success', 'Aula aberta com sucesso', 'sucesso');
        } else {
            set_msg('error', 'Erro ao abrir aula', 'erro');
        }

        redirect(base_url('professor/diario'), 'refresh');
    }

    function fechar_aula() {
        $parametros = $this->configuracao->parametros();
        $aula = $this->input->get('aula');

        $hostName = $_SERVER['REMOTE_HOST'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $this->log->registrar($aula, $hostName, $ip, "F");

        //validar horário de encerramento da aula
       /* if (!$this->aula->validarHorario($aula, false)) {
            //verificar se a validação não passou devido não cumprir o tempo minimo            
            $minutos = $this->aula->tempoMinimoRestante($aula);
            if ($minutos > 0) {
                set_msg('error', "É necessário ministrar mais $minutos minuto(s) de aula para poder encerrar a aula.", 'erro');
            } else {
                $inicio = $parametros['TOL_INI_FECHAMENTO'];
                $fim = $parametros['TOL_FIM_FECHAMENTO'];
                $mensagem = "Encerramento de aulas somente com tolerância de ";
                $mensagem .= empty($inicio) ? "" : "$inicio minutos antes ";
                $mensagem .= empty($fim) ? "" : empty($inicio) ? "até $fim minutos depois " : "e $fim minutos depois ";
                $mensagem .= "do horário.";

                set_msg('error', $mensagem, 'erro');
            }

            redirect(base_url('professor/diario'), 'refresh');
        }*/

        //verificar se realizou chamada para turmas que possuem alunos
        if ($this->aula->hasAluno($aula) && !$this->presenca->hasChamadaRealizada($aula)) {
            set_msg('error', 'A aula não pode ser fechada enquanto não for realizada a chamada.', 'erro');
            redirect(base_url('professor/diario'), 'refresh');
        }

        //verificar se lançou conteúdo
        if (!$this->diario->hasConteudoLancado($aula)) {
            set_msg('error', 'A aula não pode ser fechada enquanto não for lançado o conteúdo ministrado.');
            redirect("professor/diario");
        }

        if ($this->aula->fechar($aula)) {
            set_msg('success', 'Aula fechada com sucesso', 'sucesso');
        } else {
            set_msg('error', 'Erro ao fechar aula', 'erro');
        }

        redirect(base_url('professor/diario'), 'refresh');
    }

    //************* FREQUENCIA DOS ALUNOS ******************//

    function frequencia() {
        $aula = $this->input->get('aula');
        $data['titulo'] = '<h1> Diário de Classe <i class="fa fa-angle-double-right"></i> Chamada</h1>';
        $data['aula'] = $aula; //$this->uri->segment(7);
        $data['f'] = $this->input->get('f');

        //verifico se a chamada ja foi realizada
        $param = array('operacao' => 'LC',
            'cl_aula' => $this->input->get('aula')
        );

        $data['ch_realizada'] = $this->diario->sp_diario($param);

        //LISTA DE ALUNOS DA SALA EM QUE JA FOI REALIZADA A CHAMANDA
        if (count($data['ch_realizada'] [0]) > 0) {
            $parametro = array('operacao' => 'LCR',
                'cl_aula' => $this->input->get('aula')); //$this->uri->segment(7));
            $data['grade'] = $this->diario->sp_diario($parametro);
        } else {
            $dataPendencia = $this->input->get('data-pendencia');
            $dataFrequencia = $this->input->oracle_data(date('d/m/Y'));
            if (!empty($dataPendencia)) {
                $dataFrequencia = $this->input->oracle_data($dataPendencia);
            }

            //lista os alunos para chamada
            $parametro = array('operacao' => 'TN',
                'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                'cd_turma' => base64_decode($this->input->get('turma')), //$this->uri->segment(4),
                'subturma' => base64_decode($this->input->get('subturma')), //$this->uri->segment(4),
                'cd_disciplina' => $this->input->get('disc'), //$this->uri->segment(5),
                'cd_curso' => $this->input->get('curso'),
                'data' => $dataFrequencia
            );

            $data['grade'] = $this->diario->sp_diario($parametro);

            if (count($data['grade'] [0]) == 0) {
                $parametro = array('operacao' => 'TM',
                    'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                    'cd_turma' => base64_decode($this->input->get('turma')), //$this->uri->segment(4),
                    'subturma' => base64_decode($this->input->get('subturma')), //$this->uri->segment(4),
                    'cd_disciplina' => $this->input->get('disc'), //$this->uri->segment(5),
                    'cd_curso' => $this->input->get('curso'), //$this->uri->segment(6),
                    'data' => $dataFrequencia
                );
                $data['grade'] = $this->diario->sp_diario($parametro);
            }
        }

        $this->load->view('professor/diario/frequencia', $data);
    }

    /**
     * Exibe um modal para o professor realizar a chamada
     */
    function modal_frequencia() {
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
            'hasAluno' => $this->aula->hasAluno($codigo)
        );

        $this->load->view('professor/diario/modal_frequencia', $data);
    }

    /**
     * Salva a frequência dos alunos de uma determinada aula.
     */
    function salvar_frequencia() {
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
            $status = $this->presenca->editar($codigo, $frequencia);
        } else {
            $status = $this->presenca->adicionar($codigo, $frequencia);
        }

        //verificar se registrou a frequencia normalmente
        if (!$status) {
            set_msg("error", "Ocorreu um erro ao registrar a frequência dos alunos.");
        } else {
            set_msg("success", "A frequência dos alunos foi registrada com sucesso.", "sucesso");
        }

        redirect("professor/diario/index");
    }

    /**
     * Exibe o modal para preenche o conteúdo ministrado na aula
     */
    function modal_conteudo() {
        $codigo = $this->input->get_post('aula');
        $aula = $this->aula->consultar($codigo);
        $turma = $this->turma->consultar($aula['CD_TURMA'], $aula['PERIODO']);
        $assuntos = $this->livro->listar($turma['CD_CURSO'], $turma['CD_SERIE'], $aula['CD_DISCIPLINA']);

        $data = array(
            'aula' => $aula,
            'assuntos' => $assuntos,
            'dataPendencia' => $this->input->get("data")
        );

        $this->load->view('professor/diario/modal_conteudo', $data);
    }

    /**
     * Salvar o conteúdo informado no modal de conteudo da aula.
     */
    function salvar_conteudo() {
        $data = $this->input->post("data");
        
        $aula = array(
            'CD_CL_AULA' => $this->input->post("aula"),
            'CONTEUDO' => $this->input->post("conteudo"),
            'TAREFA_CASA' => $this->input->post("tarefa")
        );

        $assuntos = $this->input->post("assunto");
        $checkGeminado = empty($data);

        if ($this->aula->salvarConteudo($aula, $assuntos, $checkGeminado)) {
            set_msg("success", "O conteúdo ministrado na aula foi registrado com sucesso.", "sucesso");
        } else {
            set_msg("error", "Ocorreu um erro ao registrar o conteúdo ministrado na aula.");
        }        

        if (!empty($data)) {
            redirect("professor/diario/conteudo_retroativo?data=" . $data);
        }

        redirect("professor/diario/index");
    }

    /**
     * Exibe o modal com a listagem de todos os conteúdos ministrados 
     * pelo professor em uma turma e disciplina.
     */
    function modal_lista_conteudo() {
        $codigo = $this->input->get("aula");
        $aula = $this->aula->consultar($codigo);

        $params = array(
            "CD_TURMA" => $aula['CD_TURMA'],
            "CD_DISCIPLINA" => $aula['CD_DISCIPLINA'],
            "PERIODO" => $aula['PERIODO'],
            "CD_PROFESSOR" => $aula['CD_PROFESSOR'],
        );

        $aulas = $this->aula->listar($params);

        $data = array(
            "aulas" => $aulas
        );

        $this->load->view("professor/diario/modal_lista_conteudo", $data);
    }

    /**
     * Exibe um modal com todos os alunos daquela aula
     */
    function modal_lista_aluno() {
        $codigo = $this->input->get("aula");
        $aula = $this->aula->consultar($codigo);

        $aulas = $this->disciplina->listaAlunos($aula['CD_TURMA'], $aula['CD_DISCIPLINA'], $aula['PERIODO']);

        $data = array(
            "alunos" => $aulas
        );

        $this->load->view("professor/diario/modal_lista_aluno", $data);
    }

    function confirmar_frequencia() {
        $parametro = array('operacao' => 'TN',
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
            'cd_turma' => base64_decode($this->input->post('turma')),
            'subturma' => base64_decode($this->input->post('subturma')),
            'cd_disciplina' => $this->input->post('disciplina'),
            'data' => $this->input->oracle_data(date('d/m/Y'))
        );

        $alunos = $this->diario->sp_diario($parametro);
        $aula = $this->input->get_post('aula');

        if (isset($alunos['RETORNO']) && isset($alunos['CURSOR'])) {
            $parametro = array('operacao' => 'TM',
                'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                'cd_turma' => base64_decode($this->input->post('turma')),
                'subturma' => base64_decode($this->input->post('subturma')),
                'cd_disciplina' => $this->input->post('disciplina'),
                'cd_curso' => $this->input->post('curso'),
                'data' => $this->input->oracle_data(date('d/m/Y'))
            );

            $alunos = $this->diario->sp_diario($parametro);
        }

        foreach ($alunos as $row) {
            $item = explode(':', $this->input->get_post($row['CD_ALUNO']));
            $param = array('operacao' => 'IF',
                'cl_aula' => $aula,
                'cd_aluno' => $item[0],
                'frequencia' => $item[1]
            );
            $this->diario->sp_diario($param);
        }
        set_msg('msgok', 'Chamada realizada com sucesso', 'sucesso');

        /*
         * checar se irá redireiconar de volta para o diário normal ou diário de
         * lançamento retroativo
         */
        $dataPendencia = $this->input->get_post("data-pendencia");
        if (empty($dataPendencia)) {
            redirect(base_url('professor/diario'), 'refresh');
        } else {
            redirect(site_url("professor/diario/retroativo") . "?data=" . $dataPendencia);
        }
    }

    function editar_frequencia() {
        $parametro = array('operacao' => 'TN',
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
            'cd_turma' => base64_decode($this->input->post('turma')),
            'subturma' => base64_decode($this->input->post('subturma')),
            'cd_disciplina' => $this->input->post('disciplina'),
            'cd_curso' => $this->input->post('curso'),
            'data' => $this->input->oracle_data(date('d/m/Y'))
        );
        $alunos = $this->diario->sp_diario($parametro);
        $aula = $this->input->get_post('aula');

        if (!isset($alunos['RETORNO']) && !isset($alunos['CURSOR'])) {
            $parametro = array('operacao' => 'TM',
                'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                'cd_turma' => base64_decode($this->input->post('turma')),
                'subturma' => base64_decode($this->input->post('subturma')),
                'cd_disciplina' => $this->input->post('disciplina'),
                'cd_curso' => $this->input->post('curso'),
                'data' => $this->input->oracle_data(date('d/m/Y'))
            );

            $alunos = $this->diario->sp_diario($parametro);
        }

        foreach ($alunos as $row) {
            $item = explode(':', $this->input->get_post($row['CD_ALUNO']));
            $parametro = array('operacao' => 'EF',
                'cl_aula' => $aula,
                'cd_aluno' => $item[0],
                'frequencia' => $item[1]
            );
            $this->diario->sp_diario($parametro);
        }
        set_msg('msgok', 'Chamada realizada com sucesso', 'sucesso');

        /*
         * checar se irá redireiconar de volta para o diário normal ou diário de
         * lançamento retroativo
         */
        $dataPendencia = $this->input->get_post("data-pendencia");
        if (empty($dataPendencia)) {
            redirect(base_url('professor/diario'), 'refresh');
        } else {
            redirect(site_url("professor/diario/retroativo") . "?data=" . $dataPendencia);
        }
    }

    function conteudo() {
        $aula = $this->input->get_post('aula');

        $parametro = array('operacao' => 'LCT',
            'cd_turma' => base64_decode($this->input->get('turma')),
            'subturma' => base64_decode($this->input->get('subturma')),
            'cl_aula' => $aula,
            'serie' => $this->input->get_post('serie'),
            'cd_disciplina' => $this->input->get_post('disc'),
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO')
        );

        $parametro1 = array('operacao' => 'LCA2',
            'cd_curso' => $this->input->get_post('curso'),
            'serie' => $this->input->get_post('serie'),
            'cd_disciplina' => $this->input->get_post('disc'),
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO')
        );

        $data['lancado'] = $this->diario->sp_diario($parametro);
        $data['conteudo_lancado'] = $data['lancado'];
        $data['assunto'] = $this->diario->sp_diario($parametro1);

        $requer = $this->input->get_post("requer");
        if (empty($requer)) {
            $data['requer'] = "S";
        } else {
            $data['requer'] = "N";
        }

        $this->load->view('professor/diario/conteudo_ministrado', $data);
    }

    function confirmar_conteudo() {

        $parametro = array('operacao' => 'IC',
            'cl_aula' => $this->input->get_post('cl_aula'),
            'conteudo' => $this->input->get_post('conteudo'),
            'tarefa' => $this->input->get_post('tarefa')
        );

        //print_r($_POST);exit;

        if ($this->diario->sp_diario($parametro)) {
            set_msg('msgok', 'Conteúdo cadastrado com sucesso', 'sucesso');
        } else {
            set_msg('msgerro', 'Erro ao cadastrar o conteúdo', 'erro');
        }

        /*
         * checar se irá redireiconar de volta para o diário normal ou diário de
         * lançamento retroativo
         */
        $dataPendencia = $this->input->get_post("data-pendencia");
        if (empty($dataPendencia)) {
            redirect(base_url('professor/diario'), 'refresh');
        } else {
            redirect(site_url("professor/diario/retroativo") . "?data=" . $dataPendencia);
        }
    }

    function editar_conteudo() {
        $parametro = array('operacao' => 'EC',
            'cl_aula' => $this->input->get_post('cl_aula'),
            'conteudo' => $this->input->get_post('conteudo'),
            'tarefa' => $this->input->get_post('tarefa')
        );

        foreach ($this->input->post('assunto') as $a) {
            $assunto = array('operacao' => 'INSASS',
                'cl_aula' => $this->input->get_post('cl_aula'),
                'cd_plano' => $a
            );
            $this->diario->sp_diario($assunto);
        }

        if ($this->diario->sp_diario($parametro)) {
            set_msg('msgok', 'Conteúdo editado com sucesso', 'sucesso');
        } else {
            set_msg('msgerro', 'Erro ao editar o conteúdo', 'erro');
        }

        /*
         * checar se irá redireiconar de volta para o diário normal ou diário de
         * lançamento retroativo
         */
        $dataPendencia = $this->input->get_post("data-pendencia");
        if (empty($dataPendencia)) {
            redirect(base_url('professor/diario'), 'refresh');
        } else {
            redirect("professor/diario/conteudo_retroativo?data=" . $dataPendencia);
        }
    }

    /**
     * Redireciona para tela com aulas em que o conteúdo não foi lançado
     */
    function conteudo_retroativo() {
        $dataPendencia = $this->input->get("data");
        $periodo = $this->session->userdata("SCL_SSS_USU_PERIODO");
        $professor = $this->session->userdata("SCL_SSS_USU_PCODIGO");

        $datas = $this->aula->listaDatasPendente($periodo, $professor);
        $aulas = $this->aula->listaConteudoPendente($periodo, $professor, $dataPendencia);

        $data = array(
            "datas" => $datas,
            "aulas" => $aulas,
            "dataPendencia" => $dataPendencia
        );

        $auxTitulo = empty($dataPendencia) ? "" : "(" . $dataPendencia . ")";
        $data['titulo'] = '<h1> Diário de Classe <i class="fa fa-angle-double-right"></i> Lançamento Conteúdo Retroativo ' . $auxTitulo . '</h1>';

        $this->load->view("professor/diario/conteudo_retroativo", $data);
    }

    function retroativo() {
        $dataPendencia = $this->input->get_post('data');

        $paramento = array('operacao' => 'RLDD',
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
            'cd_professor' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
            'data' => $this->input->oracle_data($dataPendencia),
            "opcao" => 0
        );

        $data['dataPendencia'] = $dataPendencia;
        $data['datas'] = $this->diario->sp_diario(array(
            "operacao" => "LRC",
            'cd_professor' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
        ));
        $data['aulas'] = $this->diario->sp_diario($paramento);
        $auxTitulo = empty($dataPendencia) ? "" : "(" . $dataPendencia . ")";
        $data['titulo'] = '<h1> Diário de Classe <i class="fa fa-angle-double-right"></i> Lançamento Retroativo ' . $auxTitulo . '</h1>';
        $data['block'] = true;

        $this->load->view('professor/diario/retroativo', $data);
    }

    function retroativo_abrir_aula() {
        $aula = $this->input->get("aula");
        $dataPendencia = $this->input->get_post("data-pendencia");

        $parametro = array('operacao' => 'AAB',
            'cl_aula' => $aula,
            "hr_abertura" => $this->input->get("horario"),
        );
        $iniciar = $this->diario->sp_diario($parametro);


        if ($iniciar == true) {
            $parametro = array('operacao' => 'IP',
                'cd_professor' => $this->input->get_post('professor'),
                'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                'cd_disciplina' => $this->input->get_post('disc'),
                'cd_curso' => $this->input->get_post('curso')
            );
            $this->diario->sp_diario($parametro);
            set_msg('msgok', 'Aula aberta com sucesso', 'sucesso');
        } else {
            set_msg('msgerro', 'Erro ao abrir aula', 'erro');
        }

        redirect(site_url("professor/diario/retroativo") . "?data=" . $dataPendencia);
    }

    function retroativo_fechar_aula() {
        $aula = $this->input->get("aula");
        $dataPendencia = $this->input->get_post("data-pendencia");

        //fechar a aula
        $params = array('operacao' => 'AFC',
            'cl_aula' => $aula,
            "hr_fechamento" => $this->input->get_post("horario"),
        );

        $fechar = $this->diario->sp_diario($params);

        if ($fechar == true) {
            set_msg('msgok', 'Aula fechada com sucesso', 'sucesso');
        } else {
            set_msg('msgerro', 'Erro ao fechar aula', 'erro');
        }

        redirect(site_url("professor/diario/retroativo") . "?data=" . $dataPendencia);
    }

    function lista_alunos() {
        $dados = explode(";", $this->input->get_post('parametro'));

//RETORNA OS DADOS DA ALUNA
//lista os alunos para chamada
        $parametro = array('operacao' => 'TN',
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
            'cd_professor' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
            'cd_turma' => $dados[0],
            'cd_disciplina' => $dados[1],
            'cd_curso' => $dados[2],
            'data' => $this->input->oracle_data(($dados[3]))
        );

        $grade = $this->diario->sp_diario($parametro);
        if (count($grade) == 0) {
            $parametro = array('operacao' => 'TM',
                'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                'cd_professor' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
                'cd_turma' => $dados[0],
                'cd_disciplina' => $dados[1],
                'cd_curso' => $dados[2],
                'data' => $this->input->oracle_data(($dados[3]))
            );
            $grade = $this->diario->sp_diario($parametro);
        }
//verifico o cd_al_aula
        $p = array('operacao' => 'LDAR',
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
            'cd_turma' => $dados[0],
            'cd_disciplina' => $dados[1],
            'data' => $dados[3],
            'tempo' => $dados[4]);
        $dia_aula = $this->diario->get_cd_aula($p);

        $resultado = '<div class="tab-content no-border no-padding">
                           <form action="' . SCL_RAIZ . 'professor/diario/lancar_rechamada" method="post" enctype="multipart/form-data" id="frmfrequencia" >
                            <input name="cd_aula" type="hidden" id="cd_aula" value="' . $dia_aula[0]->CD_CL_AULA . '" />
                            <input name="turma" type="hidden" id="cd_aula" value="' . $dados[0] . '" />
                            <input name="disciplina" type="hidden" id="cd_aula" value="' . $dados[1] . '" />
                            <input name="curso" type="hidden" id="cd_aula" value="' . $dados[2] . '" />
                            <input name="data" type="hidden" id="cd_aula" value="' . $dados[3] . '" />
                            <table id="gridview" class="table table-striped table-bordered table-hover dataTable">
                                <thead>
                                  <tr>
                                    <th width="10%">Matrícula</th>
                                    <th>Aluno</th>
                                    <th colspan="2">Frequência</th>
                                  </tr>
                                </thead>
                                <tbody>';
        if (count($grade) > 0) {
            foreach ($grade as $row) {
                $resultado .= '<tr>
                                    <td>' . $row['CD_ALUNO'] . '</td>
                                    <td>' . $row['NM_ALUNO'] . '</td>
                                    <td width="10%">
                                        <div class="radio-inline">
                                          <label>
                                            <input name="' . $row['CD_ALUNO'] . '" type="radio" value="' . $row['CD_ALUNO'] . ':S" checked="checked">
                                            <span class="lbl"> SIM</span> </label>
                                        </div>
                                      </td>
                                      <td width="10%">
                                          <div class="radio-inline">
                                          <label>
                                            <input name="' . $row['CD_ALUNO'] . '" type="radio" value="' . $row['CD_ALUNO'] . ':n" >
                                            <span class="lbl"> NÃO</span> </label>
                                        </div>
                                      </td>
                                  </tr>';
            }
        }
        $resultado .= '</tbody>
                                <tfoot>
                                  <tr role="row">
                                      <th colspan="4">
                                          <div class="col-sm-12 center">
                                              <input name="bt_validar" type="submit" id="bt_validar" value="Finalizar Frequência" class="btn btn-info"/>
                                          </div>
                                      </th>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>';
        echo $resultado;
    }

    function lancar_rechamada() {
        $parametro = array('operacao' => 'TN',
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
            'cd_turma' => $this->input->post('turma'),
            'cd_disciplina' => $this->input->post('disciplina'),
            'cd_curso' => $this->input->post('curso'),
            'data' => $this->input->oracle_data($this->input->post('data'))
        );
        $alunos = $this->diario->sp_diario($parametro);
        $aula = $this->input->get_post('cd_aula');
        foreach ($alunos as $row) {
            $item = explode(':', $this->input->get_post($row['CD_ALUNO']));
            $param = array('operacao' => 'IF',
                'cl_aula' => $aula,
                'cd_aluno' => $item[0],
                'frequencia' => $item[1]
            );
            $this->diario->sp_diario($param);
        }
        set_msg('msgok', 'Chamada realizada com sucesso', 'sucesso');
        redirect(base_url('professor/diario/chamada'), 'refresh');
    }

    function listaconteudo() {

        $param = array('cd_turma' => base64_decode($this->input->get('cd_turma')),
            'cd_professor' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
            'disc' => $this->input->get('disc'),
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'));


        $data['conteudos'] = $this->diario->lista_conteudo_aula($param)->result();

        $this->load->view('professor/diario/lista_conteudo', $data);
    }

    function listagem_alunos() {
        $parametro = array('operacao' => 'LAPS',
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
            'cd_turma' => base64_decode($this->input->get_post('turma')),
            'cd_disciplina' => $this->input->get_post('disc')
        );

        $data['alunos'] = $this->diario->sp_diario($parametro);
        $this->load->view('professor/diario/lista_aluno', $data);
    }

    /**
     * Função para informar se o professor já lançou conteudo.
     * 
     * @return json Informa se já lançou conteudo na chave 'success'. Caso não
     * tenha lançado será informada uma mensagem de erro na chave 'message'.
     */
    function lancou_conteudo() {
        $aula = $this->input->post('aula');

        $result = array(
            'success' => true,
            'mensagem' => '',
        );

        if (!$this->diario->hasConteudoLancado($aula)) {
            $result['success'] = false;
            $result['mensagem'] = "Informe primeiro o conteúdo a ser ministrado.";
        }

        echo json_encode($result);
    }

    /**
     * Direciona para a tela de lançar conteúdo da prova, onde o professor
     * seleciona a turma e disciplina que irá lançar o conteudo.
     */
    function conteudo_prova() {

        $aux = $this->coordenador->professor(array(
            'operacao' => 'TR',
            'cd_professor' => $this->session->userdata('SCL_SSS_USU_PCODIGO')
        ));

        $turmas = array();

        foreach ($aux as $turma) {
            if (strstr("+", $turma['CD_TURMA']) === FALSE) {
                $turma['notas'] = $this->diario->sp_notas(array(
                    'operacao' => 'LN',
                    'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                    'cd_turma' => $turma['CD_TURMA']
                ));
            }

            $turmas[] = $turma;
        }

        $data = array(
            "titulo" => "Lançar Conteúdo de Prova",
            "turmas" => $turmas,
        );

        $data['status_btn'] = $this->diario->desabilita_botao();
        $data['data_lacamento'] = $this->diario->texto_data_lancamento_query();

       

        $this->load->view("professor/diario/conteudo_prova", $data);
    }

    /**
     * Direciona para tela onde o professor informa quais os conteúdos de uma determinada
     * nota.
     */
    function lancar_conteudo_prova() {
//obter o tipo de nota e bimestre
        $aux = explode("-", $this->input->post("tipo-nota"));
        $tipoNota = $aux[0];
        $bimestre = $aux[1];

        $lancamentos = $this->diario->aes_prova_agendamento(array(
            "operacao" => "L",
        ));

        /*
         * checar se para o bimestre, periodo, disciplina e tipo de nota já
         * foi lançado algum conteudo de prova.
         */
        $prova = null;
        foreach ($lancamentos as $row) {
            if ($row['PERIODO'] == $this->session->userdata("SCL_SSS_USU_PERIODO") &&
                    $row["BIMESTRE"] == $bimestre && $row['CD_TIPO_NOTA'] == $tipoNota &&
                    $row["CD_DISCIPLINA"] == $this->input->post("codigo-disciplina") &&
                    $row["CD_TURMA"] == $this->input->post("turma")) {
                $prova = $row;
                break;
            }
        }

        $prova['DT_PROVA'] = empty($prova['DT_PROVA']) ? "" : date("d/m/Y", strtotime($prova['DT_PROVA']));
        if (!empty($prova['DT_INICIO']) && !empty($prova['DT_FIM'])) {
            $prova['data-conteudo'] = date("d/m/Y", strtotime($prova["DT_INICIO"])) . " - " . date("d/m/Y", strtotime($prova["DT_FIM"]));
        }

//obter descrição do tipo nota
        $result = $this->diario->sp_notas(array(
            "cd_turma" => $this->input->post("turma"),
            "operacao" => "LN"
        ));

        $nota = null;
        foreach ($result as $row) {
            if ($row['CD_TIPO_NOTA'] == $tipoNota && $row['BIMESTRE'] == $bimestre) {
                $nota = $row;
                break;
            }
        }

        /*
         * obter os conteudos do professor caso seja uma edição e definir a 
         * forma de lançamento.
         */
        $opcao = "";
        $conteudos = array();
        if (!empty($prova['DT_INICIO']) && !empty($prova['DT_FIM'])) {
            $opcao = "A";
            $params = array(
                "DT_INICIO" => $prova['DT_INICIO'],
                "DT_FIM" => $prova['DT_FIM'],
                "CD_TURMA" => $prova['CD_TURMA'],
                "CD_DISCIPLINA" => $prova['CD_DISCIPLINA'],
                "PERIODO" => $prova['PERIODO'],
                "BIMESTRE" => $prova['BIMESTRE'],
            );

            $conteudos = $this->aula->listaConteudoPeriodo($params);
        } else if (!empty($prova['CONTEUDO'])) {
            $opcao = "M";
        }

        $data = array(
            "TituloSistema" => "PORTAL ACADÊMICO",
            "titulo" => "DIÁRIO DE CLASSE",
            "SubTitulo" => "LANÇAR CONTEÚDO DE PROVA",
            "side_bar" => false,
            "turma" => $this->input->post("turma"),
            "codigoDisciplina" => $this->input->post("codigo-disciplina"),
            "descricaoDisciplina" => $this->input->post("descricao-disciplina"),
            "dataConteudo" => $prova['data-conteudo'],
            "dataProva" => $prova["DT_PROVA"],
            "textoConteudo" => $prova["CONTEUDO"],
            "codigoNota" => $nota["CD_TIPO_NOTA"],
            "descricaoNota" => $nota['DC_TIPO_NOTA'] . "(" . $nota['NM_MINI'] . ") - " . $nota['BIMESTRE'] . "º Bimestre",
            "conteudos" => $conteudos,
            "opcao" => $opcao,
            "bimestre" => $bimestre,
            "codigoProva" => $prova['ID_PROVA_CONTEUDO'],
            "ajax" => false,
        );

        $this->load->view("professor/diario/lancar_conteudo_prova", $data);
    }

    /**
     * Método que irá salvar os dados do conteudo da prova
     */
    function confirmar_conteudo_prova() {
//obter dados para preencher formulário em caso de erro de validação
        $data = array(
            "TituloSistema" => "PORTAL ACADÊMICO",
            "titulo" => "DIÁRIO DE CLASSE",
            "SubTitulo" => "LANÇAR CONTEÚDO DE PROVA",
            "side_bar" => false,
            "bimestre" => $this->input->post("bimestre"),
            "turma" => $this->input->post("turma"),
            "codigoNota" => $this->input->post("tipo-nota"),
            "codigoProva" => $this->input->post("prova"),
            "codigoDisciplina" => $this->input->post("codigo-disciplina"),
            "descricaoNota" => $this->input->post("descricao-nota"),
            "descricaoDisciplina" => $this->input->post("descricao-disciplina"),
            "dataConteudo" => $this->input->post("data-conteudo"),
            "dataProva" => $this->input->post("data-prova"),
            "textoConteudo" => $this->input->post("texto-conteudo"),
            "opcao" => $this->input->post("opcao"),
        );

//validações
        $this->form_validation->set_rules("data-prova", " ", "trim|required");
        $this->form_validation->set_rules("opcao", " ", "trim|required");

//validação de campo conforme forma de lançamento
        if ($data['opcao'] === "A") {
            $this->form_validation->set_rules("data-conteudo", " ", "trim|required");
        } elseif ($data['opcao'] === "M") {
            $this->form_validation->set_rules("texto-conteudo", " ", "trim|required");
        }

        if ($this->form_validation->run()) {
            $params = array(
                "operacao" => "I",
                "periodo" => $this->session->userdata("SCL_SSS_USU_PERIODO"),
                "bimestre" => $data['bimestre'],
                "tipo_nota" => $data['codigoNota'],
                "disciplina" => $data['codigoDisciplina'],
                "data_prova" => $data['dataProva'],
                "turma" => $data['turma'],
                "flag" => "S",
            );

            if ($data['opcao'] === "A") {
                $aux = explode("-", $data['dataConteudo']);
                $params["data_inicio"] = $aux[0];
                $params["data_fim"] = $aux[1];
            } elseif ($data['opcao'] === "M") {
                $params["data_inicio"] = null;
                $params["data_fim"] = null;
                $params["conteudo"] = $data['textoConteudo'];
            }

//caso já tenha sido lançado o conteudo será apenas atualizado os dados                        
            if (!empty($data['codigoProva'])) {
                $params['operacao'] = "E";
                $params['codigo_prova'] = $data['codigoProva'];
            }

            if ($this->diario->aes_prova_agendamento($params)) {
                set_msg("msg", "Conteúdo lançado com sucesso.", "sucesso");
            } else {
                set_msg("error", "Ocorreu um erro ao lançar conteúdo de prova.");
            }

            redirect("professor/diario/conteudo_prova");
        }

        /*
         * popular a lista de conteudos caso a forma de lançamento seja por
         * conteudo ministrados em um determinado periodo
         */
        if (!empty($data['dataConteudo'])) {
            $aux = explode("-", $data['dataConteudo']);
            $params = array(
                "DT_INICIO" => $aux[0],
                "DT_FIM" => $aux[1],
                "CD_TURMA" => $data['turma'],
                "CD_DISCIPLINA" => $data['codigoDisciplina'],
                "PERIODO" => $this->session->userdata("SGP_PERIODO"),
                "BIMESTRE" => $data['bimestre'],
            );

            $data['conteudos'] = $this->aula->listaConteudoPeriodo($params);
        }

        $this->load->view("professor/diario/lancar_conteudo_prova", $data);
    }

    /**
     * Popula a grid de conteudos da tela de lançamento de conteúdo de prova
     */
    function grid_conteudo_prova() {
        $params = array(
            "DT_INICIO" => date("d-M-y", strtotime($this->input->post("inicio"))),
            "DT_FIM" => date("d-M-y", strtotime($this->input->post("fim"))),
            "CD_TURMA" => $this->input->post("turma"),
            "CD_DISCIPLINA" => $this->input->post("disciplina"),
            "PERIODO" => $this->session->userdata("SCL_SSS_USU_PERIODO"),
            "BIMESTRE" => $this->input->post("bimestre"),
        );

        $data = array(
            'conteudos' => $this->aula->listaConteudoPeriodo($params),
            'ajax' => true,
        );

        $this->load->view("professor/diario/grid_conteudo_prova", $data);
    }

    /**
     * Retorna uma mensagem informando qual aula deve ser fechada.
     * 
     * @return json
     */
    public function lembreteFecharAula() {
        $professor = $this->session->userdata('SCL_SSS_USU_PCODIGO');
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');

        $aula = $this->aula->listaAulaFechar($professor, $periodo);
        $turma = $this->turma->consultar($aula['CD_TURMA'], $aula['PERIODO']);
        $resposta = array(
            'success' => false,
            'mensagem' => ''
        );

        if (!empty($aula) && $turma['CD_CURSO'] != 1) {
            $tempo = $aula['TEMPO_AULA'];
            $turno = $aula['TURNO'] == "A" ? "manhã" : "tarde";
            $resposta['success'] = true;
            $resposta['mensagem'] = "Professor, lembre-se de fechar a aula do " . $tempo . "º tempo da $turno";
        }

        echo json_encode($resposta);
    }

}
