<div class="main-container" id="main-container">
<div class="main-container-inner">
<a class="menu-toggler" id="menu-toggler" href="#"> <span class="menu-text"></span> </a>
<div class="sidebar" id="sidebar"> 
  <div class="sidebar-shortcuts" id="sidebar-shortcuts">
    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
      <button class="btn btn-success"> <i class="icon-signal"></i> </button>
      <button class="btn btn-info"> <i class="icon-pencil"></i> </button>
      <button class="btn btn-warning"> <i class="icon-group"></i> </button>
      <button class="btn btn-danger"> <i class="icon-cogs"></i> </button>
    </div>
    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini"> 
    	<span class="btn btn-success"></span> 
        <span class="btn btn-info"></span> 
        <span class="btn btn-warning"></span> 
        <span class="btn btn-danger"></span> 
    </div>
  </div>

  <!-- #sidebar-shortcuts -->
  
  <?php
    if($this->session->userdata('SCL_SSS_USU_LOGIN') == ''){
        redirect(base_url('acesso/usuario/logout'), 'refresh');
    }
    $this->load->library('sclmenu');
    $menu = new sclMenuProfessor;
    echo $menu->show_menu();
    
   ?>
  <!-- /.nav-list -->
  
  <div class="sidebar-collapse" id="sidebar-collapse"> 
  	<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i> 
  </div>
</div>
<div class="main-content">
<div class="breadcrumbs" id="breadcrumbs"> 
  <ul class="breadcrumb">
    <li> <i class="icon-home home-icon"></i> <a href="#">Home</a> </li>
    <li class="active">Portal Educacional Século</li>
  </ul>
  <!-- .breadcrumb -->
  
  <div class="nav-search" id="nav-search">
    <form class="form-search">
      <span class="input-icon">
      <input type="text" placeholder="Pesquisar ..." class="nav-search-input" id="pesquisar" autocomplete="off">
      <i class="icon-search nav-search-icon"></i> </span>
    </form>
  </div>
  <!-- #nav-search --> 
</div>
