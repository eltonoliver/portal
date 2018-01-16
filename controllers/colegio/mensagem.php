<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mensagem extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('mensagem_model', 'mensagem', TRUE);

        $this->load->helper(array('form', 'url', 'html', 'directory', 'file'));
        $this->load->library(array('form_validation', 'session', 'email', 'upload'));

    }

    function enviar_anexo($arquivo) {

        $data['caminho'] = '' . $_SERVER['DOCUMENT_ROOT'] . '/portal/application/upload/mensagem/';
        $data['diretorio'] = directory_map($data['caminho']);
        $file = "" . $arquivo . "";
        $config['upload_path'] = '' . $_SERVER['DOCUMENT_ROOT'] . '/portal/application/upload/mensagem/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '0';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($file)) {
            return NULL;
        } else {
            $dados = $this->upload->data();
            $anexo = $dados['raw_name'] . $dados['file_ext'];
            return $anexo;
        }
    }

    function index() {
            
        $parametro = array( 'operacao'=>'LME',
                            'para' => $this->session->userdata('SCL_SSS_USU_CODIGO'));

        $data = array(
            'titulo' => '<h1> Caixa Postal </h1>',
            'mensagem' => $this->mensagem->mensagem($parametro), // LISTA DE MENSAGEM
        );

        $this->load->view('mensagem/index', $data);
    }
	
	function entrada() {
            
        $parametro = array( 'operacao'=>'LME',
                            'para' => $this->session->userdata('SCL_SSS_USU_CODIGO'));
 
        $data = array(
            'titulo' => 'Caixa de Entrada',
            'mensagem' => $this->mensagem->mensagem($parametro), // LISTA DE MENSAGEM
        );

        echo  $this->load->view('mensagem/listar', $data, true);
    }
    
    function saida() {
            
        $parametro = array( 'operacao'=>'LME',
                            'para' => $this->session->userdata('SCL_SSS_USU_CODIGO'));
 
        $data = array(
            'titulo' => 'Caixa de Saída',
            'mensagem' => $this->mensagem->mensagem($parametro), // LISTA DE MENSAGEM
        );

        echo  $this->load->view('mensagem/listar', $data, true);
    }
    
    function lixeira() {
            
        $parametro = array( 'operacao'=>'LME',
                            'para' => $this->session->userdata('SCL_SSS_USU_CODIGO'));
 
        $data = array(
            'titulo' => 'Lixeira',
            'mensagem' => $this->mensagem->mensagem($parametro), // LISTA DE MENSAGEM
        );

        echo $this->load->view('mensagem/listar', $data, true);
    }
    

    function responsavel() {

        $tipo = $this->session->userdata('SCL_SSS_USU_TIPO');
        switch ($tipo) {
            // CRIA A MENSAGEM PARA O ALUNO
            case 10:$para = $this->session->userdata('SCL_SSS_USU_ID');
                break;
            // CRIA A MENSAGEM PARA O PROFESSOR
            case 20:$para = $this->session->userdata('SCL_SSS_USU_ID');
                break;
            // CRIA A MENSAGEM PARA O RESPONSAVEL
            case 30:$para = $this->session->userdata('SCL_SSS_USU_CODIGO');
                break;
            // CRIA A MENSAGEM PARA O COLABORADOR
            case 40:$para = $this->session->userdata('SCL_SSS_USU_CODIGO');
                break;
        }

        $data = array(
            'titulo' => '<h1> Caixa Postal <i class="icon-double-angle-right"></i> Caixa de Entrada </h1>',
            'navegacao' => 'Caixa Postal > Caixa de Entrada',
            // CRIA A LISTA DE MENSAGENS DE ENTRADA
            'mensagem' => $this->mensagem->entrada(1, $para, 0),
            // CRIA A VARIÁVEL DE TOTAL DE MENSAGENS DE ENTRADA 
            'tentrada' => $this->mensagem->entrada(2, $para, 0),
            // CRIA A VARIÁVEL DE TOTAL DE MENSAGENS DE SAÍDA 
            'tsaida' => $this->mensagem->saida(2, 0),
            // CRIA A VARIÁVEL TIPO DE MENSAGEM 
            'tipo' => 0
        );

        $this->load->view('colegio/mensagem/index', $data);
    }

    function escrever() {

        $tipo = $this->session->userdata('SCL_SSS_USU_TIPO');

        $data['listargrupo'] = $this->mensagem->grupo($tipo);

        $data['titulo'] = '<h1 style="text-transform:capitalize"> Caixa Postal <i class="icon-double-angle-right"></i> Escrever Mensagem </h1>';
        $data['navegacao'] = 'Caixa Postal > Escrever Mensagem';

        $this->load->view('colegio/mensagem/form', $data);
    }

    function enviar() {
        $tipo = $this->session->userdata('SCL_SSS_USU_TIPO');

        $this->form_validation->set_rules('sclassunto', 'Assunto', 'required');
        $this->form_validation->set_rules('sclmsg', 'Mensagem', 'required');
        $this->form_validation->set_rules('destino', 'Destinatário', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['titulo'] = '<h1 style="text-transform:capitalize"> Caixa Postal <i class="icon-double-angle-right"></i> Escrever Mensagem </h1>';
            $data['navegacao'] = 'Caixa Postal > Escrever Mensagem';

            $data['listargrupo'] = $this->mensagem->grupo($tipo);
            $this->load->view('colegio/mensagem/form', $data);
        } else {
            switch ($tipo) {
                // CRIA A MENSAGEM PARA O ALUNO
                case 10:$de = $this->session->userdata('SCL_SSS_USU_ID');
                    break;
                // CRIA A MENSAGEM PARA O PROFESSOR
                case 20:$de = $this->session->userdata('SCL_SSS_USU_CODIGO');
                    break;
                // CRIA A MENSAGEM PARA O RESPONSAVEL
                case 30:$de = $this->session->userdata('SCL_SSS_USU_ID');
                    break;
                // CRIA A MENSAGEM PARA O COLABORADOR
                case 40:$de = $this->session->userdata('SCL_SSS_USU_CODIGO');
                    break;
            }
            $assunto = $this->input->get_post('sclassunto');
            $destino = $this->input->get_post('destino');

            $mensagem = $this->input->get_post('sclmsg');
            $palavra = $this->secretaria->palavra_restrita();

            // VERIFICAR SE HÁ ALGUMA PALAVRA RESTRITA NA MENSAGEM
            foreach ($palavra as $item) {
                $palavra = $item->NM_PALAVRA;
                $verificar_assunto = strripos($assunto, $palavra);
                $verificar_mensagem = strripos($mensagem, $palavra);

                if ($verificar_assunto == false && $verificar_mensagem == false) {
                    $spam = 0;
                } else {
                    $spam = 1;
                }
            }

            $anexo = $this->enviar_anexo('arquivo'); //* INICIO DO ENVIO DE ANEXO */
            echo "anexo: " . $anexo;
            $this->mensagem->enviar($de, $destino, $assunto, $mensagem, $spam, $anexo);

            redirect(base_url('/index.php/colegio/mensagem'), 'refresh');
        }
    }

    function visualizar() {

        $codigo = $this->input->get_post('codigo');
        $data['tipo'] = $this->input->get_post('tipo');
        $mensagem = $this->mensagem->visualizar_mensagem($codigo);

        foreach ($mensagem as $l) {
            $data['assunto'] = $l->SUBJECT;
            $data['codigo'] = $l->ID;
            $data['de'] = $l->DE;
            $data['aluno'] = $l->ALUNO;
            $data['professor'] = $l->PROFESSOR;
            $data['colaborador'] = $l->COLABORADOR;
            $data['responsavel'] = $l->RESPONSAVEL;
            $data['mensagem'] = $l->CONTENT;
            $data['lixeira'] = $l->TRASH;
            $data['anexo'] = $l->ANEXO;
            $data['span'] = $l->SPAM;
            $data['idpai'] = $l->ID_PAI;
        }

        $data['pessoa'] = $this->mensagem->visualizar_pessoa($codigo);
        $this->load->view('colegio/mensagem/visualizar', $data);
    }

    function filho() {

        $tipo = $this->session->userdata('SCL_SSS_USU_TIPO');
        $para = $this->input->get_post('matricula');
        $filho = $this->input->get_post('filho');
        $responsavel = $para = $this->session->userdata('SCL_SSS_USU_ID');

        $data = array(
            'titulo' => '<h1 style="text-transform:capitalize"> Caixa Postal <i class="icon-double-angle-right"></i> Caixa de Entrada <i class="icon-double-angle-right"></i> ' . ucfirst(strtolower(strtoupper($filho))) . '</h1>',
            'navegacao' => 'Caixa Postal > Caixa de Entrada',
            // CRIA A LISTA DE MENSAGENS DE ENTRADA
            'mensagem' => $this->mensagem->entrada(1, $para, 0),
            // CRIA A VARIÁVEL DE TOTAL DE MENSAGENS DE ENTRADA 
            'tentrada' => $this->mensagem->entrada(2, $para, 0),
            // CRIA A VARIÁVEL DE TOTAL DE MENSAGENS DE SAÍDA 
            'tsaida' => $this->mensagem->saida(2, 0),
            // CRIA A VARIÁVEL TIPO DE MENSAGEM 
            'tipo' => 0,
            'matricula' => $this->input->get_post('matricula'),
            'filho' => $this->input->get_post('filho')
        );

        $this->load->view('colegio/mensagem/filho', $data);
    }

    function filho_saida() {

        $tipo = $this->session->userdata('SCL_SSS_USU_TIPO');
        $de = $this->input->get_post('matricula');
        $filho = $this->input->get_post('filho');
        $responsavel = $para = $this->session->userdata('SCL_SSS_USU_ID');

        $data = array(
            'titulo' => '<h1 style="text-transform:capitalize"> Caixa Postal <i class="icon-double-angle-right"></i> Caixa de Saída <i class="icon-double-angle-right"></i> ' . ucfirst(strtolower(strtoupper($filho))) . '</h1>',
            'navegacao' => 'Caixa Postal > Caixa de Saída',
            // CRIA A LISTA DE MENSAGENS DE ENTRADA
            'tentrada' => $this->mensagem->entrada(2, $de, 0),
            // CRIA A VARIÁVEL DE TOTAL DE MENSAGENS DE ENTRADA 
            'mensagem' => $this->mensagem->saida(1, $de),
            // CRIA A VARIÁVEL DE TOTAL DE MENSAGENS DE SAÍDA 
            'tsaida' => $this->mensagem->saida(2, $de),
            // CRIA A VARIÁVEL TIPO DE MENSAGEM 
            'tipo' => 1,
            'matricula' => $this->input->get_post('matricula'),
            'filho' => $this->input->get_post('filho')
        );
        $this->load->view('colegio/mensagem/filho', $data);
    }

    function filho_lixeira() {

        $tipo = $this->session->userdata('SCL_SSS_USU_TIPO');
        $de = $this->input->get_post('matricula');
        $filho = $this->input->get_post('filho');
        $responsavel = $para = $this->session->userdata('SCL_SSS_USU_ID');

        $data = array(
            'titulo' => '<h1 style="text-transform:capitalize"> Caixa Postal <i class="icon-double-angle-right"></i> Lixeira <i class="icon-double-angle-right"></i> ' . ucfirst(strtolower(strtoupper($filho))) . '</h1>',
            'navegacao' => 'Caixa Postal > Lixeira',
            // CRIA A LISTA DE MENSAGENS DE ENTRADA
            'tentrada' => $this->mensagem->entrada(2, $de, 0),
            // CRIA A VARIÁVEL DE TOTAL DE MENSAGENS DE ENTRADA 
            'mensagem' => $this->mensagem->saida(1, $de),
            // CRIA A VARIÁVEL DE TOTAL DE MENSAGENS DE SAÍDA 
            'tsaida' => $this->mensagem->saida(2, $de),
            // CRIA A VARIÁVEL TIPO DE MENSAGEM 
            'tipo' => 2,
            'matricula' => $this->input->get_post('matricula'),
            'filho' => $this->input->get_post('filho')
        );
        $this->load->view('colegio/mensagem/filho', $data);
    }

    function envio_email_aviso($email) {

        $this->email->from('no-replay@seculomanaus.com.br', 'Século Centro Educacional');
        $this->email->to($email);
        //$this->email->bcc('silvio.souza@seculomanaus.com.br');
        $this->email->subject('Aviso de Nova Mensagem');
        $this->email->message('<style type="text/css">
.ExternalClass {
	width: 100%
}
body {
	background-color: #0078A2;
}
@charset "utf-8";
</style>
<center>
  <table   bgcolor="#f3f3f3" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr  >
        <td   align="center" bgcolor="#0078A2" valign="top">&nbsp;</td>
      </tr>
      <tr  >
        <td   align="center" bgcolor="#0078A2" valign="top"><table   bgcolor="#f3f3f3" border="0" cellpadding="0" cellspacing="0" width="596">
            <tbody>
              <tr  >
                <td   align="center" bgcolor="#ff9100" height="1" valign="top"><img    alt="transp" border="0" height="1" src="http://images.iagentemail.com.br/uploads/iagentemkt/image/promo/transp.gif" style="display:block" width="100"></td>
              </tr>
              <tr  >
                <td   align="left" bgcolor="#FF9100" height="125" valign="top"><table   border="0" cellpadding="0" cellspacing="0" width="596">
                    <tbody>
                      <tr  >
                        <td   align="left" height="125" valign="top"><table   border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                              <tr  >
                                <td   align="center" bgcolor="#E96206" valign="middle" width="232"><img    alt="" height="49" src="http://seculomanaus.com.br/wp-content/themes/secmanaus/imagens/img-04.png" style="display: block; border-width: 0px; border-style: solid;;;" width="161"></td>
                                <td width="195" height="70"   align="left" valign="top" bgcolor="#E96206"></td>
                              </tr>
                              <tr  >
                                <td   align="left" bgcolor="#ff9100" valign="top"></td>
                                <td   align="left" bgcolor="#ff9100" valign="top"></td>
                              </tr>
                            </tbody>
                          </table></td>
                        <td   align="left" height="125" valign="top" width="119"><img    alt="Vitor Comercial IAGENTE" height="125" src="http://201.90.148.130/seculo/assets/images/foto-teclado-laranja.jpg" style="display: block; border-width: 0px; border-style: solid;;;" width="119"></td>
                        <td   align="right" height="125" valign="top" width="50"><table   border="0" cellpadding="0" cellspacing="0" width="50">
                            <tbody>
                              <tr  >
                                <td height="70"   align="left" valign="top" bgcolor="#E96206">&nbsp;</td>
                              </tr>
                              <tr  >
                                <td   align="left" bgcolor="#ff9100" valign="top">&nbsp;</td>
                              </tr>
                            </tbody>
                          </table></td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
              <tr  >
                <td height="40"   align="left" valign="top" bgcolor="#ff9100" style="background-color: #ff9100">&nbsp;</td>
              </tr>
              <tr  >
                <td   align="center" bgcolor="#ff9100" valign="top"><img alt="Conta desativada" height="148" src="http://201.90.148.130/seculo/assets/images/icone-conta-teste-expirando.jpg" style="display: block; border-width: 0px; border-style: solid;;;" width="169"></td>
              </tr>
              <tr  >
                <td   align="center" bgcolor="#ff9100" valign="top"></td>
              </tr>
              <tr  >
                <td   align="center" bgcolor="#ff9100" style="font-family:Tahoma, Geneva, sans-serif; font-size:32px; color:#ffffff; font-weight:bold" valign="top">NOVA MENSAGEM</td>
              </tr>
              <tr  >
                <td   align="center" bgcolor="#ff9100" valign="top"></td>
              </tr>
              <tr  >
                <td   align="center" bgcolor="#ff9100" style="font-family:Tahoma, Geneva, sans-serif; font-size:18px; color:#bb3112" valign="middle">H&aacute; uma nova mensagem para voc&ecirc; no Portal Educacional</td>
              </tr>
              <tr  >
                <td   align="center" bgcolor="#ff9100" valign="middle"><table   border="0" cellpadding="0" cellspacing="0" width="95%">
                    <tbody>
                      <tr  >
                        <td height="50"   align="left" valign="top" style="font-family:Tahoma, Geneva, sans-serif; font-size:14px; color:#bb3112;">&nbsp;</td>
                      </tr>
                      <tr  >
                        <td   align="center" style="font-family:Tahoma, Geneva, sans-serif; font-size:14px; color:#bb3112;" valign="top"><a   href="http://www/seculomanaus.com.br/portal" target="_blank" title="Solicite nova proposta">
                         <img    alt="Solicite nova proposta" border="0" height="37" src="http://201.90.148.130/seculo/assets/images/bt.gif" style="display:block" width="272"></a></td>
                      </tr>
                      <tr  >
                        <td   align="left" style="font-family:Tahoma, Geneva, sans-serif; font-size:14px; color:#bb3112;" valign="top">&nbsp;</td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
              <tr  >
                <td height="60"   align="center" valign="middle" bgcolor="#ff9100">&nbsp;</td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      <tr  >
        <td   align="center" bgcolor="#0078A2" valign="top">&nbsp;</td>
      </tr>
    </tbody>
  </table>
</center>
      </td>
  </tr>
</table>
');
        $this->email->send();
        //$this->email->print_debugger();
    }

    function resposta_rapida() {

        $tipo = $this->session->userdata('SCL_SSS_USU_TIPO');
        switch ($tipo) {
            // CRIA A MENSAGEM PARA O ALUNO
            case 10:$de = $this->session->userdata('SCL_SSS_USU_ID');
                break;
            // CRIA A MENSAGEM PARA O PROFESSOR
            case 20:$de = $this->session->userdata('SCL_SSS_USU_CODIGO');
                break;
            // CRIA A MENSAGEM PARA O RESPONSAVEL
            case 30:$de = $this->session->userdata('SCL_SSS_USU_ID');
                break;
            // CRIA A MENSAGEM PARA O COLABORADOR
            case 40:$de = $this->session->userdata('SCL_SSS_USU_CODIGO');
                break;
        }

        $para = $this->input->get_post('sclpara');
        $assunto = $this->input->get_post('sclassunto');
        $mensagem = $this->input->get_post('sclmsg');
        $pai = $this->input->get_post('sclmsgpai');

        $palavra = $this->secretaria->palavra_restrita();

        // VERIFICAR SE HÁ ALGUMA PALAVRA RESTRITA NA MENSAGEM
        foreach ($palavra as $item) {
            $palavra = $item->NM_PALAVRA;
            $verificar_mensagem = strripos($mensagem, $palavra);
            if ($verificar_assunto == false && $verificar_mensagem == false) {
                $spam = 0;
            } else {
                $spam = 1;
            }
        }

        $anexo = $this->enviar_anexo('arquivo');
        $this->mensagem->enviar_rapida($de, $para, $assunto, $mensagem, $spam, $anexo, $pai);
        redirect(base_url('/index.php/colegio/mensagem'), 'refresh');
    }

    function grupo_listar() {

        $tipo = $this->input->post('grupo');
        if (strlen($tipo) == 1) {
            switch ($tipo) {
                // RETORNA LISTA DE TURMAS
                case 1:
                    echo $this->mensagem->aluno();
                    break;
                // RETORNA LISTA DE PROFESSORES
                case 2:
                    echo $this->mensagem->professor();
                    break;
                // RETORNA A LISTA DE COLABORADORES
                case 3:
                    echo $this->mensagem->colaborador_curso();
                    break;
                // RETORNA DE PROFESSORES
                case 4:
                    echo $this->mensagem->grupo_turma('ALU');
                    break;
                // RETORNA DE PROFESSORES
                case 5:
                    echo $this->mensagem->meus_professores($this->session->userdata('SCL_SSS_USU_TURMA'));
                    break;
                // RETORNA DE PROFESSORES
                case 6:
                    echo $this->mensagem->grupo_turma_professor($this->session->userdata('SCL_SSS_USU_CODIGO'));
                    break;
                // RETORNA DE TURMAS COM CODIGOS DOS PAIS
                case 7:
                    echo $this->mensagem->grupo_turma('RES');
                    break;
            }
        } else {
            $item = explode(':', $tipo);
            echo $this->mensagem->grupo_listar($item[1], $item[0]);
        }
    }

}