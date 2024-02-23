<!-- div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content">
			<div class="row">
				
				<div class="col-md-12 col-sm-12">
				<span class='cliente_info_span'>Detalle de Comprobante</span>
					<?php //echo $this->element('trazacomprobante'); ?>
				</div> 
			</div> 
		</div> 
		
	</div> 
</div>  
<div class="col-md-9">
    <div class="product-item-3">
		<div class="product-content">
		<div class="row">
		<span class='cliente_info_span'>Listados de productos Trazados</span>
		<br>
			<?php //echo $this->element('trazaresult'); ?>
		</div>
		</div>
		
		
    </div> 
</div> -->

<div class="col-md">
    <div class="product-item"> 
		<?php echo $this->element('comprobantes_trazapdf_datos'); ?>
	</div> 
</div>  
<div class="col-md">
    <div class="product-item"> 		
			<?php echo $this->element('comprobantes_trazapdf_result'); ?>
    </div> 
</div> 