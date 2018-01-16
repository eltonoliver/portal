<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class Noticia_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function sp_noticias($parametro) {  #print_r($parametro);exit;
        $cursor = '';
        $params = array(
            array('name' => ':OPERACAO', 'value' => $parametro['operacao']),
            array('name' => ':ID_NOTICIA', 'value' => $parametro['id_noticia']),
            array('name' => ':AUTOR', 'value' => $parametro['autor']),
            array('name' => ':TITULO', 'value' => $parametro['titulo']),
            array('name' => ':CHAMADA', 'value' => $parametro['chamada']),
            array('name' => ':STATUS', 'value' => $parametro['status']),
            array('name' => ':CORPO', 'value' => $parametro['corpo']),
            array('name' => ':POPUP', 'value' => $parametro['popup']),
            array('name' => ':TIPO', 'value' => $parametro['tipo']),
            array('name' => ':DT_INICIO', 'value' => (($parametro['inicio'] != '')? $parametro['inicio']: '') ),
            array('name' => ':DT_FIM', 'value' => (($parametro['fim'] != '')? $parametro['fim']: '') ),
            array('name' => ':RC1', 'value' => $cursor, 'type' => OCI_B_CURSOR)
        );
        //print_r($params);
        return $this->db->procedure('BD_PORTAL', 'AES_NOTICIA', $params);
    }
    
//    function grid() {
//		
//	$query = $this->db->query("SELECT ID_NOTICIA, AUTOR, TITULO, CHAMADA, STATUS, TO_CHAR(DT_PUBLICACAO,'DD/MM/YYYY') AS DT_PUBLICACAO, CORPO 
//               FROM BD_SICA.NOTICIAS ORDER BY ID_NOTICIA DESC");
//		
//	if($query->num_rows() > 0) {
//            return $query->result();
//        } else {
//            return false;
//        }
//    }
//	
//	function pesquisar($pesquisar) {
//            $query = $this->db->query("SELECT ID_NOTICIA, AUTOR, TITULO, CHAMADA, STATUS, TO_CHAR(DT_PUBLICACAO,'DD/MM/YYYY') AS DT_PUBLICACAO, CORPO 
//                                             FROM BD_SICA.NOTICIAS WHERE ID_NOTICIA = ".$pesquisar."");
//            if($query->num_rows() == 1) {
//                return $query->result();
//            } else {
//                return false;
//            }
//    }
//	
//	function inserir($parametro) { 
//	    $query = "INSERT INTO BD_SICA.NOTICIAS(AUTOR,TITULO,CHAMADA,STATUS,DT_INCLUSAO,DT_PUBLICACAO,CORPO) 
//                                      VALUES ('".$parametro[1]."','".$parametro[2]."','".$parametro[8]."',".$parametro[3].",SYSDATE,
//                                               TO_DATE('".$parametro[4]."','DD/MM/YYYY'),'".$parametro[5]."')";
//            $query = $this->db->query($query);          
//            if($query == TRUE) {
//                return TRUE;
//            } else {
//                return false;
//            }
//    }
//	
//	function editar($parametro) { 
//	  $query = "UPDATE BD_SICA.NOTICIAS
//                        SET AUTOR = '".$parametro[1]."',
//                        TITULO = '".$parametro[2]."',
//                        STATUS = ".$parametro[3].",
//                        DT_INCLUSAO =  TO_DATE('".$parametro[4]."','DD/MM/YYYY'),
//                        CORPO = '".$parametro[5]."'
//                        WHERE ID_NOTICIA = ".$parametro[7];
//           $query = $this->db->query($query);          
//           if($query == TRUE) {
//             return TRUE;
//           } else {
//             return false;
//           }
//    }
	
	function deletar($parametro) {
		$query = $this->db->query("DELETE FROM BD_SICA.NOTICIAS WHERE ID_NOTICIA = ".$parametro[7]."");
		if($query == true) {
            return true;
        } else {
            return false;
        }
    }
    
    function listaUltimasNoticias(){
            $query = $this->db->query("SELECT  ID_NOTICIA, AUTOR, TITULO, CHAMADA, STATUS, DT_PUBLICACAO, CORPO  FROM(
                                            SELECT ID_NOTICIA, AUTOR, TITULO, CHAMADA, STATUS, TO_CHAR(DT_PUBLICACAO,'DD/MM/YYYY') AS DT_PUBLICACAO, CORPO 
                                                 FROM BD_SICA.NOTICIAS
                                            ORDER BY ID_NOTICIA DESC
                                        )
                                        WHERE ROWNUM <= 10 ");
		
	if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function ver_foto(){
        $query = $this->db->query("select imagem from bd_projeto.jor_imagem where cd_imagem = 97");
        $query = $this->db->query("select alu_foto from bd_sica.aluno where rownum = 1");
        return $query->result();
        
    }
}
