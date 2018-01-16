<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Colegio extends CI_Controller {
	
    function __construct() {
         parent::__construct();
         $this->load->model('colegio/colegio_model','colegio',TRUE);
         $this->load->helper(array('form','url','html','funcoes'));
         $this->load->library(array('form_validation','session'));
    }
	
    // FORMULARIO DE CONTATO
    function contato(){
        $data['aluno'] = $this->colegio->contato();
        $this->load->view('colegio/contato', $data);
    }

    // RELAÇÃO DE CONTRATOS
    function gridview(){
        $this->load->view('contrato/index');
    }
  
    // RELAÇÃO DE CONTRATOS
    function aluno_tempo(){
            $turma = $this->session->userdata('SCL_SSS_USU_ID');
	if($this->input->get_post('aluno') != '') $aluno = $this->input->get_post('aluno');
            $data['tabela'] = $this->colegio->tempo_aula(0,$aluno);
        $html = $this->load->view('colegio/secretaria/tempo_aula', $data, true);
        include_once APPPATH.'/third_party/mpdf/mpdf.php';
        $mpdf=new mPDF();
        $mpdf->WriteHTML($html);
        $mpdf->Output();

    }
	
    // AGENDA ESCOLAR
    function agenda(){

        $turma = $this->session->userdata('SCL_SSS_USU_TURMA');
        if($this->input->get_post('turma') != '') $turma = $this->input->get_post('turma');
        $data['tabela'] = $this->colegio->tempo_aula(0,$turma);
        $html = $this->load->view('colegio/secretaria/tempo_aula', $data, true);


    }
    
    // LISTAR SERIES
    function curso_serie(){

        $parametro = array(
                        'operacao'=>'S', //MOSTRAR AS SÉRIES FILTRADAS PELOS CAMPOS
                        'curso'=>$this->input->get_post('curso'),
                        'serie'=>NULL,
                        'turma'=>NULL,
                        );		
        $serie = $this->colegio->sp_curso_serie_turma_aluno($parametro);
        $select = '<select name="serie" id="serie" class="form-control">
                      <option value="" selected="selected"> Informe a Série </option>';
        foreach($serie as $r){
                $select .= '<option value="'.$r['ORDEM_SERIE'].'">'.$r['NM_SERIE'].'</option>';	
        }
        $select .= '</select>';
        echo ($select);
    }
	
	// LISTAR TURMAS
	function serie_turma(){
		
		$parametro = array(
						  'operacao'=>'T', //MOSTRAR AS SÉRIES FILTRADAS PELOS CAMPOS
						  'curso'=>$this->input->get_post('curso'),
						  'serie'=>$this->input->get_post('serie'),
						  'turma'=>NULL,
						  );		
		$turma = $this->colegio->sp_curso_serie_turma_aluno($parametro);
		
		$select = '<option value=""></option>';
		foreach($turma as $r){
            if($r['TIPO'] == 'N'){    
			   $select .= '<option value="'.$r['CD_TURMA'].'">'.$r['CD_TURMA'].'</option>';		
             }else{
                $select .="";
             }  
		}

		echo ($select);
	}
	
	// LISTAR TURMAS
	function turma_aluno(){
		$parametro = array(
						  'operacao'=>'A', //MOSTRAR AS SÉRIES FILTRADAS PELOS CAMPOS
						  'curso'=>$this->input->get_post('curso'),
						  'serie'=>$this->input->get_post('serie'),
						  'turma'=>$this->input->get_post('turma'),
						  );		
		$turma = $this->colegio->sp_curso_serie_turma_aluno($parametro);
			
		$select = '<option value=""></option>';
		foreach($turma as $r){
			$select .= '<option value="'.$r['CD_ALUNO'].'">'.$r['NM_ALUNO'].'</option>';		
		}
		echo ($select);
	}
	
}