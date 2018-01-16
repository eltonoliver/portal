<div id="mdlProvaAluno">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h4 class="modal-title">Solicitação de Cancelamento</h4>
        </div>
        <form role="form" id="formNovaSolicitacao">
        <div class="modal-body">
            <h5>Número da Prova. <i><small>Ex. 20150001213</small></i></h5>
            <input type="number" class="form-control" name="avalProva" id="avalProva" />            
            <h5>Motivo do Cancelamento</h5>
            <select name="avalMotivo" id="avalMotivo" class="form-control" onchange="habilitar(this.value)">
                <option value=""></option>
                <? foreach ($tipo as $row) { ?>
                    <option value="<?= $row['CD_MOTIVO']?>"><?=$row['DC_MOTIVO']?></option>
                <? } ?>
            </select>
            <h5>Aprovador: </h5>
            <select name="avalAprovador" id="avalAprovador" class="form-control">
                <option value=""></option>
                <? foreach ($para as $row) { ?>
                    <option value="<?= $row['CD_USUARIO'] ?>"><?=$row['NM_USUARIO']?></option>
                <? } ?>
            </select>
        </div>
        <div class="modal-footer" id="mdlProvaCancelamento"></div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-info">Salvar Dados</button>
        </div>
        </form>
    </div>

    <script>    
    $(function() {
        $("#formNovaSolicitacao").validate({
            rules: {
              avalProva: { required: true, number: true },
             avalMotivo: { required: true },
          avalAprovador: { required: true },
            },
            submitHandler: function(form) {
                swal({
                title: "Finalizar Solicitação",
                text: "Você tem certeza que deseja finalizar essa solicitação?",
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sim, finalizar!",
                cancelButtonText: "Não, Cancelar!",
                closeOnConfirm: false,
                closeOnCancel: true,
            },
            function(isConfirm) {
                if (isConfirm) {
                    // função que verifica no banco se a prova esta processada 
                    $.post("<?= base_url('108/prova_cancelamento/frmManter') ?>", {
                      operacao: 'I',
                         prova: $("#avalProva").val(),
                        motivo: $("#avalMotivo").val(),
                     aprovador: $("#avalAprovador").val(),
                    },
                    function(data) {
                        if(data == true){                             
                            swal("Sucesso!", "Solicitação criada com sucesso.", "success");
                        }else{
                            swal("Erro!", "Ocorreu um erro ao criar a solicitação, verifique se a prova existe ou não esta anulada.", "error");
                        }
                        $("#mdlProvaCancelamento").html(data);
                    });
                }
            });
            }
        });

    });
</script>
</div>
</div>
