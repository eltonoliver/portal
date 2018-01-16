<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width = device-width, initial-scale = 1.0, minimum-scale = 1.0, maximum-scale = 1.0, user-scalable = no"/>
        <meta name="description" content="Sistema Acadêmico Século">
        <title><?= SCL_DEF_TITULO ?></title>
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,300,700">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900,200italic,300italic,400italic,600italic,700italic,900italic">
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic">

        <link href="<?= SCL_CSS ?>bootstrap.min.css?v=3.1.0" rel="stylesheet" />
        <link href="<?= SCL_CSS ?>font-awesome.min.css?v=4.0.3" rel="stylesheet" />
        <link href="<?= SCL_CSS ?>style1.css?v=1.0" rel="stylesheet" />
        <link href="<?= SCL_CSS ?>style.css" rel="stylesheet" type="text/css" />
        <link href="<?= SCL_CSS ?>chosen.css" rel="stylesheet" type="text/css" />
        <link href="<?= SCL_CSS ?>bootstrap-select.min.css" rel="stylesheet" type="text/css">

        <script src="<?= SCL_JS ?>jquery-1.11.0.min.js"></script> 
        <script src="<?= SCL_JS ?>bootstrap.min.js"></script> 
        <script src="<?= SCL_JS ?>chosen.jquery.min.js"></script> 

        <script src="<?= SCL_JS ?>jquery.sparkline.min.js"></script> 

        <link href="<?= SCL_CSS ?>footable.standalone.css" rel="stylesheet" type="text/css"/>
        <script>
            if (!window.jQuery) {
                document.write('<script src="<?= SCL_JS ?>jquery-1.9.1.min.js"><\/script>');
            }
        </script>
        <!--[if IE 7]>
            <link rel="stylesheet" href="<?=SCL_CSS?>font-awesome-ie7.min.css" />
        <![endif]-->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="<?= SCL_JS ?>html5shiv.js"></script>
        <script src="<?= SCL_JS ?>respond.min.js"></script>
        <![endif]-->
        <script src="<?= SCL_JS ?>footable.js?v=2-0-1" type="text/javascript"></script>
        <script src="<?= SCL_JS ?>footable.sort.js?v=2-0-1" type="text/javascript"></script>
        <script src="<?= SCL_JS ?>footable.filter.js?v=2-0-1" type="text/javascript"></script>
        <script src="<?= SCL_JS ?>footable.paginate.js?v=2-0-1" type="text/javascript"></script>

        <script src="<?= SCL_JS ?>bootstrap-datepicker.min.js"></script> 
        <script src="<?= SCL_JS ?>daterangepicker.min.js"></script> 
        <link rel="stylesheet" type="text/css"  href="<?= SCL_CSS ?>bootstrap-datapicker.css">

        <script src="<?= SCL_JS ?>bootstrap-tab.js" type="text/javascript"></script>
        <script src="<?= SCL_JS ?>bootstrap-select.min.js" type="text/javascript"></script>
        <script src="<?= SCL_JS ?>bootstrap-switch.min.js?v=3.0.0"></script>
        <script src="<?= SCL_JS ?>bootstrap-filestyle.js"></script>
        <script src="<?= SCL_JS ?>summernote.min.js"></script>

        <script src="<?= SCL_JS ?>jquery.dataTables.min.js"></script>
        <script src="<?= SCL_JS ?>jquery.dataTables.bootstrap.js"></script>

        <style type="text/css">
            .jqstooltip { 
                position: absolute;
                left: 0px;
                top: 0px;
                visibility: hidden;
                background: rgb(0, 0, 0) transparent;
                background-color: rgba(0,0,0,0.6);
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);
                -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";
                color: white;
                font: 10px arial, san serif;
                text-align: left;
                white-space: nowrap;
                padding: 5px;
                border: 1px solid white;
                z-index: 10000;
            }
            .jqsfield { 
                color: white;
                font: 10px arial, san serif;
                text-align: left;
            }
 
            a{
                text-decoration:none;
            }
            a:hover{
                text-decoration:none;
            }
            a:focus{
                text-decoration:none;
            }

        </style>




        <script src="<?= SCL_JS ?>demos.js" type="text/javascript"></script>


    </head>
    <body>

        <nav class="navbar navbar-fixed-top" role="navigation" id="mainnav">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-nav">
                    <span class="sr-only">Navegação</span><i class="fa fa-list"></i>
                </button>
                <span class="navbar-brand"><b class="icon-cover"></b><span><img src="<?= SCL_IMG ?>simbolo.png"> Portal Educacional </span></span>
            </div>
            <div class="collapse navbar-collapse" id="top-nav">
                <ul class="nav navbar-nav navbar-left">
                    <li class="active"><a href="<?= SCL_RAIZ ?>inicio"><i class="imoon imoon-dashboard fa-fw"></i><span class="text">Inicio</span></a></li>
<!--                    <li class="dropdown "><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="imoon imoon-envelope fa-fw"></i><span class="text">Mensagens</span><span class="pull-right badge badge-warning">4</span><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Todas as Mensagens</a></li>
                            <li><a href="#">Nova mensagem</a></li>
                        </ul>
                    </li>-->
                    <li class=""><a href="<?= SCL_RAIZ ?>inicio/trocar_senha"><i class="fa fa-key fa-fw"></i><span class="text">Trocar Senha</span></a></li>
                </ul>
            </div>
        </nav>
        
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-push-2 col-sm-9 col-sm-push-3 col-no-left-padding">
                    <section id="middle">
                        <div class="page-header">
                            <h1><?= $titulo ?></h1>
                        </div>