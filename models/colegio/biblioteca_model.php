<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Biblioteca_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //CARREGAS AS CONFIGURACOES DA BIBLIOTECA
    function configuracoes($perfil){
        $query = $this->db->query("SELECT * FROM SICA_BIBLIOTECA.BIB_CONFIGURACAO WHERE PERFIL = '".$perfil."'");
        return $query->row();
    }

    // MONTA O GRID DE LIVROS LIVROS
    function grid($tipo) {
        
        if(($tipo['autor'] != "") and ($tipo['livro'] != "")){
            $tipo = 2;
        }else{
            if($tipo['autor'] != ""){
                $tipo = 1;
            }elseif($tipo['livro'] != ""){
                $tipo = 0;
            }
        }
        switch ($tipo) {
            case 0: // tela de filtro por livros
                $tipo = " WHERE EMPRESTADO IS NULL   
                            AND E.ESTADO = 'A'       
                            AND E.LIBERACAO = 'F'    
                            AND (UPPER(IT.TITULO) LIKE UPPER('%".$_REQUEST['livro']."%'))";
                ;
                break;
            case 1: // tela de filtro por autores 
                $tipo = " WHERE EMPRESTADO IS NULL   
                            AND E.ESTADO = 'A'       
                            AND E.LIBERACAO = 'F'    
                            AND (UPPER(P.PRENOME) LIKE UPPER('%".$_REQUEST['autor']."%') OR UPPER(SOBRENOME) LIKE UPPER('%".$_REQUEST['autor']."%'))";
                ;
                break;
            case 2: // tela de filtro por livro
                $tipo = " WHERE EMPRESTADO IS NULL   
                            AND E.ESTADO = 'A'       
                            AND E.LIBERACAO = 'F'    
                            AND (UPPER(P.PRENOME) LIKE UPPER('%".$_REQUEST['autor']."%') OR UPPER(SOBRENOME) LIKE UPPER('%".$_REQUEST['autor']."%'))
                                 AND (UPPER(IT.TITULO) LIKE UPPER('%".$_REQUEST['livro']."%'))";
                ;
                break;
        }
#echo $tipo;exit;
        $query = $this->db->query("SELECT B.CD_BIBLIOTECA, B.BIBLIOTECA, IT.MFN, IT.TITULO, P.SOBRENOME || ',' || P.PRENOME AS AUTOR,
                                        NVL( RESERVAS.QTD_RESERVAS, 0) AS QTD_RESERVAS,
                                        COUNT (DISTINCT E.NR_REGISTRO) - NVL( RESERVAS.QTD_RESERVAS, 0) AS QTD_ATIVOS_PARA_EMPRESTIMO,
                                        CASE WHEN COUNT (DISTINCT E.NR_REGISTRO) - NVL( RESERVAS.QTD_RESERVAS, 0) > 0
                                            THEN 'S'
                                            ELSE 'N'
                                        END AS PODE_EMPRESTAR

                                 FROM SICA_BIBLIOTECA.BIB_EXEMPLAR E
                                 INNER JOIN SICA_BIBLIOTECA.BIB_BIBLIOTECA B ON B.CD_BIBLIOTECA = E.CD_BIBLIOTECA
                                 INNER JOIN SICA_BIBLIOTECA.BIB_ITEM IT ON IT.MFN = E.MFN
                                 INNER JOIN SICA_BIBLIOTECA.BIB_AUTOR_PRINC P ON IT.MFN = P.MFN

                                 LEFT OUTER JOIN ( --Livros Emprestados Atualmente
                                                  SELECT DISTINCT BIB_EMPRESTIMO.NR_REGISTRO, BIB_EMPRESTIMO.DT_DEV_PREVISTA AS EMPRESTADO
                                                  FROM SICA_BIBLIOTECA.BIB_EMPRESTIMO
                                                  WHERE BIB_EMPRESTIMO.DT_DEVOLUCAO IS NULL
                                                 ) EMPRESTIMO ON EMPRESTIMO.NR_REGISTRO = E.NR_REGISTRO

                                 LEFT OUTER JOIN (   --Reservas Validas
                                                     SELECT COUNT(*) AS QTD_RESERVAS, R.MFN, R.CD_BIBLIOTECA
                                                     FROM SICA_BIBLIOTECA.BIB_RESERVAS R
                                                     WHERE TRUNC(R.DT_VALIDADE_RESERVA) >= TRUNC(SYSDATE)
                                                       AND R.CD_EMPRESTIMO IS NULL
                                                     GROUP BY R.CD_BIBLIOTECA, R.MFN
                                                 ) RESERVAS ON RESERVAS.CD_BIBLIOTECA = E.CD_BIBLIOTECA AND RESERVAS.MFN = E.MFN"
                                .$tipo." GROUP BY RESERVAS.QTD_RESERVAS, B.CD_BIBLIOTECA, B.BIBLIOTECA,IT.MFN, IT.TITULO, P.SOBRENOME, P.PRENOME");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // CONTA O NUMERO DE LIVROS
    function gridCount() {
        $query = $this->db->query("SELECT COUNT(*) FROM SICA_BIBLIOTECA.bib_item");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // LIVROS EMPRESATADOS
    function emprestado() {
        $query = $this->db->query("SELECT * FROM 
                                        SICA_BIBLIOTECA.bib_emprestimo emp, 
                                        SICA_BIBLIOTECA.bib_emprestimo_material mat, 
                                        SICA_BIBLIOTECA.bib_item itm,
                                        SICA_BIBLIOTECA.bib_exemplar exm
                                        WHERE emp.cd_emprestimo = mat.cd_emprestimo
                                        AND emp.nr_registro = exm.nr_registro
                                        AND exm.mfn = itm.mfn
                                        AND emp.cd_aluno =  '" . $this->session->userdata('SCL_SSS_USU_ID') . "'");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    // LISTA DE AUTOR
    function autor() {

        if (isset($_REQUEST['query']) && $_REQUEST['query'] != "") {

            if (strlen($_REQUEST['query']) > 3) {

                $query = $this->db->query("SELECT distinct upper(PRE_SOBRE) as PRE_SOBRE FROM SICA_BIBLIOTECA.bib_autor_princ
				                            WHERE UPPER(PRE_SOBRE) LIKE('%" . strtoupper($_REQUEST['query']) . "%')
											AND ROWNUM <= 10 
										  ORDER BY PRE_SOBRE ASC");

                if ($query->num_rows() > 0) {
                    return $query->result();
                } else {
                    return false;
                }
            }
        }
    }

    // LISTA DE TIPO DE ITEM
    function tipo_item() {

        $query = $this->db->query("SELECT * FROM SICA_BIBLIOTECA.bib_tipo_item ORDER BY DESCRICAO ASC");

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    //retorna os dados do livro
    function dados_livro($mfn){ 
        $query = $this->db->query("SELECT B.CD_BIBLIOTECA, B.BIBLIOTECA, IT.MFN, IT.TITULO, P.SOBRENOME || ',' || P.PRENOME AS AUTOR,
                                        NVL( RESERVAS.QTD_RESERVAS, 0) AS QTD_RESERVAS,
                                        COUNT (DISTINCT E.NR_REGISTRO) - NVL( RESERVAS.QTD_RESERVAS, 0) AS QTD_ATIVOS_PARA_EMPRESTIMO,
                                        CASE WHEN COUNT (DISTINCT E.NR_REGISTRO) - NVL( RESERVAS.QTD_RESERVAS, 0) > 0
                                            THEN 'S'
                                            ELSE 'N'
                                        END AS PODE_EMPRESTAR

                                 FROM SICA_BIBLIOTECA.BIB_EXEMPLAR E
                                 INNER JOIN SICA_BIBLIOTECA.BIB_BIBLIOTECA B ON B.CD_BIBLIOTECA = E.CD_BIBLIOTECA
                                 INNER JOIN SICA_BIBLIOTECA.BIB_ITEM IT ON IT.MFN = E.MFN
                                 INNER JOIN SICA_BIBLIOTECA.BIB_AUTOR_PRINC P ON IT.MFN = P.MFN

                                 LEFT OUTER JOIN ( 
                                                  SELECT DISTINCT BIB_EMPRESTIMO.NR_REGISTRO, BIB_EMPRESTIMO.DT_DEV_PREVISTA AS EMPRESTADO
                                                  FROM SICA_BIBLIOTECA.BIB_EMPRESTIMO
                                                  WHERE BIB_EMPRESTIMO.DT_DEVOLUCAO IS NULL
                                                 ) EMPRESTIMO ON EMPRESTIMO.NR_REGISTRO = E.NR_REGISTRO

                                 LEFT OUTER JOIN ( 
                                                     SELECT COUNT(*) AS QTD_RESERVAS, R.MFN, R.CD_BIBLIOTECA
                                                     FROM SICA_BIBLIOTECA.BIB_RESERVAS R
                                                     WHERE TRUNC(R.DT_VALIDADE_RESERVA) >= TRUNC(SYSDATE)
                                                       AND R.CD_EMPRESTIMO IS NULL
                                                       AND R.MFN = ".$mfn."
                                                     GROUP BY R.CD_BIBLIOTECA, R.MFN
                                                 ) RESERVAS ON RESERVAS.CD_BIBLIOTECA = E.CD_BIBLIOTECA AND RESERVAS.MFN = E.MFN

                                 WHERE EMPRESTADO IS NULL   
                                   AND E.ESTADO = 'A'      
                                   AND E.LIBERACAO = 'F'    
                                   AND E.MFN = ".$mfn."
                                 GROUP BY RESERVAS.QTD_RESERVAS, B.CD_BIBLIOTECA, B.BIBLIOTECA,IT.MFN, IT.TITULO, P.SOBRENOME, P.PRENOME");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    //retorna se o usuario ja tem uma reserva para o livro selecionado
    function usuario_ja_tem_reserva($mfn){
        //VERIFICO O TIPO DE USUARIO
        if($this->session->userdata['SCL_SSS_USU_PERFIL'] == P_ALUNO){
            $tipo = "CD_ALUNO";
        }else{
            $tipo = "CD_PESSOA";
        }
        $pode_reservar = $this->db->query("SELECT COUNT(*) AS QTDE, TO_CHAR(DT_VALIDADE_RESERVA, 'DD/MM/YYYY') AS DT_VALIDADE
                                            FROM SICA_BIBLIOTECA.BIB_RESERVAS
                                        WHERE ".$tipo." = ".$this->session->userdata['SCL_SSS_USU_CODIGO']."
                                          AND MFN = ".$mfn."
                                          AND TO_CHAR(SYSDATE, 'DD/MM/YYYY') < TO_CHAR(DT_VALIDADE_RESERVA, 'DD/MM/YYYY')
                                          AND CD_EMPRESTIMO IS NULL
                                          GROUP BY DT_VALIDADE_RESERVA");
        return $pode_reservar->row();
    }
    
    //verifica quantas reservas ativas o usuario possui
    function reservas_ativas($usuario){ 
        $query = $this->db->query("SELECT COUNT(*) AS QTDE FROM SICA_BIBLIOTECA.BIB_RESERVAS 
                                    WHERE CD_PESSOA = ".$usuario." 
                                    AND TO_CHAR(SYSDATE, 'DD/MM/YYYY') < TO_CHAR(DT_VALIDADE_RESERVA, 'DD/MM/YYYY') 
                                    AND CD_EMPRESTIMO IS NULL");
         return $query->row();
    }
    
    //lista de EMPRESTIMOS
    function lista_emprestimo() {         
        $tipo = "WHERE 1=0";
        if($this->session->userdata('SCL_SSS_USU_TIPO') == 10){ // aluno
            $tipo = " WHERE EM.CD_ALUNO = ".$this->session->userdata['SCL_SSS_USU_CODIGO']."";
        }elseif($this->session->userdata('SCL_SSS_USU_TIPO') == 30){ // colaborador
            $tipo = "WHERE EM.CD_FUNCIONARIO = ".$this->session->userdata['SCL_SSS_USU_CODIGO']."";
        }
        $query = $this->db->query("SELECT EM.NR_REGISTRO, EM.CD_EMPRESTIMO, TO_CHAR(EM.DT_DEV_PREVISTA, 'DD/MM/YYYY') AS DT_DEV_PREVISTA,
                                        IT.TIT_SUBTIT, P.SOBRENOME || ',' || P.PRENOME AS AUTOR  
                                    FROM SICA_BIBLIOTECA.BIB_EMPRESTIMO EM
                                      INNER JOIN SICA_BIBLIOTECA.BIB_EXEMPLAR EX ON EM.NR_REGISTRO = EX.NR_REGISTRO
                                      INNER JOIN SICA_BIBLIOTECA.BIB_ITEM IT ON IT.MFN = EX.MFN
                                      LEFT JOIN SICA_BIBLIOTECA.BIB_AUTOR_PRINC P ON P.MFN = EX.MFN $tipo");
                                    //WHERE ".$tipo." --AND EM.DT_DEVOLUCAO IS NULL");
        
                
        $b = $query->result();
        
        if(count($b) > 0){
            return $query->result();
        }else{
            return false;
        }
    }
    
    function inserirReserva($dados){ 
        //verifica se a data cai no feriado
        $sqlFeriado = $this->db->query("SELECT TO_CHAR(DATA,'DD/MM/YYYY') AS DATA FROM BD_SICA.FC_CALENDARIO
                                WHERE TIPO IN ('R','F','V','A')
                          AND TRUNC(DATA) > TRUNC(SYSDATE)");
        $feriado = $sqlFeriado->result();
        
        foreach ($feriado as $feriados){
            //verifica se data e feriado
            if(substr($dados['DT_RESERVA'],0,5) == substr($feriados->DATA,0,5)){
                $dados['DT_RESERVA'] = $this->session->_calcular_dias(2,1,str_replace("/","-",$dados['DT_RESERVA']));
            }
        }   
        //VERIFICO O TIPO DE USUARIO
        if($this->session->userdata['SCL_SSS_USU_PERFIL'] == P_ALUNO){
            $tipo = "CD_ALUNO";
        }else{
            $tipo = "CD_PESSOA";
        }
        $sqlreserva = "INSERT INTO SICA_BIBLIOTECA.BIB_RESERVAS 
                                (".$tipo.", MFN, CD_BIBLIOTECA, DT_INTERESSE, DT_VALIDADE_RESERVA)
                           VALUES 
                                (".$dados['COD_USUARIO'].", ".$dados['MFN'].", 113, SYSDATE, TO_DATE('".$dados['DT_RESERVA']."','DD/MM/YYYY'))";
        
         $query = $this->db->query($sqlreserva);
         if($query){
           $sqlCdreserva = $this->db->query("SELECT R.CD_RESERVA, R.MFN, TO_CHAR(R.DT_VALIDADE_RESERVA, 'DD/MM/YYYY') AS DT_VALIDADE_RESERVA, IT.TIT_SUBTIT, P.PRE_SOBRE  
                                              FROM SICA_BIBLIOTECA.BIB_RESERVAS R
                                                INNER JOIN SICA_BIBLIOTECA.BIB_ITEM IT ON IT.MFN = R.MFN    
                                                LEFT JOIN SICA_BIBLIOTECA.BIB_AUTOR_PRINC P ON IT.MFN = P.MFN
                                              WHERE ROWNUM = 1 ORDER BY CD_RESERVA DESC ")->row();
        #   if ($query->num_rows() > 0) {
               return $sqlCdreserva;
       #    }
         }else{
             echo "erro no select";
         }
    }
         
    function atualizarDados($dados){ 
             $sql = "UPDATE SICA_BIBLIOTECA.BIB_EMPRESTIMO SET 
                            DT_DEV_PREVISTA = TO_DATE('".$dados['DT_DEVOLUCAO']."','DD/MM/YYYY'),
                            DT_RENOVACAO = SYSDATE
                    WHERE CD_EMPRESTIMO = ".$dados['CD_EMPRESTIMO'];
             $query = $this->db->query($sql);
             if($query){
                 return TRUE;
             }
         }


}