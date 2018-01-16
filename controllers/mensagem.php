<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mensagem extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('mensagem_model', 'mensagem', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file', 'funcoes'));
        $this->load->library(array('form_validation', 'session', 'email', 'upload', 'pagination', 'email'));
    }

    function enviar_anexo($arquivo) {

        $data['caminho'] = '' . $_SERVER['DOCUMENT_ROOT'] . '/portal/application/upload/mensagem/';
        $data['diretorio'] = directory_map($data['caminho']);
        $file = "" . $arquivo . "";
        $config['upload_path'] = '' . $_SERVER['DOCUMENT_ROOT'] . '/portal/application/upload/mensagem/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = true;

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

    /**
     * Exibe telas de mensangens de entrada
     * 
     * @param string $tipo Pode conter um dos seguintes valores:
     * S -> mensagens lidas
     * N -> mensangens não lidas
     * R -> mensagens respondidas
     * T -> todas as mensagens
     * 
     * @param type $start
     * @param type $ajax
     */
    function index($tipo = "T") {
//        if ($this->session->userdata('SCL_SSS_USU_PCODIGO') != '') {
//            $parametro = array('operacao' => 'LME',
//                'usuario' => $this->session->userdata('SCL_SSS_USU_PCODIGO')
//            );
//        } else {
//            $parametro = array('operacao' => 'LME',
//                'usuario' => $this->session->userdata('SCL_SSS_USU_CODIGO')
//            );
//        }

        $parametro = array('operacao' => 'LME',
            'usuario' => $this->session->userdata('SCL_SSS_USU_CODIGO')
        );

        $pagina = $this->input->get('pagina');
        $start = (empty($pagina) ? 1 : $pagina);
        $listar = $this->mensagem->mensagem($parametro);

        $mensagem = array();
        for ($i = 0; $i < count($listar); $i++) {
            if (isset($listar[$i])) {
                if ($tipo == "N" && $listar[$i]['STATUS'] == "N") {
                    $mensagem['N'][] = $listar[$i];
                } else if ($tipo == "S" && $listar[$i]['STATUS'] == "S") {
                    $mensagem['S'][] = $listar[$i];
                } else if ($tipo == "R" && !empty($listar[$i]['ID_PAI'])) {
                    $mensagem['R'][] = $listar[$i];
                } else if ($tipo == "T") {
                    $mensagem['T'][] = $listar[$i];
                }
            }
        }

        $mensagem_tt = count($mensagem[$tipo]);

        $config = array(
            'base_url' => site_url('mensagem/index/?tipo=' . $tipo . "&pagina="),
            'cur_page' => $start,
            'per_page' => 5,
            'uri_segment' => 4,
            'total_rows' => $mensagem_tt,
        );

        if ($start == 1) {
            $inicio = 0;
        } else {
            $inicio = $config['per_page'] * ($start - 1);
        }

        $mensagem[$tipo] = array_slice($mensagem[$tipo], $inicio, 5);
        $this->pagination->initialize($config);

        $data = array(
            'titulo' => "Caixa de Entrada",
            'paginacao' => $this->pagination->create_links(),
            'mensagem' => $mensagem[$tipo], //$this->mensagem->mensagem($parametro), // LISTA DE MENSAGEM            
            'tipo' => $tipo,
            'mensagem_tt' => $mensagem_tt,
        );

        if ($this->input->post('ajax') == 1) {
            echo $this->load->view('mensagem/entrada_listar', $data, true);
        } else {
            $this->load->view('mensagem/index', $data);
        }
    }

    // FUNCAO PARA MENSAGEM DE SAIDA
    function saida() {
//        if ($this->session->userdata('SCL_SSS_USU_PCODIGO') != '') {
//            $parametro = array('operacao' => 'LMS',
//                //'usuario' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
//                'usuario' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
//            );
//        } else {
//            $parametro = array('operacao' => 'LMS',
//                'usuario' => $this->session->userdata('SCL_SSS_USU_CODIGO')
//            );
//        }

        $parametro = array('operacao' => 'LMS',            
            'usuario' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
        );

        $pagina = $this->input->get('pagina');
        $start = (empty($pagina) ? 1 : $pagina);
        $listar = $this->mensagem->mensagem($parametro);

        $mensagem = array();
        for ($i = 0; $i < count($listar); $i++) {
            if (isset($listar[$i]) && $$listar[$i]['TRASH'] == 0) {
                $mensagem[] = $listar[$i];
            }
        }

        $mensagem_tt = count($mensagem);

        $config = array(
            'base_url' => site_url('mensagem/saida/?pagina='),
            'cur_page' => $start,
            'per_page' => 5,
            'total_rows' => $mensagem_tt,
        );

        if ($start == 1) {
            $inicio = 0;
        } else {
            $inicio = $config['per_page'] * ($start - 1);
        }

        $mensagem = array_slice($mensagem, $inicio, 5);

        $this->pagination->initialize($config);
        $data = array(
            'titulo' => 'Caixa de Saída',
            'paginacao' => $this->pagination->create_links(),
            'mensagem' => $mensagem,
            'mensagem_tt' => $mensagem_tt,
        );

        if ($this->input->post('ajax') == 1) {
            echo $this->load->view('mensagem/saida_listar', $data, true);
        } else {
            $this->load->view('mensagem/saida', $data);
        }
    }

    function escrever() {

        $tipo = $this->session->userdata('SCL_SSS_USU_TIPO');

        $data = array(
            'listargrupo' => $this->mensagem->grupo($tipo),
            'titulo' => '<h1 style="text-transform:capitalize"> Caixa Postal <i class="fa fa-angle-double-right"></i> Escrever Mensagem </h1>',
            'navegacao' => 'Caixa Postal > Escrever Mensagem'
        );
        $this->load->view('mensagem/escrever', $data);
    }

    function enviar() {
        $tipo = $this->session->userdata('SCL_SSS_USU_TIPO');

        $this->form_validation->set_rules('sclassunto', 'Assunto', 'required');
        $this->form_validation->set_rules('sclmsg', 'Mensagem', 'required');
        $this->form_validation->set_rules('destino', 'Destinatário', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['titulo'] = '<h1 style="text-transform:capitalize"> Caixa Postal <i class="fa fa-angle-double-right"></i> Escrever Mensagem </h1>';
            $data['navegacao'] = 'Caixa Postal > Escrever Mensagem';

            $data['listargrupo'] = $this->mensagem->grupo($tipo);
            $this->load->view('mensagem/escrever', $data);
        } else {
            $parametro = array(
                'operacao' => 'I',
                'de' => $this->session->userdata('SCL_SSS_USU_CODIGO'), // USUÁRIO QUE ENVIA A MENSAGEM
                'assunto' => $this->input->get_post('sclassunto'), // USUÁRIO QUE RECEBERÃO A MENSAGEM
                'conteudo' => $this->input->get_post('sclmsg'), // TEXTO DA MENSAGEM
                'anexo' => $this->enviar_anexo('arquivo'), // CHAMA A FUNÇÃO QUE FAZ O UPLOAD DO ANEXO
                'destino' => $this->input->get_post('destino'),
                'spam' => '0',
                'idmsg' => $this->input->get_post('idmsg'),
            );

            $this->mensagem->enviar($parametro);
            redirect(base_url('mensagem'), 'refresh');
        }
    }

    function marcar_lida() {
        $codigo = $this->input->post('codigo');

        if (!empty($codigo)) {
            $this->mensagem->marcar_lida($codigo);
        }
    }

    function excluir() {
        $codigo = $this->input->post("codigo");
        $result = array('success' => false);

        if (!empty($codigo)) {
            $parametros = array(
                'operacao' => "D",
                'mensagem' => $codigo,
            );

            $this->mensagem->mensagem($parametros);
            $result['success'] = true;
        }

        echo json_encode($result);
    }

    function visualizar() {

        $codigo = $this->input->get_post('codigo');
        $data['tipo'] = $this->input->get_post('tipo');
        $mensagem = $this->mensagem->visualizar_mensagem($codigo);

        foreach ($mensagem as $l) {
            $data['assunto'] = $l->SUBJECT;
            $data['codigo'] = $l->ID;
            $data['de'] = $l->DE;
            $data['aluno'] = $l->ALUNO;
            $data['professor'] = $l->PROFESSOR;
            $data['colaborador'] = $l->COLABORADOR;
            $data['responsavel'] = $l->RESPONSAVEL;
            $data['mensagem'] = $l->CONTENT;
            $data['lixeira'] = $l->TRASH;
            $data['anexo'] = $l->ANEXO;
            $data['span'] = $l->SPAM;
            $data['idpai'] = $l->ID_PAI;
        }
        if ($this->input->get('view') == 'entrada') {
            $this->load->view('mensagem/visualizar_entrada', $data);
        } else {
            $data['pessoa'] = $this->mensagem->visualizar_pessoa($codigo);
            $this->load->view('mensagem/visualizar_saida', $data);
        }
    }

    function filho() {

        $tipo = $this->session->userdata('SCL_SSS_USU_TIPO');
        $para = $this->input->get_post('matricula');
        $filho = $this->input->get_post('filho');
        $responsavel = $para = $this->session->userdata('SCL_SSS_USU_ID');

        $data = array(
            'titulo' => '<h1 style="text-transform:capitalize"> Caixa Postal <i class="icon-double-angle-right"></i> Caixa de Entrada <i class="icon-double-angle-right"></i> ' . ucfirst(strtolower(strtoupper($filho))) . '</h1>',
            'navegacao' => 'Caixa Postal > Caixa de Entrada',
            // CRIA A LISTA DE MENSAGENS DE ENTRADA
            'mensagem' => $this->mensagem->entrada(1, $para, 0),
            // CRIA A VARIÁVEL DE TOTAL DE MENSAGENS DE ENTRADA 
            'tentrada' => $this->mensagem->entrada(2, $para, 0),
            // CRIA A VARIÁVEL DE TOTAL DE MENSAGENS DE SAÍDA 
            'tsaida' => $this->mensagem->saida(2, 0),
            // CRIA A VARIÁVEL TIPO DE MENSAGEM 
            'tipo' => 0,
            'matricula' => $this->input->get_post('matricula'),
            'filho' => $this->input->get_post('filho')
        );

        $this->load->view('colegio/mensagem/filho', $data);
    }

    function filho_saida() {

        $tipo = $this->session->userdata('SCL_SSS_USU_TIPO');
        $de = $this->input->get_post('matricula');
        $filho = $this->input->get_post('filho');
        $responsavel = $para = $this->session->userdata('SCL_SSS_USU_ID');

        $data = array(
            'titulo' => '<h1 style="text-transform:capitalize"> Caixa Postal <i class="icon-double-angle-right"></i> Caixa de Saída <i class="icon-double-angle-right"></i> ' . ucfirst(strtolower(strtoupper($filho))) . '</h1>',
            'navegacao' => 'Caixa Postal > Caixa de Saída',
            // CRIA A LISTA DE MENSAGENS DE ENTRADA
            'tentrada' => $this->mensagem->entrada(2, $de, 0),
            // CRIA A VARIÁVEL DE TOTAL DE MENSAGENS DE ENTRADA 
            'mensagem' => $this->mensagem->saida(1, $de),
            // CRIA A VARIÁVEL DE TOTAL DE MENSAGENS DE SAÍDA 
            'tsaida' => $this->mensagem->saida(2, $de),
            // CRIA A VARIÁVEL TIPO DE MENSAGEM 
            'tipo' => 1,
            'matricula' => $this->input->get_post('matricula'),
            'filho' => $this->input->get_post('filho')
        );
        $this->load->view('colegio/mensagem/filho', $data);
    }

    function filho_lixeira() {

        $tipo = $this->session->userdata('SCL_SSS_USU_TIPO');
        $de = $this->input->get_post('matricula');
        $filho = $this->input->get_post('filho');
        $responsavel = $para = $this->session->userdata('SCL_SSS_USU_ID');

        $data = array(
            'titulo' => '<h1 style="text-transform:capitalize"> Caixa Postal <i class="icon-double-angle-right"></i> Lixeira <i class="icon-double-angle-right"></i> ' . ucfirst(strtolower(strtoupper($filho))) . '</h1>',
            'navegacao' => 'Caixa Postal > Lixeira',
            // CRIA A LISTA DE MENSAGENS DE ENTRADA
            'tentrada' => $this->mensagem->entrada(2, $de, 0),
            // CRIA A VARIÁVEL DE TOTAL DE MENSAGENS DE ENTRADA 
            'mensagem' => $this->mensagem->saida(1, $de),
            // CRIA A VARIÁVEL DE TOTAL DE MENSAGENS DE SAÍDA 
            'tsaida' => $this->mensagem->saida(2, $de),
            // CRIA A VARIÁVEL TIPO DE MENSAGEM 
            'tipo' => 2,
            'matricula' => $this->input->get_post('matricula'),
            'filho' => $this->input->get_post('filho')
        );
        $this->load->view('colegio/mensagem/filho', $data);
    }

    function email() {
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'localhost',
            'smtp_port' => 25,
            'smtp_auth' => true,
            'smtp_user' => 'silvio.souza@seculomanaus.com.br',
            'smtp_pass' => 'Seculo2015!',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );

        $this->email->initialize($config);

        $this->email->from('no-replay@seculomanaus.com.br', 'Século Centro Educacional');
        //$this->email->to($email);
        $this->email->to('davsonsantos@gmail.com');
        $this->email->bcc('silvio.souza@seculomanaus.com.br');
        $this->email->subject('Aviso de Nova Mensagem');
        $this->email->message('apenas um teste de servidor');
        $this->email->send();
        echo $this->email->print_debugger();
    }

    function resposta_rapida() {

        $tipo = $this->session->userdata('SCL_SSS_USU_TIPO');
        switch ($tipo) {
            // CRIA A MENSAGEM PARA O ALUNO
            case 10:$de = $this->session->userdata('SCL_SSS_USU_ID');
                break;
            // CRIA A MENSAGEM PARA O PROFESSOR
            case 20:$de = $this->session->userdata('SCL_SSS_USU_PCODIGO');
                break;
            // CRIA A MENSAGEM PARA O RESPONSAVEL
            case 30:$de = $this->session->userdata('SCL_SSS_USU_ID');
                break;
            // CRIA A MENSAGEM PARA O COLABORADOR
            case 40:$de = $this->session->userdata('SCL_SSS_USU_CODIGO');
                break;
        }

        $para = $this->input->get_post('sclpara');
        $assunto = $this->input->get_post('sclassunto');
        $mensagem = $this->input->get_post('sclmsg');
        $pai = $this->input->get_post('sclmsgpai');

        $palavra = $this->secretaria->palavra_restrita();

        // VERIFICAR SE HÁ ALGUMA PALAVRA RESTRITA NA MENSAGEM
        foreach ($palavra as $item) {
            $palavra = $item->NM_PALAVRA;
            $verificar_mensagem = strripos($mensagem, $palavra);
            if ($verificar_assunto == false && $verificar_mensagem == false) {
                $spam = 0;
            } else {
                $spam = 1;
            }
        }

        $anexo = $this->enviar_anexo('arquivo');
        $this->mensagem->enviar_rapida($de, $para, $assunto, $mensagem, $spam, $anexo, $pai);
        redirect(base_url('/index.php/colegio/mensagem'), 'refresh');
    }

    function grupo_listar() {

        $tipo = $this->input->post('grupo');
        if (strlen($tipo) == 1) {
            switch ($tipo) {
                // RETORNA LISTA DE TURMAS
                case 1:
                    echo $this->mensagem->aluno($this->session->userdata('SCL_SSS_USU_TURMA'));
                    break;
                // RETORNA LISTA DE PROFESSORES
                case 2:
                    echo $this->mensagem->professor();
                    break;
                // RETORNA A LISTA DE COLABORADORES
                case 3:
                    echo $this->mensagem->colaborador_curso();
                    break;
                // RETORNA DE PROFESSORES
                case 4:
                    echo $this->mensagem->grupo_turma('ALU');
                    break;
                // RETORNA DE PROFESSORES
                case 5:
                    echo $this->mensagem->meus_professores($this->session->userdata('SCL_SSS_USU_TURMA'));
                    break;
                // RETORNA DE PROFESSORES
                case 6:
                    echo $this->mensagem->grupo_turma_professor($this->session->userdata('SCL_SSS_USU_CODIGO'));
                    break;
                // RETORNA DE TURMAS COM CODIGOS DOS PAIS
                case 7:
                    echo $this->mensagem->grupo_turma('RES');
                    break;
            }
        } else {
            $item = explode(':', $tipo);
            echo $this->mensagem->grupo_listar($item[1], $item[0]);
        }
    }

}
