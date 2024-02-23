<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
$previous = $_SERVER['HTTP_REFERER'];
}
?>
<style> 
.columna_descuento{ text-align: center;
} 
.header{text-align: center; }
.cell_center{text-align: center; }
</style>

<article class="module width_4_quarter">
<header><h3 class="tabs_involved" id="titulobarra"><?= $titulo ?></h3>
<div style="float: right; padding-top:2px"><?php echo $this->Html->image('admin/icon_transfer_proveedor.png',["alt" => "Transfer",'url' =>['controller' => 'TransfersProveedors', 'action' => 'index_admin']]);    ?></div>
<div class="volveratras"><a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a></div>
<div id="buttonprint"><a class="print-preview" style="margin: 2px 5px 5px 2px !important"></a></div>
</header>
<div class="tab_container2">
<div id="tab2" class="tab_content2">
<div class="pedidosItems index large-10 medium-9 columns">
<table class="tablesorter" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th class="columna_descuento"><?= $this->Paginator->sort('cliente_id', 'Codigo') ?></th>
<th class="columna_descuento"><?= $this->Paginator->sort('cliente_id','Razon Social') ?></th>
<th class="columna_descuento" ><?= $this->Paginator->sort('tipo_fact') ?></th>
<th class="columna_descuento"> <?= $this->Paginator->sort('transfer_numero') ?></th>
<th class="columna_descuento">Troquel</th>
<th><?= $this->Paginator->sort('articulo_id','Descripción') ?></th>
<th class="columna_descuento">Dtos</th>
<th class="columna_descuento">U.Min.</th>
<th class="columna_descuento">Plazo</th>
<th class="columna_descuento"><?= $this->Paginator->sort('cantidad','Cant. Pedida') ?></th>
<th class="columna_descuento"><?= $this->Paginator->sort('cantidad_facturada','Cant. Factura') ?></th>
<th class="columna_descuento"><?= $this->Paginator->sort('nro_pedido_ds','Nro.pedido DS') ?></th>
<th class="columna_descuento"><?= $this->Paginator->sort('transfer_posicion') ?></th>
<th class="columna_descuento"><?= $this->Paginator->sort('pedidos_items_status_id','Detalle') ?></th>
<th class="columna_descuento"><?= $this->Paginator->sort('stock_fisico','Stock') ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($pedidosItems as $pedidosItem): ?>
<tr>
<td class="columna_descuento"><?= $pedidosItem->pedidos_transfer->cliente->codigo ?> </td>
<td><?= $pedidosItem->pedidos_transfer->cliente->razon_social ?> </td>
<td class="columna_descuento"><?= $pedidosItem->pedidos_transfer->tipo_fact ?> </td>
<td class="columna_descuento"><?= $pedidosItem->pedidos_transfer->transfer_numero ?> </td>
<td><?= $pedidosItem->has('articulo') ? $pedidosItem->articulo->troquel : '' ?> </td>
<td><?= $pedidosItem->has('articulo') ? $pedidosItem->articulo->descripcion_pag : '' ?> </td>
<td class="columna_descuento"><?= $pedidosItem['descuento'].' %' ?></td>
<td class="columna_descuento"><?= $pedidosItem['unidad_minima'] ?></td>
<td class="columna_descuento"><?= $pedidosItem['plazoley_dcto'] ?></td>
<td class="columna_descuento"><?= $pedidosItem->cantidad; ?> </td>
<td class="columna_descuento"><?= $this->Number->format($pedidosItem->cantidad_facturada) ?></td>
<td class="columna_descuento"><?= $pedidosItem->nro_pedido_ds ?> </td>
<td class="columna_descuento"><?= $pedidosItem->transfer_posicion ?> </td>
<td class="columna_descuento"><?php 
if (!is_null($pedidosItem->pedidos_items_status_id))
if ($pedidosItem->pedidos_items_status_id !=20) 
echo $itemstatus[$pedidosItem->pedidos_items_status_id]; 
else
if ($pedidosItem->cantidad_facturada == $pedidosItem->cantidad) 
echo $itemstatus[0]; 
?> </td>

<td>  
<?php 
switch ($pedidosItem['articulo']['stock']) {
case 'B':
echo $this->Html->image('admin/icon_stock_b.png', ['title' => 'Stock Bajo, Consultar Operadora', 'value' => 2]);
break;
case 'F':
echo $this->Html->image('admin/icon_stock_f.png', ['title' => 'Producto en Falta', 'value' => 3]);
break;
case 'S':
echo $this->Html->image('admin/icon_stock_s.png', ['title' => 'Stock Habitual', 'value' => 1]);
break;
case 'R':
echo $this->Html->image('admin/icon_stock_r.png', ['title' => 'Producto sujeto a stock', 'value' => 4]);
break;
case 'D':
echo $this->Html->image('admin/icon_stock_d.png', ['title' => 'Producto Discontinuo', 'value' => 5]);
break;
}
echo '<div style="margin-right:5px; text-align: center;">'. $pedidosItem['articulo']['stock_fisico'].'</div>' ?> 
</td>

</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="pagination">
<ul >
<?php
echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));
?>
</ul>
<div class="total"><?php echo $this->Paginator->counter('{{count}} Total');?></div>
</div>
</div>
</div>
</div>
</article>
<article class="module width_4_quarter">
<header><h3 class="tabs_involved"><?= $titulo2 ?></h3></header>
<div class="tab_container3">
<div id="tab3" class="tab_content3">
<table class="tablesorter" cellpadding="0" cellspacing="0">
<thead>
<tr>
<th class="header"><?= $this->Paginator->sort('cliente','Codigo') ?></th>
<th class="header"><?= $this->Paginator->sort('nombre','Razon Social') ?></th>
<th class="header"><?= $this->Paginator->sort('tipo_fact') ?></th>
<th class="header"><?= $this->Paginator->sort('numero_pedido_proveedor','Transfer Numero') ?></th>
<th class="header"><?= $this->Paginator->sort('ean') ?></th>
<th class="header"><?= $this->Paginator->sort('descripcion') ?></th>
<th class="header"><?= $this->Paginator->sort('descuento', 'Dtos') ?></th>
<th class="header"><?= $this->Paginator->sort('plazo', 'Plazo') ?></th>
<th class="header"><?= $this->Paginator->sort('unidades','Unid.') ?></th>
<th class="header"><?= $this->Paginator->sort('cuit') ?></th>
<th class="header"><?= $this->Paginator->sort('numero_posicion','Transfer Posicion') ?></th>
<th class="header"><?= $this->Paginator->sort('status') ?></th>  
</tr>
</thead>
<tbody>
<?php foreach ($transfersProveedors as $transfersProveedor): ?>
<tr> 
<td class=cell_center><?= $transfersProveedor->cliente ?></td>   
<td><?= $transfersProveedor->nombre ?></td>    
<td><?= $transfersProveedor->tipo_fact ?></td>    
<td class=cell_center><?= $transfersProveedor->numero_pedido_proveedor ?></td>
<td class=cell_center><?= $transfersProveedor->ean ?></td>
<td><?= $transfersProveedor->descripcion ?></td>
<td class=cell_center><?= round($transfersProveedor->descuento, 2).' %'  ?></td>
<td class=cell_center><?= h($transfersProveedor->plazo) ?></td> 
<td class=cell_center><?= h($transfersProveedor->unidades) ?></td>
<td class=cell_center><?= h($transfersProveedor->cuit) ?></td>
<td><?= $transfersProveedor->numero_posicion ?></td>
<td><?php
switch ($transfersProveedor->status) {
case 53:
echo "CUIT INCORRECTO";
break;
case 06:
echo "CANCELADO";
break;
case 71:
echo "CREDITO EXCEDIDO";
break;
case 8:
echo "FALTA";
break;
case 52:
echo "COD. INCORRECTO";
break;
case 41:
echo "EAN INCORRECTO";
break;
case 51:
echo "CLIENTE INACTIVO";
break;
}
?></td>  
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div><!-- end of .tab_container -->
<div class="pagination">
<ul >
<?php
echo $this->Paginator->prev(__('Anterior'), array('tag' => 'li'), null, array('tag' => 'li','disabledTag' => 'a'));
echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
echo $this->Paginator->next(__('Siguiente'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','disabledTag' => 'a'));
?>
</ul>
<div class="total"><?php echo $this->Paginator->counter('{{count}} Total');?></div>
</div>
</article><!-- end of content manager article -->	

<article class="module width_4_quarter">
<header><h3 class="tabs_involved"><?= $titulo_pedido ?></h3>

<div style="float: right; padding-top:4px; padding-right: 5px;"><?= $this->Form->postLink(
   $this->Html->image('admin/icon_cambiar_estado_falta.png',["alt" => __('Cambiar Estado de Falta'), "title" => __('Cambiar Estado de Falta')]), 
    ['action' => 'sinfalta_admin', $transfersImports["id"]],['escape' => false, 'confirm' => __('Esta seguro Marcar como sin faltas a # {0}?', $transfersImports["id"])]);?></div>
 <?php //echo $this->Form->postlink('Eliminar', array('action' => 'eliminar', $registros['Maestro']['id']), array('confirm'=>'Eliminar a ' . $registros['Maestro']['id'], 'class' => 'button'));?>
</header>
<div class="tab_container">
<?php echo $this->element('pedidotransfer_result_admin'); ?>
</div><!-- end of .tab_container -->
</article><!-- end of content manager article -->

<?php echo $this->Html->css('print',['media' => 'print']); ?>

<script type="text/javascript">

$(document).ready(function() {

$('a.print-preview').click(function() {
//echo $transfersImport->transfers_files_laboratorio['nombre_laboratorio']; 
/* var strC = "Cliente N "; 
var strR = " - Pedido N ";

document.title  = strC.concat(strCN,strR,strCR); 

document.getElementById("titulobarra").innerHTML = strC.concat(strCN,strR,strCR);*/
window.print();
return false;
});
});
</script>

