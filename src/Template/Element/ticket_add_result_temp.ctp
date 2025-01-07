<div id=reclamo-temp-item class="articulos index large-10 medium-9 columns">
	<div class="product-grid">
		<?php foreach ($reclamositemstemps as $reclamosItemsTemp): ?>
			<div class="product-card" id="<?= $reclamosItemsTemp->id ?>">
				<div class="product-header">
					<div class="product-title-container">
						<h2 class="article-title"><?= $reclamosItemsTemp->detalle ?></h2>
						<hr class="linea-divisor">
						<p class="product-lab">Laboratorio: <?= $reclamosItemsTemp->articulo->laboratorio->nombre ?></p>
						<p class="product-lab">EAN: <?= $reclamosItemsTemp->articulo->codigo_barras ?></p>
					</div>
				</div>
				<div class="product-details">
					<div style="border: solid 1px #bdbdbd;padding: 5px;border-radius: 15px;">
						<p class="detail-label">Cantidad.</p>
						<p class="detail-value cantidad"><?= $reclamosItemsTemp->cantidad ?? ' Sin completar ' ?></p>
					</div>
					<div style="border: solid 1px #bdbdbd;padding: 5px;border-radius: 15px;">
						<p class="detail-label">Fecha Venc.</p>
						<p class="detail-value"><?= $reclamosItemsTemp->fecha_vencimiento ?? ' Sin completar ' ?></p>
					</div>
					<div style="border: solid 1px #bdbdbd;padding: 5px;border-radius: 15px;">
						<p class="detail-label">Lote</p>
						<p class="detail-value">
							<?php if (($reclamosItemsTemp->lote == '') || ($reclamosItemsTemp->lote == null)): ?>
								Sin completar
							<?php else: ?>
								<?= $reclamosItemsTemp->lote ?>
							<?php endif; ?>
						</p>
					</div>
					<div style="border: solid 1px #bdbdbd;padding: 5px;border-radius: 15px;">
						<p class="detail-label">Serie</p>
						<p class="detail-value">
							<?php if (($reclamosItemsTemp->serie == '') || ($reclamosItemsTemp->serie == null)): ?>
								Sin completar
							<?php else: ?>
								<?= $reclamosItemsTemp->serie ?>
							<?php endif; ?>
						</p>
					</div>
				</div>
				<div class="product-footer">
					<button type="button" class="delete-btn" aria-label="Eliminar producto" data-id="<?= $reclamosItemsTemp['id'] ?>" data-detalle="<?= h($reclamosItemsTemp->detalle) ?>">
						<i class="fas fa-trash-alt"></i>
					</button>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>


<?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')); ?>

<script>
	$(document).ready(function() {
		$('.delete-btn').on('click', function(event) {
			event.preventDefault();

			const itemId = $(this).data('id');
			const detalle = $(this).data('detalle');

			Swal.fire({
				title: `¿Desea eliminar el ítem ${detalle} del reclamo?`,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: 'Sí, eliminar',
				cancelButtonText: 'Cancelar'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: '<?= $this->Url->build(['controller' => 'ReclamosItemsTemps', 'action' => 'delete']) ?>' + '/' + itemId,
						type: 'POST',
						data: {
							id: itemId,
							_csrfToken: $('meta[name="csrfToken"]').attr('content')
						},
						success: function(response) {
							Swal.fire(
								'Eliminado',
								'El ítem ha sido eliminado exitosamente.',
								'success'
							).then(() => $('#' + itemId).remove());
						},
						error: function() {
							Swal.fire(
								'Error',
								'No se pudo eliminar el ítem. Inténtelo nuevamente.',
								'error'
							);
						}
					});
				}
			});
		});
	});
</script>