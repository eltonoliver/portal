<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acompanhamento extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('responsavel_model', 'responsavel', TRUE);
        $this->load->model('coordenacao/ocorrencia_model', 'ocorrencia', TRUE);
        $this->load->model('secretaria/secretaria_model', 'secretaria', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file'));
        $this->load->library(array('form_validation', 'session', 'email', 'upload', 'pagination'));
    }

    function index() {

        $data = array(
            'titulo' => '<h1> Acompanhamento de Aluno </h1>',
            'aluno' => $this->responsavel->acompanhamento(array('operacao' => 'L', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'))),
        );

        $this->load->view('acompanhamento/index', $data);
    }

    function aluno() {
        
        $data = array(
            'titulo' => '<h1> Acompanhamento de Aluno </h1>',
            'alu' => $this->responsavel->acompanhamento(array('operacao' => 'FA', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'), 'aluno' => $this->input->get_post('aluno'))),
            'disciplina' => $this->secretaria->aluno(array('operacao' => 'D', 'aluno' => $this->input->get_post('aluno'))),
            'aluno' => base64_encode($this->input->get_post('aluno')),
        );
        $this->load->view('acompanhamento/aluno', $data);
    }
    
    function tempos() {
        $data = array(
            'titulo' => '<h1>  Acompanhamento de Aluno - Demonstrativo de Notas </h1>',
            'aluno' => $this->input->get_post('token'),
            'disciplina' => $this->secretaria->aluno(array('operacao' => 'D', 'aluno' => base64_decode($this->input->get('token')))),
            'alu' => $this->responsavel->acompanhamento(array('operacao' => 'FA', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'), 'aluno' => base64_decode($this->input->get('token')))),
            'tempos' => $this->secretaria->tempos(array('aluno' =>base64_decode($this->input->get('token')), 'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'))),
        );
        $this->load->view('acompanhamento/tempos', $data);
    }
    
    function agenda() {
        $data = array(
            'titulo' => '<h1> Acompanhamento de Aluno - </h1>',
            'aluno' => $this->input->get_post('token'),
            'alu' => $this->responsavel->acompanhamento(array('operacao' => 'FA', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'), 'aluno' => base64_decode($this->input->get('token')))),
            'disciplina' => $this->secretaria->aluno(array('operacao' => 'D', 'aluno' => base64_decode($this->input->get('token')))),
            'tempos' => $this->secretaria->tempos(array('aluno' =>base64_decode($this->input->get('aluno')), 'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'))),
        );
        $this->load->view('acompanhamento/agenda', $data);
    }
    
    function boletim() {
        $parametro = array('aluno' => $this->input->get('aluno'),
            'curso' => NULL,
            'serie' => NULL,
            'turma' => NULL,
            'tipo'=>1
        );
        $data['boletim'] = $this->secretaria->boletim($parametro);
  //      print_r($data['boletim']);EXIT;
        $this->load->view('acompanhamento/boletim', $data);
    }
    
    function demonstrativo() {
        
        $parametro = array('aluno' => base64_decode($this->input->get('token')),
            'curso' => NULL,
            'serie' => NULL,
            'turma' => NULL,
            'tipo'=>0
        );
        
        $data = array(
            'titulo' => '<h1>  Acompanhamento de Aluno - Demonstrativo de Notas </h1>',
            'aluno' => $this->input->get_post('token'),
            'disciplina' => $this->secretaria->aluno(array('operacao' => 'D', 'aluno' => base64_decode($this->input->get('token')))),
            'alu' => $this->responsavel->acompanhamento(array('operacao' => 'FA', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'), 'aluno' => base64_decode($this->input->get('token')))),
            'boletim' => $this->secretaria->boletim($parametro)
        );
        
        $this->load->view('acompanhamento/demonstrativo', $data);
    }
    
    function disciplina() {
        $parametro1 = array(
            'operacao'=>'C',
            'aluno' => $this->input->get('aluno'),
            'disciplina' => $this->input->get('disciplina'),
            'turma' => $this->input->get('turma'),
        );
        $parametro2 = array(
            'operacao'=>'AQ',
            'aluno' => $this->input->get('aluno'),
            'disciplina' => $this->input->get('disciplina'),
            'turma' => $this->input->get('turma'),
        );
        
        $data = array(
            'titulo' => '<h1>  Acompanhamento de Aluno - Demonstrativo de Notas </h1>',
            'aluno' => $this->input->get_post('token'),
            'disciplina' => $this->secretaria->aluno(array('operacao' => 'D', 'aluno' => base64_decode($this->input->get('token')))),
            'alu' => $this->responsavel->acompanhamento(array('operacao' => 'FA', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'), 'aluno' => base64_decode($this->input->get('token')))),
            'conteudo' => $this->secretaria->plano_ensino($parametro1),
            'arquivo' => $this->secretaria->plano_ensino($parametro2),
            
        );
        $this->load->view('acompanhamento/disciplina', $data);
    }
    
    function ocorrencia() { 
        $parametro = array('aluno' => base64_decode($this->input->get('token')),
                           'operacao' => 'LA',
                           'texto'=>'LISTAR',
                           'usuario'=>'',
                           'data'=>'',
                           'ordem'=>''
        );
        
        $data = array(
            'titulo' => '<h1> Acompanhamento de Aluno </h1>',
            'alu' => $this->responsavel->acompanhamento(array('operacao' => 'FA', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'), 'aluno' => $this->input->get_post('aluno'))),
            'disciplina' => $this->secretaria->aluno(array('operacao' => 'D', 'aluno' => base64_decode($this->input->get('token')))),
            'aluno' => base64_decode($this->input->get_post('token')),
        );
        $data['lista'] = $this->ocorrencia->ocorrencia($parametro);
        
       $this->load->view('acompanhamento/ocorrencia_aluno', $data);
    }
    
    function gabarito(){
        $cd_aluno = base64_decode($this->input->get('token'));
        
        $data = array(
            'titulo' => '<h1>  Acompanhamento de Aluno - Demonstrativo de Notas </h1>',
            'aluno' => $this->input->get_post('token'),
            'disciplina' => $this->secretaria->aluno(array('operacao' => 'D', 'aluno' => base64_decode($this->input->get('token')))),
            'alu' => $this->responsavel->acompanhamento(array('operacao' => 'FA', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO'), 'aluno' => base64_decode($this->input->get('token')))),

        );
        $data['gabarito'] = $this->ocorrencia->gabarito_provas($cd_aluno)->result();
        
        $sessao = $this->session->userdata;
        
        /* gerar log*/
        $params = array(
                    'usuario'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                   'programa'=>'GABARITO DE PROVAS',
                         'ip'=>$sessao['ip_address'],
                'dispositivo'=>$sessao['user_agent']
                );
                $this->ocorrencia->log($params);
        
        
        
        $this->load->view('acompanhamento/gabarito', $data);
      //  $data['gabarito'] = $this->inicio->gabarito_provas($cd_aluno);
    }

    /*
     * Your license information is the following: LICENÇA DO ZEND
      Order: FREE-95478-61
      Serial: V2F67G10801G51F5FEA50DCB9EF1BFE4

     * /usr/local/zend/bin
     */
}