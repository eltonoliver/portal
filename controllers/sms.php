<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sms extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('sms_model', 'sms', TRUE);
        $this->load->model('secretaria/secretaria_model', 'secretaria', TRUE);
        $this->load->model('mensagem_model', 'mensagem', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory'));
        $this->load->library(array('form_validation', 'session', 'upload','soapsms'));
        if ($this->session->userdata('SCL_SSS_USU_CODIGO') == FALSE) {
            redirect(base_url(), 'refresh');
        }
    }

    function index() {
        $param = array(
            'operacao' => 'L',
            'usuario' => $this->session->userdata('SCL_SSS_USU_CODIGO')
        );

        $data = array(
            'titulo' => 'Mensagem > Envio de SMS',
            'listar' => $this->sms->sms($param)
        );
        $this->load->view('sms/index', $data);
    }

    function destinatario() {

        $tipo = $this->session->userdata('SCL_SSS_USU_TIPO');

        $data = array(
            'titulo' => 'Mensagem > Envio de SMS',
            'listargrupo' => $this->mensagem->grupo($tipo),
        );
        $this->load->view('sms/destinatario', $data);
    }

    function enviar() {
     
        $param = array(
            'operacao' => 'LT'
        );
        $data = array(
            'titulo' => 'Mensagem > Envio de SMS',
            'listar' => $this->secretaria->responsavel($param),
        );

        $data['lista_curso'] = $this->secretaria->lista_curso();
        $this->load->view('sms/enviar', $data);
    }



    function lista_alunos(){
        /* if($this->input->post('turma') =='EIM0401'){

            $cd_curso = 2;
        }*/

        $param = array('operacao' =>'LAP',
                       'cd_curso'=>$this->input->post('curso'),
                       'serie'=>$this->input->post('serie'),
                       'cd_turma'=>$this->input->post('turma')
            );
        $alunos = $this->sms->sms($param);
       
        $ret = '';
        foreach ($alunos as $a){
            $ret .= '<option value="'.$a['CD_ALUNO'].':'.$a['ALU_TEL_CEL'].':'.$a['CD_ALUNO'].'">'.$a['NM_ALUNO'].'</option>';
        }
        echo $ret;
        unset($ret);
    }
    
    function lista_responsavel_financeiro(){
        /* if($this->input->post('turma') =='EIM0401'){

            $cd_curso = 2;
        }*/

        $param = array('operacao' =>'LRFA',
                       'cd_curso'=>$this->input->post('curso'),
                       'serie'=>$this->input->post('serie'),
                       'cd_turma'=>$this->input->post('turma')
            );
        $alunos = $this->sms->sms($param);
      
        $ret = '';
        foreach ($alunos as $a){
            $ret .= '<option value="'.$a['CPF_RESPONSAVEL'].':'.$a['TEL_RESPONSAVEL'].':'.$a['CD_ALUNO'].'">'.$a['NM_ALUNO'].' | '.$a['NM_RESPONSAVEL'].'</option>';
        }
        echo $ret;
        unset($ret);
    }
    
    function lista_responsavel(){
       /* if($this->input->post('turma') =='EIM0401'){

            $cd_curso = 2;
        }
        */
        $param = array('operacao' =>'LRA',
                       'cd_curso'=> $cd_curso,
                       'serie'=>$this->input->post('serie'),
                       'cd_turma'=>$this->input->post('turma')
            );
       // print_r($param);
        $alunos = $this->sms->sms($param);
      
        $ret = '';
        foreach ($alunos as $a){
            $ret .= '<option value="'.$a['CPF_RESPONSAVEL'].':'.$a['TEL_RESPONSAVEL'].':'.$a['CD_ALUNO'].'">'.$a['NM_ALUNO'].' | '.$a['NM_RESPONSAVEL'].'</option>';
        }
        echo $ret;
        unset($ret);
    }

    function enviando() {
        
        $dados = array();
        
        foreach ($this->input->post('celular') as $cel) {
            
            $item = explode(':', $cel);
            
            $param = array(
                'operacao' => 'I',
                'autenticacao' => $item[0].date('Yi').'01',
                'telefone' => $item[1],
                'mensagem' => $this->input->post('mensagem'),
                'destinatario' => $item[0],
                'aluno' => $item[2],
                'tipo' => $this->input->post('tipo'),
                'usuario' => $this->session->userdata('SCL_SSS_USU_CODIGO')
            );
            
          
            $dados[] = array(
                             'codigosms' => $item[0].date('Yi').'01',
                             'celular' => $item[1],
                             'mensagem' => $this->input->post('mensagem'));
            
           $insere = $this->sms->sms($param);
        }
        
        $data['dados'] = $dados;

        $this->load->view('sms/enviando', $data);
    }
    
    
    
}