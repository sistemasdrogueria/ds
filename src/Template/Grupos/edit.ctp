<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grupo $grupo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $grupo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $grupo->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Grupos'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Subcategorias'), ['controller' => 'Subcategorias', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Subcategoria'), ['controller' => 'Subcategorias', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clientes'), ['controller' => 'Clientes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Cliente'), ['controller' => 'Clientes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Subgrupos'), ['controller' => 'Subgrupos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Subgrupo'), ['controller' => 'Subgrupos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ctacte Tipo Pagos'), ['controller' => 'CtacteTipoPagos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ctacte Tipo Pago'), ['controller' => 'CtacteTipoPagos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="grupos form large-9 medium-8 columns content">
    <?= $this->Form->create($grupo) ?>
    <fieldset>
        <legend><?= __('Edit Grupo') ?></legend>
        <?php
            echo $this->Form->control('nombre');
            echo $this->Form->control('descripcion');
            echo $this->Form->control('subcategoria_id', ['options' => $subcategorias, 'empty' => true]);
            echo $this->Form->control('ctacte_tipo_pagos._ids', ['options' => $ctacteTipoPagos]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
