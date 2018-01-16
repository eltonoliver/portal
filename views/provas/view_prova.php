
    <link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css" rel="stylesheet">
    <link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="http://getbootstrap.com/2.3.2/assets/css/docs.css" rel="stylesheet">
    <link href="http://getbootstrap.com/2.3.2/assets/js/google-code-prettify/prettify.css" rel="stylesheet">
        
<div class="row">
      <div class="span2"></div>
      <div class="span8">
          Prova: <strong><?=$listar[0]->TITULO?></strong></p>
      </div>
      <div class="span2"></div>
</div>
<div class="row">
      <div class="span2"></div>
      <div class="span8">
          
          <?php
          header ('Content-type: text/html; charset=UTF-8');
          foreach ($listar as $l) {
              echo $l->POSICAO.") ".$l->DC_QUESTAO."<br>";
             // echo substr($l->DC_QUESTAO,3);
          }
          ?>
      </div>
      <div class="span2"></div>
</div>

<?php exit(); ?>