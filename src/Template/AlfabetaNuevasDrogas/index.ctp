<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaNuevasDroga[]|\Cake\Collection\CollectionInterface $alfabetaNuevasDrogas
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Nuevas Droga'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaNuevasDrogas index large-9 medium-8 columns content">
    <h3><?= __('Alfabeta Nuevas Drogas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descripcion') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alfabetaNuevasDrogas as $alfabetaNuevasDroga): ?>
            <tr>
                <td><?= $this->Number->format($alfabetaNuevasDroga->id) ?></td>
                <td><?= h($alfabetaNuevasDroga->descripcion) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $alfabetaNuevasDroga->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $alfabetaNuevasDroga->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $alfabetaNuevasDroga->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaNuevasDroga->id)]) ?>
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
