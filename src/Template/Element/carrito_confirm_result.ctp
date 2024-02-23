<div class="carrito_items">
<table cellpadding="0" cellspacing="0" style=" border : solid 1px #b3b3b3;     border-collapse: separate;">
<thead>
<tr style="background-color: #b3b3b3;">
<th class="carro_item_cantidad_th"><?= $this->Paginator->sort('cantidad', 'Cant.') ?></th>
<th class="carro_item_descripcion_th"><?= $this->Paginator->sort('Descripción','Descripción') ?></th>
<th class="carro_item_precio_th"><?= $this->Paginator->sort('precio_publico', 'P.C/ Dto') ?></th>
<th class="carro_item_preciototal_th">Precio Total</th>
</tr>
</thead>
<tbody>
<?php $indice=13; 
$descuento_pf = $this->request->session()->read('Auth.User.pf_dcto');
$condicion 	  = $this->request->session()->read('Auth.User.condicion');
$coef         = $this->request->session()->read('Auth.User.coef');

$condiciongeneral = 100*(1-($descuento_pf * (1-$condicion/100)));
?>
<?php foreach ($articulos as $articulo): ?>
<?php //foreach ($carritos as $carrito): ?>
<?php	
$carrito = $articulo['carritos'][0];
if ($carrito['descuento']>0)
{
if ($carrito['cantidad']<$carrito['unidad_minima'])
echo '<tr class="carrito_item_sinoferta">';
else
echo '<tr>';
}
else
echo '<tr>'; ?>
<td class="carro_item_cantidad" style =  "border: solid #fff">
<?= $carrito['cantidad'] ?>
</td>
<td class="carro_item_descripcion" style =  "border: solid #fff;     padding-left: 10px;">
<a class="ico" href="#"><?= $carrito['descripcion']?> 						
<?php echo $this->Html->image('productos/'.$articulo['imagen'],['class'=>'icon']); ?>
</a>
<?php if ($carrito['descuento'] != null) if ($carrito['cantidad'] < $carrito['unidad_minima']) 
{ echo"<a href='#' onclick='modificaoferta(".$carrito['articulo_id'].");'>";
echo $this->Html->image('oferta_perdida.png',['class'=>'off_perdida imgoferta'.$carrito['articulo_id'].'']);
echo "</a>";
}

else
{ echo $this->Html->image('oferta_adquirida.png',['class'=>'off_perdida imgoferta'.$carrito['articulo_id'].'']); }
?>
</td>  
<td class='carro_item_precio' style =  "border: solid #fff">
<?php echo $this->element('precio_condescuento',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'coef'=>$coef,'condiciongeneral'=>$condiciongeneral ] );?>
</td>
<td class="carro_item_preciototal" style =  "border: solid #fff">
<?php echo $this->element('precio_subtotal',['articulo'=>$articulo ,'descuento_pf'=>$descuento_pf,'condicion'=>$condicion,'cantidadencarrito'=>$carrito['cantidad'],'coef'=>$coef,'condiciongeneral'=>$condiciongeneral ] );?>
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

