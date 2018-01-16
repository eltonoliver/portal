<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
  
class Jornal_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    
    function lista_categoria_artigo(){
        $sql = "SELECT CD_CATEGORIA,DC_CATEGORIA, TIPO,
                CASE WHEN TIPO = 'N' THEN 'NOTICIAS'
                     WHEN TIPO = 'A' THEN 'ARTIGOS'
                ELSE 'TIPO NÃO DEFINIDO'
                END AS DC_TIPO
                 FROM BD_PROJETO.JOR_CATEGORIA
                WHERE TIPO = 'A'";
        $query = $this->db->query($sql)->result();     
        return $query;
    }
    
    
    function deletar_artigo($codigo){
        $img = "SELECT IMAGEM FROM BD_PROJETO.JOR_ARTIGOS WHERE CD_ARTIGO = ".$codigo;
        $delimg = $this->db->query($img)->result();
        $sql = "DELETE FROM BD_PROJETO.JOR_ARTIGOS WHERE CD_ARTIGO = ".$codigo;
        $query = $this->db->query($sql);  
        if($query == TRUE) {
            $sql2 = "DELETE FROM BD_PROJETO.JOR_IMAGEM WHERE CD_TIPO = ".$codigo." AND TIPO = 'A'";
            $query2 = $this->db->query($sql2);  
            if($query2 == TRUE) {
                $pasta = $_SERVER['DOCUMENT_ROOT'].'/seculo/application/upload/artigo/'.$codigo; 
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
                $PathImg = $_SERVER['DOCUMENT_ROOT'].'/seculo/application/upload/artigo/'.$delimg[0]->IMAGEM;
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
    
    function insert_imagem($imagem,$codigo,$tipo){
        if($tipo == 'A'){
            $sql = "INSERT INTO BD_PROJETO.JOR_IMAGEM(TIPO,CD_TIPO,IMAGEM)
                    VALUES('A',".$codigo.",'".$imagem."')";
        }else{
            $sql = "INSERT INTO BD_PROJETO.JOR_IMAGEM(TIPO,CD_TIPO,IMAGEM)
                    VALUES('N',".$codigo.",'".$imagem."')";
        }
        $query = $this->db->query($sql);  
        if($query == TRUE) {
            return TRUE;    
        } else {
            return false;
        }
    }
    
    function lista_imagem_artigo($codigo){
        $sql = "SELECT * FROM BD_PROJETO.JOR_IMAGEM WHERE TIPO = 'A' AND CD_TIPO = ".$codigo;
        return $this->db->query($sql)->result();    
    }
    
    function sp_artigo($dados){
       # print_r($dados);exit;
        $OPERACAO = $dados['operacao'];
        $CD_ARTIGO = $dados['cd_artigo'];
        $CD_CATEGORIA = $dados['categoria'];
        $CD_MEMBRO = $dados['membro'];
        $IMAGEM = $dados['capa'];
        $TITULO = $dados['titulo'];
        $DESCRICAO = $dados['descricao'];
        $PUBLICADO = $dados['publicado'];
        $DT_EVENTO = $this->input->oracle_data($dados['data']);

        $params = array(
                        array('name'=>':P_OPERACAO', 'value'=>$OPERACAO),
                        array('name'=>':P_CD_ARTIGO', 'value'=>$CD_ARTIGO),
                        array('name'=>':P_CD_CATEGORIA', 'value'=>$CD_CATEGORIA),
                        array('name'=>':P_CD_MEMBRO', 'value'=>$CD_MEMBRO),
                        array('name'=>':P_IMAGEM', 'value'=>$IMAGEM),
                        array('name'=>':P_TITULO', 'value'=>$TITULO),
                        array('name'=>':P_DESCRICAO', 'value'=>$DESCRICAO),
                        array('name'=>':P_PUBLICADO', 'value'=>$PUBLICADO),
                        array('name'=>':P_DT_EVENTO', 'value'=>$DT_EVENTO),
                        array('name'=>':RC1', 'value'=>$cursor, 'type'=>OCI_B_CURSOR)
                ); 
        return $this->db->sp_seculo('BD_PROJETO','SP_INS_UPD_DEL_ARTIGO',$params);
    }
    
    function execultar_sp_artigo($dados){  
        
        switch ($dados['operacao']) {
            case 'L':
                $paramentro['operacao'] = $dados['operacao'];
                $paramentro['cd_artigo'] = null;
                $paramentro['categoria'] = null;
                $paramentro['membro'] = null;
                $paramentro['capa'] = null;
                $paramentro['titulo'] = null;
                $paramentro['descricao'] = null;
                $paramentro['publicado'] = null;
                $dados['data'] = null;
                break;
            case 'C':
                $paramentro['operacao'] = $dados['operacao'];
                $paramentro['cd_artigo'] = $dados['cd_artigo'];
                $paramentro['categoria'] = null;
                $paramentro['membro'] = null;
                $paramentro['capa'] = null;
                $paramentro['titulo'] = null;
                $paramentro['descricao'] = null;
                $paramentro['publicado'] = null;
                $dados['data'] = null;
                break;
            case 'I': 
                $paramentro['operacao'] = $dados['operacao'];
                $paramentro['cd_artigo'] = null;
                $paramentro['categoria'] = $dados['categoria'];
                $paramentro['membro'] = $dados['autor'];
                $paramentro['capa'] = $dados['capa'];
                $paramentro['titulo'] = $dados['titulo'];
                $paramentro['descricao'] = $dados['texto'];
                $paramentro['publicado'] = $dados['publicado'];
                $dados['data'] = date('d/m/Y');
                break;
            case 'U':
                $paramentro['operacao'] = $dados['operacao'];
                $paramentro['cd_artigo'] = $dados['codigo'];
                $paramentro['categoria'] = $dados['categoria'];
                $paramentro['membro'] = $dados['autor'];
                $paramentro['capa'] = $dados['capa'];
                $paramentro['titulo'] = $dados['titulo'];
                $paramentro['descricao'] = $dados['texto'];
                $paramentro['publicado'] = $dados['publicado'];
                $dados['data'] = date('d/m/Y');
                break;
            default:
                
                break;
        }
        $spartigo = $this->sp_artigo($paramentro); 
        return($spartigo);
    }
    
    
//FUNCOES DE NOTICIAS
    function sp_noticias($dados){ 
        $OPERACAO = $dados['operacao'];
        $CD_NOTICIA = $dados['cd_noticia'];
        $CD_CATEGORIA = $dados['categoria'];
        $CD_MEMBRO = $dados['membro'];
        $IMAGEM = $dados['capa'];
        $TITULO = $dados['titulo'];
        $DESCRICAO = $dados['descricao'];
        $PUBLICADO = $dados['publicado'];
        $DT_EVENTO = $this->input->oracle_data($dados['data']); #date('d-M-y',strtotime(implode("-",array_reverse(explode("/",$dados['data'])))));;

        $params = array(
                        array('name'=>':P_OPERACAO', 'value'=>$OPERACAO),
                        array('name'=>':P_CD_NOTICIA', 'value'=>$CD_NOTICIA),
                        array('name'=>':P_CD_CATEGORIA', 'value'=>$CD_CATEGORIA),
                        array('name'=>':P_CD_MEMBRO', 'value'=>$CD_MEMBRO),
                        array('name'=>':P_IMAGEM', 'value'=>$IMAGEM),
                        array('name'=>':P_TITULO', 'value'=>$TITULO),
                        array('name'=>':P_DESCRICAO', 'value'=>$DESCRICAO),
                        array('name'=>':P_PUBLICADO', 'value'=>$PUBLICADO),
                        array('name'=>':P_DT_EVENTO', 'value'=>$DT_EVENTO),
                        array('name'=>':RC1', 'value'=>$cursor, 'type'=>OCI_B_CURSOR)
                );      
     
        return $this->db->sp_seculo('BD_PROJETO','SP_INS_UPD_DEL_NOTICIA',$params);
        
    }
    
    function execultar_sp_noticias($dados){  
        //verifico qual a operacao
        switch ($dados['operacao']) {
            case 'L':
                $paramentro['operacao'] = $dados['operacao'];
                $paramentro['cd_noticia'] = null;
                $paramentro['categoria'] = null;
                $paramentro['membro'] = null;
                $paramentro['capa'] = null;
                $paramentro['titulo'] = null;
                $paramentro['descricao'] = null;
                $paramentro['publicado'] = null;
                $dados['data'] = null;
                break;
            case 'C':
                $paramentro['operacao'] = $dados['operacao'];
                $paramentro['cd_noticia'] = $dados['cd_noticia'];
                $paramentro['categoria'] = null;
                $paramentro['membro'] = null;
                $paramentro['capa'] = null;
                $paramentro['titulo'] = null;
                $paramentro['descricao'] = null;
                $paramentro['publicado'] = null;
                $dados['data'] = null;
                break;
            case 'I': 
                $paramentro['operacao'] = $dados['operacao'];
                $paramentro['cd_noticia'] = null;
                $paramentro['categoria'] = $dados['categoria'];
                $paramentro['membro'] = $dados['autor'];
                $paramentro['capa'] = $dados['capa'];
                $paramentro['titulo'] = $dados['titulo'];
                $paramentro['descricao'] = $dados['texto'];
                $paramentro['publicado'] = $dados['publicado'];
                $dados['data'] = date('d/m/Y');
                break;
            case 'U':
                $paramentro['operacao'] = $dados['operacao'];
                $paramentro['cd_noticia'] = $dados['codigo'];
                $paramentro['categoria'] = $dados['categoria'];
                $paramentro['membro'] = $dados['autor'];
                $paramentro['capa'] = $dados['capa'];
                $paramentro['titulo'] = $dados['titulo'];
                $paramentro['descricao'] = $dados['texto'];
                $paramentro['publicado'] = $dados['publicado'];
                $dados['data'] = date('d/m/Y');
                break;
            case 'D':
                $paramentro['operacao'] = $dados['operacao'];
                $paramentro['cd_noticia'] = $dados['codigo'];
                $paramentro['categoria'] = null;
                $paramentro['membro'] = null;
                $paramentro['capa'] = null;
                $paramentro['titulo'] = null;
                $paramentro['descricao'] = null;
                $paramentro['publicado'] = null;
                $dados['data'] = null;
                break;

            default:
                break;
        }
        
        $spnoticias = $this->sp_noticias($paramentro); 
        return($spnoticias);
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
    
    function lista_categoria_noticia(){
        $sql = "SELECT CD_CATEGORIA,DC_CATEGORIA, TIPO,
                CASE WHEN TIPO = 'N' THEN 'NOTICIAS'
                     WHEN TIPO = 'A' THEN 'ARTIGOS'
                ELSE 'TIPO NÃO DEFINIDO'
                END AS DC_TIPO
                 FROM BD_PROJETO.JOR_CATEGORIA
                WHERE TIPO = 'N'";
        $query = $this->db->query($sql)->result();     
        return $query;
    }
    
    function lista_imagem_noticia($codigo){
        $sql = "SELECT * FROM BD_PROJETO.JOR_IMAGEM WHERE TIPO = 'N' AND CD_TIPO = ".$codigo;
        return $this->db->query($sql)->result();    
    }
//fim da funcoes do noticias
    
/*editores*/
    function lista_editores(){
        $sql = "SELECT DISTINCT X.CD_MEMBRO,X.DC_MEMBRO, X.EDITOR FROM(
                    SELECT M.CD_MEMBRO,M.DC_MEMBRO, U.NM_USUARIO AS EDITOR FROM BD_PROJETO.JOR_MEMBRO M
                    INNER JOIN BD_SICA.USUARIOS U ON U.CD_USUARIO = M.CD_MEMBRO 
                    UNION
                    SELECT M.CD_MEMBRO,M.DC_MEMBRO, A.NM_ALUNO AS EDITOR FROM BD_PROJETO.JOR_MEMBRO M
                    INNER JOIN BD_SICA.ALUNO A ON CD_ALUNO = CD_MEMBRO
                )X";
        return $this->db->query($sql)->result();
    }
    function alunos_por_tuma_serie($param){
        $sql = "SELECT CD_ALUNO, NM_ALUNO FROM BD_SICA.ALUNO WHERE CD_CURSO = ".$param['curso']." AND ORDEM_SERIE = ".$param['serie']."
                AND CD_ALUNO NOT IN (SELECT CD_MEMBRO FROM BD_PROJETO.JOR_MEMBRO) ORDER BY NM_ALUNO";
        return $this->db->query($sql)->result();
    }
    
    function usuarios_acesso(){
        $sql = "SELECT CD_USUARIO, NM_USUARIO, FUNCAO FROM BD_SICA.USUARIOS
                 WHERE ATIVO = 1 AND DT_EXPIRACAO IS NULL AND NM_USUARIO IS NOT NULL AND FUNCAO IS NOT NULL
                 AND CD_USUARIO NOT IN (SELECT CD_MEMBRO FROM BD_PROJETO.JOR_MEMBRO)
                ORDER BY NM_USUARIO";
        return $this->db->query($sql)->result();
    }
    
    function inserir_membros($cd_membro,$tipo){
        $sql = "INSERT INTO BD_PROJETO.JOR_MEMBRO(CD_MEMBRO,DC_MEMBRO,ACESSO)VALUES('".$cd_membro."','".$tipo."',1)";
        
        $query = $this->db->query($sql);          
        if($query == TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    function excluir_membros($cd_membro){
        $sql = "DELETE BD_PROJETO.JOR_MEMBRO WHERE CD_MEMBRO = '".$cd_membro."'";
        $query = $this->db->query($sql);          
        if($query == TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    function lista_autores(){
        $sql = "SELECT M.CD_MEMBRO, U.NM_USUARIO AS NOME FROM BD_PROJETO.JOR_MEMBRO M
                    JOIN BD_SICA.USUARIOS U ON U.CD_USUARIO = M.CD_MEMBRO
                   UNION
                   SELECT M.CD_MEMBRO, A.NM_ALUNO AS NOME FROM BD_PROJETO.JOR_MEMBRO M
                     JOIN BD_SICA.ALUNO A ON A.CD_ALUNO = M.CD_MEMBRO"; 
        return $this->db->query($sql)->result();
    }
    
    
    
    
    /*******funcoes do novo jornal*******/
    //data: 13/10/2014
    //por: Davson Santos
    /***********************************/
    function lista_caderno(){
        $sql = "SELECT * FROM BD_PROJETO.JOR_CADERNO WHERE DT_EXCLUSAO IS NULL";
        return $this->db->query($sql);
    }
    
    public function inserir_caderno($dados=NULL){ 
        if ($dados != NULL){
            $sql = "INSERT INTO BD_PROJETO.JOR_CADERNO(DESCRICAO, DT_CADASTRO, USER_CADASTRO)
                    VALUES('".$dados['DESCRICAO']."',SYSDATE,".$dados['USER_CADASTRO'].")";

            $query = $this->db->query($sql);          
            if($query == TRUE){
                return TRUE;
            }else{
                return FALSE;
            }
        }
    }
    
    public function consulta_caderno($dados=NULL){ 
        if ($dados != NULL){
            $sql = "SELECT * FROM BD_PROJETO.JOR_CADERNO WHERE CD_CADERNO = ".$dados." ";
            return $this->db->query($sql);
        }
    }
    
    public function editar_caderno($dados=NULL){ 
        if ($dados != NULL){
            $sql = "UPDATE BD_PROJETO.JOR_CADERNO SET DESCRICAO = '".$dados['DESCRICAO']."' WHERE CD_CADERNO = ".$dados['CD_CADERNO'];
         
            $query = $this->db->query($sql);          
            if($query == TRUE){
                return TRUE;
            }else{
                return FALSE;
            }
        }
    }
    
    public function excluir_caderno($dados=NULL){ 
        if ($dados != NULL){
            $sql = "UPDATE BD_PROJETO.JOR_CADERNO SET DT_EXCLUSAO = SYSDATE, USER_EXCLUSAO = ".$dados['USER_EXCLUSAO']."
                    WHERE CD_CADERNO = ".$dados['CD_CADERNO'];
            $query = $this->db->query($sql);          
            if($query == TRUE){
                return TRUE;
            }else{
                return FALSE;
            }
        }
    }
    
    function inserir_categoria($dados=NULL){
        if($dados != NULL){
            $sql = "INSERT INTO BD_PROJETO.JOR_CATEGORIA (DC_CATEGORIA,CD_CADERNO)
                    VALUES (UPPER('".$dados['CATEGORIA']."'),".$dados['CD_CADERNO'].")";
            #ECHO $sql;exit;
            $query = $this->db->query($sql);          
             if($query == TRUE) {
                 return TRUE;
             } else {
                 return false;
             }
        }
    }
    
    function lista_categoria(){
        $sql = "SELECT CT.CD_CATEGORIA,CT.DC_CATEGORIA, CA.DESCRICAO
                FROM BD_PROJETO.JOR_CATEGORIA CT
              LEFT JOIN BD_PROJETO.JOR_CADERNO CA ON CA.CD_CADERNO = CT.CD_CADERNO";
        $query = $this->db->query($sql)->result();     
        return $query;
    }
    
    function pesquisar_categoria($codigo) {
        $sql = "SELECT * FROM BD_PROJETO.JOR_CATEGORIA WHERE CD_CATEGORIA = ".$codigo;
        $query = $this->db->query($sql);     
        return $query;
    }
    
    function editar_categoria($parametro){
        $sql = "UPDATE BD_PROJETO.JOR_CATEGORIA SET DC_CATEGORIA = UPPER('".$parametro['CATEGORIA']."'), 
                 CD_CADERNO = ".$parametro['CD_CADERNO']." WHERE CD_CATEGORIA = ".$parametro['CODIGO'];
       # echo $sql;exit;
        $query = $this->db->query($sql);          
        if($query == TRUE) {
            return TRUE;
        } else {
            return false;
        }
    }
     
    function deletar_categoria($codigo){
        $sql = "DELETE FROM BD_PROJETO.JOR_CATEGORIA WHERE CD_CATEGORIA = ".$codigo['CD_CATEGORIA'];  
        $query = $this->db->query($sql);          
        if($query == TRUE) {
            return TRUE;
        } else {
            return false;
        }
    }
    
    function lista_categoria_caderno(){
        $sql = "SELECT CT.CD_CATEGORIA, CT.DC_CATEGORIA,
                         CA.DESCRICAO AS CADERNO FROM BD_PROJETO.JOR_CATEGORIA CT
                 INNER JOIN BD_PROJETO.JOR_CADERNO CA ON CA.CD_CADERNO = CT.CD_CADERNO";
        return $this->db->query($sql);
    }
    
    function execultar_sp_news($dados){  #print_r($dados);
        //verifico qual a operacao
        switch ($dados['OPERACAO']) {
            case 'L':
                $paramentro['OPERACAO'] = $dados['OPERACAO'];
                $paramentro['CD_NEWS'] = null;
                $paramentro['CD_CATEGORIA'] = null;
                $paramentro['CD_AUTOR'] = null;
                $paramentro['TITULO'] = null;
                $paramentro['RESUMO'] = null;
                $paramentro['IMG_CAPA'] = null;
                $paramentro['DESCRICAO'] = null;
                $paramentro['THUMB'] = null;
                $paramentro['DT_EVENTO'] = null;
                $paramentro['PUBLICADO'] = null;
                break;
            case 'I':
                $paramentro['OPERACAO'] = $dados['OPERACAO'];
                $paramentro['CD_NEWS'] = null;
                $paramentro['CD_CATEGORIA'] = $dados['CD_CATEGORIA'];
                $paramentro['CD_AUTOR'] = $dados['CD_AUTOR'];
                $paramentro['TITULO'] = $dados['TITULO'];
                $paramentro['RESUMO'] = $dados['RESUMO'];
                $paramentro['IMG_CAPA'] = $dados['IMG_CAPA'];
                $paramentro['DESCRICAO'] = $dados['DESCRICAO'];
                $paramentro['THUMB'] = $dados['THUMB'];
                $paramentro['DT_EVENTO'] = $dados['DT_EVENTO'];
                $paramentro['PUBLICADO'] = $dados['PUBLICADO'];
                break;
             case 'C':
                $paramentro['OPERACAO'] = $dados['OPERACAO'];
                $paramentro['CD_NEWS'] = $dados['CD_NEWS'];
                $paramentro['CD_CATEGORIA'] = null;
                $paramentro['CD_AUTOR'] = null;
                $paramentro['TITULO'] = null;
                $paramentro['RESUMO'] = null;
                $paramentro['IMG_CAPA'] = null;
                $paramentro['DESCRICAO'] = null;
                $paramentro['THUMB'] = null;
                $paramentro['DT_EVENTO'] = null;
                $paramentro['PUBLICADO'] = null;
                break;
            case 'U':
                $paramentro['OPERACAO'] = $dados['OPERACAO'];
                $paramentro['CD_NEWS'] = $dados['CD_NEWS'];
                $paramentro['CD_CATEGORIA'] = $dados['CD_CATEGORIA'];
                $paramentro['CD_AUTOR'] = $dados['CD_AUTOR'];
                $paramentro['TITULO'] = $dados['TITULO'];
                $paramentro['RESUMO'] = $dados['RESUMO'];
                $paramentro['IMG_CAPA'] = $dados['IMG_CAPA'];
                $paramentro['DESCRICAO'] = $dados['DESCRICAO'];
                $paramentro['THUMB'] = $dados['THUMB'];
                $paramentro['DT_EVENTO'] = $dados['DT_EVENTO'];
                $paramentro['PUBLICADO'] = $dados['PUBLICADO'];
                break;
            case 'E':
                $paramentro['OPERACAO'] = $dados['OPERACAO'];
                $paramentro['CD_NEWS'] = $dados['CD_NEWS'];
                $paramentro['CD_CATEGORIA'] = null;
                $paramentro['CD_AUTOR'] = null;
                $paramentro['TITULO'] = null;
                $paramentro['RESUMO'] = null;
                $paramentro['IMG_CAPA'] = null;
                $paramentro['DESCRICAO'] = null;
                $paramentro['THUMB'] = null;
                $paramentro['DT_EVENTO'] = null;
                $paramentro['PUBLICADO'] = null;
                break;
        }
        
        $spnews = $this->sp_news($paramentro); 
        return($spnews);
    }
    
    function sp_news($dados){ 
        $OPERACAO = $dados['OPERACAO'];
        $CD_NEWS = $dados['CD_NEWS'];
        $CD_CATEGORIA = $dados['CD_CATEGORIA'];
        $CD_AUTOR = $dados['CD_AUTOR'];
        $TITULO = $dados['TITULO'];
        $RESUMO = $dados['RESUMO'];
        $IMG_CAPA = $dados['IMG_CAPA'];
        $DESCRICAO = $dados['DESCRICAO'];
        $THUMB = $dados['THUMB'];
        $DT_EVENTO = $this->input->oracle_data($dados['DT_EVENTO']);
        $PUBLICADO = $dados['PUBLICADO'];        
        
        $params = array(
                        array('name'=>':P_OPERACAO', 'value'=>$OPERACAO),
                        array('name'=>':P_CD_NEWS', 'value'=>$CD_NEWS),
                        array('name'=>':P_CD_CATEGORIA', 'value'=>$CD_CATEGORIA),
                        array('name'=>':P_CD_AUTOR', 'value'=>$CD_AUTOR),
                        array('name'=>':P_TITULO', 'value'=>$TITULO),
                        array('name'=>':P_RESUMO', 'value'=>$RESUMO),
                        array('name'=>':P_IMG_CAPA', 'value'=>$IMG_CAPA),
                        array('name'=>':P_DESCRICAO', 'value'=>$DESCRICAO),
                        array('name'=>':P_THUMB', 'value'=>$THUMB),
                        array('name'=>':P_DT_EVENTO', 'value'=>$DT_EVENTO),
                        array('name'=>':P_PUBLICADO', 'value'=>$PUBLICADO),
                        array('name'=>':RC1', 'value'=>$cursor, 'type'=>OCI_B_CURSOR)
                );      
        return $this->db->sp_seculo('BD_PROJETO','SP_INS_UPD_DEL_NEWS',$params);
        
    }
    
}