<div class="cliente_info">
<span class='cliente_info_span'>Datos de Facturación</span>
<table cellpadding="0" cellspacing="0">
<tr><td><?= __('Razon Social') ?></td><td><?= h($cliente->razon_social) ?></td></tr>	
<tr><td><?= __('Código Cliente') ?></td><td><?= $this->Number->format($cliente->codigo) ?></td></tr>
<tr><td><?= __('Domicilio') ?></td><td><?= $cliente->domicilio ?></td></tr>
<tr><td><?= __('Localidad') ?></td><td><?= $cliente->has('localidad') ? $cliente->localidad->nombre : ''.' - '?>
<?php echo '('.$cliente->codigo_postal.')' ?>
</td>
</tr>

<tr>
<td>
<?= __('Provincia') ?>
</td><td>
<?= $cliente->has('provincia') ? $cliente->provincia->nombre : ''?>
</td>
</tr>
<tr>	
<td>	
<?= __('CUIT') ?>
</td><td>
<?= h($cliente->cuit) ?>
</td>
</tr>
</table>        
</div>
