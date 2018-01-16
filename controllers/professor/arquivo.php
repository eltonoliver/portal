<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Arquivo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('professor/diario_model', 'diario', TRUE);
        $this->load->model('professor/arquivo_model', 'arquivo', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file','funcoes'));
        $this->load->library(array('form_validation', 'session', 'upload'));

    }

    function enviar($arquivo, $disciplina, $professor, $descricao, $turma, $operacao) {
        $caminho = $_SERVER['DOCUMENT_ROOT'] . '/portal/application/upload/professor/' . $this->session->userdata('SCL_SSS_USU_PCODIGO') . '/';
        if(is_dir($caminho)){
            $caminho = $_SERVER['DOCUMENT_ROOT'] . '/portal/application/upload/professor/' . $this->session->userdata('SCL_SSS_USU_PCODIGO') . '/';
        }else{
            mkdir ($caminho, 0777);
        }
        $data['caminho'] = '' . $caminho;//$_SERVER['DOCUMENT_ROOT'] . '/portal/application/upload/professor/' . $this->session->userdata('SCL_SSS_USU_PCODIGO') . '/';
        $data['diretorio'] = directory_map($data['caminho']);
        $file = "" . $arquivo . "";
        $config['upload_path'] = '' . $caminho;//$_SERVER['DOCUMENT_ROOT'] . '/portal/application/upload/professor/' . $this->session->userdata('SCL_SSS_USU_PCODIGO') . '/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($file)) {
            $data['mensagem'] = $this->upload->display_errors();
        } else {
            $dados = $this->upload->data();
            $anexo = $dados['raw_name'] . $dados['file_ext'];
            $tamanho = $dados['file_size'];
            
            //PARAMENTROS DO ARQUIVOS
            $paramentro = array('operacao'=>'I',
                                'cd_professor'=>$professor,
                                'arquivo'=>$anexo,
                                'cd_disciplina'=>$disciplina,
                                'descricao'=>$descricao,
                                'tamanho'=>$tamanho,
                                'cd_turma'=>$turma);
            
            $data['mensagem'] = $this->arquivo->sp_arquivo($paramentro);
        }
        return $data['mensagem'];
    }
    
    function turma() {  
        $paramentro = array('operacao'=>'LA',
                             'cd_professor'=>$this->session->userdata('SCL_SSS_USU_PCODIGO'));
        $data = array(
            'titulo' => '<h1> Arquivos <i class="fa fa-angle-double-right"></i> Envio</h1>',
            'grade' => $this->arquivo->sp_arquivo($paramentro)
        );
        $this->load->view('professor/arquivo/turma', $data);
    }
    
    function cadastrar(){
        //PARAMENTROS PARA CARREGAR A LISTA DE TURMAS DO PROFESSOR
        $paramento = array( 'operacao'=>'LT',
                            'periodo'=> $this->session->userdata('SCL_SSS_USU_PERIODO'),
                            'cd_professor'=>$this->session->userdata('SCL_SSS_USU_PCODIGO')
                           );    
        $data = array(
            'titulo' => '<h1> Arquivos <i class="fa fa-angle-double-right"></i> Upload</h1>',
            'turma' => $this->diario->sp_notas($paramento)
        );
        $this->load->view('professor/arquivo/formulario', $data);
    }
    
    function upload_arquivo_turma() {

        if ($this->input->post('acao') == 'add') {
            $item = $this->input->post('turma');
           // $operacao = 'I'; //OPERACAO
            foreach ($item as $l) {
                $rs = explode(':', $l);
                $turma = $rs[0]; // TURMA 
                $disciplina = $rs[1]; // DISCIPLINA
                $descricao = $this->input->post('descricao'); // DESCRIÇÃO
                $professor = $this->session->userdata('SCL_SSS_USU_PCODIGO'); // PROFESSOR
                $this->enviar('arquivo1', $disciplina, $professor, $descricao, $turma);
                $this->enviar('arquivo2', $disciplina, $professor, $descricao, $turma);
                $this->enviar('arquivo3', $disciplina, $professor, $descricao, $turma);
            }
        }
        set_msg('msgok', 'Arquivo(s) enviado com sucesso', 'sucesso');
        redirect(base_url('index.php/professor/arquivo/turma'), 'refresh');
    }
    
    // CHAMA MODAL PARA JUSTIFICAR FALTA DE ALUNOS
    function view() {

        $data = array(
            'titulo' => '<h1> Arquivo <i class="icon-double-angle-right"></i> Para Turma </h1>',
            'codigo' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
            'arquivo' => $this->input->get_post('arquivo')
        );

        $this->load->view('professor/arquivo/visualizar', $data);
    }
    
    // CHAMA MODAL PARA JUSTIFICAR FALTA DE ALUNOS
    function excluir() {
        $paramento = array('operacao'=>'EA', 'arquivo'=>$this->uri->segment(4));
        $resultado = $this->arquivo->sp_arquivo($paramento);
        if ($resultado) {
            unlink($_SERVER['DOCUMENT_ROOT'].'/portal/application/upload/professor/'.$this->session->userdata('SCL_SSS_USU_PCODIGO').'/'.$this->uri->segment(5));                   
            set_msg('msgok','Arquivo excluído com sucesso','sucesso');
            redirect(base_url('index.php/professor/arquivo/turma'), 'refresh');
        }else{
            set_msg('msgerro','Erro ao excluir o arquivo','erro');
            redirect(base_url('index.php/professor/arquivo/turma'), 'refresh');
        }
    }
/*
    

    function pessoal() {

        $data['grade'] = $this->colegio->turma_professor(0, $this->session->userdata('SCL_SSS_USU_CODIGO'), '');
        $data['titulo'] = '<h1> Arquivos <i class="icon-double-angle-right"></i> Pessoal </h1>';
        $data['navegacao'] = 'Arquivos > Pessoal';
        $this->load->view('professor/arquivo/pessoal', $data);
    }   
*/
}
