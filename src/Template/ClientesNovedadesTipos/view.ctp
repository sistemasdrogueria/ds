<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientesNovedadesTipo $clientesNovedadesTipo
 */
?><nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('EditClientes Novedades Tipo'), ['action' => 'edit',$clientesNovedadesTipo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('DeleteClientes Novedades Tipo'), ['action' => 'delete',$clientesNovedadesTipo->id], ['confirm' => __('Are you sure you want to delete # {0}?',$clientesNovedadesTipo->id)]) ?> </li>
        <li><?= $this->Html->link(__('ListClientes Novedades Tipos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('NewClientes Novedades Tipo'), ['action' => 'add']) ?> </li>    </ul>
</nav>
<div class="clientesNovedadesTipos view large-9 medium-8 columns content">
    <h3><?= h($clientesNovedadesTipo->id) ?></h3>
    <table class="vertical-table">        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($clientesNovedadesTipo->nombre) ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientesNovedadesTipo->id) ?></td>
        </tr>    </table></div>
