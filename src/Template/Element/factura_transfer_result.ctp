<div class="articulos index large-10 medium-9 columns">
<table class='tablasearch' cellpadding="0" cellspacing="0">
<thead>
<tr>	
<th><?= $this->Paginator->sort('fecha') ?></th> 
<th><?php echo 'Laboratorio'; ?></th> 
<th><?= $this->Paginator->sort('transfer') ?></th> 
<th><?= $this->Paginator->sort('comprobante_id','F. Número') ?></th>
<th><?= $this->Paginator->sort('pedido_ds') ?></th> 
<th><?= $this->Paginator->sort('total') ?></th>
</tr>  
</thead>
<tbody>
<?php $indice=0;
foreach ($facturasCabeceras as $facturasCabecera): 
if (!empty($facturasCabecera['facturas_cuerpos_items']))
{
?>
<tr></tr>
<tr style="border: 1px solid #fff;">
<?php $indice+=1;?>
<td class="colcenter"><?php echo date_format($facturasCabecera['fecha'],'d-m-Y'); ?></td>
<td><?php echo $facturasCabecera['facturas_cuerpos_items'][0]['articulo']['laboratorio']['nombre'] ?></td>           
<td><?php echo  str_pad($facturasCabecera['transfer'] 	, 8, "0", STR_PAD_LEFT);?></td>
<td class="colcenter">
<?php 
echo $facturasCabecera['letra'].' '.				
str_pad($facturasCabecera['comprobante']['seccion'] , 4, "0", STR_PAD_LEFT).'-'.
str_pad($facturasCabecera['comprobante']['numero']  	, 8, "0", STR_PAD_LEFT);
?>
</td>
<td class="colcenter"><?php 
if ($facturasCabecera['comprobante']['anulado']==1)  echo 'Anulada'; 
else
echo $facturasCabecera['pedido_ds']; ?>
</td>
<td class='colprecio'><?php echo '$ '.number_format($facturasCabecera['total'],2,',','.'); ?>		</td>
</tr>
<tr>
<td></td>
<td colspan=5>
<table class='tablasearch' cellpadding="0" cellspacing="0">
<thead>
<tr>
<th><?= $this->Paginator->sort('codigo_barra','EAN') ?></th>
<th><?= $this->Paginator->sort('descripcion') ?></th>
<th><?= $this->Paginator->sort('Unids.') ?></th>
<th><?= $this->Paginator->sort('Descuento') ?></th>
<th><?= $this->Paginator->sort('precio_total','P.Unit') ?></th>
<th>
<?php echo $this->Html->image('pdf_view.png',['title' => 'Ver PDF','url'=>['controller'=>'Comprobantes','action' => 'view',  $facturasCabecera['comprobante']['id'],date_format($facturasCabecera['comprobante']['fecha'],'Ymd')]]); ?>    
<?php echo $this->Html->image('pdf.png',['title' => 'Descargar PDF','url'=>['controller'=>'Comprobantes','action' => 'downloadfile', $facturasCabecera['comprobante']['nota'], $facturasCabecera['comprobante']['comprobante_tipo_id'],date_format($facturasCabecera['comprobante']['fecha'],'Ymd')]]); ?>    
</th>
</tr>
</thead>
<?php $indice=0; foreach ($facturasCabecera['facturas_cuerpos_items'] as $facturasCuerposItem): $indice+=1;?>
<tr>
<td><?= $facturasCuerposItem['codigo_barra']; ?></td>
<td><?= $facturasCuerposItem['descripcion']; ?></td>
<td class='colcenter'><?= $facturasCuerposItem['cantidad_facturada'] ?></td>
<td class='colprecio'>
<?= $facturasCuerposItem['descuento'] ?> %
</td>
<td class='colprecio'>
<?php	
	$precio = $facturasCuerposItem['precio_unitario'];
	$descuentooferta = $facturasCuerposItem['descuento'];
	$precio -= $precio*$descuentooferta/100;
	echo '$ '.number_format($precio,2,',','.');  ?>
</td>
<td class="colcenter"><?php 
if ($facturasCuerposItem->iva==1) { echo $this->Html->image('iva.png',['title' => 'IVA']); }
?></td>

</tr>
<?php endforeach; $indice+=1; ?>
</tbody>
</table>
</td>
<tr>	
</tr>
<?php } endforeach; $indice+=2; ?>
</tbody>
</table>
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Articulos') ?> </span></div>
</ul>
</div>
</div>