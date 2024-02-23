<div class="carrito_items">
<table cellpadding="0" cellspacing="0">
<thead>
<tr>
<th class="carro_item_cantidad_th"><?= $this->Paginator->sort('cantidad', 'Cant.') ?></th>
<th class="carro_item_descripcion_th"><?= $this->Paginator->sort('Descripción','Descripción') ?></th>
<th class="carro_item_precio_th"><?= $this->Paginator->sort('precio_publico', 'P.Farmacia') ?></th>
<th class="carro_item_preciototal_th">Precio Total</th>
</tr>
</thead>
<tbody>
<?php $indice=13; 
$descuento_pf =$this->request->session()->read('Auth.User.pf_dcto');
foreach ($carritos as $carrito): 
if ($carrito['descuento']!=null)
{
if ($carrito['cantidad']<$carrito['unidad_minima'])
echo '<tr class="carrito_item_sinoferta">';
else
echo '<tr>';
}
else
echo '<tr>'; ?>
<td class="carro_item_cantidad">
<?= $carrito->cantidad ?>
</td>
<td class="carro_item_descripcion">
<?= $carrito->descripcion ?>
</td>  
<td class="carro_item_precio">
<?php
if ($carrito->tipo_precio=="P")
echo '$ '.number_format($carrito->precio_publico,2,',','.'); 
else
echo '$ '.number_format((round(h($carrito->precio_publico)*$descuento_pf, 3)),2,',','.'); ?>
</td>
<td class="carro_item_preciototal">
<?php if ($carrito->tipo_precio=="P")
echo '$ '.number_format($carrito->precio_publico*$carrito->cantidad,2,',','.'); 
else
echo '$ '.number_format((round(h($carrito->precio_publico)*$descuento_pf, 3)*$carrito->cantidad),2,',','.'); ?>
</td>
</tr>		
<?php endforeach; ?>
</tbody>
</table>
</div>
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Articulos') ?> </span></div>
</ul>
</div>