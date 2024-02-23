<div class="col-md-9">
<div class="product-item-3">
<div class="product-thumb">
<?php echo $this->element('search'); ?>
</div>
<div class="product-content">
<?php if ($articulos!=null )
{echo $this->element('carrito_search_result_ps'); }
else
{echo $this->element('carrito_search_sinresult'); }
?>
</div> 
<div class="product-content">
<?php echo $this->element('referencia'); ?>
</div> 
</div> 
</div> 
<div class="col-md-3">
<div class="product-item-5"> 
<div class="product-content">
<div class="row">
<?php echo $this->element('cartresum'); ?>
</div> 
</div> 
</div>
<div class="product-item-5">		
<div class="product-content">
<div class='cliente_info_class3'>
<?php echo $this->Html->image('ofertaagregarcarro.png'); ?>
</div>
<div class='cliente_info_class2'>Carro de Compras</div>
<div class="row">   
<?php echo $this->element('botonescarro'); ?>
<div class="cartresul">			
<?php echo $this->element('cartresult'); ?>
</div>
</div> 
</div>
</div>
</div>