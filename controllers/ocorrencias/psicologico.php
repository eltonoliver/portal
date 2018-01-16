<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Psicologico extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('colegio/colegio_model', 'colegio', TRUE);
        $this->load->model('ocorrencias/ocorrencias_model', 'ocorrencia', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'funcoes','directory'));
        $this->load->library(array('form_validation', 'session','upload'));
    }
    
    function enviar_anexo($arquivo,$cd_ocorrencia){
        $caminho = ''.$_SERVER['DOCUMENT_ROOT'].'/portal/application/upload/documentos/'.$cd_ocorrencia;
        if(is_dir($caminho)){
            $caminho = ''.$_SERVER['DOCUMENT_ROOT'].'/portal/application/upload/documentos/'.$cd_ocorrencia;
        }else{
            mkdir ($caminho, 0777);
        }
        //echo $caminho;
        $data['caminho'] = $caminho;#''.$_SERVER['DOCUMENT_ROOT'].'/seculo/application/upload/funcionario/';
        $data['diretorio'] = directory_map($data['caminho']);
        $file = "".$arquivo."";
        $config['upload_path'] = $caminho;#''.$_SERVER['DOCUMENT_ROOT'].'/seculo/application/upload/funcionario/';
        $config['allowed_types'] = '*';
        $config['max_size']	= '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name']  = true;
      
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ( ! $this->upload->do_upload($file)){
                return NULL;
        }else{
                $dados = $this->upload->data();
                $anexo =  $dados['raw_name'].$dados['file_ext'];
                return $anexo;
        }
    }

    function index() {        
        $data = array('titulo' => '<h1> Psicologia <i class="fa fa-angle-double-right"></i> Acompanhamento</h1>',
                      'lista'=>$this->ocorrencia->sp_ocorrencias(array('operacao' => 'LO', 'tipo' => 'P'))
            );
        $this->load->view('ocorrencias/lista', $data);
    }
    
    function detalhe() {
        $data = array('titulo' => '<h1> Psicologia <i class="fa fa-angle-double-right"></i> Detalhes</h1>',
                      'det'=>$this->ocorrencia->sp_ocorrencias(array('operacao' => 'LO', 'tipo' => 'P','cd_aluno'=>  base64_decode($this->input->get('cd'))))
            );
   //     print_r($data['det']);
        $this->load->view('ocorrencias/detalhes', $data);
    }

    function cadastrar() {
        $data = array('curso' => $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'C')));
        $this->load->view('ocorrencias/cad_ocorrencia', $data);
    }

    function confirmar() {
        $parametro = array('operacao' => 'IC',
            'cd_aluno' => $this->input->post('aluno'),
          //  'data' => formata_data($this->input->post('data'), 'br'),
            'data' => $this->input->oracle_data($this->input->post('data')),
            'tipo' => 'P'
        );

        $retorno = $this->ocorrencia->sp_ocorrencias($parametro);
        
        if ($retorno[0]['CD_OCORRENCIA']) {
            $consulta = array('operacao' => 'CO', 'cd_ocorrencia' => $retorno[0]['CD_OCORRENCIA']);
            $dados = $this->ocorrencia->sp_ocorrencias($consulta);
          
            //$this->load->view('ocorrencias/cad_descricao',$dados);
            //redirect('ocorrencias/psicologico/descricao?d='.urlencode(serialize($dados)).' ','refresh');
            redirect('ocorrencias/psicologico/descricao?' . http_build_query($dados) . ' ', 'refresh');
        } else {
            set_msg('msg', 'Erro ao cadastrar a Consulta, Tente Novamente', 'erro');
            redirect('ocorrencias/lista', 'refresh');
        }
    }

    function descricao() {
        $dados = array('aluno' => $_GET,
                       'tipo_arquivo' => $this->ocorrencia->sp_ocorrencias(array('operacao' => 'LTD')),
                       'parentesco'=>$this->ocorrencia->sp_ocorrencias(array('operacao' => 'GP')));
        $this->load->view('ocorrencias/cad_descricao', $dados);
    }


    function deletar_ocorrencia() {
        $id = $this->input->get('id');

        $sucesso = $this->ocorrencia->sp_ocorrencias(array('operacao' => 'EO', 'cd_ocorrencia' => $id));
        
        if ($sucesso) {
            set_msg('msg', 'Consulta cancelada com sucesso', 'warning');
            redirect('ocorrencias/psicologico', 'refresh');
        } else {
            set_msg('msg', 'Erro ao cancelar a consulta', 'erro');
            redirect('ocorrencias/psicologico', 'refresh');
        }
    }
    
    
    function conf_descricao() {
        $cd_ocorrencia = $this->input->get_post('cd_ocorrencia');
        //INSERI O CONTEUDO DA OCORRENCIA
        $this->ocorrencia->sp_ocorrencias(array('operacao' => 'ID', 
                                                'cd_ocorrencia' => $cd_ocorrencia,
                                                'descricao'=>$this->input->get_post('conteudo'),
                                                'assunto' => $this->input->post('assunto')));
        //inserir os participantes
        $qtd_participante = count($this->input->post('participante'));
        for ($p = 0; $p < $qtd_participante; $p++) {
            $this->ocorrencia->sp_ocorrencias(array('operacao' => 'IP', 
                                                    'cd_ocorrencia' => $cd_ocorrencia,
                                                    'nome'=>$_POST['participante'][$p],
                                                    'cd_parentesco'=>$_POST['parentesco'][$p])
                                              );
        }
        
        //inseri os arquivos
        for ($i = 1; $i < 3; $i++) {
            if($_FILES['arquivo'.$i]['name'] != ""){
                $tipo = $_POST['tipo_arquivo'][$i];
                $arquivo = $this->enviar_anexo('arquivo'.$i,$cd_ocorrencia);   
                $this->ocorrencia->sp_ocorrencias(array('operacao' => 'UI', 'cd_ocorrencia' => $cd_ocorrencia,'arquivo'=>$arquivo, 'tipo'=>$tipo));
            }
        }
        
        set_msg('msg', 'Registro Inserido com sucesso', 'sucesso');
        redirect('ocorrencias/psicologico?cd='.$cd_ocorrencia.' ', 'refresh');
        
    }
    
    function imprimir() {
        
        $parametro = array(
            'operacao' => 'CO',
            'cd_ocorrencia' => $this->input->get_post('cd'),
            'tipo'=>'P'
        );
        $data = array('dados' => $this->ocorrencia->sp_ocorrencias($parametro),
                      'participante'=>$this->ocorrencia->sp_ocorrencias(array('operacao'=>'LP','cd_ocorrencia'=>$this->input->get_post('cd'))));
    
        //PARAMENTROS PARA CARREGA A LISTA DE TIPO DE NOTAS
        $html = $this->load->view('ocorrencias/imprimir', $data, true);
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $mpdf->SetHTMLHeader($this->load->view('impressao/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                '', '', '', '', 
                20, // margin_left
                20, // margin right
                25, // margin top
                30, // margin bottom
                0, // margin header
                0); // margin footer 
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetHTMLFooter($this->load->view('impressao/footer', $data, true));
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
    
    
    function excluir_arquivo() {
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
    
    function upload_arq(){
        $data = array('cd_ocorrencia'=>$this->uri->segment(4),
                      'tipo_arquivo' => $this->ocorrencia->sp_ocorrencias(array('operacao' => 'LTD')),
                      'cd_aluno'=>  $this->uri->segment(5));
        $this->load->view('ocorrencias/upload_arquivos',$data);
    }
    
    function upload(){
        //inseri os arquivos
        for ($i = 1; $i < 3; $i++) {
            if($_FILES['arquivo'.$i]['name'] != ""){
                $tipo = $_POST['tipo_arquivo'][$i];
                $arquivo = $this->enviar_anexo('arquivo'.$i,$this->input->get_post('cd_ocorrencia'));   
                $this->ocorrencia->sp_ocorrencias(array('operacao' => 'UI', 'cd_ocorrencia' => $this->input->get_post('cd_ocorrencia'),'arquivo'=>$arquivo, 'tipo'=>$tipo));
            }
        }
        
        set_msg('msg', 'Upload Realizado com sucesso', 'sucesso');
        redirect('ocorrencias/psicologico/detalhe?cd='.base64_encode($this->input->get_post('cd_aluno')).' ', 'refresh');
    }
    
    function editar(){
        $cd_ocorrencia = $this->input->get('cd');
        $data = array('dados'=>$this->ocorrencia->sp_ocorrencias(array('operacao'=>'CO','cd_ocorrencia'=>$cd_ocorrencia)),
                      'participantes'=>$this->ocorrencia->sp_ocorrencias(array('operacao'=>'LP','cd_ocorrencia'=>$cd_ocorrencia)),
                      'arquivos'=>$this->ocorrencia->sp_ocorrencias(array('operacao'=>'LAR','cd_ocorrencia'=>$cd_ocorrencia)),
            );
        $this->load->view('ocorrencias/editar_descricao',$data);
    }
    
    function edicao_ocorrencia(){
       $param = array('operacao' => 'ID', 
                      'cd_ocorrencia' => $this->input->get_post('cd_ocorrencia'),
                      'descricao'=>$this->input->get_post('conteudo'),
                      'assunto' => $this->input->post('assunto'));
       $ok = $this->ocorrencia->sp_ocorrencias($param);
       
       if($ok){
            set_msg('msg', 'Registro Alterado com sucesso', 'sucesso');
       }else{
           set_msg('msg', 'Erro ao alterar o resgostro', 'erro');
       }
        redirect('ocorrencias/psicologico/detalhe?cd='. base64_encode($this->input->get_post('cd_aluno')).' ', 'refresh');
        
       
    }

}
