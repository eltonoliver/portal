<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class sclMenu {

    public $tipo;

    function icon($tipo) {

        switch ($tipo) {
            case 'Biblioteca': $icon = 'dashboard';
                break;
            case 'Mensagem': $icon = 'envelope';
                break;
            case 'Diário de Classe': $icon = 'group';
                break;
            case 'Recursos Humanos': $icon = 'group';
                break;
            case 'Área do Professor': $icon = 'briefcase';
                break;
            case 'Século': $icon = 'globe';
                break;
            case 'Coordenador': $icon = 'globe';
                break;
            case 'CAPS': $icon = 'lock';
                break;
            case 'Coordenação': $icon = 'user';
                break;
            case 'WJR': $icon = 'bar-chart-o';
                break;
            case 'Enfermaria': $icon = 'stethoscope';
                break;
            case 'Gestor de Projetos': $icon = 'sitemap';
                break;
            case 'Jornal': $icon = 'globe';
                break;
        }
        return($icon);
    }

    public function show_menu($tipo) {
        $obj = & get_instance();
        $obj->load->helper('url');
        $obj->load->library('session');

        //--------------
        // CRIA O MENU
        $menu = '<li class="">' . anchor('inicio', '<b class="icon-cover"></b><i class="fa fa-home fa-fw"></i> Início ') . '</li>';


        // VISÃO DO ALUNO
        if ($tipo == 10) {

            $menu .= '<li class="" >' . anchor('mensagem', '<b class="icon-cover"></b><i class="fa fa-envelope fa-fw"></i>Mensagem ', '', '</li>');
            $menu .= '<li class="" >' . anchor('secretaria/academico/agenda', '<b class="icon-cover"></b><i class="fa fa-book fa-fw"></i>Agenda ', '', '</li>');
            $menu .= '<li class="" >' . anchor('secretaria/academico/tempo', '<b class="icon-cover"></b><i class="fa fa-clock-o fa-fw"></i>Tempos ', '', '</li>');
            $menu .= '<li class="" >' . anchor('secretaria/academico/boletim', '<b class="icon-cover"></b><i class="fa fa-file-text fa-fw"></i>Boletim ', '', '</li>');
      //      $menu .= '<li class="" >' . anchor('secretaria/academico/ocorrencia', '<b class="icon-cover"></b><i class="fa fa-envelope fa-fw"></i>Ocorrências ', '', '</li>');
            $menu .= '<li class="" >' . anchor('secretaria/academico/disciplina', '<b class="icon-cover"></b><i class="fa fa-users fa-fw"></i>Meus Professores ', '', '</li>');
            $menu .= '<li class="" >' . anchor('provas/gabarito/prova_impressa', '<b class="icon-cover"></b><i class="fa fa-edit fa-fw"></i>Gabaritos ', '', '</li>');
            $menu .= '<li class="" >' . anchor('provas/gabarito/prova_online', '<b class="icon-cover"></b><i class="fa fa-check-square-o fa-fw"></i>Gabaritos Prova Online ', '', '</li>');
      //      $menu .= '<li class="" >' . anchor('biblioteca', '<b class="icon-cover"></b><i class="fa fa-envelope fa-fw"></i>Biblioteca ', '', '</li>');

            // VISÃO DO RESPONSAVEVL
        } elseif ($tipo == 20) {

            $menu .= '<li class="" >' . anchor('mensagem', '<b class="icon-cover"></b><i class="fa fa-envelope fa-fw"></i>Mensagem ', '', '</li>');
            $menu .= '<li class="" >' . anchor('acompanhamento', '<b class="icon-cover"></b><i class="fa fa-group fa-fw"></i>Acompanhamento ', '', '</li>');
            
            // MENU SECRÉTARIA * INICIO
            $menu .= '<li>' . anchor('#Secretaria', '<b class="icon-cover"></b><i class="fa fa-envelope fa-fw"></i>Secretaria <i class="fa fa-angle-down pull-right"></i>', 'class="collapse" data-toggle="collapse" data-parent="pages-app"');
            $menu .= '<ul class="panel-collapse collapse list-unstyled" role="menu" id="Secretaria">';
            //$menu .= '<li class="">' . anchor('colegio/contrato', '<b class="icon-cover"></b><i class="fa fa-envelope fa-fw"></i> Contratos ') . '</li>';
            $menu .= '<li class="hover">'.anchor('secretaria/declaracao','  Declarações ').'</li>';
            $menu .= '<li class="hover">'.anchor('secretaria/documento','  Documentos Pendentes ').'</li>';
            $menu .= "</ul>";
            $menu .= '</li>';
            
            // MENU ENFERMARIA
           /* $menu .= '<li>' . anchor('#Enfermaria', '<b class="icon-cover"></b><i class="fa fa-medkit fa-fw"></i> Enfermaria <i class="fa fa-angle-down pull-right"></i>', 'class="collapse" data-toggle="collapse" data-parent="pages-app"');
            $menu .= '<ul class="panel-collapse collapse list-unstyled" role="menu" id="Enfermaria">';
            $menu .= '<li class="hover">'.anchor('medico/aluno','  Tratamento ').'</li>';
            $menu .= "</ul>";
            $menu .= '</li>';
            */
            // MENU FINANCEIRO * INICIO
            $menu .= '<li>' . anchor('#Financeiro', '<b class="icon-cover"></b><i class="fa fa-money fa-fw"></i>Financeiro <i class="fa fa-angle-down pull-right"></i>', 'class="collapse" data-toggle="collapse" data-parent="pages-app"');
            $menu .= '<ul class="panel-collapse collapse list-unstyled" role="menu" id="Financeiro">';
            $menu .= '<li>' . anchor('financeiro/boleto', '<b class="icon-cover"></b> Titulos ') . '</li>';
            $menu .= '<li>' . anchor('financeiro/credito', '<b class="icon-cover"></b> Crédito para Aluno') . '</li>';
            $menu .= "</ul>";
            $menu .= '</li>';


            // VISÃO DO FUNCIONARIO 
        } elseif ($tipo == 30 || $tipo == 40) {

            $obj->load->model('seguranca/permissao_model', 'permissao', TRUE);
            $permissao = $obj->permissao->permissao_sistema();

            $i = 0;
            foreach ($permissao as $row) {
                
                $item = explode(' - ', $row->NM_PROGRAMA);
                
                $input[$i] = $item[0];
                
                if (!empty($item[1]))
                    
                    $mnu[$i] = $item[1];
                
                $i = $i + 1;
            }
            $topico = array_keys(array_flip($input));

            foreach ($topico as $row) {
                $item = explode(' - ', $row->NM_PROGRAMA);

                $menu .= '<li>' . anchor('#' . str_replace(' ','',$row) . '', '<b class="icon-cover"></b><i class="fa fa-' . $this->icon($row) . '"></i> ' . $row . ' <i class="fa fa-angle-down pull-right"></i>', 'class="collapse" data-toggle="collapse" data-parent="pages-app"');
                $j = 0;
                $menu .= '<ul class="panel-collapse collapse list-unstyled" role="menu" id="' . str_replace(' ','',$row) . '">';
                foreach ($permissao as $l) {
                    $parte = explode(' - ', $l->NM_PROGRAMA);
                    $item[$j] = $parte[0];
                    $mnu[$j] = $parte[1];
                    if ($row == $item[$j]) {
                        $menu .= '<li>' . anchor('' . $l->FORMULARIO . '', '' . $mnu[$j] . '','');
                    }
                    $j = $j + 1;
                }
                $menu .= '</ul>';
                $menu .= '</li>';
            }
        }

        $menu .= '<li>' . anchor('restrito/logout', '<i class="menu-icon fa fa-sign-out"></i> <span class="menu-text"> Sair do Sistema  </span>') . '</li>';


        return $menu;
    }

}

?>