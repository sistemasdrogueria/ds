<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaArticulosEan[]|\Cake\Collection\CollectionInterface $alfabetaArticulosEans
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulos Ean'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['controller' => 'AlfabetaArticulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['controller' => 'AlfabetaArticulos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaArticulosEans index large-9 medium-8 columns content">
    <h3><?= __('Alfabeta Articulos Eans') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_articulo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('codigo_barra') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creado') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alfabetaArticulosEans as $alfabetaArticulosEan): ?>
            <tr>
                <td><?= $this->Number->format($alfabetaArticulosEan->id) ?></td>
                <td><?= $alfabetaArticulosEan->has('alfabeta_articulo') ? $this->Html->link($alfabetaArticulosEan->alfabeta_articulo->id, ['controller' => 'AlfabetaArticulos', 'action' => 'view', $alfabetaArticulosEan->alfabeta_articulo->id]) : '' ?></td>
                <td><?= h($alfabetaArticulosEan->codigo_barra) ?></td>
                <td><?= h($alfabetaArticulosEan->creado) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $alfabetaArticulosEan->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $alfabetaArticulosEan->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $alfabetaArticulosEan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaArticulosEan->id)]) ?>
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
