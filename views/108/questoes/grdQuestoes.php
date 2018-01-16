<table id="tbl" class="table table-hover table-striped table-bordered" cellpadding="0" cellspacing="5" width="100%">
    <thead>
        <tr>
            <th class="text-center">CÓDIGO</th>
            <th class="text-center">TIPO</th>
            <th class="text-center">DESCRIÇÃO</th>                        
            <th class="text-center">DATA DO CADASTRO</th>                        
            <th class="text-center">GABARITADA</th>                        
            <th class="text-center">OPÇÕES</th>
        </tr>
    </thead>

    <tbody>        
        <? foreach ($questoes as $row) { ?>
            <tr id="<?= $row->CD_QUESTAO ?>">
                <td class="text-center"><?= $row->CD_QUESTAO ?></td>
                <td class="text-center"><?= $row->FLG_TIPO == 'O' ? 'OBJETIVA' : 'DISCURSIVA' ?></td>                        
                <td class="text-justify"><?= strip_tags($row->DC_QUESTAO->read(100)) ?></td>                
                <td class="text-center"><?= date('d/m/Y', strtotime($row->CADASTROU_EM)) ?></td>                
                <td class="text-center status">
                    <div class="text-center loading">
                        <i class="fa fa-refresh fa-spin fa-2x"></i>
                        <span class="sr-only">Loading...</span>
                    </div>
                </td>
                <td class="text-center">
                    <a id="btnTemaView" class="btn btn-primary btn-xs" href="<?= base_url('108/questoes/mdlQuestaoView/V-' . $row->CD_QUESTAO) ?>" data-toggle="frmModalUpdate">
                        <i class="fa fa-eye"></i>
                    </a>

                    <a class="btn btn-info btn-xs" href="<?= base_url('108/questoes/frmQuestao/E-' . $row->CD_QUESTAO) ?>">
                        <i class="fa fa-edit"></i>
                    </a>                

                    <a class="btn btn-danger btn-xs" href="<?= base_url('108/questoes/mdlQuestaoView/D-' . $row->CD_QUESTAO) ?>" data-toggle="frmModalDanger">
                        <i class="fa fa-trash"></i>
                    </a>                    
                </td>
            </tr>
        <? } ?>
    </tbody>
</table>

<script src="<?= base_url('assets/js/modal.js') ?>"></script>
<script type="text/javascript">
    $("#tbl").on('page.dt', function () {
        salvarFiltro();
    });

    var tabela;

    $(document).ready(function () {
        tabela = $('#tbl').DataTable({
            aaSorting: []
        });
        atualizaStatus();

        $("#tbl").on('draw.dt', function () {
            atualizaStatus();
        });
    });

    function atualizaStatus() {
        var linhas = $("#tbl").find("tbody tr");
        var tamanho = linhas.length;

        for (i = 0; i < tamanho; i++) {
            var codigo = $(linhas[i]).attr('id');

            $.ajax({
                url: "<?= site_url("108/questoes/statusGabarito") ?>",
                method: "post",
                dataType: "json",
                data: {
                    questao: codigo
                },
                success: function (data) {
                    var id = data['codigo'];
                    var valor = "";

                    if (data['success'] === "-") {
                        valor = "<i class='fa fa-minus fa-2'></i>";
                    } else if (data['success']) {
                        valor = "<i class='fa fa-check fa-2'></i>";
                    } else {
                        valor = "<i class='fa fa-close fa-2'></i>";
                    }

                    $("#tbl").find("#" + id + " .status").html(valor);
                }
            });
        }
    }
</script>