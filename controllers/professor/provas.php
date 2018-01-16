<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Provas extends CI_Controller {

    function __construct() {
        parent::__construct();
        //model sem procedure
        $this->load->model('sica/tipo_nota_model', 'tipoNota', true);
        $this->load->model('sica/turma_professor_model', 'turmaProfessor', true);
        $this->load->model('sica/aluno_nota_model', 'notaAluno', true);
        $this->load->model('provas/prova_professor_model', 'prova', true);

        //models com procedure
        $this->load->model('professor/diario_model', 'diario', TRUE);
        // $this->load->model('professor/nota_model', 'nota', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'funcoes'));
        $this->load->library(array('form_validation', 'session', 'diario_lib'));
    }

    function index() {
        //PARAMENTROS PARA CARREGAR A LISTA DE TURMAS DO PROFESSOR
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $professor = $this->session->userdata('SCL_SSS_USU_PCODIGO');

        $turmas = $this->turmaProfessor->listaTurmaDisciplinaRegular($professor, $periodo);

        $data['turmas'] = $turmas;
        $data['titulo'] = '<h1> Diário de Classe <i class="fa fa-angle-double-right"></i> Resultado de Provas</h1>';
        $this->load->view('professor/prova/index', $data);
    }
    
    function frmTurma() {
        
        $row = json_decode(base64_decode($this->input->get('p')));
        $Diario_lib = new Diario_lib();

        /* passando parametros para a biblioteca */
        $Diario_lib->disciplina = $row->CD_DISCIPLINA;
        $Diario_lib->turma      = $row->CD_TURMA;
        $Diario_lib->periodo    = $this->session->userdata('SCL_SSS_USU_PERIODO');
                
        $params = array(
            array("campo" => 'PERIODO',  'valor' => $this->session->userdata('SCL_SSS_USU_PERIODO')),
            array("campo" => 'CD_PROVA_PAI IS NULL', 'valor' => ''),
            //array("campo" => 'FLG_PEND_PROCESSAMENTO', 'valor' => '0'),
            array("campo" => 'ORDEM_SERIE', 'valor' => $row->CD_SERIE),
            array("campo" => 'CD_PROFESSOR', 'valor' => $row->CD_PROFESSOR),
            array("campo" => 'CD_CURSO', 'valor' => $row->CD_CURSO),
        );
        

        $data = array(
            'row' => $row,
            'lista' => $Diario_lib->notas_turma_disciplina(),
            'provas' => $this->prova->filtrar($params),
        );
        
        $this->load->view('professor/prova/frmTurma', $data);
    }
    
    
    function frmTurmaProvaResultado() {
        
        $row = json_decode(base64_decode($this->input->post('token')));
        $params = array(
            array("campo" => 'CD_PROVA', 'valor' => $row->CD_PROVA),
        );
        
        $view = 'BD_SICA.VW_AVAL_PROVA_ALUNO_RESULTADO';
        
        $ordem = array(
            'campo' => 'NM_ALUNO',
            'ordem' => 'ASC'
        );
        
        $data = array(
            'row'   => $row,
            'listar' => $this->prova->auxiliar($view, $params, $ordem),
        );
        
        $this->load->view('professor/prova/frmTurmaProvaResultado', $data);
    }


}
