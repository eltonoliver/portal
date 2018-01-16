<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Aulas extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file','funcoes'));
        $this->load->library(array('form_validation', 'session', 'email', 'upload', 'pagination'));        
        $this->load->model('professor/aulas_model', 'professor', TRUE);
    }

    function index() { 
        $data = array(
            'titulo' => '<h1> Lista de Disciplina </h1>'
        );        
        $param = array('cd_professor' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
                       'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                       'operacao'=> 'L');
        $data['disciplina'] = $this->professor->sp_slide($param);
        $this->load->view('professor/aulas/index', $data);
    }
    
    function cadastrar_aula() {
        $iduser = $this->uri->segment(4);
        if($iduser != NULL){
            if($this->input->post('acao') == 1){
                $this->form_validation->set_rules('titulo', 'TITULO', 'trim|required');
                $this->form_validation->set_rules('texto', 'SLIDE', 'trim|required');
                if($this->form_validation->run() == FALSE) {
                    $data = array('titulo' => '<h1> Cadastrar Aulas </h1>');        
                    $this->load->view('professor/aulas/cadastrar_aula');
                }else{
                    $parametro = array('titulo'=> $this->input->post('titulo'),
                                       'texto'=>  $this->input->post('texto'),
                                       'cd_conteudo'=>  $this->input->post('conteudo'),
                                       'cd_disciplina'=> $this->uri->segment(4),
                                       'cd_professor' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
                                       'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                                       'operacao'=> 'I');
                    if($this->professor->sp_slide($parametro)){
                        set_msg('msgok','Slide inserido com sucesso','sucesso');
                    }else{
                        set_msg('msgerro','Erro ao cadastrar o aula','erro');
                    }
                    redirect('professor/aulas/index');
                }
            }else{
                $data = array(
                    'titulo' => '<h1> Cadastrar Aulas </h1>'
                );        
                $parametro = array('operacao'=>'LC','periodo'=>$this->session->userdata('SCL_SSS_USU_PERIODO'));
                $data['conteudo'] = $this->professor->sp_slide($parametro);
                $this->load->view('professor/aulas/cadastrar_aula',$data);
            }
        }else{
            set_msg('msgerro','Selecione uma disciplina para cadastrar','erro');
            redirect('professor/index');
        }   
    }
    
    function lista_slide(){ 
        $data = array(
                'cd_conteudo'=>$this->uri->segment(3),
                'operacao'=>'LS'
        );
        $data['lista'] = $this->professor->sp_slide($data);
        $data['disciplina'] = $this->professor->get_disciplina($this->uri->segment(4))->row();
        $this->load->view('professor/aulas/lista_slide',$data);
    }
    
    
    function cadastrar_conteudo() {
        $iduser = $this->uri->segment(4);
        if($iduser != NULL){
            if($this->input->post('acao') == 1){
                $this->form_validation->set_rules('titulo', 'TITULO', 'trim|required');
                $this->form_validation->set_rules('curso', 'CURSO', 'trim|required');
                $this->form_validation->set_rules('serie', 'SERIE', 'trim|required');
                if($this->form_validation->run() == FALSE) {
                    $data = array('titulo' => '<h1> Cadastrar Conteúdo </h1>');        
                    $this->load->view('professor/aulas/cadastrar_conteudo');
                }else{
                    $parametro = array('titulo'=> $this->input->post('titulo'),
                                       'cd_curso'=>  $this->input->post('curso'),
                                       'cd_serie'=>  $this->input->post('serie'),
                                       'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                                       'cd_disciplina'=> $this->uri->segment(4),
                                       'cd_usuario' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
                                       'operacao'=> 'IC');
                    if($this->professor->sp_slide($parametro)){
                        set_msg('msgok','Slide inserido com sucesso','sucesso');
                    }else{
                        set_msg('msgerro','Erro ao inserir o conteúdo','erro');
                    }
                    redirect('professor/aulas/index');
                }
            }else{
                
                $parametro = array(
                            'operacao'=>'C', //MOSTRAR OS CURSOS
                            'curso'=>NULL
                            );
                $data = array(
                    'titulo' => '<h1> Cadastrar Conteúdo </h1>'
                );        
                $data['disciplina'] = $this->professor->get_disciplina($this->uri->segment(4))->row();
                $data['curso'] = $this->professor->sp_curso_serie_turma_aluno($parametro);
                $this->load->view('professor/aulas/cadastrar_conteudo',$data);
            }
        }else{
            set_msg('msgerro','Selecione uma disciplina para cadastrar','erro');
            redirect('professor/aulas/index');
        }   
    }
    
     function curso_serie(){ 
        $parametro = array(
                        'operacao'=>'S', //MOSTRAR AS SÉRIES FILTRADAS PELOS CAMPOS
                        'curso'=>$this->input->get_post('curso'),
                        'serie'=>NULL,
                        'turma'=>NULL,
                        );		
        $serie = $this->professor->sp_curso_serie_turma_aluno($parametro);
        
        $select = '<label for="example-nf-email">Série</label><select id="serie" name="serie" class="form-control" size="1">';
        $select .= '<option value=""></option>';
        foreach($serie as $r){
                $select .= '<option value="'.$r['ORDEM_SERIE'].'">'.$r['NM_SERIE'].'</option>';	
        }
        $select .= '</select>';
        echo ($select);
    }
    
    function lista_conteudo(){
        $data = array(
                    'titulo' => '<h1> Lista de conteúdo cadastrado </h1>'
                );        
        $parametro = array ('operacao'=> 'CC','cd_disciplina' => $this->uri->segment(4));
        $data['disciplina'] = $this->professor->get_disciplina($this->uri->segment(4))->row();
        $data['conteudo'] = $this->professor->sp_slide($parametro);
       
        $this->load->view('professor/aulas/conteudo_cadastrado',$data);
    }
    
    function excluir_conteudo(){
        $id = $this->uri->segment(4);
        $url = $this->uri->segment(5);
        $parametro = array(
                        'operacao'=>'EC', //MOSTRAR AS SÉRIES FILTRADAS PELOS CAMPOS
                        'cd_conteudo'=>$id,
                        );
        if($this->professor->sp_aula($parametro)){
            set_msg('msgok','Conteúdo excluido com sucesso','sucesso');
        }else{
            set_msg('msgerro','Erro ao excluir o conteúdo','erro');
        }
        redirect('professor/aulas/lista_conteudo/'.$url);
    }
}
