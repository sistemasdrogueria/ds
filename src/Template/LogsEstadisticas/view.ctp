<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LogsEstadistica $logsEstadistica
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Logs Estadistica'), ['action' => 'edit', $logsEstadistica->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Logs Estadistica'), ['action' => 'delete', $logsEstadistica->id], ['confirm' => __('Are you sure you want to delete # {0}?', $logsEstadistica->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Logs Estadisticas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Logs Estadistica'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Permisos'), ['controller' => 'Permisos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Permiso'), ['controller' => 'Permisos', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="logsEstadisticas view large-9 medium-8 columns content">
    <h3><?= h($logsEstadistica->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Cliente') ?></th>
            <td><?= $logsEstadistica->has('cliente') ? $this->Html->link($logsEstadistica->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $logsEstadistica->cliente->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $logsEstadistica->has('user') ? $this->Html->link($logsEstadistica->user->id, ['controller' => 'Users', 'action' => 'view', $logsEstadistica->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ip') ?></th>
            <td><?= h($logsEstadistica->ip) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Seccion') ?></th>
            <td><?= h($logsEstadistica->seccion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Permiso') ?></th>
            <td><?= $logsEstadistica->has('permiso') ? $this->Html->link($logsEstadistica->permiso->id, ['controller' => 'Permisos', 'action' => 'view', $logsEstadistica->permiso->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($logsEstadistica->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($logsEstadistica->fecha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Super') ?></th>
            <td><?= $logsEstadistica->super ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
