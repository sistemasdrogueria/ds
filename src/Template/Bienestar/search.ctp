<?php $laboratorios = $_SESSION['Laboratorios'];
$categorias= $_SESSION['Categorias'];
?>
<div class="col-md-12" >
<div class="product-item-3">
<div class="product-content" >
<?php
echo '<div class=row>'.$this->element('bienestar_search').'</div>';
echo '<div class=hide   id =bienestar_div_grupos_search>';
echo '</div>';
?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
<div class="col-md-9" id="bienestar_div_grupos">
<div class="product-item-3">
<div class="product-content" style="background-color: #f3f3f3;" >  
<?php 
if($articulos !== null){
echo $this->element('carrito_search_result_img',['articulos'=>$articulos,'laboratorios'=>$laboratorios,'categorias'=>$categorias]); 
}else{echo "sin resultados, intente nuevamente su busqueda.!";}
?>
</div> <!-- /.product-content -->
<div class="product-content">
<?php echo $this->element('referencia'); ?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-9 -->

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


<?php 
	echo $this->Html->script('buscador');
	?>

