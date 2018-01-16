<?php 
if ( ! defined('BASEPATH')) 
	exit('No direct script access allowed');

class Questoes extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'html', 'directory', 'file','funcoes'));
        $this->load->library(array('form_validation', 'session', 'upload'));

        $this->load->model('acesso/controle_model', 'controle', TRUE);
        $this->load->model('colegio/colegio_model', 'colegio', TRUE);
        $this->load->model('colegio/colegio_model', 'colegio', TRUE);
        $this->load->model('provas/provas_model','prova',TRUE);
        $this->load->model('provas/correcao_model','correcao',TRUE);
        
//        $sessao = $this->session->userdata;
//        $ips = explode('.',$sessao['ip_address']);
//        if($ips[0] != '10' ){
//            $this->load->view('provas/bloqueado');
//        }
        
        $this->load->model('provas/correcao_model','correcao',TRUE);
    }

    function index(){
        
        $p = array(
                'programa' => 'CONTROLLERS - QUESTOES',
                'sistema' => 'GESTÃO DE PROVAS'
        );
       $this->controle->weblog($p);
        
        $param = array('operacao'=>'LQU','usu_cadastra'=>$this->session->userdata('SCL_SSS_USU_CODIGO'));
        $param1 = array('operacao'=>'LP');
        $data = array('titulo'=>'Lista Questões das Provas', 
                     // 'listar'=>$this->prova->lista_questoes()->result(),
                      'listar'=>$this->prova->sp_questao($param),
                      //'provas'=>$this->prova->lista_provas()->result()
                      'provas'=>$this->prova->sp_questao($param1)
                     );
//        print_r($data['provas']);exit;
//        $data = array('titulo'=>'Lista de Provas', 
//                      'listar'=>$this->prova->lista_questoes()->result(),
//                      'provas'=>$this->prova->lista_provas()->result()
//                     );
        $this->load->view('provas/lista_questao',$data);
    }
    
    function lista_grupo(){
        $data = array('titulo'=>'Lista Grupos',
                      'listar'=>$this->prova->sp_provas(array('operacao'=>'L'))
                     );

        $this->load->view('provas/grupo',$data);
    }
    
    function cadastro_grupo(){
        
         $p = array(
                'programa' => 'CONTROLLERS - QUESTOES :: '.$acao,
                'sistema' => 'GESTÃO DE PROVAS'
        );
       $this->controle->weblog($p);
        
        $acao = base64_decode($this->input->get_post('token'));
        $cd_grupo = base64_decode($this->input->get_post('id'));
        switch($acao){
             case "cadastrar": // INSERIR DADOS NO BANCO
                        $data = array('titulo'=>'Cadastrar Grupos',
                                      'subtitulo'=>'Cadastrar',
                                      'bt_cor'=>'success',
                                      'bt_acao'=>'Cadastrar',
                                      'acao'=>'cadastrar',
                                      'autor'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                                      'disciplina'=>$this->prova->lista_disciplina()->result()
                                      
                                );
            break;
             case "editar"://edita o regitro
                    $data = array('titulo'=>'Editar Grupos',
                                      'subtitulo'=>'Edição',
                                      'bt_cor'=>'warning',
                                      'bt_acao'=>'Editar',
                                      'acao'=>'editar',
                                      'autor'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                                      'disciplina'=>$this->prova->lista_disciplina()->result(),
                                      'dados'=>$this->prova->dados_grupo($cd_grupo)->result()
                        );
                 
            
             case "editar"://edita o regitro
                    $data = array('titulo'=>'Editar Grupos',
                                      'subtitulo'=>'Edição',
                                      'bt_cor'=>'warning',
                                      'bt_acao'=>'Editar',
                                      'acao'=>'editar',
                                      'autor'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                                      'disciplina'=>$this->prova->lista_disciplina()->result(),
                                      'dados'=>$this->prova->dados_grupo($cd_grupo)->result()
                        );
        }
        $this->load->view('provas/cad_grupo',$data);
    }
    
    function registar_infor(){
         $acao = base64_decode($this->input->get_post('acao'));
         
         $p = array(
                        'programa' => 'CONTROLLERS - QUESTOES :: '.$acao .' - '. $this->input->get_post('descricao'),
                        'sistema' => 'GESTÃO DE PROVAS'
          );
          $this->controle->weblog($p);
         
         switch($acao){
            case "cadastrar": // INSERIR DADOS NO BANCO
                $parametro = array('opercao'=>'I',
                                   'dc_grupo' => $this->input->get_post('descricao'),
                                   'cd_usuario'=>$this->input->get_post('autor'),
                                   'cd_disciplina'=>$this->input->get_post('disc')
                                );
                $sucesso = $this->prova->cadastrar_grupo($parametro);
                
                if($sucesso){
                    set_msg('msgok','Registro inserido com sucesso','sucesso');
                }else{
                    set_msg('msgerro','Erro ao inserir o registro.','erro');
                }
                redirect(base_url('provas/questoes/cadastro_grupo?token='.base64_encode('cadastrar').'&cd='.$parametro['cd_disciplina']), 'refresh');
            break;
            
            case "editar": // EDITAR DADOS NO BANCO
                $parametro = array('dc_grupo' => $this->input->get_post('descricao'),
                                   'cd_disciplina'=>$this->input->get_post('disc'),
                                   'cd_grupo'=>$this->input->get_post('cd_grupo')
                                );
                $sucesso = $this->prova->editar_grupo($parametro);
                
                if($sucesso){
                    set_msg('msgok','Regsitro Alterado com sucesso','sucesso');
                }else{
                    set_msg('msgerro','Erro ao alterar o registro.','erro');
                }
                redirect(base_url('provas/questoes/lista_grupo'), 'refresh');
            break;
         }
    }
    
    
    function subgrupo(){
        //$row = unserialize(urldecode($_GET['token']));
        $cd_grupo = base64_decode($_GET['token']);
        
        $row = $this->prova->dados_subgrupo($cd_grupo)->result();
        $data = array('titulo'=>'Cadastrar Subgrupo',
                      'subtitulo'=>'Cadastrar Subgrupo para o Grupo: <strong>'.$row[0]->DC_GRUPO."</strong>",
                      'dados'=>$row,
                      'bt_cor'=>'success',
                      'bt_acao'=>'Cadastrar',
                      'acao'=>'cadastrar',
                      'listarsub'=>$this->prova->sp_subgrupo(array('operacao'=>'L','cd_grupo'=>$row[0]->CD_GRUPO)),
                      'cd_grupo'=>$cd_grupo
                );
        $this->load->view('provas/cad_subgrupo',$data);
    }
    
    function registar_subgrupo(){
         $acao = base64_decode($this->input->get_post('acao'));
         
         switch($acao){
            case "cadastrar": // INSERIR DADOS NO BANCO
                $parametro = array('cd_grupo' => $this->input->get_post('grupo'),
                                   'subgrupo'=>$this->input->get_post('subgrupo'),
                                );
                $sucesso = $this->prova->cadastrar_subgrupo($parametro);
                print_r($_POST);exit;
                if($sucesso){
                    set_msg('msgok','Regsitro inserido com sucesso','sucesso');
                }else{
                    set_msg('msgerro','Erro ao inserir o registro.','erro');
                }
                redirect(base_url('provas/questoes/subgrupo?token='.  base64_encode($this->input->get_post('grupo')).' '), 'refresh');
            break;
         }
    }
    
    
    function cadastro_questao(){
        
         $p = array(
                 'programa' => 'CONTROLLERS - CADASTRO DE QUESTOES:: '.$acao .' - '. $this->input->get_post('prova'),
                 'sistema' => 'GESTÃO DE PROVAS'
          );
          $this->controle->weblog($p);
        
//        $data = array('titulo'=>'Cadastrar Questão',
//                      'subtitulo'=>'Formulário - TODOS OS CAMPOS SÃO OBRIGATÓRIOS',
//                      'bt_cor'=>'success',
//                      'bt_acao'=>'Cadastrar',
//                      'acao'=>'cadastrar',
//                      'autor'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
//                      'prova'=>$this->input->get_post('prova'),
//                      'curso'=>$this->input->get_post('curso'),
//                      'serie'=>$this->input->get_post('serie'),
//                      'disciplina'=>$this->input->get_post('disc'),
//                  //    'disciplina'=>$this->prova->lista_disciplina()->result(),
//                  //    'curso' => $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'C')),
//                  //    'disciplina'=>$this->prova->dados_disciplina()->result($this->input->post('disc')),
//                   //   'subgrupo'=>$this->prova->carrega_sub_grupo()->result(),
//                    //  'grupo'=>$this->prova->sp_provas(array('operacao'=>'L')),
//                    //  'total'=>$this->correcao->visualiza_prova($this->input->get_post('prova'))->num_rows()
//                    );
//        
//        if($data['total'] == 24){
//            $this->correcao->grava_gabarito($this->input->get_post('prova'));
//        }
        $data = array('titulo'=>'Cadastrar Questão',
                      'subtitulo'=>'Formulário - TODOS OS CAMPOS SÃO OBRIGATÓRIOS',
                      'bt_cor'=>'success',
                      'bt_acao'=>'Cadastrar',
                      'acao'=>'cadastrar',
                      'autor'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                      'prova'=>$this->input->get_post('prova'),
                      'curso'=>$this->input->get_post('curso'),
                      'serie'=>$this->input->get_post('serie'),
                      'disciplina'=>$this->input->get_post('disc'),
                  //    'disciplina'=>$this->prova->lista_disciplina()->result(),
                  //    'curso' => $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'C')),
                  //    'disciplina'=>$this->prova->dados_disciplina()->result($this->input->post('disc')),
                  //    'subgrupo'=>$this->prova->carrega_sub_grupo()->result(),
                  //    'grupo'=>$this->prova->sp_provas(array('operacao'=>'L')),
                      'total'=>$this->correcao->visualiza_prova($this->input->get_post('prova'))->num_rows()
                    );
     
        $this->load->view('provas/cadastrar_questao',$data);
    }
    
    
    function registrar_questao(){
        header ('Content-type: text/html; charset=UTF-8');
        
//        
//          print_r($_POST);exit;
//        
//        $image_data=file_get_contents($_FILES["img"]["tmp_name"]);
//        $encoded_image=base64_encode($image_data);
//        $decoded_image=base64_decode($encoded_image);
//       
//        if($this->input->post('linha') == ""){
//            $linha = 0;
//        }else{
//            $linha = $this->input->post('linha');
//        }
        
//        if($this->input->post('footer') == ""){
//            $rodape = "";
//        }else{
//            $rodape = $this->input->post('footer');
//        }
        //cadastra a questão
        
//        if($this->input->post('footer') == ""){
//            $rodape = "";
//        }else{
//            $rodape = $this->input->post('footer');
//        }
        //cadastra a questão
        $param = array('operacao'=>'I',
                        'cd_disciplina'=>$this->input->post('disc'),
                        'dificuldade'=>  $this->input->post('dificuldade'),
                        'tipo'=>$this->input->post('tipo'),
                        'prova'=>$this->input->post('prova'),
                        'descricao'=>$this->input->post('pergunta'),
                        'resposta'=>$this->input->post('gabarito'),
                        'cd_usuario'=>$this->session->userdata('SCL_SSS_USU_CODIGO'),
                    //    'IMAGEM'=>$decoded_image,
                        'curso'=>$this->input->post('curso'),
                        'serie'=>$this->input->post('serie'),
                        'gabarito'=>'Y'//$this->input->post('gabarito')
                   //     'linhas'=>$linha,
                 //       'rodape'=>$rodape
                      );
        $sucesso = $this->prova->cadastrar_questao($param);
                
        if($sucesso){
            $p = array(
                 'programa' => 'CONTROLLERS - REGISTROU A QUESTOES:: '.$acao .' - '. $this->input->get_post('pergunta'),
                 'sistema' => 'GESTÃO DE PROVAS'
          );
          $this->controle->weblog($p);
          
            $cd = $this->prova->ultima_questao()->result();
             $assunto = $this->input->post('assunto');
            //inseri os subgrupos da questão
            foreach ($assunto as $r) {
                $param = array('cd_questao'=>$cd[0]->CD,
                               'cd_subgrupo'=>$r);
                $this->prova->cadastra_subgrupo($param);
            }
            if($this->input->post('posicao') == "" ){
                $posicao = $this->input->post('posicao1');
            }else{
                $posicao = $this->input->post('posicao');
            }
            //inserir a questao na prova            
            $param_prova = array('cd_prova'=>  $this->input->post('prova'),
                                 'cd_questao'=> $cd[0]->CD,
                                 'posicao'=>  $posicao,//$this->input->post('posicao'),
                                 'valor'=>  0
                                );
            
            $this->prova->cadastra_questao_prova($param_prova);
            
            // atualizar gabarito
            $p = array('prova'=>  $this->input->post('prova'));
            $this->prova->atualizar_gabarito($p);
            
            if($this->input->post('posicao') == "" ){
                $posicao = $this->input->post('posicao1');
            }else{
                $posicao = $this->input->post('posicao');
            }
            //inserir a questao na prova            
            $param_prova = array('cd_prova'=>  $this->input->post('prova'),
                                 'cd_questao'=> $cd[0]->CD,
                                 'posicao'=>  $posicao,//$this->input->post('posicao'),
                                 'valor'=>  0
                                );
            
            $this->prova->cadastra_questao_prova($param_prova);

            set_msg('msgok','Regsitro inserido com sucesso','sucesso');
        }else{
            set_msg('msgerro','Erro ao inserir o registro.','erro');
        }
        //redirect(base_url('provas/questoes/cadastro_questao?p='.$this->input->post('cd_prova').' '), 'refresh');
        redirect(base_url('provas/questoes/cadastro_questao?prova='.$this->input->post('prova').'&curso='.$this->input->post('curso').'&serie='.$this->input->post('serie').'&disc='.$this->input->post('disc').' '), 'refresh');
    }
    
    
    function enviar($arquivo, $cd_questao, $cd_opcao, $cd_usuario,$tipo) {
        
        $caminho = $_SERVER['DOCUMENT_ROOT'] . '/portal/uploads/questao/' . $cd_questao ;
        if(is_dir($caminho)){
            $caminho = $_SERVER['DOCUMENT_ROOT'] . '/portal/uploads/questao/' . $cd_questao ;
        }else{
            mkdir($caminho, 0777);
        }
        
        $data['caminho'] = '' . $caminho;
        $data['diretorio'] = directory_map($data['caminho']);
        $file = "" . $arquivo . "";
        $config['upload_path'] = '' . $caminho;
        $config['allowed_types'] = '*';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($file)) {
            $data['mensagem'] = $this->upload->display_errors();
        } else {
            $dados = $this->upload->data();
            $anexo = $dados['raw_name'] . $dados['file_ext'];
            $tamanho = $dados['file_size'];
            
            //PARAMENTROS DO ARQUIVOS
            $parametro = array('cd_questao'=>$cd_questao,
                                'item'=>$anexo,
                                'cd_opcao'=>$cd_opcao,
                                'cd_usuario'=>$cd_usuario,
                                'tipo'=>$tipo);
             $this->prova->cadastrar_item($parametro);
            
        }
   //     return $data['mensagem'];
    }
    
    function disciplina(){		

        $disciplina = $this->prova->lista_disciplina($this->input->post('prova'))->result();
        $select = '<select name="disc" id="disc" class="form-control">
                      <option value="" selected="selected"> Informe a Disciplina</option>';
        foreach($disciplina as $r){
                $select .= '<option value="'.$r->CD_DISCIPLINA .'">'.$r->NM_DISCIPLINA.'</option>';	
        }
        $select .= '</select>';
        echo ($select);
    }
    
    function lista_subgrupo(){		
        $sub = $this->prova->dados_subgrupo($this->input->post('grupo'))->result();
        if(count($sub)==0){
            echo "aqui";
            $select = ' <select class="form-control input-sm" name="assunto[]" id="assunto" required multiple="">';
            $select .= '<option value="">Não há assunto cadastrado</option>';	
            $select .= '</select>';
            echo ($select);
            
        }else{
            
            $select = ' <select class="form-control input-sm" name="assunto[]" id="assunto" required multiple=""  disabled>';
            foreach($sub as $r){
                    $select .= '<option value="'.$r->CD_SUBGRUPO .'">'.$r->DC_SUBGRUPO.'</option>';	
            }
            $select .= '</select>';
            echo ($select);
        }
    }
    
    
//    function lista_questoes(){
//         $data = array('titulo'=>'Lista de Questões da Provas', 
//                      'listar'=>$this->prova->lista_questoes_prova($_GET['cd_prova'])->result()
//                     );
//        $this->load->view('provas/lista_questao',$data);
//        
//    }
    
    function editar_questoes(){
        
        $p = array(
                 'programa' => 'CONTROLLERS - EDITOU A QUESTOES:: '. $this->input->get('id').'',
                 'sistema' => 'GESTÃO DE PROVAS'
          );
          $this->controle->weblog($p);
        
        
        $cd_questao = $this->input->get('id');
        $dados = $this->prova->dados_questao($cd_questao)->result();
      
        header ('Content-type: text/html; charset=UTF-8');
        $parametro = array(
                        'operacao'=>'S', //MOSTRAR AS SÉRIES FILTRADAS PELOS CAMPOS
                        'curso'=>$dados[0]->CD_CURSO,
                        'serie'=>NULL,
                        'turma'=>NULL,
                        );		
        
        $data = array('titulo'=>'Editar Questão',
                      'curso' => $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'C')),
                      'serie'=>$this->colegio->sp_curso_serie_turma_aluno($parametro),
                      'disciplina'=>$this->prova->lista_disciplina()->result(),
           //           'subgrupo'=>$this->prova->carrega_sub_grupo()->result(),
                      'dados'=>$dados
                );
  
        $this->load->view('provas/editar_questao',$data);
    }
    
    function selecionar_curso_serie(){
        $param = array('operacao'=>'LD','periodo'=>$this->session->userdata('SCL_SSS_USU_PERIODO'));
        $param1 = array('operacao'=>'LP');
        $data = array('titulo'=>'Cadastrar Questão',
                      'subtitulo'=>'Formulário - TODOS OS CAMPOS SÃO OBRIGATÓRIOS',
                      'provas'=>$this->prova->lista_provas()->result(),
                      //'provas'=>$this->prova->sp_questao($param1),
                      //'disciplina'=>$this->prova->lista_disciplina()->result(),
                      'disciplina'=>$this->prova->sp_questao($param),
                      'curso' => $this->colegio->sp_curso_serie_turma_aluno($par = array('operacao' => 'C'))
                    );
        
        
        $this->load->view('provas/cad_inicio',$data);
    }
    
    function registrar_edicao(){
        header ('Content-type: text/html; charset=UTF-8');
    //    print_r($_POST);exit;
        
        $p = array(
                 'programa' => 'CONTROLLERS - EDITOU A QUESTOES | SALVAR :: '. $this->input->get('id').'',
                 'sistema' => 'GESTÃO DE PROVAS'
          );
          $this->controle->weblog($p);
        
        $parametro = array('cd_questao'=>  $this->input->post('cd_questao'),
                           'curso'=>$this->input->post('curso'),
                           'serie'=>$this->input->post('serie'),
                           'disc'=>$this->input->post('disc'),
                           'dificuldade'=>$this->input->post('dificuldade'),
                           'tipo'=>$this->input->post('tipo'),
                           'pergunta'=>$this->input->post('pergunta'),
                           'gabarito'=>'',//$this->input->post('gabarito'),
                           'posicao'=>  $this->input->post('posicao'),
                           'cd_prova'=>  $this->input->post('cd_prova')
                          );
       // print_r($parametro);exit;
        $sucesso = $this->prova->confirmar_edicao($parametro);
        
        if($sucesso){
            $d = array('prova'=>  $this->input->post('cd_prova'));
            $this->prova->atualizar_gabarito($d);
            
            set_msg('msgok','Registro editado com sucesso','sucesso');
        }else{
            set_msg('msgerro','Erro ao editar o registro.','erro');
        }
        
        if($this->input->post('onde') == 'q'){
            redirect(base_url('provas/questoes/'), 'refresh');
        }else{
            redirect(base_url('provas/correcao/lista_questao_prova?cd_prova='.$this->input->post('cd_prova')), 'refresh');
        }
    }
    
    
     function textarea(){
        
        $this->load->view('provas/elfinder',$data);
    }
    
//    function lista_questoes(){
//         $data = array('titulo'=>'Lista de Questões da Provas', 
//                      'listar'=>$this->prova->lista_questoes_prova($_GET['cd_prova'])->result()
//                     );
//        $this->load->view('provas/lista_questao',$data);
//        
//    }
    
    
}

 