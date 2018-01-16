<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Noticia extends CI_Controller {

    function __construct() {
        parent::__construct();
        //model sem procedure
        $this->load->model('sica/noticias_model', 'noticias');

        //models usando procedure
        $this->load->model('colegio/noticia_model', 'noticia', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file', 'funcoes'));
        $this->load->library(array('form_validation', 'session', 'email', 'upload'));
    }

    function enviar_anexo($arquivo) {

        $data['caminho'] = '' . $_SERVER['DOCUMENT_ROOT'] . '/portal/application/upload/noticia/';
        $data['diretorio'] = directory_map($data['caminho']);
        $file = "" . $arquivo . "";
        $config['upload_path'] = '' . $_SERVER['DOCUMENT_ROOT'] . '/portal/application/upload/noticia/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = true;
        //    $config['file_name'] = md5($file).date('dmYhhss');

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($file)) {
            return NULL;
        } else {
            $dados = $this->upload->data();
            $anexo = $dados['raw_name'] . $dados['file_ext'];
            return $anexo;
        }
    }

    function index() {
        $parametro = array('operacao' => 'LN');
        $data = array(
            'titulo' => '<h1> Colégio <i class="fa fa-angle-double-right"></i> Notícia(s) </h1>',
            'navegacao' => 'Colégio > Notícia(s)',
            'listar' => $this->noticia->sp_noticias($parametro)
        );
        $this->load->view('colegio/noticia/index', $data);
    }

    function frmnoticia() {
        switch ($this->input->get_post('acao')) {
            case 'I': // INSERIR DADOS NO BANCO
                $parametro = array('operacao' => 'LT');
                $data = array(
                    'titulo' => '<h3> Colégio <i class="fa fa-angle-double-right"></i> Adicionar Notícia </h3>',
                    'acao' => $this->input->get_post('acao'),
                    'autor' => $this->session->userdata('SCL_SSS_USU_NOME'),
                    'not_tipo' => $this->noticia->sp_noticias($parametro),
                    'bt_cor' => 'success',
                    'bt_acao' => 'Inserir',
                    'codigo' => '',
                    'titulo_text' => '',
                    'chamada' => '',
                    'status' => '',
                    'anexo' => '',
                    'publicado' => '',
                    'corpo' => '',
                );
                break;
            case 'U': // EDITA DADOS NO BANCO
                $param_tipo = array('operacao' => 'LT');
                $parametro = $this->input->get_post('codigo');
                $row = $this->noticias->consultar($parametro);

                //preencher as datas em formato amigavel para o usuario
                $auxInicio = $row['DT_INICIO'];
                $auxFim = $row['DT_FIM'];

                $dataInicio = "";
                $dataFim = "";
                if (!empty($auxInicio)) {
                    $dataInicio = date('d/m/Y', strtotime($auxInicio));
                }

                if (!empty($auxFim)) {
                    $dataFim = date('d/m/Y', strtotime($auxFim));
                }

                $data['codigo'] = $row['ID_NOTICIA'];
                $data['autor'] = $row['AUTOR'];
                $data['scltitulo'] = $row['TITULO'];
                $data['sclstatus'] = $row['STATUS'];
                $data['sclcorpo'] = $row['CORPO'];
                $data['sclpopup'] = $row['POPUP'];
                $data['tipo'] = $row['CD_TIPO'];
                $data['dtInicio'] = $dataInicio;
                $data['dtFim'] = $dataFim;
                $data['not_tipo'] = $this->noticia->sp_noticias($param_tipo);
                $data['titulo'] = '<h3> Colégio <i class="fa fa-angle-double-right"></i> Editar Notícia </h3>';
                $data['acao'] = $this->input->get_post('acao');
                $data['bt_cor'] = 'warning';
                $data['bt_acao'] = 'Editar';

                break;
            case 'E': //EXCLUIR DADOS DO BANCO
                $param_tipo = array('operacao' => 'LT');
                $parametro = $this->input->get_post('codigo');
                $row = $this->noticias->consultar($parametro);

                //preencher as datas em formato amigavel para o usuario
                $auxInicio = $row['DT_INICIO'];
                $auxFim = $row['DT_FIM'];

                $dataInicio = "";
                $dataFim = "";
                if (!empty($auxInicio)) {
                    $dataInicio = date('d/m/Y', strtotime($auxInicio));
                }

                if (!empty($auxFim)) {
                    $dataFim = date('d/m/Y', strtotime($auxFim));
                }

                $data['codigo'] = $row['ID_NOTICIA'];
                $data['autor'] = $row['AUTOR'];
                $data['scltitulo'] = $row['TITULO'];
                $data['sclstatus'] = $row['STATUS'];
                $data['sclcorpo'] = $row['CORPO'];
                $data['sclpopup'] = $row['POPUP'];
                $data['tipo'] = $row['CD_TIPO'];
                $data['dtInicio'] = $dataInicio;
                $data['dtFim'] = $dataFim;
                $data['not_tipo'] = $this->noticia->sp_noticias($param_tipo);
                $data['titulo'] = '<h3> Colégio <i class="fa fa-angle-double-right"></i> Deletar Notícia </h3>';
                $data['acao'] = $this->input->get_post('acao');
                $data['bt_cor'] = 'danger';
                $data['bt_acao'] = 'Deletar';

                break;
        }
        $this->load->view('colegio/noticia/frmnoticia', $data);
    }

    function frmnoticiamanter() {
        $this->form_validation->set_rules('scltitulo', 'Titulo', 'required');
        #   $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        #   $this->form_validation->set_rules('scldata', 'Data', 'required');
        #   $this->form_validation->set_rules('sclcorpo', 'Corpo', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['autor'] = $this->session->userdata('SCL_SSS_USU_NOME');
            $data['scltitulo'] = $_POST['scltitulo'];
            $data['acao'] = $_REQUEST['acao'];
            $data['bt_cor'] = $_REQUEST['bt_cor'];
            $data['bt_acao'] = $_REQUEST['bt_acao'];
            $data['not_tipo'] = $this->noticia->sp_noticias(array("operacao" => "LT"));
            $this->load->view('colegio/noticia/frmnoticia', $data);
        } else {
            $anexo = $this->enviar_anexo('arquivo');

            //obter datas para serem convertidas
            $auxInicio = $this->input->get_post('dtInicio');
            $auxFim = $this->input->get_post('dtFim');

            $dataInicio = "";
            $dataFim = "";
            if (!empty($auxInicio) && !empty($auxFim)) {
                $auxInicio = date_create_from_format('d/m/Y', $auxInicio);
                $auxFim = date_create_from_format('d/m/Y', $auxFim);

                $dataInicio = $auxInicio->format("Y-m-d");
                $dataFim = $auxFim->format("Y-m-d");
            }

            $parametro = array(
                'autor' => $this->session->userdata('SCL_SSS_USU_NOME'),
                'titulo' => $this->input->get_post('scltitulo'),
                'status' => $this->input->get_post('sclstatus') ? 1 : 0,
                'operacao' => $this->input->get_post('acao'),
                'tipo' => $this->input->get_post('tipo'),
                'id_noticia' => $this->input->get_post('id_noticia'),
                'chamada' => $anexo,
                'inicio' => $dataInicio,
                'fim' => $dataFim,
                'popup' => $this->input->get_post('sclpopup') ? 1 : 0
            );

            switch ($this->input->get_post('acao')) {
                case 'I': // INSERIR DADOS NO BANCO
                    $parametro['operacao'] = 'I';
                    $retorno = $this->noticia->sp_noticias($parametro);
                    //   print_r($retorno);exit;
                    if ($retorno == true) {
                        set_msg('msgok', 'Notícia Inserida com Sucesso.', 'sucesso');
                    } else {
                        set_msg('msgerro', 'Erro ao cadastrar a notícia', 'erro');
                    }
                    redirect(base_url('index.php/colegio/noticia/index'), 'refresh');
                    break;
                case 'U': // INSERIR DADOS NO BANCO
                    $parametro['operacao'] = 'U';
                    $retorno = $this->noticia->sp_noticias($parametro);
                    if ($retorno == true) {
                        set_msg('msgok', 'Notícia Editada com Sucesso.', 'sucesso');
                    } else {
                        set_msg('msgerro', 'Erro ao editar a notícia', 'erro');
                    }
                    redirect(base_url('index.php/colegio/noticia/index'), 'refresh');
                    break;
                case 'E': // EXCLUSAO DADOS NO BANCO
                    $parametro['operacao'] = 'E';
                    $retorno = $this->noticia->sp_noticias($parametro);
                    if ($retorno == true) {
                        set_msg('msgok', 'Notícia excluida com Sucesso.', 'sucesso');
                    } else {
                        set_msg('msgerro', 'Erro ao excluir a notícia', 'erro');
                    }
                    redirect(base_url('index.php/colegio/noticia/index'), 'refresh');
                    break;
            }
        }
    }

}
