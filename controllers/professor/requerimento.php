<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Requerimento extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('professor/requerimento_model', 'requerimento', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file','funcoes'));
        $this->load->library(array('form_validation', 'session', 'upload'));

    }

    
    function index() {  
        $parametro = array('operacao' => 'LRP',
                            'cd_professor'=>$this->session->userdata('SCL_SSS_USU_PCODIGO'),
                            );
        $data = array(
            'titulo' => '<h1> Requerimentos <i class="fa fa-angle-double-right"></i> Lista</h1></h1>',
            'requerimento' => $this->requerimento->sp_requerimento_professor($parametro)
        );
      
        $this->load->view('professor/requerimento/lista', $data);
    }
    
    function novo(){
        $p_tipo = array('operacao'=>'LR');
        $p_turma = array( 'operacao'=>'LT','periodo'=> $this->session->userdata('SCL_SSS_USU_PERIODO'),'cd_professor'=>$this->session->userdata('SCL_SSS_USU_PCODIGO'));   
        $p_estrutura = array( 'operacao'=>'EN','periodo'=> $this->session->userdata('SCL_SSS_USU_PERIODO'));     
        $p_tipo_nota = array('operacao'=>'TN');
 
        $data = array('titulo' => '<h1> Requerimentos <i class="fa fa-angle-double-right"></i> Novo</h1></h1>',
                      'tipo' => $this->requerimento->sp_requerimento_professor($p_tipo),
                      'turmas'=>  $this->requerimento->sp_requerimento_professor($p_turma),
                      'estrutura' => $this->requerimento->sp_requerimento_professor($p_estrutura)
                       );
        $this->load->view('professor/requerimento/cadastrar',$data);
    }
    
    function lista_aluno(){ 

        $t = explode(";", $this->input->post('turma'));
        $turma = $t[0];
        $disciplina = $t[1];
        $curso = $t[2];
        $turno = $t[3];
        $b = explode(";", $this->input->post('bimentre'));
        $bimentre = $b[0];
        $nota = explode(";", $this->input->post('tipo_nota'));
        $parametro = array('operacao'=>'LA',
                           'periodo'=> $this->session->userdata('SCL_SSS_USU_PERIODO'),
                           'cd_turma'=>$turma,
                           'cd_disciplina'=>$disciplina,
                           'cd_professor'=>$this->session->userdata('SCL_SSS_USU_PCODIGO'),
                           'num_nota'=>$nota[1],//$this->input->post('tipo_nota'),
                           'cd_estrutura'=>$b[1],//$this->input->post('estrutura'),
                           'cd_tipo_req'=>$this->input->post('tipo'),
                           'bimestre'=>$bimentre,
                           'tipo_nota'=>$nota[0],
                           'cd_curso'=>$curso);
        $parametro1 = array('operacao'=>'MR');
        
        $data = array('alunos' => $this->requerimento->sp_requerimento_professor($parametro),
                      'tipo_req'=>  $this->input->post('tipo'),
                      'cd_tuma'=>$turma,
                      'cd_disciplina'=>$disciplina,
                      'cd_curso'=>$curso,
                      'turno'=>$turno,
                      'bimestre'=>$bimentre,
                      'tipo_nota'=>$this->input->post('tipo_nota'),
                      'motivo'=>$this->requerimento->sp_requerimento_professor($parametro1));
        
        echo $this->load->view('professor/requerimento/table_lista_aluno', $data, true);
    }
    
    function bimentre(){
        $parametro = array('operacao'=>'B','cd_estrutura'=>$this->input->post('estrutura'));
        $estrutura = $this->requerimento->sp_requerimento_professor($parametro);

        $select = '<select name="bimentre" id="bimentre" class="form-control">
                      <option value="" selected="selected"> Informe o Bimestre</option>';
        foreach($estrutura as $e){
                $select .= '<option value="'.$e['BIMESTRE'].';'.$e['CD_ESTRUTURA'].'">'.$e['BIMESTRE'].'º BIMESTRE</option>';	
        }
        $select .= '</select>';
        echo ($select);
    }
    
    function tiponota(){
        $a = explode(";", $this->input->post('tipo'));
        $parametro = array('operacao'=>'TN','bimestre'=>$a[0],'cd_estrutura'=>$a[1]);
        $tiponota = $this->requerimento->sp_requerimento_professor($parametro);
        $select = '<select name="tipo_nota" id="tipo_nota" class="form-control">
                      <option value="" selected="selected"> Informe o Tipo de Nota</option>';
        foreach($tiponota as $tn){
                $select .= '<option value="'.$tn['CD_TIPO_NOTA'].';'.$tn['NUM_NOTA'].'">'.$tn['DC_TIPO_NOTA'].'</option>';	
        }
        $select .= '</select>';
        echo ($select);
    }
    
    function obs_tipo(){
        $p_tipo = array('operacao'=>'LR','cd_tipo_req'=>  $this->input->post('tipo'));
        $obsnota = $this->requerimento->sp_requerimento_professor($p_tipo);
        echo $obsnota[0]['DESCRICAO'];
    }
    
    function estuturanota(){
        $a = explode(";", $this->input->post('est'));
        $parametro = array('operacao'=>'B','cd_estrutura'=>$a[4]);
        $estrutura = $this->requerimento->sp_requerimento_professor($parametro);

        $select = '<select name="bimentre" id="bimentre" class="form-control">
                      <option value="" selected="selected"> Informe o Bimestre</option>';
        foreach($estrutura as $e){
                $select .= '<option value="'.$e['BIMESTRE'].';'.$e['CD_ESTRUTURA'].'">'.$e['BIMESTRE'].'º BIMESTRE</option>';	
        }
        $select .= '</select>';
        echo ($select);
    }
    
    function lancar(){
        $param  = array( 'operacao'=>'IR',
                         'cd_tipo_req'=>$this->input->post('TIPO'),
                         'observacao'=>$this->input->post('obs'),
                         'cd_solicitante'=>$this->session->userdata('SCL_SSS_USU_PCODIGO'),
                         'periodo'=> $this->session->userdata('SCL_SSS_USU_PERIODO')
                       );
        $cd_requerimento = $this->requerimento->sp_requerimento_professor($param);
     
        if($cd_requerimento[0]['CD_REQUERIMENTO']){ 
            for ($i = 0; $i < count($this->input->post('motivo')); $i++) {
                $m = explode(";", $_POST['motivo'][$i]);
                    foreach ($this->input->post('CD_ALUNO') as $row) {  
                        if(isset($row)) {
                            $nota = explode(";", $this->input->post('TIPO_NOTA'));
                            if($m[1] == $row){
                            $param  = array( 'operacao'=>'IRC',
                                             'cd_aluno'=>$row,
                                             'observacao'=>$this->input->post('obs'),
                                             'cd_curso'=>$this->input->post('CD_CURSO'),
                                             'periodo'=> $this->session->userdata('SCL_SSS_USU_PERIODO'),
                                             'cd_turma' =>$this->input->post('CD_TURMA'),
                                             'bimestre' => $this->input->post('BIMESTRE'),
                                             'cd_disciplina' => $this->input->post('CD_DISCIPLINA'),
                                             'tipo_nota' =>$nota[0],//$this->input->post('TIPO_NOTA'),
                                             'num_nota'=>$nota[1],
                                             'turno' =>$this->input->post('TURNO'),
                                             'cd_requerimento'=>$cd_requerimento[0]['CD_REQUERIMENTO'],
                                             'cd_req_motivo'=>$m[0],
                                             'cd_professor'=>$this->session->userdata('SCL_SSS_USU_PCODIGO'),
                                             'nova_nota'=>  $_POST['NOTA_ALUNO'][$row]
                                           );

                                $this->requerimento->sp_requerimento_professor($param);
                            }
                        }
                    }
                
            }
        }     
        set_msg('msgok','Requerimento lançado com sucesso','sucesso');
        redirect(base_url('professor/requerimento/index'), 'refresh');   
    }
    
    function detalhes(){
        $param  = array( 'operacao'=>'LDR',
                         'cd_requerimento'=>$this->input->get('id')
                       );
        $data['lista'] = $this->requerimento->sp_requerimento_professor($param);
        $this->load->view('professor/requerimento/lista_detalhe',$data);
    }
}