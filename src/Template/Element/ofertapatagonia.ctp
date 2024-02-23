<?php echo $this->Html->script('flickity.pkgd.min');?>
<h3>OFERTAS PATAGONIA MED</h3>
<div class="gallery js-flickity" data-flickity-options='{ "freeScroll": true, "wrapAround": true }'>	

<?php foreach ($ofertasX as $oferta): ?>

<div class="gallery-cell"> <!-- -->
<div class="product-item-4"> <!-- -->
<div class="product-thumb">  
<?php echo $this->Html->image('ofertas/'.$oferta['imagen'],['url'=>['controller'=>'Carritos','action'=>'promocion',$oferta['busqueda'],$oferta['detalle']]], ['alt' => str_replace('"', '', $oferta['descripcion'])]);?> 
</div> 

<div class="product-content-oferta1"> <!-- -->
<span class="descripcion">
</span>
</div> 	<!-- -->
</div> <!-- -->
</div> <!-- -->
<?php endforeach; ?>


