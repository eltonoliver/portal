<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nota extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('coordenacao/coordenador_model', 'coordenador', TRUE);
        $this->load->model('secretaria/secretaria_model', 'secretaria', TRUE);
        $this->load->model('colegio/colegio_model', 'colegio', TRUE);
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file','funcoes'));
        $this->load->library(array('form_validation', 'session', 'upload', 'tracert'));

    }
    
    function index(){
        $data = array(
            'titulo' => '<h1> Professor <i class="fa fa-angle-double-right"></i> Notas Lançadas</h1>'
        );
        $parametro = array(
                            'operacao'=>'C', //MOSTRAR OS CURSOS
                            'curso'=>NULL
                            );
        $data['curso'] = $this->coordenador->sp_curso_serie_turma_aluno($parametro);
        $this->load->view('coordenador/notas/notas_lancadas',$data);
    }
    
    function boletim() {
        
        $parametro = array('turma' => $this->input->get('turma'),
            'curso' => NULL,
            'serie' => NULL,
            'turma' => NULL,
            'tipo'=>0
        );
        $data['boletim'] = $this->secretaria->boletim($parametro);
        $this->load->view('coordenador/notas/boletim_turma', $data);
    }
    
    //PESQUISA AS TURMAS
    function pesquisar_turmas(){
	$parametro = array(
                        'operacao'=>'T', //MOSTRAR OS CURSOS
                        'curso'=>$this->input->post('curso'),
                        'serie'=>$this->input->post('serie')
                        );
        $turmas = $this->colegio->sp_curso_serie_turma_aluno($parametro);
    
        $resultado = '<div id="accordion" class="accordion-style1 panel-group">';
        foreach($turmas as $t){
        $resultado .= ' <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title">
                              <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#'.$t['CD_TURMA'].'">
                                <i class="bigger-110 icon-angle-right" data-icon-hide="icon-angle-down" data-icon-show="icon-angle-right"></i>'.
                                $t['CD_TURMA']
                              .'</a>
                            </h4>
                          </div>
                          <div style="height: 0px;" class="panel-collapse collapse" id="'.$t['CD_TURMA'].'">
                            <div class="panel-body">';
                            $param = array('operacao'=>'TP','turma'=>$t['CD_TURMA']);
                            $professor = $this->coordenador->sp_curso_serie_turma_aluno($param);
                            $resultado .= '<table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <th width="40%">Professor</th>
                                                <th width="40%">Disciplina</th>
                                                <th>%</th>
                                            </thead>
                                            <tbody>';
                                  foreach ($professor as $prof){
                                   $resultado .=   '<tr>
                                                        <td><a data-toggle="modal" href="#msg'.$t['CD_TURMA'].$prof['CD_DISCIPLINA'].'">'.$prof['NM_PROFESSOR'].'</a></td>
                                                        <td>'.$prof['NM_DISCIPLINA'].'</td>
                                                        <td>';
                                    
                                   //quandtidade de notas já lancadas
                                   $parame = array('operacao'=>'NP','turma'=>$t['CD_TURMA'],'disciplina'=>$prof['CD_DISCIPLINA']);
                                   $nota_lanc = $this->coordenador->sp_curso_serie_turma_aluno($parame);
                                #   print_r($nota_lanc);
                                   $tt_alunos = 0;
                                   $tt_notas = 0;
                                   foreach ($nota_lanc as $q){
                                       $tt_alunos += $q['TT_ALUNOS'];
                                       $tt_notas  += $q['TT_NOTAS'];
                                   }
                                   $porcento = (($tt_notas / $tt_alunos) * 100);
                                   
                                   if($porcento > 0 and $porcento <= 33){
                                       $resultado .= '<div class="progress progress-striped" data-percent="'.number_format($porcento,2).'%">';
                                       $resultado .= '<div class="progress-bar progress-bar-danger" style="width: '.$porcento.'%;"></div>';
                                   }
                                   if($porcento > 33 and $porcento <= 66){
                                       $resultado .= '<div class="progress progress-striped" data-percent="'.number_format($porcento,2).'%">';
                                       $resultado .= '<div class="progress-bar progress-bar-warning" style="width: '.$porcento.'%;"></div>';
                                   }
                                   if($porcento > 66){
                                       $resultado .= '<div class="progress progress-striped" data-percent="'.number_format($porcento,2).'%">';
                                       $resultado .= '<div class="progress-bar progress-bar-success" style="width: '.$porcento.'%;"></div>';
                                   }
                                   $resultado .= '</td>';
                                   $resultado .=   '</tr>';
                                   $resultado .= '<div class="modal fade" id="msg'.$t['CD_TURMA'].$prof['CD_DISCIPLINA'].'" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true"
                                                    data-remote="'.SCL_RAIZ.'coordenador/nota/boletim?turma='.$t['CD_TURMA'].'&cd_disciplina='.$prof['CD_DISCIPLINA'].'"> 
                                                   <div class="modal-dialog" style="width: 80%;">
                                                       <div class="modal-content">
                                                           '.modal_load.'
                                                       </div>
                                                   </div>
                                               </div>';
                                  }
                         $resultado .='</body></table>';
        
        $resultado .= '     </div>
                          </div>
                       </div>';
        }
        
        
        echo $resultado;        
        
    }
}