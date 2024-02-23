<hr></hr>
<div class="comprobantes_result">
<h1>Listados de productos Trazados</h1>
<table class='tablasearch' cellpadding="0" cellspacing="0">
<thead>
<tr>
<th>Producto</th>
<th>GTIN</th>		
<th>Serie</th>
<th>Lote</th>
<th>Fecha Venc.</th>
<th>Nro.Transacción</th>
</tr>
</thead>
<tbody>
<?php foreach ($trazas as $traza): ?>
<tr>
<td >
<?= $traza->has('articulo') ? $traza->articulo->descripcion_pag : '' ?>
</td>
<td class="colcenter">
<?php echo str_pad($traza->has('articulo') ? $traza->articulo->codigo_barras : '', 14, "0", STR_PAD_LEFT)
?>
</td>
<td class="colcenter"><?= h($traza->serie) ?></td>
<td class="colcenter"><?= h($traza->lote) ?></td>
<td class="colcenter"><?php echo date_format($traza->vencimiento,'d-m-Y');?></td>
<td class="colcenter"><?= h($traza->cod_transaccion) ?></td>
</tr>
<?php endforeach;?>
</tbody>
</table>
</div>