<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transporte $transporte
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Transporte'), ['action' => 'edit', $transporte->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Transporte'), ['action' => 'delete', $transporte->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transporte->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Transportes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Transporte'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="transportes view large-9 medium-8 columns content">
    <h3><?= h($transporte->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($transporte->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($transporte->id) ?></td>
        </tr>
    </table>
</div>
