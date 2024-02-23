<div class="clear"></div>

<article class="module width_full">
	<?= $this->Form->create($reclamo); ?>
		<header><h3><?= $titulo ?></h3></header>
		<div class="module_content">
	<table class="viewlabel">
	<tr>
		<td><h3 class="subheader"><?= __('Número de Reclamo') ?></h3></td>
            <td><h4><p><?= $this->Number->format($reclamo->id) ?></p></h4></td>
	</tr>
	<tr>			
            <td><h3 class="subheader"><?= __('Cliente') ?></h3></td>
            <td><h4><p><?= $reclamo->has('cliente') ? h($reclamo->cliente->nombre): '' ?></p></h4></td>
	</tr>
	<tr>    
	<td><h3 class="subheader"><?= __('Reclamos Tipo') ?></h3></td>
            <td><h4><p><?= $reclamo->has('reclamos_tipo') ? h($reclamo->reclamos_tipo->nombre) : '' ?></p></h4></td>
	</tr>
	<tr>    
	<td><h3 class="subheader"><?= __('Transporte') ?></h3></td>
            <td><h4><p><?= h($reclamo->transporte) ?></p></h4></td>
	</tr>
	<tr>    
	<td><h3 class="subheader"><?= __('Observaciones') ?></h3></td>
            <td><h4><p><?= h($reclamo->observaciones) ?></p></h4></td>
	</tr>
	<tr>			
            <td><h3 class="subheader"><?= __('Factura Numero') ?></h3></td>
            <td><h4><p><?= $this->Number->format($reclamo->factura_numero) ?></p></h4></td>
	</tr>
	<tr> 
	<td><h3 class="subheader"><?= __('Guia Numero') ?></h3></td>
            <td><h4><p><?= $this->Number->format($reclamo->guia_numero) ?></p></h4></td>

	</tr>
	<tr>			
		<td><h3 class="subheader"><?= __('Fecha Recepcion') ?></h3></td>
				<td><h4><p><?= h($reclamo->fecha_recepcion) ?></p></h4></td>
			
	</tr>
	<tr>			
		<td><h3 class="subheader"><?= __('Estado Actual') ?></h3></td>
				<td><h4><p><?= $reclamo->has('reclamos_estado') ? h($reclamo->reclamos_estado->nombre) : '' ?></p></h4></td>
			
	</tr>		
	</table>

    <fieldset style="width:90%; float:left;">
        <?php
            echo $this->Form->input('estado_id', ['options' => $ReclamosEstados, 'empty' => true]);
        ?>
    </fieldset>
	</div><div class="clear"></div>
	<footer>
				<div class="submit_link">
					
					
				<?= $this->Form->button(__('Guardar')) ?>
				<?= $this->Form->end() ?>
				</div>
	</footer>
</article>
