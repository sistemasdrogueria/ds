<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Impresora $impresora
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Impresora'), ['action' => 'edit', $impresora->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Impresora'), ['action' => 'delete', $impresora->id], ['confirm' => __('Are you sure you want to delete # {0}?', $impresora->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Impresoras'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Impresora'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="impresoras view large-9 medium-8 columns content">
    <h3><?= h($impresora->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Modelo') ?></th>
            <td><?= h($impresora->modelo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Marca') ?></th>
            <td><?= h($impresora->marca) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sector') ?></th>
            <td><?= h($impresora->sector) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ip') ?></th>
            <td><?= h($impresora->ip) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($impresora->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sistema') ?></th>
            <td><?= $this->Number->format($impresora->sistema) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creado') ?></th>
            <td><?= h($impresora->creado) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modificado') ?></th>
            <td><?= h($impresora->modificado) ?></td>
        </tr>
    </table>
</div>
