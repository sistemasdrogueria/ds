<?php echo $this->Html->css('stylepdf', ['fullBase' => true]); ?>
<div class="col-md">
<div class="product-item"> 
<?php echo $this->element('comprobantes_lotevctopdf_datos'); ?>
</div> 
</div>  
<div class="col-md">
<div class="product-item"> 		
<?php echo $this->element('comprobantes_lotevctopdf_result'); ?>
</div> 
</div> 
<div class="col-md">
<div class="product-item"> 		
<?php echo $this->element('comprobantes_trazapdf_result'); ?>
</div> 
</div> 