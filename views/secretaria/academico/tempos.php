<? $this->load->view('layout/header'); ?>
<style>   
    .cf{
        
        background-color:#073F57; 
        color: white;

    }

    table{

        border-color: #073F57;
    }

    tbody tr:nth-child(odd) {
             background-color: #aae5ff;
    }
    
</style>
<div class="row">
    <div class="section-light col-lg-12 col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tempos de Aula</h3>
                    </div>
                    <div class="panel-body">
                        <table  class="table table-hover" id="rt1" border="1px;" id="rt1">
                            <thead class="cf">
                                <tr>
                                    <th data-toggle="true" class="text-center">TEMPO </th>
                                    <th data-hide="phone,tablet" class="text-center">SEGUNDA</th>
                                    <th data-hide="phone,tablet" class="text-center">TERÇA</th>
                                    <th data-hide="phone,tablet" class="text-center">QUARTA</th>
                                    <th data-hide="phone,tablet" class="text-center">QUINTA</th>
                                    <th data-hide="phone,tablet"  class="text-center">SEXTA</th>
                                    <th data-hide="phone,tablet" class="text-center">SÁBADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                $contador = count($tempos);
                                for ($i = 0; $i < $contador; $i++) {
                                    ?>
                                    <tr>
                                        <td class="text-center formatar"> <strong> <?= $tempos[$i]['TEMPO'] ?> </strong> </td>
                                        <td class="text-center formatar <? if (FL_DIA == 1) echo "success"; ?>" style="font-size:11px"> <?php $seg = str_replace('/', '<br>', $tempos[$i]['SEGUNDA']); echo nl2br($seg); ?></td>
                                        <td class="text-center formatar <? if (FL_DIA == 2) echo "success"; ?>" style="font-size:11px"> <?php $ter = str_replace('/', '<br>', $tempos[$i]['TERCA'] ); echo nl2br($terc); ?></td>
                                        <td class="text-center formatar <? if (FL_DIA == 3) echo "success"; ?>" style="font-size:11px"> <?php $quart = str_replace('/', '<br>',  $tempos[$i]['QUARTA']); echo nl2br($quart); ?></td>
                                        <td class="text-center formatar <? if (FL_DIA == 4) echo "success"; ?>" style="font-size:11px"> <?php $quinta = str_replace('/', '<br>',  $tempos[$i]['QUINTA']); echo nl2br($quinta); ?></td>
                                        <td class="text-center formatar <? if (FL_DIA == 5) echo "success"; ?>" style="font-size:11px"> <?php $sexta = str_replace('/', '<br>', $tempos[$i]['SEXTA']); echo nl2br($sexta); ?></td>
                                        <td class="text-center formatar <? if (FL_DIA == 6) echo "success"; ?>" style="font-size:11px"> <?php $sab = str_replace('/','<br>',$tempos[$i]['SABADO']); echo nl2br($sab); ?></td>
                                    </tr>
                                <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('.grid').footable();

        $('#change-page-size').change(function(e) {
            e.preventDefault();
            var pageSize = $(this).val();
            $('.footable').data('page-size', pageSize);
            $('.footable').trigger('footable_initialized');
        });

        $('#change-nav-size').change(function(e) {
            e.preventDefault();
            var navSize = $(this).val();
            $('.footable').data('limit-navigation', navSize);
            $('.footable').trigger('footable_initialized');
        });
    });
</script>
<? $this->load->view('layout/footer'); ?>
<? exit(); ?>