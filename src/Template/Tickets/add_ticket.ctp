<div class="col-md-9">
<div class="product-item-3">
<div class="product-content2">

<span class='cliente_info_span'>Items de la factura.</span>
<?php 
if ($articulos!=null ) 
{
echo $this->element('ticket_add_result'); } 
else 
{
echo $this->element('ticket_add_noresult'); 	}
?>
</div> 
<div class="product-content2">
<span class='cliente_info_span'>
<?php
if (!empty($reclamo) && !empty($comprobante))
{
	if ($reclamo['tipo']==0)
	echo 'Productos Agregados al la devolución';	
	else
	echo 'Productos Agregados al reclamo';		
}	

	else
	echo 'Productos Agregados al reclamo/devolución';


?>

</span>
<?php  
if (!empty($reclamositemstemps))
{
echo $this->element('ticket_add_result_temp');
}					
?>
</div> 
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->
<div class="col-md-3">
<div class="product-item-3"> 
<div class="product-content">
<?php 
if (!empty($reclamo) && !empty($comprobante))
{
if ($reclamo['tipo']<1)
	echo '<span class=cliente_info_span>Nueva devolución</span>';	
	else
	echo '<span class=cliente_info_span>Nuevo Reclamo</span>';
}	
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
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-3 -->