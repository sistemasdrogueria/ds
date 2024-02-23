<div class="col-md-7">
<div class="product-item-3">
<div class="product-thumb">
<?php
echo 'Hola '. $this->request->session()->read('Auth.User.razon'); 
//$this->request->session()->write('Auth.User.razon',$proveedors['razon_social']);
	//				$this->request->session()->write('Auth.User.codigo',$proveedors['codigo']);
?>
</div> <!-- /.product-thumb -->

<div class="product-content">
<div class="row">
<?php echo $this->element('transfer_user_password'); ?>
</div>
</div>

</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->