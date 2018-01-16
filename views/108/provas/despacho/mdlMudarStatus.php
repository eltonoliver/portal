<div id="mdlProvaAluno">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h4 class="modal-title">Cancelamento de Inscrição</h4>
        </div>
        <script>
            function habilitar(id){
                if(id != ''){
                    $('.btnSalvarDados').removeAttr('disabled');
                }else{
                    $('.btnSalvarDados').attr('disabled');
                }
            }
        </script>
        <div class="modal-footer">
            <h5>Selecione a Prova</h5>
            <select name="avalProva" id="avalProva" class="form-control" onchange="habilitar(this.value)">
                <option value=""></option>
                <? foreach ($provas as $row) { ?>
                    <option value="<?= $row['CD_PROVA'] ?>"><?=$row['NUM_PROVA'].' - '.$row['NM_MINI'].' - '.$row['CHAMADA'].'ª CHAMADA - '.$row['BIMESTRE'].'º BIMESTRE' ?></option>
                <? } ?>
            </select>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
            <button disabled type="button" class="btn btn-info btnSalvarDados">Salvar Dados</button>
        </div>
    </div>
    <script>
     function mdlProvaListarAluno() {
        $.post("<?= base_url('110/diario_prova/mdlDiarioProvaAluno') ?>", {
            prova: $("#avalProva").val(),
        },
        function(data) {
            if(data != 0){
                $("#mdlProvaAluno").html(valor);
                return ( 1 );
            }else{
                return ( 0 );
            }
        });
    };
    
    $(function() {
        $('.btnSalvarDados').click(function() {
            swal({
                title: "Notas Dissertativas",
                text: "Deseja realmente lançar as Notas Dissertativas desta prova?",
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sim, Lançar Agora!",
                cancelButtonText: "Não, Cancelar!",
                closeOnConfirm: true,
                closeOnCancel: true,
            },
            function(isConfirm) {
                if (isConfirm) {
                    setTimeout(function(){
                        swal("Aguarde!", "Estou buscando a prova.", "success");
                    }, 500);
                    setTimeout(function(){
                        // função que verifica no banco se a prova esta processada 
                        $.post("<?= base_url('110/diario_prova/mdlDiarioProvaAluno') ?>", {
                            prova: $("#avalProva").val(),
                        },
                        function(data) {
                            if(data != 0){
                                $("#mdlProvaAluno").html(data);
                                swal("Encontrei!", "Muita atenção na hora de colocar as notas.", "success");
                            }else{
                                swal("Encontrei mas...", "A prova selecionada ainda não foi processada! Verifique com sua coordenação.", "error");
                            }
                        });
                        // fim da função que verifica se a prova esta processada                        
                    }, 3000);
                } else {
                    swal("Tudo bem!", "Você tem até o fim do bimestre ou até a prova ser bloqueada.", "error");
                }
            });
        });

    });
</script>
</div>
</div>
