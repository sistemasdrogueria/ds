<div class="col-md-9">
<div class="product-item-3">
<div class="product-content">
<span class="cliente_info_span">Articulos importados: </span>
<?php if ($articulos!=null )
echo $this->element('carrito_import_result'); 
else
echo $this->element('searchsinresult'); 
?>
</div> <!-- /.product-content -->
<div class="product-content">
<?php echo $this->element('referencia'); ?>
</div> <!-- /.product-content -->
<div class="product-content">
<div class="row">           
<span class="cliente_info_span">No se encontraron los siguientes productos: </span>
<?php echo $this->element('searchimportresultnotfind');  ?>	
<div class="importconfirm2">	
<div class="button-holder3"><?=$this->Html->link('No Encontrados',['controller' => 'Carritos', 'action' => 'downloadfile'])?></div>
<div class="button-holder3"><?=$this->Html->link('Excel',['controller' => 'Carritos', 'action' => 'excel'])?></div>
</div>
</div>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="col-md-3">
<div class="product-item-3"> 
<div class="product-content">
<div class="row">
<?php echo $this->element('cartresumbody'); ?>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
<div class="product-content">
<div class='cliente_info_class3'>
<?php echo $this->Html->image('ofertaagregarcarro.png'); ?>
</div>
<div class='cliente_info_class2'>Carro de Compras</div>
<div class="row">   
<?php 
//botonescarro

echo $this->element('carrito_view_button'); ?>
<div class="cartresul">			
<?php echo $this->element('cartresultbody'); ?>
</div>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->