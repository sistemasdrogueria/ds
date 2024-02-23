<div class="col-md-9">
<div class="product-item-3">
<div class="product-thumb">
<?php echo $this->element('pedido_faltas_search'); ?>
</div> <!-- /.product-thumb -->
<div class="product-content">
<div class='cliente_info_class2'>Productos en faltas de la última semana</div>
</br>
<?php if ($articulos!=null )
{echo $this->element('carrito_search_result'); }
else
{echo $this->element('carrito_search_sinresult'); }
?>
</div> 
<div class="product-content">
<?php 
echo $this->element('referencia'); 
?>
</div> 
</div> 
</div> 
<div class="col-md-3">
<div class="product-item-5"> 
<div class="product-content">
<div class="row">
<?php echo $this->element('cartresumbody'); ?>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div>
<div class="product-item-5">	
<div class="product-content">
<div class='cliente_info_class3'>
<?php
echo $this->Html->image('ofertaagregarcarro.png');
?>
</div>
<div class='cliente_info_class2'>Carro de Compras</div>
<div class="row">   
<?php echo $this->element('botonescarro'); ?> 
<div class="cartresul">			
<?php echo $this->element('cartresultbody'); ?>
</div>
</div>
</div> 
</div>
</div> 