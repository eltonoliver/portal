<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$hook['display_override'][] = array('class' => 'Layout',
									'function' => 'init',
									'filename' => 'Layout.php',
									'filepath' => 'hooks');