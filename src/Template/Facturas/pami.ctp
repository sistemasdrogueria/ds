<div class="col-md-3">
    <div class="product-item-3"> 
		<div class="product-content">
			<div class="row">
				<div class="col-md-12 col-sm-12">
				<span class='cliente_info_span'>Facturas Pañales Pami</span>
					<?php echo $this->element('searchfacturapami'); ?>
				</div> <!-- /.col-md-12 -->
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->	
		<div class="product-content">	
			<div class="row">
				<span class='cliente_info_span'>Descargar Listado de Facturas</span>
					<?php echo $this->element('searchfacturaopcionespami'); ?>	
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->	   
		
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-9">
    <div class="product-item-3">
  		<?php //if ($this->request->session()->read('Auth.User.perfile_id')==1): ?>
		<div class="product-content">
		<div class="row">
		<span class='cliente_info_span'>Listado de Facturas Pañales PAMI</span>
		<br>
			<?php 
			echo $this->element('facturapamisearch');
			?>
		</div>
		</div>
		<?php //endif; ?>
    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="facturasCabeceras index large-10 medium-9 columns">
</div>
