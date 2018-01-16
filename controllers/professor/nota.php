<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nota extends CI_Controller {

    function __construct() {
        parent::__construct();
        //model sem procedure
        $this->load->model('sica/tipo_nota_model', 'tipoNota', true);
        $this->load->model('sica/turma_professor_model', 'turmaProfessor', true);
        $this->load->model('sica/aluno_nota_model', 'notaAluno', true);

        //models com procedure
        $this->load->model('professor/diario_model', 'diario', TRUE);
//        $this->load->model('professor/nota_model', 'nota', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'funcoes'));
        $this->load->library(array('form_validation', 'session'));
    }

    function index() {
        //PARAMENTROS PARA CARREGAR A LISTA DE TURMAS DO PROFESSOR
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $professor = $this->session->userdata('SCL_SSS_USU_PCODIGO');

        $turmas = $this->turmaProfessor->listaTurmaDisciplinaRegular($professor, $periodo);
        foreach ($turmas as &$turma) {
            if (strpos($turma['CD_TURMA'], "+") !== FALSE) {
                $turma['notas'] = $this->tipoNota->listaNotasLancamento($turma['CD_TURMA'], $periodo, true);
            } else {
                $turma['notas'] = $this->tipoNota->listaNotasLancamento($turma['CD_TURMA'], $periodo);
            }
        }

        $data['turmas'] = $turmas;
        $data['titulo'] = '<h1> Diário de Classe <i class="fa fa-angle-double-right"></i> Lançamento de Notas</h1>';
        $this->load->view('professor/nota/index', $data);
    }

    /**
     * Exibe as notas lançadas de todos os alunos para um determinado
     * tipo de nota. A exibição será realizada em um modal.
     */
    function consultar() {
        $nota = $this->input->get('nota') . " - " . $this->input->get("bimestre") . "° BIMESTRE";
        $turma = $this->input->get("turma");
        if ($this->input->get("mista") == 'S') {
            $turma .= "+";
        }

        $parametros = array(
            'cd_disciplina' => $this->input->get('disciplina'),
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
            'cd_professor' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
            'cd_turma' => $turma,
            'cd_curso' => $this->input->get('curso'),
            'numero_nota' => $this->input->get('numero'),
        );

        $alunos = $this->diario->listar_aluno($parametros);
        $this->load->view('professor/nota/consultar', array(
            'alunos' => $alunos,
            'nota' => $nota
        ));
    }

    function tiponota() {
        $param = array('operacao' => 'LTNM', 'cd_estrutura' => $this->input->post('tipo'));
        $estrutura = $this->diario->sp_notas($param);

        $select = '<select name="numero_nota" id="numero_nota" class="form-control">
                      <option value="" selected="selected"> Informe a estrutura</option>';
        foreach ($estrutura as $e) {
            $select .= '<option value="' . $e['NUM_NOTA'] . '">' . $e['DC_TIPO_NOTA'] . ' - (' . $e['NM_MINI'] . ')' . $e['BIMESTRE'] . 'º Bimestre</option>';
        }
        $select .= '</select>';
        echo $select;
    }

    function estrutura_nota_mista() {
        $dados = unserialize(urldecode($_GET['dados']));
        $param = array('operacao' => 'LM',
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
            'cd_turma' => trim($dados['CD_TURMA']) . '+');

        $data = array('listar_tipo_nota_mista' => $this->diario->sp_notas($param),
            'dados' => $dados);
        $this->load->view('professor/nota/estrutura_nota_mista', $data);
    }

    function confirmar() {

        $professor = $this->session->userdata('SCL_SSS_USU_CODIGO');
        $data = array(
            'titulo' => '<h4> Diário de Classe <i class="icon-double-angle-right"></i> Lançamento de Notas</h4>',
                //'listar_tipo_nota' => $this->nota->listar_tipo_nota()
        );

        $this->load->view('' . $this->session->userdata('SCL_SSS_TIPO') . '/nota/confirmar', $data);
    }

    function lancamento() {
        //paramentros para lista os alunos 

        $parametro = array(
            'operacao' => 'LA',
            'cd_disciplina' => $this->input->get_post('disciplina'),
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
            'cd_professor' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
            'cd_turma' => $this->input->get_post('turma'),
            'cd_curso' => $this->input->get_post('curso'),
            'numero_nota' => $this->input->get_post('numero_nota'),
            'estrutura' => $this->input->get_post('tipo_estrutura'),
            'todos' => 'N'
        );

        $param = array(
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
            'cd_turma' => $this->input->get_post('turma'),
            'cd_curso' => $this->input->get_post('curso'),
            'numero_nota' => $this->input->get_post('numero_nota'),
            'cd_disciplina' => $this->input->get_post('disciplina')
        );

        $string = strstr($this->input->get_post('turma'), '+');

        if ($string == '+') {
            $tipo_nota = array('operacao' => 'LTNM',
                'cd_estrutura' => $this->input->get_post('tipo_estrutura'));
        } else {
            $tipo_nota = array('operacao' => 'LN',
                'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                'cd_turma' => $this->input->get_post('turma'));
        }

        //PARAMENTROS PARA CARREGA A LISTA DE TIPO DE NOTAS
        $data = array(
            'titulo' => '<h1> Diário de Classe <i class="icon-double-angle-right"></i> Lançamento de Notas</h1>',
            'titulo_modal' => '<h4> Diário de Classe <i class="icon-double-angle-right"></i> Lançamento de Notas</h4>',
            'navegacao' => ' Diário de Classe > Lançamento de Notas',
            'turma' => $this->input->get_post('turma'),
            'curso' => $this->input->get_post('curso'),
            'disciplina' => $this->input->get_post('disciplina'),
            'txtdisciplina' => $this->input->get_post('txtdisciplina'),
            'numero_nota' => $this->input->get_post('numero_nota'),
            'listar_aluno' => $this->diario->listar_aluno($parametro),
            'listar_tipo_nota' => $this->diario->sp_notas($tipo_nota),
            'estrutura' => $this->input->get_post('tipo_estrutura'),
            'notas_obj' => $this->diario->notas_objetivas($param),
            'num_nota' => $this->input->get_post('numero_nota')
        );
        //    print_r($data['listar_tipo_nota']);
        //echo "<pre>"; print_r($param);
        $this->load->view('professor/nota/lancamento', $data);
    }

    function lancar_nota() {
        $professor = $this->session->userdata('SCL_SSS_USU_PCODIGO');

        $param = array(
            'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
            'cd_turma' => $this->input->get_post('turma'),
            'cd_curso' => $this->input->get_post('curso'),
            'numero_nota' => $this->input->get_post('num_nota'),
            'cd_disciplina' => $this->input->get_post('disciplina')
        );

        $parametro = array(
            'cd_turma' => $this->input->get_post('turma'),
            'cd_disciplina' => $this->input->get_post('disciplina'),
            'cd_curso' => $this->input->get_post('curso'),
            'numero_nota' => $this->input->get_post('tipo'),
            'cd_professor' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
        );
        //PARAMENTROS PARA CARREGA A LISTA DE TIPO DE NOTAS
        $tipo_nota = array('operacao' => 'LN');

        $data = array(
            'titulo' => '<h1> Diário de Classe <i class="icon-double-angle-right"></i> Lançamento de Notas</h1>',
            'navegacao' => ' Diário de Classe > Lançamento de Notas',
            'cd_turma' => $this->input->get_post('turma'),
            'cd_disciplina' => $this->input->get_post('disciplina'),
            'txtdisciplina' => $this->input->get_post('txtdisciplina'),
            'listar_tipo_nota' => $this->diario->sp_notas($tipo_nota),
            'listar_aluno' => $this->diario->listar_aluno($parametro)
        );

        if (($this->input->get_post('curso') != 2) and $this->input->post('sim') != 1) {
            $data['notas_obj'] = $this->diario->notas_objetivas($param);
        }

        foreach ($data['listar_aluno'] as $row) {
            if ($this->input->get_post('curso') != 2) {
                foreach ($data['notas_obj'] as $v) {

                    if ($v->CD_ALUNO == $row->CD_ALUNO) {
                        $dados = array(
                            'nota' => $this->input->post('disc_' . $row->CD_ALU_DISC),
                            // 'cd_prova'=>$this->input->post('cd_prova'),
                            'cd_prova' => $v->CD_PROVA_VERSAO,
                            'cd_aluno' => $v->CD_ALUNO,
                            'cd_disciplina' => $v->CD_DISCIPLINA
                        );
                        $this->diario->ins_nota_discursiva($dados);
                    }
                }
            }

            //nota final
            $aluno = $row->CD_ALU_DISC;
            $nota = $this->input->get_post('nota_' . $row->CD_ALU_DISC . '');
            $this->diario->confirmar_nota($aluno, $this->input->get_post('tipo'), $nota, $this->input->get_post('turma'));
        }

        set_msg('msgok', 'Lançamento Efetuado com sucesso', 'sucesso');
        redirect('professor/nota/index', refresh);
    }

    function imprimir() {
//print_r($_POST);
        $file_name = 'Relatório de Lançamento de Notas';
//        $turma = $this->input->get_post('turma');
//        $numero_nota = $this->input->get_post('numero_nota');
//        $disciplina = $this->input->get_post('disciplina');
        $parametro = array(
            'cd_turma' => $this->input->get_post('turma'),
            'cd_disciplina' => $this->input->get_post('disciplina'),
            'cd_curso' => $this->input->get_post('curso'),
            'numero_nota' => $this->input->get_post('numero_nota'),
            'cd_professor' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
            'estrutura' => $this->input->get_post('estrutura'),
            'todos' => 'S'
        );
        //PARAMENTROS PARA CARREGA A LISTA DE TIPO DE NOTAS
        $string = strstr($this->input->get_post('turma'), '+');
        if ($string == '+') {
            $tipo_nota = array('operacao' => 'LTNM',
                'cd_estrutura' => $this->input->get_post('estrutura'));
        } else {
            $tipo_nota = array('operacao' => 'LN',
                'periodo' => $this->session->userdata('SCL_SSS_USU_PERIODO'),
                'cd_turma' => $this->input->get_post('turma'));
        }

        $data = array(
            'titulo' => '<h1> Diário de Classe <i class="icon-double-angle-right"></i> Lançamento de Notas</h1>',
            'navegacao' => ' Diário de Classe > Lançamento de Notas',
            'turma' => $parametro['cd_turma'], //$this->input->get_post('turma'),
            'cd_disciplina' => $this->input->get_post('disciplina'),
            'txtdisciplina' => $this->input->get_post('txtdisciplina'),
            'listar_tipo_nota' => $this->diario->sp_notas($tipo_nota),
            'numero_nota' => $this->input->get_post('numero_nota'),
            'listar_aluno' => $this->diario->listar_aluno($parametro)
        );
//print_r($data['listar_aluno']);exit;
        $html = $this->load->view('professor/nota/imprimir', $data, true);
        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    function add_arquivo() {
        if ($this->input->post('acao') == 'upload') {
//            print_r($_FILES);
//            print_r($_POST);
//            exit;
            if (isset($_FILES['arquivo'])) {
                $errors = array();
                foreach ($_FILES['arquivo']['tmp_name'] as $key => $tmp_name) {
                    $file_name = $key . $_FILES['arquivo']['name'][$key];
                    $arquivo = explode(".", $file_name);
                    $file_name = md5($arquivo[0]) . "." . end($arquivo);
                    //  $file_size =$_FILES['arquivo']['size'][$key];
                    $file_tmp = $_FILES['arquivo']['tmp_name'][$key];
                    //  $file_type=$_FILES['arquivo']['type'][$key];

                    $desired_dir = '' . $_SERVER['DOCUMENT_ROOT'] . '/portal/application/upload/nota/' . $this->input->post('cd_alu_disc');
                    if (empty($errors) == true) {
                        if (is_dir($desired_dir) == false) {
                            mkdir("$desired_dir", 0777);
                        }
                        if (move_uploaded_file($file_tmp, $desired_dir . "/" . $file_name)) {
                            $new_dir = $desired_dir . "/" . $file_name . time();
                            rename($file_tmp, $new_dir);
                            $paramentro = array('CD_ALU_DISC' => $this->input->post('cd_alu_disc'),
                                'NUM_NOTA' => $this->input->post('num_nota'),
                                'DS_ANEXO' => $file_name,
                                'CD_PROFESSOR' => $this->session->userdata('SCL_SSS_USU_PCODIGO'));
                            $this->diario->inserir_nota_arquivo($paramentro);
                        }
                    }
                }
                echo "<script>alert('Arquivo anexado com sucesso')</script>";
                echo "<script>javascript:history.back(-1)</script>";
            }
        } else {
            $data = array('cd_alu_disc' => $this->input->get('cd_alu_disc'),
                'num_nota' => $this->input->get('num_nota'),
                'lista' => $this->diario->lista_arquivo($this->input->get('cd_alu_disc'), $this->input->get('num_nota'))->result());

            $this->load->view('professor/nota/arquivo', $data);
        }
    }

    function excluir_arquivo() {
        if ($this->diario->deletar_arquivo($this->input->get('id')) == TRUE) {
            //set_msg('msg', 'Arquivo excluido com Sucesso.','sucesso');
            echo "<script>alert('Arquivo excluido com sucesso')</script>";
            echo "<script>javascript:history.back(-1)</script>";
        } else {
            //set_msg('msg', 'Erro ao excluir o Arquivo.','erro');
            echo "<script>alert('Erro ao excluir o Arquivo')</script>";
            echo "<script>javascript:history.back(-1)</script>";
        }
    }

    /**
     * Redireciona para tela que selecionará qual turma e disciplina deseja 
     * visualizar o resultado do semestre corrente.
     */
    function resultadoSemestre() {
        $professor = $this->session->userdata('SCL_SSS_USU_PCODIGO');
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');

        $data = array(
            'titulo' => '<h1> Diário de Classe <i class="fa fa-angle-double-right"></i> Resultado do Semestre</h1>',
            'turmas' => $this->turmaProfessor->listaTurmasRegular($professor, $periodo),
        );

        $this->load->view("professor/nota/resultado-semestre", $data);
    }

    /**
     * Retorna a view que gera a grid com o resultado do semestre.
     */
    function gridResultadoSemestre() {
        $periodo = $this->session->userdata('SCL_SSS_USU_PERIODO');
        $disciplina = $this->input->post("disciplina");
        $turma = $this->input->post("turma");

        $alunos = $this->notaAluno->listaMediaSemestre($turma, $disciplina, $periodo);

        $data = array(
            'alunos' => $alunos
        );

        $this->load->view("professor/nota/grid-resultado-semestre", $data);
    }

}
