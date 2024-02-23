<div class="col-md-9">
<div class="product-item-3">
<div class="product-thumb">
<?php echo $this->element('search'); ?>
</div> <!-- /.product-thumb -->
<div class="product-content">
<?php if ($articulos!=null )
echo $this->element('carrito_search_result'); 
else
echo $this->element('carrito_search_sinresult'); 
?>
</div> <!-- /.product-content -->
<div class="product-content">
<p>
<u><strong>CONDICIONES:</strong></u> <br>
<br>
1. Todos los productos aquí difundidos poseen fecha cercana de vencimiento. <br>
2. Todos los productos aquí ofrecidos tienen fecha de caducidad entre 30 y 60 días. <br>
3. Los productos adquiridos con fecha cercana de caducidad no tienen devolución bajo ningún concepto. <br>
</p>
</div> <!-- /.product-content -->
<div class="product-content">
<?php echo $this->element('referencia'); ?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="col-md-3">
<div class="product-item-5"> 
<div class="product-content">
<div class="row">
<?php echo $this->element('cartresum'); ?>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
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
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->