<div class="col-md-9">
<div class="product-thumb">
<?php echo $this->element('search'); ?>
</div> <!-- /.product-thumb -->
<div class="product-item-3">

<div class="product-content">
<?php if (!is_null($articulos) )
{
echo $this->element('carrito_search_result',['articulos'=>$articulos,'laboratorios'=>$laboratorios,'categorias'=>$categorias]); 
}
else
{echo $this->element('carrito_search_sinresult'); }
?>
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
<?php echo $this->element('cartresumbody'); ?>
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
<?php echo $this->element('cartresultbody'); ?>
</div>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->