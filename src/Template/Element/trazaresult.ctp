<div class="trazas index large-10 medium-9 columns">
    <table class='tablasearch' cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            
            <th><?= $this->Paginator->sort('nota','Nro Pedido') ?></th>
            <th><?= $this->Paginator->sort('articulo_id','Producto') ?></th>
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
            
            <td class="colcenter"><?= $this->Number->format($traza->nota) ?></td>
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
<?php
echo $this->Html->image('trazable.png', ['alt' => 'Traza de Medicamento','url'=>['controller'=>'Comprobantes','action' => 'trazapdf', $comprobante->id,'_ext' => 'pdf']]);
	?>				