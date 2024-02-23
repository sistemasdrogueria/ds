<div class="cliente_info">
<span class='cliente_info_span'>Datos de Facturación</span>
<table class=carrito_info_client cellpadding="0" cellspacing="0">
<tr><td><?= __('Razón Social') ?></td><td class=carrito_info_client_datos><?= h($cliente->razon_social) ?></td></tr>	
<tr><td><?= __('Código Cliente') ?></td><td class=carrito_info_client_datos><?= $this->Number->format($cliente->codigo) ?></td></tr>
<tr><td><?= __('Domicilio') ?></td><td class=carrito_info_client_datos><?= $cliente->domicilio ?></td></tr>
<tr><td><?= __('Localidad') ?></td><td class=carrito_info_client_datos><?= $cliente->has('localidad') ? $cliente->localidad->nombre : ''.' - '.
'('.$cliente->codigo_postal.')' ?></td></tr>
<tr><td><?= __('Provincia') ?></td><td class=carrito_info_client_datos><?php echo strtoupper($cliente['provincia']['nombre'])?></td></tr>
<tr><td><?= __('CUIT') ?></td><td class=carrito_info_client_datos><?= h($cliente->cuit) ?></td></tr>
<tr><td><?= __('GLN') ?></td><td class=carrito_info_client_datos><?= h($cliente->gln) ?></td></tr>
</table>
</div>