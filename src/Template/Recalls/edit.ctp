<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Recall $recall
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $recall->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $recall->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Recalls'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Files'), ['controller' => 'Files', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New File'), ['controller' => 'Files', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="recalls form large-9 medium-8 columns content">
    <?= $this->Form->create($recall) ?>
    <fieldset>
        <legend><?= __('Edit Recall') ?></legend>
        <?php
            echo $this->Form->control('fecha', ['empty' => true]);
            echo $this->Form->control('titulo');
            echo $this->Form->control('detalle');
            echo $this->Form->control('creado', ['empty' => true]);
            echo $this->Form->control('files._ids', ['options' => $files]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
