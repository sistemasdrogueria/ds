<div class="col-md-5">
    <div class="product-item-3"> 
		<div class="product-content">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<?php echo $this->element('searchpago'); ?>
				</div> <!-- /.col-md-12 -->
				
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->	   	
		<div class="product-content">	
			<div class="row">
			<div class="col-md-12 col-sm-12">
					<?php echo $this->element('ctaopcionespagos'); ?>
				</div> <!-- /.col-md-12 -->
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->	   
		<div class="product-content">	
			<div class="row">
				
				<div class="col-md-12 col-sm-12">
				<span class='cliente_info_span'>Descargar Pagos de la Cta. Cte.</span>
					</br>
					
					
					<div class="button-holder4">
						<?php echo $this->Html->link(__('Excel'), ['controller' => 'CtactePagos', 'action' => 'excel']) ?>
						
					</div> <!-- /.button-holder -->
				
				</div> <!-- /.col-md-12 -->
			</div> <!-- /.row -->
		</div>
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-7">
    <div class="product-item-3">
  		<?php //if ($this->request->session()->read('Auth.User.perfile_id')==1): ?>
		<div class="product-content">
		<div class="row">
		<span class='cliente_info_span'>Cuenta Corriente Pagos</span>
		<br>
			<?php echo $this->element('ctasearchresultpagos'); ?>
		</div>
		</div>
		
		<?php //endif; ?>
    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
