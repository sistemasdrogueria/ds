<div id="carrito-items" class="carrito_items">

<table id="tabla1" class="carritos_items_tabla hide ">
<thead>
<tr>
<th class="carrito_item_descripcion_th">Descripción</th>
<th class="carrito_item_cantidad_th text-center">Cant.</th>
<th class="actions"></th>
</tr>
</thead>
<table cellpadding="0" id="table1" cellspacing="0" class="carritos_items_tabla  hide ">

</table>
</table>
<table cellpadding="0" id="tablaprueba1" cellspacing="0" class="tablaprueba0 carritos_items_tabla">
<thead>
<tr>
<th class="carrito_item_descripcion_th">Descripción</th>
<th class="carrito_item_cantidad_th text-center">Cant.</th>
<th class="actions"></th>
</tr>
</thead>
<tbody id="tablacarr">
<?php $indice = 2000; ?>
<?php foreach ($carritos as $carrito) : ?>
<?php
if ($carrito['descuento'] != null) {
if ($carrito['cantidad'] < $carrito['unidad_minima']) {
echo '<tr class="carrito_item_sinoferta" title=" Dto: ' . $carrito['descuento'] . '% Uni. Min: ' . $carrito['unidad_minima'] . ' T. Of.: ' . $carrito['tipo_oferta'] . '"id="trBody' . $carrito['articulo_id'] . '">';
} else {
echo '<tr id="trBody' . $carrito['articulo_id'] . '">';
}
} else {
echo '<tr id="trBody' . $carrito['articulo_id'] . '">';
}
?>
<!-- descripcion -->
<td class="carrito_item_descripcion">
		<a  class="ico"  data-ean="<?php  echo $carrito['articulo']['imagen']; ?>"href="#"><?= $carrito['descripcion']?>
						<?php //echo $this->Html->image('productos/'.$carrito['articulo']['imagen'],['class'=>'icon']); ?>
			</a>
				<?php if ($carrito['descuento'] != null) if ($carrito['cantidad'] < $carrito['unidad_minima']) 
													{ echo $this->Html->image('oferta_perdida.png',['class'=>'off_perdida imgoferta'.$carrito['articulo_id'].'']); }
													else
													{ echo $this->Html->image('oferta_adquirida.png',['class'=>'off_perdida imgoferta'.$carrito['articulo_id'].'']); }
													?>
</td>
<!-- cantidad -->

<td class="carrito_item_cantida">
<div class=carrito_item_cantidad_2>
<button class="btn btn-sm resta" onclick="decrement(<?php echo $carrito['articulo_id'] ?>,<?php echo $carrito['descuento_id'] ?>,<?php echo $carrito['articulo_id'] ?>,<?php echo $carrito['id'] ?>)">-</button>
<?php
$indice += 1;
echo $this->Form->input('carb'.$carrito['articulo_id'], ['tabindex' => $indice, 'value' => $carrito['cantidad'], 'data-pv-id' => $carrito['descuento_id'], 'data-id' => $carrito['articulo_id'], 'class' => 'formcarritocant  text-center', 'onkeypress' => 'return soloNumeros(event)', 'maxlength' => '3']);
?>
<button class="btn btn-sm suma" onclick="increment(<?php echo $carrito['articulo_id'] ?>,<?php echo $carrito['descuento_id'] ?>,<?php echo $carrito['articulo_id'] ?>)">+</button>
</div>
</td>

<?= $this->Form->end() ?>
<td class="carrito_item_borrar">
<a href="#" onclick="preguntarSiNo(<?php echo $carrito['id'] ?>,<?php echo $carrito['articulo_id'] ?>)">
<?php echo $this->Html->image('delete_ico.png',['title' => 'Delete']); ?>


</td>

</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>



