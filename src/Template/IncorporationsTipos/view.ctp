<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\IncorporationsTipo $incorporationsTipo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Incorporations Tipo'), ['action' => 'edit', $incorporationsTipo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Incorporations Tipo'), ['action' => 'delete', $incorporationsTipo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $incorporationsTipo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Incorporations Tipos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Incorporations Tipo'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="incorporationsTipos view large-9 medium-8 columns content">
    <h3><?= h($incorporationsTipo->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($incorporationsTipo->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($incorporationsTipo->id) ?></td>
        </tr>
    </table>
</div>
