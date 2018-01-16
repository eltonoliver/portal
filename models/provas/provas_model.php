<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Provas_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    function sp_provas($dado){ //print_r($dado);//exit;
        $cursor = '';
        $params = array(
                array('name'=>':P_OPERACAO',        'value'=>$dado['operacao']),
                array('name'=>':P_CD_GRUPO',        'value'=>$dado['cd_grupo']),
                array('name'=>':P_DC_GRUPO',        'value'=>$dado['dc_grupo']),
                array('name'=>':P_FL_ATIVO',        'value'=>$dado['ativo']),
                array('name'=>':P_CD_USU_CADASTRO', 'value'=>$dado['cd_usuario']),
                array('name'=>':P_CURSOR',          'value'=>$cursor,'type'=>OCI_B_CURSOR)
                );

        return $this->db->sp_seculo('BD_ACADEMICO','AVAL_MANTER_GRUPO',$params);		
	
    
    }
    
    function atualizar_gabarito($dado){ 
        $cursor = '';
        $pam = array(
                    array('name'=>':P_CD_PROVA', 'value'=>$dado['prova']),
                    array('name'=>':RC1', 'value'=>$cursor, 'type'=>OCI_B_CURSOR),
                    );
        return $this->db->sp_seculo('BD_SICA','AVAL_ATUALIZA_GABARITO',$pam);		
	
    
    }
    
    function sp_subgrupo($dado){ //print_r($dado);//exit;
        $cursor = '';
        $params = array(
                array('name'=>':P_OPERACAO',        'value'=>$dado['operacao']),
                array('name'=>':P_CD_GRUPO',        'value'=>$dado['cd_grupo']),
                array('name'=>':P_CD_SUBGRUPO',        'value'=>$dado['cd_subgrupo']),
                array('name'=>':P_DC_SUBGRUPO',        'value'=>$dado['subgrupo']),
                array('name'=>':P_CURSOR',          'value'=>$cursor,'type'=>OCI_B_CURSOR)
                );
        return $this->db->sp_seculo('BD_ACADEMICO','AVAL_MANTER_SUBGRUPO',$params);		
    }
    
    function sp_questao($dado){
        $cursor = '';
        $params = array(
                        array('name'=>':P_OPERACAO',            'value'=>$dado['operacao']),
                        array('name'=>':P_CD_QUESTAO',          'value'=>$dado['cd_questao']),
                        array('name'=>':P_FLG_TIPO',            'value'=>$dado['tipo']),
                        array('name'=>':P_DC_QUESTAO',          'value'=>$dado['descricao']),
                        array('name'=>':P_CD_DISCIPLINA',       'value'=>$dado['cd_disciplina']),
                        array('name'=>':P_CD_USU_APROVACAO',    'value'=>$dado['usu_aprova']),
                        array('name'=>':P_CD_USU_CADASTRO',     'value'=>$dado['usu_cadastra']),
                        array('name'=>':P_NR_DIFICULDADE',      'value'=>$dado['dificuldade']),
                        array('name'=>':P_PERIODO',             'value'=>$dado['periodo']),
                        array('name'=>':P_CURSOR',              'value'=>$cursor,'type'=>OCI_B_CURSOR)
                );
        
        return $this->db->sp_seculo('BD_ACADEMICO','AVAL_MANTER_QUESTAO',$params);		
    }
    
    function cadastrar_grupo($dado){
        $sql = " INSERT INTO BD_ACADEMICO.AVAL_GRUPO(
                DC_GRUPO,
                CD_USU_CADASTRO,
                CD_DISCIPLINA
      ) VALUES (
                UPPER('".$dado['dc_grupo']."'),
                ".$dado['cd_usuario'].",
                ".$dado['cd_disciplina']."    
                )";
    return $this->db->query($sql);
    }
    
    function dados_grupo($cd_grupo){
        $sql = "SELECT G.CD_GRUPO, G.DC_GRUPO, D.NM_DISCIPLINA, D.CD_DISCIPLINA
                    FROM BD_ACADEMICO.AVAL_GRUPO G
                INNER JOIN BD_SICA.CL_DISCIPLINA D ON D.CD_DISCIPLINA = G.CD_DISCIPLINA
                WHERE G.CD_GRUPO = ".$cd_grupo;
        return $this->db->query($sql);
    }
    
    function editar_grupo($dados){
        $sql = "UPDATE BD_ACADEMICO.AVAL_GRUPO SET DC_GRUPO = '".$dados['dc_grupo']."', CD_DISCIPLINA = ".$dados['cd_disciplina']."
                 WHERE CD_GRUPO = ".$dados['cd_grupo'];
        return $this->db->query($sql);
    }
    
    function dados_subgrupo($cd_grupo){
        $sql = "SELECT *
                    FROM BD_ACADEMICO.AVAL_SUBGRUPO S
                 INNER JOIN BD_ACADEMICO.AVAL_GRUPO G ON G.CD_GRUPO = S.CD_GRUPO
                WHERE G.CD_GRUPO  = ".$cd_grupo;
        
        return $this->db->query($sql);
    }
            
    function cadastrar_subgrupo($dado){
        $sql = "INSERT INTO BD_ACADEMICO.AVAL_SUBGRUPO(
                CD_GRUPO,
                DC_SUBGRUPO
        ) VALUES (
                ".$dado['cd_grupo'].",
                UPPER('".$dado['subgrupo']."'))";
        //echo $sql;exit;
        return $this->db->query($sql);
    }
    
    function lista_disciplina(){
       
        $sql = "SELECT P.CD_DISCIPLINA, D.NM_DISCIPLINA FROM BD_SICA.CL_TURMA_PROFESSORES P
                    INNER JOIN BD_SICA.CL_DISCIPLINA D
                      ON P.CD_DISCIPLINA = D.CD_DISCIPLINA
                    INNER JOIN BD_SICA.USUARIOS U ON U.CD_PROFESSOR = P.CD_PROFESSOR
                    WHERE P.PERIODO = '".$this->session->userdata('SCL_SSS_USU_PERIODO')."'
                 GROUP BY P.CD_DISCIPLINA, D.NM_DISCIPLINA
                 ORDER BY D.NM_DISCIPLINA";
        
        // U.CD_USUARIO = ".$this->session->userdata('SCL_SSS_USU_CODIGO')." AND
//        $sql = "SELECT DISTINCT D.CD_DISCIPLINA,D.NM_DISCIPLINA FROM BD_SICA.AVAL_PROVA_DISC P
//                INNER JOIN BD_SICA.CL_DISCIPLINA D ON P.CD_DISCIPLINA = D.CD_DISCIPLINA
//                WHERE P.CD_PROVA = ".$cd_prova;
        return $this->db->query($sql);
    }
    
    function cadastrar_questao($dados){ //print_r($dados);exit;    
        
        
//      $sql = "INSERT INTO BD_ACADEMICO.AVAL_QUESTAO(
//                FLG_TIPO,
//                DC_QUESTAO,
//                CD_DISCIPLINA,
//                CD_USU_APROVACAO,
//                DT_APROVACAO,
//                CD_USU_CADASTRO,
//                NR_DIFICULDADE,
//                CD_CURSO,
//                ORDEM_SERIE
//            )VALUES (
//                '".$dados['tipo']."',
//                '".$dados['descricao']."',
//                ".$dados['cd_disciplina'].",
//                ".$dados['cd_usuario'].",
//                SYSDATE,
//                ".$dados['cd_usuario'].",
//                ".$dados['dificuldade'].",
//                ".$dados['curso'].",
//                ".$dados['serie']."
//               )RETURNING IMG_QUESTAO into :IMAGEM";
      //echo $sql;exit;
//      $params = array(
//                 array('name'=>':IMAGEM', 'value'=>'IMAGEM', 'type'=> OCI_B_BLOB)
//                );
    
        $sql = "INSERT INTO BD_ACADEMICO.AVAL_QUESTAO(
                FLG_TIPO,
                DC_QUESTAO,
                CD_DISCIPLINA,
                CD_USU_APROVACAO,
                DT_APROVACAO,
                CD_USU_CADASTRO,
                NR_DIFICULDADE,
                CD_CURSO,
                ORDEM_SERIE,
                FLG_RESPOSTA_CORRETA
            )VALUES (
                '".$dados['tipo']."',
                '".$dados['descricao']."',
                ".$dados['cd_disciplina'].",
                ".$dados['cd_usuario'].",
                SYSDATE,
                ".$dados['cd_usuario'].",
                ".$dados['dificuldade'].",
                ".$dados['curso'].",
                ".$dados['serie'].",
                '".$dados['gabarito']."'
               )";
        $res = $this->db->query($sql);
        
        return $res;
    }
    
    function ultima_questao(){
        $sql = "select MAX(CD_QUESTAO)AS CD from BD_ACADEMICO.AVAL_QUESTAO";
        return $this->db->query($sql);
    }
    
    function cadastrar_item($dados){
        
        $sql = "INSERT INTO BD_ACADEMICO.AVAL_QUESTAO_OPCAO (CD_QUESTAO,CD_OPCAO,DC_OPCAO,CD_USU_CADASTRO,DT_CADASTRO,TIPO,FLG_CORRETA,DC_RESPOSTA)
                VALUES(".$dados['cd_questao'].",
                       ".$dados['cd_opcao'].",
                       '".$dados['item']."',
                       ".$dados['cd_usuario'].",
                       SYSDATE,
                       '".$dados['tipo']."',
                       ".$dados['correta'].",
                       '".$dados['resposta']."' )";      
        
        return $this->db->query($sql);
    }
    
    function carrega_sub_grupo(){
        $sql = "SELECT * FROM BD_ACADEMICO.AVAL_SUBGRUPO";
        return $this->db->query($sql);
    }
    
    function cadastra_subgrupo($dados){
        $sql = "INSERT INTO BD_ACADEMICO.AVAL_QUESTAO_SUBGRUPO(CD_QUESTAO,CD_SUBGRUPO)
                VALUES(".$dados['cd_questao'].",".$dados['cd_subgrupo'].")";
        return $this->db->query($sql);
    }
    
    function cadastra_resposta($dados){
        if($dados['tipo']=='D'){
            $sql = "INSERT INTO BD_ACADEMICO.AVAL_QUESTAO_RESPOSTA(CD_QUESTAO,DC_RESPOSTA) VALUES(".$dados['cd_questao'].",'".$dados['resposta']."')";
        }else{
            $sql = "INSERT INTO BD_ACADEMICO.AVAL_QUESTAO_RESPOSTA(CD_QUESTAO,CD_OPCAO) VALUES(".$dados['cd_questao'].",'".$dados['resposta']."')";
        }
        return $this->db->query($sql);
    }
    
    function resposta($cd_questao){
        $sql = "SELECT CD_QUESTAO,CD_OPCAO,DBMS_LOB.SUBSTR(DC_RESPOSTA,4000,1) DC_RESPOSTA FROM BD_ACADEMICO.AVAL_QUESTAO_RESPOSTA WHERE CD_QUESTAO = ".$cd_questao;
        return $this->db->query($sql)->result();
    }
    
    function opcoes($cd_questao){
        $sql = "SELECT CD_QUESTAO,CD_OPCAO, DBMS_LOB.SUBSTR(DC_OPCAO,4000,1) DC_OPCAO, TIPO 
                FROM BD_ACADEMICO.AVAL_QUESTAO_OPCAO WHERE CD_QUESTAO = ".$cd_questao." ORDER BY CD_OPCAO";
        return $this->db->query($sql)->result();
    }
    
    
    //consultas dos dados de provas
    function lista_provas(){
        if($this->session->userdata('SCL_SSS_USU_CODIGO') == 5454){
            $sql = "SELECT P.CD_PROVA, 
                           P.NUM_PROVA,
                           P.PERIODO,
                           P.DT_PROVA,
                           P.QTDE_QUESTOES,
                           P.TITULO,
                           P.CD_PROFESSOR,
                           NVL(P.CD_STATUS,1) CD_STATUS,
                           C.NM_CURSO,
                           (SELECT COUNT(*) QTDE FROM BD_SICA.AVAL_PROVA_QUESTOES Q WHERE Q.CD_PROVA = P.CD_PROVA) AS QTDE_QUESTAO
                      FROM BD_SICA.AVAL_PROVA P
                INNER JOIN BD_SICA.CURSOS C ON C.CD_CURSO = P.CD_CURSO";
        }else{
            $sql = "SELECT P.CD_PROVA, 
                           P.NUM_PROVA,
                           P.PERIODO,
                           P.DT_PROVA,
                           P.QTDE_QUESTOES,
                           P.TITULO,
                           P.CD_PROFESSOR,
                           NVL(P.CD_STATUS,1) CD_STATUS,
                           C.NM_CURSO,
                           (SELECT COUNT(*) QTDE FROM BD_SICA.AVAL_PROVA_QUESTOES Q WHERE Q.CD_PROVA = P.CD_PROVA) AS QTDE_QUESTAO
                      FROM BD_SICA.AVAL_PROVA P

                INNER JOIN BD_SICA.CURSOS C ON C.CD_CURSO = P.CD_CURSO
                  WHERE DT_PROVA >= TRUNC(SYSDATE)";
        }
               //--AND P.CD_PROFESSOR = ".$this->session->userdata('SCL_SSS_USU_PCODIGO');
        return $this->db->query($sql);
    }
    
    function lista_posicao_questao($cd_prova){
        $sql = "SELECT DISTINCT D.CD_DISCIPLINA,D.NM_DISCIPLINA,P.POSICAO_INICIAL, P.POSICAO_FINAL,P.TIPO_QUESTAO 
                FROM BD_SICA.AVAL_PROVA_DISC P
                INNER JOIN BD_SICA.CL_DISCIPLINA D ON P.CD_DISCIPLINA = D.CD_DISCIPLINA
                WHERE P.CD_PROVA = ".$cd_prova;  
        //echo $sql;
        return $this->db->query($sql);
    }
    
    function valida_posicao_questao($cd_prova,$tipo){
        $sql = "SELECT PQ.CD_PROVA, PQ.POSICAO, Q.FLG_TIPO FROM BD_SICA.AVAL_PROVA_QUESTOES PQ
                    INNER JOIN BD_ACADEMICO.AVAL_QUESTAO Q ON Q.CD_QUESTAO = PQ.CD_QUESTAO
                  WHERE PQ.CD_PROVA = ".$cd_prova." AND Q.FLG_TIPO = '".$tipo."'   ";
        
        return $this->db->query($sql);
    }
    
    function cadastra_questao_prova($dados){
        $sql = "INSERT INTO BD_SICA.AVAL_PROVA_QUESTOES(CD_PROVA,CD_QUESTAO,POSICAO,VALOR)
                VALUES(".$dados['cd_prova'].",".$dados['cd_questao'].",".$dados['posicao'].",".$dados['valor'].")";
        return $this->db->query($sql);
    }
    
    function lista_questoes(){
            $sql = "SELECT Q.CD_QUESTAO,DBMS_LOB.SUBSTR(Q.DC_QUESTAO,4000,1)DC_QUESTAO,Q.NR_DIFICULDADE,
                        P.POSICAO,P.VALOR,
                        CASE WHEN Q.FLG_TIPO = 'O' THEN 'OBJETIVA'
                            WHEN Q.FLG_TIPO = 'D' THEN 'DISCURSSIVA'
                        END TIPO, Q.CD_USU_CADASTRO,
                        DBMS_LOB.SUBSTR(Q.DC_RESPOSTAS,4000,1) DC_RESPOSTAS,P.CD_PROVA,AP.TITULO, NVL(AP.CD_STATUS,1) CD_STATUS              
                   FROM BD_ACADEMICO.AVAL_QUESTAO Q
                     LEFT JOIN BD_SICA.AVAL_PROVA_QUESTOES P ON P.CD_QUESTAO = Q.CD_QUESTAO
                     LEFT JOIN BD_SICA.AVAL_PROVA AP ON AP.CD_PROVA = P.CD_PROVA
             WHERE Q.CD_USU_CADASTRO = ".$this->session->userdata('SCL_SSS_USU_CODIGO')." ";  
        
        return $this->db->query($sql);
    }
    
    function dados_questao($cd_questao){
        $sql = "SELECT Q.CD_QUESTAO, PQ.CD_PROVA,
                    Q.FLG_TIPO,
                    DBMS_LOB.SUBSTR(Q.DC_QUESTAO,4000,1)DC_QUESTAO,
                    Q.CD_DISCIPLINA, 
                    Q.NR_DIFICULDADE,
                    Q.CD_CURSO,
                    Q.ORDEM_SERIE,
                    Q.QTD_LINHAS,
                    PQ.POSICAO,PQ.VALOR,
            --        SG.CD_SUBGRUPO,
            --        QP.CD_OPCAO,
            --        QP.TIPO,
            --      QP.FLG_CORRETA,
                    DBMS_LOB.SUBSTR(Q.DC_RESPOSTAS,4000,1) DC_RESPOSTAS,
                    Q.FLG_RESPOSTA_CORRETA 
                FROM BD_ACADEMICO.AVAL_QUESTAO Q
                LEFT JOIN BD_SICA.AVAL_PROVA_QUESTOES PQ ON PQ.CD_QUESTAO = Q.CD_QUESTAO
        --        INNER JOIN BD_ACADEMICO.AVAL_QUESTAO_SUBGRUPO SG ON SG.CD_QUESTAO = Q.CD_QUESTAO
          --      INNER JOIN BD_ACADEMICO.AVAL_QUESTAO_OPCAO QP ON QP.CD_QUESTAO = Q.CD_QUESTAO
                WHERE Q.CD_QUESTAO = ".$cd_questao;
    //    echo $sql; exit;
        return $this->db->query($sql);
    }
    
    function dados_disciplina($cd_disc){
        $sql = "SELECT * FROM BD_SICA.CL_DISCIPLINA WHERE CD_DISCIPLINA = ".$cd_disc;
        return $this->db->query($sql);
    }
    
    function dados_cursos($cd_curso){
        $sql = "SELECT * FROM BD_SICA.CL_CURSOS WHERE CD_DISCIPLINA = ".$cd_disc;
        return $this->db->query($sql);
    }
    
    function confirmar_edicao($param){
        //EDITA A QUESTAO
        $sql = "UPDATE BD_ACADEMICO.AVAL_QUESTAO 
                   SET CD_CURSO = ".$param['curso'].", 
                       ORDEM_SERIE = ".$param['serie'].", 
                       CD_DISCIPLINA = ".$param['disc'].", 
                       NR_DIFICULDADE = ".$param['dificuldade'].", 
                       FLG_TIPO = '".$param['tipo']."', 
                       DC_QUESTAO = '".$param['pergunta']."',
                       FLG_RESPOSTA_CORRETA = '".$param['gabarito']."',
                       CD_USU_ALTERACAO = ".$this->session->userdata('SCL_SSS_USU_CODIGO').",
                       DT_ALTERACAO = SYSDATE
                 WHERE CD_QUESTAO = ".$param['cd_questao']."
                ";
  //   echo $sql;exit;
        //EDITA A QUESTAO NA PROVA
        $sql1 = "UPDATE BD_SICA.AVAL_PROVA_QUESTOES SET POSICAO = ".$param['posicao']." 
                WHERE CD_PROVA = ".$param['cd_prova']." AND CD_QUESTAO = ".$param['cd_questao']." ";
      
        $this->db->query($sql1);
        
        return $this->db->query($sql);
                
    }

}
