<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Infantil extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('professor/infantil_model', 'infantil', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file','funcoes'));
        $this->load->library(array('form_validation', 'session', 'upload'));
    }
    
    function acompanhamento() {
        //PARAMENTROS PARA CARREGAR A LISTA DE TURMAS DO PROFESSOR
        $paramento = array( 'operacao'=>'TI',
                            'periodo'=> $this->session->userdata('SCL_SSS_USU_PERIODO'),
                            'cd_professor'=>$this->session->userdata('SCL_SSS_USU_PCODIGO')
                           );   
        $data = array(
            'titulo' => '<h1> Apóio Pedagógico <i class="fa fa-angle-double-right"></i> Infantil <i class="fa fa-angle-double-right"></i> Acompanhamento</h1>',
            'codigo' => $this->session->userdata('SCL_SSS_USU_PCODIGO'),
            'turmas' => $this->infantil->sp_infantil($paramento)
        );
        
        $this->load->view('professor/infantil/acompanhamento', $data);
    }    
  
    function acomp_diario() {
        $paramento = array( 'operacao'=>'AT',
                            'periodo'=> $this->session->userdata('SCL_SSS_USU_PERIODO'),
                            'cd_turma'=>$this->input->get_post('turma')
                           ); 
        $data = array(
            'titulo' => '<h1> Apóio Pedagógico <i class="fa fa-angle-double-right"></i> Infantil  <i class="fa fa-angle-double-right"></i> Acompanhamento ' . date('d/m/Y') . '</h1>',
            'alunos' => $this->infantil->sp_infantil($paramento),
            'turma' => $this->input->get_post('turma')
        );

        $this->load->view('professor/infantil/diario', $data);
    }    
    function diario_lancar() {
        //PARAMENTROS PARA CARREGAR A LISTA DE TURMAS DO PROFESSOR
        $paramento = array( 'operacao'=>'AT',
                            'periodo'=> $this->session->userdata('SCL_SSS_USU_PERIODO'),
                            'cd_turma'=>$this->input->get_post('turma')
                           ); 
        $alunos = $this->infantil->sp_infantil($paramento);
        foreach ($alunos as $row) {
            $parametro['turma'] = $this->input->get_post('turma'); // turma
            $parametro['aluno'] = $row['CD_ALUNO']; // turma
            $parametro['colacao'] = $this->input->get_post('colacao' . $row['CD_ALUNO'] . ''); // colação
            $parametro['almoco'] = $this->input->get_post('almoco' . $row['CD_ALUNO'] . ''); // almoco
            $parametro['lanche'] = $this->input->get_post('lanche' . $row['CD_ALUNO'] . ''); // lanche
            $parametro['descanso'] = $this->input->get_post('descanso' . $row['CD_ALUNO'] . ''); // sono
            $parametro['evacuacao'] = $this->input->get_post('evacuacao' . $row['CD_ALUNO'] . ''); // evacuacao		
            $this->infantil->diario_lancar($parametro);
        }
        set_msg('msgok','Lançamento realizado com sucesso','sucesso');
        redirect('professor/infantil/acompanhamento');
    }
    
    function avaliacao_conceitual(){
        ///PARAMENTROS PARA CARREGAR TIPO DE NOTA
        $paramento = array('operacao'=>'LN'); 
        //PARAMENTROS PARA LISTA A TURMA DO PROFESSOR PARA AVALIAÇÃO CONCEITUAL
        $param = array('operacao'=>'LTC',
                       'periodo'=> $this->session->userdata('SCL_SSS_USU_PERIODO'),
                       'cd_professor'=>$this->session->userdata('SCL_SSS_USU_PCODIGO'));  
        $data = array(
            'titulo' => '<h1> Diário de Classe <i class="fa fa-angle-double-right"></i> Avaliação Conceitual</h1>',
            'tipo_nota' => $this->infantil->sp_infantil($paramento),
            'grade' => $this->infantil->sp_infantil($param)
        );
        $this->load->view('professor/questionario/index', $data);

    }
    
    function listar_turma(){
        $paramento = array( 'operacao'=>'LAT',
                            'periodo'=> $this->session->userdata('SCL_SSS_USU_PERIODO'),
                            'cd_turma'=>$this->input->get_post('turma')
                           );  
        $data = array(
            'titulo' => '<h1> Diário de Classe <i class="fa fa-angle-double-right"></i> Avaliação Conceitual <i class="fa fa-angle-double-right"></i> Relação de Alunos da Turma '.$this->input->get_post('turma').'</h1>',
            'alunos' => $this->infantil->sp_infantil($paramento)
        );

        $this->load->view('professor/questionario/alunos', $data);
    }
    
    function questionario(){
        
        
            $parametro = array(
                'operacao'=> 'LN',
                'aluno'=>base64_decode($this->input->get_post('token')),
                'questionario'=>$this->input->get_post('qs'),
                'bimestre'=> 4
            );
            
            $resp = array(
                'operacao'=> 'OPRES',
                'questionario'=>$this->input->get_post('qs'),
            );

            $data = array(
                'turma'=>$this->input->get_post('turma'),
                'titulo'=>'<h1> Diário de Classe <i class="fa fa-angle-double-right"></i> Avaliação Conceitual</h1>',
                //'quesstionario'=>$this->infantil->montar_questionario_view($parametro),
                'listar' =>  $this->infantil->questonario($parametro),
                'aluno'=>base64_decode($this->input->get_post('token')),
                'nome'=>base64_decode($this->input->get_post('tid')),
                'turma'=>base64_decode($this->input->get_post('t')),
                'questionario'=>$this->input->get_post('qs'),
                'resposta'=> (object)$this->infantil->questonario($resp),
                'bimestre'=>$this->input->get_post('bm')
            );
            $this->load->view('professor/questionario/questionario', $data);
    }
    
    function questionario_resposta(){
        $item = explode(':',$this->input->post('resposta'));
        $parametro = array(
                'questionario' =>$this->input->post('questionario'),
                'bimestre' =>$this->input->post('bimestre'),
                'aluno' =>$this->input->post('aluno'),
                'pergunta' =>$item[0],
                'resposta' =>$item[1],
        );

        $resultado = $this->infantil->resposta($parametro);
        echo $resultado;
    }

}