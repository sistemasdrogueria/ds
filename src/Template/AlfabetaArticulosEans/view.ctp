<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaArticulosEan $alfabetaArticulosEan
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Alfabeta Articulos Ean'), ['action' => 'edit', $alfabetaArticulosEan->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Alfabeta Articulos Ean'), ['action' => 'delete', $alfabetaArticulosEan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaArticulosEan->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos Eans'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Articulos Ean'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['controller' => 'AlfabetaArticulos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['controller' => 'AlfabetaArticulos', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="alfabetaArticulosEans view large-9 medium-8 columns content">
    <h3><?= h($alfabetaArticulosEan->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Alfabeta Articulo') ?></th>
            <td><?= $alfabetaArticulosEan->has('alfabeta_articulo') ? $this->Html->link($alfabetaArticulosEan->alfabeta_articulo->id, ['controller' => 'AlfabetaArticulos', 'action' => 'view', $alfabetaArticulosEan->alfabeta_articulo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Codigo Barra') ?></th>
            <td><?= h($alfabetaArticulosEan->codigo_barra) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($alfabetaArticulosEan->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creado') ?></th>
            <td><?= h($alfabetaArticulosEan->creado) ?></td>
        </tr>
    </table>
</div>
