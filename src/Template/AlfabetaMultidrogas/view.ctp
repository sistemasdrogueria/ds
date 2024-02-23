<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaMultidroga $alfabetaMultidroga
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Alfabeta Multidroga'), ['action' => 'edit', $alfabetaMultidroga->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Alfabeta Multidroga'), ['action' => 'delete', $alfabetaMultidroga->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaMultidroga->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Multidrogas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Multidroga'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['controller' => 'AlfabetaArticulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['controller' => 'AlfabetaArticulos', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="alfabetaMultidrogas view large-9 medium-8 columns content">
    <h3><?= h($alfabetaMultidroga->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Alfabeta Articulo') ?></th>
            <td><?= $alfabetaMultidroga->has('alfabeta_articulo') ? $this->Html->link($alfabetaMultidroga->alfabeta_articulo->id, ['controller' => 'AlfabetaArticulos', 'action' => 'view', $alfabetaMultidroga->alfabeta_articulo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Articulo') ?></th>
            <td><?= $alfabetaMultidroga->has('articulo') ? $this->Html->link($alfabetaMultidroga->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $alfabetaMultidroga->articulo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Potencia') ?></th>
            <td><?= h($alfabetaMultidroga->potencia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($alfabetaMultidroga->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alfabeta Nueva Droga Id') ?></th>
            <td><?= $this->Number->format($alfabetaMultidroga->alfabeta_nueva_droga_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Alfabeta Unidad Potencia Id') ?></th>
            <td><?= $this->Number->format($alfabetaMultidroga->alfabeta_unidad_potencia_id) ?></td>
        </tr>
    </table>
</div>
