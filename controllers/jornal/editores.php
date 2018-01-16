<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Editores extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('jornal/jornal_model','jornal', TRUE);     
        $this->load->model('colegio/colegio_model','colegio',TRUE);		
        $this->load->library(array('form_validation','session','email','upload'));
        $this->load->helper(array('url','form','html','directory','file','funcoes'));
    }
    
    
    function index() {
        $data['titulo'] = 'Jornal <i class="fa fa-angle-double-right"></i> Editores do Jornal';
        $data['listar'] = $this->jornal->lista_editores();
        $this->load->view('jornal/editores',$data);
    }
    
    function cadastro_editor() {
        $parametro = array(
                            'operacao'=>'C', //MOSTRAR OS CURSOS
                            'curso'=>NULL
                            );
        $data['curso'] = $this->colegio->sp_curso_serie_turma_aluno($parametro);
        $data['funcionario'] = $this->jornal->usuarios_acesso();
        $data['titulo'] = 'Jornal <i class="fa fa-angle-double-right"></i> Cadastrar Editores';
        $this->load->view('jornal/cadastro_editor',$data);
    } 
    
    function lista_alunos(){
        $parametro = array(
                        'curso'=>$this->input->post('curso'),
                        'serie'=>$this->input->post('serie')
                        );
        $alunos = $this->jornal->alunos_por_tuma_serie($parametro);
        
        $resultado = '<div id="accordion" class="accordion-style1 panel-group">';
        $resultado .= ' <div class="panel panel-default">
                            <div class="panel-body">';
        $resultado .= '<form method="post" id="frmConfirmar" name="frmConfirmar" action="'.SCL_RAIZ.'jornal/editores/confirmar_editor">';
                            $resultado .= '<table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                             <thead>
                                               <th class="center" width="10%">Selecione</th>
                                               <th width="20%">Matricula</th>
                                               <th width="60%">Nome</th>
                                             </thead>
                                             <tbody>';
                                             foreach($alunos as $a){
                                                $resultado .=   '<tr>';
                                                $resultado .= '<td class="center"><input type="checkbox" name="selecionado[]" value="'.$a->CD_ALUNO.'"/></td>';
                                                $resultado .= '<td>'.$a->CD_ALUNO.'</td>';
                                                $resultado .= '<td>'.$a->NM_ALUNO.'</td>';
                                                $resultado .=   '</tr>';
                                            }
                         $resultado .='<tr><td colspan="3">
                                            <input type="submit" id="btn_pesquisar"  name="btn_pesquisar" class="btn btn-success" value="Confirmar"/>
                                            <input type="hidden" name="tipo" value="Aluno"/>
                                       </td></tr>';              
                         $resultado .='</body></table>';
        
        $resultado .= '     </div>
                          </div>
                       </div>';
        echo $resultado;    
    }
    
    function confirmar_editor(){
        
        $sel = $this->input->post('selecionado');
        for ($i = 0; $i < count($sel); $i++) {
           $query = $this->jornal->inserir_membros($sel[$i],$this->input->post('tipo'));          
        }
        if($query==TRUE){
            set_msg('msgok','Editor adicionado com sucesso.','sucesso');
        }else{
            set_msg('msgerro','Erro ao adicionar o editor','erro');
        }
        redirect(base_url('index.php/jornal/editores/'), 'refresh');
    }
    
    function excluir_editor(){
        $query = $this->jornal->excluir_membros($this->uri->segment(4)); 
        if($query==TRUE){
           set_msg('msgok','Editor excluido com sucesso','sucesso');
        }else{
           set_msg('msgerro','Erro ao excluir o editor.','erro');
        }
        redirect(base_url('jornal/editores/'), 'refresh');
    }
    
    function editor_html(){
        $data['titulo'] = 'EDITOR DE TEXTO';
        $this->load->view('jornal/editor',$data);
    }
    
}