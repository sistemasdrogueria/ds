<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaTiposVenta $alfabetaTiposVenta
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Alfabeta Tipos Venta'), ['action' => 'edit', $alfabetaTiposVenta->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Alfabeta Tipos Venta'), ['action' => 'delete', $alfabetaTiposVenta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaTiposVenta->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Alfabeta Tipos Ventas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Alfabeta Tipos Venta'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="alfabetaTiposVentas view large-9 medium-8 columns content">
    <h3><?= h($alfabetaTiposVenta->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($alfabetaTiposVenta->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($alfabetaTiposVenta->id) ?></td>
        </tr>
    </table>
</div>
