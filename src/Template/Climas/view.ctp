<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Clima $clima
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Clima'), ['action' => 'edit', $clima->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Clima'), ['action' => 'delete', $clima->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clima->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Climas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Clima'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Transportes'), ['controller' => 'Transportes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Transporte'), ['controller' => 'Transportes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Localidads'), ['controller' => 'Localidads', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Localidad'), ['controller' => 'Localidads', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="climas view large-9 medium-8 columns content">
    <h3><?= h($clima->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($clima->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transporte') ?></th>
            <td><?= $clima->has('transporte') ? $this->Html->link($clima->transporte->id, ['controller' => 'Transportes', 'action' => 'view', $clima->transporte->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Localidad') ?></th>
            <td><?= $clima->has('localidad') ? $this->Html->link($clima->localidad->id, ['controller' => 'Localidads', 'action' => 'view', $clima->localidad->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Url') ?></th>
            <td><?= h($clima->url) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clima->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Orden') ?></th>
            <td><?= $this->Number->format($clima->orden) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creado') ?></th>
            <td><?= h($clima->creado) ?></td>
        </tr>
    </table>
</div>
