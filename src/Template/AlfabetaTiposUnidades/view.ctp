<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaTiposUnidade $alfabetaTiposUnidade
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Alfabeta Tipos Unidade'), ['action' => 'edit', $alfabetaTiposUnidade->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Alfabeta Tipos Unidade'), ['action' => 'delete', $alfabetaTiposUnidade->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaTiposUnidade->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Tipos Unidades'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Tipos Unidade'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="alfabetaTiposUnidades view large-9 medium-8 columns content">
    <h3><?= h($alfabetaTiposUnidade->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Descripcion') ?></th>
            <td><?= h($alfabetaTiposUnidade->descripcion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($alfabetaTiposUnidade->id) ?></td>
        </tr>
    </table>
</div>
