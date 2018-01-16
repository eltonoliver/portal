<?php if ($this->session->userdata("VISUALIZOU_AVISO") === false): ?>
    <div id="modal-aviso" class="modal fade" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header btn-info">                
                    <h3 class="modal-title">Aviso</h3>
                </div>

                <div class="modal-body">
                    <p class="text-justify">
                        <?= $mensagem ?>                        
                    </p>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn-modal-aviso">
                        <i class="fa fa-check"></i> Ok, entendi.
                    </button>
                </div>
            </div>
        </div>    
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#modal-aviso').modal("show");
        });
        
        $("#btn-modal-aviso").click(function(){
           $.ajax({
               url : "<?= site_url("inicio/visualizaAviso")?>",
               success: function(){
                   $("#modal-aviso").modal("hide");
               }
           });
        });
    </script>
<?php endif; ?>