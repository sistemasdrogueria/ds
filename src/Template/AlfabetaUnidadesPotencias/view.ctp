<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaUnidadesPotencia $alfabetaUnidadesPotencia
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Alfabeta Unidades Potencia'), ['action' => 'edit', $alfabetaUnidadesPotencia->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Alfabeta Unidades Potencia'), ['action' => 'delete', $alfabetaUnidadesPotencia->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaUnidadesPotencia->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Unidades Potencias'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Unidades Potencia'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="alfabetaUnidadesPotencias view large-9 medium-8 columns content">
    <h3><?= h($alfabetaUnidadesPotencia->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($alfabetaUnidadesPotencia->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($alfabetaUnidadesPotencia->id) ?></td>
        </tr>
    </table>
</div>
