<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaVia $alfabetaVia
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Alfabeta Via'), ['action' => 'edit', $alfabetaVia->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Alfabeta Via'), ['action' => 'delete', $alfabetaVia->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaVia->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Vias'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Via'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="alfabetaVias view large-9 medium-8 columns content">
    <h3><?= h($alfabetaVia->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($alfabetaVia->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($alfabetaVia->id) ?></td>
        </tr>
    </table>
</div>
