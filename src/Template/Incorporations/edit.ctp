<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Incorporation $incorporation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $incorporation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $incorporation->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Incorporations'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Incorporations Tipos'), ['controller' => 'IncorporationsTipos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Incorporations Tipo'), ['controller' => 'IncorporationsTipos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="incorporations form large-9 medium-8 columns content">
    <?= $this->Form->create($incorporation) ?>
    <fieldset>
        <legend><?= __('Edit Incorporation') ?></legend>
        <?php
            echo $this->Form->control('descripcion');
            echo $this->Form->control('fecha_desde', ['empty' => true]);
            echo $this->Form->control('fecha_hasta', ['empty' => true]);
            echo $this->Form->control('incorporations_tipos_id', ['options' => $incorporationsTipos, 'empty' => true]);
            echo $this->Form->control('imagen');
            echo $this->Form->control('habilitada');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
