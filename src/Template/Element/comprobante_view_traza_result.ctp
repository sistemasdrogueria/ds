<div class="trazas index large-10 medium-9 columns">
<table class='tablasearch' cellpadding="0" cellspacing="0">
<thead>
<tr>
<th><?= $this->Paginator->sort('cantidad_facturada','Cantidad.') ?></th>
<th><?= $this->Paginator->sort('articulo_id','Descripción del Producto') ?></th>
<th>GTIN</th>
<th><?= $this->Paginator->sort('serie') ?></th>
<th><?= $this->Paginator->sort('lote') ?></th>
<th><?= $this->Paginator->sort('vencimiento', 'Fecha Venc.') ?></th>
<th><?= $this->Paginator->sort('cod_transaccion','Nro Transaccíon') ?></th>
</tr>
</thead>
<tbody>
<?php $indice=0;?>
<?php foreach ($trazas as $traza): ?>
<?php $indice+=1;?>      
<tr>
<td class="colcenter">1</td>
<td ><?= $traza->has('articulo') ? $traza->articulo->descripcion_pag : '' ?></td>
<td class="colcenter"><?php echo str_pad($traza->has('articulo') ? $traza->articulo->codigo_barras : '', 14, "0", STR_PAD_LEFT)?></td>
<td class="colcenter"><?= h($traza->serie) ?></td>
<td class="colcenter"><?= h($traza->lote) ?></td>
<td class="colcenter"><?php echo date_format($traza->vencimiento,'d-m-Y');?></td>
<td class="colcenter"><?= h($traza->cod_transaccion) ?></td>
</tr>
<?php endforeach; $indice+=2;?>
</tbody>
</table>
</div>