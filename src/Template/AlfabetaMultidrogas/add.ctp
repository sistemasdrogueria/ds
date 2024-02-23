<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaMultidroga $alfabetaMultidroga
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Multidrogas'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['controller' => 'AlfabetaArticulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['controller' => 'AlfabetaArticulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaMultidrogas form large-9 medium-8 columns content">
    <?= $this->Form->create($alfabetaMultidroga) ?>
    <fieldset>
        <legend><?= __('Add Alfabeta Multidroga') ?></legend>
        <?php
            echo $this->Form->control('alfabeta_articulo_id', ['options' => $alfabetaArticulos, 'empty' => true]);
            echo $this->Form->control('articulo_id', ['options' => $articulos, 'empty' => true]);
            echo $this->Form->control('alfabeta_nueva_droga_id');
            echo $this->Form->control('potencia');
            echo $this->Form->control('alfabeta_unidad_potencia_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
