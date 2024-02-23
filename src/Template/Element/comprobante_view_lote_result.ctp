<div class="lotevctos index large-10 medium-9 columns">
<table class='tablasearch' cellpadding="0" cellspacing="0">
<thead>
<tr>

<th><?= $this->Paginator->sort('cantidad','Cantidad') ?></th>
<th><?= $this->Paginator->sort('articulo_id','Descripción del Producto') ?></th>
<th>GTIN</th>
<th><?= $this->Paginator->sort('serie') ?></th>
<th><?= $this->Paginator->sort('lote') ?></th>
<th><?= $this->Paginator->sort('vencimiento', 'Fecha Venc.') ?></th>


</tr>
</thead>
<tbody>
<?php $indice=0;?>
<?php foreach ($lotevctos as $lotevcto): ?>
<?php $indice+=1;?>      
<tr>

<td class="colcenter"><?= h($lotevcto->cantidad) ?></td>
<td >

<?= $lotevcto->has('articulo') ? $lotevcto->articulo->descripcion_pag : '' ?>
</td>
<td class="colcenter">

<?php echo str_pad($lotevcto->has('articulo') ? $lotevcto->articulo->codigo_barras : '', 14, "0", STR_PAD_LEFT)
?>
</td>
<td class="colcenter"><?= h($lotevcto->serie) ?></td>
<td class="colcenter"><?= h($lotevcto->lote) ?></td>
<td class="colcenter"><?php echo date_format($lotevcto->vencimiento,'d-m-Y');?></td>


</tr>

<?php endforeach; $indice+=2;?>
</tbody>
</table>
<div class="paginator">
<ul class="pagination">
<?= $this->Paginator->prev('< ' . __('Anterior')) ?>
<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('Siguiente') . ' >',['tabindex'=>$indice]) ?>
<div class="pagination_count"><span><?= $this->Paginator->counter('{{count}} Registros') ?> </span></div>
</ul>
</div>
</div>