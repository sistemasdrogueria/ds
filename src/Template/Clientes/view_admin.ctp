<?php //><script type="text/javascript">
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
?>

<article class="module width_full">
		
<header><h3><?= $titulo ?></h3>
<div class="volveratras">
		
		<a href="<?= $previous ?>"><?php echo $this->Html->image('icn_volver.png');?></a>
		</div>
</header>

<div class="module_content">

<table>
<tr>

<td><?= __('Cliente') ?></td>

<td><h2><?= $this->Text->autoParagraph(h($cliente->razon_social));  ?></h2></td>
</tr>
<tr>
<td><?= __('Codigo') ?></td>
<td><?= $this->Number->format($cliente->codigo) ?></td>
</tr>
<tr>

<td>
<?= __('Codigo Postal') ?>
</td>
<td>
<?= h($cliente->codigo_postal) ?>
</td>
</tr>
<tr>
<td><?= __('Cuit') ?></td>
<td><?= $this->Text->autoParagraph(h($cliente->cuit)); ?></td>
</tr>
<tr>
<td><?= __('Domicilio') ?></td>
<td><?= $this->Text->autoParagraph(h($cliente->domicilio)); ?></td>
</tr>
<tr>
<td><?= __('Provincia') ?></td>
<td><?= $cliente->has('provincia') ? $this->Html->link($cliente->provincia->nombre, ['controller' => 'Provincias', 'action' => 'view', $cliente->provincia->id]) : '' ?></td>
</tr>
<tr>
<td><?= __('Localidad') ?></td>
<td><?= $cliente->has('localidad') ? $this->Html->link($cliente->localidad->nombre, ['controller' => 'Localidads', 'action' => 'view', $cliente->localidad->id]) : '' ?></td>            
</tr>
<tr>
<td><?= __('Telefono') ?></td>
<td><?= h($cliente->telefono) ?></td>
</tr>	
<tr>
<td><?= __('Representante') ?></td>
<td><?= $cliente->has('representante') ? $this->Html->link($cliente->representante->id, ['controller' => 'Representantes', 'action' => 'view', $cliente->representante->id]) : '' ?></td>
</tr>
<tr>
<td><?= __('Email') ?></td>
<td><?= h($cliente->email) ?></td>
</tr>
<tr>
<td><?= __('Email Alternativo') ?></td>
<td><?= h($cliente->email_alternativo) ?></td>
</tr>
<tr><td><?= __('Tienesucursal') ?></td>
<td><?= $cliente->tienesucursal ? __('Yes') : __('No'); ?></td>
</tr>
<tr><td><?= __('Ofertaxmail') ?></td>
<td><?= $cliente->ofertaxmail ? __('Yes') : __('No'); ?></td>
</tr>
<tr><td><?= __('Respuestaxmail') ?></td>
<td><?= $cliente->respuestaxmail ? __('Yes') : __('No'); ?></td>
</tr>
</table>


</div>
</article><!-- end of styles article -->

           

