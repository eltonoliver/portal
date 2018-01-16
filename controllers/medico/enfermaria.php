<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Enfermaria extends CI_Controller {
	
    function __construct() {
         parent::__construct();
         $this->load->model('secretaria/secretaria_model','secretaria',TRUE);
         $this->load->helper(array('form','url','html','funcoes'));
         $this->load->library(array('form_validation','session'));
    }
	
    // FORMULARIO DE CONTATO
    function ficha(){
        
        $data = array(
            'titulo' => '<h1> <i class="fa fa-medkit"></i> Módulo Médico <i class="fa fa-angle-double-right"></i> 
                              Enfermaria <i class="fa fa-angle-double-right"></i> 
                              Ficha do Aluno</h1>',
        );
        $this->load->view('medico/ficha/index', $data);
    }
    
    
}