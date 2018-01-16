<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class Site_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    } 
    //FUNCOES DE NOTICIAS
    function sp_site_noticias($dados){
        $params = array(
                    array('name'=>':P_OPERACAO', 'value'=>$dados['operacao']),
                    array('name'=>':P_CD_NOTICIAS', 'value'=>$dados['cd_noticias']),
                    array('name'=>':P_AUTOR', 'value'=>$dados['autor']),
                    array('name'=>':P_IMAGEM', 'value'=>$dados['imagem']),
                    array('name'=>':P_TITULO', 'value'=>$dados['titulo']),
                    array('name'=>':P_DESCRICAO', 'value'=>$dados['descricao']),
                    array('name'=>':P_PUBLICADO', 'value'=>$dados['publicado']),
                    array('name'=>':P_DT_EVENTO', 'value'=>$this->input->oracle_data($dados['data'])),
                    array('name'=>':CURSOR', 'value'=>$cursor, 'type'=>OCI_B_CURSOR)
                );      
        return $this->db->sp_seculo('BD_SITE','SP_NOTICIA',$params);
        
    }
    
    //FUNCOES DE PARCEIROS
    function sp_site_parceiro($dados){
        $params = array(
                    array('name'=>':P_OPERACAO', 'value'=>$dados['operacao']),
                    array('name'=>':P_CD_PARCEIRO', 'value'=>$dados['cd_parceiro']),
                    array('name'=>':P_NOME', 'value'=>$dados['nome']),
                    array('name'=>':P_TITULO', 'value'=>$dados['titulo']),
                    array('name'=>':P_DESCRICAO', 'value'=>$dados['descricao']),
                    array('name'=>':P_BANNER', 'value'=>$dados['banner']),
                    array('name'=>':P_LOGO', 'value'=>$dados['logo']),
                    array('name'=>':P_CD_USUARIO', 'value'=>$dados['cd_usuario']),
                    array('name'=>':CURSOR', 'value'=>$cursor, 'type'=>OCI_B_CURSOR)
                );      
        return $this->db->sp_seculo('BD_SITE','SP_PARCEIRO',$params);
        
    }
    
    //FUNCOES DE PARCEIROS
    function sp_site_institucional($dados){
        $params = array(
                    array('name'=>':P_OPERACAO', 'value'=>$dados['operacao']),
                    array('name'=>':P_CD_INSTITUCIONAL', 'value'=>$dados['cd_institucional']),
                    array('name'=>':P_TITULO', 'value'=>$dados['titulo']),
                    array('name'=>':P_DESCRICAO', 'value'=>$dados['descricao']),
                    array('name'=>':P_BANNER', 'value'=>$dados['banner']),
                    array('name'=>':P_CADASTRADO', 'value'=>$dados['autor']),
                    array('name'=>':CURSOR', 'value'=>$cursor, 'type'=>OCI_B_CURSOR)
                );      
        return $this->db->sp_seculo('BD_SITE','SP_INSTITUCIONAL',$params);
        
    }
    
    //FUNCAO SP_INSTITUCIONAL
    function sp_site($dados){ 
        $params = array(
                    array('name'=>':P_OPERACAO', 'value'=>$dados['operacao']),
                    array('name'=>':P_CD_UNIFORME', 'value'=>$dados['cd_uniforme']),
                    array('name'=>':P_DESCRICAO', 'value'=>$dados['descricao']),
                    array('name'=>':P_BANNER', 'value'=>$dados['banner']),
                    array('name'=>':P_APRESENTACAO', 'value'=>$dados['apresentacao']),
                    array('name'=>':P_ENS_INFANTIL', 'value'=>$dados['ens_infantil']),
                    array('name'=>':P_ENS_FUNDAMENTAL', 'value'=>$dados['ens_fundamental']),
                    array('name'=>':P_ENS_MEDIO', 'value'=>$dados['ens_medio']),
                    array('name'=>':P_CURSOR', 'value'=>$cursor, 'type'=>OCI_B_CURSOR)
            );
        return $this->db->sp_seculo('BD_SITE','SP_SITE',$params);
    }
    
    
            
    function deletar_noticia($codigo){
        $img = "SELECT IMAGEM FROM BD_PROJETO.JOR_NOTICIAS WHERE CD_NOTICIAS = ".$codigo;
        $delimg = $this->db->query($img)->result();
        $sql = "DELETE FROM BD_PROJETO.JOR_NOTICIAS WHERE CD_NOTICIAS = ".$codigo;
        $query = $this->db->query($sql);  
        if($query == TRUE) {
            $sql2 = "DELETE FROM BD_PROJETO.JOR_IMAGEM WHERE CD_TIPO = ".$codigo." AND TIPO = 'N'";
            $query2 = $this->db->query($sql2);  
            if($query2 == TRUE) {
                $pasta = $_SERVER['DOCUMENT_ROOT'].'/seculo/application/upload/noticia/'.$codigo; 
                 if ($dd = opendir($pasta)) {
                    while (false !== ($Arq = readdir($dd))) {
                        if($Arq != "." && $Arq != ".."){
                            $Path = "$pasta/$Arq";
                            if(is_dir($Path)){
                                ExcluiDir($Path);
                            }elseif(is_file($Path)){
                                unlink($Path);
                            }
                        }
                    }
                    closedir($dd);
                }
                rmdir($pasta);
                $PathImg = $_SERVER['DOCUMENT_ROOT'].'/seculo/application/upload/noticia/'.$delimg[0]->IMAGEM;
               # echo $PathImg;exit;
                unlink($PathImg);
                return TRUE;  
            }else{
                return FALSE;
            }
        } else {
            return false;
        }  
    }
}