<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientesAlta $clientesAlta
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Clientes Alta'), ['action' => 'edit', $clientesAlta->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Clientes Alta'), ['action' => 'delete', $clientesAlta->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clientesAlta->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Clientes Altas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Clientes Alta'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="clientesAltas view large-9 medium-8 columns content">
    <h3><?= h($clientesAlta->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Razon Social') ?></th>
            <td><?= h($clientesAlta->razon_social) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nombre Fantasia') ?></th>
            <td><?= h($clientesAlta->nombre_fantasia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Codigo Postal') ?></th>
            <td><?= h($clientesAlta->codigo_postal) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Telefono') ?></th>
            <td><?= h($clientesAlta->telefono) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Celular') ?></th>
            <td><?= h($clientesAlta->celular) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($clientesAlta->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Inicio Actividad') ?></th>
            <td><?= h($clientesAlta->inicio_actividad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Farmaceutico Nombre') ?></th>
            <td><?= h($clientesAlta->farmaceutico_nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Farmaceutico Matricula') ?></th>
            <td><?= h($clientesAlta->farmaceutico_matricula) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gln') ?></th>
            <td><?= h($clientesAlta->gln) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cuit') ?></th>
            <td><?= h($clientesAlta->cuit) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientesAlta->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Localidad') ?></th>
            <td><?= $this->Number->format($clientesAlta->localidad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Provincia') ?></th>
            <td><?= $this->Number->format($clientesAlta->provincia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creado') ?></th>
            <td><?= h($clientesAlta->creado) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Domicilio') ?></h4>
        <?= $this->Text->autoParagraph(h($clientesAlta->domicilio)); ?>
    </div>
    <div class="row">
        <h4><?= __('Comentario') ?></h4>
        <?= $this->Text->autoParagraph(h($clientesAlta->comentario)); ?>
    </div>
</div>
