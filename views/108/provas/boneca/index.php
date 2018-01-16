<? $this->load->view('home/header'); ?>
<link rel="stylesheet" href="<?=base_url('assets/css/dataTables.bootstrap.css')?>" />
<script type="text/javascript">
    function validar() {
        $.post("<?= base_url('108/prova_despacho/frmManterStatus') ?>", {
            operacao: 'EP',
        },
        function(data) {
            location.reload();
        });
    };
</script>
<script type="text/javascript">
    function habilitar(){
        var checkeds = new Array();
        $("input[name='listaDelete[]']:checked").each(function (){
            $('.btnCancelarInscricao').removeAttr('disabled');
        });
        $("input[name='listaDelete[]']:checked").each(function (){
            $('.btnCancelarInscricao').removeAttr('disabled');
        });
    }
</script>
<div class="content animate-panel">
    <div class="row projects">
        <div class="hpanel hgreen">
            <div class="panel-heading">
                <div class="panel-tools">
                    <a onclick="location.reload()"><i class="fa fa-refresh"></i></a>
                </div>
                <h3><i class="fa fa-check text-success"></i> <?=count($listar)?> PROVA(S) ESPERANDO IMPRESSÃO DE BONECA</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover" id="tblGridView">
                    <thead>
                        <tr class="panel-footer">
                            <td></td>
                            <td width="5%"><strong>ID</strong></td>
                            <td width="8%"><strong>N. PROVA</strong></td>
                            <td><strong>TÍTULO</strong></td>                            
                            <td align="center"></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?
                        foreach ($listar as $row) {
                            ?>
                            <tr>
                                <td align="center">
                                    <div class="checkbox checkbox-info no-margins no-padding">
                                        <input onchange="habilitar()" class="checkbox" name="listaDelete[]" id="checkbox<?= $row['CD_PROVA'] ?>" type="checkbox">
                                        <label for="checkbox<?= $row['CD_PROVA'] ?>"></label>
                                    </div>
                                </td>
                                <td><?= $row['CD_PROVA'] ?></td>
                                <td><?= $row['NUM_PROVA'] ?></td>
                                <td><?= $row['TITULO'] ?></td>
                                <td>
                                    <a class="btn btn-info btn-xs" onclick="window.open('<?=('https://www.seculomanaus.com.br/gestordeprovas/prova/index?id=' . $row['CD_PROVA'] . '') ?>');" >
                                        <i class="fa fa-print"></i> Objetiva
                                    </a>
                                    <a class="btn btn-success btn-xs" onclick="window.open('<?=('https://www.seculomanaus.com.br/gestordeprovas/prova/discursiva?id=' . $row['CD_PROVA'] . '') ?>');" >
                                        <i class="fa fa-print"></i> Dissertativa
                                    </a>
                                </td>
                            </tr>
                        <? } ?>
                    </tbody>
                    <tfoot>
                            <tr>
                                <td colspan="5" align="left">
                                    <button disabled data-toggle="modal" data-target="#mdlLiberar" class="btn btn-danger2 btn-sm btnCancelarInscricao" >
                                        <i class="fa fa-send-o"></i> Enviar para: 
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                </table>
                <script>
                    $(function() {
                        // Initialize Example 2
                        $('#tblGridView').dataTable();
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mdlLiberar" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="color-line"></div>
            <div class="modal-footer">
                <h4 class="modal-title">As provas(s) estão:</h4>
            </div>
            <div class="modal-body">
                <h4 class="radio radio-info no-margins no-padding">
                    <input value='4' class="radio" name="liberar" id="radioS" type="radio">
                    <label for="radioS"> APROVADA(S)</label>
                </h4>
                <h4 class="radio radio-info no-margins no-padding">
                    <input value='2' class="radio" name="liberar" id="radioN" type="radio">
                    <label for="radioN"> REPROVADA(S)</label>
                </h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary">Despachar Prova(s)</button>
            </div>
        </div>
    </div>
</div>

<? $this->load->view('home/footer'); ?>