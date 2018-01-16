<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Biblioteca extends CI_Controller {
    function __construct() {
        parent::__construct();
	$this->load->model('colegio/biblioteca_model','biblio', TRUE);
        $this->load->helper(array('form','url','html','funcoes'));
	$this->load->library(array('form_validation','session','pagination'));
    }
    
    
	
	// FORMULARIO DE CONTATO
	public function index(){            
            $data['autor']  = $this->biblio->autor();
            $data['tipo']   = $this->biblio->tipo_item();
            $data['titulo'] = 'Biblioteca online <i class="fa fa-angle-double-right"> Reserva</i>';            
            $config = $this->biblio->configuracoes($this->session->userdata['SCL_SSS_USU_TIPO']);            
            $data['lista_emp'] = $this->biblio->lista_emprestimo();                        
            $this->load->view('colegio/biblioteca/index',$data);

	}
        
        //pagaina de reserva de livro
        public function reservar(){
            $data['autor']  = $this->biblio->autor();
            $data['tipo']   = $this->biblio->tipo_item();
            $data['titulo'] = 'Biblioteca online <small> <i class="fa fa-angle-double-right"></i>  </small>';
            $data['livro'] = $this->biblio->dados_livro($this->input->get('mfn'));
            $config = $this->biblio->configuracoes($this->session->userdata['SCL_SSS_USU_PERFIL']);
            //data de validade da reserva
            $data['dias'] = $this->session->_calcular_dias(1,$config->DIAS_RESERVAS);
            $dia= $data['dias'];
            $diaa=substr($dia,0,2)."/";
            $mes=substr($dia,3,2)."/";
            $ano=substr($dia,6,4);
            $dataInvalida = @date("w", mktime(0,0,0,$mes,$diaa,$ano) );
            $dataReserva = $dia;
            //varifica se a data cai no sabado
            if($dataInvalida == 6){
               $dataReserva = $this->session->_calcular_dias(2,2,str_replace("/","-",$dia));;
            }
            //verifico se cai no domingo
            if($dataInvalida == 0){
               $dataReserva = $this->session->_calcular_dias(2,1,str_replace("/","-",$dia));;
            }
            //verifico se o usuario ja reservou o livro e estar valido e estar no limite de reserva
            $data['max_reserva'] = $config->MAX_RESERVAS;
            $data['reserva'] = $this->biblio->usuario_ja_tem_reserva($this->input->get('mfn'));
            $data['reserva_ativa'] = $this->biblio->reservas_ativas($this->session->userdata['SCL_SSS_USU_CODIGO']);
            $data['dias'] = $dataReserva;
     
            $this->load->view('colegio/biblioteca/reservar',$data);

	}
	
	// GRID SELECT DE AUTOR
	public function autor(){
		
		$autor = $this->biblio->autor();
		if($autor != 0){
			echo '<ul class="ui-autocomplete ui-front ui-menu" style="width:50%">';
			foreach($autor as $item){
				echo '<li class="ui-menu-item" id="autocomplete_'.$item->PRE_SOBRE.'" rel="'.$item->PRE_SOBRE.'"><a>'.$item->PRE_SOBRE.'</a></li>';
			}
			echo '</ul>';
		}
	}
	
	// GRID SELECT DE AUTOR
	public function gridautor(){
		$config = $this->biblio->configuracoes();                
                $paramentro = array('autor' => $this->input->post('autor'),'livro' => $this->input->post('livro'));
		$autor = $this->biblio->grid($paramentro);
		if($autor != 0){
                    echo '<div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Lista de Livros</h3>
                                </div>
                                <div class="panel-body">
                                    <p>Resultado da Busca.</p>
                                    <hr>
                                    <div class="row">';
                   foreach($autor as $item){
                       echo '<div class="col-xs-6 col-md-3">
                               <div class="thumbnail"><img alt="Sample thumbnail 1" src="'.SCL_IMG.'simbolo.png">
                                 <div class="caption">
                                   <p class="text-info">'.substr($item->TITULO,0,25).'</p>
                                   <p>'.substr($item->AUTOR,0,25).'</p>';
                        if($config->LIBERA_EMPRESTIMO == 0){
                            if($item->PODE_EMPRESTAR == 'S' and $item->QTD_ATIVOS_PARA_EMPRESTIMO > 1){
                                echo '<p> <span class="label label-success label-sm"> DISPONÍVEL</span> </p>';
                                echo '<p> <a class="btn btn-primary" href="'.SCL_RAIZ.'colegio/biblioteca/reservar?mfn='.$item->MFN.'">Reservar</a> </p>';
                            }else{
                               echo '<p> <span class="label label-danger label-sm"> INDISPONÍVEL</span> </p>';
                               echo '<p> <button class="btn btn-default" disabled href="#">Reservar</a> </button>';
                            }
                        }
                       echo '      
                                 </div>
                               </div>
                             </div>';
                       
                   }
                   echo '</div></div></div>';
		}else{
                    echo '<div class="alert alert-danger">
                                <button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>
                                <strong><i class="icon-remove"></i>Livro Não Encontrado!</strong>
                                <br><br>
                                Você estar pesquisando com os seguintes valores: <br>Autor:'.$this->input->post('autor').'<br> Livro:'.$this->input->post('livro').'
                                <br>
                        </div>';
                }
	}
        
        function inserir_reserva(){ 
            $dados = array('COD_USUARIO' => $this->session->userdata['SCL_SSS_USU_CODIGO'],
                           'DT_RESERVA'  => $this->input->get('dt'),
                           'MFN'         => $this->input->get('mfn'));
            
            $dados['retorno'] = $this->biblio->inserirReserva($dados);
            $this->load->view('colegio/biblioteca/confirmar',$dados);
        }
        
        function renovar_livro(){ 
            $config = $this->biblio->configuracoes($this->session->userdata['SCL_SSS_USU_PERFIL']);
            //data de validade da reserva
            $data['dias'] = $this->session->_calcular_dias(2,$config->DIAS_RENOVACAO,str_replace("/","-",$_POST['dt_devolucao']));
            $dia= $data['dias'];
            $diaa=substr($dia,0,2)."/";
            $mes=substr($dia,3,2)."/";
            $ano=substr($dia,6,4);
            $dataInvalida = @date("w", mktime(0,0,0,$mes,$diaa,$ano) );
            $dataReserva = $dia;
            //varifica se a data cai no sabado
            if($dataInvalida == 6){
               $dataReserva = $this->session->_calcular_dias(2,2,str_replace("/","-",$dia));;
            }
            //verifico se cai no domingo
            if($dataInvalida == 0){
               $dataReserva = $this->session->_calcular_dias(2,1,str_replace("/","-",$dia));;
            }
            
            
            $dados = array('CD_EMPRESTIMO' => $_POST['cd_emprestimo'],
                           'DT_DEVOLUCAO'  => $dataReserva);
            $reserva = $this->biblio->atualizarDados($dados);
            
            if($reserva == TRUE){
              echo '<span class="label label-success arrowed arrowed-right">Renovado</span>';
            }else{
              echo '<span class="label label-danger arrowed arrowed-right">Erro no registro</span>';  
            }
        }
	
}