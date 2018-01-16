<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inicio extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('responsavel_model', 'responsavel', TRUE);
        $this->load->model('professor/infantil_model', 'infantil', TRUE);
        $this->load->model('professor/diario_model', 'diario', TRUE);
        $this->load->model('inicio_model', 'inicio', TRUE);
        $this->load->model('financeiro/pagamento_model', 'pagar', TRUE);
        $this->load->model('coordenacao/ocorrencia_model', 'ocorrencia', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory', 'file', 'funcoes'));
        $this->load->library(array('form_validation', 'session'));
    }

    function index() {
        //para remover visualização do modal de aviso
        $this->session->set_userdata('VISUALIZOU_AVISO', true);

        $data = array(
            'titulo' => 'Bem Vindo ao Portal Educacional Século',
            'mensagem' => '',
                //   'tabela'=>$this->inicio->tempo_aula(1,$this->session->userdata('SCL_SSS_USU_PCODIGO')),
                //'noticias'=>$this->noticia->listaUltimasNoticias(),
        );
        
        //ultimas noticias
        $paramento = array('operacao' => 'N');

        if ($this->session->userdata('SCL_SSS_USU_TIPO') == 10) { // VISAO DO ALUNO
            //carrega as ultimas noticias
            $data['noticias'] = $this->inicio->sp_dashboard($paramento);
            //gabarito P1
            //$data['gabarito'] = $this->ocorrencia->gabarito_provas($this->session->userdata('SCL_SSS_USU_CODIGO'))->result();

            $this->load->view('inicio/aluno', $data);
            echo $this->foto($this->session->userdata('SCL_SSS_USU_FOTO'));
        } elseif ($this->session->userdata('SCL_SSS_USU_TIPO') == 20) { // VISAO DO RESPONSAVEL
            //carrega as ultimas noticias
            $data['noticias'] = $this->inicio->sp_dashboard($paramento);
            $data['aluno'] = $this->responsavel->acompanhamento(array('operacao' => 'L', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO')));

            $data['rematricula'] = $this->responsavel->rematricula(array('operacao' => 'L', 'responsavel' => $this->session->userdata('SCL_SSS_USU_CODIGO')));

            $this->load->view('inicio/responsavel', $data);
        } elseif ($this->session->userdata('SCL_SSS_USU_TIPO') == 30) { // VISAO DO PROFESSOR
            //carrega as ultimas noticias
            $data['noticias'] = $this->inicio->sp_dashboard($paramento);
            //tempos de aula do professor
            $data['horario'] = $this->diario->horario(array(
                'cd_professor' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
            ));

            $this->load->view('inicio/professor', $data);
        } else if ($this->session->userdata('SCL_SSS_USU_TIPO') == 40) { // VISAO DO COLABORADOR
            //carrega as ultimas noticias
            $data['noticias'] = $this->inicio->sp_dashboard($paramento);

            $this->load->view('inicio/colaborador', $data);
        }
    }

    function tabela_infantil() {

        $paramento = array(
            'operacao' => 'LR',
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
            'cd_aluno' => $this->input->get_post('aluno'),
            'dia' => $this->input->get_post('dia')
        );

        $data['diario'] = $this->infantil->sp_infantil($paramento);
        $data['data'] = $this->input->get_post('dia');
        $this->load->view('inicio/grid_acompanhamento', $data);
    }

    function funcao() {

        $paramento = array(
            'aluno' => '14004160',
        );

        $data['diario'] = $this->inicio->fctaluno($paramento);
    }

    function trocar_senha() {
        $data = array(
            'titulo' => 'Trocar Senha de Acesso'
        );
        $this->load->view('inicio/troca_senha', $data);
    }

    function conf_troca() {
        $dados = array('tipo' => $this->session->userdata('SCL_SSS_USU_TIPO'),
            'usuario' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
            'senha' => $this->input->post('nova_senha')
        );

        $sucesso = $this->inicio->alterar_senha($dados);
        if (count($sucesso) > 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    function valida_senha() {
        $dados = array('tipo' => $this->session->userdata('SCL_SSS_USU_TIPO'),
            'usuario' => $this->session->userdata('SCL_SSS_USU_CODIGO'),
            'senha' => $this->input->post('senha')
        );

        $sucesso = $this->inicio->get_bySenha($dados)->result();

        if (count($sucesso) != 0) {
            echo 1;
        } else {
            echo 0;
        }
    }

    /**
     * Parametro para indicar que o aviso foi visto na sessão atual e não 
     * disparar mais o modal para esta sessão.
     */
    function visualizaAviso() {
        $this->session->set_userdata("VISUALIZOU_AVISO", true);
    }

}
