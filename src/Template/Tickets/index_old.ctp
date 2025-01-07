<div class="col-md-3">
<div class="product-item-3"> 
<div class="product-content">
<span class='cliente_info_span'>Buscar Devolución/Reclamo</span>
</br>
<div class="row">
<?php echo $this->element('ticket_index_search'); ?>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
<div class="product-content">
<span class='cliente_info_span'>Manual de Procedimiento</span>
</br>
<div class="row">
<?php echo $this->element('ticket_opcion_descarga'); ?>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-9">
<div class="product-item-3">
<div class="product-content">
<span class='cliente_info_span'>Devolución/Reclamo Realizados</span>
</br>		
<?php echo $this->element('ticket_index_result');?>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->