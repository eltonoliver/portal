<div class="modal-dialog" style="width:80%; float:left">


    <script type="text/javascript">
        $(document).ready(function() {
            $('#filtro a').click(function() {
                // fetch the class of the clicked item
                var ourID = $(this).attr('id');

                // reset the active class on all the buttons
                $('#filtro li').removeClass('active');
                // update the active state on our clicked button
                $(this).parent().addClass('active');

                if (ourID == 'all') {
                    // show all our items
                    $('#frmpedido').children('div.item').show();
                }
                else {
                    // hide all elements that don't share ourClass
                    $('#frmpedido').children('div:not(.' + ourID + ')').hide();
                    // show all elements that do share ourClass
                    $('#frmpedido').children('div.' + ourID).show();
                }
                return false;
            });
        });
    </script>
    <div class="modal-content ">
        <div class="modal-header btn-info">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="panel-title"><i class="fa fa-user"></i> Faltas do(a) Aluno(a)</h4>
        </div>
        
        <?
        $categoria = array();
        foreach ($produtos as $pro) {
            $categoria[] = strtolower($pro['DC_CATEGORIA']);
        }
        $categoria = array_keys(array_flip($categoria));
        ?>
        <div class="modal-footer">
            <div id="filtro" style="witdh:100%">
                <a href="#" class="btn btn-warning" id="all">Todos</a>
                <? foreach ($categoria as $item) { ?>
                    <a href="#" class="btn btn-info" id="<?= $item ?>"><?= $item ?></a>
                <? } ?>
            </div>
            <hr />
            <form name="frmpedido" id="frmpedido" >
                <? foreach ($produtos as $pro) { ?>
                    <div class="item <?= strtolower($pro['DC_CATEGORIA']) ?>" style="width:20%; float: left">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <div class="thumbnail avatar">
                                    <img src="http://localhost/cantina/assets/images/xsalada.jpg" class="media-object">
                                </div>
                                <div>
                                    <ul class="nav nav-pills nav-stacked">
                                        <li class="list-danger" style="background:#D6D6D6; text-align: left; font-size:10px">
                                         <strong><?= $pro['DC_PRODUTO'] ?> </strong>
                                        </li>
                                        <li class="list-info">
                                            R$  <strong style="font-size:20px"><?= number_format($pro['PRECO_ALUNO'], 2, ',', '.') ?></strong>
                                        </li>
                                        <li class="list-warning">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="checkbox" onclick="javascript:mostrar(<?= $pro['CD_PRODUTO'] ?>);" name="selecao[]" value="<?= $pro['CD_PRODUTO'] ?>" />
                                                </span>
                                                <select disabled="disabled" class="form-control" id="produto<?= $pro['CD_PRODUTO'] ?>" name="produto[]" style="display:none" onchange="javascript:atualizar()">
                                                    <option value="<?= $pro['CD_PRODUTO'] ?>:1:<?= $pro['PRECO_ALUNO'] ?>:<?= $pro['DC_PRODUTO'] ?>" >1</option>
                                                    <option value="<?= $pro['CD_PRODUTO'] ?>:2:<?= $pro['PRECO_ALUNO'] ?>:<?= $pro['DC_PRODUTO'] ?>" >2</option>
                                                    <option value="<?= $pro['CD_PRODUTO'] ?>:3:<?= $pro['PRECO_ALUNO'] ?>:<?= $pro['DC_PRODUTO'] ?>" >3</option>
                                                    <option value="<?= $pro['CD_PRODUTO'] ?>:4:<?= $pro['PRECO_ALUNO'] ?>:<?= $pro['DC_PRODUTO'] ?>" >4</option>
                                                    <option value="<?= $pro['CD_PRODUTO'] ?>:5:<?= $pro['PRECO_ALUNO'] ?>:<?= $pro['DC_PRODUTO'] ?>" >5</option>
                                                </select>
                                                <input class="form-control" placeholder="QUANTIDADE" style="display:block" id="txt<?= $pro['CD_PRODUTO'] ?>" disabled />
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> 
                    </div>
                <? } ?>
                <input type="hidden" name="token" id="token" value="<?= $js ?>" />
                <input type="hidden" name="aluno" id="aluno" value="<?= $aluno ?>" />
            </form>
        </div>
    </div>
</div>
<div  style="position: fixed; bottom:0px; z-index:99999; float:right; right:0px; width:20%" id="grdpedido">
</div>
<? exit(); ?>

