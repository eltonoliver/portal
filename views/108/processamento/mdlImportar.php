<div class="modal-dialog">
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-footer">
            <h5 class="modal-title">Novo Arquivo de Provas</h5>
        </div>
        <div class="modal-body">
            <ul class="list-group" id="anexos"></ul>
        </div>
        <div class="modal-footer">
            <div class="col-xs-10 pull-left text-left">
                <small>Somente arquivos .txt | .dat</small><br>
                <iframe height="40" src="<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/processamento/anexo')?>" frameborder="0" scrolling="no"></iframe>
            </div>
            <button type="button" class="btn btn-danger2" data-dismiss="modal">Fechar</button>
        </div>
    </div>
    <script type="text/javascript">
$(function($) {
    // Quando enviado o formulário
    $("#upload").submit(function() {
        // Passando por cada anexo
        $("#anexos").find("li").each(function() {
            // Recuperando nome do arquivo           
            var nome = $(this).attr('nome');
            var registro = $(this).attr('registro');
            // Criando campo oculto com o nome do arquivo
            $("#upload").prepend('<input type="hidden" name="anexos[' + sequencia + '][nome]" value="' + nome + '" \/>');
        }); 
    });
});
    
// FunÃ§Ã£o para remover um anexo
function removeAnexo(obj){
    // Recuperando nome do arquivo
    var arquivo = $(obj).parent('li').attr('lang');
    // Removendo arquivo do servidor
    $.post("<?=base_url(''.$this->session->userdata('SGP_SISTEMA').'/processamento/mdlImportar')?>", {
        acao: 'removeAnexo', 
        arquivo: arquivo
    }, function() {
        // Removendo elemento da pÃ¡gina
        $(obj).parent('li').remove();
    });
}
</script>
</div>
