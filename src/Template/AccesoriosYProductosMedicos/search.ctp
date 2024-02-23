<div class="col-md-9">
<div class="product-item-3">
<div class="product-thumb">
<?php echo $this->element('accesorio_prodmed_search'); ?>
</div>
<div class="product-content">
<?php if ($articulos!=null ){echo $this->element('carrito_search_result'); }?>
</div>
<div class="product-content">
<?php echo $this->element('referencia'); ?>
</div> 
</div>
</div>

<div class="col-md-3">
<div class="product-item-5"> 
<div class="product-content">
<div class="row"> <?php echo $this->element('cartresumbody'); ?></div>
</div>
</div>
<div class="product-item-5">		
<div class="product-content">
<div class='cliente_info_class3'><?php echo $this->Html->image('ofertaagregarcarro.png'); ?></div>
<div class='cliente_info_class2'>Carro de Compras</div>
<div class="row"> <?php echo $this->element('botonescarro'); ?>
<div class="cartresul"><?php echo $this->element('cartresultbody'); ?>
</div>
</div> 
</div>
</div> 
</div>