<div id="reclamoDetails" class="reclamo-grid">
	<div class="detail-item">
		<div class="detail-label">Nro</div>
		<div class="detail-value"><?= $reclamo->id ?></div>
	</div>
	<div class="detail-item">
		<div class="detail-label">Fecha y Hora</div>
		<div class="detail-value"><?= date_format($reclamo->creado, 'd/m/Y H:i:s'); ?></div>
	</div>
	<div class="detail-item">
		<div class="detail-label">Cliente</div>
		<div class="detail-value"><?= $reclamo->has('cliente') ? h($reclamo->cliente->codigo) : '' ?> - <?= $reclamo->has('cliente') ? h($reclamo->cliente->nombre) : '' ?></div>
	</div>
	<div class="detail-item">
		<div class="detail-label">Motivo</div>
		<div class="detail-value"><?= $reclamo->has('reclamos_tipo') ? h($reclamo->reclamos_tipo->nombre) : '' ?></div>
	</div>
	<div class="detail-item">
		<div class="detail-label">Email</div>
		<div class="detail-value"><?= $reclamo->has('cliente') ? h($reclamo->cliente->email) : '' ?></div>
	</div>
	<div class="detail-item">
		<div class="detail-label">Factura Nro</div>
		<div class="detail-value"><?php echo str_pad($reclamo['factura_seccion'], 4, '0', STR_PAD_LEFT) . '-' . str_pad($reclamo['factura_numero'], 8, '0', STR_PAD_LEFT); ?></div>
	</div>
	<div class="detail-item">
		<div class="detail-label">Pedido Nro</div>
		<div class="detail-value"><?php echo $reclamo['pedido_numero']; ?></div>
	</div>
	<div class="detail-item">
		<div class="detail-label">Factura Fecha</div>
		<div class="detail-value"><?php echo date_format($reclamo->fecha_recepcion, 'd/m/Y'); ?></div>
	</div>
	<div class="detail-item">
		<div class="detail-label">Estado</div>

		<div class="detail-value">
			<?= $this->Form->create(null, ['url' => ['action' => 'cambiarEstadoReclamo', $reclamo->id], 'id' => 'estadoForm']) ?>
			<?= $this->Form->control('estado_id', [
				'type' => 'select',
				'options' => $reclamosEstados,
				'value' => $reclamo->estado_id,
				'empty' => 'Seleccione un estado',
				'label' => '',
				'class' => 'form-control',
				'onchange' => 'document.getElementById("estadoForm").submit();',
			]); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>