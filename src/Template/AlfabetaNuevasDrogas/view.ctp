<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaNuevasDroga $alfabetaNuevasDroga
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Alfabeta Nuevas Droga'), ['action' => 'edit', $alfabetaNuevasDroga->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Alfabeta Nuevas Droga'), ['action' => 'delete', $alfabetaNuevasDroga->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaNuevasDroga->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Nuevas Drogas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Nuevas Droga'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="alfabetaNuevasDrogas view large-9 medium-8 columns content">
    <h3><?= h($alfabetaNuevasDroga->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($alfabetaNuevasDroga->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($alfabetaNuevasDroga->id) ?></td>
        </tr>
    </table>
</div>
