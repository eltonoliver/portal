<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registro_diario extends CI_Controller {

    function __construct() {
        parent::__construct();
        //model sem procedure
        $this->load->model('sica/turma_professor_model', 'turmaProfessor', true);
        $this->load->model('sica/aluno_disciplina_model', 'alunoDisciplina', true);
        $this->load->model('professor/registro_diario_model', 'registroDiario', true);
       
        $this->load->helper(array('form', 'url', 'html', 'funcoes'));
        $this->load->library(array('form_validation', 'session'));
    }

   
    /**
     * Redireciona para tela que selecionará qual turma e disciplina deseja 
     * visualizar o resultado do semestre corrente.
     */
    function index() {
        $professor = $this->session->userdata('SCL_SSS_USU_PCODIGO');
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');

        $data = array(
            'titulo' => '<h1> Diário de Classe <i class="fa fa-angle-double-right"></i> Registro Diário</h1>',
            'turmas' => $this->turmaProfessor->listaTurmasRegularDoDia($professor, $periodo),
        );
        
        $this->load->view("professor/diario/registro_diario/registro_diario", $data);
    }

    /**
     * Retorna a view que gera a grid com o resultado do semestre.
     */
    function gridResultadoRegistro() {
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $turma = $this->input->post("turma");
        $aluno = $this->input->post("aluno");

        $registros = $this->registroDiario->listaRegistrosDiarios($periodo, $aluno);
        

        $data = array(
            'registros' => $registros
        );
  
        $this->load->view("professor/diario/registro_diario/grid-resultado-registros", $data);
    }
    
    function cadastrar(){
        //PARAMENTROS PARA CARREGAR A LISTA DE TURMAS DO PROFESSOR
        $professor = $this->session->userdata('SCL_SSS_USU_PCODIGO');
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
           
        $data = array(
            //'turmas' => $this->turmaProfessor->listaDisciplinasRegular($professor, $periodo)
            'turmas' => $this->turmaProfessor->listaTurmasRegularDoDia($professor, $periodo)
        );
        $this->load->view('professor/diario/registro_diario/novo_registro', $data);
    }
    
    function do_salvar() {

        $item = $this->input->post('aluno');
        
        $cd_registro = (($this->input->post('cd_registro')=='')? 0 : $this->input->post('cd_registro')); 
        
        foreach ($item as $l) {
            $dados = array('aluno' => $l,
            'periodo' => $this->input->post('periodo'),
            'turma' => $this->input->post('turma'), 
            'descricao' => $this->input->post('descricao'),
            'professor' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
            'cd_registro' => $cd_registro);
             
            if($cd_registro==0){
                $registro = $this->registroDiario->cadastrarRegistro($dados);
            }else{
                $registro = $this->registroDiario->editarRegistro($dados);
            }
            if($registro == 'erro'){
                $this->session->set_flashdata('msgRegistro', '<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>O registro não pôde ser salvo!</div>');

                //set_msg('msgRegistro', 'O registro não pôde ser salvo', 'erro');
            } else{
                $this->session->set_flashdata('msgRegistro', '<div class="alert alert-success alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>Registro salvo com sucesso!</div>');

              //  set_msg('msgRegistro', 'Registro salvo com sucesso', 'sucesso');
            }
        }  
        redirect(base_url('index.php/professor/registro_diario'), 'refresh');
    }

    function visualizar(){
        
        $cd_registro = $this->input->get("id");
            
        $data = array('registro' => $this->registroDiario->registroByID($cd_registro));
        
        $this->load->view('professor/diario/registro_diario/visualizar_registro', $data);
    }
    
    function editar(){
        
        $cd_registro = $this->input->get("id");
        $professor = $this->session->userdata('SCL_SSS_USU_PCODIGO');
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
            
        $data = array('registro' => $this->registroDiario->registroByID($cd_registro),
                'turmas' => $this->turmaProfessor->listaTurmasRegular($professor, $periodo),);
        
        $this->load->view('professor/diario/registro_diario/novo_registro', $data);
    }
    
}
