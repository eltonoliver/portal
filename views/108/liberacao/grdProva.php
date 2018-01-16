<script type='text/javascript'>//<![CDATA[

    $(function() {
        $('#todos').click(function() {
            var val = this.checked;
            $('input[name=prova[]]').each(function() {
                $(this).prop('checked', val);
            });
        });
    });
    function habilitar(id) {
        if (id != '') {
            $('.btnLiberar').removeAttr('disabled');
            $('.btnRemover').removeAttr('disabled');
            $('#todos').removeAttr('disabled');
        } else {
            $('.btnRemover').attr('disabled');
            $('.btnLiberar').attr('disabled');
            $('#todos').attr('disabled');
        }
    }
</script>
<div id="retorno"></div>
<table class="display table table-striped table-hover" id="tblGrid">
    <thead>
        <tr class="panel-footer">
            <td style="width:1%"></td>
            <td style="width:5%"><strong>ID</strong></td>
            <td style="width:8%"><strong>N. PROVA</strong></td>
            <td align="center" style="width:12%"><strong>DT. REALIZAÇÃO</strong></td>
            <td><strong>DISCIPLINA</strong></td>
            <td align="center" style="width:5%"><strong>STATUS</strong></td>
            <td align="center" style="width:5%"><strong>OPÇÕES</strong></td>
        </tr>
    </thead>
    <tbody>
        <?
        $new = new Prova_lib();
        foreach ($resultado as $row) {
        
           $data_atual = date('Y-m-d');
           $data_prova = date('Y-m-d',strtotime(implode("-",array_reverse(explode("/",$row['DT_PROVA'])))));
        
        
            if(strtotime($data_prova) < strtotime($data_atual) ){
            ?>
            <tr>
                <td><input onchange="habilitar()" class="checkbox" name="prova[]" value="<?= $row['CD_PROVA'] ?>" id="prova_<?= $row['CD_PROVA'] ?>" type="checkbox"></td>
                <td><?= $row['CD_PROVA'] ?></td>
                <td><?= $row['NUM_PROVA'] ?></td>                
                <td align="center"><?= date('d/m/Y',strtotime(implode("-",array_reverse(explode("/",$row['DT_PROVA'])))));?></td>
                <td><?= $row['DISCIPLINAS'] ?></td>
                <td align="center">
                    <?= (($row['FLG_WEB'] == 0)? '<small class="label label-danger">Aguardando Liberação.</small>' : '<small class="label label-success">Gabarito Liberado.</small>')?>
                </td>                
                <td align="center">
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-info btn-xs dropdown-toggle">
                            Provas & Gabaritos <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a target="_blank" href="https://www.seculomanaus.com.br/academico/108/prova_gabarito/avaliacao/?id=<?= base64_encode($row['CD_PROVA'])?>">Prova Corrigida</a></li>
                            <li class="divider"></li>
                            <li><a target="_blank" href="https://www.seculomanaus.com.br/gestordeprovas/banco/gabarito/frmImprimir/?id=<?= base64_encode($row['CD_PROVA'])?>">Gabarito Geral</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        <? } } ?>
    </tbody>
    <tfoot>
        <tr class="panel-footer">
            <td colspan="7" height="50px"></td>
        </tr>
        <tr class="panel-footer">
            <td colspan="7">
                <button disabled id="btnLiberar" name="btnLiberar" type="button" class="btn btn-info btnLiberar">
                  Liberar Web
                </button>
                
                <button disabled id="btnRemover" name="btnRemover" type="button" class="btn btn-danger2 btnRemover">
                  Remover Web
                </button>
            </td>
        </tr>
    </tfoot>
</table>
<script>
    $(function () {
        $('#tblGrid').dataTable();
    });
</script>
<script>

 
    $('.btnLiberar').click(function() {
        swal({
            title: "Liberação de Gabaritos",
            text: "Você tem certeza que deseja libetrar os gabaritos da(s) prova(s) selecionada(s)?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sim, Liberar!",
            cancelButtonText: "Não, Cancelar!",
            closeOnConfirm: false,
            closeOnCancel: true,
        },
        function(isConfirm) {
            if (isConfirm) {
                // Chama a função que inscreverá o aluno na prova manualmente
                $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/liberacao/frmLiberacao') ?>", {
                    prova: $("input[name='prova[]']:checked").serialize(),
                    tipo: 1
                },
                function(data) {
                    swal("Sucesso!", "Liberação realizada com sucesso!", "success");
                    txtFiltrar();
                    //$("#retorno").html(data);
                });
            }
        });
    });
    
    
    $('.btnRemover').click(function() {
        swal({
            title: "Retirar os Gabaritos",
            text: "Você tem certeza que deseja retirar os gabaritos da(s) prova(s) selecionada(s)?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Sim, Retirar!",
            cancelButtonText: "Não, Cancelar!",
            closeOnConfirm: false,
            closeOnCancel: true,
        },
        function(isConfirm) {
            if (isConfirm) {
                // Chama a função que inscreverá o aluno na prova manualmente
                $.post("<?= base_url(''.$this->session->userdata('SGP_SISTEMA').'/liberacao/frmLiberacao') ?>", {
                    prova: $("input[name='prova[]']:checked").serialize(),
                    tipo: 0
                },
                function(data) {
                    swal("Sucesso!", "Remoção realizada com sucesso.", "success");
                    txtFiltrar();
                    //$("#retorno").html(data);
                });
            }
        });
    });
</script>