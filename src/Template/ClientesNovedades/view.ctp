<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientesNovedade $clientesNovedade
 */
?><nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('EditClientes Novedade'), ['action' => 'edit',$clientesNovedade->id]) ?> </li>
        <li><?= $this->Form->postLink(__('DeleteClientes Novedade'), ['action' => 'delete',$clientesNovedade->id], ['confirm' => __('Are you sure you want to delete # {0}?',$clientesNovedade->id)]) ?> </li>
        <li><?= $this->Html->link(__('ListClientes Novedades'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('NewClientes Novedade'), ['action' => 'add']) ?> </li>        <li><?= $this->Html->link(__('ListClientes Novedades Tipos'), ['controller' => 'ClientesNovedadesTipos', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('NewClientes Novedades Tipo'), ['controller' => 'ClientesNovedadesTipos', 'action' => 'add']) ?> </li>    </ul>
</nav>
<div class="clientesNovedades view large-9 medium-8 columns content">
    <h3><?= h($clientesNovedade->id) ?></h3>
    <table class="vertical-table">        <tr>
            <th scope="row"><?= __('Titulo') ?></th>
            <td><?= h($clientesNovedade->titulo) ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Clientes Novedades Tipo') ?></th>
            <td><?= $clientesNovedade->has('clientes_novedades_tipo') ? $this->Html->link($clientesNovedade->clientes_novedades_tipo->id, ['controller' => 'ClientesNovedadesTipos', 'action' => 'view', $clientesNovedade->clientes_novedades_tipo->id]) : '' ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Img File') ?></th>
            <td><?= h($clientesNovedade->img_file) ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($clientesNovedade->id) ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($clientesNovedade->fecha) ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Creado') ?></th>
            <td><?= h($clientesNovedade->creado) ?></td>
        </tr>        <tr>
            <th scope="row"><?= __('Activo') ?></th>
            <td><?= $clientesNovedade->activo ? __('Yes') : __('No'); ?></td>
        </tr>    </table>    <div class="row">
        <h4><?= __('Descripcion') ?></h4>
        <?= $this->Text->autoParagraph(h($clientesNovedade->descripcion)); ?>
    </div></div>
