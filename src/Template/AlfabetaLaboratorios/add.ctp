<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaLaboratorio $alfabetaLaboratorio
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Laboratorios'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['controller' => 'AlfabetaArticulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['controller' => 'AlfabetaArticulos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaLaboratorios form large-9 medium-8 columns content">
    <?= $this->Form->create($alfabetaLaboratorio) ?>
    <fieldset>
        <legend><?= __('Add Alfabeta Laboratorio') ?></legend>
        <?php
            echo $this->Form->control('nombre');
            echo $this->Form->control('codigo');
            echo $this->Form->control('eliminado');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
