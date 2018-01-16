<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Visualizar extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file','funcoes'));
        $this->load->library(array('form_validation', 'session', 'upload'));
        $this->load->model('provas/correcao_model','correcao',TRUE);
    }

    function prova(){
        
//        $cd_prova = base64_decode($this->input->get('id'));
//
//        $data = array('titulo'=>'Lista de Provas', 
//                      'listar'=>$this->prova->visualiza_prova($cd_prova)->result()
//                     );
//        $this->load->view('provas/view_prova',$data);
        
        //$params = array('prova'=>308, 'aluno'=>14001349);
         $params = array(
            'prova' => $this->input->get_post('id'), 
            'aluno' => $this->input->get_post('aluno')
         );
       

        $data = array(
            'aluno' => $this->correcao->cabecalho($params),
            'listar' => $this->correcao->questoes($params)
        );
        
        foreach ($data['listar'] as $row) {
           $questoes .= $row['POSICAO'] . ') '.str_replace('<p>','',$row['DC_QUESTAO']).'<p/>';
        }

        include_once APPPATH . '/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF();
        $mpdf->list_indent_first_level = 0;
        $mpdf->max_colH_correction = 1.1;
        
        
        /* PÁGINA DE ROSTO :: INICIO */
        $mpdf->SetHTMLHeader($this->load->view('provas/imprimir/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', 
                '', 
                '', 
                '', 
                10, // margin_left
                10, // margin right
                30, // margin top
                30, // margin bottom
                 0, // margin header
                 5);// margin footer 
        $cabeca = $this->load->view('provas/imprimir/cabecalho', $data, TRUE);
        $mpdf->WriteHTML($cabeca); // cabeçalho
        $mpdf->SetHTMLFooter($this->load->view('provas/imprimir/footer', $data, true));
        /* PÁGINA DE ROSTO :: FINAL */
        
        
        $mpdf->SetHTMLHeader($this->load->view('provas/imprimir/header', $data, true));
        $mpdf->AddPage('P', // L - landscape, P - portrait
                'A4', 
                '', 
                '', 
                '', 
                10, // margin_left
                10, // margin right
                30, // margin top
                30, // margin bottom
                 0, // margin header
                 5);// margin footer 
        $mpdf->SetDisplayMode('fullpage');        
        $mpdf->SetHTMLFooter($this->load->view('provas/imprimir/footer', $data, true));
      //  echo $questoes;exit;
        $mpdf->SetColumns(2,'J');
	$mpdf->WriteHTML($questoes,2);
        
        $mpdf->Output();
        
    }
    
    
}

 