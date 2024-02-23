<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaTamano[]|\Cake\Collection\CollectionInterface $alfabetaTamanos
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Tamano'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos Extras'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulos Extra'), ['controller' => 'AlfabetaArticulosExtras', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaTamanos index large-9 medium-8 columns content">
    <h3><?= __('Alfabeta Tamanos') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descripcion') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alfabetaTamanos as $alfabetaTamano): ?>
            <tr>
                <td><?= $this->Number->format($alfabetaTamano->id) ?></td>
                <td><?= h($alfabetaTamano->descripcion) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $alfabetaTamano->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $alfabetaTamano->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $alfabetaTamano->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaTamano->id)]) ?>
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
