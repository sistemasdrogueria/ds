<div class="col-md-5">
    <div class="product-item-3"> 
		<div class="product-content">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<?php echo $this->element('ctaclientecredito'); ?>
				</div> <!-- /.col-md-12 -->
				
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->	   	
		<div class="product-content">	
			<div class="row">
			<div class="col-md-12 col-sm-12">
					<?php echo $this->element('ctaopciones'); ?>
				</div> <!-- /.col-md-12 -->
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->	   
		
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-7">
    <div class="product-item-3">
  		<?php //if ($this->request->session()->read('Auth.User.perfile_id')==1): ?>
		<div class="product-content">
		<div class="row">
		<span class='cliente_info_span'>Deuda a Vencida</span>
		<br>
			<?php echo $this->element('ctasearchresult'); ?>
		</div>
		</div>
		
		<?php //endif; ?>
    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->