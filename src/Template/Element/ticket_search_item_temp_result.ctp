
<div class="articulos index large-10 medium-9 columns">
	<div style="display:flex; flex-direction: column;overflow: scroll;">
		<table class="tablasearch" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>Cant.</th>
					<th>Imagen</th>
					<th>Descripción</th>
					<th>EAN</th>
					<th>Fecha Venc.</th>
					<th>Lote</th>
					<th>Serie</th>
				</tr>
			</thead>
			<tbody style="width: 1162px">
				<?php foreach ($reclamositemstemps as $reclamosItemsTemp): ?>
					<tr>
						<td style="text-align: center"><?= $this->Number->format($reclamosItemsTemp->cantidad) ?></td>
						<td style="width: 100px;">
							<?= $this->Html->image('productos/big_' . $reclamosItemsTemp->articulo->imagen, ['alt' => 'no-img', 'style' => 'height:75px;width:75px;']); ?>
						</td>
						<td><?= h($reclamosItemsTemp['detalle']) ?></td>
						<td style="text-align: center"><?= $reclamosItemsTemp->articulo->codigo_barras ?></td>
						<td style="text-align: center">
							<?php if ($reclamosItemsTemp->fecha_vencimiento != null)
								echo date_format($reclamosItemsTemp->fecha_vencimiento, 'd/m/Y'); ?>
						</td>
						<td style="text-align: center"><?= h($reclamosItemsTemp->lote) ?></td>
						<td style="text-align: center"><?= h($reclamosItemsTemp->serie) ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div style="display:flex;position: absolute;top: 20px;right: 50px;align-items: center;">
		<?= $this->Html->link(
			'<i class="fa-solid fa-left-long" style="color:white;font-size: 30px;"></i>',
			['controller' => 'Tickets', 'action' => 'index'],
			['escape' => false]
		); ?>
	</div>
</div>

<!-- Script Mouserover -->
<script>
	document.querySelectorAll('.tablasearch tbody tr').forEach(row => {
		row.addEventListener('mouseenter', () => {
			row.style.background = '#d7e7a1';
			row.style.color = '#000';
			row.style.fontWeight = 'bold';
		});
		row.addEventListener('mouseleave', () => {
			row.style.background = '';
			row.style.color = '';
			row.style.fontWeight = '';
		});
	});
</script>

<!-- Script de Paginación -->
<script>
	$('table.tablasearch').each(function() {
		var currentPage = 0;
		var numPerPage = 3;
		var $table = $(this);
		$table.bind('repaginate', function() {
			$table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
		});
		$table.trigger('repaginate');
		var numRows = $table.find('tbody tr').length;
		var numPages = Math.ceil(numRows / numPerPage);
		var $pager = $('<div class="paginator-table"></div>');
		for (var page = 0; page < numPages; page++) {
			$('<div class="page-number"></div>').text(page + 1).bind('click', {
				newPage: page
			}, function(event) {
				currentPage = event.data['newPage'];
				$table.trigger('repaginate');
				$(this).addClass('active').siblings().removeClass('active');
			}).appendTo($pager).addClass('clickable');
		}
		$pager.insertAfter($table).find('div.page-number:first').addClass('active');
	});
</script>