<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AlfabetaMultidroga[]|\Cake\Collection\CollectionInterface $alfabetaMultidrogas
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Multidroga'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Alfabeta Articulos'), ['controller' => 'AlfabetaArticulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Alfabeta Articulo'), ['controller' => 'AlfabetaArticulos', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articulos'), ['controller' => 'Articulos', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Articulo'), ['controller' => 'Articulos', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="alfabetaMultidrogas index large-9 medium-8 columns content">
    <h3><?= __('Alfabeta Multidrogas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_articulo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('articulo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_nueva_droga_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('potencia') ?></th>
                <th scope="col"><?= $this->Paginator->sort('alfabeta_unidad_potencia_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($alfabetaMultidrogas as $alfabetaMultidroga): ?>
            <tr>
                <td><?= $this->Number->format($alfabetaMultidroga->id) ?></td>
                <td><?= $alfabetaMultidroga->has('alfabeta_articulo') ? $this->Html->link($alfabetaMultidroga->alfabeta_articulo->id, ['controller' => 'AlfabetaArticulos', 'action' => 'view', $alfabetaMultidroga->alfabeta_articulo->id]) : '' ?></td>
                <td><?= $alfabetaMultidroga->has('articulo') ? $this->Html->link($alfabetaMultidroga->articulo->id, ['controller' => 'Articulos', 'action' => 'view', $alfabetaMultidroga->articulo->id]) : '' ?></td>
                <td><?= $this->Number->format($alfabetaMultidroga->alfabeta_nueva_droga_id) ?></td>
                <td><?= h($alfabetaMultidroga->potencia) ?></td>
                <td><?= $this->Number->format($alfabetaMultidroga->alfabeta_unidad_potencia_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $alfabetaMultidroga->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $alfabetaMultidroga->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $alfabetaMultidroga->id], ['confirm' => __('Are you sure you want to delete # {0}?', $alfabetaMultidroga->id)]) ?>
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
