<div class="search-form">
	<?= $this->Form->create('Tickets', ['id' => 'searchform4', 'url' => ['controller' => 'Tickets', 'action' => 'confirm']]); //,'onsubmit'=>'return validar2()'
	?>
	<fieldset>
		<?php
		echo $this->Form->input('reclamos_tipo_id', ['label' => 'Motivo', 'options' => $reclamostipos, 'empty' => 'Seleccionar motivo', 'id' => 'form_reclamos_tipo_id', 'disabled' => 'disabled', 'value' => $reclamo['reclamos_tipo_id']]);
		echo $this->Form->input('fecha_recepcion', ['label' => 'Fecha Pedido', 'id' => 'fecha_recepcion', 'name' => 'fecha_recepcion', 'type' => 'text', 'placeholder' => 'Fecha Pedido', 'disabled' => 'disabled', 'value' => $reclamo['fecha_recepcion']]);
		echo $this->Form->input('factura_numero', [
			'placeholder' => "e.g. 0007-04222400",
			'title' => "Número de factura e.g. 0007-04222400",
			'name' => 'factura_numero',
			'label' => 'Número Factura',
			'pattern' => '[0-9]{4}[-]{1}[0-9]{8}',
			'required' => true,
			'disabled' => 'disabled',
			'value' => str_pad($reclamo['factura_seccion'], 4, '0', STR_PAD_LEFT) . '-' . str_pad($reclamo['factura_numero'], 8, '0', STR_PAD_LEFT)
		]);

		echo $this->Form->input('observaciones', ['type' => 'textarea', 'id' => 'form_observaciones', 'onchange' => "javascript:checkobservacion(this);"])
		?>
	</fieldset>
</div>
<div class="col-md-12 col-sm-12">

	<div style="margin-bottom: 10px;">
		<?= $this->Form->submit('Enviar', ['class' => 'button-articulo']); ?>
	</div>
</div>
<?= $this->Form->end() ?>