<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header btn-info">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">INFORME DE QUAL ALUNO USARÁ O CRÉDITO</h3>
        </div>

        <div class="modal-body">                 
            <?php
            $i = 0;
            foreach ($alunos as $row) {
                if ($i == 0) {
                    echo "<div class='row'>";
                }
                ?>

                <div class="col-md-4">                
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h6 class="panel-title"><span style="font-size:14px"><i class="fa fa-user"></i>  <?= $row['NM_ALUNO'] ?></span></h6>
                        </div>

                        <div class="panel-body">
                            <div class="col-xs-3 thumbnail avatar center">
                                <img src="<?= SCL_RAIZ ?>restrito/foto?codigo=<?= $row['CD_ALUNO'] ?>" class="media-object">
                            </div>

                            <div class="col-xs-9">
                                <ul class="nav nav-pills nav-stacked">
                                    <li class="list-warning">
                                        Crédito (R$):<br />
                                        <strong style="font-size:20px">
                                            <?= number_format(str_replace(',', '.', $row['VL_SALDO']), 2, ',', '.') ?>
                                        </strong>
                                    </li>
                                </ul>
                            </div>
                        </div>                    

                        <div class="panel-footer">
                            <form class="pagar-credito-aluno" action="<?= site_url("financeiro/boleto/pagar_credito_aluno") ?>" method="post">
                                <input type="hidden" name="boleto" value="<?= $boleto ?>">
                                <input type="hidden" name="aluno" value="<?= base64_encode($row['CD_ALUNO']) ?>">
                                <button class="btn btn-success pagar-boleto" type="submit">
                                    <i class="fa fa-check-circle"></i> Selecionar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <?php
                $i++;

                if ($i == 3) {
                    $i = 0;
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>

    <div class="modal-footer">
        <button id="cancelar" type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>                
    </div>      

    <script type="text/javascript">
        $(".pagar-credito-aluno").submit(function (e) {
            e.preventDefault();
            var dados = $(this).serialize();
            var url = $(this).attr("action");

            $("#cancelar").hide();
            $(this).closest("div .modal-body").html('<?= modal_load ?>');

            $.ajax({
                url: url,
                method: "post",
                data: dados,
                dataType: "json",
                success: function (response) {
                    window.location = response['url'];
                }
            });
        });
    </script>
</div>

<?php exit(); ?>