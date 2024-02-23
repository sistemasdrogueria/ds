<article class="module width_3_quarter">
<header><h3 class="tabs_involved"><?= $titulo ?></h3></header>
<div class="tab_container">
<div id="tab1" class="tab_content">
    <table class="tablesorter" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th class="header"><?= $this->Paginator->sort('numero_pedido_proveedor','N° Ped Prov.') ?></th>
                <th class="header"><?= $this->Paginator->sort('status') ?></th>
                <th class="header"><?= $this->Paginator->sort('lab') ?></th>
                <th class="header"><?= $this->Paginator->sort('numero_pedido','N.PED.') ?></th>
                <th class="header"><?= $this->Paginator->sort('fecha_transfer','F.Trans') ?></th>
                <th class="header"><?= $this->Paginator->sort('cliente') ?></th>
                <th class="header"><?= $this->Paginator->sort('nombre') ?></th>
                <th class="header"><?= $this->Paginator->sort('ean') ?></th>
                <th class="header"><?= $this->Paginator->sort('descripcion') ?></th>
                <th class="header"><?= $this->Paginator->sort('unidades') ?></th>
                <th class="header"><?= $this->Paginator->sort('descuento') ?></th>
                <th class="header"><?= $this->Paginator->sort('cuit') ?></th>
                <th class="header"><?= $this->Paginator->sort('domicilio') ?></th>
                <th class="header"><?= $this->Paginator->sort('codigo_postal', 'CP') ?></th>
                <th class="header"><?= $this->Paginator->sort('proveedor_id') ?></th>
                <th class="header" class="actions"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transfersProveedors as $transfersProveedor): ?>
            <tr>          
                <td><?= $transfersProveedor->numero_pedido_proveedor ?></td>
                <td><?= $this->Number->format($transfersProveedor->status) ?></td>  
                <td><?= $this->Number->format($transfersProveedor->lab) ?></td>
                <td><?= $this->Number->format($transfersProveedor->numero_pedido) ?></td>
                <td><?= h($transfersProveedor->fecha_transfer) ?></td>
                <td><?= $this->Number->format($transfersProveedor->cliente) ?></td>
                <td><?= h($transfersProveedor->nombre) ?></td>
                <td><?= h($transfersProveedor->ean) ?></td>
                <td><?= h($transfersProveedor->descripcion) ?></td>
                <td><?= $this->Number->format($transfersProveedor->unidades) ?></td>
                <td><?= $transfersProveedor->descuento ?></td>
                <td><?= h($transfersProveedor->cuit) ?></td>
                <td><?= h($transfersProveedor->domicilio) ?></td>
                <td><?= h($transfersProveedor->codigo_postal) ?></td> 
                <td><?php echo $transfersProveedor->proveedor->id ?></td>              
                <td class="actions">
<?=	$this->Html->image("admin/icn_edit.png", array(
"alt" => "Edit",
'url' => array('controller' => 'incorporations', 'action' => 'edit_admin',  $transfersProveedor->id)
));?>
<?php 
echo $this->Form->postLink(
$this->Html->image('admin/icn_trash.png',
array("alt" => __('Delete'), "title" => __('Delete'))), 
array('action' => 'delete_admin', $transfersProveedor->id), 
array('escape' => false, 'confirm' => __('Esta seguro de eliminar a # {0}?', $transfersProveedor->id))
);?>
</td>                
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div><!-- end of .tab_container -->
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <div class="total"><?php echo $this->Paginator->counter('{{count}} Total');?>
    </div>
    </div>
</article><!-- end of content manager article -->	
