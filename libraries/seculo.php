<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seculo{
    
    protected $CI;

    public function __construct(){
            $this->CI =& get_instance();
            $this->CI->load->helper('funcoes');
    }
    
//    public function enviar_email($para, $assunto, $mensagem, $formato='html'){
//        $this->CI->load->library('email');
//        $config['mailtype'] = $formato;
//        $this->CI->email->initialize($config);
//        $this->CI->email->from('davsonsantos@gmail.com', 'Administração do site');
//        $this->CI->email->to($para);
//        $this->CI->email->subject($assunto);
//        $this->CI->email->message($mensagem);
//        if ($this->CI->email->send()):
//            return TRUE;
//        else:
//            return $this->CI->email->print_debugger();
//        endif;
//    }
	
    
}

/* End of file sistema.php */
/* Location: ./application/labrarys/sistemas.php */