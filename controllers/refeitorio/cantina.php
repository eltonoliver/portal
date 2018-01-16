<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Cantina extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file','funcoes'));
        $this->load->library(array('form_validation', 'session', 'upload'));
        $this->load->model('refeitorio/refeitorio_model','refeitorio',TRUE);
    }

    function trocar_produto(){
        
        $data = array('titulo'=>'Troca de Produtos Vendidos');
        $this->load->view('refeitorio/troca_venda',$data);
    }
    
    public function lista_venda(){
        $paramentro = array('cupom' => $this->input->post('cupom'));
        $cupom = $this->refeitorio->consulta_cupom($paramentro)->result();
        
        if(count($cupom) != 0){
            $data['cupom'] =  $cupom;
            echo $this->load->view('refeitorio/dados_cupom',$data,TRUE);
        }else{
            echo '<div class="alert alert-danger">
                        <button data-dismiss="alert" class="close" type="button"><i class="icon-remove"></i></button>
                        <strong><i class="icon-remove"></i>Cupom Não Localizado!</strong>
                        <br><br>
                        Cupom número: <strong>'.$this->input->post('cupom').'</strong> Não Localizado
                        <br>
                </div>';
        }
    }
    
    function confirma_troca(){
        $row = unserialize(urldecode($_GET['p']));
        
        $param = array('cd_almoxarifado'=>11,
                       'preco'=> str_replace(',','.',$row->PRECO_UNITARIO));
        $data = array('produtos'=>$this->refeitorio->consulta_produtos($param)->result(),
                      'estorno'=> $row);

        $this->load->view('refeitorio/conf_troca',$data);
    }
    
    function trocar(){
        
        if($_POST['qtde_origem'] < $_POST['qtde_troca']){
             set_msg('msgok','A Quantidade de torca não deve ser maior que a quantidade vendida<br>Troca não realizada','warning');
             redirect(base_url('refeitorio/cantina/trocar_produto'), 'refresh');
        }else{
            if($_POST['estorno'][10] == ""){
                $cd_uni_medida = $_POST['estorno'][9];
            }else{
               $cd_uni_medida = $_POST['estorno'][10]; 
            }

            $b = explode(";", $_POST['baixa']);

            if($b[3]==0){
                $uni_medida = $b[1];
            }else{
                $uni_medida = $b[3];
            }

            $dados = array('id_venda'=>$_POST['estorno'][0],
                           'material_origem'=>$_POST['estorno'][3],
                           'material_toca'=>$b[0],
                           'uni_medida_troca'=>$uni_medida,
                           'qtde_troca'=>$_POST['qtde_troca'],
                           'nr_ordem'=>$_POST['estorno'][1]);

            $ok = $this->refeitorio->inserir_historico($dados);
            
            if($ok == true){
                set_msg('msgok','Troca Efetuada com Sucesso','sucesso');
            }else{
                set_msg('msgok','Troca não realizada','erro');
            }
            redirect(base_url('refeitorio/cantina/trocar_produto'), 'refresh');
        }
        
        /*      $estorno = array('opcao'=>2,
                         'cd_almoxarifado'=>11,
                         'cd_material'=>$_POST['estorno'][3],
                         'qtde'=>$_POST['estorno'][5],
                         'unidade_medida'=>$cd_uni_medida,
                         'cd_ducumento'=>$_POST['estorno'][0],
                         'nro_documento'=>$_POST['estorno'][0],
                         'tipo_transacao'=>8
        );
        $rEstorno = $this->refeitorio->sp_baixa_estorno_cantina($estorno);
        $baixa = array('opcao'=>1,
                         'cd_almoxarifado'=>11,
                         'cd_material'=>$b[0],
                         'qtde'=>1,
                         'unidade_medida'=>$uni_medida,
                         'cd_ducumento'=>$_POST['estorno'][0],
                         'nro_documento'=>$_POST['estorno'][0],
                         'tipo_transacao'=>8
        );
        $rBaixa = $this->refeitorio->sp_baixa_estorno_cantina($baixa); */
    }
	
    
}