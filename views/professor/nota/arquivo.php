<script type="text/javascript">
    function addArquivo(event) {
        var input = '<label style="display: block"><button type="button" class="remove-field btn btn-danger btn-sm">X</button><input class="col-lg-11" type="file" name="arquivo[]" /></label>';
        $(event.target).closest("div").find(".files:first").append(input);
    }    

    $(".files").on("click", ".remove-field", function (event) {
        $(event.target).parent().remove();
    });

    $(".remove-file").on("click", function (event) {
        if (confirm('Tem certeza que deseja excluir o arquivo?')) {
            var id = $(event.target).attr("id");
            var url = "<?= site_url("professor/nota/excluir_arquivo") ?>" + "?id=" + id;
            window.location.href = url;
            $(event.target).closest("tr").remove();
        }
    });
</script>

<form name="form_acao" id="form_acao" action="<?= site_url("professor/nota/add_arquivo") ?>" method="post" enctype='multipart/form-data'>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" style="font-weight: bold">Adicionar Comprovante</h4>
    </div>

    <div class="modal-body">
        <input type="hidden" name="cd_alu_disc" value="<?= $cd_alu_disc ?>" >
        <input type="hidden" name="num_nota" value="<?= $num_nota ?>" >
        <input type="hidden" name="acao" value="upload" >        

        <div class="form-group">            
            <button type="button" class="btn btn-primary" onclick="addArquivo(event)">
                <i class="fa fa-plus"></i>Adicionar Arquivo
            </button>

            <div class="files">
            </div>
        </div>        

        <div class="form-group">
            <?php if (count($lista) > 0) { ?>
                <table width="100%" class="table table-bordered table-hover" id="gridview" aria-describedby="sample-table-2_info">
                    <caption>Lista de Arquivos</caption>

                    <thead>
                        <tr class="panel-heading">
                            <th class="sorting text-center">Arquivo</th>
                            <th class="sorting text-center">Data Upload</th>
                            <th class="sorting text-center">Excluir</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($lista as $l) { ?>
                            <tr>
                                <td class="sorting text-justify">        
                                    <button style="background: none; border: none;" type="button" class="text" onclick="window.open('<?= SCL_UPLOAD ?>/nota/<?= $cd_alu_disc ?>/<?= $l->DS_ANEXO ?>')"><?= $l->DS_ANEXO ?></button>                            
                                </td>

                                <td class="sorting text-center">
                                    <?php echo formato_data($l->DT_ANEXO) ?>
                                </td>

                                <td class="sorting text-center">
                                    <a class="remove-file" id="<?= $l->ID ?>">
                                        <i class="btn btn-danger btn-small fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
    </div>

    <div class="modal-footer">
        <div class="pull-left">
            <button type="submit" class="btn btn-success" >Salvar</button>    
        </div>

        <div class="pull-right">
            <button class='btn btn-danger' data-dismiss="modal">Cancelar</button>    
        </div>
    </div>
</form>

<?php exit(); ?>