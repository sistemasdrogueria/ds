<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TransfersProveedor $transfersProveedor
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Transfers Proveedor'), ['action' => 'edit', $transfersProveedor->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Transfers Proveedor'), ['action' => 'delete', $transfersProveedor->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transfersProveedor->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Transfers Proveedors'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Transfers Proveedor'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Proveedors'), ['controller' => 'Proveedors', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Proveedor'), ['controller' => 'Proveedors', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="transfersProveedors view large-9 medium-8 columns content">
    <h3><?= h($transfersProveedor->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($transfersProveedor->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ean') ?></th>
            <td><?= h($transfersProveedor->ean) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($transfersProveedor->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Contacto') ?></th>
            <td><?= h($transfersProveedor->contacto) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefono') ?></th>
            <td><?= h($transfersProveedor->telefono) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cuit') ?></th>
            <td><?= h($transfersProveedor->cuit) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Domicilio') ?></th>
            <td><?= h($transfersProveedor->domicilio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Localidad') ?></th>
            <td><?= h($transfersProveedor->localidad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Provincia') ?></th>
            <td><?= h($transfersProveedor->provincia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Proveedor') ?></th>
            <td><?= $transfersProveedor->has('proveedor') ? $this->Html->link($transfersProveedor->proveedor->id, ['controller' => 'Proveedors', 'action' => 'view', $transfersProveedor->proveedor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($transfersProveedor->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Numero Pedido Proveedor') ?></th>
            <td><?= $this->Number->format($transfersProveedor->numero_pedido_proveedor) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($transfersProveedor->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Drogueria') ?></th>
            <td><?= $this->Number->format($transfersProveedor->drogueria) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lab') ?></th>
            <td><?= $this->Number->format($transfersProveedor->lab) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Numero Pedido') ?></th>
            <td><?= $this->Number->format($transfersProveedor->numero_pedido) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cliente') ?></th>
            <td><?= $this->Number->format($transfersProveedor->cliente) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Unidades') ?></th>
            <td><?= $this->Number->format($transfersProveedor->unidades) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Descuento') ?></th>
            <td><?= $this->Number->format($transfersProveedor->descuento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Codigo Postal') ?></th>
            <td><?= $this->Number->format($transfersProveedor->codigo_postal) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha Factura') ?></th>
            <td><?= h($transfersProveedor->fecha_factura) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha Transfer') ?></th>
            <td><?= h($transfersProveedor->fecha_transfer) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creado') ?></th>
            <td><?= h($transfersProveedor->creado) ?></td>
        </tr>
    </table>
</div>
