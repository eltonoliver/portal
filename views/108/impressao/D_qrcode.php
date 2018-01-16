<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <script src="<?= base_url('assets/js/') ?>/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="<?= base_url('assets/') ?>/extencoes/jquery.qrcode.min.js"></script>
    </head>
    <body>
        <div id="imagem"></div>
        

<script>

        imagem = jQuery('#imagem').qrcode({text: "<?= $codigo ?>"});
        $('canvas').attr('id', 'canvas');
        var canvas = document.getElementById("canvas");
        var canvasData = canvas.toDataURL("image/png");
        //alert(canvasData);
        </script>