<div class="col-md-3">
<div class="product-item-3"> 
<div class="product-content">
<div class="row">
<div class="col-md-12 col-sm-12">
<span class='cliente_info_span'>Transfer</span>
<?php echo $this->element('factura_transfer_search'); ?>
</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
</div> <!-- /.product-content -->	
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-9">
<div class="product-item-3">
<div class="product-content">
<div class="row">
<span class='cliente_info_span'>Listado de Facturas Transfer</span>
<br>
<?php 
echo $this->element('factura_transfer_result');
?>
</div>
</div>
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->