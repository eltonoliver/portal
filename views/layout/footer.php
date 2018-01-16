	</section>
</div>
<aside class="col-md-2 col-md-pull-10 col-sm-3 col-sm-pull-9">
  <div id="sidebar">
    <div class="panel panel-default panel-user panel-no-padding hidden-sm hidden-xs">
      <div class="panel-heading">
        <div class="panel-title">
          <div class="media">
           	<a class="pull-left">
                    <?php if($this->session->userdata('SCL_SSS_USU_TIPO') < 25) $img = $this->session->userdata('SCL_SSS_USU_CODIGO'); else $img =  $this->session->userdata('SCL_SSS_USU_RHCODIGO');?>
                    <img src="<?='https://www.seculomanaus.com.br/academico/usuarios/foto?codigo='.$img.''?>" class="media-object">
                </a>
            <div class="media-body">
              <h5 class="media-heading"><span class="welcome">Bem Vindo</span><span><?=$this->session->userdata('SCL_SSS_USU_NOME')?></span></h5>
            </div>
          </div>
        </div>
      </div>
      <div class="panel-body align-center">
        <ul class="list-unstyled list-inline list-user-app">
          <!--li>
          	<a title="Task List" data-placement="bottom" data-toggle="tooltip" href="tasks.html">
            	<i class="fa fa-list"></i>
                <span class="text">Task List</span>
                <span class="pull-right badge badge-danger">12</span>
            </a>
          </li-->

<!--          <li>
          	<a title="Preferences" data-placement="bottom" data-toggle="tooltip" href="settings.html">
            	<i class="fa fa-gear"></i>
                <span class="text">Perfil</span>
            </a>
          </li>-->
          <li>
              <a title="Mensagem" data-placement="bottom" data-toggle="tooltip" href="<?=  base_url()?>mensagem">
            	<i class="fa fa-envelope"></i>
                <span class="text">Mensagem</span>
            </a>
          </li>
          <li>
              <a title="Mudar Senha" data-placement="bottom" data-toggle="tooltip" href="<?=base_url()?>inicio/trocar_senha">
            	<i class="fa fa-key"></i>
                <span class="text">Mudar Senha</span>
            </a>
          </li>
          <li>
              <a title="Sair do Sistema" data-placement="bottom" data-toggle="tooltip" href="<?=base_url()?>restrito/logout">
                  <i class="fa fa-signout"></i><span class="text">Sair do Sistema</span>
              </a>
          </li>
        </ul>
      </div>
    </div>
    
    <div class="panel-group" id="app-menu">
      <div class="panel panel-default panel-no-padding">
        <div class="panel-heading">
          <h4 class="panel-title"><a data-toggle="collapse" data-parent="#app-menu" href="#menu-app"> Meu Século </a></h4>
          <div class="panel-toolbar"><a data-toggle="collapse" data-parent="#app-menu" href="#menu-app"><i class="fa fa-angle-down pull-right collapse-trigger"></i></a></div>
        </div>
        <div id="menu-app" class="panel-collapse collapse in">
          <div class="panel-body">
            <ul class="nav nav-pills nav-stacked" id="pages-app">
                <?php
                if($this->session->userdata('SCL_SSS_USU_TIPO') == ''){
                    redirect(base_url('restrito/logout'), 'refresh');
                }
                $this->load->library('sclmenu');
                $menu = new sclMenu;
                echo $menu->show_menu($this->session->userdata('SCL_SSS_USU_TIPO'));
                
                ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</aside>
</div>
</div>


<footer id="footer">
  <div class="container">
    <div class="row">
      <div class="col-xs-6">
        <ul class="list-inline">
          <li>&copy; <a>Portal Educacional - Século</a></li>
        </ul>
      </div>
      <div class="col-xs-6">
        <ul class="list-inline social-network">
          <li><a href="https://www.facebook.com/seculomanaus" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
          <li><a href="#"><i class="fa fa-twitter-square"></i></a></li>
          <li><a href="#"><i class="fa fa-linkedin-square"></i></a></li>
          <li><a href="#"><i class="fa fa-github-square"></i></a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
</body>
</html>
<? exit();?>
