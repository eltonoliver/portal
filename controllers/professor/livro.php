<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Livro extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('professor/livro_model', 'livro', TRUE);
        $this->load->model('colegio/colegio_model', 'colegio', TRUE);
        $this->load->helper(array('form', 'url', 'html','funcoes'));
        $this->load->library(array('form_validation', 'session'));
    }
    

    function index() {
        $retorno = $this->livro->sp_livro(array('operacao'=>'L'));
        if(count($retorno[0])==0){
            $lista = 0;
        }else{
            $lista = $retorno;
        }
        $data = array(
            'titulo' => 'Planejamento <i class="fa fa-angle-double-right"> Cadastro de Livro</i>',
            'lista' => $lista
        );   

        $this->load->view('professor/livro/index', $data);
    }
    
    function cadastrar_livro(){
        
        $acao = $this->input->get('acao');
        switch ($acao) {
            case 'novo':
                $data = array('titulo'=>'Novo Livro',
                    'acao'=>$acao,
                    'botao'=>'Cadastrar',
                    'cor'=>'success',
                    'dados'=>'',
                    'disciplina'=>  $this->livro->sp_livro(array('operacao'=>'DISC')),
                    'curso' => $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'C')),
                    'dados'=>""
                );
              

                break;
            case 'editar':
                $curso = $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'C'));
                $dados = $this->livro->sp_livro(array('operacao'=>'DL','id_livro'=>$this->input->get_post('id_livro')));
                $data = array('titulo'=>'Editar Assunto',
                    'acao'=>$acao,
                    'botao'=>'Editar',
                    'cor'=>'warning',
                    'id_livro'=>$this->input->get_post('id'),
                    'disciplina'=>  $this->livro->sp_livro(array('operacao'=>'DISC')),
                    'curso' => $curso,
                    'serie' => $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'S','curso'=>$dados[0]['CD_CURSO'])),
                    'dados'=>$dados
                    );
                #print_r($dados);
                break;
            
            default:

                break; 
        
        }
        $this->load->view('professor/livro/cad_livro',$data);
    }
    
    function conf_livro(){
        $acao = $this->input->get_post('acao');
        if ($acao == 'novo') {
                $operacao = 'IL';
        }else{
                $operacao = 'EL';
        }
        $param = array('operacao' => $operacao,
                       'titulo' => $this->input->post('nome'), 
                       'autor'  => $this->input->post('autor'),
                       'ano_edicao' => $this->input->post('ano_edicao'),
                       'editora'  => $this->input->post('editora'),
                       'observacao'  => $this->input->post('obs'),
                       'cod_referencia'  => $this->input->post('cod_ref'),
                       'cd_usuario'  => $this->session->userdata('SCL_SSS_USU_CODIGO'),
                       'ativo'  => $this->input->post('ativo'),
                       'cd_disciplina'=>$this->input->post('cd_disciplina'),
                       'cd_curso'=>$this->input->post('curso'),
                       'ordem_serie'=>$this->input->post('serie'),
                       'id_livro'=>$this->input->post('id_livro')
                );
        
        if($this->livro->sp_livro($param)){
            echo 1;
        }else{
            echo 0;
        }
    }
    
    function excluir_livro(){
        $param = array('operacao'=>'EXCL','id_livro'=>$this->input->get('livro'));
       // print_r($param);exit;
        if($this->livro->sp_livro($param)){
            set_msg('msg', 'Registro excluido com sucesso', 'sucesso');
            redirect('professor/livro/index','refresh');
        }else{
            set_msg('msg', 'Erro ao excluir o registro', 'erro');
            redirect('professor/livro/index','refresh');
        }
        
    }
    

    // MODAL
    function conteudo() {

        $data = array(
            'titulo' => 'Planejamento <i class="fa fa-angle-double-right"> Cadastro de Conteúdo</i>',
            'frenteA' => $this->livro->sp_livro(array('operacao'=>'LCL','id_livro'=>base64_decode($this->input->get('cd')),'tipo'=>'1')),
            'frenteB' => $this->livro->sp_livro(array('operacao'=>'LCL','id_livro'=>  base64_decode($this->input->get('cd')),'tipo'=>'2')),
            'frenteC' => $this->livro->sp_livro(array('operacao'=>'LCL','id_livro'=>  base64_decode($this->input->get('cd')),'tipo'=>'3'))
        );
        $this->load->view('professor/livro/cad_conteudo', $data);
    }
    
    function cadastrar_assunto(){
        $acao = $this->input->get('acao');
        switch ($acao) {
            case 'novo':
                $data = array('titulo'=>'Novo Assunto',
                    'acao'=>$acao,
                    'botao'=>'Cadastrar',
                    'cor'=>'success',
                    'dados'=>'',
                    'id_livro'=>$this->input->get_post('id'),
                    'estrutura'=>$this->input->get_post('est'),
                    'id_assunto'=>$this->input->get_post('id_assunto')
                    );

                break;
            case 'editar':
                $data = array('titulo'=>'Editar Assunto',
                    'acao'=>$acao,
                    'botao'=>'Editar',
                    'cor'=>'warning',
                    'id_livro'=>$this->input->get_post('id'),
                    'estrutura'=>$this->input->get_post('est'),
                    'id_assunto'=>$this->input->get_post('id_assunto'),
                    'dados'=>$this->livro->sp_livro(array('operacao'=>'DA','id_assunto'=>$this->input->get_post('id_assunto')))
                    );
                break;
            
            default:

                break;       
        }
        
        $this->load->view('professor/livro/cad_assunto',$data);
    }
    
    function conf_assunto(){
        $acao = $this->input->get_post('acao');
        switch ($acao) {
            case 'novo':
                $dados = array('operacao'=>'IA',
                               'id_livro'=>$this->input->post('id_livro'),
                               'id_assunto'=>$this->input->post('id_assunto'),
                               'estrutura'=>$this->input->post('estrutura'),
                               'bimestre'=>$this->input->post('bimestre'),
                               'titulo'=>$this->input->post('assunto'),
                               'ins_upd'=>1
                               );				   
                $sucesso = $this->livro->sp_livro($dados);
                break;
            
            case 'editar':
                $dados = array('operacao'=>'IA',
                               'id_livro'=>$this->input->post('id_livro'),
                               'id_assunto'=>$this->input->post('id_assunto'),
                               'estrutura'=>$this->input->post('estrutura'),
                               'bimestre'=>$this->input->post('bimestre'),
                               'titulo'=>$this->input->post('assunto'),
                               'ins_upd'=>0
                               );				   
                $sucesso = $this->livro->sp_livro($dados);
                break;
            case 'excluir':
                $livro  = $this->input->get_post('livro');
                $estrutura  = $this->input->get_post('estrutura');
                $sucesso = $this->livro->sp_livro(array('operacao'=>'EXA','id_livro'=>$livro,'estrutura'=>$estrutura));
                break;
        }
        
        if($acao == 'excluir'){
            set_msg('msg', 'Registro excluido com sucesso', 'sucesso');
            redirect('professor/livro/conteudo?cd='.  base64_encode($this->input->get_post('livro')).' ','refresh');
        }else{
            if($sucesso){
                echo 1;
            }else{
                echo 0;
            }
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    function manter() {

        $data['plano'] = $this->input->post('plano');
        $data['acao'] = $this->input->post('acao');
        $data['titulo'] = $this->input->post('acao');

        if ($this->input->post('sclacao') == 'inserir') {

            $this->form_validation->set_rules('sclmes', 'MÊS', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sclaula', 'HORA AULA', 'numeric|required');
            $this->form_validation->set_rules('sclobjetivo', 'AVALIAÇÃO', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sclconteudo', 'BIBLIOGRAFIA BÁSICA', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {

                $data['sclmes'] = $this->input->post('sclmes');
                $data['sclaula'] = $this->input->post('sclaula');
                $data['sclobjetivo'] = $this->input->post('sclobjetivo');
                $data['sclconteudo'] = $this->input->post('sclconteudo');
                echo validation_errors();
            } else {

                $resultado_acao = $this->conteudo->inserir();

                $data['sclmes'] = '';
                $data['sclaula'] = '';
                $data['sclobjetivo'] = '';
                $data['sclconteudo'] = '';

                redirect($this->load->view('' . $this->session->userdata('SCL_SSS_TIPO') . '/plano/conteudo', $data), 'refresh');
            }
        } else {
            if ($this->input->post('sclacao') == 'editar') {
                $resultado_acao = $this->conteudo->editar();
                $this->index();
            } elseif ($this->input->post('sclacao') == 'deletar') {

                $resultado_acao = $this->conteudo->deletar();
                $data['sclmes'] = NULL;
                $data['sclaula'] = NULL;
                $data['sclobjetivo'] = NULL;
                $data['sclconteudo'] = NULL;
                echo validation_errors();
            }
        }
    }

    function manter_conteudo() {

        $data['plano'] = $this->input->post('plano');
        $data['acao'] = $this->input->post('acao');
        $data['titulo'] = $this->input->post('acao');

        if ($this->input->post('sclacao') == 'inserir') {

            $this->form_validation->set_rules('sclmes', 'MÊS', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sclaula', 'HORA AULA', 'numeric|required');
            $this->form_validation->set_rules('sclobjetivo', 'AVALIAÇÃO', 'trim|required|xss_clean');
            $this->form_validation->set_rules('sclconteudo', 'BIBLIOGRAFIA BÁSICA', 'trim|required|xss_clean');

            if ($this->form_validation->run() == FALSE) {

                $data['sclmes'] = $this->input->post('sclmes');
                $data['sclaula'] = $this->input->post('sclaula');
                $data['sclobjetivo'] = $this->input->post('sclobjetivo');
                $data['sclconteudo'] = $this->input->post('sclconteudo');
                echo validation_errors();
            } else {

                $resultado_acao = $this->conteudo->inserir();

                $data['sclmes'] = '';
                $data['sclaula'] = '';
                $data['sclobjetivo'] = '';
                $data['sclconteudo'] = '';

                redirect('' . $this->session->userdata('SCL_SSS_TIPO') . '/plano', 'refresh');
            }
        } else {

            if ($this->input->post('sclacao') == 'editar') {

                $resultado_acao = $this->conteudo->editar();
                $this->index();
            } elseif ($this->input->post('sclacao') == 'deletar') {

                $resultado_acao = $this->conteudo->deletar();
                $data['sclmes'] = NULL;
                $data['sclaula'] = NULL;
                $data['sclobjetivo'] = NULL;
                $data['sclconteudo'] = NULL;

                echo validation_errors();
            }
        }
    }

}
