<div class="col-md-4">
<div class="product-item-3"> 
<div class="product-content">
<div class="row">
<div class="col-md-12 col-sm-12">
<div class="cliente_info">
<span class='cliente_info_span'>Ticket</span>
</br>
<table cellpadding="0" cellspacing="0">
<tr> 
<td>
<?= __('Número') ?>
</td>
<td>    
<?= $this->Number->format($reclamo->id) ?>
</td>
</tr>	
<tr>
<td>
<?= __('Factura Número') ?>
</td>
<td>
<?php echo str_pad($reclamo['factura_seccion'], 4, '0', STR_PAD_LEFT).'-'.str_pad($reclamo['factura_numero'], 8, '0', STR_PAD_LEFT); ?>
</td>
</tr>
<tr>
<td>
<?= __('Factura Fecha') ?>
</td>
<td>
<?php echo date_format($reclamo['fecha_recepcion'],'d-m-Y'); ?>
</td>
</tr>
<tr>
<td>
<?= __('Motivo') ?>
</td>
<td>
<?= $reclamo->has('reclamos_tipo') ? h($reclamo->reclamos_tipo->nombre) : '' ?>
</td>
</tr>
<tr>	
<td>	
<?= __('Estado') ?>
</td>
<td>
<?= $reclamo->has('reclamos_estado') ? h($reclamo->reclamos_estado->nombre) : '' ?>
</td>
</tr>
<tr>	
<td>	
<?= __('Creado el ') ?>
</td>
<td>
<?php echo date_format($reclamo['creado'],'d-m-Y'); ?>
</td>
</tr>
<tr>
<td>	
<?= __('Observaciones ') ?>
</td>
<td>
<?php echo $reclamo['observaciones']; ?>
</td>
</tr>
</table>   
</br>				
</div>
</div>
</div> <!-- /.row -->
</div> <!-- /.product-content -->
</div> <!--.product-item-1 -->  
</div> <!-- /.col-md-4 -->
<div class="col-md-8">
<div class="product-item-3">

<div class="product-content">

<span class='cliente_info_span'>Producto/s</span>		
</br>		
<?php 
if ($reclamositemstemps!=null )
{ echo $this->element('ticket_search_item_temp_result');}		
?>
</br>
</div> <!-- /.product-content -->
</div> <!-- /.product-item -->
</div> <!-- /.col-md-3 -->