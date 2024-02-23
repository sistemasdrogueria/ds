<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FacturasCuerposItemsLotesVcto $facturasCuerposItemsLotesVcto
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Facturas Cuerpos Items Lotes Vcto'), ['action' => 'edit', $facturasCuerposItemsLotesVcto->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Facturas Cuerpos Items Lotes Vcto'), ['action' => 'delete', $facturasCuerposItemsLotesVcto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $facturasCuerposItemsLotesVcto->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Facturas Cuerpos Items Lotes Vctos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Facturas Cuerpos Items Lotes Vcto'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="facturasCuerposItemsLotesVctos view large-9 medium-8 columns content">
    <h3><?= h($facturasCuerposItemsLotesVcto->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Articulo') ?></th>
            <td><?= $facturasCuerposItemsLotesVcto->has('articulo') ? $this->Html->link($facturasCuerposItemsLotesVcto->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $facturasCuerposItemsLotesVcto->articulo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Serie') ?></th>
            <td><?= h($facturasCuerposItemsLotesVcto->serie) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lote') ?></th>
            <td><?= h($facturasCuerposItemsLotesVcto->lote) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cantidad') ?></th>
            <td><?= h($facturasCuerposItemsLotesVcto->cantidad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cliente') ?></th>
            <td><?= $facturasCuerposItemsLotesVcto->has('cliente') ? $this->Html->link($facturasCuerposItemsLotesVcto->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $facturasCuerposItemsLotesVcto->cliente->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($facturasCuerposItemsLotesVcto->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nota') ?></th>
            <td><?= $this->Number->format($facturasCuerposItemsLotesVcto->nota) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Vencimiento') ?></th>
            <td><?= h($facturasCuerposItemsLotesVcto->vencimiento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($facturasCuerposItemsLotesVcto->fecha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($facturasCuerposItemsLotesVcto->created) ?></td>
        </tr>
    </table>
</div>
