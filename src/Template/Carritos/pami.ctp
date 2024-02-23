<div class="col-md-12">
<div class="product-thumb">
<?php echo $this->element('search'); ?>
</div> <!-- /.product-thumb -->
<div class="product-item-3">
<div class="product-content">
<!-- p>Estimados clientes<br>
IMPORTANTE A TENER EN CUENTA<br> 
Hasta el 05 de abril 2019 inclusive podrán dar ingreso manual a stock de pañales Pami que tienen en su poder, luego de esa fecha se procederá con nueva modalidad de obleas.<br>
</p -->
<?php if ($articulos!=null )
{echo $this->element('carrito_pami_result'); }
else
{echo $this->element('searchsinresult'); }
?>
</div> <!-- /.product-content -->
<div class="product-content">
<?php echo $this->element('referencia'); ?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
