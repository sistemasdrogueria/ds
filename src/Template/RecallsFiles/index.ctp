<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RecallsFile[]|\Cake\Collection\CollectionInterface $recallsFiles
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Recalls File'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Recalls'), ['controller' => 'Recalls', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Recall'), ['controller' => 'Recalls', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="recallsFiles index large-9 medium-8 columns content">
    <h3><?= __('Recalls Files') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('recall_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('file') ?></th>
                <th scope="col"><?= $this->Paginator->sort('path') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recallsFiles as $recallsFile): ?>
            <tr>
                <td><?= $this->Number->format($recallsFile->id) ?></td>
                <td><?= h($recallsFile->name) ?></td>
                <td><?= $recallsFile->has('recall') ? $this->Html->link($recallsFile->recall->id, ['controller' => 'Recalls', 'action' => 'view', $recallsFile->recall->id]) : '' ?></td>
                <td><?= h($recallsFile->tipo) ?></td>
                <td><?= h($recallsFile->file) ?></td>
                <td><?= h($recallsFile->path) ?></td>
                <td><?= h($recallsFile->created) ?></td>
                <td><?= h($recallsFile->modified) ?></td>
                <td><?= $this->Number->format($recallsFile->status) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $recallsFile->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $recallsFile->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $recallsFile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $recallsFile->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
