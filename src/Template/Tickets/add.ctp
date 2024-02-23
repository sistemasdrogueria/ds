<div class="col-md-3">
<div class="product-item-3"> 
<div class="product-content">
<?php 
if (!empty($reclamo) && !empty($comprobante))
	echo '<span class=cliente_info_span>Nuevo Reclamo/devolución</span>';
	else
	echo '<span class=cliente_info_span>Ingrese Reclamo/devolución</span>';
?>
</br>
<div class="row">
<?php 
if (!empty($reclamo) && !empty($comprobante))
echo $this->element('ticket_add_form_2'); 
	else
	echo $this->element('ticket_add_form_1'); 
?>
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
<div class="product-content2">

<?php 
if ($articulos!=null ) 
{
echo '<span class=cliente_info_span>Items de la factura.</span>';
echo $this->element('ticket_add_result'); } 
else 
{
echo $this->element('ticket_add_noresult'); 	}
?>
</div> 
<div class="product-content2">

<?php  
if (!empty($reclamositemstemps) && !empty($comprobante))
{
echo '<span class=cliente_info_span>Productos Agregados al reclamo/devolución</span>';
echo $this->element('ticket_add_result_temp');
}					
?>
</div> 
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->