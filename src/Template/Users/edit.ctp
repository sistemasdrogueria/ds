<div class="col-md-5">
    <div class="product-item-3"> 
		<div class="product-content">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<?php echo $this->element('cartconfirmclient'); ?>
				</div> <!-- /.col-md-12 -->
			</div> <!-- /.row -->
		</div> <!-- /.product-content -->	   
		<div class="product-content">
		<div class="row">    
			<?php echo $this->element('infoclient');?>
		</div> <!-- /.row -->
		</div> <!-- /.product-content -->
	</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-7">
    <div class="product-item-3">
        <div class="product-thumb">
			Verifique sus datos. Para modificar la información sobre facturación comuníquese con nosotros al teléfono 0291-5507777. Muchas gracias!
        </div> <!-- /.product-thumb -->
		<?php if ($this->request->session()->read('Auth.User.perfile_id')==1): ?>
		<div class="product-content">
		<div class="row">
			<?php echo $this->element('useredit'); ?>
		</div>
		</div>
		<div class="product-content">
		<div class="related row">
			<div class="column large-12">
				<?php echo $this->element('userlist'); ?>
			</div>
		</div>
	    </div> <!-- /.product-content -->
		<?php endif; ?>
    </div> <!-- /.product-item -->
</div> <!-- /.col-md-3 --> 