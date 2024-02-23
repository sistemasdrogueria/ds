<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GruposTipo $gruposTipo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Grupos Tipo'), ['action' => 'edit', $gruposTipo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Grupos Tipo'), ['action' => 'delete', $gruposTipo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $gruposTipo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Grupos Tipos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Grupos Tipo'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="gruposTipos view large-9 medium-8 columns content">
    <h3><?= h($gruposTipo->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($gruposTipo->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($gruposTipo->id) ?></td>
        </tr>
    </table>
</div>
