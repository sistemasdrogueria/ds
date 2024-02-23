<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Catalogo $catalogo
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Catalogo'), ['action' => 'edit', $catalogo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Catalogo'), ['action' => 'delete', $catalogo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $catalogo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Catalogos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Catalogo'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="catalogos view large-9 medium-8 columns content">
    <h3><?= h($catalogo->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($catalogo->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($catalogo->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Paginas') ?></th>
            <td><?= $this->Number->format($catalogo->paginas) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo Catalogo') ?></th>
            <td><?= $this->Number->format($catalogo->tipo_catalogo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Desde') ?></th>
            <td><?= h($catalogo->desde) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Hasta') ?></th>
            <td><?= h($catalogo->hasta) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creado') ?></th>
            <td><?= h($catalogo->creado) ?></td>
        </tr>
    </table>
</div>
