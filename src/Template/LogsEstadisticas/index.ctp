<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LogsEstadistica[]|\Cake\Collection\CollectionInterface $logsEstadisticas
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Logs Estadistica'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Permisos'), ['controller' => 'Permisos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Permiso'), ['controller' => 'Permisos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="logsEstadisticas index large-9 medium-8 columns content">
    <h3><?= __('Logs Estadisticas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha') ?></th>
                <th scope="col"><?= $this->Paginator->sort('cliente_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ip') ?></th>
                <th scope="col"><?= $this->Paginator->sort('super') ?></th>
                <th scope="col"><?= $this->Paginator->sort('seccion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('permiso_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logsEstadisticas as $logsEstadistica): ?>
            <tr>
                <td><?= $this->Number->format($logsEstadistica->id) ?></td>
                <td><?= h($logsEstadistica->fecha) ?></td>
                <td><?= $logsEstadistica->has('cliente') ? $this->Html->link($logsEstadistica->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $logsEstadistica->cliente->id]) : '' ?></td>
                <td><?= $logsEstadistica->has('user') ? $this->Html->link($logsEstadistica->user->id, ['controller' => 'Users', 'action' => 'view', $logsEstadistica->user->id]) : '' ?></td>
                <td><?= h($logsEstadistica->ip) ?></td>
                <td><?= h($logsEstadistica->super) ?></td>
                <td><?= h($logsEstadistica->seccion) ?></td>
                <td><?= $logsEstadistica->has('permiso') ? $this->Html->link($logsEstadistica->permiso->id, ['controller' => 'Permisos', 'action' => 'view', $logsEstadistica->permiso->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $logsEstadistica->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $logsEstadistica->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $logsEstadistica->id], ['confirm' => __('Are you sure you want to delete # {0}?', $logsEstadistica->id)]) ?>
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
