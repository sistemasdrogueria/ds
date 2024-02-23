<div class="col-md-3">
<div class="product-item-3"> 
<div class="product-content">
<div class="row">
<div class="col-md-12 col-sm-12">
<span class='cliente_info_span'>Comprobantes</span>
<?php echo $this->element('comprobante_search'); ?>
</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
</div> <!-- /.product-content -->	   
<div class="product-content">
<div class="row">	
<div class="col-md-12 col-sm-12">
<span class='cliente_info_span'>Descargar listado de Comprobantes</span>
<?php echo $this->element('comprobante_search_option'); ?>
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
<span class='cliente_info_span'>Listados de Comprobantes</span>
<br>
<?php echo $this->element('comprobante_result'); ?>
</div>
</div>
<?php //endif; ?>
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->