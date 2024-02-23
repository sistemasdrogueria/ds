<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FacturasCuerposItemsLotesVcto[]|\Cake\Collection\CollectionInterface $facturasCuerposItemsLotesVctos
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Facturas Cuerpos Items Lotes Vcto'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="facturasCuerposItemsLotesVctos index large-9 medium-8 columns content">
    <h3><?= __('Facturas Cuerpos Items Lotes Vctos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nota') ?></th>
                <th scope="col"><?= $this->Paginator->sort('articulo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('serie') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lote') ?></th>
                <th scope="col"><?= $this->Paginator->sort('vencimiento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cantidad') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cliente_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($facturasCuerposItemsLotesVctos as $facturasCuerposItemsLotesVcto): ?>
            <tr>
                <td><?= $this->Number->format($facturasCuerposItemsLotesVcto->id) ?></td>
                <td><?= $this->Number->format($facturasCuerposItemsLotesVcto->nota) ?></td>
                <td><?= $facturasCuerposItemsLotesVcto->has('articulo') ? $this->Html->link($facturasCuerposItemsLotesVcto->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $facturasCuerposItemsLotesVcto->articulo->id]) : '' ?></td>
                <td><?= h($facturasCuerposItemsLotesVcto->serie) ?></td>
                <td><?= h($facturasCuerposItemsLotesVcto->lote) ?></td>
                <td><?= h($facturasCuerposItemsLotesVcto->vencimiento) ?></td>
                <td><?= h($facturasCuerposItemsLotesVcto->cantidad) ?></td>
                <td><?= h($facturasCuerposItemsLotesVcto->fecha) ?></td>
                <td><?= $facturasCuerposItemsLotesVcto->has('cliente') ? $this->Html->link($facturasCuerposItemsLotesVcto->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $facturasCuerposItemsLotesVcto->cliente->id]) : '' ?></td>
                <td><?= h($facturasCuerposItemsLotesVcto->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $facturasCuerposItemsLotesVcto->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $facturasCuerposItemsLotesVcto->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $facturasCuerposItemsLotesVcto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $facturasCuerposItemsLotesVcto->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
