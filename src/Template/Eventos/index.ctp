
<div class="col-md-9">
<div class="product-item-3">
<div class="product-content3">
<div class="row">
<div class="eventos index large-9 medium-8 columns content">
<h3><?= __('Eventos Realizados') ?></h3>
<div id="galeria" data-nanogallery2 = '{"thumbnailWidth":   "auto","thumbnailHeight":  250,"itemsBaseURL":     "img/eventos/","galleryTheme":    {"navigationBreadcrumb": {  }}}'>
<?php 
foreach ($eventos as $evento): 
echo '<a href="" data-ngkind="album" data-ngid="'.$evento->carpeta_fotos.'" data-ngthumb="'.$evento->carpeta_fotos.'/invitacion.png">'.$evento->nombre.' - '.$evento->fecha.' - '.$evento->lugar.'</a>'; 
for ($i=1;$i<$evento->cantidad_fotos;$i++)
{
$imagen = $evento->carpeta_fotos.'/'.$i.'.jpg';
$imagen_c = $evento->carpeta_fotos.'/'.$i.'c.jpg';
$ngid= $evento->carpeta_fotos.($i-1);
$ngalbumid = $evento->carpeta_fotos;
echo '<a href="'.$imagen.'" data-ngid="'.$ngid.'" data-ngalbumid="'.$ngalbumid.'" data-ngthumb="'.$imagen_c.'"></a>';
} 
endforeach; 
?>
</div> <!-- div id galeria -->
</div> <!-- div class eventos -->
</div> <!-- row -->
</div> <!-- product-content3 -->
</div> <!-- product-item -->
</div> <!-- col-md-9 -->


<div class="col-md-3">
<div class="product-item-3">
<div class="product-content3">
<div class="row">
<h3><?= __('Proximos Eventos') ?></h3>
<?php //echo $this->Html->image('Exposur4Participantes.jpg', ["alt" => "Novedades",'width'=>'100%']);?>
<?php //echo $this->Html->image('Exposur4.jpg', ["alt" => "Novedades",'width'=>'100%']);?>

</div> <!-- row -->
</div> <!-- product-content3 -->
</div> <!-- product-item -->
</div> <!-- col-md-3 -->