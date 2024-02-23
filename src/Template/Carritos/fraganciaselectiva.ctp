<div class="col-md-2">
<div class="product-item-3">
<div class="product-thumb">
<?php echo $this->element('searchfragancias'); ?>
</div> <!-- /.product-thumb -->
<div class="product-content">
<?php {echo $this->element('searchmarcas'); } ?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="col-md-7">
<div class="product-item-3">
<div class="product-content">
<div class='cliente_info_class2'>Fragancias Selectivas</div></br>
<?php echo $this->element('searchsinresultfraganciamarca');?>	
<div class='cliente_info_class2'>Ultimas Novedades</div></br>
<?php echo $this->element('searchsinresultfragancia'); ?>
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
<?php
echo $this->Html->image('ofertaagregarcarro.png');
?>
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