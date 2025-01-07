<script>
	var mot = [];
	mot[4] = "Mercadería Dañada";
	mot[5] = "Mercadería Vencida";
	mot[6] = "Mercadería Solicitada por error";
	mot[3] = "Mercadería No Solicitada";
	var mot2 = [];
	mot2[1] = "Mercadería Mal Facturada";
	mot2[2] = "Mercadería No recibida";
	mot2[8] = "Rectificación de Lote";
	mot2[7] = "Problemas de Trazabilidad";

	var options = {
		0: mot,
		1: mot2
	}

	$(function() {
		var fillSecondary = function() {
			var selected = $('#form_tipo').val();
			$('#form_reclamos_tipo_id').empty();
			options[selected].forEach(function(element, index) {
				$('#form_reclamos_tipo_id').append('<option value="' + index + '">' + element + '</option>');
			});
		}
		$('#form_tipo').change(fillSecondary);
		fillSecondary();
	});
</script>

<div class="card">
	<h2>Ingrese Reclamo/Devolución</h2>
	<?= $this->Form->create('Tickets', ['id' => 'searchform4', 'url' => ['controller' => 'Tickets', 'action' => 'add']]); ?>

	<div class="form-group">
		<label class="label-informacion" for="form_tipo">Tipo</label>
		<?php $motivo_tipo = [0 => 'Devolución', 1 => 'Reclamo']; ?>
		<?= $this->Form->input('tipo', [
			'type' => 'select',
			'label' => false,
			'options' => $motivo_tipo,
			'empty' => 'Seleccionar tipo',
			'class' => 'select-info-form',
			'id' => 'form_tipo',
			'required' => true
		]); ?>
	</div>
	<div class="form-group">
		<label class="label-informacion" for="form_reclamos_tipo_id">Motivo</label>
		<?= $this->Form->input('reclamos_tipo_id', [
			'type' => 'select',
			'label' => false,
			'options' => $reclamostipos,
			'empty' => 'Seleccionar motivo',
			'class' => 'select-info-form',
			'id' => 'form_reclamos_tipo_id',
			'required' => true
		]); ?>
	</div>
	<div class="form-group">
		<label class="label-informacion" for="factura">Número Factura</label>
		<?= $this->Form->input('factura_numero', [
			'type' => 'text',
			'label' => false,
			'placeholder' => 'e.g. 0007-04222400',
			'title' => 'Número de factura e.g. 0007-04222400',
			'class' => 'input-numero-factura',
			'id' => 'factura',
			'pattern' => '[0-9]{4}[-]{1}[0-9]{8}',
			'required' => true
		]); ?>
	</div>
	<button class="boton-validar" type="submit">Validar</button>
	<?= $this->Form->end(); ?>
</div>