<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TransfersProveedor $transfersProveedor
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $transfersProveedor->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $transfersProveedor->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Transfers Proveedors'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Proveedors'), ['controller' => 'Proveedors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Proveedor'), ['controller' => 'Proveedors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="transfersProveedors form large-9 medium-8 columns content">
    <?= $this->Form->create($transfersProveedor) ?>
    <fieldset>
        <legend><?= __('Edit Transfers Proveedor') ?></legend>
        <?php
            echo $this->Form->control('numero_pedido_proveedor');
            echo $this->Form->control('status');
            echo $this->Form->control('fecha_factura', ['empty' => true]);
            echo $this->Form->control('drogueria');
            echo $this->Form->control('lab');
            echo $this->Form->control('numero_pedido');
            echo $this->Form->control('fecha_transfer', ['empty' => true]);
            echo $this->Form->control('cliente');
            echo $this->Form->control('nombre');
            echo $this->Form->control('ean');
            echo $this->Form->control('descripcion');
            echo $this->Form->control('unidades');
            echo $this->Form->control('descuento');
            echo $this->Form->control('contacto');
            echo $this->Form->control('telefono');
            echo $this->Form->control('cuit');
            echo $this->Form->control('domicilio');
            echo $this->Form->control('codigo_postal');
            echo $this->Form->control('localidad');
            echo $this->Form->control('provincia');
            echo $this->Form->control('creado', ['empty' => true]);
            echo $this->Form->control('proveedor_id', ['options' => $proveedors, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
