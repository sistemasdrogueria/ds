<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaTiposUnidade[]|\Cake\Collection\CollectionInterface $alfabetaTiposUnidades
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Tipos Unidade'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaTiposUnidades index large-9 medium-8 columns content">
    <h3><?= __('Alfabeta Tipos Unidades') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descripcion') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alfabetaTiposUnidades as $alfabetaTiposUnidade): ?>
            <tr>
                <td><?= $this->Number->format($alfabetaTiposUnidade->id) ?></td>
                <td><?= h($alfabetaTiposUnidade->descripcion) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $alfabetaTiposUnidade->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $alfabetaTiposUnidade->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $alfabetaTiposUnidade->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaTiposUnidade->id)]) ?>
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
