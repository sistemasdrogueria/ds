<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaVia[]|\Cake\Collection\CollectionInterface $alfabetaVias
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Via'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaVias index large-9 medium-8 columns content">
    <h3><?= __('Alfabeta Vias') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descripcion') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alfabetaVias as $alfabetaVia): ?>
            <tr>
                <td><?= $this->Number->format($alfabetaVia->id) ?></td>
                <td><?= h($alfabetaVia->descripcion) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $alfabetaVia->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $alfabetaVia->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $alfabetaVia->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaVia->id)]) ?>
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
