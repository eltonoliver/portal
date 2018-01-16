<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 |------------------------------------------------------------------------
 | descrições de perfil de usuario
 |------------------------------------------------------------------------
 */
define('P_ALUNO'        , 'A');
define('P_FUNCIONARIO'  , 'F');
define('P_PROFESSOR'    , 'P');


/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',				'rb');
define('FOPEN_READ_WRITE',			'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',	'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',			'ab');
define('FOPEN_READ_WRITE_CREATE',		'a+b');
define('FOPEN_WRITE_CREATE_STRICT',		'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',	'x+b');


/**
 * Barra de loading
 */

define('modal_load','<div class="progress progress-striped active"><div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="50" style="width:100%"> Carregando Dados</div></div>');
define('LOAD_BAR', '<div class="progress progress-striped progress-active"><div class="progress-bar progress-bar-warning" style="width: 100%;"></div></div>');

/*
|--------------------------------------------------------------------------
| DESCRIÇÕES DE LABEL 
|--------------------------------------------------------------------------
|
*/

define('SCL_DEF_TITULO', 'PORTAL SÉCULO'); // define o título das páginas
define('SCL_SENHA', '#S3cu10!'); // define o título das páginas
define('SCL_RAIZ', 'https://'.$_SERVER['HTTP_HOST'].'/portal/'); // define o título das páginas
define('SCL_UPLOAD', 'https://'.$_SERVER['HTTP_HOST'].'/portal/application/upload'); // define o título das páginas
define('SCL_CSS', 'https://'.$_SERVER['HTTP_HOST'].'/portal/assets/css/'); // define o caminho para as paginas de stylo .css
define('SCL_JS', 'https://'.$_SERVER['HTTP_HOST'].'/portal/assets/js/'); // define o caminho para as paginas javascript .js
define('SCL_IMG', 'https://'.$_SERVER['HTTP_HOST'].'/portal/assets/images/'); // define o caminho para as paginas de images
define('SCL_XML', 'https://'.$_SERVER['HTTP_HOST'].'/portal/application/logs/xml.log'); // define o caminho para a pasta de log
define('SCL_LOG', 'https://'.$_SERVER['HTTP_HOST'].'/portal/application/logs/log.log'); // define o caminho para a pasta de log
define('SCL_SSL', 'https://'.$_SERVER['HTTP_HOST'].'/portal/assets/ssl/'); // define o caminho para a pasta de log

/*
|--------------------------------------------------------------------------
| DESCRIÇÕES BANCÁRIAS
|--------------------------------------------------------------------------
|
*/

define('BLT_EMP', 'CENTRO EDUCACIONAL SÉCULO LTDA');
define('BLT_EMP_END', 'Av. Coronel Teixeira, nº 4371 - Ponta Negra - 69037.000 - MANAUS');
define('BLT_EMP_CID', 'MANAUS/AM');
define('BLT_EMP_CNPJ', '18.621.830/0001-00');

define('VERSAO', "1.1.0"); //10510478600000431001
// PARA USO DA CIELO

define("ENDERECO_BASE", "https://ecommerce.cbmp.com.br");   // PRODUÇÃO 
define("ENDERECO", ENDERECO_BASE."/servicos/ecommwsec.do");
define("SECULO_CIELO", "1051047860");// código da seculo
define("SECULO_CHAVE_CIELO", "dd8b9b4c3fa1ed6594afff1fa2d4473924153eb01a04e4f9f3c873fe44245512");//chave cielo século



