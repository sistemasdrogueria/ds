<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Corte $corte
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Corte'), ['action' => 'edit', $corte->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Corte'), ['action' => 'delete', $corte->id], ['confirm' => __('Are you sure you want to delete # {0}?', $corte->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cortes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Corte'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Provincias'), ['controller' => 'Provincias', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Provincia'), ['controller' => 'Provincias', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cortes view large-9 medium-8 columns content">
    <h3><?= h($corte->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Codigo') ?></th>
            <td><?= h($corte->codigo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Provincia') ?></th>
            <td><?= $corte->has('provincia') ? $this->Html->link($corte->provincia->id, ['controller' => 'Provincias', 'action' => 'view', $corte->provincia->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($corte->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dia N') ?></th>
            <td><?= $this->Number->format($corte->dia_n) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dia D') ?></th>
            <td><?= $this->Number->format($corte->dia_d) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Proximo D') ?></th>
            <td><?= $this->Number->format($corte->proximo_d) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Salida N Id') ?></th>
            <td><?= $this->Number->format($corte->salida_n_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Salida D Id') ?></th>
            <td><?= $this->Number->format($corte->salida_d_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Hora N') ?></th>
            <td><?= h($corte->hora_n) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Hora D') ?></th>
            <td><?= h($corte->hora_d) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Proximo H') ?></th>
            <td><?= h($corte->proximo_h) ?></td>
        </tr>
    </table>
</div>
