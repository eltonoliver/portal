<div class="col-md-3">
    <div class="panel panel-default">                
        <div class="panel-body">                    
            <ul class="nav nav-pills nav-stacked">
                <li class="<?= $tipo == "T" ? "active" : "" ?>">
                    <a href="<?= base_url("mensagem") ?>" data-togle="collapse">Entrada</a>
                </li>
                <li>
                    <ul class="nav nav-pills nav-stacked">                             
                        <li class="<?= $tipo == "N" ? "active" : "" ?>">
                            <a href="<?= base_url("mensagem/index/N") ?>"><span class="fa fa-arrow-right"></span> Novas</a>
                        </li>                        
                        <li class="<?= $tipo == "S" ? "active" : "" ?>">
                            <a href="<?= base_url("mensagem/index/S") ?>"><span class="fa fa-arrow-right"></span> Lidas</a>
                        </li>                        
                        <li class="<?= $tipo == "R" ? "active" : "" ?>">
                            <a href="<?= base_url("mensagem/index/R") ?>"><span class="fa fa-arrow-right"></span> Respondidas</a>
                        </li>                                                        
                    </ul>
                </li>
                <li class="<?= empty($tipo) ? "active" : "" ?>">
                    <a href="<?= SCL_RAIZ ?>mensagem/saida">Saída</a>
                </li>
            </ul>
        </div>
    </div>
</div>
