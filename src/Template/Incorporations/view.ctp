<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Incorporation $incorporation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Incorporation'), ['action' => 'edit', $incorporation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Incorporation'), ['action' => 'delete', $incorporation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $incorporation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Incorporations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Incorporation'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Incorporations Tipos'), ['controller' => 'IncorporationsTipos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Incorporations Tipo'), ['controller' => 'IncorporationsTipos', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="incorporations view large-9 medium-8 columns content">
    <h3><?= h($incorporation->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Incorporations Tipo') ?></th>
            <td><?= $incorporation->has('incorporations_tipo') ? $this->Html->link($incorporation->incorporations_tipo->id, ['controller' => 'IncorporationsTipos', 'action' => 'view', $incorporation->incorporations_tipo->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Imagen') ?></th>
            <td><?= h($incorporation->imagen) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($incorporation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Habilitada') ?></th>
            <td><?= $this->Number->format($incorporation->habilitada) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha Desde') ?></th>
            <td><?= h($incorporation->fecha_desde) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha Hasta') ?></th>
            <td><?= h($incorporation->fecha_hasta) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Descripcion') ?></h4>
        <?= $this->Text->autoParagraph(h($incorporation->descripcion)); ?>
    </div>
</div>
