<hr></hr>
<div class="comprobantes_result">
	<h1>Listados de productos</h1>
    <table class='tablasearch' cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th>Cantidad</th>    
            <th>Producto</th>
			<th>GTIN</th>		
            <th>Serie</th>
            <th>Lote</th>
            <th>Fecha Venc.</th>
            
        </tr>
    </thead>
    <tbody>
    <?php foreach ($lotevctos as $lotevcto): ?>
	     
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

    <?php endforeach;?>
    </tbody>
    </table>
</div>