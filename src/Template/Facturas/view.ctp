<div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content">
			<div class="row">
				
				<div class="col-md-12 col-sm-12">
				<span class='cliente_info_span'>Factura</span>
					<?php echo $this->element('facturaencabezadoview'); ?>
					
				</div> <!-- /.col-md-12 -->
			</div> <!-- /.row -->
			</div> <!-- /.product-content -->	
		
		
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-9">
    <div class="product-item-3">
  		<?php //if ($this->request->session()->read('Auth.User.perfile_id')==1): ?>
		<div class="product-content">
		<div class="row">
		<span class='cliente_info_span'>Cuerpo de la Facturas</span>
		<br>
			<?php 
			echo $this->element('facturaitemsview');
			?>
		</div>
		</div>
		
		<?php //endif; ?>
    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->

<div class="facturasCabeceras index large-10 medium-9 columns">

</div>