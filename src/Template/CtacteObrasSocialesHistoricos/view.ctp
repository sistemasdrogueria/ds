<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ctacte Obras Sociales Historico'), ['action' => 'edit', $ctacteObrasSocialesHistorico->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ctacte Obras Sociales Historico'), ['action' => 'delete', $ctacteObrasSocialesHistorico->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ctacteObrasSocialesHistorico->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ctacte Obras Sociales Historicos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ctacte Obras Sociales Historico'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ctacteObrasSocialesHistoricos view large-9 medium-8 columns content">
    <h3><?= h($ctacteObrasSocialesHistorico->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Cliente') ?></th>
            <td><?= $ctacteObrasSocialesHistorico->has('cliente') ? $this->Html->link($ctacteObrasSocialesHistorico->cliente->id, ['controller' => 'Clientes', 'action' => 'view', $ctacteObrasSocialesHistorico->cliente->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($ctacteObrasSocialesHistorico->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Importe') ?></th>
            <td><?= $this->Number->format($ctacteObrasSocialesHistorico->importe) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Obra Social Id') ?></th>
            <td><?= $this->Number->format($ctacteObrasSocialesHistorico->obra_social_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Nro Nota') ?></th>
            <td><?= $this->Number->format($ctacteObrasSocialesHistorico->nro_nota) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo Nota') ?></th>
            <td><?= $this->Number->format($ctacteObrasSocialesHistorico->tipo_nota) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($ctacteObrasSocialesHistorico->fecha) ?></td>
        </tr>
    </table>
</div>
