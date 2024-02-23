<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaAccionesFar $alfabetaAccionesFar
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Alfabeta Acciones Far'), ['action' => 'edit', $alfabetaAccionesFar->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Alfabeta Acciones Far'), ['action' => 'delete', $alfabetaAccionesFar->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaAccionesFar->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Acciones Fars'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Acciones Far'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="alfabetaAccionesFars view large-9 medium-8 columns content">
    <h3><?= h($alfabetaAccionesFar->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($alfabetaAccionesFar->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($alfabetaAccionesFar->id) ?></td>
        </tr>
    </table>
</div>
