<div class="articulos index large-10 medium-9 columns">
    <table class='tablasearch' cellpadding="0" cellspacing="0">
    <thead>
        <tr>	
			<th>Cant.</th>
            <th>Descripción</th>
            <th>EAN</th>
			<th>Fecha Venc.</th>
            <th>Lote</th>
			<th>Serie</th>
        </tr>
    </thead>
    <tbody>
	<?php 			
		$lab = $laboratorios->toArray(); ?>

    <tbody>
    <?php foreach ($reclamositemstemps as $reclamosItemsTemp): ?>
        <tr>
            <td class='form_reclamo_cant_td'><?= $this->Number->format($reclamosItemsTemp['cantidad']) ?></td>
            <td><?= h($reclamosItemsTemp['detalle']) ?></td>
			<td> 
			<?php echo $reclamosItemsTemp['a']['codigo_barras'];?>
			</td>
            <td class="form_reclamo_fv_td">
			<?php 
			if ($reclamosItemsTemp['fecha_vencimiento']!=null)
					echo date_format($reclamosItemsTemp['fecha_vencimiento'],'d-m-Y');
			?>	
			</td>
            <td class="form_reclamo_lote_td"><?= h($reclamosItemsTemp['lote']) ?></td>
			<td class="form_reclamo_serie_td"><?= h($reclamosItemsTemp['serie']) ?></td>

        </tr>

    <?php endforeach; ?>
    </tbody>
	 </table>
	
    
</div>
<script>
	$(".tablasearch tr").not(':first').hover(
	function () {
		$(this).css("background","#8FA800");
		$(this).css("color","#000");
		$(this).css("font-weight","");
		}, 
	function () {
		$(this).css("background","");
		$(this).css("color","");
		$(this).css("font-weight","");
		}
	);

</script>