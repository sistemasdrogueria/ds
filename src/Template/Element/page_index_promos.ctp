<style>
.col-item {
padding: 0; border: 5px solid #fff; background: 0 0; margin-bottom: 50px;}
.col-item .info {padding: 12px 15px 15px;}
.col-item .photo {position: relative;}
.col-item .photo a .bg_promo {position: absolute;left: 0;right: 0;top: 0;bottom: 0;background-color: #0d1217;opacity: 0;z-index: 2;}
.col-item .photo a .btn_bg_promo {position: absolute;left: 0;right: 0;margin: 0 auto;top: 130px;width: 130px;padding: 10px 20px 8px;background: #1b82c5;color: #fff;text-align: center;z-index: 3;opacity: 0;}
.col-item .photo a img, .col-item .photo img {margin: 0 auto;width: 100%;z-index: 1;}
.titulo_seccion_off {margin-top: 35px; margin-bottom: 35px;}
</style>
<div class="content-section" style="background: #EFEFEF;">
<div class="container">
<div class="row">
<div class="col-md-12">
<h2 class=titulo_seccion_off>OFERTAS QUE NO TE PODÉS PERDER </h2>
</div> <!-- /.section -->
</div> <!-- /.row -->
<div class="row">
<?php 
if (!empty($ofertasX))
foreach ($ofertasX as $oferta): ?>
<div class="col-md-3 col-sm-6">
<div class="col-item">
<div class="photo">
<?php 
if ($oferta["laboratorio_id"]!=500)
echo $this->Html->image('ofertas/'.$oferta['imagen'], ['width'=>350,'alt' => str_replace('"', '', $oferta['descripcion'])]);
else
echo '<a href="https://www.exposurvirtual.com.ar/" target ="_blank">'.$this->Html->image('ofertas/'.$oferta['imagen'], ['alt' => 'EXPOSUR VIRTUAL 8']) .'</a>';

?>
</div>
</div>
</div> <!-- /.col-md-3 -->
<?php endforeach; ?>
</div> <!-- /.row -->
</div> <!-- /.container -->
</div> <!-- /.content-section -->


