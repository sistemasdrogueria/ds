<div class="col-md-9">
<div class="product-item-3">

<div class="product-content">
<?php if ($articulos!=null )


{
    echo '<div class=param_sort>'.$this->Paginator->sort('puntos','Menor Valor',['descripcion_sist' => 'asc'] ).'</div>';
    /*<div class="param_sort"><?= $this->Paginator->sort('puntos','Mayor Valor',['direction' => 'desc'] ) ?></div>
    <div class="param_sort"><?= $this->Paginator->sort('creado','Fecha') ?></div>
    <div class="param_sort"><?= $this->Paginator->limitControl(['10'=>10,'20'=>20,'40'=>40],null,['label'=>'Cant:','class'=>'cantidadselect']);?></div>
*/
    echo $this->element('carrito_search_result'); }
else
{echo $this->element('searchsinresult'); }
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