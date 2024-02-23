<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RecallsFile $recallsFile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Recalls File'), ['action' => 'edit', $recallsFile->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Recalls File'), ['action' => 'delete', $recallsFile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $recallsFile->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Recalls Files'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Recalls File'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Recalls'), ['controller' => 'Recalls', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Recall'), ['controller' => 'Recalls', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="recallsFiles view large-9 medium-8 columns content">
    <h3><?= h($recallsFile->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($recallsFile->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Recall') ?></th>
            <td><?= $recallsFile->has('recall') ? $this->Html->link($recallsFile->recall->id, ['controller' => 'Recalls', 'action' => 'view', $recallsFile->recall->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tipo') ?></th>
            <td><?= h($recallsFile->tipo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('File') ?></th>
            <td><?= h($recallsFile->file) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Path') ?></th>
            <td><?= h($recallsFile->path) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($recallsFile->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $this->Number->format($recallsFile->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($recallsFile->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($recallsFile->modified) ?></td>
        </tr>
    </table>
</div>
