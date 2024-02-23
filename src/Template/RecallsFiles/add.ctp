<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RecallsFile $recallsFile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Recalls Files'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Recalls'), ['controller' => 'Recalls', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Recall'), ['controller' => 'Recalls', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="recallsFiles form large-9 medium-8 columns content">
    <?= $this->Form->create($recallsFile) ?>
    <fieldset>
        <legend><?= __('Add Recalls File') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('recall_id', ['options' => $recalls, 'empty' => true]);
            echo $this->Form->control('tipo');
            echo $this->Form->control('file');
            echo $this->Form->control('path');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
