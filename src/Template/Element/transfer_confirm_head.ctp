<div class="search-form">
	<div class="view_cliente_pv">
	<table class="tablasearch"cellpadding="0" cellspacing="0">
	<tr>
		<th><?= __('Razon Social') ?></th>
		<th><?= __('Codigo') ?></th>
		<th><?= __('Domicilio') ?></th>
		<th><?= __('Localidad') ?></th>
	</tr>
	<tr>
	<td><?= h($cliente->razon_social) ?></td>
	<td><?= $this->Number->format($cliente->codigo) ?></td>
	<td><?= $cliente->domicilio ?></td>
	<td><?= h($cliente->codigo_postal) ?></td></tr>
    </table>        
	</div>
	<div class="view_botones_pv">
	
	<div class="button-holder4">
	<?= $this->Html->link('Email',['controller' => 'Transfers', 'action' => 'send_email'])?>
	</div> 
	
	</div>
	
</div> <!-- /.search-form -->